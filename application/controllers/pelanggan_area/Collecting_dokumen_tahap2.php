
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Collecting_dokumen_tahap2 extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('opening_meeting_model', 'opening_meeting');
        $this->load->model("Collecting_dokumen_tahap2_model", "collecting_dokumen_tahap2");
    }

    public function load_data()
    {
        if ($this->validasi_login_pelanggan()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');

                $select = "*, collecting_dokumen_tahap2.alasan_verifikasi alasan_verifikasi_cd2";

                $relation[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = collecting_dokumen_tahap2.id_opening_meeting', 'direction' => 'left');
                $relation[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');

                $where = "collecting_dokumen_tahap2.active = 1  and opening_meeting.active = 1 and opening_meeting.id_opening_meeting = '" . $id_opening_meeting . "' and id_pelanggan = '" . $this->session->userdata('id_pelanggan') . "'";
                $send_data = array('where' => $where, 'join' => $relation, 'select' => $select);
                $load_data = $this->collecting_dokumen_tahap2->load_data($send_data);
                $result = $load_data->result();

                $result = array('result' => $result);

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
                $nama_file = htmlentities($this->input->post('nama_file') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                #cek apakah boleh upload dokumen...
                $where = array('opening_meeting.active' => 1, 'id_status' => 16, 'id_opening_meeting' => $id_opening_meeting);
                $data_send = array('where' => $where);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $var = array(
                        'dir' => 'assets/uploads/dokumen/' . $this->session->userdata('id_pelanggan') . '/collecting_dokumen/' . $id_opening_meeting . '/',
                        'allowed_types' => 'pdf|jpeg|jpg|xls|xlsx|doc|docx|zip|rar',
                        'file' => 'path_file',
                        'new_name' => $nama_file . '-' . date('Ymdhis') . '-' . $this->generateRandomString('5')
                    );
                    $hasil = $this->upload_v2($var);

                    if ($hasil['sts'] == 'sukses') {

                        $data = array(
                            'id_opening_meeting' => $id_opening_meeting,
                            'nama_file' => $nama_file,
                            'path_file' => $var['dir'] . $hasil['file'],
                            'status_verifikasi' => 2,
                            'user_create' => $user_create,
                            'time_create' => $time_create,
                            'time_update' => $time_update,
                            'user_update' => $user_update
                        );
                        $exe = $this->collecting_dokumen_tahap2->save($data, 'pelanggan', $user_create);
                        $return['sts'] = $exe;
                    } else {
                        $return['sts'] = 'upload_gagal';
                        $return['msg'] = $hasil['msg'];
                    }
                } else {
                    $return['sts'] = 'tidak_berhak';
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
            $id_pelanggan = $this->session->userdata('id_pelanggan');
            $id_collecting_dokumen_2 = htmlentities($data_receive->id_collecting_dokumen_2 ?? '');

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                #cek apakah pelanggan berhak menghapus data...
                $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = collecting_dokumen_tahap2.id_opening_meeting', 'direction' => 'left');
                $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');

                $where = array(
                    'collecting_dokumen_tahap2.active' => 1,
                    'id_collecting_dokumen_2' => $id_collecting_dokumen_2,
                    'id_pelanggan' => $id_pelanggan,
                    'collecting_dokumen_tahap2.status_verifikasi != ' => 1
                );
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->collecting_dokumen_tahap2->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $where = array('id_collecting_dokumen_2' => $id_collecting_dokumen_2);
                    $exe = $this->collecting_dokumen_tahap2->soft_delete($where, 'pelanggan', $id_pelanggan);
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'tidak_berhak';
                }
            }

            echo json_encode($return);
        }
    }
}
