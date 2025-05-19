
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
        $this->load->model('bom_model', 'bom');
    }

    public function load_folder()
    {
        if ($this->validasi_login_pelanggan() or $this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $from = htmlentities($data_receive->from ?? '');

                $hasil = $this->load_file_collecting_dokumen($id_opening_meeting, $from);
                echo json_encode($hasil['result']);
            }
        }
    }

    public function upload_file()
    {
        if ($this->validasi_login_pelanggan()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
                $id_nama_file = htmlentities($this->input->post('id_nama_file') ?? '');
                $kolom_tambahan = $this->input->post('kolom_tambahan');

                $id_pelanggan = $this->session->userdata('id_pelanggan');
                $time_create = date('Y-m-d H:i:s');

                #cek apakah pelanggan boleh menambahkan file pada id_opening_meeting yang diberikan...
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where = array(
                    'opening_meeting.active' => 1,
                    'id_opening_meeting' => $id_opening_meeting,
                    'id_pelanggan' => $id_pelanggan,
                    '(id_status >= 7 and id_status < 15)' => null
                );
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();

                    #ambil data dari id_nama_file
                    $where_nama_file = array('collecting_dokumen_nama_file.active' => 1, 'id_nama_file' => $id_nama_file);
                    $data_send_nama_file = array('where' => $where_nama_file);
                    $load_data_nama_file = $this->nama_file->load_data($data_send_nama_file);
                    if ($load_data_nama_file->num_rows() > 0) {
                        $nama_file = $load_data_nama_file->row();

                        $allow_upload = true;
                        #cek apakah boleh upload lagi atau tidak...
                        if ($nama_file->multi_file == 0) {
                            #cek apakah sudah ada 1 file atau tidak.. jika masih belum ada file maka boleh upload
                            $where_dokumen = array('collecting_dokumen.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_nama_file' => $id_nama_file);
                            $jml_dokumen = $this->collecting_dokumen->select_count($where_dokumen);

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
                                'dir' => 'assets/uploads/dokumen/' . $id_pelanggan . '/' . 'collecting_dokumen/' . $id_opening_meeting,
                                'allowed_types' => ($nama_file->jns_file ? $nama_file->jns_file : '*'),
                                'file' => 'file',
                                'encrypt_name' => false
                            );
                            $hasil = $this->upload_v2($var);

                            if ($hasil['sts']) {
                                #simpan ke dalam database...
                                $data = array(
                                    'id_opening_meeting' => $id_opening_meeting,
                                    'id_nama_file' => $id_nama_file,
                                    'value' => $hasil['file'],
                                    'resource' => $var['dir'] . '/' . $hasil['file'],
                                    'kolom_tambahan' => $kolom_tambahan,
                                    'user_create' => $id_pelanggan,
                                    'time_create' => $time_create,
                                    'time_update' => $time_create,
                                    'user_update' => $id_pelanggan
                                );
                                $simpan = $this->collecting_dokumen->save_with_autoincrement($data, $id_pelanggan, 'pelanggan');
                                $exe = $simpan[0];
                                $id_collecting_dokumen = $simpan[1];

                                #cek apakah ada referensi khusus atau tidak...
                                if ($nama_file->referensi == 'BOM') {
                                    $exe = $this->simpan_bom($id_collecting_dokumen, $var['dir'] . '/' . $hasil['file']);
                                }

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
            }

            echo json_encode($return);
        }
    }
    function simpan_bom($id_collecting_dokumen, $file_bom)
    {
        if ($this->validasi_login_pelanggan()) {
            $id_pelanggan = $this->session->userdata('id_pelanggan');

            $start_row = 1;
            $end_row = 999999;
            $start_column = 'A';
            $end_column = 'H';
            $this->reader = new ExcelReader();
            $result = $this->reader->read($file_bom, 0, $start_row, $end_row, $start_column, $end_column);
            // print_r($result);

            #cek apakah file sesuai dengan yang diupload 
            if (strtolower($result[$start_row]['A']) != 'no' or strtolower($result[$start_row]['B']) != 'uraian' or strtolower($result[$start_row]['C']) != 'spesifikasi' or strtolower($result[$start_row]['D']) != 'satuan bahan baku' or strtolower($result[$start_row]['E']) != 'negara asal' or strtolower($result[$start_row]['F']) != 'vendor / supplier' or strtolower($result[$start_row]['G']) != 'jumlah pemakaian untuk 1 (satu) satuan produk' or strtolower($result[$start_row]['H']) != 'harga satuan material (rupiah)') {
                $this->collecting_dokumen->delete(array('id_collecting_dokumen' => $id_collecting_dokumen), 'pelanggan', $id_pelanggan);
                @unlink($file_bom);
                return 'tidak_sesuai_format';
            } else {
                #jika file sesuai, simpan file ke database...
                $urutan = 1;
                for ($i = ($start_row + 1); $i <= $end_row; $i++) {
                    if (!isset($result[$i]['B'])) break;
                    $tipe = 'GRUP';
                    if ($result[$i]['D'] and $result[$i]['E'] and $result[$i]['F'] and $result[$i]['G'] and $result[$i]['H']) {
                        $tipe = 'ITEM';
                    }

                    $data = array(
                        'tipe' => $tipe,
                        'id_collecting_dokumen' => $id_collecting_dokumen,
                        'uraian' => htmlentities($result[$i]['B'] ?? ''),
                        'spesifikasi' => htmlentities($result[$i]['C'] ?? ''),
                        'satuan_bahan_baku' => htmlentities($result[$i]['D'] ?? ''),
                        'negara_asal' => htmlentities($result[$i]['E'] ?? ''),
                        'vendor_suplier' => htmlentities($result[$i]['F'] ?? ''),
                        'jml_pemakaian_satuan_produk' => htmlentities($result[$i]['G'] ?? ''),
                        'harga_satuan' => htmlentities($result[$i]['H'] ?? ''),
                        'urutan' => $urutan
                    );
                    $this->bom->save($data, 'pelanggan', $id_pelanggan);
                    $urutan++;
                }
                @unlink($file_bom);
                return true;
            }
        }
    }
    public function simpan_file_textarea()
    {
        if ($this->validasi_login_pelanggan()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $id_nama_file = htmlentities($data_receive->id_nama_file ?? '');
                $file_textarea = htmlentities($data_receive->file_textarea ?? '');

                $id_pelanggan = $this->session->userdata('id_pelanggan');
                $time_create = date('Y-m-d H:i:s');

                #cek apakah pelanggan boleh menambahkan file pada id_opening_meeting yang diberikan...
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where = array(
                    'opening_meeting.active' => 1,
                    'id_opening_meeting' => $id_opening_meeting,
                    'id_pelanggan' => $id_pelanggan,
                    'id_status IN (7)' => null
                );
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();

                    #ambil data dari id_nama_file
                    $where_nama_file = array('collecting_dokumen_nama_file.active' => 1, 'id_nama_file' => $id_nama_file);
                    $data_send_nama_file = array('where' => $where_nama_file);
                    $load_data_nama_file = $this->nama_file->load_data($data_send_nama_file);
                    if ($load_data_nama_file->num_rows() > 0) {
                        $nama_file = $load_data_nama_file->row();

                        $allow_simpan = true;
                        #cek apakah boleh simpan lagi atau tidak...
                        if ($nama_file->multi_file == 0) {
                            #cek apakah sudah ada 1 file atau tidak.. jika masih belum ada file maka boleh simpan
                            $where_dokumen = array('collecting_dokumen.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_nama_file' => $id_nama_file);
                            $jml_dokumen = $this->collecting_dokumen->select_count($where_dokumen);

                            if ($jml_dokumen == 0) {
                                $allow_simpan = true;
                            } else {
                                $allow_simpan = false;
                                $return['sts'] = 'mencapai_batas_simpan';
                            }
                        } else {
                            $allow_simpan = true;
                        }

                        if ($allow_simpan) {

                            #simpan ke dalam database...
                            $data = array(
                                'id_opening_meeting' => $id_opening_meeting,
                                'id_nama_file' => $id_nama_file,
                                'value' => $file_textarea,
                                'user_create' => $id_pelanggan,
                                'time_create' => $time_create,
                                'time_update' => $time_create,
                                'user_update' => $id_pelanggan
                            );
                            $exe = $this->collecting_dokumen->save($data, $id_pelanggan, 'pelanggan');
                            $return['sts'] = $exe;
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
        if ($this->validasi_login_pelanggan()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_collecting_dokumen = htmlentities($data_receive->id_collecting_dokumen ?? '');

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_pelanggan = $this->session->userdata('id_pelanggan');
                $allow = true;

                #cek apakah file ini tidak sedang dalam proses pengecekan atau tidak...
                $where_dokumen = array(
                    'collecting_dokumen.active' => 1,
                    'id_collecting_dokumen' => $id_collecting_dokumen,
                    'status_verifikasi IN (0, 1, 2) and (id_status >= 7 and id_status < 15)' => null
                );
                $join_dokumen[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = collecting_dokumen.id_opening_meeting', 'direction' => 'left');
                $data_send_dokumen = array('where' => $where_dokumen, 'join' => $join_dokumen);
                $load_data_dokumen = $this->collecting_dokumen->load_data($data_send_dokumen);
                if ($load_data_dokumen->num_rows() > 0) {
                    #jika tidak dalam pengecekan atau belum disetujui, boleh dihapus...
                    $dokumen = $load_data_dokumen->row();

                    #cek apakah file ini milik id_pelanggan atau tidak...
                    $join_opening_meeting[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                    $where_opening_meeting = array('opening_meeting.active' => 1, 'id_opening_meeting' => $dokumen->id_opening_meeting);
                    $data_send_opening_meeting = array('where' => $where_opening_meeting, 'join' => $join_opening_meeting);
                    $load_data_opening_meeting = $this->opening_meeting->load_data($data_send_opening_meeting);
                    if ($load_data_opening_meeting->num_rows() == 0) {
                        #jika bukan milik pelanggan, tidak boleh dihapus...
                        $allow = false;
                        $return['sts'] = 'tidak_berhak_hapus_data';
                    }
                } else {
                    #jika dalam pengecekan atau sudah disetujui, tidak boleh dihapus...
                    $allow = false;
                    $return['sts'] = 'tidak_berhak_hapus_data';
                }

                if ($allow) {
                    $where = array('id_collecting_dokumen' => $id_collecting_dokumen);
                    $this->bom->delete($where, $id_pelanggan, 'pelanggan');
                    $exe = $this->collecting_dokumen->delete($where, $id_pelanggan, 'pelanggan');
                    @unlink($dokumen->resource);
                    $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }

    public function upload_permohonan_perpanjangan_waktu()
    {
        if ($this->validasi_login_pelanggan()) {
            $token = $this->input->post('token');

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
                $id_pelanggan = $this->session->userdata('id_pelanggan');

                if ($id_opening_meeting) {
                    $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                    $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_pelanggan' => $id_pelanggan);
                    $data_send = array('where' => $where, 'join' => $join);
                    $load_data = $this->opening_meeting->load_data($data_send);
                    if ($load_data->num_rows() > 0) {
                        $var = array(
                            'dir' => 'assets/uploads/dokumen/' . $id_pelanggan . '/',
                            'allowed_types' => 'pdf|jpeg|jpg',
                            'file' => 'surat_permohonan_perpanjangan_waktu',
                            'encrypt_name' => true,
                            'new_name' => 'Surat Permohonan Perpanjangan Waktu Pengumpulan Dokumen-' . date('ymd') . '-' . $this->generateRandomString(5),
                        );
                        $hasil = $this->upload_v2($var);
                        if ($hasil['sts']) {
                            $data = array(
                                'surat_perpanjangan_waktu' => $var['dir'] . $hasil['file']
                            );
                            $where = "id_opening_meeting = '" . $id_opening_meeting . "'";
                            $exe = $this->opening_meeting->update($data, $where, $id_pelanggan, 'pelanggan');
                            if ($exe) {
                                $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 12);
                            }

                            $return['sts'] = $exe;
                        } else {
                            $return['sts'] = 'upload_error';
                            $return['msg'] = $hasil['msg'];
                        }
                    } else {
                        $return['sts'] = 'tidak_berhak_akses_data';
                    }
                } else {
                    $return['sts'] = 'kosong';
                }
            }

            echo json_encode($return);
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
