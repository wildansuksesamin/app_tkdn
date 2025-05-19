<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hak_akses_permohonan_pemerintah extends MY_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("Menu_model",'menu');
    }

    
    public function simpan(){
        if($this->validasi_login()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $status = $data_receive->status;
            
            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){

                $where = array('id_menu' => '101.2');
                if($status == 'aktif'){
                    $data = array('nama_menu' => 'Berbayar Pemerintah');
                }
                else{
                    $data = array('nama_menu' => '[OFF]Berbayar Pemerintah');
                }
                $exe = $this->menu->update($data, $where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
