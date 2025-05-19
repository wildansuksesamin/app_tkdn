
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Opening_meeting_asisten_assesor extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('opening_meeting_model', 'opening_meeting');
        $this->load->model("Opening_meeting_asisten_assesor_model", "opening_meeting_asisten_assesor");
    }

    public function simpan()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_asisten_assesor = htmlentities($this->input->post('id_asisten_assesor') ?? '');
                $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
                $id_admin = htmlentities($this->input->post('id_admin') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $cek_asisten = $this->opening_meeting_asisten_assesor->is_available(array(
                    'active' => 1,
                    'id_admin' => $id_admin,
                    'id_opening_meeting' => $id_opening_meeting
                ));

                $cek_utama = $this->opening_meeting->is_available(array(
                    'active' => 1,
                    'id_assesor' => $id_admin,
                    'id_opening_meeting' => $id_opening_meeting
                ));

                if (!$cek_asisten and !$cek_utama) {
                    $data = array(
                        'id_opening_meeting' => $id_opening_meeting,
                        'id_admin' => $id_admin,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $exe = $this->opening_meeting_asisten_assesor->save($data);
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'data_available';
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
            $id_asisten_assesor = $data_receive->id_asisten_assesor;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $where = array('id_asisten_assesor' => $id_asisten_assesor);
                $exe = $this->opening_meeting_asisten_assesor->soft_delete($where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
