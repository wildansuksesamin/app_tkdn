
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Opening_meeting extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Opening_meeting_model", "opening_meeting");
        $this->load->model('surat_penawaran_model', 'surat_penawaran');
    }

    public function penugasan_assesor()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_dokumen_permohonan = htmlentities($this->input->post('id_dokumen_permohonan') ?? '');
                $id_admin = htmlentities($this->input->post('id_admin') ?? '');

                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $cek_open_meeting = $this->opening_meeting->is_available(array('active' => 1, 'id_permohonan' => $id_dokumen_permohonan));

                if (!$cek_open_meeting) {
                    $masa_collecting_dokumen = 0;

                    $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                    $where = array('surat_penawaran.active' => 1, 'id_dokumen_permohonan' => $id_dokumen_permohonan);
                    $data_send = array('where' => $where, 'join' => $join);
                    $load_data = $this->surat_penawaran->load_data($data_send);
                    if ($load_data->num_rows() > 0) {
                        $masa_collecting_dokumen = $load_data->row()->masa_collecting_dokumen;
                    }

                    $data = array(
                        'id_permohonan' => $id_dokumen_permohonan,
                        'id_assesor' => $id_admin,
                        'masa_collecting_dokumen' => $masa_collecting_dokumen,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $hasil = $this->opening_meeting->save_with_autoincrement($data);
                    $return['sts'] = $hasil[0];

                    if ($hasil[0]) {
                        $id_opening_meeting = $hasil[1];

                        #simpan log statusnya...
                        $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 0);
                        $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 1);
                    }
                } else {
                    $data = array(
                        'id_assesor' => $id_admin,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where = array('id_permohonan' => $id_dokumen_permohonan);
                    $exe = $this->opening_meeting->update($data, $where);
                    $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }

    var $manual_tipe_file = 'application/pdf';
    public function upload_dokumen_opening_meeting()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
                $time_update = date('Y-m-d H:i:s');
                $id_admin = $this->session->userdata('id_admin');

                $data = array(
                    'time_update' => $time_update,
                    'user_update' => $id_admin
                );

                $allow = true;
                $dir_parent = 'assets/uploads/dokumen_admin';
                $dir = $dir_parent . '/' . $id_admin;
                #create folder untuk admin...
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);

                    touch($dir . '/index.html');
                }

                $prefix_rename = date('ymd') . '-' . $this->generateRandomString(5) . '.pdf';
                $new_name = 'dokumen_admin-' . $id_admin . '-' . date('YmdHis') . $this->generateRandomString(5);
                $variable = array(
                    'new_name' => $new_name,
                    'dir' => $dir,
                );

                if (isset($_FILES['surat_tugas_assesor'])) {
                    $var_surat_tugas_assesor = $variable;
                    $var_surat_tugas_assesor['file'] = 'surat_tugas_assesor';
                    $result = $this->upload($var_surat_tugas_assesor);
                    if ($result['sts'] == 'sukses') {
                        $rename = 'Dokumen Surat Tugas-' . $prefix_rename;
                        rename($dir . '/' . $result['file'], $dir . '/' . $rename);
                        $data['surat_tugas_assesor'] = $dir . '/' . $rename;
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $result['msg'];
                    }
                }

                if (isset($_FILES['risalah_rapat_assesor'])) {
                    $var_risalah_rapat_assesor = $variable;
                    $var_risalah_rapat_assesor['file'] = 'risalah_rapat_assesor';
                    $result = $this->upload($var_risalah_rapat_assesor);
                    if ($result['sts'] == 'sukses') {
                        $rename = 'Dokumen Risalah Rapat-' . $prefix_rename;
                        rename($dir . '/' . $result['file'], $dir . '/' . $rename);
                        $data['risalah_rapat_assesor'] = $dir . '/' . $rename;
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $result['msg'];
                    }
                }

                if (isset($_FILES['hadir_rapat_assesor'])) {
                    $var_hadir_rapat_assesor = $variable;
                    $var_hadir_rapat_assesor['file'] = 'hadir_rapat_assesor';
                    $result = $this->upload($var_hadir_rapat_assesor);
                    if ($result['sts'] == 'sukses') {
                        $rename = 'Dokumen Hadir Rapat-' . $prefix_rename;
                        rename($dir . '/' . $result['file'], $dir . '/' . $rename);
                        $data['hadir_rapat_assesor'] = $dir . '/' . $rename;
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $result['msg'];
                    }
                }

                if ($allow) {
                    $where = array('id_opening_meeting' => $id_opening_meeting, 'id_assesor' => $id_admin);
                    $exe = $this->opening_meeting->update($data, $where, $id_admin, 'mst_admin');
                    $return['sts'] = $exe;

                    if ($exe) {
                        $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 4);
                    }
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
                $id_opening_meeting = $data_receive->id_opening_meeting;
                $alasan = (isset($data_receive->alasan) ? htmlentities($data_receive->alasan ?? '') : '');
                $status = ($data_receive->status == 'setuju' ? 7 : 6);

                if ($data_receive->status == 'setuju') {
                    #start tgl mulai opening meeting...
                    $data = array(
                        'tgl_mulai_verifikasi_dokumen' => date('Y-m-d')
                    );
                    $where = array(
                        'active' => 1,
                        'id_opening_meeting' => $id_opening_meeting,
                        'id_status' => 5,
                        'id_assesor' => $this->session->userdata('id_admin')
                    );
                    $this->opening_meeting->update($data, $where);
                }

                $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, $status, $alasan);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
