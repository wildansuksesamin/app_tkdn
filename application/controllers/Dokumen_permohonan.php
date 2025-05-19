
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dokumen_permohonan extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
        $this->load->model("rab_model", "rab");
        $this->load->model("surat_penawaran_model", "surat_penawaran");
        $this->load->model("surat_oc_model", "surat_oc");
        $this->load->model("form_01_model", "form_01");
        $this->load->model("payment_detail_model", "payment_detail");
        $this->load->model('proforma_invoice_model', 'proforma_invoice');
    }

    public function riwayat_pembayaran()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);
                $field_sort = (isset($data_receive->field_sort) ? $data_receive->field_sort : null);
                $field_order = (isset($data_receive->field_order) ? $data_receive->field_order : null);

                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $where_sub = "dokumen_permohonan.active = 1
                        AND pelanggan.active = 1
                        AND rab.active = 1 
                        AND `surat_penawaran`.`active` = 1 
                        AND `surat_oc`.`active` = 1 
                        AND `form_01`.`active` = 1 
                        AND `payment_detail`.`active` = 1 
                        and (status_pengajuan >= 25 and status_pengajuan != 99) and tipe_pengajuan != 'PEMERINTAH'
                        AND termin_1 > 0
                        AND (concat(tipe_badan_usaha.nama_badan_usaha,' ',pelanggan.nama_perusahaan) like '%" . $filter . "%' or tipe_permohonan.nama_tipe_permohonan like '%" . $filter . "%' or `nomor_oc` LIKE '%" . $filter . "%' OR `nomor_invoice` LIKE '%" . $filter . "%' OR `nomor_faktur_pajak` LIKE '%" . $filter . "%')";

                $join_sub[0] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
                $join_sub[1] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join_sub[2] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                $join_sub[3] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join_sub[4] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');
                $join_sub[5] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
                $join_sub[6] = array('tabel' => 'form_01', 'relation' => 'form_01.id_surat_oc = surat_oc.id_surat_oc', 'direction' => 'left');
                $join_sub[7] = array('tabel' => 'payment_detail', 'relation' => 'payment_detail.id_form_01 = form_01.id_form_01', 'direction' => 'left');
                $order_sub = $field_sort . ' ' . $field_order;
                $data_send_sub = array('where' => $where_sub, 'join' => $join_sub, 'order' => $order_sub, 'limit' => $limit);
                $load_data_sub = $this->dokumen_permohonan->load_data($data_send_sub);
                if ($load_data_sub->num_rows() > 0) {
                    foreach ($load_data_sub->result() as $key) {
                        $key->assesor = $this->siapaAssesor($key->id_dokumen_permohonan);
                    }
                }
                $result = $load_data_sub->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where_sub, 'join' => $join_sub, 'select' => $select);
                $load_data = $this->dokumen_permohonan->load_data($send_data);
                $total_data = $load_data->row()->jml;

                $last_page = ceil($total_data / $jml_data);
                $result = array('result' => $result, 'last_page' => $last_page);

                echo json_encode($result);
            }
        }
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);

                $relation[0] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $relation[1] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
                $relation[2] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');

                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $where = "dokumen_permohonan.active = 1  and pelanggan.active = 1  and tipe_permohonan.active = 1  and (concat(tipe_badan_usaha.nama_badan_usaha,' ',pelanggan.nama_perusahaan) like '%" . $filter . "%' or tipe_permohonan.nama_tipe_permohonan like '%" . $filter . "%')";

                $order = "id_dokumen_permohonan DESC";

                if (isset($data_receive->from)) {
                    if ($data_receive->from == 'penugasan_pic') {
                        $where .= " and status_pengajuan != 99";
                        $order = " status_pengajuan, id_dokumen_permohonan ASC";
                    }
                    if ($data_receive->from == 'verifikasi_dokumen') {
                        $where .= " and status_pengajuan IN (2,3) and id_dokumen_permohonan IN (select id_dokumen_permohonan from dokumen_permohonan_pic pic where pic.active = 1 and pic.id_admin = '" . $this->session->userdata('id_admin') . "')";
                    } else if ($data_receive->from == 'buat_rab') {
                        $where .= " and status_pengajuan = 4 and id_dokumen_permohonan IN (select id_dokumen_permohonan from dokumen_permohonan_pic pic where pic.active = 1 and pic.id_admin = '" . $this->session->userdata('id_admin') . "')";
                    }
                } else {
                    #cek apakah verifikator atau bukan...
                    if ($this->is_assesor()) {
                        $where .= " and id_dokumen_permohonan IN (select id_dokumen_permohonan from dokumen_permohonan_pic pic where pic.active = 1 and pic.id_admin = '" . $this->session->userdata('id_admin') . "') ";
                    }
                }

                if (isset($data_receive->status_pengajuan))
                    $where .= " and status_pengajuan= '" . $data_receive->status_pengajuan . "'";

                $send_data = array('where' => $where, 'join' => $relation, 'limit' => $limit, 'order' => $order);
                $load_data = $this->dokumen_permohonan->load_data($send_data);
                $result = $load_data->result();
                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $row) {
                        $row->assesor = $this->siapaAssesor($row->id_dokumen_permohonan);

                        #cek apakah sudah ada rab...
                        $row->rab = null;
                        $where_rab = array('active' => 1, 'id_dokumen_permohonan' => $row->id_dokumen_permohonan);
                        $data_send_rab = array('where' => $where_rab);
                        $load_data_rab = $this->rab->load_data($data_send_rab);
                        if ($load_data_rab->num_rows() > 0) {
                            $row->id_rab = $load_data_rab->row()->id_rab;
                            $row->rab = $load_data_rab->row();

                            #cek apakah sudah ada penawaran...
                            $row->surat_penawaran = null;
                            $where_penawaran = array('active' => 1, 'id_rab' => $row->id_rab);
                            $data_send_penawaran = array('where' => $where_penawaran);
                            $load_data_penawaran = $this->surat_penawaran->load_data($data_send_penawaran);
                            if ($load_data_penawaran->num_rows() > 0) {
                                $row->surat_penawaran = $load_data_penawaran->row();

                                #apakah sudah ada OC...
                                $row->surat_oc = null;
                                $where_oc = array('active IN (1,2)' => NULL, 'id_surat_penawaran' => $row->surat_penawaran->id_surat_penawaran);
                                $data_send_oc = array('where' => $where_oc);
                                $load_data_oc = $this->surat_oc->load_data($data_send_oc);
                                if ($load_data_oc->num_rows() > 0) {
                                    $row->surat_oc = $load_data_oc->row();

                                    #cek apakah ada proforma invoice...
                                    $row->proforma_invoice = null;
                                    $where_proforma_invoice = array('active' => 1, 'id_surat_oc' => $row->surat_oc->id_surat_oc);
                                    $data_send_proforma_invoice = array('where' => $where_proforma_invoice);
                                    $load_data_proforma_invoice = $this->proforma_invoice->load_data($data_send_proforma_invoice);
                                    if ($load_data_proforma_invoice->num_rows() > 0) {
                                        $row->proforma_invoice = $load_data_proforma_invoice->row();
                                    }

                                    #cek apakah sudah ada Form 01...
                                    $row->form_01 = null;
                                    $where_form_01 = array('active' => 1, 'id_surat_oc' => $row->surat_oc->id_surat_oc);
                                    $data_send_form_01 = array('where' => $where_form_01);
                                    $load_data_form_01 = $this->form_01->load_data($data_send_form_01);
                                    if ($load_data_form_01->num_rows() > 0) {
                                        $row->form_01 = $load_data_form_01->row();

                                        #cek apakah sudah ada payment detail...
                                        $row->payment_detail = null;
                                        $where_payment_detail = array('active' => 1, 'id_form_01' => $row->form_01->id_form_01);
                                        $data_send_payment_detail = array('where' => $where_payment_detail);
                                        $load_data_payment_detail = $this->payment_detail->load_data($data_send_payment_detail);
                                        if ($load_data_payment_detail->num_rows() > 0) {
                                            $row->payment_detail = $load_data_payment_detail->row();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'join' => $relation, 'select' => $select);
                $load_data = $this->dokumen_permohonan->load_data($send_data);
                $total_data = $load_data->row()->jml;

                $last_page = ceil($total_data / $jml_data);
                $result = array('result' => $result, 'last_page' => $last_page);

                echo json_encode($result);
            }
        }
    }

    public function verifikasi_dokumen()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_dokumen_permohonan = $data_receive->id_dokumen_permohonan;
            $status_pengajuan = ($data_receive->status_pengajuan == 'setuju' ? 4 : 3);
            $alasan_verifikasi = (isset($data_receive->alasan_verifikasi) ? $data_receive->alasan_verifikasi : '');

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $data = array('status_pengajuan' => $status_pengajuan, 'alasan_verifikasi' => $alasan_verifikasi);
                $where = array('id_dokumen_permohonan' => $id_dokumen_permohonan);
                $exe = $this->dokumen_permohonan->update($data, $where);
                $return['sts'] = $exe;

                if ($exe) {
                    $this->simpan_log_verifikasi($id_dokumen_permohonan, $status_pengajuan, $alasan_verifikasi);
                }
            }

            echo json_encode($return);
        }
    }
    public function batalkan_permohonan()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_dokumen_permohonan = htmlentities($data_receive->id_dokumen_permohonan ?? '');
            $alasan_verifikasi = htmlentities($data_receive->alasan_verifikasi ?? '');
            $from = htmlentities($data_receive->from ?? '');
            $id_jns_admin = $this->session->userdata('id_jns_admin');

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $allow = false;

                if ($from == 'dokumen_permohonan') {
                    if ($id_jns_admin == 2) {
                        #jika dari dokumen_permohonan, hanya boleh koordinator saja yang membatalkan...
                        $allow = true;
                    }
                } else if ($from == 'penugasan_pic') {
                    if ($this->validasi_controller('page/' . $from)) {
                        $allow = true;
                    }
                }

                if ($allow) {
                    $return['sts'] = $this->simpan_log_verifikasi($id_dokumen_permohonan, 99, $alasan_verifikasi);
                } else {
                    $return['sts'] = 'tidak_berhak_ubah_data';
                }
            } else {
                $return['sts'] = 'tidak_berhak_ubah_data';
            }

            echo json_encode($return);
        }
    }
}
