
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jns_admin extends MY_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("Jns_admin_model","jns_admin");
    }

    public function load_data(){
        if($this->validasi_login()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if($this->tokenStatus($token, 'LOAD_DATA')){
                $filter = $data_receive->filter;


                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data.','.$start;

                $where = "id_jns_admin != 1 and (jns_admin like '%".$filter."%')";
                $send_data = array('where' => $where, 'limit' => $limit);
                $load_data = $this->jns_admin->load_data($send_data);
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'select' => $select);
                $load_data = $this->jns_admin->load_data($send_data);
                $total_data = $load_data->row()->jml;

                $last_page = ceil($total_data / $jml_data);
                $result = array('result' => $result, 'last_page' => $last_page);

                echo json_encode($result);
            }
        }

    }

    public function simpan(){
        if($this->validasi_login()){
            $token = $this->input->post('token');
            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
                $id_jns_admin = htmlentities($this->input->post('id_jns_admin') ?? '');
                $jns_admin = htmlentities($this->input->post('jns_admin') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $action = htmlentities($this->input->post('action') ?? '');

                #jika action memiliki value 'save' maka data akan disimpan.
                #jika action tidak memiliki value, maka akan dianggap sebagai upadate.
                if($action == 'save'){
                    $data = array(								'jns_admin' => $jns_admin,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update);
                    $exe = $this->jns_admin->save($data);
                    $return['sts'] = $exe;
                }
                else{
                    if($id_jns_admin != 1){
                        $data = array(								'jns_admin' => $jns_admin,
                            'time_update' => $time_update,
                            'user_update' => $user_update);
                        $where = array('id_jns_admin' => $id_jns_admin);
                        $exe = $this->jns_admin->update($data, $where);
                        $return['sts'] = $exe;
                    }
                    else
                        $return['sts'] = 'tidak_berhak';
                }
            }

            echo json_encode($return);
        }
    }
    public function hapus(){
        if($this->validasi_login()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_jns_admin = $data_receive->id_jns_admin;

            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
                if($id_jns_admin != 1){
                    $where = array('id_jns_admin' => $id_jns_admin);
                    $exe = $this->jns_admin->delete($where);
                    $return['sts'] = $exe;
                }
                else
                    $return['sts'] = 'tidak_berhak';

            }

            echo json_encode($return);
        }
    }

}
