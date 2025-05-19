
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Survey_lapangan_assesor extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Survey_lapangan_assesor_model", "survey_lapangan_assesor");
    }



    public function simpan()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_assesor_survey_lapangan = htmlentities($this->input->post('id_assesor_survey_lapangan') ?? '');
                $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
                $id_admin = htmlentities($this->input->post('id_admin') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                #cek apakah assesor sudah pernah ditambahkan sebelumnya...
                $cek_assesor = $this->survey_lapangan_assesor->is_available(array(
                    'active' => 1,
                    'id_opening_meeting' => $id_opening_meeting,
                    'id_admin' => $id_admin
                ));
                if (!$cek_assesor) {
                    #jika belum ada, boleh input data...
                    $data = array(
                        'id_opening_meeting' => $id_opening_meeting,
                        'id_admin' => $id_admin,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $exe = $this->survey_lapangan_assesor->save($data);
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
            $id_assesor_survey_lapangan = $data_receive->id_assesor_survey_lapangan;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $where = array('id_assesor_survey_lapangan' => $id_assesor_survey_lapangan);
                $exe = $this->survey_lapangan_assesor->soft_delete($where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
