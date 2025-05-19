
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Survey_lapangan_perjab extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("survey_lapangan_perjab_model", "survey_lapangan_perjab");
        $this->load->model('survey_lapangan_assesor_model', 'survey_lapangan_assesor');
    }


    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $from = htmlentities($data_receive->from ?? '');
                $jml_data = htmlentities($data_receive->jml_data ?? '');
                $page = htmlentities($data_receive->page ?? '');
                $filter = (isset($data_receive->filter) ? htmlentities($data_receive->filter ?? '') : null);
                $id_opening_meeting = (isset($data_receive->id_opening_meeting) ? htmlentities($data_receive->id_opening_meeting ?? '') : null);
                $id_jns_admin = $this->session->userdata('id_jns_admin');

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $select = "*, survey_lapangan_perjab.status_verifikasi status_verifikasi_survey_lapangan, survey_lapangan_perjab.alasan_verifikasi alasan_verifikasi_survey_lapangan";

                $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = survey_lapangan_perjab.id_opening_meeting', 'direction' => 'left');
                $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $join[2] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join[3] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                $join[4] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join[5] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');
                $join[6] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
                $join[7] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[8] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');

                $where = "survey_lapangan_perjab.active = 1 and opening_meeting.active = 1";
                if ($from == 'pekerjaan') {
                    $where .= " and opening_meeting.id_opening_meeting = '" . $id_opening_meeting . "'";
                }
                if ($from == 'verifikasi_dokumen') {
                    $status_verifkasi = 'x';
                    if ($id_jns_admin == 4) { #admin TKDN
                        $status_verifkasi = 3;
                    } else if ($id_jns_admin == 2) { #koordinator
                        $status_verifkasi = 2;
                    }
                    $where .= " and survey_lapangan_perjab.status_verifikasi = '" . $status_verifkasi . "' and (
                        nomor_order_payment like '%" . $filter . "%' or
                        sub_unit_kerja like '%" . $filter . "%' or 
                        concat(nama_badan_usaha, ' ', nama_perusahaan) like '%" . $filter . "%'
                    )";
                }


                $send_data = array('select' => $select, 'where' => $where, 'join' => $join, 'limit' => $limit);
                $load_data = $this->survey_lapangan_perjab->load_data($send_data);
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'join' => $join, 'select' => $select);
                $load_data = $this->survey_lapangan_perjab->load_data($send_data);
                $total_data = $load_data->row()->jml;

                $last_page = ceil($total_data / $jml_data);
                $result = array('result' => $result, 'last_page' => $last_page);

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
                $biaya_operasional = htmlentities($this->input->post('biaya_operasional') ?? '');
                $file_surat_tugas = htmlentities($this->input->post('file_surat_tugas') ?? '');
                $file_perjab = htmlentities($this->input->post('file_perjab') ?? '');
                $biaya_operasional = str_replace('.', '', $biaya_operasional);

                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                #cek apakah admin boleh menambahkan data...
                $berhak = $this->survey_lapangan_assesor->is_available(array(
                    'active' => 1,
                    'id_admin' => $user_create,
                    'id_opening_meeting' => $id_opening_meeting
                ));
                if ($berhak) {
                    $allowed_types = 'pdf';

                    $dir = 'assets/uploads/dokumen_survey_lapangan/';

                    #upload file surat tugas...
                    $allow_surat_tugas = false;
                    $file_surat_tugas = null;
                    if (!isset($_FILES['file_surat_tugas'])) {
                        $allow_surat_tugas = true;
                    } else {
                        $var = array(
                            'dir' => $dir, #string, nama folder akhiri dengan /
                            'allowed_types' => $allowed_types, #string => pdf|jpeg|jpg, kosongkan jika boleh upload semua file
                            'file' => 'file_surat_tugas', #string => name dari input type="file"
                            'encrypt_name' => true, #boolean
                            'new_name' => 'Survey Lapangan-Surat Tugas-' . date('YmdHis') . '-' . $this->generateRandomString(5), #string => isi jika ingin merename nama file sesuai kebutuhan. biarkan kosong jika tidak ingin rename.
                        );
                        $hasil_surat_tugas = $this->upload_v2($var);
                        $file_surat_tugas = $var['dir'] . $hasil_surat_tugas['file'];
                        $allow_surat_tugas = $hasil_surat_tugas['sts'];
                    }

                    #upload file perjab....
                    $allow_perjab = false;
                    $file_perjab = null;
                    if (!isset($_FILES['file_perjab'])) {
                        $allow_perjab = true;
                    } else {
                        $var = array(
                            'dir' => $dir, #string, nama folder akhiri dengan /
                            'allowed_types' => $allowed_types, #string => pdf|jpeg|jpg, kosongkan jika boleh upload semua file
                            'file' => 'file_perjab', #string => name dari input type="file"
                            'encrypt_name' => true, #boolean
                            'new_name' => 'Survey Lapangan-Perjab-' . date('YmdHis') . '-' . $this->generateRandomString(5), #string => isi jika ingin merename nama file sesuai kebutuhan. biarkan kosong jika tidak ingin rename.
                        );
                        $hasil_perjab = $this->upload_v2($var);
                        $file_perjab = $var['dir'] . $hasil_perjab['file'];
                        $allow_perjab = $hasil_perjab['sts'];
                    }

                    if (!$allow_surat_tugas) {
                        $return['sts'] = 'upload_error';
                        $return['msg'] = $hasil_surat_tugas['msg'];
                    } else if (!$allow_perjab) {
                        $return['sts'] = 'upload_error';
                        $return['msg'] = $hasil_perjab['msg'];
                    } else {
                        $data = array(
                            'id_opening_meeting' => $id_opening_meeting,
                            'file_surat_tugas' => $file_surat_tugas,
                            'file_perjab' => $file_perjab,
                            'biaya_operasional' => $biaya_operasional,
                            'user_create' => $user_create,
                            'time_create' => $time_create,
                            'time_update' => $time_update,
                            'user_update' => $user_update
                        );
                        $exe = $this->survey_lapangan_perjab->save($data);
                        $return['sts'] = $exe;
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
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_survey_lapangan_perjab = htmlentities($data_receive->id_survey_lapangan_perjab ?? '');
            $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
            $id_admin = $this->session->userdata('id_admin');

            #cek apakah admin boleh menambahkan data...
            $berhak = $this->survey_lapangan_assesor->is_available(array(
                'active' => 1,
                'id_admin' => $id_admin,
                'id_opening_meeting' => $id_opening_meeting
            ));

            $return = array();
            if ($berhak) {
                if ($this->tokenStatus($token, 'SEND_DATA')) {
                    $where = array('id_survey_lapangan_perjab' => $id_survey_lapangan_perjab);
                    $exe = $this->survey_lapangan_perjab->soft_delete($where);
                    $return['sts'] = $exe;
                }
            } else {
                $return['sts'] = 'tidak_berhak';
            }

            echo json_encode($return);
        }
    }

    public function verifikasi_dokumen()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_survey_lapangan_perjab = htmlentities($data_receive->id_survey_lapangan_perjab ?? '');
            $status_verifikasi = htmlentities($data_receive->status_verifikasi ?? '');
            $alasan_verifikasi = htmlentities($data_receive->alasan_verifikasi ?? '');
            $id_admin = $this->session->userdata('id_admin');
            $id_jns_admin = $this->session->userdata('id_jns_admin');

            if ($status_verifikasi == 'setuju') {
                if ($id_jns_admin == 2) { #Koordinator
                    $status_verifikasi = 1;
                } else if ($id_jns_admin == 4) { #admin TKDN
                    $status_verifikasi = 2;
                } else { #unkown
                    $status_verifikasi = 3;
                }
            } else {
                $status_verifikasi = 0;
            }


            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $data = array(
                    'status_verifikasi' => $status_verifikasi,
                    'alasan_verifikasi' => $alasan_verifikasi
                );
                $where = array('id_survey_lapangan_perjab' => $id_survey_lapangan_perjab);
                $exe = $this->survey_lapangan_perjab->update($data, $where);
                $return['sts'] = $exe;
            }


            echo json_encode($return);
        }
    }
}
