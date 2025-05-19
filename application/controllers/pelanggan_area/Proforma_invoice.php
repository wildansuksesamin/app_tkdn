
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proforma_invoice extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('proforma_invoice_model', 'proforma_invoice');
        $this->load->model('dokumen_permohonan_model', 'dokumen_permohonan');
	}

    public function request_proforma_invoice(){
        if($this->validasi_login_pelanggan()){
            $return = array();
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
                $id_dokumen_permohonan = htmlentities($data_receive->id_dokumen_permohonan ?? '');

                #cek apakah permohonan ini layak untuk mengajukan request proforma invoice...
                $where = array('active' => 1, 'id_dokumen_permohonan' => $id_dokumen_permohonan, 'status_pengajuan' => 22);
                $cek = $this->dokumen_permohonan->is_available($where);
                if($cek){
                    $exe = $this->simpan_log_verifikasi($id_dokumen_permohonan, 17);
                    $return['sts'] = $exe;
                }
                else{
                    $return['sts'] = 'tidak_berhak_ubah_data';
                }

            }
            echo json_encode($return);
        }
    }
}
