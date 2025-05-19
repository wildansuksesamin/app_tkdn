<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gateway extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model("Mst_admin_model",'admin');
        $this->load->model("Menu_model",'menu');
	}

    public function login(){
        $data_receive = json_decode(urldecode($this->input->post('data_send')));
        $token = $data_receive->token;
        $return = array();
        if($this->tokenStatus($token, 'SEND_DATA')){
            $username= htmlentities($data_receive->username ?? '');
            $password = htmlentities($data_receive->password ?? '');

            $result = $this->admin->login($username, $password);
            if($result){
                $return['sts'] = 1;
            }
            else if($result == false)
                $return['sts'] = 'not_valid';
        }

        echo json_encode($return);
    }
    public function keluar(){
        if($this->session->userdata('login_as') == 'administrator')
            $url = base_url('admin');
        else if($this->session->userdata('login_as') == 'pelanggan')
            $url = base_url('pelanggan');
        else
            $url = base_url();

        $this->session->sess_destroy();
        redirect($url);
    }
}
