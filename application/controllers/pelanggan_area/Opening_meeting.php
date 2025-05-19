
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Opening_meeting extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Opening_meeting_model", "opening_meeting");
        $this->load->model('surat_penawaran_model', 'surat_penawaran');
    }


    var $manual_tipe_file = 'application/pdf,image/jpeg';
    public function upload_dokumen_opening_meeting()
    {
        if ($this->validasi_login_pelanggan()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
                $time_update = date('Y-m-d H:i:s');
                $id_pelanggan = $this->session->userdata('id_pelanggan');

                $data = array(
                    'time_update' => $time_update,
                    'user_update' => $id_pelanggan
                );

                $allow = true;
                $dir_parent = 'assets/uploads/dokumen';
                $dir = $dir_parent . '/' . $id_pelanggan;
                #create folder untuk admin...
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);

                    touch($dir . '/index.html');
                }

                $prefix_rename = date('ymd') . '-' . $this->generateRandomString(5);

                if (isset($_FILES['surat_tugas_pelanggan'])) {
                    $var = array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'surat_tugas_pelanggan',
                        'new_name' => 'Dokumen Surat Tugas-' . $prefix_rename
                    );
                    $hasil = $this->upload_v2($var);
                    if ($hasil['sts']) {
                        $data['surat_tugas_pelanggan'] = $dir . '/' . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                }
                if (isset($_FILES['risalah_rapat_pelanggan'])) {
                    $var = array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'risalah_rapat_pelanggan',
                        'new_name' => 'Dokumen Risalah Rapat-' . $prefix_rename
                    );
                    $hasil = $this->upload_v2($var);
                    if ($hasil['sts']) {
                        $data['risalah_rapat_pelanggan'] = $dir . '/' . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                }

                if (isset($_FILES['hadir_rapat_pelanggan'])) {
                    $var = array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'hadir_rapat_pelanggan',
                        'new_name' => 'Dokumen Hadir Rapat-' . $prefix_rename
                    );
                    $hasil = $this->upload_v2($var);
                    if ($hasil['sts']) {
                        $data['hadir_rapat_pelanggan'] = $dir . '/' . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                }

                if ($allow) {
                    $where = array('id_opening_meeting' => $id_opening_meeting);
                    $exe = $this->opening_meeting->update($data, $where, $id_pelanggan, 'pelanggan');
                    $return['sts'] = $exe;

                    if ($exe) {
                        $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 5);
                    }
                }
            }

            echo json_encode($return);
        }
    }
    public function request_revisi_dokumen()
    {
        if ($this->validasi_login_pelanggan()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = $data_receive->id_opening_meeting;
                $alasan = (isset($data_receive->alasan) ? htmlentities($data_receive->alasan ?? '') : '');

                $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 2, $alasan);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
