
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bom extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("collecting_dokumen_model", "collecting_dokumen");
        $this->load->model("Bom_model", "bom");
    }

    public function load_data()
    {
        if ($this->validasi_login_pelanggan() or $this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_collecting_dokumen = htmlentities($data_receive->id_collecting_dokumen ?? '');
                $result = array();
                $where_collecting_dokumen = array('collecting_dokumen.active' => 1, 'id_collecting_dokumen' => $id_collecting_dokumen);
                $data_send_collecting_dokumen = array('where' => $where_collecting_dokumen);
                $load_data_collecting_dokumen = $this->collecting_dokumen->load_data($data_send_collecting_dokumen);
                if ($load_data_collecting_dokumen->num_rows() > 0) {
                    $collecting_dokumen = $load_data_collecting_dokumen->row();
                    $order = "urutan asc";
                    $where = array('bom.active' => 1, 'bom.id_collecting_dokumen' => $id_collecting_dokumen); #show active data...

                    $send_data = array('where' => $where, 'order' => $order);
                    $load_data = $this->bom->load_data($send_data);
                    $bom = $load_data->result();

                    $result = array(
                        'collecting_dokumen' => $collecting_dokumen,
                        'bom' => $bom
                    );
                }

                echo json_encode($result);
            }
        }
    }
    public function simpan_bom()
    {
        if ($this->validasi_login_pelanggan() or $this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $return = array();
                $id_collecting_dokumen = htmlentities($data_receive->id_collecting_dokumen ?? '');
                $header_bom = json_decode($data_receive->header_bom, true);
                $items = json_decode($data_receive->items, true);
                $time_update = date('Y-m-d H:i:s');
                $login_as = $this->session->userdata('login_as');

                if ($login_as == 'pelanggan') {
                    $id_pelanggan = $this->session->userdata('id_pelanggan');
                } else {
                    $id_admin = $this->session->userdata('id_admin');
                }

                #cek apakah pelanggan berhak mengubah data...
                #cek apakah berhak untuk mengupdate data...
                $join_collecting_dokumen[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = collecting_dokumen.id_opening_meeting', 'direction' => 'left');
                $join_collecting_dokumen[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where_collecting_dokumen = array('collecting_dokumen.active' => 1, 'collecting_dokumen.id_collecting_dokumen' => $id_collecting_dokumen, '(id_status >= 7 and id_status < 15)' => null);
                if ($login_as == 'pelanggan') {
                    $where_collecting_dokumen['dokumen_permohonan.id_pelanggan'] = $id_pelanggan;
                } else {
                    $where_collecting_dokumen["(opening_meeting.id_assesor = '" . $id_admin . "' or opening_meeting.id_opening_meeting IN (select id_opening_meeting from opening_meeting_asisten_assesor where active = 1 and id_admin = '" . $this->session->userdata('id_admin') . "'))"] = null;
                }
                $data_send_collecting_dokumen = array('where' => $where_collecting_dokumen, 'join' => $join_collecting_dokumen);
                $load_data_collecting_dokumen = $this->collecting_dokumen->load_data($data_send_collecting_dokumen);
                if ($load_data_collecting_dokumen->num_rows() > 0) {
                    #sterilisasi...
                    $kolom_tambahan = array();
                    foreach ($header_bom as $row) {
                        $kolom_tambahan[] = [
                            'field' => htmlentities($row['field'] ?? ''),
                            'label' => htmlentities($row['label'] ?? ''),
                            'value' => htmlentities($row['value'] ?? ''),
                        ];
                    }
                    $kolom_tambahan = json_encode($kolom_tambahan);

                    #simpan kedalam tabel collecting_dokumen...
                    $data = array(
                        'kolom_tambahan' => $kolom_tambahan,
                        'time_update' => $time_update,
                        'user_update' => ($login_as == 'pelanggan' ? $id_pelanggan : $id_admin),
                    );
                    $where = array('id_collecting_dokumen' => $id_collecting_dokumen);
                    $this->collecting_dokumen->update($data, $where, ($login_as == 'pelanggan' ? $id_pelanggan : $id_admin), ($login_as == 'pelanggan' ? 'pelanggan' : 'mst_admin'));

                    $urutan = 1;
                    foreach ($items as $row) {
                        $id_bom = htmlentities($row['id_bom'] ?? '');
                        $uraian = htmlentities($row['uraian'] ?? '');
                        $spesifikasi = htmlentities($row['spesifikasi'] ?? '');
                        $satuan_bahan_baku = htmlentities($row['satuan_bahan_baku'] ?? '');
                        $negara_asal = htmlentities($row['negara_asal'] ?? '');
                        $vendor_suplier = htmlentities($row['vendor_suplier'] ?? '');
                        $jml_pemakaian_satuan_produk = htmlentities($row['jml_pemakaian_satuan_produk'] ?? '');
                        $harga_satuan = str_replace('.', '', htmlentities($row['harga_satuan'] ?? ''));

                        $tipe = 'GRUP';
                        if ($satuan_bahan_baku and $negara_asal and $vendor_suplier and $jml_pemakaian_satuan_produk and $harga_satuan) {
                            $tipe = 'ITEM';
                        }
                        #jika id_bom ada, maka lakukan update..
                        if ($id_bom) {
                            $data_bom = array(
                                'tipe' => $tipe,
                                'uraian' => $uraian,
                                'spesifikasi' => $spesifikasi,
                                'satuan_bahan_baku' => $satuan_bahan_baku,
                                'negara_asal' => $negara_asal,
                                'vendor_suplier' => $vendor_suplier,
                                'jml_pemakaian_satuan_produk' => $jml_pemakaian_satuan_produk,
                                'harga_satuan' => $harga_satuan,
                                'urutan' => $urutan,
                                'time_update' => $time_update,
                                'user_update' => ($login_as == 'pelanggan' ? $id_pelanggan : $id_admin),
                            );
                            $where_bom = array('id_bom' => $id_bom, 'id_collecting_dokumen' => $id_collecting_dokumen);
                            $this->bom->update($data_bom, $where_bom, ($login_as == 'pelanggan' ? $id_pelanggan : $id_admin), ($login_as == 'pelanggan' ? 'pelanggan' : 'mst_admin'));
                        } else {
                            #jika id_bom tidak ada, lakukan insert..
                            $data_bom = array(
                                'id_collecting_dokumen' => $id_collecting_dokumen,
                                'tipe' => $tipe,
                                'uraian' => $uraian,
                                'spesifikasi' => $spesifikasi,
                                'satuan_bahan_baku' => $satuan_bahan_baku,
                                'negara_asal' => $negara_asal,
                                'vendor_suplier' => $vendor_suplier,
                                'jml_pemakaian_satuan_produk' => $jml_pemakaian_satuan_produk,
                                'harga_satuan' => $harga_satuan,
                                'urutan' => $urutan,
                                'time_update' => $time_update,
                                'user_update' => ($login_as == 'pelanggan' ? $id_pelanggan : $id_admin),
                            );
                            $this->bom->save($data_bom, ($login_as == 'pelanggan' ? $id_pelanggan : $id_admin), ($login_as == 'pelanggan' ? 'pelanggan' : 'mst_admin'));
                        }

                        $urutan++;
                    }

                    $return['sts'] = true;
                } else {
                    $return['sts'] = 'tidak_berhak_ubah_data';
                }
                echo json_encode($return);
            }
        }
    }

    public function hapus_item_bom()
    {
        if ($this->validasi_login_pelanggan()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $return = array();
                $id_pelanggan = $this->session->userdata('id_pelanggan');
                $id_collecting_dokumen = htmlentities($data_receive->id_collecting_dokumen ?? '');
                $id_bom = htmlentities($data_receive->id_bom ?? '');

                #cek apakah berhak untuk mengupdate data...
                $join_bom[0] = array('tabel' => 'collecting_dokumen', 'relation' => 'collecting_dokumen.id_collecting_dokumen = bom.id_collecting_dokumen', 'direction' => 'left');
                $join_bom[1] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = collecting_dokumen.id_opening_meeting', 'direction' => 'left');
                $join_bom[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where_bom = array('bom.active' => 1, 'bom.id_bom' => $id_bom, 'collecting_dokumen.id_collecting_dokumen' => $id_collecting_dokumen, 'dokumen_permohonan.id_pelanggan' => $id_pelanggan,  '(id_status >= 7 and id_status < 15)' => null);
                $data_send_bom = array('where' => $where_bom, 'join' => $join_bom);
                $load_data_bom = $this->bom->load_data($data_send_bom);
                if ($load_data_bom->num_rows() > 0) {
                    $where = array(
                        'id_bom' => $id_bom
                    );
                    $exe = $this->bom->delete($where, $id_pelanggan, 'pelanggan');
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'tidak_berhak_hapus_data';
                }

                echo json_encode($return);
            }
        }
    }

    public function simpan_file()
    {
        if ($this->validasi_login_pelanggan()) {
            $token = $this->input->post('token');
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_bom = htmlentities($this->input->post('id_bom') ?? '');
                $field = htmlentities($this->input->post('field') ?? '');
                $id_pelanggan = $this->session->userdata('id_pelanggan');

                #cek apakah berhak untuk mengupdate data...
                $join_bom[0] = array('tabel' => 'collecting_dokumen', 'relation' => 'collecting_dokumen.id_collecting_dokumen = bom.id_collecting_dokumen', 'direction' => 'left');
                $join_bom[1] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = collecting_dokumen.id_opening_meeting', 'direction' => 'left');
                $join_bom[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where_bom = array('bom.active' => 1, 'bom.id_bom' => $id_bom, 'dokumen_permohonan.id_pelanggan' => $id_pelanggan,  '(id_status >= 7 and id_status < 15)' => null);
                $data_send_bom = array('where' => $where_bom, 'join' => $join_bom);
                $load_data_bom = $this->bom->load_data($data_send_bom);
                if ($load_data_bom->num_rows() > 0) {
                    $row = $load_data_bom->row();
                    #jika data ini milik pelanggan, maka boleh upload filenya...
                    $prefix_rename = date('ymd') . '-' . $this->generateRandomString(5);

                    if (isset($_FILES['file_bom'])) {
                        $dir = "assets/uploads/dokumen/" . $id_pelanggan . "//collecting_dokumen/" . $row->id_collecting_dokumen . "/";
                        $hasil = $this->upload_v2(array(
                            'dir' => $dir,
                            'allowed_types' => 'pdf|jpeg|jpg',
                            'file' => 'file_bom',
                            'new_name' => $field . '-' . $prefix_rename
                        ));

                        if ($hasil['sts']) {
                            $data = array(
                                $field => $dir . $hasil['file'],
                                'status_verifikasi' => 3,
                                'time_update' => date('Y-m-d H:i:s'),
                                'user_update' => $id_pelanggan
                            );
                            $where = array('id_bom' => $id_bom);
                            $return['sts'] = $this->bom->update($data, $where, $id_pelanggan, 'pelanggan');

                            #update juga status di collecting dokumen
                            $data = array(
                                'status_verifikasi' => 3,
                                'alasan_verifikasi' => null,
                                'time_update' => date('Y-m-d H:i:s'),
                                'user_update' => $id_pelanggan
                            );
                            $where = array('id_collecting_dokumen' => $row->id_collecting_dokumen);
                            $this->collecting_dokumen->update($data, $where, $id_pelanggan, 'pelanggan');
                        } else {
                            $return['sts'] = 'upload_error';
                            $return['error_msg'] = $hasil['msg'];
                        }
                    }
                } else {
                    $return['sts'] = 'tidak_berhak_ubah_data';
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
                $id_bom = htmlentities($data_receive->id_bom ?? '');
                $field = htmlentities($data_receive->field ?? '');
                $id_pelanggan = $this->session->userdata('id_pelanggan');

                #cek apakah berhak untuk mengupdate data...
                $join_bom[0] = array('tabel' => 'collecting_dokumen', 'relation' => 'collecting_dokumen.id_collecting_dokumen = bom.id_collecting_dokumen', 'direction' => 'left');
                $join_bom[1] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = collecting_dokumen.id_opening_meeting', 'direction' => 'left');
                $join_bom[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where_bom = array('bom.active' => 1, 'bom.id_bom' => $id_bom, 'dokumen_permohonan.id_pelanggan' => $id_pelanggan,  '(id_status >= 7 and id_status < 15)' => null);
                $data_send_bom = array('where' => $where_bom, 'join' => $join_bom);
                $load_data_bom = $this->bom->load_data($data_send_bom);
                if ($load_data_bom->num_rows() > 0) {
                    $row = $load_data_bom->row();
                    #jika data ini milik pelanggan, maka boleh upload filenya...
                    $data = array(
                        $field => null,
                        'time_update' => date('Y-m-d H:i:s'),
                        'user_update' => $id_pelanggan
                    );
                    $where = array('id_bom' => $id_bom);
                    $return['sts'] = $this->bom->update($data, $where, $id_pelanggan, 'pelanggan');

                    @unlink($row->{$field});

                    #cek apakah file invoice dan faktur pajak kosong...
                    $where = array('bom.active' => 1, 'bom.id_bom' => $id_bom, 'invoice IS NULL' => null, 'faktur_pajak IS NULL' => null);
                    $cek = $this->bom->is_available($where);
                    if ($cek) {
                        $status = 0;
                        $data = array(
                            'status_verifikasi' => $status,
                            'time_update' => date('Y-m-d H:i:s'),
                            'user_update' => $id_pelanggan
                        );
                        $where = array('id_bom' => $id_bom);
                        $this->bom->update($data, $where, $id_pelanggan, 'pelanggan');

                        #update juga status di collecting dokumen
                        $where = array('id_collecting_dokumen' => $row->id_collecting_dokumen);
                        $this->collecting_dokumen->update($data, $where, $id_pelanggan, 'pelanggan');
                    }
                } else {
                    $return['sts'] = 'tidak_berhak_ubah_data';
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
                $id_bom = htmlentities($data_receive->id_bom ?? '');
                $status = htmlentities($data_receive->status ?? '');
                $alasan_verifikasi = htmlentities($data_receive->alasan_verifikasi ?? '');
                $id_status = ($status == 'setuju' ? 1 : 2);
                $id_admin = $this->session->userdata('id_admin');

                #cek apakah berhak untuk mengupdate data...
                $join_bom[0] = array('tabel' => 'collecting_dokumen', 'relation' => 'collecting_dokumen.id_collecting_dokumen = bom.id_collecting_dokumen', 'direction' => 'left');
                $join_bom[1] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = collecting_dokumen.id_opening_meeting', 'direction' => 'left');
                $join_bom[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where_bom = array('bom.active' => 1, 'bom.id_bom' => $id_bom, "(opening_meeting.id_assesor = '" . $id_admin . "' or opening_meeting.id_opening_meeting IN (select id_opening_meeting from opening_meeting_asisten_assesor where active = 1 and id_admin = '" . $this->session->userdata('id_admin') . "'))" => null,  '(id_status >= 7 and id_status < 15)' => null);
                $data_send_bom = array('where' => $where_bom, 'join' => $join_bom);
                $load_data_bom = $this->bom->load_data($data_send_bom);
                if ($load_data_bom->num_rows() > 0) {
                    $row = $load_data_bom->row();
                    $data = array(
                        'status_verifikasi' => $id_status,
                        'alasan_verifikasi' => $alasan_verifikasi,
                        'time_update' => date('Y-m-d H:i:s'),
                        'user_update' => $id_admin,
                    );
                    $where = array('id_bom' => $id_bom);
                    $return['sts'] = $this->bom->update($data, $where);

                    #jika status ditolak, maka update status secara global...
                    if ($id_status == 2) {
                        #update status collecting dokumen...
                        $where = array('id_collecting_dokumen' => $row->id_collecting_dokumen);
                        $this->collecting_dokumen->update($data, $where);
                    } else {
                        #jika setuju, cek apakah semua juga sudah disetujui...
                        $where_bom = "bom.active = 1 and tipe = 'ITEM' and id_collecting_dokumen = '" . $row->id_collecting_dokumen . "' and status_verifikasi != 1";
                        $cek = $this->bom->is_available($where_bom);
                        if (!$cek) {
                            #jika tidak ada status verifikasi != 1 artinya semua status verifikasi sudah 1 (disetujui) semua...
                            #update collecting dokumen menjadi disetujui...
                            $data = array(
                                'status_verifikasi' => 1,
                                'alasan_verifikasi' => null,
                                'time_update' => date('Y-m-d H:i:s'),
                                'user_update' => $id_admin,
                            );
                            $where = array('id_collecting_dokumen' => $row->id_collecting_dokumen);
                            $this->collecting_dokumen->update($data, $where);
                        }
                    }
                } else {
                    $return['sts'] = 'tidak_berhak_akses_data';
                }
                echo json_encode($return);
            }
        }
    }
}
