
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pelanggan extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Pelanggan_model", "pelanggan");
        $this->load->model('dokumen_permohonan_model', 'dokumen_permohonan');
    }

    function notif_riwayat_permohonan()
    {
        $select = "count(-1) jml";
        $where = "active = 1 
                and status_pengajuan IN (3, 10, 21, 22, 24)
                and id_pelanggan = '" . $this->session->userdata('id_pelanggan') . "'";
        $data_send = array('select' => $select, 'where' => $where);
        $load_data = $this->dokumen_permohonan->load_data($data_send);
        return $load_data->row()->jml;
    }
    function notif_upload_bukti_bayar()
    {
        $select = "count(-1) jml";
        $join[] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
        $join[] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');
        $join[] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
        $where = array(
            'dokumen_permohonan.active' => 1,
            'status_pengajuan >= ' => 25,
            'status_pengajuan !=' => 99,
            'termin_1 >' => 0,
            'bukti_bayar' => '',
            'id_pelanggan' => $this->session->userdata('id_pelanggan')
        );
        $data_send = array('select' => $select, 'where' => $where, 'join' => $join);
        $load_data = $this->dokumen_permohonan->load_data($data_send);
        return $load_data->row()->jml;
    }
    function notif_ruang_negosiasi()
    {
        $select = "count(-1) jml";
        $join[0] = array('tabel' => 'chat_room', 'relation' => 'chat_room.id_chat_room = chat_room_conversation.id_chat_room', 'direction' => 'left');
        $where = "chat_room_conversation.active = 1 
                and chat_room.active = 1
                and chat_room.status = 1 
                and id_pelanggan = '" . $this->session->userdata('id_pelanggan') . "'  
                and read = 0  
                and tabel_pengirim = 'mst_admin'";

        $data_send = array('select' => $select, 'where' => $where, 'join' => $join);
        $load_data = $this->chat_room_conversation->load_data($data_send);
        $jml_chat = $load_data->row()->jml;
        return $jml_chat;
    }

    function notif_riwayat_verifikasi_tkdn()
    {
        $this->load->model('opening_meeting_model', 'opening_meeting');

        $select = "count(-1) jml";
        $where = "opening_meeting.active = 1 and id_pelanggan = '" . $this->session->userdata('id_pelanggan') . "' and id_status IN (4, 6, 7, 11, 13, 14, 16, 22, 23, 29)";
        $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
        $data_send = array('select' => $select, 'where' => $where, 'join' => $join);
        $load_data = $this->opening_meeting->load_data($data_send);
        return $load_data->row()->jml;
    }
    function notif_pesan()
    {
        $this->load->model('pesan_model', 'pesan');
        $where = array('active' => 1, 'id_pelanggan' => $this->session->userdata('id_pelanggan'), 'read' => 0);
        $jml = $this->pesan->select_count($where);
        return $jml;
    }
    function notifikasi()
    {
        $this->load->model("chat_room_conversation_model", "chat_room_conversation");

        $ruang_negosiasi = $this->notif_ruang_negosiasi();
        $pesan = $this->notif_pesan();
        $riwayat_permohonan = $this->notif_riwayat_permohonan() + $this->notif_upload_bukti_bayar();

        $permohonan_tkdn_grup = null;
        if ($riwayat_permohonan > 0) {
            $permohonan_tkdn_grup = array(
                'Riwayat Permohonan TKDN' => $riwayat_permohonan,
            );
        }

        $riwayat_verifikasi_tkdn = $this->notif_riwayat_verifikasi_tkdn();

        $verifikasi_tkdn_grup = null;
        if ($riwayat_verifikasi_tkdn > 0) {
            $verifikasi_tkdn_grup = array(
                'Riwayat Verifikasi TKDN' => $riwayat_verifikasi_tkdn,
            );
        }

        $array = array(
            'Permohonan TKDN' => $permohonan_tkdn_grup,
            'Verifikasi TKDN' => $verifikasi_tkdn_grup,
            'Ruang Negosiasi' => $ruang_negosiasi,
            'Pesan' => $pesan,
        );
        return $array;
    }

    public function index()
    {
        $konten = array('title' => 'Login Pelanggan');
        $this->load->view('pelanggan_area/gateway/login', $this->data_halaman($konten));
    }

    public function daftar($status = '')
    {
        if ($status == 'berhasil') {
            $email = htmlentities($this->input->get('email') ?? '');

            $konten = array('title' => 'Daftar Berhasil', 'email' => ($email ? $email : 'alamat email Anda'));
            $this->load->view('pelanggan_area/gateway/daftar_berhasil', $this->data_halaman($konten));
        } else {
            $this->load->model("tipe_badan_usaha_model", "tipe_badan_usaha");
            $where = array('active' => 1);
            $data_send = array('where' => $where);
            $tipe_badan_usaha = $this->tipe_badan_usaha->load_data($data_send);

            $konten = array('title' => 'Daftar Pelanggan', 'tipe_badan_usaha' => $tipe_badan_usaha);
            $this->load->view('pelanggan_area/gateway/daftar', $this->data_halaman($konten));
        }
    }
    public function verifikasi_email()
    {
        $token = htmlentities($this->input->get('token') ?? '');
        $this->load->model("pelanggan_model", "pelanggan");
        $where = "active = 1 and concat(md5(id_pelanggan), md5(email)) = '" . $token . "'";
        $data_send = array('where' => $where);
        $load_data = $this->pelanggan->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            $request = $load_data->row();

            #update verifikasi email...
            $data = array(
                'verifikasi_email' => 1,
                'time_update' => date('Y-m-d H:i:s'),
                'user_update' => $request->id_pelanggan
            );
            $this->pelanggan->update($data, $where, $request->id_pelanggan, 'pelanggan');

            $konten = array('title' => 'Verifikasi Email Berhasil');
            $this->load->view('pelanggan_area/gateway/verifikasi_email_berhasil', $this->data_halaman($konten));
        } else {
            #token tidak ditemukan / kadaluarsa...
            $konten = array('title' => 'Tautan Salah');
            $this->load->view('pelanggan_area/gateway/verifikasi_email_gagal', $this->data_halaman($konten));
        }
    }
    public function request_verifikasi_email()
    {
        $konten = array('title' => 'Request Verifikasi Email');
        $this->load->view('pelanggan_area/gateway/request_verifikasi_email', $this->data_halaman($konten));
    }
    public function lupa_password($status = '')
    {
        if ($status == 'berhasil') {
            $konten = array('title' => 'Email Terkirim', 'email' => htmlentities($this->input->get('email') ?? ''));
            $this->load->view('pelanggan_area/gateway/request_forgot_password_berhasil', $this->data_halaman($konten));
        } else {
            $konten = array('title' => 'Lupa Password');
            $this->load->view('pelanggan_area/gateway/lupa_password', $this->data_halaman($konten));
        }
    }
    public function reset_password()
    {
        $token = htmlentities($this->input->get('token') ?? '');
        $this->load->model("request_forgot_password_model", "request_forgot_password");
        $where = array('active' => 1, 'kode' => $token);
        $data_send = array('where' => $where);
        $load_data = $this->request_forgot_password->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            $request = $load_data->row();

            $konten = array('title' => 'Buat Kata Sandi Yang Kuat', 'token' => $token);
            $this->load->view('pelanggan_area/gateway/reset_password', $this->data_halaman($konten));
        } else {
            #token tidak ditemukan / kadaluarsa...
            $konten = array('title' => 'Tautan Salah');
            $this->load->view('pelanggan_area/gateway/request_forgot_password_gagal', $this->data_halaman($konten));
        }
    }
    public function reset_password_berhasil()
    {
        $konten = array('title' => 'password Berhasil Diperbarui');
        $this->load->view('pelanggan_area/gateway/reset_password_berhasil', $this->data_halaman($konten));
    }
    public function beranda()
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Beranda', 'notif' => $notif);
            $this->load->view('pelanggan_area/beranda', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }


    public function berbayar_pelaku_usaha($id_dokumen_permohonan = '')
    {
        $data = array(
            'id_dokumen_permohonan' => $id_dokumen_permohonan,
            'tipe_pengajuan' => 'PELAKU USAHA',
            'title' => 'Permohonan TKDN Berbayar Pelaku Usaha'
        );
        $this->open_form_dokumen_permohonan($data);
    }
    public function berbayar_pemerintah($id_dokumen_permohonan = '')
    {
        #cek apakah akses berbayar pemerintah sedang dibuka atau tidak..
        $allow = true;
        $this->load->model('menu_model', 'menu');
        $where = array('module' => 'pelanggan', 'nama_menu' => '[OFF]Berbayar Pemerintah');
        $cek = $this->menu->is_available($where);
        if ($cek and !$id_dokumen_permohonan) {
            $allow = false;
        }


        if ($allow) {
            $data = array(
                'id_dokumen_permohonan' => $id_dokumen_permohonan,
                'tipe_pengajuan' => 'PEMERINTAH',
                'title' => 'Permohonan TKDN Berbayar Pemerintah'
            );
            $this->open_form_dokumen_permohonan($data);
        } else {
            $this->lost();
        }
    }
    function open_form_dokumen_permohonan($data_form)
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();
            $id_pelanggan = $this->session->userdata('id_pelanggan');
            #find last dokumen...
            $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
            $order_permohonan = " id_dokumen_permohonan DESC";
            $limit_permohonan = "1,0";
            $where_permohonan = array('active' => 1, 'id_pelanggan' => $id_pelanggan);
            $data_send_permohonan = array('where' => $where_permohonan, 'order' => $order_permohonan, 'limit' => $limit_permohonan);
            $load_data_permohonan = $this->dokumen_permohonan->load_data($data_send_permohonan);
            $dokumen_permohonan = null;
            $dokumen_ready = false;
            if ($load_data_permohonan->num_rows() > 0) {
                $dokumen_ready = true;
                $dokumen_permohonan = $load_data_permohonan->row();
            }

            $this->load->model('tipe_permohonan_model', 'tipe_permohonan');
            $where = array('active' => 1);  #show active data...
            $send_data = array('where' => $where);
            $tipe_permohonan = $this->tipe_permohonan->load_data($send_data);

            $this->load->model("Kriteria_bpm_model", "kriteria_bpm");
            $where = array('active' => 1);
            $data_send = array('where' => $where);
            $kriteria_bpm = $this->kriteria_bpm->load_data($data_send);

            $data_edit = '';
            if ($data_form['id_dokumen_permohonan']) {
                #jika ada data ini maka artinya ini edit...
                #cek apakah boleh di edit atau tidak...
                $where = array(
                    'active' => 1,
                    'id_dokumen_permohonan' => $data_form['id_dokumen_permohonan'],
                    'id_pelanggan' => $id_pelanggan,
                    'status_pengajuan' => 3
                );
                $data_send = array('where' => $where);
                $load_data = $this->dokumen_permohonan->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $data_edit = $load_data->row();
                } else {
                    $this->lost();
                    return;
                }
            }

            $konten = array(
                'title' => $data_form['title'],
                'notif' => $notif,
                'tipe_permohonan' => $tipe_permohonan,
                'dokumen_ready' => $dokumen_ready,
                'dokumen_permohonan' => $dokumen_permohonan,
                'kriteria_bpm' => $kriteria_bpm,
                'tipe_pengajuan' => $data_form['tipe_pengajuan'],
                'data_edit' => $data_edit
            );
            $this->load->view('pelanggan_area/dokumen_permohonan/form_dokumen_permohonan', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function riwayat_permohonan_tkdn()
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Riwayat Permohonan TKDN', 'notif' => $notif,);
            $this->load->view('pelanggan_area/dokumen_permohonan/riwayat_dokumen_permohonan', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function riwayat_verifikasi_tkdn()
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Riwayat Verifikasi TKDN', 'notif' => $notif,);
            $this->load->view('pelanggan_area/verifikasi_tkdn/riwayat_verifikasi_tkdn', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_penawaran($id_dokumen_permohonan = '')
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();
            $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
            $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $where = array('dokumen_permohonan.active' => 1, 'dokumen_permohonan.id_dokumen_permohonan' => $id_dokumen_permohonan, 'id_pelanggan' => $this->session->userdata('id_pelanggan'), 'status_pengajuan >=' => 10);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $surat_penawaran = $load_data->row();
                $konten = array('title' => 'Lihat Surat Penawaran', 'notif' => $notif, 'surat_penawaran' => $surat_penawaran);
                $this->load->view('pelanggan_area/dokumen_penawaran', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_oc($id_dokumen_permohonan = '')
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();
            $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
            $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $join[2] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
            $where = array('dokumen_permohonan.active' => 1, 'dokumen_permohonan.id_dokumen_permohonan' => $id_dokumen_permohonan, 'id_pelanggan' => $this->session->userdata('id_pelanggan'), 'status_pengajuan >=' => 10);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $surat_oc = $load_data->row();
                $konten = array('title' => 'Lihat Surat OC', 'notif' => $notif, 'surat_oc' => $surat_oc);
                $this->load->view('pelanggan_area/lihat_dokumen/dokumen_oc', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_oc_pelanggan($id_dokumen_permohonan = '')
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();
            $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
            $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $join[2] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
            $where = array('dokumen_permohonan.active' => 1, 'dokumen_permohonan.id_dokumen_permohonan' => $id_dokumen_permohonan, 'id_pelanggan' => $this->session->userdata('id_pelanggan'), 'status_pengajuan >=' => 10);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $surat_oc = $load_data->row();
                $konten = array('title' => 'Lihat Surat OC Pelanggan', 'notif' => $notif, 'surat_oc' => $surat_oc);
                $this->load->view('pelanggan_area/lihat_dokumen/dokumen_oc_pelanggan', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_proforma_invoice($id_dokumen_permohonan = '')
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();
            $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
            $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $join[2] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
            $join[3] = array('tabel' => 'proforma_invoice', 'relation' => 'surat_oc.id_surat_oc = proforma_invoice.id_surat_oc', 'direction' => 'left');
            $where = array('dokumen_permohonan.active' => 1, 'dokumen_permohonan.id_dokumen_permohonan' => $id_dokumen_permohonan, 'id_pelanggan' => $this->session->userdata('id_pelanggan'), 'status_pengajuan >=' => 10);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $proforma_invoice = $load_data->row();
                $konten = array('title' => 'Lihat Proforma Invoice', 'notif' => $notif, 'proforma_invoice' => $proforma_invoice);
                $this->load->view('pelanggan_area/lihat_dokumen/dokumen_proforma_invoice', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_form_01($id_dokumen_permohonan = '')
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();
            $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
            $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $join[2] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
            $join[3] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
            $where = array('dokumen_permohonan.active' => 1, 'dokumen_permohonan.id_dokumen_permohonan' => $id_dokumen_permohonan, 'id_pelanggan' => $this->session->userdata('id_pelanggan'), 'status_pengajuan >=' => 25);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $form_01 = $load_data->row();
                $konten = array('title' => 'Lihat Form 01', 'notif' => $notif, 'form_01' => $form_01);
                $this->load->view('pelanggan_area/lihat_dokumen/dokumen_form_01', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function lihat_invoice($id_dokumen_permohonan = '')
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();
            $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
            $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $join[2] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
            $join[3] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
            $join[4] = array('tabel' => 'payment_detail', 'relation' => 'payment_detail.id_form_01 = form_01.id_form_01', 'direction' => 'left');
            $where = array('dokumen_permohonan.active' => 1, 'dokumen_permohonan.id_dokumen_permohonan' => $id_dokumen_permohonan, 'id_pelanggan' => $this->session->userdata('id_pelanggan'), 'status_pengajuan >=' => 25);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $data = $load_data->row();
                $konten = array('title' => 'Lihat Invoice', 'notif' => $notif, 'invoice' => $data);
                $this->load->view('pelanggan_area/lihat_dokumen/invoice', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_faktur_pajak($id_dokumen_permohonan = '')
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();
            $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
            $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $join[2] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
            $join[3] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
            $join[4] = array('tabel' => 'payment_detail', 'relation' => 'payment_detail.id_form_01 = form_01.id_form_01', 'direction' => 'left');
            $where = array('dokumen_permohonan.active' => 1, 'dokumen_permohonan.id_dokumen_permohonan' => $id_dokumen_permohonan, 'id_pelanggan' => $this->session->userdata('id_pelanggan'), 'status_pengajuan >=' => 25);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $data = $load_data->row();
                $konten = array('title' => 'Lihat Faktur Pajak', 'notif' => $notif, 'faktur_pajak' => $data);
                $this->load->view('pelanggan_area/lihat_dokumen/faktur_pajak', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_bukti_potong_pph21($id_dokumen_permohonan = '')
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();
            $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
            $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $join[2] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
            $join[3] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
            $join[4] = array('tabel' => 'payment_detail', 'relation' => 'payment_detail.id_form_01 = form_01.id_form_01', 'direction' => 'left');
            $where = array('dokumen_permohonan.active' => 1, 'dokumen_permohonan.id_dokumen_permohonan' => $id_dokumen_permohonan, 'id_pelanggan' => $this->session->userdata('id_pelanggan'), 'status_pengajuan >=' => 25);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $data = $load_data->row();
                $konten = array('title' => 'Lihat Bukti Potong PPh 23', 'notif' => $notif, 'faktur_pajak' => $data);
                $this->load->view('pelanggan_area/lihat_dokumen/bukti_potong_pph21', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_pesan($id_pesan = '')
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();
            if ($id_pesan) {
                $id_pelanggan = $this->session->userdata('id_pelanggan');
                $this->load->model('pesan_model', 'pesan');
                $where = array('active' => 1, 'id_pesan' => $id_pesan, 'id_pelanggan' => $id_pelanggan);
                $data_send = array('where' => $where);
                $load_data = $this->pesan->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $data_update = array('read' => 1);
                    $where_update = array('id_pesan' => $id_pesan);
                    $this->pesan->update($data_update, $where_update, $id_pelanggan, 'pelanggan');

                    $konten = array('title' => 'Lihat Pesan', 'notif' => $notif, 'pesan' => $load_data->row());
                    $this->load->view('pelanggan_area/lihat_dokumen/pesan', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function pesan()
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Pesan', 'notif' => $notif);
            $this->load->view('pelanggan_area/pesan', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function room_negosiasi()
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();
            $id_room = htmlentities($this->input->get('room') ?? '');

            $konten = array('title' => 'Ruang Negosasi', 'notif' => $notif, 'include_path' => 'pelanggan_area/', 'id_room' => $id_room);
            $this->load->view('chat_room/room', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function upload_opening_meeting($id_opening_meeting = '')
    {
        if ($this->validasi_login_pelanggan()) {
            if ($id_opening_meeting) {
                #cek apakah id_opening_meeting valid...
                $this->load->model('opening_meeting_model', 'opening_meeting');
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_pelanggan' => $this->session->userdata('id_pelanggan'), 'id_status IN (4, 6)' => null);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();
                    $notif = $this->notifikasi();
                    $konten = array('title' => 'Upload Dokumen Opening Meeting', 'notif' => $notif, 'opening_meeting' => $opening_meeting);
                    $this->load->view('pelanggan_area/opening_meeting/form_upload_dokumen', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function upload_daftar_tanda_sah($id_opening_meeting = '')
    {
        if ($this->validasi_login_pelanggan()) {
            if ($id_opening_meeting) {
                #cek apakah id_opening_meeting valid...
                $this->load->model('opening_meeting_model', 'opening_meeting');
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $join[1] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[3] = array('tabel' => 'surat_oc', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[4] = array('tabel' => 'proforma_invoice', 'relation' => 'proforma_invoice.id_surat_oc = surat_oc.id_surat_oc', 'direction' => 'left');
                $join[5] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[6] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');

                $join[7] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[8] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

                $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'pelanggan.id_pelanggan' => $this->session->userdata('id_pelanggan'), 'id_status IN (22, 23)' => null);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();

                    #ketentuan Draft tanda sah...
                    $ketentuan_file = null;
                    $this->load->model('panel_internal_nama_file_model', 'panel_internal_nama_file');
                    $where_file = array('panel_internal_nama_file.active' => 1, 'id_nama_file' => 9);
                    $data_send_file = array('where' => $where_file);
                    $load_data_file = $this->panel_internal_nama_file->load_data($data_send_file);
                    if ($load_data_file->num_rows() > 0) {
                        $ketentuan_file = $load_data_file->row();
                        $notif = $this->notifikasi();

                        $konten = array(
                            'title' => 'Upload Draft Tanda Sah',
                            'notif' => $notif,
                            'opening_meeting' => $opening_meeting,
                            'ketentuan_file' => $ketentuan_file,
                        );
                        $this->load->view('pelanggan_area/panel_internal/daftar_tanda_sah', $this->data_halaman($konten));
                    } else {
                        $this->lost();
                    }
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function daftar_tanda_sah($id_opening_meeting = '')
    {
        if ($this->validasi_login_pelanggan()) {
            if ($id_opening_meeting) {
                #cek apakah id_opening_meeting valid...
                $this->load->model('opening_meeting_model', 'opening_meeting');
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $join[1] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[3] = array('tabel' => 'surat_oc', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[4] = array('tabel' => 'proforma_invoice', 'relation' => 'proforma_invoice.id_surat_oc = surat_oc.id_surat_oc', 'direction' => 'left');
                $join[5] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[6] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');

                $join[7] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[8] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

                $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'pelanggan.id_pelanggan' => $this->session->userdata('id_pelanggan'), 'id_status >=' => 23);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();

                    #ketentuan Draft tanda sah...
                    $ketentuan_file = null;
                    $this->load->model('panel_internal_nama_file_model', 'panel_internal_nama_file');
                    $where_file = array('panel_internal_nama_file.active' => 1, 'id_nama_file' => 9);
                    $data_send_file = array('where' => $where_file);
                    $load_data_file = $this->panel_internal_nama_file->load_data($data_send_file);
                    if ($load_data_file->num_rows() > 0) {
                        $ketentuan_file = $load_data_file->row();
                        $notif = $this->notifikasi();

                        $konten = array(
                            'title' => 'Draft Tanda Sah',
                            'notif' => $notif,
                            'opening_meeting' => $opening_meeting,
                            'ketentuan_file' => $ketentuan_file,
                        );
                        $this->load->view('pelanggan_area/panel_internal/daftar_tanda_sah', $this->data_halaman($konten));
                    } else {
                        $this->lost();
                    }
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function collecting_dokumen($id_opening_meeting = '')
    {
        if ($this->validasi_login_pelanggan()) {
            if ($id_opening_meeting) {
                #cek apakah id_opening_meeting valid...
                $this->load->model('opening_meeting_model', 'opening_meeting');
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $join[1] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[3] = array('tabel' => 'surat_oc', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[4] = array('tabel' => 'proforma_invoice', 'relation' => 'proforma_invoice.id_surat_oc = surat_oc.id_surat_oc', 'direction' => 'left');
                $join[5] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[6] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');

                $join[7] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[8] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

                $join[9] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
                $join[10] = array('tabel' => 'mst_admin', 'relation' => 'opening_meeting.id_assesor = mst_admin.id_admin', 'direction' => 'left');

                $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'dokumen_permohonan.id_pelanggan' => $this->session->userdata('id_pelanggan'), 'id_status >= 7' => null);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();
                    $notif = $this->notifikasi();

                    $konten = array('title' => 'Pengumpulan Dokumen', 'notif' => $notif, 'opening_meeting' => $opening_meeting);
                    $this->load->view('pelanggan_area/collecting_dokumen/form_upload_dokumen', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function lihat_surat_pemberitahuan_pemenuhan_dokumen($id_opening_meeting = '')
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();

            $this->load->model('opening_meeting_model', 'opening_meeting');
            $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'pemberitahuan_pemenuhan_dokumen', 'relation' => 'pemberitahuan_pemenuhan_dokumen.id_opening_meeting = opening_meeting.id_opening_meeting', 'direction' => 'left');
            $where = array('opening_meeting.active' => 1, 'opening_meeting.id_opening_meeting' => $id_opening_meeting, 'id_pelanggan' => $this->session->userdata('id_pelanggan'), 'id_status >= ' => 10);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->opening_meeting->load_data($data_send);
            if ($load_data->num_rows() > 0) {

                $konten = array('title' => 'Lihat Surat Pemberitahuan Pemenuhan Dokumen', 'notif' => $notif, 'id_opening_meeting' => $id_opening_meeting);
                $this->load->view('pelanggan_area/verifikasi_tkdn/lihat_pemberitahuan_pemenuhan_dokumen', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function lihat_surat_permohonan_perpanjangan_waktu($id_opening_meeting = '')
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();

            $this->load->model('opening_meeting_model', 'opening_meeting');
            $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'pemberitahuan_pemenuhan_dokumen', 'relation' => 'pemberitahuan_pemenuhan_dokumen.id_opening_meeting = opening_meeting.id_opening_meeting', 'direction' => 'left');
            $where = array('opening_meeting.active' => 1, 'opening_meeting.id_opening_meeting' => $id_opening_meeting, 'id_pelanggan' => $this->session->userdata('id_pelanggan'), 'id_status >= ' => 11);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->opening_meeting->load_data($data_send);
            if ($load_data->num_rows() > 0) {

                $konten = array('title' => 'Surat Permohonan Perpanjangan Waktu', 'notif' => $notif, 'opening_meeting' => $load_data->row(), 'id_opening_meeting' => $id_opening_meeting);
                $this->load->view('pelanggan_area/verifikasi_tkdn/lihat_permohonan_perpanjangan_waktu', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }


    public function collecting_dokumen_tahap_2($id_opening_meeting = '')
    {
        if ($this->validasi_login_pelanggan()) {
            $this->load->model('opening_meeting_model', 'opening_meeting');
            $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');

            $join[1] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
            $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $join[3] = array('tabel' => 'surat_oc', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
            $join[4] = array('tabel' => 'proforma_invoice', 'relation' => 'proforma_invoice.id_surat_oc = surat_oc.id_surat_oc', 'direction' => 'left');
            $join[5] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
            $join[6] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');

            $join[7] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
            $join[8] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');


            $join[9] = array('tabel' => 'pemberitahuan_pemenuhan_dokumen', 'relation' => 'pemberitahuan_pemenuhan_dokumen.id_opening_meeting = opening_meeting.id_opening_meeting', 'direction' => 'left');
            $where = array('opening_meeting.active' => 1, 'opening_meeting.id_opening_meeting' => $id_opening_meeting, 'dokumen_permohonan.id_pelanggan' => $this->session->userdata('id_pelanggan'), 'id_status >=' => 16);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->opening_meeting->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $notif = $this->notifikasi();
                $opening_meeting = $load_data->row();

                $opening_meeting->id_opening_meeting = $id_opening_meeting;

                $konten = array(
                    'notif' => $notif,
                    'title' => 'Collecting Document Tahap 2',
                    'opening_meeting' => $opening_meeting
                );
                $this->load->view('pelanggan_area/collecting_dokumen/form_upload_tahap2', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function upload_closing_meeting($id_opening_meeting = '')
    {
        if ($this->validasi_login_pelanggan()) {
            if ($id_opening_meeting) {
                #cek apakah id_opening_meeting valid...
                $this->load->model('opening_meeting_model', 'opening_meeting');
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $join[1] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[3] = array('tabel' => 'surat_oc', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[4] = array('tabel' => 'proforma_invoice', 'relation' => 'proforma_invoice.id_surat_oc = surat_oc.id_surat_oc', 'direction' => 'left');
                $join[5] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[6] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');

                $join[7] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[8] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

                $join[9] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
                $join[10] = array('tabel' => 'mst_admin', 'relation' => 'opening_meeting.id_assesor = mst_admin.id_admin', 'direction' => 'left');

                $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'dokumen_permohonan.id_pelanggan' => $this->session->userdata('id_pelanggan'), 'id_status >= 7' => null);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();
                    $notif = $this->notifikasi();

                    $konten = array('title' => 'Upload Dokumen Closing Meeting', 'notif' => $notif, 'opening_meeting' => $opening_meeting);
                    $this->load->view('pelanggan_area/closing_meeting/form_upload_dokumen', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function profil_perusahaan()
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Profil Pelanggan', 'notif' => $notif);
            $this->load->view('pelanggan_area/setting/profil_perusahaan', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function ganti_password()
    {
        if ($this->validasi_login_pelanggan()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Ganti Password', 'notif' => $notif);
            $this->load->view('pelanggan_area/setting/ganti_password', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
}
