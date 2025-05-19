<?php
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/ExpiredException.php';
require_once APPPATH . '/libraries/SignatureInvalidException.php';

use \Firebase\JWT\JWT;

class MY_Controller extends CI_Controller
{
    protected $smtp_config;
    var $nama_developer = 'Bhaga ISD';
    var $url_developer = 'http://www.bhaga.id/';

    var $aplikasi = 'E-TDKN Sba';
    var $nama_instansi = '';
    var $nama_lengkap_perusahaan = '';
    var $cabang = '';
    var $alamat = '';
    var $alamat_pusat = '';
    var $npwp_perusahaan = '';
    var $metatag = '';
    var $deskripsi_web = '';
    var $no_photo = 'assets/images/no_image.jpg';
    var $no_avatar = 'assets/images/avatar.jpg';
    var $no_ttd = 'assets/images/no_ttd.jpg';
    var $kolom_label = 'col-sm-3';
    var $mata_uang = 'Rp';
    var $maxlength_id = 5;
    var $qty_data = 10;
    var $qty_data_mobile = 8;
    var $waiting_time = 1500; #1.5 second
    var $tinggi_ttd = '120px';

    //JSON web token..
    //don't change secretKey and tokenKey unless needed..
    private $jwt = array(
        'secretKey' => '6VH2FFRXDKFSODBBI',
        'staticKey' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9',
        'algorithm' => 'HS256'
    );

    //social media link..

    function __construct()
    {
        parent::__construct();
        // Load config env
        $this->config->load('env');
    }

    public function getToken($type_token = 'LOAD_DATA')
    {
        //persamaan: 1 menit = 600;
        if ($type_token == 'SEND_DATA')
            $expiredIn = 72000; //2 jam...
        else
            $expiredIn = 18000; // 30 menit...
        $date = new DateTime();
        $token['type']  = $type_token; //REQUEST_DATA & ENTRY_DATA..
        $token['time']  = $date->getTimestamp();
        $token['expd']  = $date->getTimestamp() + $expiredIn;
        $output = JWT::encode($token, $this->jwt['secretKey'], $this->jwt['algorithm']);

        $enkrip = explode('.', $output);
        $output = $enkrip[1] . '.' . $enkrip[2];
        return $output;
    }
    public function tokenStatus($token, $type_token)
    {
        try {
            $date = new DateTime();
            $decode = JWT::decode($this->jwt['staticKey'] . '.' . $token, $this->jwt['secretKey'], array($this->jwt['algorithm']));

            if ($type_token == $decode->type) {
                if ($date->getTimestamp() < $decode->expd)
                    return true;
                else
                    return false;
            } else
                return false;
        } catch (Exception $e) {
            $msg = $e->getMessage(); //this is the way to get error message from jwt.. but I use only false..
            return false;
        }
    }
    public function getTokenMobile($receiver_data, $type_token = 'LOAD_DATA', $login_status = false)
    {
        $date = new DateTime();
        $now = $date->getTimestamp();
        $expd_date = strtotime('+3 day', $now);
        $token['type']  = $type_token; //LOAD_DATA & SEND_DATA..
        $token['time']  = $now;
        $token['expd']  = $expd_date;
        $token['profile']  = $receiver_data;
        $token['login_status']  = $login_status; //(isset($receiver_data->login_status) ? $receiver_data->login_status : 'false');

        $output = JWT::encode($token, $this->jwt['secretKey'], $this->jwt['algorithm']);

        $enkrip = explode('.', $output);
        $output = $enkrip[1] . '.' . $enkrip[2];
        return $output;
    }
    public function tokenStatusMobile($token, $type_token, $check_user_data = true)
    {
        $return = array();
        try {
            $date = new DateTime();
            $decode = JWT::decode($this->jwt['staticKey'] . '.' . $token, $this->jwt['secretKey'], array($this->jwt['algorithm']));

            $status = false;
            if ($type_token == $decode->type) {
                if ($date->getTimestamp() < $decode->expd) {
                    if ($check_user_data == true) {
                        $return['sts'] = true;
                        $return['data'] = $decode;
                        $return['message'] = 'success_check';
                    } else {
                        $return['sts'] = true;
                        $return['data'] = '';
                        $return['message'] = 'success_check';
                    }
                } else {
                    $return['sts'] = false;
                    $return['data'] = '';
                    $return['message'] = 'kadaluarsa';
                }
            } else {
                $return['sts'] = false;
                $return['data'] = '';
                $return['message'] = 'tipe_token_salah';
            }
        } catch (Exception $e) {
            $msg = $e->getMessage(); //this is the way to get error message from jwt.. but I use only false..
            $return['sts'] = false;
            $return['data'] = '';
            $return['message'] = 'token_invalid';
        }

        return $return;
    }
    public function checkSessionAdmin($data)
    {
        $username = $data->profile->username_admin;
        $password = $data->profile->password_admin;

        $this->load->model('Mst_admin_model', 'admin');
        $result = $this->admin->checkAdmin($username, $password, 'mobile');
        if ($result)
            return true;
        else
            return false;
    }

    function data_halaman($konten = '')
    {
        $this->load->model('profil_perusahaan_model', 'profil_perusahaan');
        $where = array('active' => 1, 'id_profil_perusahaan' => '1');
        $data_send = array('where' => $where);
        $load_data = $this->profil_perusahaan->load_data($data_send);

        $profil_perusahaan = $load_data->row();

        $this->nama_instansi = $profil_perusahaan->nama_perusahaan;
        $this->nama_lengkap_perusahaan = $profil_perusahaan->nama_lengkap_perusahaan;
        $this->cabang = $profil_perusahaan->kantor_cabang;
        $this->alamat = $profil_perusahaan->alamat_kantor_cabang;
        $this->npwp_perusahaan = $profil_perusahaan->npwp_perusahaan;
        $this->alamat_pusat = $profil_perusahaan->alamat_pusat;

        $this->load->model('rekening_bank_model', 'rekening_bank');
        $where_rekening_bank = array('active' => 1);
        $data_send_rekening_bank = array('where' => $where_rekening_bank);
        $rekening_bank = $this->rekening_bank->load_data($data_send_rekening_bank);


        $data_halaman = array(
            "body_parameter"        => 'id="kt_app_body" data-kt-app-layout="light-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default"',
            "konten"                => $konten,
            "url_developer"         => $this->url_developer,
            "nama_developer"        => $this->nama_developer,
            "aplikasi"                 => $this->aplikasi,
            "title"                 => $this->aplikasi . ($this->nama_instansi ? ' - ' . $this->nama_instansi : ''),
            "nama_instansi"         => $this->nama_instansi,
            "nama_lengkap_perusahaan" => $this->nama_lengkap_perusahaan,
            "alamat_pusat"          => $this->alamat_pusat,
            "npwp_perusahaan"       => $this->npwp_perusahaan,
            "cabang"                => $this->cabang,
            "alamat"                => $this->alamat,
            "rekening_bank"         => $rekening_bank,
            "deskripsi_web"         => $this->deskripsi_web,
            "metatag"                 => $this->metatag,
            "kolom_label"             => $this->kolom_label,
            "maxlength_id"          => $this->maxlength_id,
            "waiting_time"          => $this->waiting_time,
            "qty_data"              => $this->qty_data,
            "no_photo"              => 'onerror="this.onerror=null;this.src=\'' . base_url() . $this->no_photo . '\';"',
            "no_photo_url"          => $this->no_photo,
            "no_photo_for_js"       => 'onerror="this.onerror=null;this.src=\\\'' . base_url() . $this->no_photo . '\\\';"',
            "no_avatar"             => 'onerror="this.onerror=null;this.src=\'' . base_url() . $this->no_avatar . '\';"',
            "no_avatar_for_js"      => 'onerror="this.onerror=null;this.src=\\\'' . base_url() . $this->no_avatar . '\\\';"',
            "no_avatar_url"         => $this->no_avatar,
            "today"                 => $day = $this->hari(date('w')) . ', ' . date('d') . ' ' . $this->bulan((int)date('m')) . ' ' . date('Y')
        );

        return $data_halaman;
    }
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function reformat_date($date, $option = array())
    {
        if ($date != '0000-00-00') {
            # Default => - | {bisa sembarang}
            $delimiter = (array_key_exists('delimiter', $option) ? $option['delimiter'] : '-');

            # Default => - | {bisa sembarang}
            $new_delimiter = (array_key_exists('new_delimiter', $option) ? $option['new_delimiter'] : $delimiter);

            #Default => angka | {angka, full, short}
            $month_type = (array_key_exists('month_type', $option) ? $option['month_type'] : 'angka');

            #Default => true | {true, false}
            $date_reverse = (array_key_exists('date_reverse', $option) ? $option['date_reverse'] : true);

            #Default => true | {true, false}
            $show_time = (array_key_exists('show_time', $option) ? $option['show_time'] : true);

            #Default => false | {true, false}
            $show_day = (array_key_exists('show_day', $option) ? $option['show_day'] : false);
            #Default => full | {full, short}
            $day_type = (array_key_exists('day_type', $option) ? $option['day_type'] : 'full');

            $waktu = '';
            $pecah = explode(' ', $date);
            if (array_key_exists("1", $pecah)) {
                $date = $pecah[0];

                $time = explode(":", $pecah[1]);
                $waktu = ' ' . $time[0] . ':' . $time[1];
                if (!$show_time)
                    $waktu = '';
            }
            $date_split = explode($delimiter, $date);

            $bulan = $date_split[1];
            if ($month_type == 'full') {
                $bulan = $this->bulan((int) $bulan);
            } else if ($month_type == 'short') {
                $bulan = substr($this->bulan((int) $bulan), 0, 3);
            }

            $hari = '';
            if ($show_day) {
                $hari = $this->hari((int) date('w', strtotime($date))) . ', ';
                if ($day_type == 'short') {
                    $hari = substr($hari, 0, 3) . ', ';
                }
            }

            if (!$date_reverse)
                $new_date = $hari . $date_split[0] . $new_delimiter . $bulan . $new_delimiter . $date_split[2] . $waktu;
            else
                $new_date = $hari . $date_split[2] . $new_delimiter . $bulan . $new_delimiter . $date_split[0] . $waktu;

            return $new_date;
        } else
            return '00-00-0000';
    }
    function lost()
    {
        //halaman tidak ditemukan...
        $this->load->view('errors/404', $this->data_halaman());
    }

    function setting_kartu()
    {
        $this->load->library('pdf'); // set default header data
        //$this->pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $sistem, $nama_instansi."\n".$alamat."\n".$telepon." | ".$email);// set header and footer fonts

        $this->pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->pdf->SetPrintHeader(false);
        $this->pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA)); // set default monospaced font
        $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); //set margins
        $this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $this->pdf->SetAutoPageBreak(true, 0);

        //set image scale factor
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // ———————————————————

    }
    function setting_portrait($with_header = true)
    {
        $this->load->library('Pdf'); // set default header data

        if ($with_header) {
            $this->pdf->SetHeaderData('header.jpg', 180, '', '', array(0, 0, 0), array(255, 255, 255));
            $this->pdf->SetHeaderMargin(0);
            $this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        } else {
            $this->pdf->SetMargins(10, 10, 10);
            $this->pdf->SetPrintHeader(false);
            $this->pdf->SetHeaderMargin(0);
        }

        $this->pdf->SetPrintFooter(false);
        $this->pdf->SetFont('helvetica', '', 10);
        $this->pdf->SetAutoPageBreak(TRUE, 40);
        $this->pdf->AddPage('P', 'A4', false, false);

        //set image scale factor
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // ———————————————————

    }
    function setting_landscape($no_header = false)
    {
        $this->load->library('pdf');
        if (!$no_header) {
            $this->pdf->SetHeaderData('logo.png', 20, $this->aplikasi, $this->nama_instansi . "\n" . $this->alamat . "\n" . $this->telepon);
            $this->pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        } else {
            $this->pdf->SetMargins(3, 3, 3);
            $this->pdf->SetPrintHeader(false);
            $this->pdf->SetHeaderMargin(0);
        }
        $this->pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA)); // set default monospaced font
        $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); //set margins
        $this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $this->pdf->SetPrintFooter(false);
        $this->pdf->SetFont('helvetica', '', 10);
        $this->pdf->AddPage('L', 'A4', false, false);

        //set image scale factor
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // ———————————————————

    }
    function header_table_tcpdf()
    {
        return "margin:5px; background-color:#024419; color:#FAF50A; font-weight:bold; text-align:center;";
    }
    function header_tcpdf($text = "")
    {
        return '    <div style="width:100%;text-align:right">
                        Surabaya, ' . date("d") . " " . $this->bulan((int)date("m")) . " " . date("Y") . " (" . date("H:i") . ')
                    </div>
                    <div style="width:100%;text-align:center">
                        <h2>' . $text . '</h2>
                    </div>';
    }
    function border_excel()
    {
        $styleArray = array(
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => '00000000',
                    ),
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => '00000000',
                    ),
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => '00000000',
                    ),
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => '00000000',
                    ),
                ),
            )
        );

        return $styleArray;
    }

    function hari($line)
    {
        $hari[0] = 'Minggu';
        $hari[1] = 'Senin';
        $hari[2] = 'Selasa';
        $hari[3] = 'Rabu';
        $hari[4] = 'Kamis';
        $hari[5] = 'Jumat';
        $hari[6] = 'Sabtu';

        return $hari[$line];
    }
    function bulan($i)
    {
        $bulan[1] = 'Januari';
        $bulan[2] = 'Februari';
        $bulan[3] = 'Maret';
        $bulan[4] = 'April';
        $bulan[5] = 'Mei';
        $bulan[6] = 'Juni';
        $bulan[7] = 'Juli';
        $bulan[8] = 'Agustus';
        $bulan[9] = 'September';
        $bulan[10] = 'Oktober';
        $bulan[11] = 'November';
        $bulan[12] = 'Desember';

        return $bulan[$i];
    }
    function alert_text($i)
    {
        $alert['simpan_berhasil']['sts'] = "Proses simpan data berhasil dilakukan.";
        $alert['simpan_berhasil']['type'] = "success";
        $alert['hapus_berhasil']['sts']  = "Proses hapus data berhasil dilakukan.";
        $alert['hapus_berhasil']['type'] = "success";
        $alert['reset_password_berhasil']['sts']  = "Proses reset sandi berhasil dilakukan.";
        $alert['reset_password_berhasil']['type'] = "success";
        $alert['ganti_pwd_berhasil']['sts']  = "Proses ganti sandi berhasil dilakukan.";
        $alert['ganti_pwd_berhasil']['type'] = "success";
        $alert['login_berhasil']['sts']  = "Login berhasil, silahkan tunggu sebentar.";
        $alert['login_berhasil']['type'] = "success";
        $alert['daftar_berhasil']['sts']  = "Daftar berhasil, silahkan tunggu sebentar.";
        $alert['daftar_berhasil']['type'] = "success";
        $alert['verifikasi_berhasil']['sts']  = "Proses verifikasi berhasil dilakukan.";
        $alert['verifikasi_berhasil']['type'] = "success";

        $alert['semua_wajib']['sts']  = "Semua field wajib dilengkapi.";
        $alert['semua_wajib']['type'] = "warning";
        $alert['kosong']['sts']  = "Field yang memiliki tanda bintang wajib dilengkapi.";
        $alert['kosong']['type'] = "warning";
        $alert['pilih_satu']['sts']  = "Anda harus memilih minimal satu data.";
        $alert['pilih_satu']['type'] = "warning";
        $alert['password_tidak_sama']['sts']  = "Sandi yang Anda masukan tidak sama dengan yang Anda ulangi.";
        $alert['password_tidak_sama']['type'] = "warning";
        $alert['password_salah']['sts']  = "Sandi lama yang Anda masukan salah.";
        $alert['password_salah']['type'] = "warning";
        $alert['perusahaan_available']['sts']  = "Nama perusahaan yang Anda masukan sudah terdaftar, silahkan gunakan nama perusahaan lain.";
        $alert['perusahaan_available']['type'] = "warning";
        $alert['data_available']['sts']  = "Data yang Anda masukkan sudah ada, silahkan gunakan data lain.";
        $alert['data_available']['type'] = "warning";
        $alert['email_salah']['sts']  = "Format email yang Anda masukkan salah.";
        $alert['email_salah']['type'] = "warning";
        $alert['email_available']['sts']  = "Email yang Anda masukan sudah terdaftar, silahkan gunakan email lain.";
        $alert['email_available']['type'] = "warning";
        $alert['email_not_verified']['sts']  = "Email Anda belum terverifikasi. Silahkan cek inbox email Anda untuk menemukan email verifikasi dari kami.";
        $alert['email_not_verified']['type'] = "warning";
        $alert['email_tidak_ada']['sts']  = "Email yang Anda masukan belum terdaftar.";
        $alert['email_tidak_ada']['type'] = "warning";
        $alert['username_available']['sts']  = "Username yang Anda masukan sudah terdaftar, silahkan gunakan username lain.";
        $alert['username_available']['type'] = "warning";
        $alert['not_valid']['sts']  = "Kombinasi username dan sandi tidak sesuai, silahkan ulangi lagi.";
        $alert['not_valid']['type'] = "warning";
        $alert['tgl_awal_lebih_besar']['sts']  = "Tanggal awal tidak boleh lebih besar dari tanggal akhir.";
        $alert['tgl_awal_lebih_besar']['type'] = "warning";
        $alert['format_waktu_salah']['sts']  = "Waktu yang Anda masukkan salah. Aplikasi hanya menerima format dd-mm-yyyy HH:MM. Contoh: 17-01-2017 17:58.";
        $alert['format_waktu_salah']['type'] = "warning";
        $alert['format_tgl_salah']['sts']  = "Tanggal yang Anda masukkan salah. Aplikasi hanya menerima format dd-mm-yyyy. Contoh: 17-01-2017.";
        $alert['format_tgl_salah']['type'] = "warning";
        $alert['format_jam_salah']['sts']  = "Jam yang Anda masukkan salah. Aplikasi hanya menerima format HH:MM. Contoh: 17:56.";
        $alert['format_jam_salah']['type'] = "warning";
        $alert['termin_harus_100']['sts']  = "Total persentase termin harus 100%. Tidak boleh lebih ataupun kurang.";
        $alert['termin_harus_100']['type'] = "warning";
        $alert['total_pembayaran_kurang']['sts']  = "Total pembayaran tidak sesuai. Silahkan atur kembali total pembayaran hingga setara dengan: ";
        $alert['total_pembayaran_kurang']['type'] = "warning";
        $alert['mencapai_batas_upload']['sts']  = "Anda tidak bisa mengupload file lagi karena sudah mencapai batas upload yang ditentukan. Jika ingin mengupload file baru, silakan hapus file lama terlebih dahulu.";
        $alert['mencapai_batas_upload']['type'] = "warning";
        $alert['mencapai_batas_simpan']['sts']  = "Anda tidak bisa menyimpan {{nama_textarea}} lagi. Jika ingin memperbarui {{nama_textarea}}, silakan hapus data yang lama terlebih dahulu.";
        $alert['mencapai_batas_simpan']['type'] = "warning";
        $alert['dokumen_belum_lengkap']['sts']  = "Proses tidak dapat dilanjutkan karena ada dokumen yang belum lengkap atau masih tertolak.";
        $alert['dokumen_belum_lengkap']['type'] = "warning";
        $alert['dokumen_belum_disetujui']['sts']  = "Proses tidak dapat dilanjutkan karena ada dokumen yang belum disetujui.";
        $alert['dokumen_belum_disetujui']['type'] = "warning";
        $alert['tidak_sesuai_format']['sts']  = "Format file yang diupload tidak sesuai dengan template yang disediakan.";
        $alert['tidak_sesuai_format']['type'] = "warning";
        $alert['sppd_sedang_dicek']['sts']  = "SPPD sedang dalam pengecekan. Silakan tunggu hingga proses verifikasi selesai.";
        $alert['sppd_sedang_dicek']['type'] = "warning";
        $alert['data_kembar']['sts']  = "Anda tidak bisa menyimpan item data yang kembar, silakan pilih item lainnya.";
        $alert['data_kembar']['type'] = "warning";
        $alert['pengambilan_dana_lebih_besar']['sts']  = "Pengambilan/penggunaan dana tidak boleh lebih besar dari sumbernya.";
        $alert['pengambilan_dana_lebih_besar']['type'] = "warning";
        $alert['file_tidak_ditemukan']['sts']  = "File yang Anda maksud tidak ditemukan.";
        $alert['file_tidak_ditemukan']['type'] = "warning";
        $alert['belum_verifikasi_semua']['sts']  = "Dokumen harus diverifikasi semuanya terlebih dahulu.";
        $alert['belum_verifikasi_semua']['type'] = "warning";
        $alert['belum_ada_etc']['sts']  = "Proses tidak dapat dilanjutkan karena Anda belum menugaskan ETC.";
        $alert['belum_ada_etc']['type'] = "warning";
        $alert['belum_ada_file']['sts']  = "Proses tidak dapat dilanjutkan karena ada dokumen yang belum lengkap.";
        $alert['belum_ada_file']['type'] = "warning";

        $alert['upload_error']['sts']  = "Upload error: {{upload_error_msg}}";
        $alert['upload_error']['type'] = "warning";


        $alert['proses_gagal']['sts']  = "Ada kesalahan dalam proses, silahkan ulangi sekali lagi.";
        $alert['proses_gagal']['type'] = "error";
        $alert['tidak_berhak_ubah_data']['sts']  = "Anda tidak berhak untuk mengubah data ini.";
        $alert['tidak_berhak_ubah_data']['type'] = "error";
        $alert['tidak_berhak_hapus_data']['sts']  = "Anda tidak berhak untuk menghapus data ini.";
        $alert['tidak_berhak_hapus_data']['type'] = "error";
        $alert['tidak_berhak_akses_data']['sts']  = "Anda tidak berhak untuk mengakses data ini.";
        $alert['tidak_berhak_akses_data']['type'] = "error";

        $alert['token_invalid']['sts']  = "Token invalid, silahkan buka ulang (refresh) halaman ini.";
        $alert['token_invalid']['type'] = "error";
        $alert['tipe_token_salah']['sts']  = "Tipe token Anda salah.";
        $alert['tipe_token_salah']['type'] = "error";
        $alert['kadaluarsa']['sts']  = "Token Anda kadaluarsa, silahkan login kembali.";
        $alert['kadaluarsa']['type'] = "error";

        $x['msg'] = (isset($alert[$i]['sts']) ? $alert[$i]['sts'] : null);
        $x['type'] = $alert[$i]['type'];
        return $x;
    }
    function alert($i)
    {
        $alert = $this->alert_text($i);
        $msg = $alert['msg'];

        $info = '';
        if ($alert['type'] == 'success')
            $info = 'Sukses!';
        else if ($alert['type'] == 'warning')
            $info = 'Perhatian!';
        else if ($alert['type'] == 'error')
            $info = 'Maaf!';

        return json_encode(array(
            'title' => $info,
            'message' => $msg,
            'type' => $alert['type']
        ));
    }

    function redirect($url)
    {
        echo "<script>
			location.href='$url';
		</script>";
    }

    public function cekHakAkses($menu, $with_ruang_kerja = true)
    {
        if ($with_ruang_kerja) {
            $ruang_kerja = ($this->session->userdata('ruang_kerja') ? ' and sub_module IN (\'ALL\', \'' . $this->session->userdata('ruang_kerja') . '\')' : '');
        } else {
            $ruang_kerja = '';
        }
        $this->load->model('Hak_akses_menu_model', 'hak_akses_menu');
        $where = array(
            "id_jns_admin = (SELECT a.id_jns_admin FROM mst_admin a WHERE a.id_admin = '" . $this->session->userdata('id_admin') . "')" => null,
            "id_menu = (SELECT b.id_menu FROM menu b WHERE b.url_menu = '" . $menu . "' and module = 'ADMIN' " . $ruang_kerja . ")" => null
        );
        return $this->hak_akses_menu->is_available($where);
    }

    public function validasi_controller($menu)
    {
        $return = $this->cekHakAkses($menu);
        if ($return === false) {
            $this->redirect(base_url() . 'gateway/keluar');
        } else {
            #cek apakah admin sudah memilih tempat kerja atau belum...
            $ruang_kerja = $this->session->userdata('ruang_kerja');
            if (!$ruang_kerja) {
                $return = false;
                $this->redirect(base_url('page/ruang_kerja'));
            }
        }
        return $return;
    }
    public function validasi_login()
    {
        if ($this->session->userdata('login_as') == 'administrator' and $this->session->userdata('id_admin') != '') {
            //validasi id user and password..
            $username_admin = $this->session->userdata('username_admin');
            $password_admin = $this->session->userdata('password_admin');

            $this->load->model('Mst_admin_model', 'admin');
            $join[0] = array('tabel' => 'credential', 'relation' => 'credential.id_pengguna = mst_admin.id_admin and tabel = \'mst_admin\' and credential.active = 1', 'direction' => 'left');
            $where = array('mst_admin.status_admin' => 'A', 'username_admin' => $username_admin, 'password' => $password_admin);
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->admin->load_data($data_send);
            if ($load_data->num_rows() > 0) {
                return true;
            } else {
                return false;
            }

            // $where = array('username_admin' => $username_admin, 'password_admin' => $password_admin);
            // return $this->admin->is_available($where);
        } else
            return false;
    }
    public function validasi_login_pelanggan()
    {
        if ($this->session->userdata('login_as') == 'pelanggan' and $this->session->userdata('id_pelanggan') != '') {
            //validasi id user and password..
            $email = $this->session->userdata('email');
            $password_perusahaan = $this->session->userdata('password_perusahaan');

            $this->load->model('pelanggan_model', 'pelanggan');
            $where = array('email' => $email, 'password_perusahaan' => $password_perusahaan);
            return $this->pelanggan->is_available($where);
        } else
            return false;
    }
    public function pelangganTerverifikasi()
    {
        $this->load->model("Pelanggan_model", "pelanggan");
        $id_pelanggan = $this->session->userdata('id_pelanggan');

        $where = array('active' => 1, 'id_pelanggan' => $id_pelanggan, 'status_verifikasi' => 1);
        $cek = $this->pelanggan->is_available($where);

        return $cek;
    }

    function nama_perusahaan($id_pelanggan = '')
    {
        if ($id_pelanggan == '')
            $id_pelanggan = $this->session->userdata('id_pelanggan');

        $nama_perusahaan = '';
        $this->load->model("pelanggan_model", "pelanggan");
        $join[0] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
        $where = array('pelanggan.active' => 1, 'id_pelanggan' => $id_pelanggan);
        $data_send = array('where' => $where, 'join' => $join);
        $load_data = $this->pelanggan->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            $pelanggan = $load_data->row();
            $nama_perusahaan = $pelanggan->nama_badan_usaha . ' ' . $pelanggan->nama_perusahaan;
        }
        return $nama_perusahaan;
    }
    public function convertToRupiah($angka)
    {
        $pecah = explode('.', $angka);
        $angka = $pecah[0];
        return strrev(implode('.', str_split(strrev(strval($angka)), 3))) . (isset($pecah[1]) ? ',' . $pecah[1] : '');
    }
    public function convertToAngka($rupiah)
    {
        $pecah = explode(',', $rupiah);
        return str_replace('.', '', coverMe($pecah[0])) . (isset($pecah[1]) ? '.' . $pecah[1] : '');
    }

    public function http_request_builder($data, $url)
    {

        $protocol = substr($url, 0, 5);
        if ($protocol == 'https') {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            // Edit: prior variable $postFields should be $postfields;
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
            $result = curl_exec($ch);
        } else {
            $postdata = http_build_query($data);
            $opts = array(
                'http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );

            $context = stream_context_create($opts);
            $result = file_get_contents($url, false, $context);
        }

        return $result;
    }

    public function get_browser()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
            return 'Internet explorer';
        elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
            return 'Internet explorer';
        elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
            return 'Mozilla Firefox';
        elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
            return 'Google Chrome';
        elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
            return "Opera Mini";
        elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
            return "Opera";
        elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
            return "Safari";
        else
            return 'Something else';
    }
    public function save_log_visit($data_received = array())
    {
        $actual_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $location = @file_get_contents('http://freegeoip.net/json/' . $_SERVER['REMOTE_ADDR']);
        if ($location === true) {
            $data_receive = json_decode($location);

            $data = array(
                'waktu_visit' => date('Y-m-d H:i:s'),
                'url_visit' => $actual_link,
                'browser_visitor' => $this->get_browser(),
                'ipAddress' => $data_receive->ip,
                'countryCode' => $data_receive->country_code,
                'countryName' => $data_receive->country_name,
                'regionName' => $data_receive->region_name,
                'cityName' => $data_receive->city,
                'latitude' => $data_receive->latitude,
                'longitude' => $data_receive->longitude,
                'time_zone' => $data_receive->time_zone,
                'user_id' => $this->session->userdata('user_id'),
            );
            $this->load->model('Log_visit_model', 'log_visit');
            $this->log_visit->save($data);
        }


        if (array_key_exists('table', $data_received) and array_key_exists('field_id', $data_received) and array_key_exists('id', $data_received)  and array_key_exists('field_view', $data_received)) {
            $this->all_data->count_viewer($data_received);
        }
    }
    public function maxlength($var, $length)
    {
        if (strlen($var) > $length)
            $var = substr($var, 0, $length);
        return $var;
    }

    function createDir($direktori)
    {
        // Pecah path ke dalam array
        $dirs = explode('/', $direktori);
        $path = '';

        // Looping array dan cek tiap direktori
        foreach ($dirs as $dir) {
            $path .= $dir . '/';

            if (!is_dir($path)) {
                // Jika direktori tidak ada, buat direktori
                mkdir($path, 0755, true);

                // Buat file index.html kosong
                $index = fopen($path . '/index.html', 'w');
                fclose($index);
            }
        }
    }
    function upload_v2($var = array())
    {
        /* Template varible $var adalah sebagai berikut...
        $var = array(
            'dir' => '', #string, nama folder akhiri dengan /
            'allowed_types' => '', #string => pdf|jpeg|jpg, kosongkan jika boleh upload semua file
            'file' => '', #string => name dari input type="file"
            'encrypt_name' => true|false, #boolean
            'new_name' => '', #string => isi jika ingin merename nama file sesuai kebutuhan. biarkan kosong jika tidak ingin rename.
        );
        ========================= */

        #cek dan buat folder jika tidak ada...
        $this->createDir($var['dir']);

        $return = array();
        $this->load->helper('file');

        $config['upload_path'] = $var['dir'];
        $config['allowed_types'] = (isset($var['allowed_types']) ? $var['allowed_types'] : '*'); // 'pdf|jpeg|jpg';
        $config['encrypt_name'] = (isset($var['encrypt_name']) ? $var['encrypt_name'] : TRUE);

        $this->load->library('upload', $config);
        if ($this->upload->do_upload($var['file'])) {
            $upload_data = $this->upload->data();

            if (isset($var['new_name'])) {
                $old_name = $upload_data['file_path'] . $upload_data['file_name'];
                $new_name = $upload_data['file_path'] . $var['new_name'] . $upload_data['file_ext'];
                rename($old_name, $new_name);

                $upload_data['file_name'] = $var['new_name'] . $upload_data['file_ext'];
            }

            # Atur izin file agar dapat dibaca
            if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
                $file_path = $var['dir'] . $upload_data['file_name'];
                if (file_exists($file_path)) {
                    chmod($file_path, 0644);
                }
            }

            $return['sts'] = true;
            $return['msg'] = '';
            $return['file'] = $upload_data['file_name'];
        } else {
            $return['sts'] = false;
            $return['msg'] = $this->upload->display_errors('', '');
        }

        return $return;
    }

    function upload($variable = array())
    {
        $return = array();
        $this->load->helper('file');

        #cek dan buat folder jika tidak ada...
        $this->createDir($variable['dir']);

        $new_name = $variable['new_name'];
        $file = $variable['file'];
        $dir = $variable['dir'];
        if (isset($variable['overwrite']))
            $overwrite = $variable['overwrite'];
        else
            $overwrite = false;
        if (isset($variable['manimpulation']))
            $manimpulation = $variable['manimpulation'];
        else
            $manimpulation = false;

        if (isset($_FILES[$file])) {
            $sts_watermark = true;
            $nama = $_FILES[$file]['name'];
            $manual_mime = get_mime_by_extension($nama);

            if (isset($variable['manual_tipe_file'])) {
                #bagian ini untuk spesifik menentukan manual tipe..
                #tidak ikut yang global $this->manual_tipe_file
                $manual_tipe_explode = explode(',', $variable['manual_tipe_file']);
                $way_through = false;
                for ($i = 0; $i < count($manual_tipe_explode); $i++) {
                    if ($manual_tipe_explode[$i] == $manual_mime) {
                        $way_through = true;
                    }
                }
            } else {
                if (isset($this->manual_tipe_file)) {
                    $manual_tipe_explode = explode(',', $this->manual_tipe_file);
                    $way_through = false;
                    for ($i = 0; $i < count($manual_tipe_explode); $i++) {
                        if ($manual_tipe_explode[$i] == $manual_mime) {
                            $way_through = true;
                        }
                    }
                } else
                    $way_through = true;
            }

            if ($way_through) {
                if (!isset($this->manual_tipe_file))
                    $config['allowed_types'] = $this->tipe_file;
                else
                    $config['allowed_types'] = '*';

                $config['upload_path'] = $dir;
                $config['overwrite'] = $overwrite;
                $config['file_name'] = $new_name . '.' . pathinfo($nama, PATHINFO_EXTENSION);

                $this->load->library('upload', $config);
                if ($this->upload->do_upload($file)) {
                    $image_data = $this->upload->data();

                    if ($manimpulation) {
                        ini_set('memory_limit', '-1');
                        //proses manipulasi gambar asli..
                        $img_proses['new_image']    = $dir . "/" . $image_data['file_name'];
                        $img_proses['width']        = 1000;
                        $img_proses['source_image'] = $dir . "/" . $image_data['file_name'];
                        $img_proses['quality']      = 70; //compress the image..

                        $this->load->library('image_lib', $img_proses);
                        $this->image_lib->initialize($img_proses);
                        $this->image_lib->resize();
                        $this->image_lib->watermark();
                    }

                    $return['sts'] = 'sukses';
                    $return['msg'] = '';
                    $return['file'] = $image_data['file_name'];
                } else {
                    $return['sts'] = 'denied';
                    $return['msg'] = $this->upload->display_errors('', '');
                }
            } else {
                $return['sts'] = 'denied';
                $return['msg'] = 'Tipe file yang anda upload tidak sesuai.';
            }
        } else {
            $return['sts'] = 'form_empty';
            $return['msg'] = '';
        }

        return $return;
    }

    function base64_to_file($base64_string, $output_file, $filename)
    {
        $data = explode(',', $base64_string);
        $img = $data[1];
        $data = base64_decode($img);
        $file = $output_file . $filename;
        $success = file_put_contents($file, $data);

        return $success ? $file : '';
    }

    function send_bunker($mail)
    {
        $this->load->model("Bunker_email_model", 'bunker_email');
        $exe = $this->bunker_email->save($mail, 'x', 'x');
        if ($exe) {
            $this->send_email($mail);
        }

        return $exe;
    }

    function send_email($data)
    {
        $this->load->library('email_lib');

        $config = array(
            'protocol'      => 'smtp',
            'smtp_host'     => $this->config->item('smtp_host') ?? '',
            'smtp_port'     => $this->config->item('smtp_port') ?? '',
            'SMTPSecure'    => $this->config->item('smtp_secure') ?? '',
            'smtp_user'     => $this->config->item('smtp_username') ?? '',
            'smtp_pass'     => $this->config->item('smtp_password') ?? '',
            'mailtype'      =>  'html',
            'charset'       =>  'iso-8859-1',
            'crlf'          => "\r\n",
            'newline'       => "\r\n"
        );

        $this->email_lib->initialize($config);

        $this->email_lib->from('no-reply@tkdn-scisba.web.id', $this->aplikasi);
        $this->email_lib->to($data['penerima_email']);

        $this->email_lib->subject($data['judul_email']);
        $this->email_lib->message($data['pesan_email']);

        if (array_key_exists('attach', $data)) {
            if ($data['attach'])
                $this->email_lib->attach($data['attach']);
        }

        return $this->email_lib->send();
    }
    public function penyebut($nilai)
    {
        $nilai = (int) $nilai;
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " milyar" . $this->penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }
    public function convertAngkaToTeks($nilai)
    {
        return trim($this->penyebut($nilai));
        // return '[DEBUG PENYEBUT] '.$nilai;
    }
    public function simpan_log_verifikasi($id_dokumen_permohonan, $status_verifikasi, $alasan_verifikasi = '')
    {
        $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
        $this->load->model("log_verifikasi_model", "log_verifikasi");
        $id_admin = $this->session->userdata('id_admin');

        $user_create = ($id_admin ? $id_admin : $this->session->userdata('id_pelanggan'));
        $time_create = date('Y-m-d H:i:s');
        $time_update = date('Y-m-d H:i:s');
        $user_update = ($id_admin ? $id_admin : $this->session->userdata('id_pelanggan'));


        $update_permohonan = array(
            'status_pengajuan' => $status_verifikasi,
            'alasan_verifikasi' => $alasan_verifikasi,
            'time_update' => $time_update,
            'user_update' => $user_update
        );
        $where_permohonan = array('id_dokumen_permohonan' => $id_dokumen_permohonan);
        $this->dokumen_permohonan->update($update_permohonan, $where_permohonan, $user_update, ($id_admin ? 'mst_admin' : 'pelanggan'));

        $data = array(
            'id_dokumen_permohonan' => $id_dokumen_permohonan,
            'tgl_verifikasi' => date('Y-m-d H:i:s'),
            'status_verifikasi' => $status_verifikasi,
            'alasan_verifikasi' => $alasan_verifikasi,
            'id_verifikator' => ($id_admin ? $id_admin : null),
            'active' => 1,
            'user_create' => $user_create,
            'time_create' => $time_create,
            'time_update' => $time_update,
            'user_update' => $user_update
        );
        $exe = $this->log_verifikasi->save($data, $user_create, ($id_admin ? 'mst_admin' : 'pelanggan'));

        return $exe;
    }
    public function simpan_log_status_verifikasi_tkdn($id_opening_meeting, $status_verifikasi, $alasan_verifikasi = '')
    {
        $this->load->model('opening_meeting_model', 'opening_meeting');
        $this->load->model('log_status_verifikasi_tkdn_model', 'log_status_verifikasi_tkdn');
        $id_admin = $this->session->userdata('id_admin');

        $user_create = ($id_admin ? $id_admin : $this->session->userdata('id_pelanggan'));
        $time_create = date('Y-m-d H:i:s');
        $time_update = date('Y-m-d H:i:s');
        $user_update = ($id_admin ? $id_admin : $this->session->userdata('id_pelanggan'));

        $update = array(
            'id_status' => $status_verifikasi,
            'alasan_status' => $alasan_verifikasi,
            'time_update' => $time_update,
            'user_update' => $user_update
        );
        $where = array('id_opening_meeting' => $id_opening_meeting);
        $this->opening_meeting->update($update, $where, $user_update, ($id_admin ? 'mst_admin' : 'pelanggan'));

        $data = array(
            'id_opening_meeting' => $id_opening_meeting,
            'tgl_log_status' => date('Y-m-d H:i:s'),
            'id_status' => $status_verifikasi,
            'alasan_status' => $alasan_verifikasi,
            'id_verifikator' => ($id_admin ? $id_admin : null),
            'active' => 1,
            'user_create' => $user_create,
            'time_create' => $time_create,
            'time_update' => $time_update,
            'user_update' => $user_update
        );
        $exe = $this->log_status_verifikasi_tkdn->save($data, $user_create, ($id_admin ? 'mst_admin' : 'pelanggan'));

        return $exe;
    }

    public function simpan_log_closing_meeting($id_closing_meeting, $status_verifikasi, $alasan_verifikasi = '')
    {
        $this->load->model('closing_meeting_model', 'closing_meeting');
        $this->load->model('log_status_closing_meeting_model', 'log_status_closing_meeting');
        $id_admin = $this->session->userdata('id_admin');

        $user_create = ($id_admin ? $id_admin : $this->session->userdata('id_pelanggan'));
        $time_create = date('Y-m-d H:i:s');
        $time_update = date('Y-m-d H:i:s');
        $user_update = ($id_admin ? $id_admin : $this->session->userdata('id_pelanggan'));

        $update = array(
            'status' => $status_verifikasi,
            'alasan_status' => $alasan_verifikasi,
            'time_update' => $time_update,
            'user_update' => $user_update
        );
        $where = array('id_closing_meeting' => $id_closing_meeting);
        $this->closing_meeting->update($update, $where, $user_update, ($id_admin ? 'mst_admin' : 'pelanggan'));

        $data = array(
            'id_closing_meeting' => $id_closing_meeting,
            'tgl_log_status' => date('Y-m-d H:i:s'),
            'id_status' => $status_verifikasi,
            'alasan_status' => $alasan_verifikasi,
            'id_verifikator' => ($id_admin ? $id_admin : null),
            'active' => 1,
            'user_create' => $user_create,
            'time_create' => $time_create,
            'time_update' => $time_update,
            'user_update' => $user_update
        );
        $exe = $this->log_status_closing_meeting->save($data, $user_create, ($id_admin ? 'mst_admin' : 'pelanggan'));

        return $exe;
    }
    function is_assesor()
    {
        if ($this->session->userdata('id_jns_admin') == 3) {
            return true;
        } else {
            return false;
        }
    }
    function siapaAssesor($id_dokumen_permohonan)
    {
        $this->load->model('dokumen_permohonan_pic_model', 'pic_assesor');
        $select_pic = "mst_admin.id_admin, nama_admin";
        $join_pic[0] = array('tabel' => 'mst_admin', 'relation' => 'mst_admin.id_admin = dokumen_permohonan_pic.id_admin', 'direction' => 'left');
        $order_pic = "id_pic DESC";
        $where_pic = array('dokumen_permohonan_pic.active' => 1, 'id_dokumen_permohonan' => $id_dokumen_permohonan, 'id_jns_admin' => 3);
        $data_send_pic = array('select' => $select_pic, 'where' => $where_pic, 'join' => $join_pic, 'order' => $order_pic);
        $load_data_pic = $this->pic_assesor->load_data($data_send_pic);
        if ($load_data_pic->num_rows() > 0) {
            return $load_data_pic->row();
        } else {
            return null;
        }
    }
    function AsistenAssesor($id_opening_meeting)
    {
        $this->load->model('opening_meeting_asisten_assesor_model', 'opening_meeting_asisten_assesor');
        $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = opening_meeting_asisten_assesor.id_opening_meeting', 'direction' => 'left');
        $join[1] = array('tabel' => 'mst_admin', 'relation' => 'mst_admin.id_admin = opening_meeting_asisten_assesor.id_admin', 'direction' => 'left');
        $where = array('opening_meeting_asisten_assesor.active' => 1, 'opening_meeting_asisten_assesor.id_opening_meeting' => $id_opening_meeting);
        $data_send = array('where' => $where, 'join' => $join);
        $load_data = $this->opening_meeting_asisten_assesor->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            return $load_data->result();
        } else {
            return null;
        }
    }
    function AssesorLapangan($id_opening_meeting)
    {
        $this->load->model('survey_lapangan_assesor_model', 'survey_lapangan_assesor');
        $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = survey_lapangan_assesor.id_opening_meeting', 'direction' => 'left');
        $join[1] = array('tabel' => 'mst_admin', 'relation' => 'mst_admin.id_admin = survey_lapangan_assesor.id_admin', 'direction' => 'left');
        $where = array('survey_lapangan_assesor.active' => 1, 'survey_lapangan_assesor.id_opening_meeting' => $id_opening_meeting);
        $data_send = array('where' => $where, 'join' => $join);
        $load_data = $this->survey_lapangan_assesor->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            return $load_data->result();
        } else {
            return null;
        }
    }

    function OrangEtc($id_opening_meeting)
    {
        $this->load->model('opening_meeting_etc_model', 'opening_meeting_etc');
        $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = opening_meeting_etc.id_opening_meeting', 'direction' => 'left');
        $join[1] = array('tabel' => 'mst_admin', 'relation' => 'mst_admin.id_admin = opening_meeting_etc.id_admin', 'direction' => 'left');
        $where = array('opening_meeting_etc.active' => 1, 'opening_meeting_etc.id_opening_meeting' => $id_opening_meeting);
        $data_send = array('where' => $where, 'join' => $join);
        $load_data = $this->opening_meeting_etc->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            return $load_data->result();
        } else {
            return null;
        }
    }

    function jmlETC($id_opening_meeting)
    {
        $this->load->model('opening_meeting_etc_model', 'opening_meeting_etc');

        $where = array('active' => 1, 'id_opening_meeting' => $id_opening_meeting);
        $jml = $this->opening_meeting_etc->select_count($where);

        return $jml;
    }
    function suratTugasOpeningMeeting($id_opening_meeting)
    {
        $this->load->model('surat_tugas_model', 'surat_tugas');
        $where = array('surat_tugas.active' => 1, 'tipe_surat_tugas' => 'opening_meeting', 'id_opening_meeting' => $id_opening_meeting);
        $data_send = array('where' => $where);
        $load_data = $this->surat_tugas->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            return $load_data->row();
        } else {
            return null;
        }
    }
    function suratTugasLapangan($id_opening_meeting)
    {
        $this->load->model('surat_tugas_model', 'surat_tugas');
        $where = array('surat_tugas.active' => 1, 'tipe_surat_tugas' => 'survey_lapangan', 'id_opening_meeting' => $id_opening_meeting);
        $data_send = array('where' => $where);
        $load_data = $this->surat_tugas->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            return $load_data->result();
        } else {
            return null;
        }
    }
    function getSPPD($id_opening_meeting)
    {
        $this->load->model('sppd_model', 'sppd');
        $this->load->model('sppd_project_model', 'sppd_project');
        $where = array('sppd.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
        $data_send = array('where' => $where);
        $load_data = $this->sppd->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            foreach ($load_data->result() as $row) {
                $row->status_sppd = null;
                if ($row->jns_sppd == 'PTT Project') {
                    $where_project = array('sppd_project.active' => 1, 'id_sppd' => $row->id_sppd);
                    $data_send_project = array('where' => $where_project);
                    $load_data_project = $this->sppd_project->load_data($data_send_project);
                    if ($load_data_project->num_rows() > 0) {
                        $project = $load_data_project->row();
                    }
                }
            }
            return $load_data->result();
        } else {
            return null;
        }
    }
    function getRAB($id_opening_meeting)
    {
        $this->load->model('sppd_item_rab_model', 'sppd_item_rab');
        $select_item_rab = "sum(total_biaya) grand_total";
        $where_item_rab = array('sppd_item_rab.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
        $join_item_rab[0] = array('tabel' => 'rab_detail', 'relation' => 'rab_detail.id_rab_detail = sppd_item_rab.id_rab_detail', 'direction' => 'left');
        $data_send_item_rab = array('where' => $where_item_rab, 'join' => $join_item_rab, 'select' => $select_item_rab);
        $load_data_item_rab = $this->sppd_item_rab->load_data($data_send_item_rab);
        $total_item_rab = $load_data_item_rab->row()->grand_total;
        return $total_item_rab;
    }
    function getRealisasiAnggaran($id_opening_meeting)
    {
        $this->load->model('sppd_model', 'sppd');
        $select_sppd = "sum(total_sppd) grand_total";
        $where_sppd = array('sppd.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
        $data_send_sppd = array('where' => $where_sppd, 'select' => $select_sppd);
        $load_data_sppd = $this->sppd->load_data($data_send_sppd);
        $total_rab_dipakai = $load_data_sppd->row()->grand_total;
        return $total_rab_dipakai;
    }
    function getSubsidiSilang($id_opening_meeting)
    {
        $this->load->model('rab_model', 'rab');
        $join[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');
        $join[1] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
        $join[2] = array('tabel' => 'rab_detail', 'relation' => 'rab_detail.id_rab = rab.id_rab', 'direction' => 'left');
        $where = array('rab.active' => 1, 'id_rab_detail IN (select id_rab_detail from sppd_item_rab where active = 1 and id_opening_meeting = \'' . $id_opening_meeting . '\' and jns_item = \'SUBSIDI SILANG\')' => null);
        $group = "rab.id_rab";
        $data_send = array('where' => $where, 'join' => $join, 'group' => $group);
        $load_data = $this->rab->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            return $load_data->result();
        } else {
            return null;
        }
    }
    function getSurveyLapanganDokumen($id_opening_meeting, $status)
    {
        $this->load->model('survey_lapangan_perjab_model', 'survey_lapangan_perjab');
        $where = array('survey_lapangan_perjab.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'status_verifikasi' => $status);
        $data_send = array('where' => $where);
        $load_data = $this->survey_lapangan_perjab->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            return array('jml' => $load_data->num_rows(), 'data' => $load_data->result());
        } else {
            return array('jml' => 0, 'data' => null);
        }
    }
    function getCollectingDokumen2($id_opening_meeting)
    {
        $this->load->model('collecting_dokumen_tahap2_model', 'collecting_dokumen_tahap2');
        $where = array('collecting_dokumen_tahap2.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
        $data_send = array('where' => $where);
        $load_data = $this->collecting_dokumen_tahap2->load_data($data_send);
        return $load_data->result();
    }
    function getPanelInternal($id_opening_meeting)
    {
        $this->load->model('panel_internal_dokumen_model', 'panel_internal_dokumen');
        $this->load->model('panel_internal_lhv_model', 'panel_internal_lhv');
        $this->load->model('panel_internal_nama_file_model', 'panel_internal_nama_file');
        $this->load->model('opening_meeting_model', 'opening_meeting');

        $id_status = '';
        $where_opening_meeting = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
        $data_send_opening_meeting = array('where' => $where_opening_meeting);
        $load_data_opening_meeting = $this->opening_meeting->load_data($data_send_opening_meeting);
        if ($load_data_opening_meeting->num_rows() > 0) {
            $opening_meeting = $load_data_opening_meeting->row();

            $id_status = $opening_meeting->id_status;
        }
        $panel_internal = [];

        #jika status masih dibawah 25, tampilkan semua folder kecuali folder pelanggan...
        #hal ini diperlukan agar dokumen yang belum sah tidak muncul pada data...
        $where = "panel_internal_nama_file.active = 1";
        if ($id_status < 25) {
            $where .= " and aktor != 'pelanggan'";
        }

        $order = "urutan asc";
        $data_send = array('where' => $where, 'order' => $order);
        $load_data = $this->panel_internal_nama_file->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            foreach ($load_data->result() as $row) {
                if ($row->nama_file == 'LHV') {
                    $where_files = array('panel_internal_lhv.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
                    $data_send_files = array('where' => $where_files);
                    $load_data_files = $this->panel_internal_lhv->load_data($data_send_files);
                } else {
                    $where_files = array('panel_internal_dokumen.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_nama_file' => $row->id_nama_file);
                    $data_send_files = array('where' => $where_files);
                    $load_data_files = $this->panel_internal_dokumen->load_data($data_send_files);
                }

                $nama_folder = $row->nama_file;
                if ($row->aktor == 'pelanggan') {
                    $nama_folder .= ' (' . $row->aktor . ')';
                }
                $panel_internal[] = array('nama_folder' => $nama_folder, 'files' => $load_data_files->result());
            }
        }

        return $panel_internal;
    }

    public function getPanelKemenperin($id_opening_meeting)
    {
        $this->load->model('panel_kemenperin_dokumen_model', 'panel_kemenperin_dokumen');
        $where = array('panel_kemenperin_dokumen.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
        $data_send = array('where' => $where);
        $load_data = $this->panel_kemenperin_dokumen->load_data($data_send);
        return $load_data->result();
    }

    public function getClosingMeeting($id_opening_meeting)
    {
        $this->load->model('closing_meeting_nama_file_model', 'closing_meeting_nama_file');
        $order = "urutan ASC";

        #get file dari verifikator...
        $where_verifikator = array('closing_meeting_nama_file.active' => 1, 'aktor' => 'assesor');
        $data_send_verifikator = array('where' => $where_verifikator, 'order' => $order);
        $load_data_verifikator = $this->closing_meeting_nama_file->load_data($data_send_verifikator);
        if ($load_data_verifikator->num_rows() > 0) {
            foreach ($load_data_verifikator->result() as $row) {
                $row->dokumen = $this->getClosingMeetingDokumen($id_opening_meeting, $row->id_closing_meeting_nama_file);
            }
        }

        #get file dari pelanggan...
        $where_pelanggan = array('closing_meeting_nama_file.active' => 1, 'aktor' => 'pelanggan');
        $data_send_pelanggan = array('where' => $where_pelanggan, 'order' => $order);
        $load_data_pelanggan = $this->closing_meeting_nama_file->load_data($data_send_pelanggan);
        if ($load_data_pelanggan->num_rows() > 0) {
            foreach ($load_data_pelanggan->result() as $row) {
                $row->dokumen = $this->getClosingMeetingDokumen($id_opening_meeting, $row->id_closing_meeting_nama_file);
            }
        }

        return array(
            'verifikator' => $load_data_verifikator->result(),
            'pelanggan' => $load_data_pelanggan->result(),
        );
    }

    public function getClosingMeetingDokumen($id_opening_meeting, $id_closing_meeting_nama_file)
    {
        $this->load->model('closing_meeting_dokumen_model', 'closing_meeting_dokumen');

        $join_dokumen[0] = array('tabel' => 'closing_meeting', 'relation' => 'closing_meeting.id_closing_meeting = closing_meeting_dokumen.id_closing_meeting', 'direction' => 'left');
        $where_dokumen = array('closing_meeting_dokumen.active' => 1, 'id_opening_meeting' => $id_opening_meeting, 'id_closing_meeting_nama_file' => $id_closing_meeting_nama_file);
        $data_send_dokumen = array('where' => $where_dokumen, 'join' => $join_dokumen);
        $load_data_dokumen = $this->closing_meeting_dokumen->load_data($data_send_dokumen);
        return $load_data_dokumen->result();
    }

    function titik_titik($jml_titik = 1)
    {
        $titik = '';
        for ($i = 0; $i < $jml_titik; $i++) {
            $titik .= '.';
        }

        return $titik;
    }


    public function load_file_collecting_dokumen($id_opening_meeting, $from = '')
    {
        $this->load->model('opening_meeting_model', 'opening_meeting');
        $this->load->model('collecting_dokumen_nama_file_model', 'nama_file');
        $this->load->model('kriteria_bpm_model', 'kriteria_bpm');
        $this->load->model('collecting_dokumen_model', 'collecting_dokumen');
        $id_opening_meeting = htmlentities($id_opening_meeting ?? '');

        $komplit = true;

        $result = null;
        $join_opening_meeting[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
        $where_opening_meeting = array(
            'opening_meeting.active' => 1,
            'id_opening_meeting' => $id_opening_meeting,
            'id_status >= 7' => null
        );

        $data_send_opening_meeting = array('where' => $where_opening_meeting, 'join' => $join_opening_meeting);
        $load_data_opening_meeting = $this->opening_meeting->load_data($data_send_opening_meeting);
        if ($load_data_opening_meeting->num_rows() > 0) {
            $opening_meeting = $load_data_opening_meeting->row();

            #mencari list file yang ingin diupload...
            $where_nama_file = "collecting_dokumen_nama_file.active = 1 
                and (id_tipe_permohonan = '" . $opening_meeting->id_tipe_permohonan . "' or id_tipe_permohonan IS NULL)";

            #mencari kriteria BPM...
            if ($opening_meeting->kriteria_bpm) {
                $kriteria_bpm = explode(',', $opening_meeting->kriteria_bpm);
                $rangkai = '';
                for ($i = 0; $i < count($kriteria_bpm); $i++) {
                    $where_bpm = array('kriteria_bpm.active' => 1, 'judul_kriteria' => ltrim($kriteria_bpm[$i]));
                    $data_send_bpm = array('where' => $where_bpm);
                    $load_data_bpm = $this->kriteria_bpm->load_data($data_send_bpm);
                    if ($load_data_bpm->num_rows() > 0) {
                        $bpm = $load_data_bpm->row();
                        $rangkai .= '\'' . $bpm->id_kriteria_bpm . '\',';
                    }
                }

                $rangkai = rtrim($rangkai, ',');
                $where_nama_file .= " and id_kriteria_bpm IN (" . $rangkai . ")";
                $order_nama_file = "id_kriteria_bpm, urutan ASC";
            } else {
                $order_nama_file = "urutan ASC";
            }

            $data_send_nama_file = array('where' => $where_nama_file, 'order' => $order_nama_file);
            $load_data_nama_file = $this->nama_file->load_data($data_send_nama_file);
            if ($load_data_nama_file->num_rows() > 0) {
                foreach ($load_data_nama_file->result() as $row) {
                    $row->dokumen_status = array();
                    $row->kriteria_bmp = null;
                    if ($row->id_kriteria_bpm) {
                        $where_kriteria_bmp = array('kriteria_bpm.active' => 1, 'id_kriteria_bpm' => $row->id_kriteria_bpm);
                        $data_send_kriteria_bmp = array('where' => $where_kriteria_bmp);
                        $load_data_kriteria_bmp = $this->kriteria_bpm->load_data($data_send_kriteria_bmp);

                        $row->kriteria_bmp = $load_data_kriteria_bmp->row();
                    }

                    #mencari list file dari folder ini...
                    $where_file = array('collecting_dokumen.active' => 1, 'id_opening_meeting' => $opening_meeting->id_opening_meeting, 'collecting_dokumen.id_nama_file' => $row->id_nama_file);
                    $data_send_file = array('where' => $where_file);
                    $load_data_file = $this->collecting_dokumen->load_data($data_send_file);
                    $row->files = array();

                    #jika file dalam folder ada...
                    if ($load_data_file->num_rows() > 0) {
                        $jml_tolak = 0;
                        $jml_setuju = 0;
                        foreach ($load_data_file->result() as $file) {
                            $file->jns_file = $row->jns_file;
                            $file->referensi = $row->referensi;

                            if ($file->status_verifikasi == 1) {
                                $jml_setuju++;
                            } else if ($file->status_verifikasi == 2) {
                                $jml_tolak++;
                            }
                        }

                        if ($jml_tolak > 0) {
                            $row->dokumen_status = array('Dokumen Ditolak', 'danger');
                            $komplit = false;
                        } else if ($jml_setuju == $load_data_file->num_rows()) {
                            $row->dokumen_status = array('Dokumen Disetujui', 'success');
                        } else {
                            $row->dokumen_status = array('Menunggu Verifikasi', 'info');
                            $komplit = false;
                        }

                        $row->files = $load_data_file->result();
                    } else {
                        #jika file dalam folder kosong, cek apakah folder memiliki status required atau tidak...
                        if ($row->required == 1) {
                            #jika statusnya required, maka ubah komplit menjadi false
                            $komplit = false;
                        }
                    }
                }
            } else {
                $komplit = false;
            }

            $result = $load_data_nama_file->result();
        } else {
            $komplit = false;
        }

        return array('komplit' => $komplit, 'result' => $result);
    }

    function getDetailRAB($row)
    {
        $this->load->model('rab_detail_model', 'rab_detail');
        $this->load->model('survey_lapangan_subsidi_silang_model', 'subsidi_silang');
        $detail_rab = array();
        $anggaran = array();

        $where_rab_detail = array('rab_detail.active' => 1, 'id_rab' => $row->id_rab);
        $data_send_rab_detail = array('where' => $where_rab_detail);
        $load_data_rab_detail = $this->rab_detail->load_data($data_send_rab_detail);
        if ($load_data_rab_detail->num_rows() > 0) {
            $flag_iwo = false;
            foreach ($load_data_rab_detail->result() as $item_rab) {

                if ($flag_iwo) {
                    $flag_iwo = false;
                    $detail_rab['IWO PUSAT'] = $item_rab->total_biaya;
                }
                if ($item_rab->uraian_kegiatan == 'IWO PUSAT') {
                    $flag_iwo = true;
                }
                $detail_rab[$item_rab->uraian_kegiatan] = $item_rab->total_biaya;
            }

            #mencari nilai kontrak...
            $detail_rab['NILAI KONTRAK'] = $row->nilai_kontrak;

            #mencari tambahan dana dari subsidi silang....
            $select_subsidi_silang = "SUM(nominal_subsidi) tambahan_subsidi_silang";
            $where_subsidi_silang = array('survey_lapangan_subsidi_silang.active' => 1, 'id_rab_tujuan' => $row->id_rab);
            $data_send_subsidi_silang = array('where' => $where_subsidi_silang, 'select' => $select_subsidi_silang);
            $load_data_subsidi_silang = $this->subsidi_silang->load_data($data_send_subsidi_silang);
            $anggaran['tambahan_subsidi_silang'] = $load_data_subsidi_silang->row()->tambahan_subsidi_silang;

            #mencari nilai RAB...
            $anggaran['nilai_rab'] = sprintf("%.2f", $row->nilai_kontrak - $detail_rab['VERIFIKASI DOKUMEN'] -  $detail_rab['FACTORY OVERHEAD'] - $detail_rab['IWO PUSAT']);
            $anggaran['anggaran_operasional'] = sprintf("%.2f", $anggaran['nilai_rab'] + $row->profit_operasional + $anggaran['tambahan_subsidi_silang']);

            #mencari realisasi SPPD...
            $select_sppd = 'sum(total_sppd) realisasi';
            $where_sppd = array('sppd.active' => 1, 'id_opening_meeting' => $row->id_opening_meeting);
            $data_send_sppd = array('where' => $where_sppd, 'select' => $select_sppd);
            $load_data_sppd = $this->sppd->load_data($data_send_sppd);
            $anggaran['total_sppd'] = $load_data_sppd->row()->realisasi;

            #mencari biaya operasional dari perjab...
            $select_perjab = "sum(biaya_operasional) total_biaya_operasional";
            $where_perjab = array('survey_lapangan_perjab.active' => 1, 'id_opening_meeting' => $row->id_opening_meeting, 'status_verifikasi' => 1);
            $data_send_perjab = array('where' => $where_perjab, 'select' => $select_perjab);
            $load_data_perjab = $this->survey_lapangan_perjab->load_data($data_send_perjab);
            $anggaran['biaya_operasional'] = $load_data_perjab->row()->total_biaya_operasional;

            #mencari dana yang diambil untuk subsidi silang...
            $select_subsidi_silang = "SUM(nominal_subsidi) pengurangan_subsidi_silang";
            $where_subsidi_silang = array('survey_lapangan_subsidi_silang.active' => 1, 'id_rab_sumber' => $row->id_rab);
            $data_send_subsidi_silang = array('where' => $where_subsidi_silang, 'select' => $select_subsidi_silang);
            $load_data_subsidi_silang = $this->subsidi_silang->load_data($data_send_subsidi_silang);
            $anggaran['pengurangan_subsidi_silang'] = $load_data_subsidi_silang->row()->pengurangan_subsidi_silang;

            #menghitung total pengeluaran...
            $anggaran['total_pengeluaran'] = $anggaran['total_sppd'] + $anggaran['biaya_operasional'] + $anggaran['pengurangan_subsidi_silang'];

            #menghitung sisa biaya.. sisa biaya juga bisa diartikan sebagai profit...
            $anggaran['sisa_biaya'] = sprintf("%.2f", $anggaran['anggaran_operasional'] - $anggaran['total_pengeluaran']);
            $anggaran['sisa_biaya_persen'] = sprintf("%.2f", ($anggaran['sisa_biaya'] / $row->nilai_kontrak) * 100);
        }

        return array(
            'detail_rab' => $detail_rab,
            'anggaran' => $anggaran
        );
    }

    function createBr($loop = 1)
    {
        $br = '';
        for ($i = 0; $i < $loop; $i++) {
            $br .= '<br>';
        }
        return $br;
    }
    function cropImage($sourcePath, $destinationPath, $targetWidth = 200, $targetHeight = 200)
    {
        // Dapatkan informasi ukuran gambar sumber
        list($sourceWidth, $sourceHeight, $sourceType) = getimagesize($sourcePath);

        // Buat gambar hasil pemotongan (canvas) dengan ukuran target
        $destinationImage = imagecreatetruecolor($targetWidth, $targetHeight);

        // Tentukan jenis gambar berdasarkan jenis gambar sumber
        switch ($sourceType) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($sourcePath);
                break;
                // Tambahkan jenis gambar lain sesuai kebutuhan
            default:
                return false; // Jenis gambar tidak didukung
        }

        // Tentukan posisi awal pemotongan
        $cropX = 0;
        $cropY = 0;

        // Hitung perbandingan aspek antara gambar sumber dan ukuran target
        $sourceAspect = $sourceWidth / $sourceHeight;
        $targetAspect = $targetWidth / $targetHeight;

        // Hitung ulang posisi pemotongan berdasarkan perbandingan aspek
        if ($sourceAspect > $targetAspect) {
            // Gambar sumber lebih lebar, potong atas dan bawah
            $newSourceWidth = $sourceHeight * $targetAspect;
            $cropX = ($sourceWidth - $newSourceWidth) / 2;
            $sourceWidth = $newSourceWidth;
        } else {
            // Gambar sumber lebih tinggi, potong kiri dan kanan
            $newSourceHeight = $sourceWidth / $targetAspect;
            $cropY = ($sourceHeight - $newSourceHeight) / 2;
            $sourceHeight = $newSourceHeight;
        }

        // Potong dan ubah ukuran gambar sumber ke dalam gambar hasil pemotongan
        imagecopyresampled($destinationImage, $sourceImage, 0, 0, $cropX, $cropY, $targetWidth, $targetHeight, $sourceWidth, $sourceHeight);

        // Simpan gambar hasil pemotongan (dalam format JPEG, Anda dapat menggantinya)
        imagejpeg($destinationImage, $destinationPath, 90); // Menggunakan JPEG dengan kualitas 90 (silakan sesuaikan)

        // Hapus gambar sumber dan gambar hasil pemotongan dari memori
        imagedestroy($sourceImage);
        imagedestroy($destinationImage);

        return true;
    }
}
