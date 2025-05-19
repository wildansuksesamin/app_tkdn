
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Collecting_dokumen_tahap2 extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Collecting_dokumen_tahap2_model", "collecting_dokumen_tahap2");
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_admin = $this->session->userdata('id_admin');
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');

                $relation[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = collecting_dokumen_tahap2.id_opening_meeting', 'direction' => 'left');
                $relation[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');

                $where = "collecting_dokumen_tahap2.active = 1  and opening_meeting.active = 1 and opening_meeting.id_opening_meeting = '" . $id_opening_meeting . "' and (opening_meeting.id_assesor = '" . $id_admin . "' or opening_meeting.id_opening_meeting IN (select id_opening_meeting from opening_meeting_asisten_assesor where active = 1 and id_admin = '" . $id_admin . "'))";
                $send_data = array('where' => $where, 'join' => $relation);
                $load_data = $this->collecting_dokumen_tahap2->load_data($send_data);
                $result = $load_data->result();

                $result = array('result' => $result);

                echo json_encode($result);
            }
        }
    }


    public function verifikasi_dokumen()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_collecting_dokumen_2 = $data_receive->id_dokumen;
            $id_admin = $this->session->userdata('id_admin');

            $status_verifikasi = ($data_receive->status_verifikasi == 'setuju' ? 1 : 0);
            $alasan_verifikasi = (isset($data_receive->alasan_verifikasi) ? $data_receive->alasan_verifikasi : '');

            $return = array();
            #cek apakah boleh diupdate status dokumennya...
            $relation[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = collecting_dokumen_tahap2.id_opening_meeting', 'direction' => 'left');
            $relation[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');

            $where = "collecting_dokumen_tahap2.active = 1  and opening_meeting.active = 1 and id_collecting_dokumen_2 = '" . $id_collecting_dokumen_2 . "' and (opening_meeting.id_assesor = '" . $id_admin . "' or opening_meeting.id_opening_meeting IN (select id_opening_meeting from opening_meeting_asisten_assesor where active = 1 and id_admin = '" . $id_admin . "'))";
            $send_data = array('where' => $where, 'join' => $relation);
            $load_data = $this->collecting_dokumen_tahap2->load_data($send_data);
            if ($load_data->num_rows() > 0) {
                $data_update = array(
                    'status_verifikasi' => $status_verifikasi,
                    'alasan_verifikasi' => $alasan_verifikasi
                );
                $where_update = array(
                    'id_collecting_dokumen_2' => $id_collecting_dokumen_2,
                );
                $exe = $this->collecting_dokumen_tahap2->update($data_update, $where_update);
                $return['sts'] = $exe;
            } else {
                $return['sts'] = 'tidak_berhak';
            }

            echo json_encode($return);
        }
    }

    public function lanjut_ke_verifikasi_teknis()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');

                #cek apakah ada dokumen yang belum disetujui semua...
                $where = array('collecting_dokumen_tahap2.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'status_verifikasi !=' => 1);
                $data_send = array('where' => $where);
                $load_data = $this->collecting_dokumen_tahap2->load_data($data_send);
                if ($load_data->num_rows() == 0) {
                    #jika semua sudah disetujui, lanjutkan proses update step...

                    $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 17);
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'dokumen_belum_disetujui';
                }
            }
            echo json_encode($return);
        }
    }
}
