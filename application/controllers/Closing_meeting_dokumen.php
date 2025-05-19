
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Closing_meeting_dokumen extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Closing_meeting_dokumen_model", "closing_meeting_dokumen");
        $this->load->model('closing_meeting_nama_file_model', 'closing_meeting_nama_file');
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_closing_meeting = $data_receive->id_closing_meeting;

                $where_files = array('closing_meeting_nama_file.active' => 1, 'aktor' => 'assesor');
                $order_files = "urutan ASC";
                $data_send_files = array('where' => $where_files, 'order' => $order_files);
                $load_data_files = $this->closing_meeting_nama_file->load_data($data_send_files);
                if ($load_data_files->num_rows() > 0) {
                    foreach ($load_data_files->result() as $row) {

                        $where = array(
                            'closing_meeting_dokumen.active' => 1,
                            'id_closing_meeting' => $id_closing_meeting,
                            'id_closing_meeting_nama_file' => $row->id_closing_meeting_nama_file
                        ); #show active data...

                        $send_data = array('where' => $where);
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
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_closing_meeting = htmlentities($this->input->post('id_closing_meeting') ?? '');
                $id_closing_meeting_nama_file = htmlentities($this->input->post('id_closing_meeting_nama_file') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $this->load->model('opening_meeting_model', 'opening_meeting');
                $where = array('opening_meeting.active' => 1, 'closing_meeting.id_closing_meeting' => $id_closing_meeting);
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $join[1] = array('tabel' => 'closing_meeting', 'relation' => 'closing_meeting.id_opening_meeting = opening_meeting.id_opening_meeting', 'direction' => 'left');
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
                        $nama_file = str_replace(' ', '', $nama_file);
                        $nama_file = str_replace('/', '-', $nama_file);
                        $jns_file = $closing_meeting_nama_file->jns_file;
                    }

                    $var = array(
                        'dir' => 'assets/uploads/dokumen/' . $opening_meeting->id_pelanggan . '/' . 'closing_meeting/' . $id_closing_meeting,
                        'allowed_types' => $jns_file,
                        'file' => 'file',
                        'encrypt_name' => true,
                        'new_name' => $nama_file . '-' . date('ymd') . '-' . $this->generateRandomString(5),
                    );
                    $hasil = $this->upload_v2($var);

                    if ($hasil['sts']) {
                        $data = array(
                            'id_closing_meeting' => $id_closing_meeting,
                            'id_closing_meeting_nama_file' => $id_closing_meeting_nama_file,
                            'path_file' => $var['dir'] . '/' . $hasil['file'],
                            'status' => 2,
                            'user_create' => $user_create,
                            'time_create' => $time_create,
                            'time_update' => $time_update,
                            'user_update' => $user_update
                        );
                        $exe = $this->closing_meeting_dokumen->save($data);
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

    public function verifikasi_dokumen()
    {
        if ($this->validasi_login()) {

            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_closing_meeting_dokumen = htmlentities($data_receive->id_dokumen);
                $status_verifikasi = htmlentities($data_receive->status_verifikasi);
                $alasan_verifikasi = htmlentities($data_receive->alasan_verifikasi);
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                if ($status_verifikasi == 'setuju') {
                    $status = 1;
                } else {
                    $status = 0;
                }

                $where = array('id_closing_meeting_dokumen' => $id_closing_meeting_dokumen);
                $data = array(
                    'status' => $status,
                    'alasan_verifikasi' => $alasan_verifikasi,
                    'time_update' => $time_update,
                    'user_update' => $user_update
                );
                $exe = $this->closing_meeting_dokumen->update($data, $where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }

    public function hapus()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_closing_meeting_dokumen = $data_receive->id_closing_meeting_dokumen;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $where = array('id_closing_meeting_dokumen' => $id_closing_meeting_dokumen);
                $where = "id_closing_meeting_dokumen = '" . $id_closing_meeting_dokumen . "' and status IN (0, 2)";
                $exe = $this->closing_meeting_dokumen->soft_delete($where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }


    public function goto_kirim_dokumen_kontrol()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_closing_meeting = htmlentities($data_receive->id_closing_meeting ?? '');

                $ditolak = false;
                $allow = true;
                #cek apakah sudah ada file yang di unggah atau belum
                $where_files = array('closing_meeting_nama_file.active' => 1, 'aktor' => 'assesor');
                $order_files = "urutan ASC";
                $data_send_files = array('where' => $where_files, 'order' => $order_files);
                $load_data_files = $this->closing_meeting_nama_file->load_data($data_send_files);
                if ($load_data_files->num_rows() > 0) {
                    foreach ($load_data_files->result() as $row) {
                        $where = array('active' => 1, 'id_closing_meeting' => $id_closing_meeting, 'id_closing_meeting_nama_file' => $row->id_closing_meeting_nama_file);
                        $data_send = array('where' => $where);
                        $load_data = $this->closing_meeting_dokumen->load_data($data_send);
                        if ($load_data->num_rows() > 0) {
                            $dokumen  = $load_data->row();

                            if ($dokumen->status == 0) {
                                $ditolak = true;
                            }
                        } else {
                            $allow = false;
                        }
                    }
                } else {
                    $allow = false;
                }

                if ($allow and !$ditolak) {
                    #update semua status file menjadi 3...
                    $data = array('status' => '3');
                    $where = array('active' => 1, 'id_closing_meeting' => $id_closing_meeting, 'status' => 2);
                    $this->closing_meeting_dokumen->update($data, $where);

                    #update status closing_meeting menjadi 2...
                    $step = 2;
                    $exe = $this->simpan_log_closing_meeting($id_closing_meeting, $step);
                    $return['sts'] = $exe;
                } else {
                    if ($ditolak) {
                        $return['sts'] = 'dokumen_belum_lengkap';
                    } else {
                        $return['sts'] = 'belum_ada_file';
                    }
                }
            }

            echo json_encode($return);
        }
    }

    public function goto_kirim_koordinator()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_closing_meeting = htmlentities($data_receive->id_closing_meeting ?? '');

                $ditolak = false;
                $allow = true;
                #cek apakah sudah ada file yang di unggah atau belum
                $where_files = array('closing_meeting_nama_file.active' => 1, 'aktor' => 'assesor');
                $order_files = "urutan ASC";
                $data_send_files = array('where' => $where_files, 'order' => $order_files);
                $load_data_files = $this->closing_meeting_nama_file->load_data($data_send_files);
                if ($load_data_files->num_rows() > 0) {
                    foreach ($load_data_files->result() as $row) {
                        $where = array('active' => 1, 'id_closing_meeting' => $id_closing_meeting, 'id_closing_meeting_nama_file' => $row->id_closing_meeting_nama_file);
                        $data_send = array('where' => $where);
                        $load_data = $this->closing_meeting_dokumen->load_data($data_send);
                        if ($load_data->num_rows() > 0) {
                            $dokumen  = $load_data->row();

                            if ($dokumen->status == 0) {
                                $ditolak = true;
                            }
                        } else {
                            $allow = false;
                        }
                    }
                } else {
                    $allow = false;
                }

                if ($allow and !$ditolak) {
                    #update semua status file menjadi 3...
                    $data = array('status' => '3');
                    $where = array('active' => 1, 'id_closing_meeting' => $id_closing_meeting, 'status' => 1);
                    $this->closing_meeting_dokumen->update($data, $where);

                    #update status closing_meeting menjadi 3...
                    $step = 3;
                    $exe = $this->simpan_log_closing_meeting($id_closing_meeting, $step);
                    $return['sts'] = $exe;
                } else {
                    if ($ditolak) {
                        $return['sts'] = 'dokumen_belum_lengkap';
                    } else {
                        $return['sts'] = 'belum_ada_file';
                    }
                }
            }

            echo json_encode($return);
        }
    }

    public function goto_kirim_verifikator()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_closing_meeting = htmlentities($data_receive->id_closing_meeting ?? '');

                $menunggu = false;

                #cek apakah sudah ada file yang di unggah atau belum
                $where_files = array('closing_meeting_nama_file.active' => 1, 'aktor' => 'assesor');
                $order_files = "urutan ASC";
                $data_send_files = array('where' => $where_files, 'order' => $order_files);
                $load_data_files = $this->closing_meeting_nama_file->load_data($data_send_files);
                if ($load_data_files->num_rows() > 0) {
                    foreach ($load_data_files->result() as $row) {
                        $where = array('active' => 1, 'id_closing_meeting' => $id_closing_meeting, 'id_closing_meeting_nama_file' => $row->id_closing_meeting_nama_file);
                        $data_send = array('where' => $where);
                        $load_data = $this->closing_meeting_dokumen->load_data($data_send);
                        if ($load_data->num_rows() > 0) {
                            $dokumen  = $load_data->row();

                            if ($dokumen->status == 3) {
                                $menunggu = true;
                            }
                        }
                    }
                }

                if (!$menunggu) {
                    #update status closing_meeting menjadi 1...
                    $step = 1;
                    $exe = $this->simpan_log_closing_meeting($id_closing_meeting, $step);
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'belum_verifikasi_semua';
                }
            }

            echo json_encode($return);
        }
    }

    public function goto_kirim_pelanggan()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_closing_meeting = htmlentities($data_receive->id_closing_meeting ?? '');

                $menunggu = false;
                $ditolak = false;

                #cek apakah sudah ada file yang di unggah atau belum
                $where_files = array('closing_meeting_nama_file.active' => 1, 'aktor' => 'assesor');
                $order_files = "urutan ASC";
                $data_send_files = array('where' => $where_files, 'order' => $order_files);
                $load_data_files = $this->closing_meeting_nama_file->load_data($data_send_files);
                if ($load_data_files->num_rows() > 0) {
                    foreach ($load_data_files->result() as $row) {
                        $where = array('active' => 1, 'id_closing_meeting' => $id_closing_meeting, 'id_closing_meeting_nama_file' => $row->id_closing_meeting_nama_file);
                        $data_send = array('where' => $where);
                        $load_data = $this->closing_meeting_dokumen->load_data($data_send);
                        if ($load_data->num_rows() > 0) {
                            $dokumen  = $load_data->row();

                            if ($dokumen->status == 3) {
                                $menunggu = true;
                            } else if ($dokumen->status == 0) {
                                $ditolak = true;
                            }
                        }
                    }
                }

                if (!$menunggu and !$ditolak) {
                    #update status closing_meeting menjadi 3...
                    $step = 4;
                    $exe = $this->simpan_log_closing_meeting($id_closing_meeting, $step);
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'dokumen_belum_disetujui';
                }
            }

            echo json_encode($return);
        }
    }
}
