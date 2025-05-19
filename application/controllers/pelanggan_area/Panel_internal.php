
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Panel_internal extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('opening_meeting_model', 'opening_meeting');
        $this->load->model('panel_internal_dokumen_model', 'panel_internal_dokumen');
        $this->load->model('panel_internal_nama_file_model', 'panel_internal_nama_file');
        $this->load->model('panel_internal_material_model', 'panel_internal_material');
    }

    public function load_daftar_tanda_sah($from = '')
    {
        if ($this->validasi_login_pelanggan()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');

                if ($from == 'assesor') {
                    $id_nama_file = 1;
                } else {
                    $id_nama_file = 9;
                }

                $select = "*, panel_internal_dokumen.alasan_verifikasi alasan_verifikasi_dokumen";
                $relation[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = panel_internal_dokumen.id_opening_meeting', 'direction' => 'left');
                $relation[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where = "panel_internal_dokumen.active = 1 and opening_meeting.active = 1 and id_nama_file = '" . $id_nama_file . "' and opening_meeting.id_opening_meeting = '" . $id_opening_meeting . "' and id_pelanggan = '" . $this->session->userdata('id_pelanggan') . "'";
                $send_data = array('select' => $select, 'where' => $where, 'join' => $relation);
                $load_data = $this->panel_internal_dokumen->load_data($send_data);
                $result = $load_data->result();

                $result = array('result' => $result);

                echo json_encode($result);
            }
        }
    }

    public function upload_daftar_tanda_sah()
    {
        $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
        $id_nama_file = htmlentities($this->input->post('id_nama_file') ?? '');
        $kolom_tambahan = $this->input->post('kolom_tambahan');

        $id_pelanggan = $this->session->userdata('id_pelanggan');
        $time_create = date('Y-m-d H:i:s');

        #cek apakah pelanggan boleh menambahkan file pada id_opening_meeting yang diberikan...
        $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
        $join[1] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
        $where = "opening_meeting.active = 1 and (id_status >= 22 and id_status <= 23) and dokumen_permohonan.id_pelanggan = '" . $id_pelanggan . "'";

        $data_send = array('where' => $where, 'join' => $join);
        $load_data = $this->opening_meeting->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            $opening_meeting = $load_data->row();

            #ambil data dari id_nama_file
            $where_nama_file = array('panel_internal_nama_file.active' => 1, 'id_nama_file' => $id_nama_file, 'aktor' => 'pelanggan');
            $data_send_nama_file = array('where' => $where_nama_file);
            $load_data_nama_file = $this->panel_internal_nama_file->load_data($data_send_nama_file);
            if ($load_data_nama_file->num_rows() > 0) {
                $nama_file = $load_data_nama_file->row();

                $allow_upload = true;
                #cek apakah boleh upload lagi atau tidak...
                if ($nama_file->multi_file == 0) {
                    #cek apakah sudah ada 1 file atau tidak.. jika masih belum ada file maka boleh upload
                    $where_dokumen = array('panel_internal_dokumen.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_nama_file' => $id_nama_file);
                    $jml_dokumen = $this->panel_internal_dokumen->select_count($where_dokumen);

                    if ($jml_dokumen == 0) {
                        $allow_upload = true;
                    } else {
                        $allow_upload = false;
                        $return['sts'] = 'mencapai_batas_upload';
                    }
                } else {
                    $allow_upload = true;
                }

                if ($allow_upload) {
                    $nama_perusahaan = str_replace(' ', '-', $opening_meeting->nama_perusahaan);
                    #upload file ke server...
                    $var = array(
                        'dir' => 'assets/uploads/dokumen/' . $opening_meeting->id_pelanggan . '/' . 'panel_internal/' . $id_opening_meeting,
                        'allowed_types' => ($nama_file->jns_file ? $nama_file->jns_file : '*'),
                        'file' => 'file',
                        'encrypt_name' => false,
                        'new_name' => strtolower(str_replace(' ', '-', $nama_file->nama_file) . '-' . $nama_perusahaan . '-' . date('YmdHis')) . '-' . $this->generateRandomString(5)
                    );
                    $hasil = $this->upload_v2($var);

                    if ($hasil['sts']) {
                        #simpan ke dalam database...
                        $data = array(
                            'id_opening_meeting' => $id_opening_meeting,
                            'id_nama_file' => $id_nama_file,
                            'value' => $hasil['file'],
                            'path_file' => $var['dir'] . '/' . $hasil['file'],
                            'kolom_tambahan' => $kolom_tambahan,
                            'user_create' => $id_pelanggan,
                            'time_create' => $time_create,
                            'time_update' => $time_create,
                            'user_update' => $id_pelanggan
                        );
                        $exe = $this->panel_internal_dokumen->save($data, $id_pelanggan, 'pelanggan');
                        $return['sts'] = $exe;
                    } else {
                        $return['sts'] = 'upload_error';
                        $return['msg'] = $hasil['msg'];
                    }
                }
            } else {
                $return['sts'] = 'tidak_berhak_akses_data';
            }
        } else {
            $return['sts'] = 'tidak_berhak_akses_data';
        }
        echo json_encode($return);
    }
    public function kirim_assesor()
    {
        if ($this->validasi_login_pelanggan()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_pelanggan = $this->session->userdata('id_pelanggan');
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');

                $allow = true;
                #tampilkan list nama_file yang memiliki id_tipe_permohonan yang sama dengan dokumen permohonan dari id_opening_meeting yang dikirim...
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_tipe_permohonan = panel_internal_nama_file.id_tipe_permohonan', 'direction' => 'left');
                $join[1] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $where = array('panel_internal_nama_file.active' => 1, 'required' => 1, 'opening_meeting.id_opening_meeting' => $id_opening_meeting, 'id_pelanggan' => $id_pelanggan, 'aktor' => 'pelanggan');
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->panel_internal_nama_file->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $row) {
                        #jika dokumen masih kosong, maka dilarang kirim ke Verifikator...
                        $where_dokumen = array('panel_internal_dokumen.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_nama_file' => $row->id_nama_file);
                        $data_send_dokumen = array('where' => $where_dokumen);
                        $load_data_dokumen = $this->panel_internal_dokumen->load_data($data_send_dokumen);
                        if ($load_data_dokumen->num_rows() == 0) {
                            $allow = false;
                        }

                        #jika ada dokumen yang masih ditolak, maka dilarang kirim ke Verifikator
                        $where_dokumen['status_verifikasi'] = 0;
                        $data_send_dokumen = array('where' => $where_dokumen);
                        $load_data_dokumen = $this->panel_internal_dokumen->load_data($data_send_dokumen);
                        if ($load_data_dokumen->num_rows() > 0) {
                            $allow = false;
                        }
                    }
                } else {
                    $allow = false;
                }

                if ($allow) {
                    $step = 24;

                    $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, $step);
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'dokumen_belum_lengkap';
                }
            }

            echo json_encode($return);
        }
    }
    public function hapus_file()
    {
        if ($this->validasi_login_pelanggan()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $id_panel_internal_dokumen = htmlentities($data_receive->id_panel_internal_dokumen ?? '');
                $id_pelanggan = $this->session->userdata('id_pelanggan');

                #cek apakah pelanggan berhak melakukan pengahapusan data...
                $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = panel_internal_dokumen.id_opening_meeting', 'direction' => 'left');
                $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where = array(
                    'id_panel_internal_dokumen' => $id_panel_internal_dokumen,
                    'panel_internal_dokumen.id_opening_meeting' => $id_opening_meeting,
                    'id_pelanggan' => $id_pelanggan,
                    'opening_meeting.id_status in (22,23)' => null,
                    'status_verifikasi in (0,2)' => null,
                );
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->panel_internal_dokumen->load_data($data_send);
                if ($load_data->num_rows() > 0) {

                    #hapus list bahan bakunya...
                    $this->panel_internal_material->soft_delete(array(
                        'id_panel_internal_dokumen' => $id_panel_internal_dokumen
                    ), $id_pelanggan, 'pelanggan');

                    #hapus dokumennya...
                    $exe = $this->panel_internal_dokumen->soft_delete(array(
                        'id_panel_internal_dokumen' => $id_panel_internal_dokumen,
                        'id_opening_meeting' => $id_opening_meeting,
                        'status_verifikasi in (0,2)' => null,
                    ), $id_pelanggan, 'pelanggan');

                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'tidak_berhak_hapus_data';
                }
            }

            echo json_encode($return);
        }
    }
}
