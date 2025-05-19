
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Opening_meeting_etc extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Opening_meeting_etc_model", "opening_meeting_etc");
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_opening_meeting = (isset($data_receive->id_opening_meeting) ? $data_receive->id_opening_meeting : 'x');
                $relation[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = opening_meeting_etc.id_opening_meeting', 'direction' => 'left');
                $relation[1] = array('tabel' => 'mst_admin', 'relation' => 'mst_admin.id_admin = opening_meeting_etc.id_admin', 'direction' => 'left');

                $where = "opening_meeting_etc.active = 1  and opening_meeting.active = 1 and opening_meeting.id_opening_meeting = '" . $id_opening_meeting . "'";
                $send_data = array('where' => $where, 'join' => $relation);
                $load_data = $this->opening_meeting_etc->load_data($send_data);
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
                $id_admin = htmlentities($this->input->post('id_admin') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $where = array(
                    'id_opening_meeting' => $id_opening_meeting,
                    'id_admin' => $id_admin,
                    'active' => 1
                );
                $is_available = $this->opening_meeting_etc->is_available($where);

                if (!$is_available) {
                    $data = array(
                        'id_opening_meeting' => $id_opening_meeting,
                        'id_admin' => $id_admin,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $exe = $this->opening_meeting_etc->save($data);
                } else {
                    $exe = 'data_available';
                }

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
            $id_opening_meeting_etc = $data_receive->id_opening_meeting_etc;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $where = array('id_opening_meeting_etc' => $id_opening_meeting_etc);
                $exe = $this->opening_meeting_etc->soft_delete($where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }


    public function kirim_etc()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');

                #cek apakah sudah ada ETC yang ditugaskan atau belum...
                $where = array('active' => 1, 'id_opening_meeting' => $id_opening_meeting);
                $is_available = $this->opening_meeting_etc->is_available($where);

                if ($is_available) {
                    $step = 21;
                    $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, $step);
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'belum_ada_etc';
                }
            }

            echo json_encode($return);
        }
    }
    public function kirim_pelanggan()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');


                $step = 22;
                $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, $step);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
