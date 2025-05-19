
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Panel_internal extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('opening_meeting_model', 'opening_meeting');
        $this->load->model('panel_internal_lhv_model', 'panel_internal_lhv');
        $this->load->model('panel_internal_dokumen_model', 'panel_internal_dokumen');
        $this->load->model('panel_internal_nama_file_model', 'panel_internal_nama_file');
        $this->load->model('panel_internal_material_model', 'panel_internal_material');
    }

    public function load_folder()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_jns_admin = $this->session->userdata('id_jns_admin');
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');

                $relation[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $relation[1] = array('tabel' => 'panel_internal_nama_file', 'relation' => 'panel_internal_nama_file.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');

                $where = array('opening_meeting.active' => 1, 'opening_meeting.id_opening_meeting' => $id_opening_meeting, 'aktor != ' => 'pelanggan'); #show active data...
                if (isset($data_receive->id_nama_file)) {
                    $id_nama_file = htmlentities($data_receive->id_nama_file ?? '');

                    $where['id_nama_file'] = $id_nama_file;
                }
                $order = "urutan asc";
                $send_data = array('where' => $where, 'join' => $relation, 'order' => $order);
                $load_data = $this->opening_meeting->load_data($send_data);

                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $row) {
                    }
                }
                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $row) {

                        if ($row->referensi == 'lhv') {
                            $where_lhv = array('panel_internal_lhv.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
                            $data_send_lhv = array('where' => $where_lhv);
                            $load_data_lhv = $this->panel_internal_lhv->load_data($data_send_lhv);
                            if ($load_data_lhv->num_rows() > 0) {
                                $jml_setuju = 0;
                                $jml_tolak = 0;
                                $jml_menunggu = 0;
                                foreach ($load_data_lhv->result() as $list) { #mencari status dokumen...
                                    if ($list->status_verifikasi == 1) {
                                        $jml_setuju++;
                                    } else if ($list->status_verifikasi == 0) {
                                        $jml_tolak++;
                                    } else if ($list->status_verifikasi == 2) {
                                        $jml_menunggu++;
                                    }
                                }

                                if ($id_jns_admin == 2) { #khusus koordiantor...
                                    if ($jml_setuju == $load_data_lhv->num_rows()) {
                                        $row->dokumen_status = array('Disetujui', 'light-success py-3 px-4 fs-7 ');
                                    } else if ($jml_menunggu > 0) {
                                        $row->dokumen_status = array(($row->id_status == 19 ? 'Menunggu Verifikasi' : 'Dalam Proses'), 'light-primary py-3 px-4 fs-7 ');
                                    } else if ($jml_menunggu == 0 and $jml_tolak > 0) {
                                        $row->dokumen_status = array('Ditolak', 'light-danger py-3 px-4 fs-7 ');
                                    }
                                } else {
                                    if ($jml_setuju == $load_data_lhv->num_rows()) {
                                        $row->dokumen_status = array('Disetujui', 'light-success py-3 px-4 fs-7 ');
                                    } else if ($jml_tolak > 0) {
                                        $row->dokumen_status = array('Ditolak', 'light-danger py-3 px-4 fs-7 ');
                                    } else {
                                        $row->dokumen_status = array(($row->id_status == 19 ? 'Menunggu Verifikasi' : 'Dalam Proses'), 'light-primary py-3 px-4 fs-7 ');
                                    }
                                }
                            } else {
                                $row->dokumen_status = array('Folder Kosong', 'secondary py-3 px-4 fs-7 ');
                            }
                            $row->files = $load_data_lhv->result();
                        } else {
                            #cari filenya...
                            $where_dokumen = array('panel_internal_dokumen.active' => 1, 'id_nama_file' => $row->id_nama_file, 'id_opening_meeting' => $id_opening_meeting);
                            $data_send_dokumen = array('where' => $where_dokumen);
                            $load_data_dokumen = $this->panel_internal_dokumen->load_data($data_send_dokumen);
                            if ($load_data_dokumen->num_rows() > 0) {
                                $jml_setuju = 0;
                                $jml_tolak = 0;
                                $jml_menunggu = 0;
                                foreach ($load_data_dokumen->result() as $list) {
                                    #mencari status dokumen...
                                    if ($list->status_verifikasi == 1) {
                                        $jml_setuju++;
                                    } else if ($list->status_verifikasi == 0) {
                                        $jml_tolak++;
                                    } else if ($list->status_verifikasi == 2) {
                                        $jml_menunggu++;
                                    }
                                }

                                if ($id_jns_admin == 2) { #khusus koordiantor...
                                    if ($jml_setuju == $load_data_dokumen->num_rows()) {
                                        $row->dokumen_status = array('Disetujui', 'light-success py-3 px-4 fs-7 ');
                                    } else if ($jml_menunggu > 0) {
                                        $row->dokumen_status = array(($row->id_status == 19 ? 'Menunggu Verifikasi' : 'Dalam Proses'), 'light-primary py-3 px-4 fs-7 ');
                                    } else if ($jml_menunggu == 0 and $jml_tolak > 0) {
                                        $row->dokumen_status = array('Ditolak', 'light-danger py-3 px-4 fs-7 ');
                                    }
                                } else {
                                    if ($jml_setuju == $load_data_dokumen->num_rows()) {
                                        $row->dokumen_status = array('Disetujui', 'light-success py-3 px-4 fs-7 ');
                                    } else if ($jml_tolak > 0) {
                                        $row->dokumen_status = array('Ditolak', 'light-danger py-3 px-4 fs-7 ');
                                    } else {
                                        $row->dokumen_status = array(($row->id_status == 19 ? 'Menunggu Verifikasi' : 'Dalam Proses'), 'light-primary py-3 px-4 fs-7 ');
                                    }
                                }
                            } else {
                                $row->dokumen_status = array('Folder Kosong', 'secondary py-3 px-4 fs-7 ');
                            }

                            $row->files = $load_data_dokumen->result();
                        }
                    }
                }
                $result = $load_data->result();

                echo json_encode($result);
            }
        }
    }

    public function upload_file()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
                $id_nama_file = htmlentities($this->input->post('id_nama_file') ?? '');
                $kolom_tambahan = $this->input->post('kolom_tambahan');

                $id_admin = $this->session->userdata('id_admin');
                $id_jns_admin = $this->session->userdata('id_jns_admin');
                $time_create = date('Y-m-d H:i:s');

                #cek apakah Verifikator boleh menambahkan file pada id_opening_meeting yang diberikan...
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where = "opening_meeting.active = 1 and (id_status >= 17 and id_status <= 18)";

                if ($id_jns_admin == 3) {
                    $where .= " and id_opening_meeting IN (select id_opening_meeting from survey_lapangan_assesor a where a.active = 1 and a.id_admin = '" . $id_admin . "' and a.id_opening_meeting = '" . $id_opening_meeting . "')";
                } else if ($id_jns_admin == 4) {
                    $where .= " and id_opening_meeting = '" . $id_opening_meeting . "'";
                } else {
                    $where .= " and id_opening_meeting = 'xxx'"; #ini gunanya untuk mencegah jenis admin lain ikut upload...
                }

                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();

                    #ambil data dari id_nama_file
                    $where_nama_file = array('panel_internal_nama_file.active' => 1, 'id_nama_file' => $id_nama_file);
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
                            #upload file ke server...
                            $var = array(
                                'dir' => 'assets/uploads/dokumen/' . $opening_meeting->id_pelanggan . '/' . 'panel_internal/' . $id_opening_meeting,
                                'allowed_types' => ($nama_file->jns_file ? $nama_file->jns_file : '*'),
                                'file' => 'file',
                                'encrypt_name' => false,
                                'new_name' => strtolower(str_replace(' ', '-', $nama_file->nama_file)) . '-' . date('YmdHis') . $this->generateRandomString(3)
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
                                    'user_create' => $id_admin,
                                    'time_create' => $time_create,
                                    'time_update' => $time_create,
                                    'user_update' => $id_admin
                                );
                                $exe = $this->panel_internal_dokumen->save($data);
                                $return['sts'] = $exe;

                                if ($exe) {
                                    $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 18);
                                }
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
            }

            echo json_encode($return);
        }
    }

    public function hapus_file()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $id_panel_internal_dokumen = htmlentities($data_receive->id_panel_internal_dokumen ?? '');

                #cek apakah Verifikator berhak melakukan pengahapusan data...
                $cek = $this->panel_internal_dokumen->is_available(
                    array(
                        'id_panel_internal_dokumen' => $id_panel_internal_dokumen,
                        'id_opening_meeting' => $id_opening_meeting,
                        'status_verifikasi in (0,2)' => null,
                    )
                );

                #jika data yang dimaksud ada, maka boleh hapus...
                if ($cek) {
                    #hapus list bahan bakunya...
                    $this->panel_internal_material->soft_delete(array(
                        'id_panel_internal_dokumen' => $id_panel_internal_dokumen
                    ));

                    #hapus dokumennya...
                    $exe = $this->panel_internal_dokumen->soft_delete(array(
                        'id_panel_internal_dokumen' => $id_panel_internal_dokumen,
                        'id_opening_meeting' => $id_opening_meeting,
                        'status_verifikasi in (0,2)' => null,
                    ));

                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'tidak_berhak_hapus_data';
                }
            }

            echo json_encode($return);
        }
    }

    public function load_lhv()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');

                $where = array('panel_internal_lhv.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
                $data_send = array('where' => $where);
                $load_data = $this->panel_internal_lhv->load_data($data_send);
                $result = $load_data->result();

                echo json_encode($result);
            }
        }
    }

    public function simpan_lhv()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
                $id_panel_internal_lhv = htmlentities($this->input->post('id_panel_internal_lhv') ?? '');
                $lhv_jns_produk = htmlentities($this->input->post('lhv_jns_produk') ?? '');
                $lhv_spesifikasi = htmlentities($this->input->post('lhv_spesifikasi') ?? '');
                $lhv_tipe = htmlentities($this->input->post('lhv_tipe') ?? '');

                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');


                if (!$id_panel_internal_lhv) {
                    $data = array(
                        'id_opening_meeting' => $id_opening_meeting,
                        'lhv_jns_produk' => $lhv_jns_produk,
                        'lhv_spesifikasi' => $lhv_spesifikasi,
                        'lhv_tipe' => $lhv_tipe,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $hasil = $this->panel_internal_lhv->save_with_autoincrement($data);
                    $exe = $hasil[0];
                    $id_panel_internal_lhv = $hasil[1];
                } else {
                    $data = array(
                        'lhv_jns_produk' => $lhv_jns_produk,
                        'lhv_spesifikasi' => $lhv_spesifikasi,
                        'lhv_tipe' => $lhv_tipe,
                        'status_verifikasi' => 2,
                        'alasan_verifikasi' => null,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where = array(
                        'id_opening_meeting' => $id_opening_meeting,
                        'id_panel_internal_lhv' => $id_panel_internal_lhv
                    );
                    $exe = $this->panel_internal_lhv->update($data, $where);
                }

                $return['sts'] = $exe;
                $return['id_panel_internal_lhv'] = $id_panel_internal_lhv;
            }

            echo json_encode($return);
        }
    }

    public function hapus_lhv()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $id_panel_internal_lhv = htmlentities($data_receive->id_panel_internal_lhv ?? '');

                #cek apakah Verifikator berhak melakukan pengahapusan data...
                $cek = $this->panel_internal_lhv->is_available(
                    array(
                        'id_panel_internal_lhv' => $id_panel_internal_lhv,
                        'id_opening_meeting' => $id_opening_meeting,
                        'status_verifikasi in (0,2)' => null,
                    )
                );


                #jika data yang dimaksud ada, maka boleh hapus...
                if ($cek) {
                    #hapus file gambarnya...
                    $this->panel_internal_dokumen->soft_delete(array(
                        'id_panel_internal_lhv' => $id_panel_internal_lhv
                    ));

                    #hapus list bahan bakunya...
                    $this->panel_internal_material->soft_delete(array(
                        'id_panel_internal_lhv' => $id_panel_internal_lhv
                    ));

                    #hapus lhvnya...
                    $exe = $this->panel_internal_lhv->soft_delete(array(
                        'id_panel_internal_lhv' => $id_panel_internal_lhv,
                        'id_opening_meeting' => $id_opening_meeting,
                        'status_verifikasi in (0,2)' => null,
                    ));

                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'tidak_berhak_hapus_data';
                }
            }

            echo json_encode($return);
        }
    }

    public function load_foto_lhv()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $id_panel_internal_lhv = htmlentities($data_receive->id_panel_internal_lhv ?? '');
                $id_nama_file = htmlentities($data_receive->id_nama_file ?? '');

                $where = array('panel_internal_dokumen.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_panel_internal_lhv' => $id_panel_internal_lhv, 'id_nama_file' => $id_nama_file);
                $data_send = array('where' => $where);
                $load_data = $this->panel_internal_dokumen->load_data($data_send);
                $result = $load_data->result();

                echo json_encode($result);
            }
        }
    }
    public function simpan_foto_lhv()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {

                $id_panel_internal_dokumen = htmlentities($this->input->post('id_panel_internal_dokumen') ?? '');
                $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
                $id_panel_internal_lhv = htmlentities($this->input->post('id_panel_internal_lhv') ?? '');
                $id_nama_file = htmlentities($this->input->post('id_nama_file') ?? '');
                $group_file = htmlentities($this->input->post('group_file') ?? '');
                $judul_foto = htmlentities($this->input->post('judul_foto') ?? '');
                $foto_blob = $this->input->post('foto_blob');
                $id_admin = $this->session->userdata('id_admin');
                $id_jns_admin = $this->session->userdata('id_jns_admin');
                $time_create = date('Y-m-d H:i:s');

                #cek apakah Verifikator boleh menambahkan file pada id_opening_meeting yang diberikan...
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where = "opening_meeting.active = 1 and (id_status >= 17 and id_status <= 18)";

                if ($id_jns_admin == 3) {
                    $where .= " and id_opening_meeting IN (select id_opening_meeting from survey_lapangan_assesor a where a.active = 1 and a.id_admin = '" . $id_admin . "' and a.id_opening_meeting = '" . $id_opening_meeting . "')";
                } else if ($id_jns_admin == 4) {
                    $where .= " and id_opening_meeting = '" . $id_opening_meeting . "'";
                } else {
                    $where .= " and id_opening_meeting = 'xxx'"; #ini gunanya untuk mencegah jenis admin lain ikut upload...
                }

                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();

                    #upload foto...
                    $file_foto = '';
                    if ($foto_blob != '') {
                        $new_name = date('ymdHis') . '_' . $this->generateRandomString(5);
                        $output = 'assets/uploads/dokumen/' . $opening_meeting->id_pelanggan . '/' . 'panel_internal/' . $id_opening_meeting . '/';
                        $filename = $new_name . '.jpg';
                        $file_foto = $this->base64_to_file($foto_blob, $output, $filename);

                        #crop image menjadi ukuran 200px x 200px...
                        $file_foto_crop = $output . 'crop_' . $filename;
                        $this->cropImage($file_foto, $file_foto_crop, 400, 400);
                        $file_foto = $file_foto_crop;
                    }

                    if ($id_panel_internal_dokumen) {
                        #jika ada id_panel_internal_dokumen maka actionnya adalah update...
                        $data = array(
                            'value' => $judul_foto,
                            'time_update' => $time_create,
                            'user_update' => $id_admin

                        );
                        if ($file_foto) {
                            $data['path_file'] = $file_foto;
                        }
                        $where = array('id_panel_internal_dokumen' => $id_panel_internal_dokumen);
                        $return['sts'] = $this->panel_internal_dokumen->update($data, $where);
                    } else {
                        #jika tidak ada id_panel_internal_dokumen, actionnya simpan...

                        $data = array(
                            'id_opening_meeting' => $id_opening_meeting,
                            'id_panel_internal_lhv' => $id_panel_internal_lhv,
                            'id_nama_file' => $id_nama_file,
                            'group_file' => $group_file,
                            'value' => $judul_foto,
                            'path_file' => $file_foto,
                            'status_verifikasi' => 1, #status verifikasi langsung disetujui karena status foto akan mengikuti dokumen LHVnya...
                            'user_create' => $id_admin,
                            'time_create' => $time_create,
                            'time_update' => $time_create,
                            'user_update' => $id_admin

                        );
                        $return['sts'] = $this->panel_internal_dokumen->save($data);
                    }

                    #update status lhv menjadi menunggu verifikasi...
                    $data_lhv = array('status_verifikasi' => 2, 'alasan_verifikasi' => null);
                    $where_lhv = array('id_panel_internal_lhv' => $id_panel_internal_lhv);
                    $this->panel_internal_lhv->update($data_lhv, $where_lhv);
                } else {
                    $return['sts'] = 'tidak_berhak_akses_data';
                }
            }

            echo json_encode($return);
        }
    }
    public function hapus_foto_lhv()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_panel_internal_dokumen = htmlentities($data_receive->id_panel_internal_dokumen ?? '');

                $exe = $this->panel_internal_dokumen->soft_delete(array(
                    'id_panel_internal_dokumen' => $id_panel_internal_dokumen
                ));

                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }

    public function pilih_assesment()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $id_panel_internal_lhv = htmlentities($data_receive->id_panel_internal_lhv ?? '');
                $id_panel_internal_dokumen = htmlentities($data_receive->id_panel_internal_dokumen ?? '');

                #load file assesmentnya...
                $where = array('panel_internal_dokumen.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_panel_internal_dokumen' => $id_panel_internal_dokumen);
                $data_send = array('where' => $where);
                $load_data = $this->panel_internal_dokumen->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $file = $load_data->row();

                    #Sheet Form 1.1
                    $start_row = 17;
                    $end_row = 999999;
                    $start_column = 'A';
                    $end_column = 'G';
                    $this->reader = new ExcelReader();
                    $result = $this->reader->read($file->path_file, 0, $start_row, $end_row, $start_column, $end_column);

                    for ($i = $start_row; $i <= $end_row; $i++) {
                        if (!isset($result[$i]['B']) or strtoupper($result[$i]['B']) == 'TOTAL') break;

                        $bahan_baku = htmlentities($result[$i]['B'] ?? '');
                        $negara = htmlentities($result[$i]['F'] ?? '');
                        $produsen = htmlentities($result[$i]['G'] ?? '');

                        #simpan bahan baku
                        $data = array(
                            'id_panel_internal_lhv' => $id_panel_internal_lhv,
                            'id_panel_internal_dokumen' => $id_panel_internal_dokumen,
                            'bahan_baku' => $bahan_baku,
                            'negara' => ($negara ? $negara : 'NIHIL'),
                            'produsen' => $produsen,
                        );
                        $this->panel_internal_material->save($data);

                        #simpan bahan baku sebagai foto...
                        $data_foto = array(
                            'id_opening_meeting' => $id_opening_meeting,
                            'id_panel_internal_lhv' => $id_panel_internal_lhv,
                            'id_nama_file' => 3, #id_nama_file = 3 adalah LHV. Lihat di tabel panel_internal_nama_file...
                            'group_file' => 'foto_bahan_baku',
                            'value' => $bahan_baku,
                            'status_verifikasi' => 1, #status verifikasi langsung disetujui karena status foto akan mengikuti dokumen LHVnya...
                        );
                        $this->panel_internal_dokumen->save($data_foto);
                    }

                    #Sheet Form 1.6
                    $start_row = 17;
                    $end_row = 999999;
                    $start_column = 'B';
                    $end_column = 'B';
                    $this->reader = new ExcelReader();
                    $result = $this->reader->read($file->path_file, 5, $start_row, $end_row, $start_column, $end_column);
                    for ($i = $start_row; $i <= $end_row; $i++) {
                        if (!isset($result[$i]['B']) or strtoupper($result[$i]['B']) == 'TOTAL') break;

                        $mesin_alat_kerja = htmlentities($result[$i]['B'] ?? '');

                        #simpan mesin alat kerja sebagai foto...
                        $data_foto = array(
                            'id_opening_meeting' => $id_opening_meeting,
                            'id_panel_internal_lhv' => $id_panel_internal_lhv,
                            'id_nama_file' => 3, #id_nama_file = 3 adalah LHV. Lihat di tabel panel_internal_nama_file...
                            'group_file' => 'foto_alat_kerja',
                            'value' => $mesin_alat_kerja,
                            'status_verifikasi' => 1, #status verifikasi langsung disetujui karena status foto akan mengikuti dokumen LHVnya...
                        );
                        $this->panel_internal_dokumen->save($data_foto);
                    }

                    #update status lhv menjadi menunggu verifikasi...
                    $data_lhv = array('status_verifikasi' => 2, 'alasan_verifikasi' => null);
                    $where_lhv = array('id_panel_internal_lhv' => $id_panel_internal_lhv);
                    $exe = $this->panel_internal_lhv->update($data_lhv, $where_lhv);

                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'file_tidak_ditemukan';
                }
            }

            echo json_encode($return);
        }
    }

    public function load_bahan_baku()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_panel_internal_lhv = htmlentities($data_receive->id_panel_internal_lhv ?? '');

                $where = array('panel_internal_material.active' => 1, 'id_panel_internal_lhv' => $id_panel_internal_lhv);
                $data_send = array('where' => $where);
                $load_data = $this->panel_internal_material->load_data($data_send);
                $result = $load_data->result();

                echo json_encode($result);
            }
        }
    }
    public function kirim_koordinator()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_admin = $this->session->userdata('id_admin');
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');

                $allow = true;
                #tampilkan list nama_file yang memiliki id_tipe_permohonan yang sama dengan dokumen permohonan dari id_opening_meeting yang dikirim...
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_tipe_permohonan = panel_internal_nama_file.id_tipe_permohonan', 'direction' => 'left');
                $join[1] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $where = array('panel_internal_nama_file.active' => 1, 'required' => 1, 'opening_meeting.id_opening_meeting' => $id_opening_meeting, 'aktor != ' => 'pelanggan');
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->panel_internal_nama_file->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $row) {
                        #jika ada dokumen yang ditolak, maka dilarang kirim ke koordinator
                        $where_dokumen = array('panel_internal_dokumen.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_nama_file' => $row->id_nama_file);
                        $data_send_dokumen = array('where' => $where_dokumen);
                        $load_data_dokumen = $this->panel_internal_dokumen->load_data($data_send_dokumen);
                        if ($load_data_dokumen->num_rows() > 0) {
                            foreach ($load_data_dokumen->result() as $row) {
                                if ($row->status_verifikasi == 0) {
                                    $allow = false;
                                }
                            }
                        } else {
                            #jika ada folder dokumen yang belum diisi, filenya masih kosong, maka dilarang kirim ke koordinator... 
                            $allow = false;
                        }
                    }
                }

                if ($allow) {
                    #cek hak akses executor apakah diperbolehkan...
                    $relation[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                    $where = "opening_meeting.active = 1 and (id_status >= 17 and id_status <= 18) and id_opening_meeting IN (select id_opening_meeting from survey_lapangan_assesor a where a.active = 1 and a.id_admin = '" . $id_admin . "' and a.id_opening_meeting = '" . $id_opening_meeting . "')";

                    $data_send = array('where' => $where, 'join' => $relation);
                    $load_data = $this->opening_meeting->load_data($data_send);
                    if ($load_data->num_rows() > 0) {

                        $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 19);
                        $return['sts'] = $exe;
                    } else {
                        $return['sts'] = 'tidak_berhak_ubah_data';
                    }
                } else {
                    $return['sts'] = 'dokumen_belum_lengkap';
                }
            }

            echo json_encode($return);
        }
    }

    public function verifikasi_dokumen()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $from = htmlentities($data_receive->from ?? '');
                $id = htmlentities($data_receive->id ?? '');
                $status_verifikasi = htmlentities($data_receive->status_verifikasi ?? '');
                $alasan_verifikasi = htmlentities($data_receive->alasan_verifikasi ?? '');

                if ($status_verifikasi == 'setuju') {
                    $status_verifikasi = 1;
                    $alasan_verifikasi = null;
                } else {
                    $status_verifikasi = 0;
                }

                if ($from == 'panel_internal_dokumen') {
                    $data = array(
                        'status_verifikasi' => $status_verifikasi,
                        'alasan_verifikasi' => $alasan_verifikasi,
                        'time_update' => date('Y-m-d H:i:s'),
                        'user_update' => $this->session->userdata('id_admin'),
                    );
                    $where = array(
                        'id_panel_internal_dokumen' => $id
                    );
                    $exe = $this->panel_internal_dokumen->update($data, $where);
                } else {
                    $data = array(
                        'status_verifikasi' => $status_verifikasi,
                        'alasan_verifikasi' => $alasan_verifikasi,
                        'time_update' => date('Y-m-d H:i:s'),
                        'user_update' => $this->session->userdata('id_admin'),
                    );
                    $where = array(
                        'id_panel_internal_lhv' => $id
                    );
                    $exe = $this->panel_internal_lhv->update($data, $where);
                }

                $return['sts'] = $exe;
            }
            echo json_encode($return);
        }
    }

    public function lanjutan_proses_draft_tanda_sah()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_admin = $this->session->userdata('id_admin');
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $action = htmlentities($data_receive->action ?? '');

                if ($action == 'tanda_sah_tolak') {
                    $id_step = 23;
                } else {
                    $id_step = 25;
                }

                $allow = true;
                $menunggu = 0;
                $tolak = 0;
                $setuju = 0;

                $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = panel_internal_dokumen.id_opening_meeting', 'direction' => 'left');
                $where = array('panel_internal_dokumen.active' => 1, 'opening_meeting.id_opening_meeting' => $id_opening_meeting, 'opening_meeting.id_status' => 24, 'id_nama_file' => 9);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->panel_internal_dokumen->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $row) {
                        if ($row->status_verifikasi == 1) {
                            $setuju++;
                        } else if ($row->status_verifikasi == 0) {
                            $tolak++;
                        } else {
                            $menunggu++;
                        }
                    }

                    #cek apakah boleh lanjut...
                    if ($menunggu > 0) {
                        #jika masih ada dokumen yg statusnya menunggu artinya belum semuanya diverifikasi.
                        #maka jangan boleh melanjutkan ke proses pengembalian pelanggan atau lanjut ke QC...
                        $allow = false;
                        $return['sts'] = 'belum_verifikasi_semua';
                    } else {
                        if ($action == 'assesment_kemenperin' and $tolak > 0) {
                            #jika action mau lanjut ke QC kemenperin tapi masih ada dokumen yang ditolak,
                            #maka jangan boleh melanjutkan proses...
                            $allow = false;
                            $return['sts'] = 'tidak_berhak_ubah_data';
                        } else if ($action == 'tanda_sah_tolak' and $tolak == 0) {
                            #jika action ingin kembali ke pelanggan tapi tidak ada dokumen yang ditolak,
                            #maka jangan boleh melanjutkan proses...
                            $allow = false;
                            $return['sts'] = 'tidak_berhak_ubah_data';
                        }
                    }
                } else {
                    $allow = false;
                }


                if ($allow) {
                    $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, $id_step);
                    $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }

    public function kirim_assesor()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_admin = $this->session->userdata('id_admin');
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');

                $allow = true;
                #tampilkan list nama_file yang memiliki id_tipe_permohonan yang sama dengan dokumen permohonan dari id_opening_meeting yang dikirim...
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_tipe_permohonan = panel_internal_nama_file.id_tipe_permohonan', 'direction' => 'left');
                $join[1] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $where = array('panel_internal_nama_file.active' => 1, 'required' => 1, 'opening_meeting.id_opening_meeting' => $id_opening_meeting, 'aktor != ' => 'pelanggan');
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->panel_internal_nama_file->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $row) {
                        #jika ada dokumen yang belum diverifikasi, maka dilarang kirim ke Verifikator
                        $where_dokumen = array('panel_internal_dokumen.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_nama_file' => $row->id_nama_file, 'status_verifikasi' => 2);
                        $data_send_dokumen = array('where' => $where_dokumen);
                        $load_data_dokumen = $this->panel_internal_dokumen->load_data($data_send_dokumen);
                        if ($load_data_dokumen->num_rows() > 0) {
                            $allow = false;
                        }

                        #jika ada lhv yang belum diverifkasi, maka dilarang kirim ke Verifikator...
                        $where_dokumen = array('panel_internal_lhv.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'status_verifikasi' => 2);
                        $data_send_dokumen = array('where' => $where_dokumen);
                        $load_data_dokumen = $this->panel_internal_lhv->load_data($data_send_dokumen);
                        if ($load_data_dokumen->num_rows() > 0) {
                            $allow = false;
                        }
                    }
                }

                if ($allow) {
                    #semua dokumen sudah melalui proses verifikasi...
                    #kemudian, cek apakah dokumen ada yang ditolak atau tidak...
                    $ditolak = false;
                    $where_dokumen = array('panel_internal_dokumen.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'status_verifikasi' => 0);
                    $data_send_dokumen = array('where' => $where_dokumen);
                    $load_data_dokumen = $this->panel_internal_dokumen->load_data($data_send_dokumen);
                    if ($load_data_dokumen->num_rows() > 0) {
                        $ditolak = true;
                    }

                    #jika ada lhv yang belum diverifkasi, maka dilarang kirim ke Verifikator...
                    $where_dokumen = array('panel_internal_lhv.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'status_verifikasi' => 0);
                    $data_send_dokumen = array('where' => $where_dokumen);
                    $load_data_dokumen = $this->panel_internal_lhv->load_data($data_send_dokumen);
                    if ($load_data_dokumen->num_rows() > 0) {
                        $ditolak = true;
                    }

                    if ($ditolak) {
                        $step = 18; #mundurkan dan kembalikan ke asessor untuk proses perbaikan dokumen...
                    } else {
                        $step = 20; #jika tidak ditolak, lanjutkan ke tahap selanjutnya...
                    }

                    $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, $step);
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'belum_verifikasi_semua';
                }
            }

            echo json_encode($return);
        }
    }

    public function dokumen_lhv($id_panel_internal_lhv = '')
    {
        if ($this->validasi_login() and $id_panel_internal_lhv) {
            $id_panel_internal_lhv = htmlentities($id_panel_internal_lhv ?? '');

            $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = panel_internal_lhv.id_opening_meeting', 'direction' => 'left');
            $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
            $join[2] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
            $join[3] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
            $where = array('panel_internal_lhv.active' => 1, 'id_panel_internal_lhv' => $id_panel_internal_lhv);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->panel_internal_lhv->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $lhv = $load_data->row();
                $perusahaan = $lhv->nama_badan_usaha . ' ' . $lhv->nama_perusahaan;

                #load bahan baku...
                $bahan_baku = '';
                $where_material = array('panel_internal_material.active' => 1, 'id_panel_internal_lhv' => $id_panel_internal_lhv);
                $data_send_material = array('where' => $where_material);
                $load_data_material = $this->panel_internal_material->load_data($data_send_material);
                if ($load_data_material->num_rows() > 0) {
                    $no = 1;
                    foreach ($load_data_material->result() as $row) {
                        $bahan_baku .= '<tr>
                            <td>' . $no . '</td>
                            <td>' . $row->bahan_baku . '</td>
                            <td style="text-align: center">' . $row->negara . '</td>
                            <td>' . $row->produsen . '</td>
                        </tr>';

                        $no++;
                    }
                }

                #load foto2...
                $group = array('foto_perusahaan', 'foto_alat_kerja', 'foto_bahan_baku', 'foto_produk');
                $album_foto = array();
                for ($i = 0; $i < count($group); $i++) {
                    $where_foto = array('panel_internal_dokumen.active' => 1, 'id_panel_internal_lhv' => $id_panel_internal_lhv, 'group_file' => $group[$i]);
                    $where_foto = "panel_internal_dokumen.active = 1 and id_panel_internal_lhv = '" . $id_panel_internal_lhv . "' and group_file = '" . $group[$i] . "' and (path_file != '' and path_file IS NOT NULL)";
                    $data_send_foto = array('where' => $where_foto);
                    $load_data_foto = $this->panel_internal_dokumen->load_data($data_send_foto);
                    $foto = '';
                    if ($load_data_foto->num_rows() > 0) {
                        $kolom = 2;
                        $loop = 1;
                        $rangkai_nama = '';
                        foreach ($load_data_foto->result() as $row) {
                            if ($loop == 1) {
                                $foto .= '<tr>';
                            }

                            $foto .= '<td style="text-align: center; border: 1px solid #000;"><img src="' . base_url() . $row->path_file . '" style="height: 200px; width: 200px; object-fit:cover;"></td>';
                            $rangkai_nama .= '<td style="text-align: center; border: 1px solid #000;">' . $row->value . '</td>';
                            if ($loop == $kolom) {
                                $foto .= '</tr>';
                                $foto .= '<tr>' . $rangkai_nama . '</tr>';
                                $loop = 1;
                                $rangkai_nama = '';
                            } else {
                                $loop++;
                            }
                        }

                        if ($loop != 1) {
                            $kurang = $kolom - ($loop - 1);
                            for ($j = 0; $j < $kurang; $j++) {
                                $foto .= '<td></td>';
                            }
                            $foto .= '</tr>';
                            $foto .= '<tr>' . $rangkai_nama . '</tr>';
                        }
                    }
                    $album_foto[$group[$i]] = $foto;
                }

                $html = $this->createBr(20) . '<div style="text-align: center; font-size: 25px; border:3px solid #000;">' . $this->createBr(2) . 'LAMPIRAN-LAMPIRAN' . $this->createBr(2) . '</div>';
                $html .= '<br pagebreak="true"/>';
                $html .= '<div style="text-align: center; font-weight: bold; font-size: 12px">DAFTAR BAHAN BAKU</div>';
                $html .= '<table cellpadding="3" width="1000px" style="font-weight: bold;">
                            <tr>
                                <td style="width: 15%">Penyedia Barang / Jasa</td>
                                <td style="width: 3%">:</td>
                                <td>' . $perusahaan . '</td>
                            </tr>
                            <tr>
                                <td style="width: 15%">Jenis Produk</td>
                                <td style="width: 3%">:</td>
                                <td>' . $lhv->lhv_jns_produk . '</td>
                            </tr>
                            <tr>
                                <td style="width: 15%">Spesifikasi</td>
                                <td style="width: 3%">:</td>
                                <td>' . $lhv->lhv_spesifikasi . '</td>
                            </tr>
                            <tr>
                                <td style="width: 15%">Tipe</td>
                                <td style="width: 3%">:</td>
                                <td>' . $lhv->lhv_tipe . '</td>
                            </tr>
                    </table>';
                $html .= '<table cellpadding="3" border="1">
                    <tr style="font-weight: bold; text-align: center; background-color: #eaeaea; vertical-align: middle;">
                        <td style="width: 50px;">No</td>
                        <td style="width: 110px">Bahan Baku / Material</td>
                        <td style="width: 110px">negara / Kota Asal</td>
                        <td style="width: 240px">Pemasok / Produsen Tingkat 2</td>
                    </tr>
                    ' . $bahan_baku . '
                </table>';
                $html .= '<br pagebreak="true"/>';
                $html .= '<div style="font-weight: bold; font-size: 12px; text-align: center;">Foto Perusahaan<br>' . $perusahaan . '</div>';
                $html .= '<table border="1" cellpadding="3">' . $album_foto['foto_perusahaan'] . '</table>';
                $html .= '<br pagebreak="true"/>';
                $html .= '<div style="font-weight: bold; font-size: 12px; text-align: center;">Foto Mesin / Alat Kerja<br>' . $perusahaan . '</div>';
                $html .= '<table border="1" cellpadding="3">' . $album_foto['foto_alat_kerja'] . '</table>';
                $html .= '<br pagebreak="true"/>';
                $html .= '<div style="font-weight: bold; font-size: 12px; text-align: center;">Foto Bahan Baku<br>' . $perusahaan . '</div>';
                $html .= '<table cellpadding="3">' . $album_foto['foto_bahan_baku'] . '</table>';
                $html .= '<br pagebreak="true"/>';
                $html .= '<div style="font-weight: bold; font-size: 12px; text-align: center;">Foto Produk<br>' . $perusahaan . '</div>';
                $html .= '<table border="1" cellpadding="3">' . $album_foto['foto_produk'] . '</table>';

                // echo $html;
                ob_start();
                $this->load->library('Pdf_without_footer'); // set default header data
                $this->pdf_without_footer->SetHeaderMargin(0);
                $this->pdf_without_footer->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

                $this->pdf_without_footer->setCustomFooterText('Laporan Pekerjaan Verifikasi Tingkat Komponen Dalam Negeri');
                $this->pdf_without_footer->SetFont('helvetica', '', 11);
                $this->pdf_without_footer->AddPage('P', 'A4', false, false);

                $this->pdf_without_footer->SetAutoPageBreak(TRUE, 10);
                $this->pdf_without_footer->writeHTML($html, true, false, true, false, '');
                $this->pdf_without_footer->Output('LHV ' . $lhv->lhv_jns_produk . '.pdf', 'I');
            } else {
                $this->lost();
            }
        } else {
            $this->lost();
        }
    }
}
