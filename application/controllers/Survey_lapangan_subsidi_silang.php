
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Survey_lapangan_subsidi_silang extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Survey_lapangan_subsidi_silang_model", "survey_lapangan_subsidi_silang");
    }


    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_rab = htmlentities($data_receive->id_rab ?? '');

                $select = "*, 
                surat_oc_sumber.nomor_oc nomor_oc_sumber, 
                tipe_badan_usaha_sumber.nama_badan_usaha nama_badan_usaha_sumber, 
                pelanggan_sumber.nama_perusahaan nama_perusahaan_sumber,

                surat_oc_tujuan.nomor_oc nomor_oc_tujuan, 
                tipe_badan_usaha_tujuan.nama_badan_usaha nama_badan_usaha_tujuan, 
                pelanggan_tujuan.nama_perusahaan nama_perusahaan_tujuan";

                $join[0] = array('tabel' => 'rab rab_sumber', 'relation' => 'rab_sumber.id_rab = survey_lapangan_subsidi_silang.id_rab_sumber', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_penawaran surat_penawaran_sumber', 'relation' => 'surat_penawaran_sumber.id_rab = rab_sumber.id_rab', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_oc surat_oc_sumber', 'relation' => 'surat_oc_sumber.id_surat_oc = surat_penawaran_sumber.id_surat_penawaran', 'direction' => 'left');
                $join[3] = array('tabel' => 'dokumen_permohonan dokumen_permohonan_sumber', 'relation' => 'dokumen_permohonan_sumber.id_dokumen_permohonan = rab_sumber.id_dokumen_permohonan', 'direction' => 'left');
                $join[4] = array('tabel' => 'pelanggan pelanggan_sumber', 'relation' => 'pelanggan_sumber.id_pelanggan = dokumen_permohonan_sumber.id_pelanggan', 'direction' => 'left');
                $join[5] = array('tabel' => 'tipe_badan_usaha tipe_badan_usaha_sumber', 'relation' => 'tipe_badan_usaha_sumber.id_tipe_badan_usaha = pelanggan_sumber.id_tipe_badan_usaha', 'direction' => 'left');

                $join[6] = array('tabel' => 'rab rab_tujuan', 'relation' => 'rab_tujuan.id_rab = survey_lapangan_subsidi_silang.id_rab_tujuan', 'direction' => 'left');
                $join[7] = array('tabel' => 'surat_penawaran surat_penawaran_tujuan', 'relation' => 'surat_penawaran_tujuan.id_rab = rab_tujuan.id_rab', 'direction' => 'left');
                $join[8] = array('tabel' => 'surat_oc surat_oc_tujuan', 'relation' => 'surat_oc_tujuan.id_surat_oc = surat_penawaran_tujuan.id_surat_penawaran', 'direction' => 'left');
                $join[9] = array('tabel' => 'dokumen_permohonan dokumen_permohonan_tujuan', 'relation' => 'dokumen_permohonan_tujuan.id_dokumen_permohonan = rab_tujuan.id_dokumen_permohonan', 'direction' => 'left');
                $join[10] = array('tabel' => 'pelanggan pelanggan_tujuan', 'relation' => 'pelanggan_tujuan.id_pelanggan = dokumen_permohonan_tujuan.id_pelanggan', 'direction' => 'left');
                $join[11] = array('tabel' => 'tipe_badan_usaha tipe_badan_usaha_tujuan', 'relation' => 'tipe_badan_usaha_tujuan.id_tipe_badan_usaha = pelanggan_tujuan.id_tipe_badan_usaha', 'direction' => 'left');


                $where = "survey_lapangan_subsidi_silang.active = 1 and (id_rab_sumber = '" . $id_rab . "' or id_rab_tujuan = '" . $id_rab . "')";
                $send_data = array('select' => $select, 'where' => $where, 'join' => $join);
                $load_data = $this->survey_lapangan_subsidi_silang->load_data($send_data);
                $result = $load_data->result();

                echo json_encode($result);
            }
        }
    }

    public function simpan()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_rab_sumber = htmlentities($this->input->post('id_rab_sumber') ?? '');
                $id_rab_tujuan = htmlentities($this->input->post('id_rab_tujuan') ?? '');
                $nominal_subsidi = htmlentities($this->input->post('pengambilan_dana') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $nominal_subsidi = str_replace('.', '', $nominal_subsidi);
                $nominal_subsidi = str_replace(',', '.', $nominal_subsidi);
                $nominal_subsidi = number_format($nominal_subsidi, 2, '.', '');

                $data = array(
                    'id_rab_sumber' => $id_rab_sumber,
                    'id_rab_tujuan' => $id_rab_tujuan,
                    'nominal_subsidi' => $nominal_subsidi,
                    'user_create' => $user_create,
                    'time_create' => $time_create,
                    'time_update' => $time_update,
                    'user_update' => $user_update
                );
                $exe = $this->survey_lapangan_subsidi_silang->save($data);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
    public function hapus()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_subsidi_silang = $data_receive->id_subsidi_silang;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $where = array('id_subsidi_silang' => $id_subsidi_silang);
                $exe = $this->survey_lapangan_subsidi_silang->soft_delete($where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
