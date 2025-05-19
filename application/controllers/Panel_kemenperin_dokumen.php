
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Panel_kemenperin_dokumen extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('opening_meeting_model', 'opening_meeting');
        $this->load->model('closing_meeting_model', 'closing_meeting');
        $this->load->model("Panel_kemenperin_dokumen_model", "panel_kemenperin_dokumen");
        $this->load->model('panel_kemenperin_nama_file_model', 'panel_kemenperin_nama_file');
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $id_nama_file = htmlentities($data_receive->id_nama_file ?? '');

                $select = "*, panel_kemenperin_dokumen.nama_file as panel_kemenperin_dokumen_nama_file";
                $relation[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = panel_kemenperin_dokumen.id_opening_meeting', 'direction' => 'left');
                $relation[1] = array('tabel' => 'panel_kemenperin_nama_file', 'relation' => 'panel_kemenperin_nama_file.id_nama_file = panel_kemenperin_dokumen.id_nama_file', 'direction' => 'left');
                $where = array(
                    'panel_kemenperin_dokumen.active' => 1,
                    'opening_meeting.active' => 1,
                    'panel_kemenperin_dokumen.id_opening_meeting' => $id_opening_meeting,
                    'panel_kemenperin_dokumen.id_nama_file' => $id_nama_file,
                ); #show active data...

                if (isset($data_receive->id_closing_meeting)) {
                    $where['id_closing_meeting'] = htmlentities($data_receive->id_closing_meeting ?? '');
                }

                $send_data = array('select' => $select, 'where' => $where, 'join' => $relation);
                $load_data = $this->panel_kemenperin_dokumen->load_data($send_data);
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
                $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
                $id_nama_file = htmlentities($this->input->post('id_nama_file') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $this->load->model('opening_meeting_model', 'opening_meeting');
                $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();

                    #mencari nama_file...
                    $where_file = array('panel_kemenperin_nama_file.active' => 1, 'id_nama_file' => $id_nama_file);
                    $data_send_file = array('where' => $where_file);
                    $load_data_file = $this->panel_kemenperin_nama_file->load_data($data_send_file);
                    if ($load_data_file->num_rows() > 0) {
                        $panel_kemenperin_nama_file = $load_data_file->row();


                        #upload file ke server...
                        $var = array(
                            'dir' => 'assets/uploads/dokumen/' . $opening_meeting->id_pelanggan . '/' . 'panel_kemenperin/' . $id_opening_meeting,
                            'allowed_types' => $panel_kemenperin_nama_file->jns_file,
                            'file' => 'file',
                            'new_name' => 'panel-kemenperin-' . strtolower(str_replace(' ', '-', $panel_kemenperin_nama_file->nama_file)) . '-' . date('YmdHis') . '-' . $opening_meeting->id_pelanggan,
                            'encrypt_name' => false
                        );
                        $hasil = $this->upload_v2($var);

                        if ($hasil['sts']) {
                            $data = array(
                                'id_opening_meeting' => $id_opening_meeting,
                                'id_nama_file' => $id_nama_file,
                                'nama_file' => $hasil['file'],
                                'path_file' => $var['dir'] . '/' . $hasil['file'],
                                'user_create' => $user_create,
                                'time_create' => $time_create,
                                'time_update' => $time_update,
                                'user_update' => $user_update
                            );
                            $exe = $this->panel_kemenperin_dokumen->save($data);
                            $return['sts'] = $exe;
                        } else {
                            $return['sts'] = 'upload_error';
                            $return['msg'] = $hasil['msg'];
                        }
                    } else {
                        $return['sts'] = 'tidak_berhak_akses_data';
                    }
                } else {
                    $return['sts'] = 'tidak_berhak_akses_data';
                }
            }

            echo json_encode($return);
        }
    }

    public function goto_closing_meeting()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $id_panel_kemenperin_dokumen = $data_receive->id_panel_kemenperin_dokumen;

                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');

                #mencari tahap closing meeting terakhir...
                $where = array('closing_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
                $jml_data = $this->closing_meeting->select_count($where);
                $tahap_closing_meeting = $jml_data + 1;

                #buat data closing meeting...
                $data = array(
                    'id_opening_meeting' => $id_opening_meeting,
                    'tahap_closing_meeting' => $tahap_closing_meeting,
                    'user_create' => $user_create,
                    'time_create' => $time_create
                );
                $hasil = $this->closing_meeting->save_with_autoincrement($data);
                $exe = $hasil[0];
                $return['sts'] = $exe;

                if ($exe) {
                    $id_closing_meeting = $hasil[1];
                    #upload panel_kemenperin_dokumen dengan cara loop $id_panel_kemenperin_dokumen
                    foreach ($id_panel_kemenperin_dokumen as $id_panel) {
                        $data = array('id_closing_meeting' => $id_closing_meeting);
                        $where = array('id_panel_kemenperin_dokumen' => $id_panel);
                        $this->panel_kemenperin_dokumen->update($data, $where);
                    }

                    #cek apakah status opening meeting lebih dari 26 atau belum
                    $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
                    $data_send = array('where' => $where);
                    $load_data = $this->opening_meeting->load_data($data_send);
                    if ($load_data->num_rows() > 0) {
                        $opening_meeting = $load_data->row();

                        if ($opening_meeting->id_status < 26) {
                            $step = 26;
                            $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, $step);
                        }
                    }
                }
            }

            echo json_encode($return);
        }
    }

    public function hapus()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_panel_kemenperin_dokumen = $data_receive->id_panel_kemenperin_dokumen;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $where = array('id_panel_kemenperin_dokumen' => $id_panel_kemenperin_dokumen, 'id_closing_meeting' => 0);
                $exe = $this->panel_kemenperin_dokumen->soft_delete($where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
