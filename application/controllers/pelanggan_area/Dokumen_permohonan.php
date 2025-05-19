
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dokumen_permohonan extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Dokumen_permohonan_model", "dokumen_permohonan");
        $this->load->model("Dokumen_permohonan_pic_model", "pic");
        $this->load->model("mst_admin_model", "admin");
        $this->load->model("chat_room_model", "chat_room");
        $this->load->model("surat_oc_model", "surat_oc");
        $this->load->model("payment_detail_model", "payment_detail");
        $this->load->model('proforma_invoice_model', 'proforma_invoice');
    }

    public function load_data()
    {
        if ($this->validasi_login_pelanggan()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_pelanggan = $this->session->userdata('id_pelanggan');
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);
                $relation[0] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $relation[1] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');

                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                //                $select = "*, (select nama_admin from mst_admin where id_jns_admin = 3 AND id_admin = (select id_admin from dokumen_permohonan_pic where active = 1 and id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan order by id_pic asc limit 1)) assesor_utama";
                $order = "id_dokumen_permohonan DESC";
                $where = "dokumen_permohonan.active = 1  and pelanggan.active = 1  and pelanggan.id_pelanggan = '" . $id_pelanggan . "' and (tipe_permohonan.nama_tipe_permohonan like '%" . $filter . "%')";
                $send_data = array('where' => $where, 'join' => $relation, 'limit' => $limit, 'order' => $order);
                $load_data = $this->dokumen_permohonan->load_data($send_data);
                $result = $load_data->result();
                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $list) {
                        $list->assesor_utama = null;
                        $list->nomor_hp_assesor = null;

                        $order_admin = "id_pic ASC";
                        $limit_admin = "1,0";
                        $join_admin[0] = array('tabel' => 'mst_admin', 'relation' => 'mst_admin.id_admin = dokumen_permohonan_pic.id_admin', 'direction' => 'left');
                        $where_admin = array('active' => 1, 'id_dokumen_permohonan' => $list->id_dokumen_permohonan);
                        $data_send_admin = array('where' => $where_admin, 'order' => $order_admin, 'limit' => $limit_admin, 'join' => $join_admin);
                        $load_data_admin = $this->pic->load_data($data_send_admin);
                        if ($load_data_admin->num_rows() > 0) {
                            $admin = $load_data_admin->row();

                            $list->assesor_utama = $admin->nama_admin;
                            $list->nomor_hp_assesor = $admin->telepon_admin;
                        }

                        #GET SURAT_OC...
                        $list->surat_oc = null;
                        $join_surat_oc[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                        $join_surat_oc[1] = array('tabel' => 'rab', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');

                        $where_surat_oc = array('surat_oc.active IN (1,2)' => NULL, 'id_dokumen_permohonan' => $list->id_dokumen_permohonan);
                        $data_send_surat_oc = array('where' => $where_surat_oc, 'join' => $join_surat_oc);
                        $load_data_surat_oc = $this->surat_oc->load_data($data_send_surat_oc);
                        if ($load_data_surat_oc->num_rows() > 0) {
                            $list->surat_oc = $load_data_surat_oc->row();

                            # GET PROFORMA INVOICE...
                            $list->proforma_invoice = null;
                            $where_proforma_invoice = array('active' => 1, 'id_surat_oc' => $list->surat_oc->id_surat_oc);
                            $data_send_proforma_invoice = array('where' => $where_proforma_invoice);
                            $load_data_proforma_invoice = $this->proforma_invoice->load_data($data_send_proforma_invoice);
                            if ($load_data_proforma_invoice->num_rows() > 0) {
                                $list->proforma_invoice = $load_data_proforma_invoice->row();
                            }


                            # GET PAYMENT DETAIL...
                            $list->payment_detail = null;
                            $join_payment_detail[0] = array('tabel' => 'form_01', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');
                            $where_payment_detail = array('payment_detail.active' => 1, 'id_surat_oc' => $list->surat_oc->id_surat_oc);
                            $data_send_payment_detail = array('where' => $where_payment_detail, 'join' => $join_payment_detail);
                            $load_data_payment_detail = $this->payment_detail->load_data($data_send_payment_detail);
                            if ($load_data_payment_detail->num_rows() > 0) {
                                $list->payment_detail = $load_data_payment_detail->row();
                            }
                        }
                    }
                }

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'join' => $relation, 'select' => $select);
                $load_data = $this->dokumen_permohonan->load_data($send_data);
                $total_data = $load_data->row()->jml;

                $last_page = ceil($total_data / $jml_data);
                $result = array('result' => $result, 'last_page' => $last_page);

                echo json_encode($result);
            }
        }
    }
    var $manual_tipe_file = 'application/pdf,image/jpeg';
    public function simpan()
    {
        if ($this->validasi_login_pelanggan()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_pelanggan = $this->session->userdata('id_pelanggan');
                $nama_perusahaan = $this->nama_perusahaan();

                $tgl_pengajuan = date('Y-m-d H:i:s');
                $id_tipe_permohonan = htmlentities($this->input->post('id_tipe_permohonan') ?? '');
                $dokumen_permohonan = htmlentities($this->input->post('dokumen_permohonan') ?? '');
                $kartu_npwp = htmlentities($this->input->post('kartu_npwp') ?? '');
                $dokumen_skt = htmlentities($this->input->post('dokumen_skt') ?? '');
                $dokumen_alamat_antar_invoice = htmlentities($this->input->post('dokumen_alamat_antar_invoice') ?? '');
                $dokumen_uiu_nib = htmlentities($this->input->post('dokumen_uiu_nib') ?? '');
                $dokumen_nomor_izin_edar = htmlentities($this->input->post('dokumen_nomor_izin_edar') ?? '');
                $dokumen_kontrak_amandemen = htmlentities($this->input->post('dokumen_kontrak_amandemen') ?? '');
                $nilai_tagihan_kontrak = str_replace('.', '', htmlentities($this->input->post('nilai_tagihan_kontrak') ?? ''));
                $dokumen_komitmen_tkdn = htmlentities($this->input->post('dokumen_komitmen_tkdn') ?? '');
                $kriteria_pengajuan = $this->input->post('kriteria_pengajuan');
                $dokumen_ready = htmlentities($this->input->post('dokumen_ready') ?? '');
                $nomor_npwp = htmlentities($this->input->post('nomor_npwp') ?? '');
                $alamat_npwp = htmlentities($this->input->post('alamat_npwp') ?? '');
                $tipe_pengajuan = htmlentities($this->input->post('tipe_pengajuan') ?? '');

                $user_create = $this->session->userdata('id_pelanggan');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_pelanggan');

                #find last dokumen...
                if ($dokumen_ready == 1) {
                    $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
                    $order_penawaran = " id_dokumen_permohonan DESC";
                    $limit_penawaran = "1,0";
                    $where_penawaran = array('active' => 1, 'id_pelanggan' => $id_pelanggan);
                    $data_send_penawaran = array('where' => $where_penawaran, 'order' => $order_penawaran, 'limit' => $limit_penawaran);
                    $load_data_penawaran = $this->dokumen_permohonan->load_data($data_send_penawaran);
                    $data_penawaran = $load_data_penawaran->row();
                }

                $allow = true;
                $dir_parent = 'assets/uploads/dokumen';
                $dir = $dir_parent . '/' . $id_pelanggan . '/';
                #create pelanggan folder...
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                    touch($dir . '/index.html');
                }

                $data = array(
                    'id_pelanggan' => $id_pelanggan,
                    'tgl_pengajuan' => $tgl_pengajuan,
                    'id_tipe_permohonan' => $id_tipe_permohonan,
                    'nilai_tagihan_kontrak' => $nilai_tagihan_kontrak,
                    'nomor_npwp' => $nomor_npwp,
                    'alamat_npwp' => $alamat_npwp,
                    'status_pengajuan' => 1,
                    'user_create' => $user_create,
                    'time_create' => $time_create,
                    'time_update' => $time_update,
                    'user_update' => $user_update
                );

                if ($tipe_pengajuan != 'PELAKU USAHA') {
                    $this->load->model('menu_model', 'menu');
                    $where = array('module' => 'pelanggan', 'nama_menu' => '[OFF]Berbayar Pemerintah');
                    $cek = $this->menu->is_available($where);
                    if ($cek) {
                        $allow = false;
                        $return['sts'] = 'tidak_berhak_akses_data';
                    } else {
                        $data['tipe_pengajuan'] = $tipe_pengajuan;
                    }
                } else {
                    $data['tipe_pengajuan'] = $tipe_pengajuan;
                }

                $prefix_rename = $nama_perusahaan . '-' . date('ymd') . '-' . $this->generateRandomString(5); // . '.pdf';

                #DOKUMEN PERMOHONAN
                if (isset($_FILES['dokumen_permohonan'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'dokumen_permohonan',
                        'new_name' => 'Dokumen Permohonan-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['dokumen_permohonan'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                }

                #KARTU NPWP
                if (isset($_FILES['kartu_npwp'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'kartu_npwp',
                        'new_name' => 'Kartu NPWP-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['kartu_npwp'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                } else {
                    if ($dokumen_ready == 1) {
                        $data['kartu_npwp'] = $data_penawaran->kartu_npwp;
                    }
                }

                #DOKUMEN SKT
                if (isset($_FILES['dokumen_skt'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'dokumen_skt',
                        'new_name' => 'Dokumen SKT-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['dokumen_skt'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                } else {
                    if ($dokumen_ready == 1) {
                        $data['dokumen_skt'] = $data_penawaran->dokumen_skt;
                    }
                }

                #DOKUMEN ALAMAT KANTOR ANTAR INVOICE
                if (isset($_FILES['dokumen_alamat_antar_invoice'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'dokumen_alamat_antar_invoice',
                        'new_name' => 'Dokumen Antar Invoice-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['dokumen_alamat_antar_invoice'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                } else {
                    if ($dokumen_ready == 1) {
                        $data['dokumen_alamat_antar_invoice'] = $data_penawaran->dokumen_alamat_antar_invoice;
                    }
                }

                #DOKUMEN ALAMAT KANTOR ANTAR INVOICE
                if (isset($_FILES['dokumen_uiu_nib'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'dokumen_uiu_nib',
                        'new_name' => 'Dokumen IUI NIB-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['dokumen_uiu_nib'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                } else {
                    if ($dokumen_ready == 1) {
                        $data['dokumen_uiu_nib'] = $data_penawaran->dokumen_uiu_nib;
                    }
                }

                #DOKUMEN IJIN EDAR
                if (isset($_FILES['dokumen_nomor_izin_edar'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'dokumen_nomor_izin_edar',
                        'new_name' => 'Dokumen Nomor Izin Edar-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['dokumen_nomor_izin_edar'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                } else {
                    if ($dokumen_ready == 1) {
                        $data['dokumen_nomor_izin_edar'] = $data_penawaran->dokumen_nomor_izin_edar;
                    }
                }

                #DOKUMEN KONTRAK AMANDEMEN
                if (isset($_FILES['dokumen_kontrak_amandemen'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'dokumen_kontrak_amandemen',
                        'new_name' => 'Dokumen Kontrak Amandemen-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['dokumen_kontrak_amandemen'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                } else {
                    if ($dokumen_ready == 1) {
                        $data['dokumen_kontrak_amandemen'] = $data_penawaran->dokumen_kontrak_amandemen;
                    }
                }

                #DOKUMEN KOMITMEN TKDN
                if (isset($_FILES['dokumen_komitmen_tkdn'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'dokumen_komitmen_tkdn',
                        'new_name' => 'Form Komitmen TKDN-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['dokumen_komitmen_tkdn'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                } else {
                    if ($dokumen_ready == 1) {
                        $data['dokumen_komitmen_tkdn'] = $data_penawaran->dokumen_komitmen_tkdn;
                    }
                }

                if ($kriteria_pengajuan) {
                    $data['kriteria_bpm'] = htmlentities(implode(', ', $kriteria_pengajuan) ?? '');
                }

                if ($allow) {
                    $hasil = $this->dokumen_permohonan->save_with_autoincrement($data, $id_pelanggan, 'pelanggan');
                    $exe = $hasil[0];
                    $id_dokumen_permohonan = $hasil[1];
                    if ($exe) {
                        $this->simpan_log_verifikasi($id_dokumen_permohonan, 1);
                    }
                    $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }
    public function edit()
    {
        if ($this->validasi_login_pelanggan()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_pelanggan = $this->session->userdata('id_pelanggan');
                $nama_perusahaan = $this->nama_perusahaan();

                $id_dokumen_permohonan = htmlentities($this->input->post('id_dokumen_permohonan') ?? '');
                $id_tipe_permohonan = htmlentities($this->input->post('id_tipe_permohonan') ?? '');
                $dokumen_permohonan = htmlentities($this->input->post('dokumen_permohonan') ?? '');
                $kartu_npwp = htmlentities($this->input->post('kartu_npwp') ?? '');
                $dokumen_skt = htmlentities($this->input->post('dokumen_skt') ?? '');
                $dokumen_alamat_antar_invoice = htmlentities($this->input->post('dokumen_alamat_antar_invoice') ?? '');
                $dokumen_uiu_nib = htmlentities($this->input->post('dokumen_uiu_nib') ?? '');
                $dokumen_nomor_izin_edar = htmlentities($this->input->post('dokumen_nomor_izin_edar') ?? '');
                $dokumen_kontrak_amandemen = htmlentities($this->input->post('dokumen_kontrak_amandemen') ?? '');
                $nilai_tagihan_kontrak = str_replace('.', '', htmlentities($this->input->post('nilai_tagihan_kontrak') ?? ''));
                $dokumen_komitmen_tkdn = htmlentities($this->input->post('dokumen_komitmen_tkdn') ?? '');
                $kriteria_pengajuan = htmlentities($this->input->post('kriteria_pengajuan') ?? '');
                $dokumen_ready = htmlentities($this->input->post('dokumen_ready') ?? '');
                $nomor_npwp = htmlentities($this->input->post('nomor_npwp') ?? '');
                $alamat_npwp = htmlentities($this->input->post('alamat_npwp') ?? '');

                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_pelanggan');

                $allow = true;
                $dir_parent = 'assets/uploads/dokumen';
                $dir = $dir_parent . '/' . $id_pelanggan . '/';
                #create pelanggan folder...
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                    copy($dir_parent . '/index.html', $dir . '/index.html');
                }

                $data = array(
                    'id_tipe_permohonan' => $id_tipe_permohonan,
                    'nilai_tagihan_kontrak' => $nilai_tagihan_kontrak,
                    'nomor_npwp' => $nomor_npwp,
                    'alamat_npwp' => $alamat_npwp,
                    'status_pengajuan' => 2,
                    'time_update' => $time_update,
                    'user_update' => $user_update
                );

                $prefix_rename = $nama_perusahaan . '-' . date('ymd') . '-' . $this->generateRandomString(5);


                #DOKUMEN PERMOHONAN
                if (isset($_FILES['dokumen_permohonan'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'dokumen_permohonan',
                        'new_name' => 'Dokumen Permohonan-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['dokumen_permohonan'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                }

                #KARTU NPWP
                if (isset($_FILES['kartu_npwp'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'kartu_npwp',
                        'new_name' => 'Kartu NPWP-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['kartu_npwp'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                }

                #DOKUMEN SKT
                if (isset($_FILES['dokumen_skt'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'dokumen_skt',
                        'new_name' => 'Dokumen SKT-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['dokumen_skt'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                }

                #DOKUMEN ALAMAT KANTOR ANTAR INVOICE
                if (isset($_FILES['dokumen_alamat_antar_invoice'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'dokumen_alamat_antar_invoice',
                        'new_name' => 'Dokumen Antar Invoice-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['dokumen_alamat_antar_invoice'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                }

                #DOKUMEN ALAMAT KANTOR ANTAR INVOICE
                if (isset($_FILES['dokumen_uiu_nib'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'dokumen_uiu_nib',
                        'new_name' => 'Dokumen IUI NIB-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['dokumen_uiu_nib'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                }

                #DOKUMEN IJIN EDAR
                if (isset($_FILES['dokumen_nomor_izin_edar'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'dokumen_nomor_izin_edar',
                        'new_name' => 'Dokumen Nomor Izin Edar-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['dokumen_nomor_izin_edar'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                }

                #DOKUMEN KONTRAK AMANDEMEN
                if (isset($_FILES['dokumen_kontrak_amandemen'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'dokumen_kontrak_amandemen',
                        'new_name' => 'Dokumen Kontrak Amandemen-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['dokumen_kontrak_amandemen'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                }

                #DOKUMEN KOMITMEN TKDN
                if (isset($_FILES['dokumen_komitmen_tkdn'])) {
                    $hasil = $this->upload_v2(array(
                        'dir' => $dir,
                        'allowed_types' => 'pdf|jpeg|jpg',
                        'file' => 'dokumen_komitmen_tkdn',
                        'new_name' => 'Form Komitmen TKDN-' . $prefix_rename
                    ));

                    if ($hasil['sts']) {
                        $data['dokumen_komitmen_tkdn'] = $dir . $hasil['file'];
                    } else {
                        $allow = false;
                        $return['sts'] = 'upload_error';
                        $return['error_msg'] = $hasil['msg'];
                    }
                }

                if ($kriteria_pengajuan) {
                    $this->load->model("kriteria_bpm_model", "kriteria_bpm");
                    $where_kriteria_bpm = array('active' => 1, 'id_kriteria_bpm' => $kriteria_pengajuan);
                    $data_send_kriteria_bpm = array('where' => $where_kriteria_bpm);
                    $load_data_kriteria_bpm = $this->kriteria_bpm->load_data($data_send_kriteria_bpm);
                    if ($load_data_kriteria_bpm->num_rows() > 0) {
                        $list = $load_data_kriteria_bpm->row();

                        $data['kriteria_bpm'] = $list->judul_kriteria;
                    }
                }

                if ($allow) {
                    $where = array('id_pelanggan' => $id_pelanggan, 'id_dokumen_permohonan' => $id_dokumen_permohonan, 'status_pengajuan' => 3);
                    $exe = $this->dokumen_permohonan->update($data, $where, $id_pelanggan, 'pelanggan');
                    $return['sts'] = $exe;

                    if ($exe) {
                        $this->simpan_log_verifikasi($id_dokumen_permohonan, 2);
                    }
                }
            }

            echo json_encode($return);
        }
    }

    public function verifikasi_surat_penawaran()
    {
        if ($this->validasi_login_pelanggan()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_dokumen_permohonan = $data_receive->id_dokumen_permohonan;
            $status_verifikasi = $data_receive->status_verifikasi;

            if ($status_verifikasi == 'negosiasi') {
                $status_verifikasi = 11;
            } else if ($status_verifikasi == 'setuju') {
                $status_verifikasi = 12;
            } else {
                $status_verifikasi = 99;
            }

            $alasan_verifikasi = (isset($data_receive->alasan_verifikasi) ? $data_receive->alasan_verifikasi : '');

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $exe = $this->simpan_log_verifikasi($id_dokumen_permohonan, $status_verifikasi, $alasan_verifikasi);
                if ($status_verifikasi == 11) {
                    #mencari Verifikator...
                    $order = "id_pic ASC";
                    $join[0] = array('tabel' => 'mst_admin', 'relation' => 'mst_admin.id_admin = dokumen_permohonan_pic.id_admin', 'direction' => 'left');
                    $where = array('dokumen_permohonan_pic.active' => 1, 'id_dokumen_permohonan' => $id_dokumen_permohonan, 'id_jns_admin' => 3);
                    $data_send = array('where' => $where, 'join' => $join, 'order' => $order);
                    $load_data = $this->pic->load_data($data_send);
                    $id_assesor = null;
                    if ($load_data->num_rows() > 0) {
                        $id_assesor = $load_data->row()->id_admin;
                    }

                    $user_create = $this->session->userdata('id_pelanggan');
                    $time_create = date('Y-m-d H:i:s');
                    $time_update = date('Y-m-d H:i:s');
                    $user_update = $this->session->userdata('id_pelanggan');

                    #cek apakah sudah ada room negosiasi atau belum...
                    $where_cek_room = array('id_pelanggan' => $user_create, 'id_dokumen_permohonan' => $id_dokumen_permohonan);

                    $data_send_cek_room = array('where' => $where_cek_room);
                    $load_data_cek_room = $this->chat_room->load_data($data_send_cek_room);
                    if ($load_data_cek_room->num_rows() > 0) {
                        $return['id_chat_room'] = $load_data_cek_room->row()->id_chat_room;
                    } else {
                        #buka room negosiasi...
                        $data = array(
                            'id_dokumen_permohonan' => $id_dokumen_permohonan,
                            'waktu_buka_chat' => $time_create,
                            'id_assesor' => $id_assesor,
                            'id_pelanggan' => $user_create,
                            'status' => 1,
                            'user_create' => $user_create,
                            'time_create' => $time_create,
                            'time_update' => $time_update,
                            'user_update' => $user_update
                        );
                        $hasil = $this->chat_room->save_with_autoincrement($data, $user_create, 'pelanggan');
                        if ($hasil[0])
                            $return['id_chat_room'] = $hasil[1];
                    }
                } else {
                    $time_update = date('Y-m-d H:i:s');
                    $user_update = $this->session->userdata('id_pelanggan');

                    #tutup room chat...
                    $update_chat = array(
                        'status' => 0,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where_chat = array('id_pelanggan' => $user_update, 'id_dokumen_permohonan' => $id_dokumen_permohonan);
                    $this->chat_room->update($update_chat, $where_chat, $user_update, 'pelanggan');
                }
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
