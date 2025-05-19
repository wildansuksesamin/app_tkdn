<?php if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Surat_penawaran_rilis extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Surat_penawaran_model", "surat_penawaran");
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);
                $relation[0] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $relation[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $relation[2] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $relation[3] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');

                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $order = "id_surat_penawaran DESC";
                $where = "surat_penawaran.active = 1  and rab.active = 1  and (concat(nama_badan_usaha, ' ', nama_perusahaan) like '%" . $filter . "%' or nomor_surat_penawaran like '%" . $filter . "%' or nomor_surat_permohonan like '%" . $filter . "%' or permohonan_verifikasi like '%" . $filter . "%' or rincian_produk_pekerjaan like '%" . $filter . "%')";

                #cek apakah Verifikator atau bukan...
                if (isset($data_receive->from)) {
                    $from = htmlentities($data_receive->from ?? '');

                    if ($from == 'collecting_dokumen') {
                        $where .= " and masa_collecting_dokumen = 0 and dokumen_permohonan.status_pengajuan = 12 and dokumen_permohonan.id_dokumen_permohonan IN (select id_dokumen_permohonan from dokumen_permohonan_pic pic where pic.active = 1 and pic.id_admin = '" . $this->session->userdata('id_admin') . "') ";
                    } else if ($from == 'buat_oc') {
                        $where .= " and masa_collecting_dokumen > 0 and dokumen_permohonan.status_pengajuan IN (13, 14)";
                    } else if ($from == 'buat_proforma_invoice') {
                        $where .= " and masa_collecting_dokumen > 0 and dokumen_permohonan.status_pengajuan IN (17, 18)";
                    } else if ($from == 'verifikasi_oc_koordinator') {
                        $where .= " and masa_collecting_dokumen > 0  and dokumen_permohonan.status_pengajuan = 15 and rab.id_koordinator = '" . $this->session->userdata('id_admin') . "'";
                    } else if ($from == 'verifikasi_oc_kabid') {
                        $where .= " and masa_collecting_dokumen > 0  and dokumen_permohonan.status_pengajuan = 16 and surat_penawaran.id_kabid = '" . $this->session->userdata('id_admin') . "'";
                    } else if ($from == 'bypass_bukti_bayar') {
                        $where .= " and masa_collecting_dokumen > 0  and dokumen_permohonan.status_pengajuan IN (21,22)";
                    }
                } else {
                    $where .= " and dokumen_permohonan.status_pengajuan != 99";
                    if ($this->is_assesor()) {
                        $where .= " and dokumen_permohonan.id_dokumen_permohonan IN (select id_dokumen_permohonan from dokumen_permohonan_pic pic where pic.active = 1 and pic.id_admin = '" . $this->session->userdata('id_admin') . "') ";
                    }
                }

                $send_data = array('where' => $where, 'join' => $relation, 'limit' => $limit, 'order' => $order);
                $load_data = $this->surat_penawaran->load_data($send_data);
                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $list) {
                        $list->assesor = $this->siapaAssesor($list->id_dokumen_permohonan);
                    }
                }
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'join' => $relation, 'select' => $select);
                $load_data = $this->surat_penawaran->load_data($send_data);
                $total_data = $load_data->row()->jml;

                $last_page = ceil($total_data / $jml_data);
                $result = array('result' => $result, 'last_page' => $last_page);

                echo json_encode($result);
            }
        }
    }
    public function input_masa_collecting_dokumen()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_surat_penawaran = htmlentities($this->input->post('id_surat_penawaran') ?? '');
                $masa_collecting_dokumen = str_replace('.', '', htmlentities($this->input->post('masa_collecting_dokumen') ?? ''));
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $data = array(
                    'masa_collecting_dokumen' => $masa_collecting_dokumen,
                    'time_update' => $time_update,
                    'user_update' => $user_update
                );
                $where = array('id_surat_penawaran' => $id_surat_penawaran);
                $exe = $this->surat_penawaran->update($data, $where);
                if ($exe) {
                    $this->load->model("surat_penawaran_model", "surat_penawaran");
                    $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                    $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                    $where = array('surat_penawaran.active' => 1, 'id_surat_penawaran' => $id_surat_penawaran);
                    $data_send = array('where' => $where, 'join' => $join);
                    $load_data = $this->surat_penawaran->load_data($data_send);
                    if ($load_data->num_rows() > 0) {
                        $surat_penawaran = $load_data->row();
                        if ($surat_penawaran->tipe_pengajuan == 'PEMERINTAH') {
                            #buatkan default surat oc...
                            $this->load->model('surat_oc_model', 'surat_oc');
                            $data_oc = array(
                                'id_surat_penawaran' => $id_surat_penawaran,
                                'nomor_oc' => 'TANPA NOMOR OC',
                                'tgl_oc' => date('Y-m-d'),
                                'batas_waktu_pembayaran' => 1,
                                'bukti_bayar' => 'TANPA BUKTI BAYAR',
                                'surat_oc_pelanggan' => 'TANPA OC PELANGGAN',
                                'active' => 2,
                                'user_create' => $user_update,
                                'time_create' => $time_update,
                                'user_update' => $user_update,
                                'time_update' => $time_update
                            );
                            $this->surat_oc->save($data_oc);
                            $this->simpan_log_verifikasi($surat_penawaran->id_dokumen_permohonan, 25);
                        } else {
                            $this->simpan_log_verifikasi($surat_penawaran->id_dokumen_permohonan, 13);
                        }
                    }
                }
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
