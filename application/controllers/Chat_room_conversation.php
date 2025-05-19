
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_room_conversation extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model("Chat_room_conversation_model","chat_room_conversation");
        $this->load->model("mst_admin_model","mst_admin");
        $this->load->model("pelanggan_model","pelanggan");
        $this->load->model("chat_room_model","chat_room");

	}

    public function load_data(){
        if($this->validasi_login() or $this->validasi_login_pelanggan()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if($this->tokenStatus($token, 'LOAD_DATA')){
                $id_chat_room = htmlentities($data_receive->id_chat_room ?? '');

                #read data...
                if($this->session->userdata('login_as') == 'pelanggan'){
                    $id_pelanggan = $this->session->userdata('id_pelanggan');
                    $data = array(
                        'read' => 1,
                        'time_update' => date('Y-m-d H:i:s'),
                        'user_update' => $id_pelanggan);
                    $where = array('id_chat_room' => $id_chat_room, 'tabel_pengirim' => 'mst_admin');
                    $this->chat_room_conversation->update($data, $where, $id_pelanggan, 'pelanggan');
                }
                else if($this->session->userdata('login_as') == 'administrator'){
                    if($this->is_assesor()){
                        $id_admin = $this->session->userdata('id_admin');
                        $data = array(
                            'read' => 1,
                            'time_update' => date('Y-m-d H:i:s'),
                            'user_update' => $id_admin);
                        $where = array('id_chat_room' => $id_chat_room, 'tabel_pengirim' => 'pelanggan');
                        $this->chat_room_conversation->update($data, $where, $id_admin, 'mst_admin');
                    }
                }

                $relation[0] = array('tabel' => 'chat_room', 'relation' => 'chat_room.id_chat_room = chat_room_conversation.id_chat_room', 'direction' => 'left');

                $where = "chat_room_conversation.active = 1  and chat_room.active = 1 and chat_room.id_chat_room = '".$id_chat_room."'";
                if($this->session->userdata('login_as') == 'pelanggan'){
                    $where .= " and id_pelanggan = '".$this->session->userdata('id_pelanggan')."'";
                }
                else if($this->session->userdata('login_as') == 'administrator'){
                    if($this->is_assesor()){
                        $where .= " and id_assesor = '".$this->session->userdata('id_admin')."'";
                    }
                }

                $send_data = array('where' => $where, 'join' => $relation);
                $load_data = $this->chat_room_conversation->load_data($send_data);
                $result = $load_data->result();
                if($load_data->num_rows() > 0){
                    foreach ($load_data->result() as $data){
                        #mencari nama...
                        if($data->tabel_pengirim == 'mst_admin'){
                            $where_nama = array('id_admin' => $data->id_pengirim);
                            $data_send_nama = array('where' => $where_nama);
                            $load_data_nama = $this->mst_admin->load_data($data_send_nama);
                            if($load_data_nama->num_rows() > 0){
                                $data->nama = $load_data_nama->row()->nama_admin;
                            }
                        }
                        else if($data->tabel_pengirim == 'pelanggan'){
                            $where_nama = array('id_pelanggan' => $data->id_pengirim);
                            $data_send_nama = array('where' => $where_nama);
                            $load_data_nama = $this->pelanggan->load_data($data_send_nama);
                            if($load_data_nama->num_rows() > 0){
                                $data->nama = $load_data_nama->row()->nama_pejabat_penghubung_proses_tkdn;
                            }
                        }
                    }
                }

                echo json_encode($result);
            }
        }

    }

    public function simpan(){
        if($this->validasi_login() or $this->validasi_login_pelanggan()){
            $token = $this->input->post('token');
            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
				$id_chat_room = htmlentities($this->input->post('id_chat_room') ?? '');
				$pesan = htmlentities($this->input->post('pesan') ?? '');
                $allow = true;

                if($this->session->userdata('login_as') == 'pelanggan'){
                    $id_pengirim = $this->session->userdata('id_pelanggan');
                    $tabel_pengirim = 'pelanggan';
                    $user_create = $this->session->userdata('id_pelanggan');
                    $time_create = date('Y-m-d H:i:s');
                    $time_update = date('Y-m-d H:i:s');
                    $user_update = $this->session->userdata('id_pelanggan');

                    $where_cek = array('active' => 1, 'id_chat_room' => $id_chat_room, 'id_pelanggan' => $id_pengirim, 'status' => 1);
                    $hasil_cek = $this->chat_room->is_available($where_cek);
                    if(!$hasil_cek){
                        $allow = false;
                    }
                }
                else if($this->session->userdata('login_as') == 'administrator'){
                    $id_pengirim = $this->session->userdata('id_admin');
                    $tabel_pengirim = 'mst_admin';
                    $user_create = $this->session->userdata('id_admin');
                    $time_create = date('Y-m-d H:i:s');
                    $time_update = date('Y-m-d H:i:s');
                    $user_update = $this->session->userdata('id_admin');

                    $where_cek = array('active' => 1, 'id_chat_room' => $id_chat_room, 'id_assesor' => $id_pengirim, 'status' => 1);
                    $hasil_cek = $this->chat_room->is_available($where_cek);
                    if(!$hasil_cek){
                        $allow = false;
                    }
                }

                if($allow){
                    $data = array('id_chat_room' => $id_chat_room,
                        'waktu_kirim' => $time_create,
                        'pesan' => $pesan,
                        'id_pengirim' => $id_pengirim,
                        'tabel_pengirim' => $tabel_pengirim,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update);
                    $exe = $this->chat_room_conversation->save($data, $id_pengirim, $tabel_pengirim);
                    $return['sts'] = $exe;
                }
                else{
                    $return['sts'] = 'tidak_berhak_akses_data';
                }

            }

            echo json_encode($return);
        }
    }

}
