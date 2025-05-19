<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hak_akses_menu extends MY_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("Menu_model",'menu');
        $this->load->model("Hak_akses_menu_model",'hak_akses_menu');
    }

    function load_menu($where, $id_jns_admin){
        $return = array();
        $order = ' urutan_menu ASC';
        $send_data = array('where' => $where, 'order' => $order);
        $data = $this->menu->load_data($send_data);
        if($data->num_rows() > 0){
            foreach ($data->result() as $menu){
                //have a child??...
                $where_count = array('parent_menu' => $menu->id_menu, 'module' => 'ADMIN');
                $jml_sub = $this->menu->select_count($where_count);
                $return_sub = array();
                if($jml_sub > 0){
                    $return_sub = $this->load_menu($where_count, $id_jns_admin);
                }

                //check have choosen..
                $where_choosen = array('id_menu' => $menu->id_menu, 'id_jns_admin' => $id_jns_admin);
                $count_choosen = $this->hak_akses_menu->select_count($where_choosen);
                if($count_choosen > 0)
                    $checked = 'checked';
                else
                    $checked = '';

                array_push($return, array(  'id_menu' => $menu->id_menu,
                    'nama_menu' => $menu->nama_menu,
                    'icon_menu' => $menu->icon_menu,
                    'url_menu' => $menu->url_menu,
                    'parent_menu' => $menu->parent_menu,
                    'checked' => $checked,
                    'sub_menu' => $return_sub
                ));
            }
        }

        return $return; //$rangkai;
    }

    public function load_akses_menu(){
        if($this->validasi_login()){
            $result = array();
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_jns_admin = $data_receive->id_jns_admin;

            if($this->tokenStatus($token, 'LOAD_DATA')){
                $where = array('parent_menu' => null,  'module' => 'ADMIN');
                $result = $this->load_menu($where, $id_jns_admin);
            }
            echo json_encode($result);
        }
    }

    public function simpan(){
        if($this->validasi_login()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_jns_admin = $data_receive->id_jns_admin;
            $data = $data_receive->datajson;
            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
                //clear hak akses first...
                $where_delete = array('id_jns_admin' => $id_jns_admin);
                $this->hak_akses_menu->delete($where_delete);

                foreach($data as $json){
                    $data_entry = array('id_menu' => $json->id_menu, 'id_jns_admin' => $id_jns_admin);
                    $this->hak_akses_menu->save($data_entry);
                }

                if($id_jns_admin == 1){
                    #dari pada ngecek ada atau tidak ada data 50.2, hapus saja dan insert baru..
                    $where_delete = array('id_jns_admin' => $id_jns_admin, 'id_menu' => '50.2');
                    $this->hak_akses_menu->delete($where_delete);

                    $data_entry = array('id_menu' => '50.2', 'id_jns_admin' => $id_jns_admin);
                    $this->hak_akses_menu->save($data_entry);
                }
                $return['sts'] = 1;
            }

            echo json_encode($return);
        }
    }
    public function hapus(){
        if($this->validasi_login()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
                $id_admin = htmlentities($data_receive->id_admin ?? '');

                $data = array('status_admin' => 'D');
                $where = array('id_admin' => $id_admin);
                $exe = $this->master_admin->update($data, $where);
                $return['sts'] = $exe;

            }

            echo json_encode($return);
        }
    }
    public function reset_password(){
        if($this->validasi_login()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
                $id_admin = htmlentities($data_receive->id_admin ?? '');
                $username = htmlentities($data_receive->username ?? '');

                $data = array('password_admin' => md5($username));
                $where = array('id_admin' => $id_admin);
                $exe = $this->master_admin->update($data, $where);
                $return['sts'] = $exe;

            }

            echo json_encode($return);
        }
    }



}
