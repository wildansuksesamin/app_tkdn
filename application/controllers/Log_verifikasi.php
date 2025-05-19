
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_verifikasi extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model("Log_verifikasi_model","log_verifikasi");
	}

    public function load_data(){
        if($this->validasi_login()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if($this->tokenStatus($token, 'LOAD_DATA')){
                $id_dokumen_permohonan = htmlentities($data_receive->id_dokumen_permohonan ?? '');

                $order = "id_log_verifikasi DESC";
                $select = "*, log_verifikasi.alasan_verifikasi log_alasan";
                $relation[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = log_verifikasi.id_dokumen_permohonan', 'direction' => 'left');
                $relation[1] = array('tabel' => 'mst_admin', 'relation' => 'mst_admin.id_admin = log_verifikasi.id_verifikator', 'direction' => 'left');

                $where = array('log_verifikasi.active' => 1 , 'dokumen_permohonan.active' => 1, 'log_verifikasi.id_dokumen_permohonan' => $id_dokumen_permohonan); #show active data...

                $send_data = array('select' => $select, 'where' => $where, 'join' => $relation, 'order' => $order);
                $load_data = $this->log_verifikasi->load_data($send_data);
                $result = $load_data->result();


                echo json_encode($result);
            }
        }

    }


}
