
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Closing_meeting extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Closing_meeting_dokumen_model", "closing_meeting_dokumen");
        $this->load->model('closing_meeting_nama_file_model', 'closing_meeting_nama_file');
    }

    public function load_file_closing_meeting()
    {
        if ($this->validasi_login_pelanggan()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting);
                $aktor = (isset($data_receive->aktor) ? htmlentities($data_receive->aktor) : 'pelanggan');
                $id_pelanggan = $this->session->userdata('id_pelanggan');

                $where_files = array('closing_meeting_nama_file.active' => 1, 'aktor' => $aktor);
                $order_files = "urutan ASC";
                $data_send_files = array('where' => $where_files, 'order' => $order_files);
                $load_data_files = $this->closing_meeting_nama_file->load_data($data_send_files);
                if ($load_data_files->num_rows() > 0) {
                    foreach ($load_data_files->result() as $row) {
                        $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = closing_meeting_dokumen.id_opening_meeting', 'direction' => 'left');
                        $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                        $where = array(
                            'closing_meeting_dokumen.active' => 1,
                            'dokumen_permohonan.id_pelanggan' => $id_pelanggan,
                            'closing_meeting_dokumen.id_opening_meeting' => $id_opening_meeting,
                            'id_closing_meeting_nama_file' => $row->id_closing_meeting_nama_file
                        ); #show active data...

                        $send_data = array('where' => $where, 'join' => $join);
                        $load_data = $this->closing_meeting_dokumen->load_data($send_data);
                        $row->dokumen = $load_data->result();
                    }
                }

                $result = $load_data_files->result();
                echo json_encode($result);
            }
        }
    }

    public function simpan()
    {
        if ($this->validasi_login_pelanggan()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
                $id_closing_meeting_nama_file = htmlentities($this->input->post('id_closing_meeting_nama_file') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');
                $id_pelanggan = $this->session->userdata('id_pelanggan');

                $this->load->model('opening_meeting_model', 'opening_meeting');
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_pelanggan' => $id_pelanggan);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();

                    #load nama file...
                    $nama_file = '';
                    $jns_file = '*';
                    $this->load->model('closing_meeting_nama_file_model', 'closing_meeting_nama_file');
                    $where_nama_file = array('closing_meeting_nama_file.active' => 1, 'id_closing_meeting_nama_file' => $id_closing_meeting_nama_file);
                    $data_send_nama_file = array('where' => $where_nama_file);
                    $load_data_nama_file = $this->closing_meeting_nama_file->load_data($data_send_nama_file);
                    if ($load_data_nama_file->num_rows() > 0) {
                        $closing_meeting_nama_file = $load_data_nama_file->row();
                        $nama_file = $closing_meeting_nama_file->nama_file;
                        $jns_file = $closing_meeting_nama_file->jns_file;
                    }

                    $var = array(
                        'dir' => 'assets/uploads/dokumen/' . $opening_meeting->id_pelanggan . '/' . 'closing_meeting/' . $id_opening_meeting,
                        'allowed_types' => $jns_file,
                        'file' => 'file',
                        'encrypt_name' => true,
                        'new_name' => $nama_file . '-' . date('ymd') . '-' . $this->generateRandomString(5),
                    );
                    $hasil = $this->upload_v2($var);

                    if ($hasil['sts']) {
                        $data = array(
                            'id_opening_meeting' => $id_opening_meeting,
                            'id_closing_meeting_nama_file' => $id_closing_meeting_nama_file,
                            'path_file' => $var['dir'] . '/' . $hasil['file'],
                            'status' => 1,
                            'user_create' => $user_create,
                            'time_create' => $time_create,
                            'time_update' => $time_update,
                            'user_update' => $user_update
                        );
                        $exe = $this->closing_meeting_dokumen->save($data, $id_pelanggan, 'pelanggan');
                        $return['sts'] = $exe;
                    } else {
                        $return['sts'] = 'upload_error';
                        $return['msg'] = $hasil['msg'];
                    }
                } else {
                    $return['sts'] = 'tidak_berhak_akses_data';
                }
            }

            echo json_encode($return);
        }
    }

    public function hapus()
    {
        if ($this->validasi_login_pelanggan()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_closing_meeting_dokumen = $data_receive->id_closing_meeting_dokumen;
            $id_pelanggan = $this->session->userdata('id_pelanggan');

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = closing_meeting_dokumen.id_opening_meeting', 'direction' => 'left');
                $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where = array('closing_meeting_dokumen.active' => 1, 'id_closing_meeting_dokumen' => $id_closing_meeting_dokumen, 'id_pelanggan' => $id_pelanggan);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->closing_meeting_dokumen->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $where_hapus = array('id_closing_meeting_dokumen' => $id_closing_meeting_dokumen);
                    $exe = $this->closing_meeting_dokumen->soft_delete($where_hapus, $id_pelanggan, 'pelanggan');
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'tidak_berhak_hapus_data';
                }
            }

            echo json_encode($return);
        }
    }

    public function goto_next_step()
    {
        if ($this->validasi_login_pelanggan()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_pelanggan = $this->session->userdata('id_pelanggan');
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');

                $allow = true;

                #cek apakah sudah ada file yang di unggah atau belum
                $where_files = array('closing_meeting_nama_file.active' => 1, 'aktor' => 'pelanggan');
                $order_files = "urutan ASC";
                $data_send_files = array('where' => $where_files, 'order' => $order_files);
                $load_data_files = $this->closing_meeting_nama_file->load_data($data_send_files);
                if ($load_data_files->num_rows() > 0) {
                    foreach ($load_data_files->result() as $row) {
                        $join_dokumen[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = closing_meeting_dokumen.id_opening_meeting', 'direction' => 'left');
                        $join_dokumen[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                        $where_dokumen = array(
                            'closing_meeting_dokumen.active' => 1,
                            'closing_meeting_dokumen.id_opening_meeting' => $id_opening_meeting,
                            'id_closing_meeting_nama_file' => $row->id_closing_meeting_nama_file,
                            'id_pelanggan' => $id_pelanggan
                        );
                        $data_send_dokumen = array('where' => $where_dokumen, 'join' => $join_dokumen);
                        $load_data_dokumen = $this->closing_meeting_dokumen->load_data($data_send_dokumen);
                        if ($load_data_dokumen->num_rows() == 0) {
                            $allow = false;
                        }
                    }
                } else {
                    $allow = false;
                }

                if ($allow) {
                    $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 30);
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'belum_ada_file';
                }
            }

            echo json_encode($return);
        }
    }
}
