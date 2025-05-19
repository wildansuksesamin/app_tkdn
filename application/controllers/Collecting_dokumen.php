
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Collecting_dokumen extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('opening_meeting_model', 'opening_meeting');
        $this->load->model('collecting_dokumen_nama_file_model', 'nama_file');
        $this->load->model('kriteria_bpm_model', 'kriteria_bpm');
        $this->load->model("Collecting_dokumen_model", "collecting_dokumen");
        $this->load->model('mst_admin_model', 'mst_admin');
    }

    public function verifikasi_dokumen()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_collecting_dokumen = htmlentities($data_receive->id_collecting_dokumen ?? '');
            $status = htmlentities($data_receive->status ?? '');
            $alasan_verifikasi = htmlentities($data_receive->alasan_verifikasi ?? '');

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_admin = $this->session->userdata('id_admin');

                #cek apakah admin boleh memverifikasi dokumen ini...
                $join[0] = array('tabel' => 'collecting_dokumen', 'relation' => 'collecting_dokumen.id_opening_meeting = opening_meeting.id_opening_meeting', 'direction' => 'left');
                $where = "opening_meeting.active = 1 and id_collecting_dokumen = '" . $id_collecting_dokumen . "' and (id_status >= 7 and id_status < 15) and (id_assesor = '" . $this->session->userdata('id_admin') . "' or opening_meeting.id_opening_meeting IN (select id_opening_meeting from opening_meeting_asisten_assesor where active = 1 and id_admin = '" . $this->session->userdata('id_admin') . "'))";

                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $data = array(
                        'status_verifikasi' => ($status == 'setuju' ? 1 : 2),
                        'alasan_verifikasi' => ($alasan_verifikasi ?? null),
                        'user_update' => $id_admin,
                        'time_update' => date('Y-m-d H:i:s')
                    );
                    $where = array('id_collecting_dokumen' => $id_collecting_dokumen);
                    $exe = $this->collecting_dokumen->update($data, $where);
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'tidak_berhak_akses_data';
                }
            }

            echo json_encode($return);
        }
    }

    public function submit_semua_dokumen()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');

                #cek apakah berhak mengupdate data ini...
                $this->load->model('opening_meeting_model', 'opening_meeting');
                $cek = $this->opening_meeting->is_available(array(
                    'active' => 1,
                    'id_assesor' => $this->session->userdata('id_admin'),
                    'id_opening_meeting' => $id_opening_meeting,
                    '(id_status >= 7 and id_status < 15)' => null
                ));

                if ($cek) {
                    $hasil = $this->load_file_collecting_dokumen($id_opening_meeting);
                    $komplit = $hasil['komplit'];

                    if ($komplit) {
                        #update status ke proses selanjutnya...
                        $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 15);
                        $return['sts'] = $exe;
                    } else {
                        $return['sts'] = 'dokumen_belum_lengkap';
                    }
                } else {
                    $return['sts'] = 'tidak_berhak_ubah_data';
                }

                echo json_encode($return);
            }
        }
    }
    public function verifikasi_perpanjangan_waktu()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $status_verifikasi = htmlentities($data_receive->status_verifikasi ?? '');
                $alasan_verifikasi = htmlentities($data_receive->alasan_verifikasi ?? '');
                $id_status = ($status_verifikasi == 'setuju' ? 14 : 13);

                $where = array(
                    'active' => 1,
                    'id_opening_meeting' => $id_opening_meeting,
                    'id_status' => 12,
                    'id_assesor' => $this->session->userdata('id_admin')
                );
                $data_send = array('where' => $where);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();

                    $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, $id_status, $alasan_verifikasi);
                    if ($exe and $id_status == 14) { #jika disetujui...
                        $tambahan_hari = $alasan_verifikasi;
                        $masa = $opening_meeting->masa_collecting_dokumen + $tambahan_hari;

                        $data = array(
                            'masa_collecting_dokumen' => $masa,
                        );
                        $where = array(
                            'active' => 1,
                            'id_opening_meeting' => $id_opening_meeting,
                            'id_assesor' => $this->session->userdata('id_admin')
                        );
                        $this->opening_meeting->update($data, $where);

                        $this->load->model('surat_penawaran_model', 'surat_penawaran');
                        $where = "id_rab = (select id_rab from rab where rab.active = 1 and id_dokumen_permohonan = (select id_permohonan from opening_meeting where id_opening_meeting = '" . $id_opening_meeting . "'))";
                        $this->surat_penawaran->update($data, $where);
                    }
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'tidak_berhak_ubah_data';
                }
                echo json_encode($return);
            }
        }
    }

    public function proses_penutupan_permohonan()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $alasan_verifikasi = htmlentities($data_receive->alasan_verifikasi ?? '');

                $cek = $this->opening_meeting->is_available(array(
                    'active' => 1,
                    'id_opening_meeting' => $id_opening_meeting,
                    'id_assesor' => $this->session->userdata('id_admin')
                ));
                if ($cek) {

                    $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 99, $alasan_verifikasi);
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'tidak_berhak_ubah_data';
                }
                echo json_encode($return);
            }
        }
    }

    public function proses_tahap_kedua()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');

                #cek apakah berhak mengupdate data ini...
                $this->load->model('opening_meeting_model', 'opening_meeting');
                $cek = $this->opening_meeting->is_available(array(
                    'active' => 1,
                    'id_assesor' => $this->session->userdata('id_admin'),
                    'id_opening_meeting' => $id_opening_meeting,
                    'id_status' => 15
                ));

                if ($cek) {
                    #update status ke proses selanjutnya...
                    $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 16);
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'tidak_berhak_ubah_data';
                }

                echo json_encode($return);
            }
        }
    }


    // public function load_data()
    // {
    //     if ($this->validasi_login()) {
    //         $data_receive = json_decode(urldecode($this->input->post('data_send')));
    //         $token = $data_receive->token;
    //         if ($this->tokenStatus($token, 'LOAD_DATA')) {
    //             $filter = (isset($data_receive->filter) ? $data_receive->filter : null);
    //             $relation[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = collecting_dokumen.id_opening_meeting', 'direction' => 'left');
    //             $relation[1] = array('tabel' => 'collecting_dokumen_nama_file', 'relation' => 'collecting_dokumen_nama_file.id_nama_file = collecting_dokumen.id_nama_file', 'direction' => 'left');


    //             $page = $data_receive->page;
    //             $jml_data = $data_receive->jml_data;

    //             $page = (empty($page) ? 1 : $page);
    //             $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
    //             $start = ($page - 1) * $jml_data;
    //             $limit = $jml_data . ',' . $start;

    //             $where = "collecting_dokumen.active = 1  and opening_meeting.active = 1  and collecting_dokumen_nama_file.active = 1  and (collecting_dokumen.id_collecting_dokumen like '%" . $filter . "%' or collecting_dokumen.id_opening_meeting like '%" . $filter . "%' or collecting_dokumen.id_nama_file like '%" . $filter . "%' or collecting_dokumen.value like '%" . $filter . "%' or collecting_dokumen.status_verifikasi like '%" . $filter . "%' or collecting_dokumen.alasan_evrifikasi like '%" . $filter . "%' or collecting_dokumen.user_create like '%" . $filter . "%' or collecting_dokumen.time_create like '%" . $filter . "%' or collecting_dokumen.time_update like '%" . $filter . "%' or collecting_dokumen.user_update like '%" . $filter . "%' )";
    //             $send_data = array('where' => $where, 'join' => $relation, 'limit' => $limit);
    //             $load_data = $this->collecting_dokumen->load_data($send_data);
    //             $result = $load_data->result();

    //             #find last page...
    //             $select = "count(-1) jml";
    //             $send_data = array('where' => $where, 'join' => $relation, 'select' => $select);
    //             $load_data = $this->collecting_dokumen->load_data($send_data);
    //             $total_data = $load_data->row()->jml;

    //             $last_page = ceil($total_data / $jml_data);
    //             $result = array('result' => $result, 'last_page' => $last_page);

    //             echo json_encode($result);
    //         }
    //     }
    // }

    // public function simpan()
    // {
    //     if ($this->validasi_login()) {
    //         $token = $this->input->post('token');
    //         $return = array();
    //         if ($this->tokenStatus($token, 'SEND_DATA')) {
    //             $id_collecting_dokumen = htmlentities($this->input->post('id_collecting_dokumen') ?? '');
    //             $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
    //             $id_nama_file = htmlentities($this->input->post('id_nama_file') ?? '');
    //             $value = htmlentities($this->input->post('value') ?? '');
    //             $status_verifikasi = htmlentities($this->input->post('status_verifikasi') ?? '');
    //             $alasan_evrifikasi = htmlentities($this->input->post('alasan_evrifikasi') ?? '');
    //             $user_create = $this->session->userdata('id_admin');
    //             $time_create = date('Y-m-d H:i:s');
    //             $time_update = date('Y-m-d H:i:s');
    //             $user_update = $this->session->userdata('id_admin');

    //             $action = htmlentities($this->input->post('action') ?? '');

    //             #jika action memiliki value 'save' maka data akan disimpan.
    //             #jika action tidak memiliki value, maka akan dianggap sebagai upadate.
    //             if ($action == 'save') {
    //                 $data = array(
    //                     'id_opening_meeting' => $id_opening_meeting,
    //                     'id_nama_file' => $id_nama_file,
    //                     'value' => $value,
    //                     'status_verifikasi' => $status_verifikasi,
    //                     'alasan_evrifikasi' => $alasan_evrifikasi,
    //                     'user_create' => $user_create,
    //                     'time_create' => $time_create,
    //                     'time_update' => $time_update,
    //                     'user_update' => $user_update
    //                 );
    //                 $exe = $this->collecting_dokumen->save($data);
    //                 $return['sts'] = $exe;
    //             } else {
    //                 $data = array(
    //                     'id_opening_meeting' => $id_opening_meeting,
    //                     'id_nama_file' => $id_nama_file,
    //                     'value' => $value,
    //                     'status_verifikasi' => $status_verifikasi,
    //                     'alasan_evrifikasi' => $alasan_evrifikasi,
    //                     'time_update' => $time_update,
    //                     'user_update' => $user_update
    //                 );
    //                 $where = array('id_collecting_dokumen' => $id_collecting_dokumen);
    //                 $exe = $this->collecting_dokumen->update($data, $where);
    //                 $return['sts'] = $exe;
    //             }
    //         }

    //         echo json_encode($return);
    //     }
    // }
}
