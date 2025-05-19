
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_room extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model("Chat_room_model","chat_room");
        $this->load->model("Chat_room_conversation_model","chat_room_conversation");
	}

    public function load_data(){
        if($this->validasi_login() or $this->validasi_login_pelanggan()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if($this->tokenStatus($token, 'LOAD_DATA')){
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);
                $relation[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = chat_room.id_dokumen_permohonan', 'direction' => 'left');
                $relation[1] = array('tabel' => 'mst_admin', 'relation' => 'mst_admin.id_admin = chat_room.id_assesor', 'direction' => 'left');
                $relation[2] = array('tabel' => 'jns_admin', 'relation' => 'mst_admin.id_jns_admin = jns_admin.id_jns_admin', 'direction' => 'left');
                $relation[3] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = chat_room.id_pelanggan', 'direction' => 'left');
                $relation[4] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
                $relation[5] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $relation[6] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');

                $where = "chat_room.active = 1  and dokumen_permohonan.active = 1 and pelanggan.active = 1";
                if($this->session->userdata('login_as') == 'pelanggan'){
                    $where .= " and mst_admin.nama_admin like '%".$filter."%' and pelanggan.id_pelanggan = '".$this->session->userdata('id_pelanggan')."'";
                }
                else if($this->session->userdata('login_as') == 'administrator'){
                    $where .= " and pelanggan.nama_perusahaan like '%".$filter."%'";

                    if($this->is_assesor()){
                        $where .= " and mst_admin.id_admin = '".$this->session->userdata('id_admin')."'";
                    }
                }
                $order = "unix_timestamp(chat_room.time_update) DESC";
                $send_data = array('where' => $where, 'join' => $relation, 'order' => $order);
                $load_data = $this->chat_room->load_data($send_data);
                $result = $load_data->result();

                if($load_data->num_rows() > 0){
                    foreach ($load_data->result() as $list){
                        #find jml chat yang belum dibaca...
                        if($this->session->userdata('login_as') == 'pelanggan'){
                            $where_count = array(
                                'id_chat_room' => $list->id_chat_room,
                                'read' => 0,
                                'tabel_pengirim' => 'mst_admin'
                            );
                        }
                        else if($this->session->userdata('login_as') == 'administrator'){
                            $where_count = array(
                                'id_chat_room' => $list->id_chat_room,
                                'read' => 0,
                                'tabel_pengirim' => 'pelanggan'
                            );
                        }
                        $list->unread = $this->chat_room_conversation->select_count($where_count);

                        #find last chat...
                        $order_last_chat = 'id_chat_room_conversation DESC';
                        $limit_last_chat = '1,0';
                        $where_last_chat = array('active' => 1, 'id_chat_room' => $list->id_chat_room);
                        $data_send_last_chat = array('where' => $where_last_chat, 'order' => $order_last_chat, 'limit' => $limit_last_chat);
                        $load_data_last_chat = $this->chat_room_conversation->load_data($data_send_last_chat);
                        if($load_data_last_chat->num_rows() > 0){
                            $list->last_chat = $load_data_last_chat->row()->waktu_kirim;
                        }
                    }
                }

                echo json_encode($result);
            }
        }
    }

    public function proses_revisi(){
        if($this->validasi_login() or $this->validasi_login_pelanggan()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
                $this->load->model("rab_model", "rab");
                $id_rab = htmlentities($data_receive->id_rab ?? '');
                $tipe_revisi = htmlentities($data_receive->tipe_revisi ?? '');
                $alasan_verifikasi = htmlentities($data_receive->alasan_revisi ?? '');

                if($tipe_revisi == 'rab')
                    $status_verifikasi = 6;
                else
                    $status_verifikasi = 9;

                $where = array('active' => 1, 'id_rab' => $id_rab);
                $data_send = array('where' => $where);
                $load_data = $this->rab->load_data($data_send);
                if($load_data->num_rows() > 0){
                    $rab = $load_data->row();
                    $id_dokumen_permohonan = $rab->id_dokumen_permohonan;
                    $exe = $this->simpan_log_verifikasi($id_dokumen_permohonan, $status_verifikasi, $alasan_verifikasi);
                    $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }
}
