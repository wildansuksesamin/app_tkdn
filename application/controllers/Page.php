<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function change_language($lang)
    {
        $this->session->set_userdata('language', ($lang ? $lang : 'id'));
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    function lang_loader($file = '')
    {
        $file = str_replace('page/', '', $file);
        $this->load->helper('language');
        $siteLang = $this->session->userdata('language');

        $load_lang = array('notifikasi', 'public');
        if ($file)
            $load_lang[] = $file;

        if ($siteLang) {
            $this->lang->load($load_lang, $siteLang);
        } else {
            $this->lang->load($load_lang, 'id');
        }
    }

    function notif_penugasan_pic()
    {
        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/penugasan_pic', false)) {
            $where = array('active' => 1, 'status_pengajuan' => '1');
            $penugasan_pic = $this->dokumen_permohonan->select_count($where);
            return $penugasan_pic;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }
    function notif_diverifikasi()
    {
        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/verifikasi_dokumen', false)) {
            $where = "active = 1 and status_pengajuan IN (2) and id_dokumen_permohonan IN (select id_dokumen_permohonan from dokumen_permohonan_pic pic where pic.active = 1 and pic.id_admin = '" . $this->session->userdata('id_admin') . "')";
            $diverifikasi = $this->dokumen_permohonan->select_count($where);
            return $diverifikasi;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }
    function notif_buat_rab()
    {
        if ($this->cekHakAkses('page/buat_rab', false)) {
            $select = 'count(-1) jml';
            $join[0] = array('tabel' => 'dokumen_permohonan_pic', 'relation' => 'dokumen_permohonan_pic.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'mst_admin', 'relation' => 'dokumen_permohonan_pic.id_admin = mst_admin.id_admin', 'direction' => 'left');
            $where = array('dokumen_permohonan.active' => 1, 'dokumen_permohonan_pic.active' => 1, 'status_pengajuan' => '4', 'mst_admin.id_admin' => $this->session->userdata('id_admin'));
            $data_send = array('select' => $select, 'where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            $buat_rab = $load_data->row()->jml;
            return $buat_rab;
        } else {
            return 0;
        }
    }
    function notif_approval_rab()
    {
        if ($this->cekHakAkses('page/approval_rab', false)) {
            $select = 'count(-1) jml';
            $join[0] = array('tabel' => 'dokumen_permohonan_pic', 'relation' => 'dokumen_permohonan_pic.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'mst_admin', 'relation' => 'dokumen_permohonan_pic.id_admin = mst_admin.id_admin', 'direction' => 'left');
            $where = array('dokumen_permohonan.active' => 1, 'status_pengajuan' => '5', 'id_jns_admin' => 2, 'mst_admin.id_admin' => $this->session->userdata('id_admin'));
            $data_send = array('select' => $select, 'where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            $approval_rab = $load_data->row()->jml;
            return $approval_rab;
        } else {
            return 0;
        }
    }
    function notif_rab_ditolak()
    {
        if ($this->cekHakAkses('page/rab_ditolak', false)) {
            $select = 'count(-1) jml';
            $join[0] = array('tabel' => 'dokumen_permohonan_pic', 'relation' => 'dokumen_permohonan_pic.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'mst_admin', 'relation' => 'dokumen_permohonan_pic.id_admin = mst_admin.id_admin', 'direction' => 'left');
            $where = array('dokumen_permohonan.active' => 1, 'status_pengajuan' => '6', 'id_jns_admin' => 3, 'mst_admin.id_admin' => $this->session->userdata('id_admin'));
            $data_send = array('select' => $select, 'where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            $rab_tolak = $load_data->row()->jml;
            return $rab_tolak;
        } else {
            return 0;
        }
    }
    function notif_buat_penawaran()
    {

        if ($this->cekHakAkses('page/buat_penawaran', false)) {
            $select = 'count(-1) jml';
            $where = array('dokumen_permohonan.active' => 1, 'status_pengajuan IN (7, 9)' => null);
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            $buat_penawaran = $load_data->row()->jml;

            #hanya untuk ADMIN TKDN...
            if ($this->session->userdata('id_jns_admin') == 4)
                return $buat_penawaran;
            else
                return 0;
        } else {
            return 0;
        }
    }
    function notif_Verifikasi_penawaran()
    {
        #hanya untuk KABID IG...
        if ($this->session->userdata('id_jns_admin') == 5) {
            $select = 'count(-1) jml';
            $join[] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $join[] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');
            $where = array('dokumen_permohonan.active' => 1, 'status_pengajuan' => '8', 'butuh_verifikasi_koordinator' => 0);
            $data_send = array('select' => $select, 'where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            $verifikasi_surat_penawaran = $load_data->row()->jml;

            return $verifikasi_surat_penawaran;
        } else if ($this->session->userdata('id_jns_admin') == 2) {
            $select = 'count(-1) jml';
            $join[] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $join[] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');
            $where = array('dokumen_permohonan.active' => 1, 'status_pengajuan' => '8', 'butuh_verifikasi_koordinator' => 1);
            $data_send = array('select' => $select, 'where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            $verifikasi_surat_penawaran = $load_data->row()->jml;

            return $verifikasi_surat_penawaran;
        } else
            return 0;
    }
    function notif_ruang_negosiasi()
    {

        if ($this->cekHakAkses('page/ruang_negosiasi', false)) {
            $select = "count(-1) jml";
            $join[0] = array('tabel' => 'chat_room', 'relation' => 'chat_room.id_chat_room = chat_room_conversation.id_chat_room', 'direction' => 'left');
            $where = "chat_room_conversation.active = 1 
                    and chat_room.active = 1
                    and chat_room.status = 1 
                    and read = 0  
                    and tabel_pengirim = 'pelanggan'";

            if ($this->session->userdata('id_jns_admin') == '3') {
                $where .= " and id_assesor = '" . $this->session->userdata('id_admin') . "'  ";
            }
            $data_send = array('select' => $select, 'where' => $where, 'join' => $join);
            $load_data = $this->chat_room_conversation->load_data($data_send);
            $jml_chat = $load_data->row()->jml;
            return $jml_chat;
        } else {
            return 0;
        }
    }

    function notif_masa_collecting_dokumen()
    {
        #hanya untuk Verifikator...
        if ($this->session->userdata('id_jns_admin') == 3) {
            $select = 'count(-1) jml';
            $where = "dokumen_permohonan.active = 1 and status_pengajuan = 12 and id_dokumen_permohonan IN (select id_dokumen_permohonan from dokumen_permohonan_pic where dokumen_permohonan_pic.active = 1 and dokumen_permohonan_pic.id_admin = '" . $this->session->userdata('id_admin') . "')";
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            return $load_data->row()->jml;
        } else
            return 0;
    }
    function notif_waktu_pelaksanaan()
    {

        #hanya untuk Verifikator...
        if ($this->session->userdata('id_jns_admin') == 3) {
            $select = 'count(-1) jml';
            $where = "dokumen_permohonan.active = 1 and status_pengajuan = 25 and id_dokumen_permohonan IN (select id_dokumen_permohonan from dokumen_permohonan_pic where dokumen_permohonan_pic.active = 1 and dokumen_permohonan_pic.id_admin = '" . $this->session->userdata('id_admin') . "')";
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            return $load_data->row()->jml;
        } else
            return 0;
    }
    function notif_buat_konfirmasi_order()
    {

        #hanya untuk Admin...
        if ($this->session->userdata('id_jns_admin') == 4) {

            $select = 'count(-1) jml';
            $where = "dokumen_permohonan.active = 1 and status_pengajuan IN (13, 14)";
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            $buat_konfirmasi_order = $load_data->row()->jml;
            return $buat_konfirmasi_order;
        } else
            return 0;
    }
    function notif_buat_reminder_pembayaran_oc()
    {

        #hanya untuk Verifikator saja...
        if ($this->session->userdata('id_jns_admin') == 3) {
            $this->load->model('surat_oc_model', 'surat_oc');
            $relation[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
            $relation[1] = array('tabel' => 'rab', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');
            $relation[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $relation[3] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
            $relation[4] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');

            $select = "count(-1) jml";
            $where = "surat_oc.active = 1  and surat_penawaran.active = 1";
            $where .= " and dokumen_permohonan.status_pengajuan IN (21,22) 
                                        and dokumen_permohonan.id_dokumen_permohonan NOT IN (select id_dokumen_permohonan from pesan where tag = 'reminder_pembayaran_oc')
                                        and DATE_ADD(tgl_oc, INTERVAL (batas_waktu_pembayaran - 7) DAY) <= '" . date('Y-m-d') . "' 
                                        and dokumen_permohonan.id_dokumen_permohonan IN (
                                            select id_dokumen_permohonan 
                                            from dokumen_permohonan_pic 
                                            where dokumen_permohonan_pic.active = 1 
                                                and dokumen_permohonan_pic.id_admin = '" . $this->session->userdata('id_admin') . "'
                                        )";
            $data_send = array('where' => $where, 'join' => $relation, 'select' => $select);
            $load_data = $this->surat_oc->load_data($data_send);
            return $load_data->row()->jml;
        } else {
            return 0;
        }
    }
    function notif_buat_proforma_invoice()
    {

        #hanya untuk Admin...
        if ($this->session->userdata('id_jns_admin') == 4) {

            $select = 'count(-1) jml';
            $where = "dokumen_permohonan.active = 1 and status_pengajuan IN (17, 18)";
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            $buat_konfirmasi_order = $load_data->row()->jml;
            return $buat_konfirmasi_order;
        } else
            return 0;
    }
    function notif_verifikasi_proforma_invoice()
    {
        $status_pengajuan = 'x';
        $allow_notif = false;
        if ($this->session->userdata('id_jns_admin') == '5') {
            $status_pengajuan = '19';
            $allow_notif = true;
        } else if ($this->session->userdata('id_jns_admin') == '7') {
            $status_pengajuan = '20';
            $allow_notif = true;
        }

        $select = 'count(-1) jml';
        $where = "dokumen_permohonan.active = 1 and status_pengajuan = '" . $status_pengajuan . "'";
        $data_send = array('select' => $select, 'where' => $where);
        $load_data = $this->dokumen_permohonan->load_data($data_send);
        $jml_notif = $load_data->row()->jml;

        #hanya untuk Admin...
        if ($allow_notif)
            return $jml_notif;
        else
            return 0;
    }
    function notif_verifikasi_konfirmasi_order()
    {
        $select = 'count(-1) jml';

        #hanya untuk Admin...
        if ($this->session->userdata('id_jns_admin') == 2) { #koordinator
            $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $where = "dokumen_permohonan.active = 1 and status_pengajuan = 15 and id_koordinator = '" . $this->session->userdata('id_admin') . "'";
            $data_send = array('select' => $select, 'where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            return $load_data->row()->jml;
        } else if ($this->session->userdata('id_jns_admin') == 5) { #kabid...
            $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $where = "dokumen_permohonan.active = 1 and status_pengajuan = 16 and id_kabid = '" . $this->session->userdata('id_admin') . "'";
            $data_send = array('select' => $select, 'where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            return $load_data->row()->jml;
        } else
            return 0;
    }
    function notif_verifikasi_bukti_bayar()
    {

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/verifikasi_bukti_bayar', false)) {
            $select = 'count(-1) jml';
            $where = "dokumen_permohonan.active = 1 and status_pengajuan = 23";
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }

    function notif_buat_form_01()
    {

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/buat_form_01', false)) {
            $select = 'count(-1) jml';
            $where = "dokumen_permohonan.active = 1 and status_pengajuan IN (26, 27)";
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }
    function notif_verifikasi_form_01()
    {
        $allow = false;
        if ($this->session->userdata('id_jns_admin') == 2) { #koordinator
            $status_pengajuan = 28;
            $allow = true;
        } else if ($this->session->userdata('id_jns_admin') == 5) { #kabid...
            $status_pengajuan = 29;
            $allow = true;
        }

        if ($allow) {
            $select = 'count(-1) jml';
            $where = "dokumen_permohonan.active = 1 and status_pengajuan = '" . $status_pengajuan . "'";
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->dokumen_permohonan->load_data($data_send);

            #cek apakah admin memiliki hak akses menu ini...
            if ($this->cekHakAkses('page/verifikasi_form_01', false)) {
                return $load_data->row()->jml;
            } else #jika tidak, maka jangan beri notifikasi...
                return 0;
        } else {
            return 0;
        }
    }
    function notif_buat_payment_detail()
    {
        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/buat_payment_detail', false)) {
            $select = 'count(-1) jml';
            $where = "dokumen_permohonan.active = 1 and status_pengajuan IN (30, 31)";
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }
    function notif_verifikasi_payment_detail()
    {
        $allow = false;
        if ($this->session->userdata('id_jns_admin') == 5) { #kabid...
            $status_pengajuan = 32;
            $allow = true;
        }

        if ($allow) {
            $select = 'count(-1) jml';
            $where = "dokumen_permohonan.active = 1 and status_pengajuan = '" . $status_pengajuan . "'";
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->dokumen_permohonan->load_data($data_send);

            #cek apakah admin memiliki hak akses menu ini...
            if ($this->cekHakAkses('page/verifikasi_payment_detail', false)) {
                return $load_data->row()->jml;
            } else #jika tidak, maka jangan beri notifikasi...
                return 0;
        } else {
            return 0;
        }
    }
    function notif_upload_invoice_faktur_pajak()
    {

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/upload_invoice_faktur_pajak', false)) {
            $select = 'count(-1) jml';
            $where = "dokumen_permohonan.active = 1 and status_pengajuan = '33'";
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }
    function notif_penugasan_assesor()
    {

        #hanya untuk Koordinator...
        if ($this->session->userdata('id_jns_admin') == 2) {
            $select = 'count(-1) jml';
            $where = "dokumen_permohonan.active = 1 and status_pengajuan = 34 and id_dokumen_permohonan not in (select id_permohonan from opening_meeting where opening_meeting.active = 1)";
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            $jml_notif = $load_data->row()->jml;
            return $jml_notif;
        } else
            return 0;
    }
    function notif_buat_surat_tugas()
    {

        $select = 'count(-1) jml';

        $where = "opening_meeting.active = 1 and id_assesor = '" . $this->session->userdata('id_admin') . "' and id_status IN (1, 2)";

        $data_send = array('select' => $select, 'where' => $where);
        $load_data = $this->opening_meeting->load_data($data_send);
        $jml_notif = $load_data->row()->jml;

        return $jml_notif;
    }
    function notif_upload_dokumen_opening_meeting()
    {

        $select = 'count(-1) jml';

        $where = "opening_meeting.active = 1 and id_assesor = '" . $this->session->userdata('id_admin') . "' and id_status IN (3)";

        $data_send = array('select' => $select, 'where' => $where);
        $load_data = $this->opening_meeting->load_data($data_send);
        $jml_notif = $load_data->row()->jml;

        return $jml_notif;
    }
    function notif_verifikasi_dokumen_opening_meeting()
    {
        $select = 'count(-1) jml';

        $where = "opening_meeting.active = 1 and id_assesor = '" . $this->session->userdata('id_admin') . "' and id_status IN (5)";

        $data_send = array('select' => $select, 'where' => $where);
        $load_data = $this->opening_meeting->load_data($data_send);
        $jml_notif = $load_data->row()->jml;

        return $jml_notif;
    }

    function notif_pengumpulan_dokumen()
    {
        $id_assesor = $this->session->userdata('id_admin');
        $this->load->model('opening_meeting_model', 'opening_meeting');

        #apakah ada dokumen yang ingin diverifikasi...
        $select_verifikasi = "count(-1) jml";
        $join_verifikasi[0] = array('tabel' => 'collecting_dokumen', 'relation' => 'collecting_dokumen.id_opening_meeting = opening_meeting.id_opening_meeting', 'direction' => 'left');
        $where_verifikasi = array('opening_meeting.active' => 1, 'id_assesor' => $id_assesor, 'status_verifikasi' => '0');
        $data_send_verifikasi = array('select' => $select_verifikasi, 'where' => $where_verifikasi, 'join' => $join_verifikasi);
        $jml_verifikasi = $this->opening_meeting->load_data($data_send_verifikasi)->row()->jml;

        #apakah ada sisa hari pengumpulan dokumen yang <= 7 hari..
        $select_sisa_hari = "count(-1) jml";
        $where_sisa_hari = array('opening_meeting.active' => 1, 'id_assesor' => $id_assesor, 'masa_collecting_dokumen - DATEDIFF(CURDATE(), tgl_mulai_verifikasi_dokumen) <= 7' => null);
        $data_send_sisa_hari = array('select' => $select_sisa_hari, 'where' => $where_sisa_hari);
        $jml_sisa_hari = $this->opening_meeting->load_data($data_send_sisa_hari)->row()->jml;

        #surat pemberitahuan ditolak...
        $select_pemberitahuan_ditolak = "count(-1) jml";
        $where_pemberitahuan_ditolak = array('opening_meeting.active' => 1, 'id_assesor' => $id_assesor, 'id_status' => 9);
        $data_send_pemberitahuan_ditolak = array('select' => $select_pemberitahuan_ditolak, 'where' => $where_pemberitahuan_ditolak);
        $jml_pemberitahuan_ditolak = $this->opening_meeting->load_data($data_send_pemberitahuan_ditolak)->row()->jml;

        #apakah ada surat permohonan perpanjangan waktu yang perlu diverifikasi...
        $select_perpanjangan = "count(-1) jml";
        $where_perpanjangan = array('opening_meeting.active' => 1, 'id_assesor' => $id_assesor, 'id_status' => 11);
        $data_send_perpanjangan = array('select' => $select_perpanjangan, 'where' => $where_perpanjangan);
        $jml_perpanjangan = $this->opening_meeting->load_data($data_send_perpanjangan)->row()->jml;

        $total_notif = $jml_sisa_hari + $jml_perpanjangan + $jml_verifikasi + $jml_pemberitahuan_ditolak;
        return $total_notif;
    }
    function notif_verifikasi_pemberitahuan_pemenuhan_dokumen()
    {

        $select = 'count(-1) jml';
        if ($this->session->userdata('id_jns_admin') == 2) {
            $id_status = 8;
        } else if ($this->session->userdata('id_jns_admin') == 5) {
            $id_status = 9;
        } else {
            $id_status = 'x';
        }
        $where = "opening_meeting.active = 1 and id_status = '" . $id_status . "'";

        $data_send = array('select' => $select, 'where' => $where);
        $load_data = $this->opening_meeting->load_data($data_send);
        $jml_notif = $load_data->row()->jml;

        return $jml_notif;
    }
    function notif_verifikasi_permohonan_perpanjangan_waktu()
    {

        $select = 'count(-1) jml';
        if ($this->session->userdata('id_jns_admin') == 3) {
            $id_status = 12;
        } else {
            $id_status = 'x';
        }
        $where = "opening_meeting.active = 1 and id_assesor = '" . $this->session->userdata('id_admin') . "' and id_status = '" . $id_status . "'";

        $data_send = array('select' => $select, 'where' => $where);
        $load_data = $this->opening_meeting->load_data($data_send);
        $jml_notif = $load_data->row()->jml;

        return $jml_notif;
    }
    function notif_penungasan_assesor_lapangan()
    {
        if ($this->cekHakAkses('page/penungasan_assesor_lapangan', false)) {
            $this->load->model('opening_meeting_model', 'opening_meeting');
            $select = "count(-1) jml";
            $where = array('opening_meeting.active' => 1, 'id_status >=' => 15);
            $where = "opening_meeting.active = 1 and id_status >= 15 and id_opening_meeting not in (select id_opening_meeting from survey_lapangan_assesor where survey_lapangan_assesor.active = 1)";
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->opening_meeting->load_data($data_send);
            $jml = $load_data->row()->jml;
            return $jml;
        } else {
            return 0;
        }
    }
    function notif_pekerjaan()
    {
        $id_admin = $this->session->userdata('id_admin');
        $this->load->model('survey_lapangan_perjab_model', 'survey_lapangan_perjab');

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/pekerjaan', false)) {
            #dokumen survey lapangan ditolak...
            $select = "count(-1) jml";
            $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = survey_lapangan_perjab.id_opening_meeting', 'direction' => 'left');
            $where = array('survey_lapangan_perjab.active' => 1, 'status_verifikasi' => 0, 'opening_meeting.id_opening_meeting in (select id_opening_meeting from survey_lapangan_assesor where id_admin = \'' . $id_admin . '\')' => null);
            $data_send = array('where' => $where, 'select' => $select, 'join' => $join);
            $load_data = $this->survey_lapangan_perjab->load_data($data_send);
            $jml_notif_tolak = $load_data->row()->jml;
            if ($jml_notif_tolak == 0) {
                #data pekerjaan...
                $this->load->model('opening_meeting_model', 'opening_meeting');
                $where = "opening_meeting.active = 1 and id_status >= 15 and id_opening_meeting IN (select id_opening_meeting from survey_lapangan_assesor a where a.active = 1 and a.id_admin = '" . $this->session->userdata('id_admin') . "')";
                $data_send = array('select' => $select, 'where' => $where);
                $load_data = $this->opening_meeting->load_data($data_send);
                $jml_notif = $load_data->row()->jml;
                return $jml_notif;
            } else {
                return $jml_notif_tolak;
            }
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }
    function notif_verifikasi_dokumen_survey_lapangan()
    {
        $id_jns_admin = $this->session->userdata('id_jns_admin');
        $this->load->model('survey_lapangan_perjab_model', 'survey_lapangan_perjab');
        $jml_notif = 0;
        if ($id_jns_admin == 2) { #admin TKDN...
            $select = "count(-1) jml";
            $where = array('survey_lapangan_perjab.active' => 1, 'status_verifikasi' => 2);
            $data_send = array('where' => $where, 'select' => $select);
            $load_data = $this->survey_lapangan_perjab->load_data($data_send);
            $jml_notif = $load_data->row()->jml;
        } else if ($id_jns_admin == 4) { #admin TKDN...
            $select = "count(-1) jml";
            $where = array('survey_lapangan_perjab.active' => 1, 'status_verifikasi' => 3);
            $data_send = array('where' => $where, 'select' => $select);
            $load_data = $this->survey_lapangan_perjab->load_data($data_send);
            $jml_notif = $load_data->row()->jml;
        }

        return $jml_notif;
    }

    function notif_verifikasi_collecting_document_2()
    {
        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/verifikasi_collecting_document_2', false)) {

            $select = "count(-1) jml";
            $where = "active = 1 and id_status = 16 and id_opening_meeting IN (select id_opening_meeting from survey_lapangan_assesor a where a.active = 1 and a.id_admin = '" . $this->session->userdata('id_admin') . "')";

            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->opening_meeting->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }
    function notif_upload_dokumen_panel_internal()
    {
        $this->load->model('opening_meeting_model', 'opening_meeting');

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/upload_dokumen_panel_internal', false)) {
            $id_jns_admin = $this->session->userdata('id_jns_admin');

            $select = "count(-1) jml";
            $where = "active = 1 and (id_status >= 17 and id_status <= 18)";

            if ($id_jns_admin == 3) {
                $where .= " and id_opening_meeting IN (select id_opening_meeting from survey_lapangan_assesor a where a.active = 1 and a.id_admin = '" . $this->session->userdata('id_admin') . "')";
            } else if ($id_jns_admin == 4) {
            } else {
                $where .= " and id_opening_meeting = 'xxx'";
            }

            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->opening_meeting->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }

    function notif_verifikasi_dokumen_panel_internal()
    {
        $this->load->model('opening_meeting_model', 'opening_meeting');

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/verifikasi_dokumen_panel_internal', false)) {
            $select = "count(-1) jml";
            $where = "active = 1 and id_status = 19";

            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->opening_meeting->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }

    function notif_penugasan_etc()
    {
        $this->load->model('opening_meeting_model', 'opening_meeting');

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/penugasan_etc', false)) {
            $select = "count(-1) jml";
            $where = "active = 1 and id_status = 20";

            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->opening_meeting->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }

    function notif_approval_assesment_etc()
    {
        $this->load->model('opening_meeting_model', 'opening_meeting');

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/approval_assesment_etc', false)) {
            $select = "count(-1) jml";
            $where = "active = 1 and id_status = 21";
            $where .= " and id_opening_meeting IN (select id_opening_meeting from opening_meeting_etc a where a.active = 1 and a.id_admin = '" . $this->session->userdata('id_admin') . "')";

            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->opening_meeting->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }
    function notif_verifikasi_draft_tanda_sah()
    {
        $this->load->model('opening_meeting_model', 'opening_meeting');

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/verifikasi_draft_tanda_sah', false)) {
            $select = "count(-1) jml";
            $where = "active = 1 and id_status = 24";
            $where .= " and id_opening_meeting IN (select id_opening_meeting from survey_lapangan_assesor a where a.active = 1 and a.id_admin = '" . $this->session->userdata('id_admin') . "')";

            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->opening_meeting->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }
    function notif_assesment_kemenperin()
    {
        $this->load->model('opening_meeting_model', 'opening_meeting');

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/assessment_kemenperin', false)) {
            $select = "count(-1) jml";
            $where = "active = 1 and (
                id_status = 25 
                or (
                    select count(-1) jml 
                    from panel_kemenperin_dokumen 
                    where panel_kemenperin_dokumen.active = 1 
                        and id_closing_meeting = 0 
                        and panel_kemenperin_dokumen.id_opening_meeting = opening_meeting.id_opening_meeting 
                        and id_nama_file in 
                            (
                                select id_nama_file 
                                from panel_kemenperin_nama_file 
                                where panel_kemenperin_nama_file.active = 1 and to_closing_meeting = 1
                            )
                ) > 0
            )";
            $where .= " and id_opening_meeting IN (select id_opening_meeting from survey_lapangan_assesor a where a.active = 1 and a.id_admin = '" . $this->session->userdata('id_admin') . "')";

            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->opening_meeting->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }

    function notif_upload_closing_meeting()
    {
        $this->load->model('closing_meeting_model', 'closing_meeting');

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/upload_closing_meeting', false)) {
            $select = "count(-1) jml";
            $where = "active = 1 and status IN (0, 1)";
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->closing_meeting->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }
    function notif_verifikasi_closing_meeting()
    {
        $this->load->model('closing_meeting_model', 'closing_meeting');

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/verifikasi_closing_meeting', false)) {
            $id_jns_admin = $this->session->userdata('id_jns_admin');
            #cek apakah jenis admin adalah koordinator atau dokumen kontrol...
            $status = 'x';
            if ($id_jns_admin == 2) { #koordinator...
                $status = 3;
            } else if ($id_jns_admin == 8) { #dokumen kontrol...
                $status = 2;
            } else {
                return 0;
            }

            $select = "count(-1) jml";
            $where = "active = 1 and status = '" . $status . "'";
            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->closing_meeting->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }

    function notif_buat_payment_detail_2()
    {
        $this->load->model('opening_meeting_model', 'opening_meeting');

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/buat_payment_detail_2', false)) {
            $select = "count(-1) jml";
            $where = "active = 1 and id_status IN (30, 31)";

            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->opening_meeting->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }
    function notif_verifikasi_payment_detail_2()
    {
        $this->load->model('opening_meeting_model', 'opening_meeting');

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/verifikasi_payment_detail_2', false)) {
            $select = "count(-1) jml";
            $where = "active = 1 and id_status = 32";

            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->opening_meeting->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }
    function notif_upload_surat_tugas_sistem()
    {
        $this->load->model('opening_meeting_model', 'opening_meeting');

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/upload_surat_tugas_sistem', false)) {
            $select = "count(-1) jml";
            $where = "active = 1 and id_status = 33";

            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->opening_meeting->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }
    function notif_upload_invoice_faktur_pajak_2()
    {
        $this->load->model('opening_meeting_model', 'opening_meeting');

        #cek apakah admin memiliki hak akses menu ini...
        if ($this->cekHakAkses('page/upload_invoice_faktur_pajak_2', false)) {
            $select = "count(-1) jml";
            $where = "active = 1 and id_status = 34";

            $data_send = array('select' => $select, 'where' => $where);
            $load_data = $this->opening_meeting->load_data($data_send);
            return $load_data->row()->jml;
        } else #jika tidak, maka jangan beri notifikasi...
            return 0;
    }


    function notifikasi()
    {
        $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
        $this->load->model("chat_room_conversation_model", "chat_room_conversation");
        $this->load->model('opening_meeting_model', 'opening_meeting');
        $this->load->model('sppd_project_model', 'sppd_project');

        $sub_module_order_tkdn = 0;
        $sub_module_verifikasi_tkdn = 0;

        $penugasan_pic = $this->notif_penugasan_pic();
        $diverifikasi = $this->notif_diverifikasi();

        $verifikasi_grup = '';
        $jml = $penugasan_pic + $diverifikasi;
        $sub_module_order_tkdn += $jml;
        if ($jml > 0) {
            $verifikasi_grup = array(
                'Penugasan PIC' => $penugasan_pic,
                'Verifikasi Dokumen' => $diverifikasi,
            );
        }
        #==============================

        #buat RAB...
        $buat_rab = $this->notif_buat_rab();

        #approval RAB...
        $approval_rab = $this->notif_approval_rab();

        #rab ditolak...
        $rab_tolak = $this->notif_rab_ditolak();

        #Buat Penawaran...
        $buat_penawaran = $this->notif_buat_penawaran();

        $rab_grup = '';
        $jml = $buat_rab + $approval_rab + $rab_tolak + $buat_penawaran;
        $sub_module_order_tkdn += $jml;
        if ($jml > 0) {
            $rab_grup = array(
                'Buat RAB' => $buat_rab,
                'Approval RAB' => $approval_rab,
                'RAB Ditolak' => $rab_tolak,
                'Buat Penawaran' => $buat_penawaran,
            );
        }

        #==============================

        #verifikasi surat penawaran...
        $verifikasi_surat_penawaran = $this->notif_Verifikasi_penawaran();
        $sub_module_order_tkdn += $verifikasi_surat_penawaran;

        #==============================
        $ruang_negosiasi = $this->notif_ruang_negosiasi();
        $sub_module_order_tkdn += $ruang_negosiasi;

        #==============================

        $masa_collecting_dokumen = $this->notif_masa_collecting_dokumen();
        $waktu_pelaksanaan = $this->notif_waktu_pelaksanaan();
        $buat_konfirmasi_order = $this->notif_buat_konfirmasi_order();
        $buat_proforma_invoice = $this->notif_buat_proforma_invoice();
        $verifikasi_proforma_invoice = $this->notif_verifikasi_proforma_invoice();
        $verifikasi_konfirmasi_order = $this->notif_verifikasi_konfirmasi_order();
        $verifikasi_bukti_bayar = $this->notif_verifikasi_bukti_bayar();
        $buat_reminder_pembayaran_oc = $this->notif_buat_reminder_pembayaran_oc();
        $konfirmasi_order_grup = '';
        $jml_konfirmasi_order_grup = $masa_collecting_dokumen + $waktu_pelaksanaan + $buat_konfirmasi_order + $buat_proforma_invoice + $verifikasi_proforma_invoice + $verifikasi_konfirmasi_order + $verifikasi_bukti_bayar + $buat_reminder_pembayaran_oc;
        $sub_module_order_tkdn += $jml_konfirmasi_order_grup;
        if ($jml_konfirmasi_order_grup > 0) {
            $konfirmasi_order_grup = array(
                'Masa Collecting Dokumen' => $masa_collecting_dokumen,
                'Waktu Pelaksanaan' => $waktu_pelaksanaan,
                'Buat Konfirmasi Order' => $buat_konfirmasi_order,
                'Buat Proforma Invoice' => $buat_proforma_invoice,
                'Verifikasi Proforma Invoice' => $verifikasi_proforma_invoice,
                'Verifikasi Konfirmasi Order' => $verifikasi_konfirmasi_order,
                'Verifikasi Bukti Bayar & OC Pelanggan' => $verifikasi_bukti_bayar,
                'Reminder Pembayaran OC' => $buat_reminder_pembayaran_oc,

            );
        }

        $buat_form_01 = $this->notif_buat_form_01();
        $verifikasi_form_01 = $this->notif_verifikasi_form_01();
        $buat_payment_detail = $this->notif_buat_payment_detail();
        $verifikasi_payment_detail = $this->notif_verifikasi_payment_detail();
        $upload_invoice_faktur_pajak = $this->notif_upload_invoice_faktur_pajak();
        $open_order_grup = '';
        $jml_open_order_grup = $buat_form_01 + $verifikasi_form_01 + $buat_payment_detail + $verifikasi_payment_detail + $upload_invoice_faktur_pajak;
        $sub_module_order_tkdn += $jml_open_order_grup;
        if ($jml_open_order_grup) {
            $open_order_grup = array(
                'Buat Form 01' => $buat_form_01,
                'Verifikasi Form 01' => $verifikasi_form_01,
                'Buat Payment Detail' => $buat_payment_detail,
                'Verifikasi Payment Detail' => $verifikasi_payment_detail,
                'Upload Invoice & Faktur Pajak' => $upload_invoice_faktur_pajak,
            );
        }

        $penugasan_assesor = $this->notif_penugasan_assesor();
        $buat_surat_tugas = $this->notif_buat_surat_tugas();
        $upload_dokumen_opening_meeting = $this->notif_upload_dokumen_opening_meeting();
        $verifikasi_dokumen_opening_meeting = $this->notif_verifikasi_dokumen_opening_meeting();
        $open_meeting_grup = '';
        $jml_open_meeting_grup = $penugasan_assesor + $buat_surat_tugas + $upload_dokumen_opening_meeting + $verifikasi_dokumen_opening_meeting;
        $sub_module_verifikasi_tkdn += $jml_open_meeting_grup;
        if ($jml_open_meeting_grup) {
            $open_meeting_grup = array(
                'Penugasan Assesor' => $penugasan_assesor,
                'Buat Surat Tugas' => $buat_surat_tugas,
                'Upload Dokumen' => $upload_dokumen_opening_meeting,
                'Verifikasi Dokumen' => $verifikasi_dokumen_opening_meeting,
            );
        }

        $pengumpulan_dokumen = $this->notif_pengumpulan_dokumen() + $this->notif_verifikasi_permohonan_perpanjangan_waktu();
        $verifikasi_pemberitahuan_pemenuhan_dokumen = $this->notif_verifikasi_pemberitahuan_pemenuhan_dokumen();
        $collecting_dokumen_grup = '';
        $jml_collecting_dokumen_grup = $pengumpulan_dokumen + $verifikasi_pemberitahuan_pemenuhan_dokumen;
        $sub_module_verifikasi_tkdn += $jml_collecting_dokumen_grup;
        if ($jml_collecting_dokumen_grup) {
            $collecting_dokumen_grup = array(
                'Pengumpulan Dokumen' => $pengumpulan_dokumen,
                'Verifikasi Pemberitahuan Pemenuhan Dokumen' => $verifikasi_pemberitahuan_pemenuhan_dokumen,
            );
        }

        $penungasan_assesor_lapangan = $this->notif_penungasan_assesor_lapangan();
        $pekerjaan = $this->notif_pekerjaan();
        $verifikasi_dokumen_survey_lapangan = $this->notif_verifikasi_dokumen_survey_lapangan();
        $survey_lapangan_grup = '';
        $jml_survey_lapangan_grup = $penungasan_assesor_lapangan + $pekerjaan + $verifikasi_dokumen_survey_lapangan;
        $sub_module_verifikasi_tkdn += $jml_survey_lapangan_grup;
        if ($jml_survey_lapangan_grup) {
            $survey_lapangan_grup = array(
                'Penugasan Assesor' => $penungasan_assesor_lapangan,
                'Pekerjaan' => $pekerjaan,
                'Verifikasi Dokumen' => $verifikasi_dokumen_survey_lapangan,
            );
        }

        $verifikasi_collecting_document_2 = $this->notif_verifikasi_collecting_document_2();
        $collecting_document_2_grup = '';
        $jml_collecting_dokumen_2_grup = $verifikasi_collecting_document_2;
        $sub_module_verifikasi_tkdn += $jml_collecting_dokumen_2_grup;
        if ($jml_collecting_dokumen_2_grup) {
            $collecting_document_2_grup = array(
                'Verifikasi Dokumen' => $verifikasi_collecting_document_2,
            );
        }


        $upload_dokumen_panel_internal = $this->notif_upload_dokumen_panel_internal();
        $verifikasi_dokumen_panel_internal = $this->notif_verifikasi_dokumen_panel_internal();
        $penugasan_etc = $this->notif_penugasan_etc();
        $approval_assesment_etc = $this->notif_approval_assesment_etc();

        $panel_internal_grup = '';
        $jml_panel_internal_grup = $upload_dokumen_panel_internal + $verifikasi_dokumen_panel_internal + $penugasan_etc + $approval_assesment_etc;
        $sub_module_verifikasi_tkdn += $jml_panel_internal_grup;
        if ($jml_panel_internal_grup) {
            $panel_internal_grup = array(
                'Upload Dokumen' => $upload_dokumen_panel_internal,
                'Verifikasi Dokumen' => $verifikasi_dokumen_panel_internal,
                'Penugasan ETC' => $penugasan_etc,
                'Approval Assessment' => $approval_assesment_etc,
            );
        }

        $verifikasi_draft_tanda_sah = $this->notif_verifikasi_draft_tanda_sah();
        $assesment_kemenperin = $this->notif_assesment_kemenperin();
        $panel_kemenperin_grup = '';
        $jml_panel_kemenperin_grup = $verifikasi_draft_tanda_sah + $assesment_kemenperin;
        $sub_module_verifikasi_tkdn += $jml_panel_kemenperin_grup;
        if ($jml_panel_kemenperin_grup) {
            $panel_kemenperin_grup = array(
                'Verifikasi Draft Tanda Sah' => $verifikasi_draft_tanda_sah,
                'Assessment Kemenperin' => $assesment_kemenperin,
            );
        }

        $upload_closing_meeting = $this->notif_upload_closing_meeting();
        $verifikasi_closing_meeting = $this->notif_verifikasi_closing_meeting();

        $closing_meeting_grup = '';
        $jml_closing_meeting_grup = $upload_closing_meeting + $verifikasi_closing_meeting;
        $sub_module_verifikasi_tkdn += $jml_closing_meeting_grup;
        if ($jml_closing_meeting_grup) {
            $closing_meeting_grup = array(
                'Upload Dokumen' => $upload_closing_meeting,
                'Verifikasi Dokumen' => $verifikasi_closing_meeting,
            );
        }

        $buat_payment_detail_2 = $this->notif_buat_payment_detail_2();
        $verifikasi_payment_detail_2 = $this->notif_verifikasi_payment_detail_2();
        $upload_surat_tugas_sistem = $this->notif_upload_surat_tugas_sistem();
        $upload_invoice_faktur_pajak_2 = $this->notif_upload_invoice_faktur_pajak_2();

        $close_order_grup = '';
        $jml_close_order_grup = $buat_payment_detail_2 + $verifikasi_payment_detail_2 + $upload_surat_tugas_sistem + $upload_invoice_faktur_pajak_2;
        $sub_module_verifikasi_tkdn += $jml_close_order_grup;
        if ($jml_close_order_grup) {
            $close_order_grup = array(
                'Buat Payment Detail' => $buat_payment_detail_2,
                'Verifikasi Payment Detail' => $verifikasi_payment_detail_2,
                'Upload Surat Tugas (System)' => $upload_surat_tugas_sistem,
                'Upload Invoice & Faktur Pajak' => $upload_invoice_faktur_pajak_2,
            );
        }


        $array = array(
            'order_tkdn' => $sub_module_order_tkdn,
            'verifikasi_tkdn' => $sub_module_verifikasi_tkdn,

            'Verifikasi Permohonan' => $verifikasi_grup,
            'Rencana Anggaran Biaya' => $rab_grup,
            'Verifikasi Surat Penawaran' => $verifikasi_surat_penawaran,
            'Ruang Negosiasi' => $ruang_negosiasi,
            'Konfirmasi Order' => $konfirmasi_order_grup,
            'Open Order' => $open_order_grup,
            'Open Meeting' => $open_meeting_grup,
            'Collecting Document' => $collecting_dokumen_grup,
            'Survey Lapangan' => $survey_lapangan_grup,
            'Collecting Document II' => $collecting_document_2_grup,
            'Panel Internal' => $panel_internal_grup,
            'Panel Kemenperin' => $panel_kemenperin_grup,
            'Closing Meeting' => $closing_meeting_grup,
            'Close Order' => $close_order_grup,
        );

        return $array;
    }

    public function index()
    {
        $this->redirect(base_url('pelanggan'));
    }

    public function mail_template($with_button = 'ya')
    {
        if ($with_button == 'ya') {
            $this->load->view('mail_template/layout', $this->data_halaman());
        } else {
            $this->load->view('mail_template/layout_tanpa_tombol', $this->data_halaman());
        }
    }

    public function admin_login()
    {
        $this->lang_loader('admin_login');
        $this->load->view('admin_login', $this->data_halaman());
    }

    public function ruang_kerja($sub_module = '')
    {
        if ($this->validasi_login()) {
            if ($sub_module == 'ORDER_TKDN' or $sub_module == 'VERIFIKASI_TKDN') {
                $data = array(
                    'ruang_kerja' => $sub_module
                );
                $this->session->set_userdata($data);

                $this->redirect(base_url() . 'page/home');
            } else {
                $notif = $this->notifikasi();
                $konten = array('title' => 'Pilih Ruang Kerja', 'notif' => $notif);
                $this->load->view('ruang_kerja', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function home()
    {
        $menu = 'page/home';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Beranda', 'notif' => $notif);
            $this->load->view('welcome', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function rekening_bank()
    {
        $menu = 'page/rekening_bank';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Rekening Bank', 'notif' => $notif);
            $this->load->view('master/rekening_bank', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function profil_perusahaan()
    {
        $menu = 'page/profil_perusahaan';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $this->load->model('profil_perusahaan_model', 'profil_perusahaan');
            $where = array('active' => 1, 'id_profil_perusahaan' => 1);
            $data_send = array('where' => $where);
            $load_data = $this->profil_perusahaan->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $profil_perusahaan = $load_data->row();
            }

            $konten = array('title' => 'Profil Perusahaan', 'notif' => $notif, 'profil_perusahaan' => $profil_perusahaan);
            $this->load->view('master/profil_perusahaan', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function mata_anggaran()
    {
        $menu = 'page/mata_anggaran';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Mata Anggaran', 'notif' => $notif);
            $this->load->view('master/mata_anggaran', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function data_pelanggan()
    {
        $menu = 'page/data_pelanggan';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Data Pelanggan', 'notif' => $notif);
            $this->load->view('pelanggan/data_pelanggan', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function profil_pelanggan($id_pelanggan = '')
    {
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();
            $this->load->model("pelanggan_model", "pelanggan");
            $join[0] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
            $where = array('pelanggan.active' => 1, 'id_pelanggan' => htmlentities($id_pelanggan ?? ''));
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->pelanggan->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $pelanggan = $load_data->row();

                $konten = array('title' => 'Data Pelanggan', 'notif' => $notif, 'pelanggan' => $pelanggan);
                $this->load->view('pelanggan/profil_pelanggan', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function penugasan_pic()
    {
        $menu = 'page/penugasan_pic';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $this->load->model("mst_admin_model", "admin");
            $where = array('id_jns_admin' => 3);
            $data_send = array('where' => $where);
            $assesor = $this->admin->load_data($data_send);

            $konten = array('title' => 'Penugasan PIC', 'notif' => $notif, 'assesor' => $assesor);
            $this->load->view('dokumen_permohonan/penugasan_pic', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function verifikasi_dokumen()
    {
        $menu = 'page/verifikasi_dokumen';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Verifikasi Dokumen Permohonan', 'notif' => $notif);
            $this->load->view('dokumen_permohonan/verifikasi_dokumen', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function detail_dokumen_permohonan($id_dokumen_permohonan = '')
    {
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();
            $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
            $join[0] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
            $join[1] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
            $join[2] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
            $where = array('dokumen_permohonan.active' => 1, 'pelanggan.active' => 1, 'id_dokumen_permohonan' => $id_dokumen_permohonan);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $dokumen_permohonan = $load_data->row();
                $assesor = $this->siapaAssesor($dokumen_permohonan->id_dokumen_permohonan);
                $konten = array('title' => 'Detail Dokumen Permohonan', 'notif' => $notif, 'dokumen_permohonan' => $dokumen_permohonan, 'assesor' => $assesor);
                $this->load->view('dokumen_permohonan/detail_dokumen_permohonan', $this->data_halaman($konten));
            } else {
                $this->load->view('errors/404', $this->data_halaman());
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function detail_verifikasi_dokumen_permohonan($id_dokumen_permohonan = '')
    {
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();
            $id_admin = $this->session->userdata('id_admin');
            $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
            $join[0] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
            $join[1] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
            $join[2] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
            $where = array(
                'dokumen_permohonan.active' => 1,
                'pelanggan.active' => 1,
                'status_pengajuan' => 2,
                'id_dokumen_permohonan' => $id_dokumen_permohonan,
                '(select count(-1) jml from dokumen_permohonan_pic pic where pic.active = 1 and id_admin = \'' . $id_admin . '\' and pic.id_dokumen_permohonan = \'' . $id_dokumen_permohonan . '\') =' => 1,
            );
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->dokumen_permohonan->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $dokumen_permohonan = $load_data->row();
                $assesor = $this->siapaAssesor($dokumen_permohonan->id_dokumen_permohonan);
                $konten = array('title' => 'Detail Dokumen Permohonan', 'notif' => $notif, 'dokumen_permohonan' => $dokumen_permohonan, 'assesor' => $assesor, 'proses_verifikasi' => true);
                $this->load->view('dokumen_permohonan/detail_dokumen_permohonan', $this->data_halaman($konten));
            } else {
                $this->load->view('errors/404', $this->data_halaman());
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function buat_rab()
    {
        $menu = 'page/buat_rab';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Buat RAB', 'notif' => $notif);
            $this->load->view('rab/buat_rab', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function proses_buat_rab($id_dokumen_permohonan = '')
    {
        $menu = 'page/buat_rab';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $id_dokumen_permohonan = htmlentities($id_dokumen_permohonan ?? '');

            $load_data = $this->getDokumenPermohonan($id_dokumen_permohonan);
            if ($load_data->num_rows() > 0) {
                #find anggaran...
                $anggaran = $this->getAnggaran();

                #find PIC...
                $pic = $this->getPIC($id_dokumen_permohonan);

                $konten = array(
                    'title' => 'Proses Pembuatan RAB',
                    'notif' => $notif,
                    'dokumen_permohonan' => $load_data->row(),
                    'id_dokumen_permohonan' => $id_dokumen_permohonan,
                    'koordinator' => $pic['koordinator'],
                    'assesor' => $pic['assesor'],
                    'anggaran' => $anggaran
                );
                $this->load->view('rab/proses_buat_rab', $this->data_halaman($konten));
            } else {
                $this->redirect(base_url() . 'page/buat_rab');
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    function getDokumenPermohonan($id_dokumen_permohonan)
    {
        $this->load->model('dokumen_permohonan_model', 'dokumen_permohonan');
        $join[0] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
        $join[1] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
        $join[2] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
        $where = array('dokumen_permohonan.active' => 1, 'id_dokumen_permohonan' => $id_dokumen_permohonan);  #show active data...
        $send_data = array('where' => $where, 'join' => $join);
        $load_data = $this->dokumen_permohonan->load_data($send_data);
        return $load_data;
    }
    function getAnggaran()
    {
        $anggaran = array();
        $this->load->model("mata_anggaran_model", "mata_anggaran");
        $where = array('active' => 1);
        $data_send = array('where' => $where);
        $load_mata_anggaran = $this->mata_anggaran->load_data($data_send);
        if ($load_mata_anggaran->num_rows() > 0) {
            foreach ($load_mata_anggaran->result() as $mata) {
                $data = array(
                    'nama_mata_anggaran' => $mata->nama_mata_anggaran,
                    'biaya' => $mata->biaya,
                    'satuan' => $mata->satuan,
                );
                $anggaran[$mata->id_mata_anggaran] = $data;
            }
        }
        return $anggaran;
    }
    function getPIC($id_dokumen_permohonan)
    {
        $this->load->model("mst_admin_model", "admin");
        #kabid
        $where_kabid = "id_jns_admin = 5";
        $kabid = $this->admin->load_data(array('where' => $where_kabid));

        #koordinator
        $where_koordinator = "id_jns_admin = 2";
        $koordinator = $this->admin->load_data(array('where' => $where_koordinator));

        #Verifikator bertugas...
        $where_assesor = "id_jns_admin = 3 and id_admin IN (select id_admin from dokumen_permohonan_pic where active = 1 and id_dokumen_permohonan = '" . $id_dokumen_permohonan . "')";
        $data_send = array('where' => $where_assesor);
        $assesor = $this->admin->load_data($data_send);
        return array(
            'kabid' => $kabid,
            'koordinator' => $koordinator,
            'assesor' => $assesor,
        );
    }

    public function approval_rab()
    {
        $menu = 'page/approval_rab';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Approval RAB', 'notif' => $notif);
            $this->load->view('rab/approval_rab', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function proses_approval_rab($id_rab = '')
    {
        $menu = 'page/approval_rab';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $id_rab = htmlentities($id_rab ?? '');
            $this->load->model("rab_model", "rab");
            $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
            $where = array('rab.active' => 1, 'id_rab' => $id_rab, 'status_pengajuan' => 5, 'id_koordinator' => $this->session->userdata('id_admin'));
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->rab->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $rab = $load_data->row();

                $rab->alamat_npwp = preg_replace('/\s+/', ' ', $rab->alamat_npwp);

                #find detail rab...
                $this->load->model("rab_detail_model", "rab_detail");
                $order_detail = "id_rab_detail ASC";
                $where_detail = array('active' => 1, 'id_rab' => $rab->id_rab);
                $data_send_detail = array('where' => $where_detail, 'order' => $order_detail);
                $rab_detail = $this->rab_detail->load_data($data_send_detail)->result();

                $id_dokumen_permohonan = $rab->id_dokumen_permohonan;
                $dokumen_penawran = $this->getDokumenPermohonan($id_dokumen_permohonan);
                if ($dokumen_penawran->num_rows() > 0) {
                    #find anggaran...
                    $anggaran = $this->getAnggaran();

                    #find PIC...
                    $pic = $this->getPIC($id_dokumen_permohonan);

                    $konten = array(
                        'title' => 'Approval RAB',
                        'notif' => $notif,
                        'dokumen_permohonan' => $dokumen_penawran->row(),
                        'id_dokumen_permohonan' => $id_dokumen_permohonan,
                        'id_rab' => $id_rab,
                        'rab' => $rab,
                        'rab_detail' => $rab_detail,
                        'koordinator' => $pic['koordinator'],
                        'assesor' => $pic['assesor'],
                        'kabid' => $pic['kabid'],
                        'anggaran' => $anggaran,
                        'from' => 'approval_rab'
                    );
                    $this->load->view('rab/display_rab', $this->data_halaman($konten));
                } else {
                    $this->redirect(base_url() . 'page/buat_rab');
                }
            } else {
                $this->redirect(base_url() . 'page/approval_rab');
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_detail_rab($id_rab = '')
    {
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();

            $id_rab = htmlentities($id_rab ?? '');
            $this->load->model("rab_model", "rab");
            $where = array('active' => 1, 'id_rab' => $id_rab);
            $data_send = array('where' => $where);
            $load_data = $this->rab->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $rab = $load_data->row();

                #find detail rab...
                $this->load->model("rab_detail_model", "rab_detail");
                $order_detail = "id_rab_detail ASC";
                $where_detail = array('active' => 1, 'id_rab' => $rab->id_rab);
                $data_send_detail = array('where' => $where_detail, 'order' => $order_detail);
                $rab_detail = $this->rab_detail->load_data($data_send_detail)->result();

                $id_dokumen_permohonan = $rab->id_dokumen_permohonan;
                $dokumen_penawran = $this->getDokumenPermohonan($id_dokumen_permohonan);
                if ($dokumen_penawran->num_rows() > 0) {
                    #find anggaran...
                    $anggaran = $this->getAnggaran();

                    #find PIC...
                    $pic = $this->getPIC($id_dokumen_permohonan);

                    $konten = array(
                        'title' => 'Detail RAB',
                        'notif' => $notif,
                        'dokumen_permohonan' => $dokumen_penawran->row(),
                        'id_dokumen_permohonan' => $id_dokumen_permohonan,
                        'id_rab' => $id_rab,
                        'rab' => $rab,
                        'rab_detail' => $rab_detail,
                        'koordinator' => $pic['koordinator'],
                        'assesor' => $pic['assesor'],
                        'kabid' => $pic['kabid'],
                        'anggaran' => $anggaran,
                        'from' => 'lihat_rab'
                    );
                    $this->load->view('rab/display_rab', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function rab_ditolak()
    {
        $menu = 'page/rab_ditolak';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'RAB Ditolak', 'notif' => $notif);
            $this->load->view('rab/rab_ditolak', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function perbaikan_rab($id_rab = '')
    {
        $menu = 'page/rab_ditolak';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $id_rab = htmlentities($id_rab ?? '');
            $this->load->model("rab_model", "rab");
            $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
            $where = array('rab.active' => 1, 'id_rab' => $id_rab, 'status_pengajuan' => 6, 'id_assesor' => $this->session->userdata('id_admin'));
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->rab->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $rab = $load_data->row();

                $rab->nama_produk_jasa = preg_replace('/\s+/', ' ', $rab->nama_produk_jasa);
                $rab->alamat_npwp = preg_replace('/\s+/', ' ', $rab->alamat_npwp);
                $rab->alasan_verifikasi = preg_replace('/\s+/', ' ', $rab->alasan_verifikasi);

                #find detail rab...
                $this->load->model("rab_detail_model", "rab_detail");
                $order_detail = "id_rab_detail ASC";
                $where_detail = array('active' => 1, 'id_rab' => $rab->id_rab);
                $data_send_detail = array('where' => $where_detail, 'order' => $order_detail);
                $rab_detail = $this->rab_detail->load_data($data_send_detail)->result();

                $id_dokumen_permohonan = $rab->id_dokumen_permohonan;
                $dokumen_penawran = $this->getDokumenPermohonan($id_dokumen_permohonan);
                if ($dokumen_penawran->num_rows() > 0) {
                    #find anggaran...
                    $anggaran = $this->getAnggaran();

                    #find PIC...
                    $pic = $this->getPIC($id_dokumen_permohonan);

                    $konten = array(
                        'title' => 'Perbaikan RAB',
                        'notif' => $notif,
                        'dokumen_permohonan' => $dokumen_penawran->row(),
                        'id_dokumen_permohonan' => $id_dokumen_permohonan,
                        'id_rab' => $id_rab,
                        'rab' => $rab,
                        'rab_detail' => $rab_detail,
                        'koordinator' => $pic['koordinator'],
                        'assesor' => $pic['assesor'],
                        'kabid' => $pic['kabid'],
                        'anggaran' => $anggaran,
                        'from' => 'perbaikan_rab'
                    );
                    $this->load->view('rab/proses_buat_rab', $this->data_halaman($konten));
                } else {
                    $this->redirect(base_url() . 'page/buat_rab');
                }
            } else {
                $this->redirect(base_url() . 'page/approval_rab');
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function buat_penawaran()
    {
        $menu = 'page/buat_penawaran';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Buat Penawaran', 'notif' => $notif);
            $this->load->view('rab/buat_penawaran', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function proses_buat_penawaran($id_rab = '')
    {
        $menu = 'page/buat_penawaran';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $id_rab = htmlentities($id_rab ?? '');

            $this->load->model("rab_model", "rab");
            $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
            $join[2] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
            $where = array('rab.active' => 1, 'id_rab' => $id_rab, 'dokumen_permohonan.status_pengajuan IN (7,9)' => null);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->rab->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $rab = $load_data->row();
                $status = '';
                $surat_penawaran = '';
                if ($rab->status_pengajuan == 9) {
                    #penawaran ini ditolak oleh kabid.. admin harus revisi...
                    $status = 'revisi';

                    $this->load->model('surat_penawaran_model', 'surat_penawaran');
                    $where_surat_penawaran = array('active' => 1, 'id_rab' => $id_rab);
                    $data_send_surat_penawaran = array('where' => $where_surat_penawaran);
                    $surat_penawaran = $this->surat_penawaran->load_data($data_send_surat_penawaran)->row();
                } else {
                    #cek apakah dokumen ini pernah di nego...
                    $this->load->model('surat_penawaran_model', 'surat_penawaran');
                    $where_surat_penawaran = array('active' => 1, 'id_rab' => $id_rab);
                    $data_send_surat_penawaran = array('where' => $where_surat_penawaran);
                    $load_data_surat_penawaran = $this->surat_penawaran->load_data($data_send_surat_penawaran);
                    if ($load_data_surat_penawaran->num_rows() > 0) {
                        #ternyata sudah ada surat pernawarannya, artinya sudah pernah dibuat tapi dinego.
                        $surat_penawaran = $load_data_surat_penawaran->row();

                        #cari alasan negosiasi...
                        $this->load->model('log_verifikasi_model', 'log_verifikasi');
                        $where_log_verifikasi = array('active' => 1, 'id_dokumen_permohonan' => $rab->id_dokumen_permohonan, 'status_verifikasi' => 6);
                        $order_log_verifikasi = "id_log_verifikasi DESC";
                        $limit_log_verifikasi = "1,0";
                        $data_send_log_verifikasi = array('where' => $where_log_verifikasi, 'order' => $order_log_verifikasi, 'limit' => $limit_log_verifikasi);
                        $load_data_log_verifikasi = $this->log_verifikasi->load_data($data_send_log_verifikasi);
                        if ($load_data_log_verifikasi->num_rows() > 0) {
                            $log_verifikasi = $load_data_log_verifikasi->row();
                            $rab->alasan_verifikasi = 'Alasan Negosiasi: ' . $log_verifikasi->alasan_verifikasi;
                        }

                        $status = 'revisi';
                    }
                }

                // if($id_rab and !$rab->alasan_verifikasi){
                //     #jika ada id_rab tapi alasan verifikasi kosong.. kemungkinan ini adalah penawaran yang di nego... cari alasan negosiasinya...
                //     $this->load->model("log_verifikasi_model", "log_verifikasi");
                //     $where_nego = array('active' => 1, 'id_dokumen_permohonan' => $rab->id_dokumen_permohonan, 'status_verifikasi' => 6);
                //     $order_nego = "id_log_verifikasi DESC";
                //     $limit_nego = '1,0';
                //     $data_send_nego = array('where' => $where_nego, 'order' => $order_nego, 'limit' => $limit_nego);
                //     $load_data_nego = $this->log_verifikasi->load_data($data_send_nego);
                //     if($load_data_nego->num_rows() > 0){
                //         $nego = $load_data_nego->row();
                //         $rab->alasan_verifikasi = $nego->alasan_verifikasi;
                //     }
                // }

                $this->load->model('permohonan_verifikasi_model', 'permohonan_verifikasi');
                $where_permohonan_verifikasi = array('active' => 1);
                $data_send_permohonan_verifikasi = array('where' => $where_permohonan_verifikasi);
                $permohonan_verifikasi = $this->permohonan_verifikasi->load_data($data_send_permohonan_verifikasi);

                $konten = array(
                    'title' => 'Pembuatan Dokumen Penawaran',
                    'notif' => $notif,
                    'id_rab' => $id_rab,
                    'rab' => $rab,
                    'status' => $status,
                    'surat_penawaran' => $surat_penawaran,
                    'permohonan_verifikasi' => $permohonan_verifikasi,
                );
                $this->load->view('rab/proses_buat_penawaran', $this->data_halaman($konten));
            } else {
                $this->redirect(base_url() . 'page/buat_penawaran');
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function verifikasi_penawaran()
    {
        $menu = 'page/verifikasi_penawaran';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Verifikasi Surat Penawaran', 'notif' => $notif);
            $this->load->view('rab/verifikasi_penawaran', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function proses_verifikasi_penawaran($id_rab = '')
    {
        $menu = 'page/verifikasi_penawaran';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $this->load->model("mst_admin_model", "admin");
            $this->load->model("surat_penawaran_model", "surat_penawaran");
            $id_admin = $this->session->userdata('id_admin');
            $where_admin = array('id_admin' => $id_admin, 'id_jns_admin IN (2,5)' => null);
            $cek_admin = $this->admin->is_available($where_admin);
            if ($cek_admin) {
                $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $where = array('surat_penawaran.active' => 1, 'surat_penawaran.id_rab' => $id_rab, 'status_pengajuan' => 8);
                if ($this->session->userdata('id_jns_admin') == 2) {
                    $where['butuh_verifikasi_koordinator'] = 1;
                } else if ($this->session->userdata('id_jns_admin') == 5) {
                    $where['butuh_verifikasi_koordinator'] = 0;
                }
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->surat_penawaran->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $surat_penawaran = $load_data->row();
                    $notif = $this->notifikasi();

                    $konten = array('title' => 'Verifikasi Surat Penawaran', 'notif' => $notif, 'surat_penawaran' => $surat_penawaran);
                    $this->load->view('rab/proses_verifikasi_penawaran', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_surat_penawaran($id_rab = '')
    {
        if ($this->validasi_login()) {
            $this->load->model("surat_penawaran_model", "surat_penawaran");
            $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $where = array('surat_penawaran.active' => 1, 'surat_penawaran.id_rab' => $id_rab);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->surat_penawaran->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $surat_penawaran = $load_data->row();
                $notif = $this->notifikasi();

                $konten = array('title' => 'Lihat Surat Penawaran', 'notif' => $notif, 'surat_penawaran' => $surat_penawaran, 'display_only' => true);
                $this->load->view('rab/proses_verifikasi_penawaran', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function ruang_negosiasi()
    {
        $menu = 'page/ruang_negosiasi';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Ruang Negosiasi', 'notif' => $notif);
            $this->load->view('chat_room/room', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function masa_collecting_dokumen()
    {
        $menu = 'page/masa_collecting_dokumen';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Masa Collecting Dokumen', 'notif' => $notif);

            $this->load->view('konfirmasi_order/masa_collecting_dokumen', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function buat_konfirmasi_order()
    {
        $menu = 'page/buat_konfirmasi_order';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Buat Konfirmasi Order', 'notif' => $notif);

            $this->load->view('konfirmasi_order/buat_oc', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function buat_proforma_invoice()
    {
        $menu = 'page/buat_proforma_invoice';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Buat Proforma Invoice', 'notif' => $notif);

            $this->load->view('konfirmasi_order/buat_proforma_invoice', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function form_proforma_invoice($id_surat_oc = '')
    {
        $menu = 'page/buat_proforma_invoice';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $id_surat_oc = htmlentities($id_surat_oc ?? '');
            if ($id_surat_oc) {
                $this->load->model('surat_oc_model', 'surat_oc');
                $join[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[1] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join[3] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join[4] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
                $where = "surat_penawaran.active = 1 and id_surat_oc = '" . $id_surat_oc . "' and dokumen_permohonan.status_pengajuan IN (17, 18)";
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->surat_oc->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $notif = $this->notifikasi();
                    $surat_oc = $load_data->row();

                    $proforma_invoice = '';
                    if ($surat_oc->status_pengajuan == 18) {
                        $title = 'Revisi Proforma Invoice';
                        $this->load->model('proforma_invoice_model', 'proforma_invoice');
                        $where_proforma_invoice = array('active' => 1, 'id_surat_oc' => $surat_oc->id_surat_oc);
                        $data_send_proforma_invoice = array('where' => $where_proforma_invoice);
                        $load_data_proforma_invoice = $this->proforma_invoice->load_data($data_send_proforma_invoice);
                        if ($load_data_proforma_invoice->num_rows() > 0) {
                            $proforma_invoice = $load_data_proforma_invoice->row();
                        }
                    } else
                        $title = 'Buat Proforma Invoice';
                    $konten = array('title' => $title, 'notif' => $notif, 'surat_oc' => $surat_oc, 'proforma_invoice' => $proforma_invoice);

                    $this->load->view('konfirmasi_order/form_proforma_invoice', $this->data_halaman($konten));
                } else {
                    $this->redirect(base_url() . 'page/buat_proforma_invoice');
                }
            } else {
                $this->redirect(base_url() . 'page/buat_proforma_invoice');
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function verifikasi_proforma_invoice()
    {
        $menu = 'page/verifikasi_proforma_invoice';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            if ($this->session->userdata('id_jns_admin') == '5') {
                $from = 'verifikasi_proforma_invoice_kabid';
            } else if ($this->session->userdata('id_jns_admin') == '7') {
                $from = 'verifikasi_proforma_invoice_kepkeu';
            } else {
                $from = 'x';
            }

            $konten = array('title' => 'Verifikasi Proforma Invoice', 'notif' => $notif, 'from' => $from);

            $this->load->view('konfirmasi_order/verifikasi_proforma_invoice', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function proses_verifikasi_proforma_invoice($id_surat_oc = '')
    {
        $menu = 'page/verifikasi_proforma_invoice';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $id_surat_oc = htmlentities($id_surat_oc ?? '');
            if ($id_surat_oc) {
                $status_pengajuan = 'x';
                if ($this->session->userdata('id_jns_admin') == '5') {
                    $status_pengajuan = 19;
                } else if ($this->session->userdata('id_jns_admin') == '7') {
                    $status_pengajuan = 20;
                }
                $this->load->model('proforma_invoice_model', 'proforma_invoice');
                $join[0] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = proforma_invoice.id_surat_oc', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[2] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[3] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join[4] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join[5] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
                $where = "surat_penawaran.active = 1 and surat_oc.id_surat_oc = '" . $id_surat_oc . "' and dokumen_permohonan.status_pengajuan = '" . $status_pengajuan . "'";
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->proforma_invoice->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $notif = $this->notifikasi();
                    $proforma_invoice = $load_data->row();

                    $konten = array('title' => 'Verifikasi Proforma Invoice', 'notif' => $notif, 'proforma_invoice' => $proforma_invoice, 'display_only' => false);

                    $this->load->view('konfirmasi_order/lihat_proforma_invoice', $this->data_halaman($konten));
                } else {
                    $this->redirect(base_url() . 'page/buat_proforma_invoice');
                }
            } else {
                $this->redirect(base_url() . 'page/buat_proforma_invoice');
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function lihat_proforma_invoice($id_proforma_invoice = '')
    {
        if ($this->validasi_login()) {
            $id_proforma_invoice = htmlentities($id_proforma_invoice ?? '');
            if ($id_proforma_invoice) {

                $this->load->model('proforma_invoice_model', 'proforma_invoice');
                $join[0] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = proforma_invoice.id_surat_oc', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[2] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[3] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join[4] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join[5] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
                $where = "surat_penawaran.active = 1 and proforma_invoice.id_proforma_invoice = '" . $id_proforma_invoice . "' and dokumen_permohonan.status_pengajuan >= '21'";
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->proforma_invoice->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $notif = $this->notifikasi();
                    $proforma_invoice = $load_data->row();

                    $konten = array('title' => 'Lihat Proforma Invoice', 'notif' => $notif, 'proforma_invoice' => $proforma_invoice, 'display_only' => true);

                    $this->load->view('konfirmasi_order/lihat_proforma_invoice', $this->data_halaman($konten));
                } else {
                    $this->redirect(base_url() . 'page/buat_proforma_invoice');
                }
            } else {
                $this->redirect(base_url() . 'page/buat_proforma_invoice');
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function form_surat_oc($id_surat_penawaran = '')
    {
        $menu = 'page/buat_konfirmasi_order';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            if ($id_surat_penawaran) {
                $notif = $this->notifikasi();
                $this->load->model("surat_penawaran_model", "surat_penawaran");
                $this->load->model("surat_oc_model", "surat_oc");
                $this->load->model('kriteria_verifikasi_bmp_model', 'kriteria_verifikasi_bmp');

                $where_kriteria_bmp = array('kriteria_verifikasi_bmp.active' => 1);
                $data_send_kriteria_bmp = array('where' => $where_kriteria_bmp);
                $load_data_kriteria_bmp = $this->kriteria_verifikasi_bmp->load_data($data_send_kriteria_bmp);


                $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join[2] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join[3] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
                $where = "surat_penawaran.active = 1 and id_surat_penawaran = '" . $id_surat_penawaran . "' and dokumen_permohonan.status_pengajuan IN (13, 14)";
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->surat_penawaran->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $surat_penawaran = $load_data->row();

                    $where_oc = array('active' => 1, 'id_surat_penawaran' => $id_surat_penawaran);
                    $data_send_oc = array('where' => $where_oc);
                    $load_data_oc = $this->surat_oc->load_data($data_send_oc);
                    $surat_oc = null;
                    if ($load_data_oc->num_rows() > 0) {
                        $surat_oc = $load_data_oc->row();
                    }

                    if ($surat_penawaran->status_pengajuan == 13) {
                        $title = 'Buat Konfirmasi Order';
                        $action = 'save';
                    } else {
                        $title = 'Revisi Konfirmasi Order';
                        $action = 'update';
                    }

                    #hitung nilai kontrak...
                    $nilai_kontrak_1 = ($surat_penawaran->termin_1 / 100) * $surat_penawaran->nilai_kontrak;
                    $nilai_kontrak_2 = ($surat_penawaran->termin_2 / 100) * $surat_penawaran->nilai_kontrak;
                    $konten = array(
                        'title' => $title,
                        'notif' => $notif,
                        'surat_penawaran' => $surat_penawaran,
                        'surat_oc' => $surat_oc,
                        'nilai_kontrak_1' => $nilai_kontrak_1,
                        'nilai_kontrak_2' => $nilai_kontrak_2,
                        'kriteria_verifikasi_bmp' => $load_data_kriteria_bmp,
                        'action' => $action,
                    );
                    $this->load->view('konfirmasi_order/form_surat_oc', $this->data_halaman($konten));
                } else {
                    $this->redirect(base_url() . 'page/buat_konfirmasi_order');
                }
            } else {
                $this->redirect(base_url() . 'page/buat_konfirmasi_order');
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function verifikasi_konfirmasi_order()
    {
        $menu = 'page/verifikasi_konfirmasi_order';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            #check apakah yg login adalah koordinator atau kabid...
            $id_jns_admin = $this->session->userdata('id_jns_admin');
            $from = 'unkown';
            if ($id_jns_admin == 2) {
                $from = 'verifikasi_oc_koordinator';
            } else if ($id_jns_admin == 5) {
                $from = 'verifikasi_oc_kabid';
            }
            $konten = array('title' => 'Verifikasi Konfirmasi Order', 'notif' => $notif, 'from' => $from);

            $this->load->view('konfirmasi_order/verifikasi_konfirmasi_order', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function bypass_bukti_bayar()
    {
        $menu = 'page/bypass_bukti_bayar';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'ByPass Bukti Bayar & OC Pelanggan', 'notif' => $notif);

            $this->load->view('konfirmasi_order/bypass_bukti_bayar', $this->data_halaman($konten));
        } else {
            $this->redirect(base_url() . 'gateway/keluar');
        }
    }

    public function proses_verifikasi_oc($id_surat_penawaran = '')
    {
        $menu = 'page/verifikasi_konfirmasi_order';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $this->load->model("surat_oc_model", "surat_oc");
            $join[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
            $join[1] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $join[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
            $where = array('surat_oc.active' => 1, 'surat_oc.id_surat_penawaran' => $id_surat_penawaran);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->surat_oc->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $surat_oc = $load_data->row();
                $notif = $this->notifikasi();

                $konten = array('title' => 'Verifikasi Konfirmasi Order', 'notif' => $notif, 'surat_oc' => $surat_oc);

                $this->load->view('konfirmasi_order/proses_verifikasi_oc', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_oc($id_surat_oc = '')
    {
        $menu = 'page/dokumen_permohonan';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $this->load->model("surat_oc_model", "surat_oc");
            $join[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
            $join[1] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $join[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
            $where = array('surat_oc.active' => 1, 'surat_oc.id_surat_oc' => $id_surat_oc);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->surat_oc->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $surat_oc = $load_data->row();
                $notif = $this->notifikasi();

                $konten = array('title' => 'Surat Konfirmasi Order', 'notif' => $notif, 'display_only' => true, 'surat_oc' => $surat_oc);

                $this->load->view('konfirmasi_order/proses_verifikasi_oc', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function verifikasi_bukti_bayar()
    {
        $menu = 'page/verifikasi_bukti_bayar';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Verifikasi Bukti Bayar & OC Pelanggan', 'notif' => $notif);

            $this->load->view('konfirmasi_order/verifikasi_bukti_bayar', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_oc_pelanggan($id_surat_oc = '')
    {
        if ($this->validasi_login()) {
            $this->load->model("surat_oc_model", "surat_oc");
            $join[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
            $join[1] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $join[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
            $where = array('surat_oc.active' => 1, 'surat_oc.id_surat_oc' => $id_surat_oc);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->surat_oc->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $surat_oc = $load_data->row();
                $notif = $this->notifikasi();
                $konten = array('title' => 'Konfirmasi Order Dari Pelanggan', 'notif' => $notif, 'surat_oc' => $surat_oc);
                $this->load->view('konfirmasi_order/surat_oc_pelanggan', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_bukti_bayar($id_surat_oc = '')
    {
        if ($this->validasi_login()) {
            $this->load->model("surat_oc_model", "surat_oc");
            $join[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
            $join[1] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $join[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
            $where = array('surat_oc.active' => 1, 'surat_oc.id_surat_oc' => $id_surat_oc, 'surat_penawaran.termin_1 > ' => 0, 'bukti_bayar != ' => '');
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->surat_oc->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $surat_oc = $load_data->row();
                $notif = $this->notifikasi();
                $konten = array('title' => 'Bukti Bayar', 'notif' => $notif, 'surat_oc' => $surat_oc);
                $this->load->view('konfirmasi_order/lihat_bukti_bayar', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function waktu_pelaksanaan()
    {
        $menu = 'page/waktu_pelaksanaan';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Waktu Pelaksanaan', 'notif' => $notif);

            $this->load->view('konfirmasi_order/set_waktu_pelaksanaan', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function reminder_pembayaran_oc()
    {
        $menu = 'page/reminder_pembayaran_oc';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Reminder Pembayaran OC', 'notif' => $notif);

            $this->load->view('konfirmasi_order/reminder_pembayaran_oc', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function buat_reminder_oc($id_surat_oc)
    {
        $menu = 'page/reminder_pembayaran_oc';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $data_halaman = $this->data_halaman();
            $this->load->model('mst_admin_model', 'mst_admin');
            $join_admin[0] = array('tabel' => 'jns_admin', 'relation' => 'jns_admin.id_jns_admin = mst_admin.id_jns_admin', 'direction' => 'left');
            $where_admin = array('status_admin' => 'A', 'mst_admin.id_jns_admin' => 5);
            $data_send_admin = array('where' => $where_admin, 'join' => $join_admin);
            $admin = $this->mst_admin->load_data($data_send_admin)->row();

            $this->load->model('surat_oc_model', 'surat_oc');
            $relation[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
            $relation[1] = array('tabel' => 'rab', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');
            $relation[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
            $relation[3] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
            $relation[4] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');

            $where = " surat_oc.active = 1 
                        and surat_penawaran.active = 1 
                        and dokumen_permohonan.id_dokumen_permohonan NOT IN (select id_dokumen_permohonan from pesan where tag = 'reminder_pembayaran_oc')
                        and dokumen_permohonan.status_pengajuan IN (21,22) 
                        and DATE_ADD(tgl_oc, INTERVAL (batas_waktu_pembayaran - 7) DAY) <= '" . date('Y-m-d') . "' 
                        and dokumen_permohonan.id_dokumen_permohonan IN (
                            select id_dokumen_permohonan 
                            from dokumen_permohonan_pic 
                            where dokumen_permohonan_pic.active = 1 
                                and dokumen_permohonan_pic.id_admin = '" . $this->session->userdata('id_admin') . "'
                        )";
            $data_send = array('where' => $where, 'join' => $relation);
            $load_data = $this->surat_oc->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $data = $load_data->row();
                $pelanggan = array(
                    'id_pelanggan' => $data->id_pelanggan,
                    'nama_perusahaan' => $data->nama_badan_usaha . ' ' . $data->nama_perusahaan,
                    'alamat_perusahaan' => $data->alamat_perusahaan,
                );

                $option_dateformat = array(
                    'new_delimiter' => ' ',
                    'month_type' => 'full',
                );
                $batas_pembayaran = $this->reformat_date(date('Y-m-d', strtotime($data->tgl_oc . ' + ' . $data->batas_waktu_pembayaran . ' days')), $option_dateformat);
                $isi_pesan = '<div style="font-size: 13px;">
                    <div>Dengan Hormat,</div><br>
                    <div style="text-align: justify">
                    Kami menginformasikan bahwa pekerjaan ' . $data->permohonan_verifikasi . ' sesuai dengan Konfirmasi Order No. ' . $data->nomor_oc . ' tanggal  ' . $this->reformat_date($data->tgl_oc, $option_dateformat) . ' sampai saat ini belum ada pembayaran termin ke-I. Maka dari itu Kami menghimbau agar segera melakukan pembayaran sebelum tanggal ' . $batas_pembayaran . '. Apabila sampai tanggal tersebut belum dilakukan pembayaran, maka Konfirmasi Order No. ' . $data->nomor_oc . ' ' . $data->permohonan_verifikasi . ' dibatalkan.
                    </div><br>
                    <div>Demikian pemberitahuan ini Kami sampaikan,  atas perhatian dan kerjasama Bapak/Ibu Kami ucapkan terima kasih.</div><br>
                    <div>
                        <div style="font-weight: bold;">' . strtoupper($data_halaman['nama_instansi']) . '</div>
                        <div style="font-weight: bold;">CABANG ' . strtoupper($data_halaman['cabang']) . '</div>
                        <img src="' . base_url() . $admin->ttd_admin . '" style="height:70px;">
                        <div style="font-weight: bold; text-decoration: underline">' . $admin->nama_admin . '</div>
                        <div style="font-weight: bold;">' . $admin->jns_admin . '</div>

                    </div>
                </div>';

                $konten = array(
                    'title' => 'Buat Reminder OC',
                    'notif' => $notif,
                    'pelanggan' => $pelanggan,
                    'perihal' => 'Pemberitahuan Batas Pembayaran',
                    'isi_pesan' => $isi_pesan,
                    'id_dokumen_permohonan' => $data->id_dokumen_permohonan,
                    'tag' => 'reminder_pembayaran_oc'
                );
                $this->load->view('pesan/buat_pesan', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_reminder_pembayaran_oc($id_pesan = '')
    {
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_pesan) {
                $this->load->model('pesan_model', 'pesan');
                $where = array('active' => 1, 'id_pesan' => htmlentities($id_pesan ?? ''));
                $data_send = array('where' => $where);
                $load_data = $this->pesan->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $pesan = $load_data->row();

                    $konten = array('title' => 'Reminder Pembayaran OC', 'notif' => $notif, 'pesan' => $pesan);
                    $this->load->view('konfirmasi_order/lihat_reminder_pembayaran_oc', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function buat_form_01($id_surat_oc = '')
    {
        $menu = 'page/buat_form_01';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_surat_oc) {
                $this->load->model("surat_oc_model", "surat_oc");
                $join[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[1] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');

                $join[3] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[4] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                $where = array('surat_oc.active IN (1,2)' => null, 'id_surat_oc' => $id_surat_oc, 'status_pengajuan IN (26, 27)' => null);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->surat_oc->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $surat_oc = $load_data->row();

                    $action = 'save';
                    $title = 'Buat Form 01';
                    $form_01 = null;
                    if ($surat_oc->status_pengajuan == 27) {
                        $action = 'revisi';
                        $title = 'Revisi Form 01';

                        $this->load->model("form_01_model", "form_01");
                        $where_form_01 = array('active' => 1, 'id_surat_oc' => $id_surat_oc);
                        $data_send_form_01 = array('where' => $where_form_01);
                        $load_data_form_01 = $this->form_01->load_data($data_send_form_01);
                        if ($load_data_form_01->num_rows() > 0) {
                            $form_01 = $load_data_form_01->row();
                        }
                    }
                    $date_option = array('delimiter' => '-', 'new_delimiter' => ' ', 'month_type' => 'full', 'date_reverse' => true);
                    $konten = array('title' => $title, 'notif' => $notif, 'surat_oc' => $surat_oc, 'form_01' => $form_01, 'action' => $action, 'date_option' => $date_option);
                    $this->load->view('open_order/form_01', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $konten = array('title' => 'Buat Form 01', 'notif' => $notif);
                $this->load->view('open_order/data_konfirmasi_order', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function verifikasi_form_01($id_surat_oc = '')
    {
        $menu = 'page/verifikasi_form_01';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_surat_oc) {
                if ($this->session->userdata('id_jns_admin') == 2) {
                    $statu_pengajuan = 28;
                } else if ($this->session->userdata('id_jns_admin') == 5) {
                    $statu_pengajuan = 29;
                }

                $this->load->model("surat_oc_model", "surat_oc");
                $join[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[1] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[3] = array('tabel' => 'form_01', 'relation' => 'form_01.id_surat_oc = surat_oc.id_surat_oc', 'direction' => 'left');

                $join[4] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[5] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                $where = array('surat_oc.active IN (1,2)' => NULL, 'surat_oc.id_surat_oc' => $id_surat_oc, 'status_pengajuan' => $statu_pengajuan);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->surat_oc->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $surat_oc = $load_data->row();
                    $konten = array('title' => 'Proses Verifikasi Form 01', 'notif' => $notif, 'surat_oc' => $surat_oc, 'display_only' => false);
                    $this->load->view('open_order/proses_verifikasi_form_01', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $from = '';
                if ($this->session->userdata('id_jns_admin') == 2) {
                    $from = 'verifikasi_koordinator';
                } else if ($this->session->userdata('id_jns_admin') == 5) {
                    $from = 'verifikasi_kabid';
                }
                $konten = array('title' => 'Verifikasi Form 01', 'notif' => $notif, 'from' => $from);
                $this->load->view('open_order/verifikasi_form_01', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_form_01($id_surat_oc = '')
    {
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_surat_oc) {

                $this->load->model("surat_oc_model", "surat_oc");
                $join[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[1] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[3] = array('tabel' => 'form_01', 'relation' => 'form_01.id_surat_oc = surat_oc.id_surat_oc', 'direction' => 'left');

                $join[4] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[5] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                $where = array('surat_oc.active IN (1,2)' => NULL, 'surat_oc.id_surat_oc' => $id_surat_oc, 'status_pengajuan >=' => 25);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->surat_oc->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $surat_oc = $load_data->row();
                    $konten = array('title' => 'Lihat Form 01', 'notif' => $notif, 'surat_oc' => $surat_oc, 'display_only' => true);
                    $this->load->view('open_order/proses_verifikasi_form_01', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function buat_payment_detail($id_form_01 = '')
    {
        $menu = 'page/buat_form_01';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_form_01) {
                $this->load->model("form_01_model", "form_01");
                $join[0] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[2] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[3] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');

                $join[4] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[5] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                $where = array('surat_oc.active IN (1,2)' => NULL, 'id_form_01' => $id_form_01, 'status_pengajuan IN (30, 31)' => null);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->form_01->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $form_01 = $load_data->row();
                    $title = 'Buat Payment Detail';
                    $action = 'save';
                    $payment_detail = null;
                    if ($form_01->status_pengajuan == 31) {
                        $title = 'Revisi Payment Detail';
                        $action = 'revisi';

                        $this->load->model("payment_detail_model", "payment_detail");
                        $where_payment_detail = array('active' => 1, 'id_form_01' => $form_01->id_form_01);
                        $data_send_payment_detail = array('where' => $where_payment_detail);
                        $load_data_payment_detail = $this->payment_detail->load_data($data_send_payment_detail);
                        if ($load_data_payment_detail->num_rows() > 0) {
                            $payment_detail = $load_data_payment_detail->row();
                        }
                    }
                    $konten = array('title' => $title, 'notif' => $notif, 'form_01' => $form_01, 'payment_detail' => $payment_detail, 'action' => $action);
                    $this->load->view('open_order/proses_buat_payment_detail', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $konten = array('title' => 'Buat Payment Detail', 'notif' => $notif);
                $this->load->view('open_order/buat_payment_detail', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function verifikasi_payment_detail($id_payment_detail = '')
    {
        $menu = 'page/verifikasi_payment_detail';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_payment_detail) {
                $this->load->model("payment_detail_model", "payment_detail");
                $join[0] = array('tabel' => 'form_01', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[3] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[4] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');

                $join[5] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[6] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                $where = array('surat_oc.active IN (1,2)' => NULL, 'id_payment_detail' => $id_payment_detail, 'status_pengajuan' => 32);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->payment_detail->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $payment_detail = $load_data->row();

                    $konten = array('title' => 'Verifikasi Payment Detail', 'notif' => $notif, 'payment_detail' => $payment_detail, 'display_only' => false);
                    $this->load->view('open_order/proses_verifikasi_payment_detail', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $konten = array('title' => 'Verifikasi Payment Detail', 'notif' => $notif);
                $this->load->view('open_order/verifikasi_payment_detail', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_payment_detail($id_payment_detail = '')
    {
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_payment_detail) {
                $this->load->model("payment_detail_model", "payment_detail");
                $join[0] = array('tabel' => 'form_01', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[3] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[4] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');

                $join[5] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[6] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                $where = array('surat_oc.active' => 1, 'id_payment_detail' => $id_payment_detail, 'status_pengajuan >=' => 28);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->payment_detail->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $payment_detail = $load_data->row();

                    $konten = array('title' => 'Dokumen Payment Detail', 'notif' => $notif, 'payment_detail' => $payment_detail, 'display_only' => true);
                    $this->load->view('open_order/proses_verifikasi_payment_detail', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $konten = array('title' => 'Verifikasi Payment Detail', 'notif' => $notif);
                $this->load->view('open_order/verifikasi_payment_detail', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function upload_invoice_faktur_pajak()
    {
        $menu = 'page/upload_invoice_faktur_pajak';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Upload Invoice & Faktur Pajak', 'notif' => $notif);
            $this->load->view('open_order/upload_invoice_faktur_pajak', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function lihat_invoice($id_payment_detail = '')
    {
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_payment_detail) {
                $this->load->model("payment_detail_model", "payment_detail");
                $join[0] = array('tabel' => 'form_01', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[3] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[4] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');

                $where = array('surat_oc.active' => 1, 'id_payment_detail' => $id_payment_detail, 'status_pengajuan >=' => 28);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->payment_detail->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $payment_detail = $load_data->row();

                    $konten = array('title' => 'Invoice', 'notif' => $notif, 'payment_detail' => $payment_detail);
                    $this->load->view('open_order/lihat_invoice', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_faktur_pajak($id_payment_detail = '')
    {
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_payment_detail) {
                $this->load->model("payment_detail_model", "payment_detail");
                $join[0] = array('tabel' => 'form_01', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[3] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[4] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');

                $where = array('surat_oc.active' => 1, 'id_payment_detail' => $id_payment_detail, 'status_pengajuan >=' => 28);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->payment_detail->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $payment_detail = $load_data->row();

                    $konten = array('title' => 'Faktur Pajak', 'notif' => $notif, 'payment_detail' => $payment_detail);
                    $this->load->view('open_order/lihat_faktur_pajak', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_bukti_potong_pph_23($id_payment_detail = '')
    {
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_payment_detail) {
                $this->load->model("payment_detail_model", "payment_detail");
                $join[0] = array('tabel' => 'form_01', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[3] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[4] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');

                $where = array('surat_oc.active' => 1, 'id_payment_detail' => $id_payment_detail, 'status_pengajuan >=' => 28);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->payment_detail->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $payment_detail = $load_data->row();

                    $konten = array('title' => 'Bukti Potong PPh 23', 'notif' => $notif, 'payment_detail' => $payment_detail);
                    $this->load->view('open_order/lihat_bukti_potong_pph_23', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }


    #RIWAYAT DOKUMEN
    public function dokumen_permohonan()
    {
        $menu = 'page/dokumen_permohonan';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Riwayat Permohonan TKDN', 'notif' => $notif);
            $this->load->view('riwayat_dokumen/dokumen_permohonan', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function riwayat_pembayaran()
    {
        $menu = 'page/riwayat_pembayaran';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Riwayat Pembayaran', 'notif' => $notif);
            $this->load->view('riwayat_dokumen/riwayat_pembayaran', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function surat_penawaran_rilis()
    {
        $menu = 'page/surat_penawaran_rilis';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Surat Penawaran Rilis', 'notif' => $notif);

            $this->load->view('riwayat_dokumen/surat_penawaran', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function riwayat_surat_oc()
    {
        $menu = 'page/riwayat_surat_oc';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Riwayat Surat Konfirmasi Order', 'notif' => $notif);

            $this->load->view('riwayat_dokumen/riwayat_oc', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function riwayat_reminder_pembayaran_oc()
    {
        $menu = 'page/riwayat_reminder_pembayaran_oc';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array(
                'title' => 'Riwayat Reminder Pembayaran OC',
                'notif' => $notif,
                'from' => 'riwayat_reminder_pembayaran_oc'
            );

            $this->load->view('riwayat_dokumen/riwayat_reminder_pembayaran_oc', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function riwayat_proforma_invoice()
    {
        $menu = 'page/riwayat_proforma_invoice';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Riwayat Proforma Invoice', 'notif' => $notif);

            $this->load->view('riwayat_dokumen/proforma_invoice', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function riwayat_form_01()
    {
        $menu = 'page/riwayat_form_01';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Riwayat Form 01', 'notif' => $notif);

            $this->load->view('riwayat_dokumen/riwayat_form_01', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function riwayat_payment_detail()
    {
        $menu = 'page/riwayat_payment_detail';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Riwayat Payment Detail', 'notif' => $notif);

            $this->load->view('riwayat_dokumen/riwayat_payment_detail', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function riwayat_invoice_faktur_pajak()
    {
        $menu = 'page/riwayat_invoice_faktur_pajak';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Riwayat Invoice & Faktur Pajak', 'notif' => $notif);

            $this->load->view('riwayat_dokumen/riwayat_invoice_faktur_pajak', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    #====================== 
    # OPENING MEETING AREA...
    #======================


    public function komponen_sppd()
    {
        $menu = 'page/komponen_sppd';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {

            $konten = array('title' => 'Komponen SPPD');
            $this->load->view('master/komponen_sppd', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }


    public function ttd_dokumen()
    {
        $menu = 'page/ttd_dokumen';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {

            $konten = array('title' => 'Penandatangan Komponen');
            $this->load->view('master/ttd_dokumen', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function penugasan_assesor()
    {
        $menu = 'page/penugasan_assesor';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $this->load->model("mst_admin_model", "admin");
            $where = array('id_jns_admin' => 3);
            $data_send = array('where' => $where);
            $assesor = $this->admin->load_data($data_send);

            $konten = array('title' => 'Penugasan Verifikator', 'notif' => $notif, 'assesor' => $assesor);
            $this->load->view('opening_meeting/penugasan_assesor', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function buat_surat_tugas($id_opening_meeting = '')
    {
        $menu = 'page/buat_surat_tugas';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            if ($id_opening_meeting) {
                #cek apakah id_opening_meeting ada...
                $this->load->model('opening_meeting_model', 'opening_meeting');
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $join[1] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[3] = array('tabel' => 'surat_oc', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[4] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[5] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');

                $join[6] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[7] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

                $join[8] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
                $join[9] = array('tabel' => 'mst_admin', 'relation' => 'opening_meeting.id_assesor = mst_admin.id_admin', 'direction' => 'left');

                $where = "opening_meeting.active = 1 and opening_meeting.id_assesor = '" . $this->session->userdata('id_admin') . "' and opening_meeting.id_status IN (1,2) and id_opening_meeting = '" . $id_opening_meeting . "'";
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $surat_tugas = null;
                    $this->load->model('surat_tugas_model', 'surat_tugas');
                    $where_surat_tugas = array('surat_tugas.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'tipe_surat_tugas' => 'opening_meeting');
                    $data_send_surat_tugas = array('where' => $where_surat_tugas);
                    $load_data_surat_tugas = $this->surat_tugas->load_data($data_send_surat_tugas);
                    if ($load_data_surat_tugas->num_rows() > 0) {
                        $surat_tugas = $load_data_surat_tugas->row();
                    }

                    $konten = array(
                        'title' => 'Form Surat Tugas',
                        'notif' => $notif,
                        'opening_meeting' => $load_data->row(),
                        'surat_tugas' => $surat_tugas,
                        'tipe_surat_tugas' => 'opening_meeting'
                    );
                    $this->load->view('opening_meeting/form_surat_tugas', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $konten = array('title' => 'Buat Surat Tugas', 'notif' => $notif);
                $this->load->view('opening_meeting/surat_tugas', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function lihat_surat_tugas($id_surat_tugas)
    {
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();

            if ($id_surat_tugas) {
                #cek apakah surat tugas ada atau tidak...
                $this->load->model('surat_tugas_model', 'surat_tugas');
                $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = surat_tugas.id_opening_meeting', 'direction' => 'left');
                $where = array('surat_tugas.active' => 1, 'id_surat_tugas' => $id_surat_tugas, 'opening_meeting.id_status >=' => 2);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->surat_tugas->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $surat_tugas = $load_data->row();
                    $konten = array('title' => 'Surat Tugas', 'notif' => $notif, 'surat_tugas' => $surat_tugas);
                    $this->load->view('opening_meeting/lihat_surat_tugas', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        }
    }

    public function upload_dokumen_opening_meeting($id_opening_meeting = '')
    {
        $menu = 'page/upload_dokumen_opening_meeting';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            if ($id_opening_meeting) {
                #cek apakah id_opening_meeting ada...
                $this->load->model('opening_meeting_model', 'opening_meeting');
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $join[1] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[3] = array('tabel' => 'surat_oc', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[4] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[5] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');

                $join[6] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[7] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

                $join[8] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
                $join[9] = array('tabel' => 'mst_admin', 'relation' => 'opening_meeting.id_assesor = mst_admin.id_admin', 'direction' => 'left');

                $where = "opening_meeting.active = 1 and opening_meeting.id_assesor = '" . $this->session->userdata('id_admin') . "' and opening_meeting.id_status IN (3) and id_opening_meeting = '" . $id_opening_meeting . "'";
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $konten = array('title' => 'Form Upload Dokumen Opening Meeting', 'notif' => $notif, 'opening_meeting' => $load_data->row());
                    $this->load->view('opening_meeting/form_upload_dokumen', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $konten = array('title' => 'Upload Dokumen Opening Meeting', 'notif' => $notif);
                $this->load->view('opening_meeting/upload_dokumen', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function verifikasi_dokumen_opening_meeting($id_opening_meeting = '')
    {
        $menu = 'page/verifikasi_dokumen_opening_meeting';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Verifikasi Dokumen Opening Meeting', 'notif' => $notif);
            $this->load->view('opening_meeting/verifikasi_dokumen', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function proses_collecting_document($id_opening_meeting = '')
    {
        $menu = 'page/proses_collecting_document';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_opening_meeting) {
                $id_admin = $this->session->userdata('id_admin');

                $this->load->model('opening_meeting_model', 'opening_meeting');
                $select = "*, opening_meeting.id_assesor id_assesor_opening_meeting";
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

                $where = "opening_meeting.active = 1 and id_opening_meeting = '" . $id_opening_meeting . "' and (id_status >= 7 and id_status < 15) and (opening_meeting.id_assesor = '" . $id_admin . "' or opening_meeting.id_opening_meeting IN (select id_opening_meeting from opening_meeting_asisten_assesor where active = 1 and id_admin = '" . $id_admin . "'))";
                $data_send = array('where' => $where, 'join' => $join, 'select' => $select);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();
                    $notif = $this->notifikasi();

                    $btn_siap_survey = false;
                    if ($opening_meeting->id_assesor_opening_meeting == $id_admin) {
                        $btn_siap_survey = true;
                    }

                    $konten = array('title' => 'Collecting Document', 'notif' => $notif, 'btn_siap_survey' => $btn_siap_survey, 'opening_meeting' => $opening_meeting);
                    $this->load->view('collecting_document/lihat_collecting_document', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $konten = array('title' => 'Collecting Document', 'notif' => $notif);
                $this->load->view('collecting_document/collecting_document', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function folder_collecting_document($id_opening_meeting = '')
    {
        $menu = 'page/dokumen_verifikasi_tkdn';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_opening_meeting) {
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


                $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'opening_meeting.id_assesor' => $this->session->userdata('id_admin'), 'id_status >= ' => 14);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();
                    $notif = $this->notifikasi();

                    $konten = array('title' => 'Collecting Document', 'notif' => $notif, 'opening_meeting' => $opening_meeting);
                    $this->load->view('collecting_document/folder_collecting_document', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function buat_reminder_collecting_document_habis($id_opening_meeting = '')
    {
        $menu = 'page/proses_collecting_document';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_opening_meeting) {
                $id_opening_meeting = htmlentities($id_opening_meeting ?? '');

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

                $where = array('opening_meeting.active' => 1, 'opening_meeting.id_opening_meeting' => $id_opening_meeting);  #show active data...
                $send_data = array('where' => $where, 'join' => $join);
                $opening_meeting = $this->opening_meeting->load_data($send_data);
                if ($opening_meeting->num_rows() > 0) {
                    $opening_meeting = $opening_meeting->row();
                    if ($opening_meeting->id_status == 7 or $opening_meeting->id_status == 10) {
                        $pemenuhan_dokumen = null;
                        #cari pemberitahuan pemenuhan dokumen yang ditolak...
                        if ($opening_meeting->id_status == 10) {
                            $this->load->model('pemberitahuan_pemenuhan_dokumen_model', 'pemberitahuan_pemenuhan_dokumen');
                            $where_pemenuhan = array('pemberitahuan_pemenuhan_dokumen.active' => 1, 'id_opening_meeting' => $opening_meeting->id_opening_meeting);
                            $data_send_pemenuhan = array('where' => $where_pemenuhan);
                            $load_data_pemenuhan = $this->pemberitahuan_pemenuhan_dokumen->load_data($data_send_pemenuhan);
                            if ($load_data_pemenuhan->num_rows() > 0) {
                                $pemenuhan_dokumen = $load_data_pemenuhan->row();
                            }

                            $title = 'Revisi Pemberitahuan Pemenuhan Dokumen';
                        } else {
                            $title = 'Buat Pemberitahuan Pemenuhan Dokumen';
                        }
                        $konten = array(
                            'title' => $title,
                            'notif' => $notif,
                            'opening_meeting' => $opening_meeting,
                            'pemenuhan_dokumen' => $pemenuhan_dokumen
                        );
                        $this->load->view('collecting_document/pemberitahuan_pemenuhan_dokumen', $this->data_halaman($konten));
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
    public function lihat_pemberitahuan_pemenuhan_dokumen($id_opening_meeting = '')
    {
        if ($this->validasi_login()) {
            #cek apakah dokumen pemberitahuan ada...
            $this->load->model('pemberitahuan_pemenuhan_dokumen_model', 'pemberitahuan_pemenuhan_dokumen');
            $cek = $this->pemberitahuan_pemenuhan_dokumen->is_available(array(
                'id_opening_meeting' => $id_opening_meeting
            ));

            if ($cek) {
                $notif = $this->notifikasi();

                $konten = array('title' => 'Lihat Pemberitahuan Pemenuhan Dokumen', 'notif' => $notif, 'id_opening_meeting' => $id_opening_meeting, 'display_only' => true);
                $this->load->view('collecting_document/lihat_pemberitahuan_pemenuhan_dokumen', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function verifikasi_pemberitahuan_pemenuhan_dokumen($id_opening_meeting = '')
    {
        $menu = 'page/verifikasi_pemberitahuan_pemenuhan_dokumen';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_opening_meeting) {
                $this->load->model('pemberitahuan_pemenuhan_dokumen_model', 'pemberitahuan_pemenuhan_dokumen');
                if ($this->session->userdata('id_jns_admin') == 2) {
                    $id_status = 8;
                } else if ($this->session->userdata('id_jns_admin') == 5) {
                    $id_status = 9;
                } else {
                    $id_status = 'x';
                }

                $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = pemberitahuan_pemenuhan_dokumen.id_opening_meeting', 'direction' => 'left');
                $where = array('pemberitahuan_pemenuhan_dokumen.active' => 1, 'id_status' => $id_status, 'pemberitahuan_pemenuhan_dokumen.id_opening_meeting' => $id_opening_meeting);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->pemberitahuan_pemenuhan_dokumen->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $notif = $this->notifikasi();

                    $konten = array('title' => 'Verifikasi Pemberitahuan Pemenuhan Dokumen', 'notif' => $notif, 'id_opening_meeting' => $id_opening_meeting, 'display_only' => false);
                    $this->load->view('collecting_document/lihat_pemberitahuan_pemenuhan_dokumen', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $konten = array('title' => 'Verifikasi Pemberitahuan Pemenuhan Dokumen', 'notif' => $notif, 'from' => 'verifikasi_pemberitahuan_pemenuhan_dokumen');
                $this->load->view('collecting_document/verifikasi_pemberitahuan_pemenuhan_dokumen', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function verifikasi_surat_permohonan_perpanjangan_waktu($id_opening_meeting = '')
    {
        if ($this->validasi_login()) {
            $id_opening_meeting = htmlentities($id_opening_meeting ?? '');

            $this->load->model('opening_meeting_model', 'opening_meeting');
            $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_status >= ' => 11);
            $data_send = array('where' => $where);
            $load_data = $this->opening_meeting->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $opening_meeting = $load_data->row();
                $notif = $this->notifikasi();

                $konten = array('title' => 'Verifikasi Surat Permohonan Perpanjangan Waktu', 'notif' => $notif, 'opening_meeting' => $opening_meeting, 'display_only' => false);
                $this->load->view('collecting_document/lihat_permohonan_perpanjangan_waktu', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lihat_surat_permohonan_perpanjangan_waktu($id_opening_meeting = '')
    {
        if ($this->validasi_login()) {
            $id_opening_meeting = htmlentities($id_opening_meeting ?? '');

            $this->load->model('opening_meeting_model', 'opening_meeting');
            $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_status >= ' => 11);
            $data_send = array('where' => $where);
            $load_data = $this->opening_meeting->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                $opening_meeting = $load_data->row();
                $notif = $this->notifikasi();

                $konten = array('title' => 'Verifikasi Surat Permohonan Perpanjangan Waktu', 'notif' => $notif, 'opening_meeting' => $opening_meeting, 'display_only' => true);
                $this->load->view('collecting_document/lihat_permohonan_perpanjangan_waktu', $this->data_halaman($konten));
            } else {
                $this->lost();
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function penungasan_assesor_lapangan()
    {
        $menu = 'page/penungasan_assesor_lapangan';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $this->load->model("mst_admin_model", "admin");
            $where = array('id_jns_admin' => 3);
            $data_send = array('where' => $where);
            $assesor = $this->admin->load_data($data_send);

            $konten = array('title' => 'Penugasan Verifikator Survey Lapangan', 'notif' => $notif, 'assesor' => $assesor);
            $this->load->view('survey_lapangan/penugasan_assesor', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function pekerjaan()
    {
        $menu = 'page/pekerjaan';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Pekerjaan Survey Lapangan', 'notif' => $notif);
            $this->load->view('survey_lapangan/pekerjaan', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function verifikasi_dokumen_survey_lapangan($id_survey_lapangan_perjab = '')
    {
        $menu = 'page/verifikasi_dokumen_survey_lapangan';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            if ($id_survey_lapangan_perjab) {
                $id_jns_admin = $this->session->userdata('id_jns_admin');
                $status = 'x';
                if ($id_jns_admin == 4) {
                    $status = 3;
                } else if ($id_jns_admin == 2) {
                    $status = 2;
                }
                $this->load->model('survey_lapangan_perjab_model', 'survey_lapangan_perjab');
                $where = array('survey_lapangan_perjab.active' => 1, 'id_survey_lapangan_perjab' => $id_survey_lapangan_perjab, 'status_verifikasi' => $status);
                $data_send = array('where' => $where);
                $load_data = $this->survey_lapangan_perjab->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $data = $load_data->row();
                    $konten = array('title' => 'Verifikasi Perjab Biaya Survey', 'notif' => $notif, 'data' => $data);
                    $this->load->view('survey_lapangan/verifikasi_dokumen', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $konten = array('title' => 'Verifikasi Perjab Biaya Survey', 'notif' => $notif);
                $this->load->view('survey_lapangan/list_verifikasi_dokumen', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function surat_tugas_lapangan($id_opening_meeting = '')
    {
        $menu = 'page/pekerjaan';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            if ($id_opening_meeting) {
                #cek apakah id_opening_meeting ada...
                $this->load->model('opening_meeting_model', 'opening_meeting');
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $join[1] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[3] = array('tabel' => 'surat_oc', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[4] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[5] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');

                $join[6] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[7] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

                $join[8] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
                $join[9] = array('tabel' => 'mst_admin', 'relation' => 'opening_meeting.id_assesor = mst_admin.id_admin', 'direction' => 'left');

                $where = "opening_meeting.active = 1 and opening_meeting.id_status >= 15 and id_opening_meeting IN (select id_opening_meeting from survey_lapangan_assesor a where a.active = 1 and a.id_admin = '" . $this->session->userdata('id_admin') . "' and a.id_opening_meeting = '" . $id_opening_meeting . "')";
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    // $surat_tugas = null;
                    // $this->load->model('surat_tugas_model', 'surat_tugas');
                    // $where_surat_tugas = array('surat_tugas.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
                    // $data_send_surat_tugas = array('where' => $where_surat_tugas);
                    // $load_data_surat_tugas = $this->surat_tugas->load_data($data_send_surat_tugas);
                    // if ($load_data_surat_tugas->num_rows() > 0) {
                    //     $surat_tugas = $load_data_surat_tugas->row();
                    // }

                    $konten = array(
                        'title' => 'Form Surat Tugas',
                        'notif' => $notif,
                        'opening_meeting' => $load_data->row(),
                        // 'surat_tugas' => $surat_tugas,
                        'tipe_surat_tugas' => 'survey_lapangan'
                    );
                    $this->load->view('opening_meeting/form_surat_tugas', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->redirect(base_url() . 'page/pekerjaan');
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function buat_sppd($id_opening_meeting = '')
    {
        $menu = 'page/pekerjaan';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $id_admin = $this->session->userdata('id_admin');
            $id_sppd = htmlentities($this->input->get('id_sppd') ?? '');
            $notif = $this->notifikasi();

            #load model...
            $this->load->model('sppd_item_rab_model', 'sppd_item_rab');
            $this->load->model('survey_lapangan_assesor_model', 'survey_lapangan_assesor');
            $this->load->model('mst_admin_model', 'mst_admin');
            $this->load->model('opening_meeting_model', 'opening_meeting');
            $this->load->model('reg_regencies_model', 'reg_regencies');
            $this->load->model('komponen_sppd_model', 'komponen_sppd');
            $this->load->model('sppd_model', 'sppd');
            $this->load->model('sppd_project_model', 'sppd_project');
            $this->load->model('sppd_reguler_model', 'sppd_reguler');
            $this->load->model('sppd_rincian_realisasi_model', 'sppd_rincian_realisasi');
            $this->load->model('mst_admin_model', 'mst_admin');

            $konten = array(
                'title' => 'Buat SPPD',
                'notif' => $notif,
                'id_opening_meeting' => $id_opening_meeting,
            );

            #cek apakah Verifikator berhak membuka halaman ini...
            $cek_assesor = $this->survey_lapangan_assesor->is_available(array(
                'active' => 1,
                'id_admin' => $id_admin,
                'id_opening_meeting' => $id_opening_meeting
            ));

            if ($cek_assesor) {
                #cek apakah admin memiliki jns_sppd pada dirinya...
                $where_admin = array('id_admin' => $id_admin);
                $data_send_admin = array('where' => $where_admin);
                $load_data_admin = $this->mst_admin->load_data($data_send_admin);
                if ($load_data_admin->num_rows() > 0) {
                    $admin = $load_data_admin->row();

                    if ($admin->jns_sppd) {
                        #load data permohonan...
                        $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                        $join[1] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = rab.id_dokumen_permohonan', 'direction' => 'left');
                        $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');
                        $join[3] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
                        $join[4] = array('tabel' => 'form_01', 'relation' => 'form_01.id_surat_oc = surat_oc.id_surat_oc', 'direction' => 'left');
                        $join[5] = array('tabel' => 'payment_detail', 'relation' => 'payment_detail.id_form_01 = form_01.id_form_01', 'direction' => 'left');
                        $join[6] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                        $join[7] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                        $where_permohonan = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
                        $data_send_permohonan = array('where' => $where_permohonan, 'join' => $join);
                        $load_data_permohonan = $this->opening_meeting->load_data($data_send_permohonan);
                        if ($load_data_permohonan->num_rows() > 0) {
                            $konten['dokumen_permohonan'] = $load_data_permohonan->row();

                            #load tempat pelaksanaan...
                            $where_reg_regencies = array('allow_sppd' => 1);
                            $data_send_reg_regencies = array('where' => $where_reg_regencies);
                            $load_data_reg_regencies = $this->reg_regencies->load_data($data_send_reg_regencies);
                            $konten['kota'] = $load_data_reg_regencies;

                            #load komponen sppd...
                            $where_komponen_sppd = array('komponen_sppd.active' => 1);
                            $data_send_komponen_sppd = array('where' => $where_komponen_sppd);
                            $load_data_komponen_sppd = $this->komponen_sppd->load_data($data_send_komponen_sppd);
                            $konten['komponen_sppd'] = $load_data_komponen_sppd;

                            $konten['action'] = 'new';

                            #jika ada id_sppd, artinya sedang dalam mode revisi...
                            if ($id_sppd) {
                                $konten['id_sppd'] = $id_sppd;
                                $where_sppd_revisi = array('sppd.active' => 1, 'id_sppd' => $id_sppd);
                                $data_send_sppd_revisi = array('where' => $where_sppd_revisi);
                                $load_data_sppd_revisi = $this->sppd->load_data($data_send_sppd_revisi);
                                if ($load_data_sppd_revisi->num_rows() > 0) {
                                    $sppd = $load_data_sppd_revisi->row();

                                    $konten['action'] = 'revisi';
                                    $konten['sppd'] = $sppd;
                                    $admin->jns_sppd = $sppd->jns_sppd;
                                } else {
                                    $this->lost();
                                    return false;
                                }
                            }

                            #tampilkan form pembuatan sppd sesuai jenis sppdnya...
                            if ($admin->jns_sppd == 'PTT Project') {
                                $konten['title'] = $konten['title'] . ' - PTT Project';

                                if ($id_sppd) {
                                    $where_project = array('sppd_project.active' => 1, 'id_sppd' => $id_sppd);
                                    $where_project = "sppd_project.active = 1 and id_sppd = '" . $id_sppd . "'";
                                    $data_send_project = array('where' => $where_project);
                                    $load_data_project = $this->sppd_project->load_data($data_send_project);
                                    if ($load_data_project->num_rows() > 0) {
                                        $konten['ptt_project'] = $load_data_project->row();

                                        #mencari rincian PTT Project...
                                        $where_rincian = array('sppd_rincian_realisasi.active' => 1, 'id_sppd' => $id_sppd);
                                        $data_send_rincian = array('where' => $where_rincian);
                                        $load_data_rincian = $this->sppd_rincian_realisasi->load_data($data_send_rincian);
                                        $konten['rincian_sppd'] = $load_data_rincian->result();
                                    } else {
                                        $this->lost();
                                        return false;
                                    }
                                }

                                $this->load->view('sppd/ptt_project', $this->data_halaman($konten));
                            } else if ($admin->jns_sppd == 'PTT Reguler' or $admin->jns_sppd == 'PT') {
                                if ($admin->jns_sppd == 'PTT Reguler') {
                                    $konten['title'] = $konten['title'] . ' - PTT Reguler';
                                } else {
                                    $konten['title'] = $konten['title'] . ' - PTT PT';
                                }

                                #mencari koordinator
                                $where_koordinator = array('status_admin' => 'A', 'id_jns_admin' => 2);
                                $data_send_koordinator = array('where' => $where_koordinator);
                                $load_data_koordinator = $this->mst_admin->load_data($data_send_koordinator);
                                if ($load_data_koordinator->num_rows() > 0) {
                                    $konten['koordinator'] = $load_data_koordinator->row();
                                }

                                if ($id_sppd) {
                                    $where_reguler = array('sppd_reguler.active' => 1, 'id_sppd' => $id_sppd);
                                    $where_reguler = "sppd_reguler.active = 1 and id_sppd = '" . $id_sppd . "'";
                                    $data_send_reguler = array('where' => $where_reguler);
                                    $load_data_reguler = $this->sppd_reguler->load_data($data_send_reguler);
                                    if ($load_data_reguler->num_rows() > 0) {
                                        $konten['ptt_reguler'] = $load_data_reguler->row();

                                        #mencari rincian PTT reguler...
                                        $where_rincian = array('sppd_rincian_realisasi.active' => 1, 'id_sppd' => $id_sppd);
                                        $data_send_rincian = array('where' => $where_rincian);
                                        $load_data_rincian = $this->sppd_rincian_realisasi->load_data($data_send_rincian);
                                        $konten['rincian_sppd'] = $load_data_rincian->result();
                                    } else {
                                        $this->lost();
                                        return false;
                                    }
                                }

                                $this->load->view('sppd/ptt_reguler', $this->data_halaman($konten));
                            } else {
                                $this->load->view('sppd/tidak_ada_hak_sppd', $this->data_halaman($konten));
                            }
                        } else {
                            $this->lost();
                            return false;
                        }
                    } else {
                        $this->load->view('sppd/tidak_ada_hak_sppd', $this->data_halaman($konten));
                    }
                } else {
                    $this->lost();
                    return false;
                }
            } else {
                $this->lost();
                return false;
            }
        }
    }
    public function lihat_sppd($id_opening_meeting = '')
    {
        $menu = 'page/pekerjaan';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $id_admin = $this->session->userdata('id_admin');
            $id_sppd = htmlentities($this->input->get('id_sppd') ?? '');
            $notif = $this->notifikasi();

            #load model...
            $this->load->model('sppd_model', 'sppd');


            if ($id_opening_meeting and $id_sppd) {
                $where = array('sppd.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_sppd' => $id_sppd);
                $data_send = array('where' => $where);
                $load_data = $this->sppd->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $sppd = $load_data->row();

                    $url = '';
                    if ($sppd->jns_sppd == 'PTT Reguler' or $sppd->jns_sppd == 'PT') {
                        $url = 'sppd_reguler';
                    } else if ($sppd->jns_sppd == 'PTT Project') {
                        $url = 'sppd_project';
                    }

                    $konten = array(
                        'title' => 'Lihat SPPD',
                        'notif' => $notif,
                        'sppd' => $sppd,
                        'url' => $url
                    );
                    $this->load->view('sppd/lihat_sppd', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        }
    }

    #====================== 
    # RIWAYAT COLLECTING DOCUMENT II AREA...
    #======================
    public function verifikasi_collecting_document_2($id_opening_meeting = '')
    {
        $menu = 'page/verifikasi_collecting_document_2';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_opening_meeting) {
                $id_opening_meeting = htmlentities($id_opening_meeting ?? '');
                $id_admin = $this->session->userdata('id_admin');

                $this->load->model('opening_meeting_model', 'opening_meeting');
                $select = "*, opening_meeting.id_assesor id_assesor_opening_meeting";
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

                $where = "opening_meeting.active = 1 and id_opening_meeting = '" . $id_opening_meeting . "' and id_status = 16 and (opening_meeting.id_assesor = '" . $id_admin . "' or opening_meeting.id_opening_meeting IN (select id_opening_meeting from opening_meeting_asisten_assesor where active = 1 and id_admin = '" . $id_admin . "'))";
                $data_send = array('where' => $where, 'join' => $join, 'select' => $select);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();
                    $notif = $this->notifikasi();

                    $konten = array('title' => 'Verifikasi Collecting Document Tahap 2', 'notif' => $notif, 'opening_meeting' => $opening_meeting);
                    $this->load->view('collecting_document/verifikasi_collecting_document_tahap_2', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $konten = array('title' => 'Verifikasi Collecting Document Tahap 2', 'notif' => $notif);
                $this->load->view('collecting_document/collecting_document_tahap_2', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function proses_verifikasi_collecting_document_2($id_collecting_dokumen_2 = '')
    {
        $menu = 'page/verifikasi_collecting_document_2';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            if ($id_collecting_dokumen_2) {
                $id_admin = $this->session->userdata('id_admin');
                $id_collecting_dokumen_2 = htmlentities($id_collecting_dokumen_2 ?? '');

                $this->load->model('collecting_dokumen_tahap2_model', 'collecting_dokumen_tahap2');
                $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = collecting_dokumen_tahap2.id_opening_meeting', 'direction' => 'left');
                $where = array('collecting_dokumen_tahap2.active' => 1, 'id_collecting_dokumen_2' => $id_collecting_dokumen_2);
                $where = "collecting_dokumen_tahap2.active = 1 and id_collecting_dokumen_2 = '" . $id_collecting_dokumen_2 . "' and (opening_meeting.id_assesor = '" . $id_admin . "' or opening_meeting.id_opening_meeting IN (select id_opening_meeting from opening_meeting_asisten_assesor where active = 1 and id_admin = '" . $id_admin . "'))";
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->collecting_dokumen_tahap2->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $data = $load_data->row();

                    $konten = array(
                        'title' => 'Verifikasi Collecting Document Tahap 2',
                        'notif' => $notif,
                        'file' => $data->path_file,
                        'id_dokumen' => $data->id_collecting_dokumen_2,
                        'url_verifikasi' => base_url() . 'collecting_dokumen_tahap2/verifikasi_dokumen',
                        'redirect_after_save' => base_url() . "page/verifikasi_collecting_document_2/" . $data->id_opening_meeting,
                        'display_only' => false
                    );
                    $this->load->view('panel_internal/preview_dokumen', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $this->lost();
            }
        }
    }

    #======================


    #====================== 
    # RIWAYAT PANEL AREA...
    #======================
    public function upload_dokumen_panel_internal($id_opening_meeting = '')
    {
        $menu = 'page/upload_dokumen_panel_internal';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            if ($id_opening_meeting) {
                $id_admin = $this->session->userdata('id_admin');
                $id_jns_admin = $this->session->userdata('id_jns_admin');

                $this->load->model('opening_meeting_model', 'opening_meeting');
                $select = "*, opening_meeting.id_assesor id_assesor_opening_meeting";
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

                $where = "opening_meeting.active = 1 and id_opening_meeting = '" . $id_opening_meeting . "' and (id_status >= 17 and id_status <= 18)";

                if ($id_jns_admin == 3) {
                    $aktor = 'assesor';
                    $btn_siap_lanjut = true;
                    $where .= " and (opening_meeting.id_assesor = '" . $id_admin . "' or opening_meeting.id_opening_meeting IN (select id_opening_meeting from opening_meeting_asisten_assesor where active = 1 and id_admin = '" . $id_admin . "'))";
                } else {
                    $aktor = 'admin';
                    $btn_siap_lanjut = false;
                }
                $data_send = array('where' => $where, 'join' => $join, 'select' => $select);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();

                    $konten = array(
                        'title' => 'Upload Dokumen',
                        'notif' => $notif,
                        'opening_meeting' => $opening_meeting,
                        'aktor' => $aktor,
                        'btn_siap_lanjut' => $btn_siap_lanjut,
                    );
                    $this->load->view('panel_internal/proses_upload_dokumen', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $konten = array('title' => 'Upload Dokumen', 'notif' => $notif);
                $this->load->view('panel_internal/upload_dokumen', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function lhv($id_opening_meeting = '')
    {
        $menu = 'page/upload_dokumen_panel_internal';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            if ($id_opening_meeting) {
                $id_panel_internal_lhv = htmlentities($this->input->get('id_lhv') ?? '');

                $id_admin = $this->session->userdata('id_admin');
                $id_jns_admin = $this->session->userdata('id_jns_admin');

                $this->load->model('opening_meeting_model', 'opening_meeting');
                $select = "*, opening_meeting.id_assesor id_assesor_opening_meeting";
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

                $where = "opening_meeting.active = 1 and id_opening_meeting = '" . $id_opening_meeting . "' and (id_status >= 17 and id_status <= 18)";

                #cek apakah aktor berhak membuat LHV berdasarkan id_opening_meetingnya...
                if ($id_jns_admin == 3) {
                    $aktor = 'assesor';
                    $where .= " and (opening_meeting.id_assesor = '" . $id_admin . "' or opening_meeting.id_opening_meeting IN (select id_opening_meeting from opening_meeting_asisten_assesor where active = 1 and id_admin = '" . $id_admin . "'))";
                } else {
                    $aktor = 'admin';
                }

                $data_send = array('where' => $where, 'join' => $join, 'select' => $select);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();

                    #cek apakah aktor boleh membuat lhv...
                    $this->load->model('panel_internal_nama_file_model', 'nama_file');

                    $where_lhv = array(
                        'active' => 1,
                        'referensi' => 'lhv',
                        'id_tipe_permohonan' => $opening_meeting->id_tipe_permohonan,
                        'aktor like \'%' . $aktor . '%\'' => null
                    );
                    $data_send_lhv = array('where' => $where_lhv);
                    $load_data_lhv = $this->nama_file->load_data($data_send_lhv);
                    if ($load_data_lhv->num_rows() > 0) {
                        $nama_file = $load_data_lhv->row();
                        $konten = array(
                            'title' => 'Buat LHV',
                            'notif' => $notif,
                            'opening_meeting' => $opening_meeting,
                            'nama_file' => $nama_file,
                            'aktor' => $aktor,
                            'id_panel_internal_lhv' => $id_panel_internal_lhv,
                        );
                        $this->load->view('panel_internal/lhv', $this->data_halaman($konten));
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

    public function verifikasi_dokumen_panel_internal($id_opening_meeting = '')
    {
        $menu = 'page/verifikasi_dokumen_panel_internal';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $id_panel_internal_dokumen = $this->input->get('id_panel_internal_dokumen');
            $id_panel_internal_lhv = $this->input->get('id_panel_internal_lhv');

            $konten = array('title' => 'Verifikasi Dokumen Panel Internal', 'notif' => $notif);
            if ($id_opening_meeting) {
                $id_opening_meeting = htmlentities($id_opening_meeting ?? '');

                $this->load->model('opening_meeting_model', 'opening_meeting');
                $select = "*, opening_meeting.id_assesor id_assesor_opening_meeting";
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

                $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_status' => 19);
                $data_send = array('select' => $select, 'where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();
                    $konten['opening_meeting'] = $opening_meeting;

                    if ($id_panel_internal_dokumen) {
                        $id_panel_internal_dokumen = htmlentities($id_panel_internal_dokumen ?? '');
                        $this->load->model('panel_internal_dokumen_model', 'panel_internal_dokumen');
                        $join_dokumen[0] = array('tabel' => 'panel_internal_nama_file', 'relation' => 'panel_internal_nama_file.id_nama_file = panel_internal_dokumen.id_nama_file', 'direction' => 'left');
                        $where_dokumen = array('panel_internal_dokumen.active' => 1, 'id_panel_internal_dokumen' => $id_panel_internal_dokumen);
                        $data_send_dokumen = array('where' => $where_dokumen, 'join' => $join_dokumen);
                        $load_data_dokumen = $this->panel_internal_dokumen->load_data($data_send_dokumen);
                        if ($load_data_dokumen->num_rows() > 0) {
                            $konten['panel_internal_dokumen'] = $load_data_dokumen->row();
                            $konten['from'] = 'panel_internal_dokumen';
                            $this->load->view('panel_internal/proses_verifikasi_dokumen', $this->data_halaman($konten));
                        } else {
                            $this->lost();
                        }
                    } else if ($id_panel_internal_lhv) {
                        $id_panel_internal_lhv = htmlentities($id_panel_internal_lhv ?? '');
                        $this->load->model('panel_internal_lhv_model', 'panel_internal_lhv');
                        $where_lhv = array('panel_internal_lhv.active' => 1, 'id_panel_internal_lhv' => $id_panel_internal_lhv);
                        $data_send_lhv = array('where' => $where_lhv);
                        $load_data_lhv = $this->panel_internal_lhv->load_data($data_send_lhv);
                        if ($load_data_lhv->num_rows() > 0) {
                            $konten['lhv'] = $load_data_lhv->row();
                            $konten['from'] = 'lhv';
                            $this->load->view('panel_internal/proses_verifikasi_dokumen', $this->data_halaman($konten));
                        } else {
                            $this->lost();
                        }
                    } else {
                        $this->load->view('panel_internal/folder_dokumen', $this->data_halaman($konten));
                    }
                } else {
                    $this->lost();
                }
            } else {
                $this->load->view('panel_internal/verifikasi_dokumen', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }


    public function penugasan_etc()
    {
        $menu = 'page/penugasan_etc';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $this->load->model("mst_admin_model", "admin");
            $where = "status_admin = 'A' and etc = 1";
            $data_send = array('where' => $where);
            $verifikator = $this->admin->load_data($data_send);

            $konten = array('title' => 'Penugasan ETC', 'notif' => $notif, 'verifikator' => $verifikator);
            $this->load->view('panel_internal/penugasan_etc', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function approval_assesment_etc()
    {
        $menu = 'page/approval_assesment_etc'; 
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Approval Assessment ETC', 'notif' => $notif);
            $this->load->view('panel_internal/approval_assesment_etc',  $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function preview_dokumen()
    {
        // $menu = 'page/approval_assesment_etc';
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();
            $file = $this->input->get('file');
            $display_only = true;

            $konten = array(
                'title' => 'Preview Dokumen',
                'notif' => $notif,
                'file' => $file,
                'display_only' => $display_only
            );
            $this->load->view('panel_internal/preview_dokumen', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function approval_dokumen()
    {
        // $menu = 'page/approval_assesment_etc';
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();
            $id_dokumen = htmlentities($this->input->get('id_dokumen') ?? '');
            $url_verifikasi = htmlentities($this->input->get('url_verifikasi') ?? '');
            $redirect_after_save = htmlentities($this->input->get('redirect_after_save') ?? '');
            $file = $this->input->get('file');
            $display_only = false;

            $konten = array(
                'title' => 'Approval Dokumen',
                'notif' => $notif,
                'file' => $file,
                'id_dokumen' => $id_dokumen,
                'url_verifikasi' => ($url_verifikasi ? base_url() . $url_verifikasi  : ''),
                'redirect_after_save' => ($redirect_after_save ? base_url() . $redirect_after_save  : ''),
                'display_only' => $display_only
            );
            $this->load->view('panel_internal/preview_dokumen', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function verifikasi_draft_tanda_sah($id_opening_meeting = '')
    {
        $menu = 'page/verifikasi_draft_tanda_sah';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $id_panel_internal_dokumen = htmlentities($this->input->get('dokumen') ?? '');
            if ($id_opening_meeting and $id_panel_internal_dokumen) {

                $id_admin = $this->session->userdata('id_admin');
                $id_jns_admin = $this->session->userdata('id_jns_admin');

                $this->load->model('panel_internal_dokumen_model', 'panel_internal_dokumen');
                $select = "*, opening_meeting.id_assesor id_assesor_opening_meeting, panel_internal_dokumen.status_verifikasi status_verifikasi_dokumen";
                $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = panel_internal_dokumen.id_opening_meeting', 'direction' => 'left');
                $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $join[2] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[3] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[4] = array('tabel' => 'surat_oc', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[5] = array('tabel' => 'proforma_invoice', 'relation' => 'proforma_invoice.id_surat_oc = surat_oc.id_surat_oc', 'direction' => 'left');
                $join[6] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[7] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');

                $join[8] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[9] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

                $join[10] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
                $join[11] = array('tabel' => 'mst_admin', 'relation' => 'opening_meeting.id_assesor = mst_admin.id_admin', 'direction' => 'left');

                $where = "opening_meeting.active = 1 and opening_meeting.id_opening_meeting = '" . $id_opening_meeting . "' and opening_meeting.id_status = 24 and id_panel_internal_dokumen = '" . $id_panel_internal_dokumen . "'";

                $data_send = array('where' => $where, 'join' => $join, 'select' => $select);
                $load_data = $this->panel_internal_dokumen->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();

                    $konten = array(
                        'title' => 'Verifikasi Draft Tanda Sah',
                        'notif' => $notif,
                        'opening_meeting' => $opening_meeting,
                        'display_only' => false,
                        'from' => 'panel_internal_dokumen',
                    );
                    $this->load->view('panel_kemenperin/proses_verifikasi_draft_tanda_sah', $this->data_halaman($konten));
                } else {
                    $this->lost();
                }
            } else {
                $konten = array('title' => 'Verifikasi Draft Tanda Sah', 'notif' => $notif);
                $this->load->view('panel_kemenperin/verifikasi_draft_tanda_sah', $this->data_halaman($konten));
            }
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function assessment_kemenperin()
    {
        $menu = 'page/assessment_kemenperin';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $this->load->model('panel_kemenperin_nama_file_model', 'panel_kemenperin_nama_file');
            $where = array('panel_kemenperin_nama_file.active' => 1);
            $order = "urutan ASC";
            $data_send = array('where' => $where, 'order' => $order);
            $panel_kemenperin_nama_file = $this->panel_kemenperin_nama_file->load_data($data_send);


            $konten = array('title' => 'Assessment Kemenperin', 'notif' => $notif, 'panel_kemenperin_nama_file' => $panel_kemenperin_nama_file);
            $this->load->view('panel_kemenperin/assesment_kemenperin', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function upload_closing_meeting()
    {
        $menu = 'page/upload_closing_meeting';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $this->load->model('panel_kemenperin_nama_file_model', 'panel_kemenperin_nama_file');
            $where = array('panel_kemenperin_nama_file.active' => 1, 'to_closing_meeting' => 1);
            $order = "urutan ASC";
            $data_send = array('where' => $where, 'order' => $order);
            $panel_kemenperin_nama_file = $this->panel_kemenperin_nama_file->load_data($data_send);

            $konten = array('title' => 'Upload Closing Meeting', 'notif' => $notif, 'panel_kemenperin_nama_file' => $panel_kemenperin_nama_file);
            $this->load->view('closing_meeting/data_closing_meeting', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function verifikasi_closing_meeting()
    {
        $menu = 'page/verifikasi_closing_meeting';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $this->load->model('panel_kemenperin_nama_file_model', 'panel_kemenperin_nama_file');
            $where = array('panel_kemenperin_nama_file.active' => 1, 'to_closing_meeting' => 1);
            $order = "urutan ASC";
            $data_send = array('where' => $where, 'order' => $order);
            $panel_kemenperin_nama_file = $this->panel_kemenperin_nama_file->load_data($data_send);

            $id_jns_admin = $this->session->userdata('id_jns_admin');
            $as = '';
            if ($id_jns_admin == 3) {
                $as = 'koordinator';
            } else if ($id_jns_admin == 8) {
                $as = 'dokumen kontrol';
            }

            $konten = array('title' => 'Verifikasi Closing Meeting', 'notif' => $notif, 'as' => $as, 'panel_kemenperin_nama_file' => $panel_kemenperin_nama_file);
            $this->load->view('closing_meeting/verifikasi_closing_meeting', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    #====================== 
    # RIWAYAT OPENING MEETING AREA...
    #======================

    public function dokumen_verifikasi_tkdn()
    {
        $menu = 'page/dokumen_verifikasi_tkdn';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $konten = array('title' => 'Riwayat Verifikasi TKDN', 'notif' => $notif);
            $this->load->view('riwayat_dokumen/dokumen_verifikasi_tkdn', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    #====================== 
    # LAPORAN AREA...
    #======================

    public function laporan_pendapatan()
    {
        $menu = 'page/laporan_pendapatan';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Laporan Pendapatan', 'notif' => $notif);

            $this->load->view('laporan/pendapatan', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function laporan_pendapatan_assesor()
    {
        $menu = 'page/laporan_pendapatan_assesor';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Laporan Pendapatan Verifikator', 'notif' => $notif);

            $this->load->view('laporan/pendapatan', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    #================


    public function hak_akses_permohonan_pemerintah()
    {
        $menu = 'page/hak_akses_permohonan_pemerintah';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();

            $this->load->model('menu_model', 'menu');
            $cek = $this->menu->is_available(array('id_menu' => '101.2', "nama_menu like '%[OFF]%'" => null));
            if ($cek) {
                $checked = '';
            } else {
                $checked = 'checked="checked"';
            }
            $konten = array('title' => 'Hak Akses Permohonan Pemerintah', 'notif' => $notif, 'checked' => $checked);
            $this->load->view('setting/hak_akses_permohonan_pemerintah', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function tipe_admin()
    {
        $menu = 'page/tipe_admin';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $this->lang_loader($menu);

            $konten = array('title' => 'Jabatan', 'notif' => $notif);
            $this->load->view('setting/jns_admin', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function hak_akses_menu()
    {
        $menu = 'page/hak_akses_menu';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $this->lang_loader($menu);
            $konten = array('title' => 'Hak Akses Menu');
            #menampilkan tipe admin...
            $this->load->model('Jns_admin_model', 'jns_admin');
            $load_jns_admin = $this->jns_admin->load_data();
            $konten = array('title' => 'Hak Akses Menu', 'notif' => $notif, 'jns_admin' => $load_jns_admin);

            $this->load->view('setting/hak_akses_menu', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function administrator()
    {
        $menu = 'page/administrator';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {
            $notif = $this->notifikasi();
            $this->lang_loader($menu);
            #menampilkan tipe admin...
            $this->load->model('Jns_admin_model', 'jns_admin');
            $where = "id_jns_admin != 1";
            $send_data = array('where' => $where);
            $load_jns_admin = $this->jns_admin->load_data($send_data);

            $konten = array('title' => 'Pengguna', 'notif' => $notif, 'jns_admin' => $load_jns_admin);

            $this->load->view('setting/administrator', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function profil_saya()
    {
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Profil Saya', 'notif' => $notif);
            $this->load->view('setting/profil_saya', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }
    public function ganti_password()
    {
        if ($this->validasi_login()) {
            $notif = $this->notifikasi();
            $konten = array('title' => 'Ganti Password', 'notif' => $notif);
            $this->load->view('setting/ganti_password', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function upload_invoice_faktur_pajak_2()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->load->library('upload');
        $this->load->model('Upload_invoice_model');
        

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['max_size'] = 2048;

        $results = [];
        $success = true;

        // Upload invoice
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('invoice')) {
            $results['error'] = $this->upload->display_errors();
            $success = false;
        } else {
            $results['invoice'] = $this->upload->data('file_name');
            
        }

        // Upload faktur pajak
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('faktur')) {
            $results['error'] .= '<br>' . $this->upload->display_errors();
            $success = false;
        } else {
            $results['faktur'] = $this->upload->data('file_name');
        }

        if ($success) {
            // Ambil input dari form
            $data_simpan = array(
                'user_id' => $this->session->userdata('id_admin'), // pastikan sesi login benar
                'nama_file_invoice' => $results['invoice'],
                'nama_file_faktur' => $results['faktur'],
                'nomor_invoice' => $this->input->post('nomor_invoice'),
                'tanggal_invoice' => $this->input->post('tanggal_invoice'),
                'nomor_faktur' => $this->input->post('nomor_faktur'),
                'tanggal_upload' => date('Y-m-d H:i:s')
            );

            // Simpan ke DB
            $this->Upload_invoice_model->insert($data_simpan);


            $results['success'] = 'Upload berhasil!';
        }
        // $data['body_parameter'] = '';

        // Tampilkan ulang form dengan status
        $this->load->view('upload_invoice_faktur_pajak_2', vars: $results);
    } else {
        $this->load->view('upload_invoice_faktur_pajak_2');
    }
}
public function daftar_upload_invoice()
{
    $this->load->model('Upload_invoice_model');
    $this->load->library('pagination');

    $config['base_url'] = base_url('page/daftar_upload_invoice');
    $config['total_rows'] = $this->Upload_invoice_model->get_total_rows();
    $config['per_page'] = 10;
    $config['uri_segment'] = 3;

    // Styling pagination (opsional)
    $config['full_tag_open'] = '<nav><ul class="pagination">';
    $config['full_tag_close'] = '</ul></nav>';
    $config['first_tag_open'] = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open'] = '<li class="page-item">';
    $config['first_tag_close'] = $config['last_tag_close'] = $config['next_tag_close'] = $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close'] = '</span></li>';
    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['attributes'] = array('class' => 'page-link');

    $this->pagination->initialize($config);

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

    $data['upload_list'] = $this->Upload_invoice_model->get_paginated($config['per_page'], $page);
    $data['pagination'] = $this->pagination->create_links();

    $this->load->view('daftar_upload_invoice', $data);
}

public function upload_invoice_list()

{
    $this->load->model('Upload_invoice_model');
    $data['uploads'] = $this->Upload_invoice_model->get_all();

    // ⬇ Ini memanggil view dan melempar data dari model
    $this->load->view('upload_invoice_list', $data);
}


public function upload_invoice_form($id = null)
{
    $this->load->model('Upload_invoice_model');
    $data['data'] = $id ? $this->Upload_invoice_model->get_by_id($id) : null;
    $this->load->view('upload_invoice_form', $data);
}

public function upload_invoice_save()
{
    $this->load->model('Upload_invoice_model');
    $id = $this->input->post('id');

    // Upload config
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'pdf';
    $config['max_size'] = 2048;
    $this->load->library('upload');

    $data = [
        'user_id' => $this->session->userdata('id_admin'),
        'nomor_invoice' => $this->input->post('nomor_invoice'),
        'tanggal_invoice' => $this->input->post('tanggal_invoice'),
        'nomor_faktur' => $this->input->post('nomor_faktur'),
        'tanggal_upload' => date('Y-m-d H:i:s'),
    ];

    if ($_FILES['invoice']['name']) {
        $this->upload->initialize($config);
        if ($this->upload->do_upload('invoice')) {
            $data['nama_file_invoice'] = $this->upload->data('file_name');
        }
    }

    if ($_FILES['faktur']['name']) {
        $this->upload->initialize($config);
        if ($this->upload->do_upload('faktur')) {
            $data['nama_file_faktur'] = $this->upload->data('file_name');
        }
    }

    if ($id) {
        $this->Upload_invoice_model->update($id, $data);
    } else {
        $this->Upload_invoice_model->insert($data);
        
    }
   
    redirect('page/upload_invoice_list');
}

public function update_pekerjaan($idSurveyLapanganPerjab) {
    $this->load->model("Survey_lapangan_perjab_model", "survey_lapangan_perjab");
    $loadData = $this->survey_lapangan_perjab->load_data(['where' => "id_survey_lapangan_perjab = $idSurveyLapanganPerjab"]);
    $result = $loadData->row();
    $notif = $this->notifikasi();
    $konten = array('title' => 'Update Pekerjaan Survey Lapangan', 'notif' => $notif, 'data' => $result);
    $this->load->view('survey_lapangan/update_pekerjaan', $this->data_halaman($konten));

}

public function upload_invoice_delete($id)
{
    $this->load->model('Upload_invoice_model');
    $this->Upload_invoice_model->delete($id);
    redirect('page/upload_invoice_list');
    
}



}