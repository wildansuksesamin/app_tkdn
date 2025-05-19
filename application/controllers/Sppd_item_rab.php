
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sppd_item_rab extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Sppd_item_rab_model", "sppd_item_rab");
    }


    public function simpan_reguler()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $id_rab_detail = $data_receive->id_rab_detail;
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');

                #cek apakah admin berhak...
                $this->load->model('survey_lapangan_assesor_model', 'survey_lapangan_assesor');
                $berhak = $this->survey_lapangan_assesor->is_available(array(
                    'active' => 1,
                    'id_admin' => $user_create,
                    'id_opening_meeting' => $id_opening_meeting
                ));
                if ($berhak) { #hapus dulu data reguler...
                    $where = array(
                        'id_opening_meeting' => $id_opening_meeting,
                        'jns_item' => 'REGULER'
                    );
                    $this->sppd_item_rab->delete($where);

                    #simpan data satu per satu...
                    for ($i = 0; $i < count($id_rab_detail); $i++) {
                        $data = array(
                            'id_opening_meeting' => $id_opening_meeting,
                            'id_rab_detail' => htmlentities($id_rab_detail[$i] ?? ''),
                            'jns_item' => 'REGULER',
                            'user_create' => $user_create,
                            'time_create' => $time_create,
                            'time_update' => $time_create,
                            'user_update' => $user_create
                        );
                        $this->sppd_item_rab->save($data);
                    }
                    $return['sts'] = true;
                } else {
                    $return['sts'] = 'tidak_berhak';
                }
            }
            echo json_encode($return);
        }
    }
    public function simpan_subsidi_silang()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $id_rab = htmlentities($data_receive->id_rab ?? '');
                $id_rab_detail = $data_receive->id_rab_detail;
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');

                #cek apakah admin berhak...
                $this->load->model('survey_lapangan_assesor_model', 'survey_lapangan_assesor');
                $berhak = $this->survey_lapangan_assesor->is_available(array(
                    'active' => 1,
                    'id_admin' => $user_create,
                    'id_opening_meeting' => $id_opening_meeting
                ));
                if ($berhak) { #hapus dulu data subsidi silang...
                    $where = "id_opening_meeting = '" . $id_opening_meeting . "' and jns_item = 'SUBSIDI SILANG' and id_rab_detail IN (select id_rab_detail from rab_detail where id_rab = '" . $id_rab . "')";
                    $this->sppd_item_rab->delete($where);

                    #simpan data satu per satu...
                    for ($i = 0; $i < count($id_rab_detail); $i++) {
                        $data = array(
                            'id_opening_meeting' => $id_opening_meeting,
                            'id_rab_detail' => htmlentities($id_rab_detail[$i] ?? ''),
                            'jns_item' => 'SUBSIDI SILANG',
                            'user_create' => $user_create,
                            'time_create' => $time_create,
                            'time_update' => $time_create,
                            'user_update' => $user_create
                        );
                        $this->sppd_item_rab->save($data);
                    }
                    $return['sts'] = true;
                } else {
                    $return['sts'] = 'tidak_berhak';
                }
            }
            echo json_encode($return);
        }
    }
}
