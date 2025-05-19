
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_pelanggan extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Pelanggan_model", "pelanggan");
    }

    public function login()
    {
        $return = array();
        $data_receive = json_decode(urldecode($this->input->post('data_send')));
        $email = htmlentities($data_receive->email ?? '');
        $password = htmlentities($data_receive->password ?? '');

        $result = $this->pelanggan->login($email, $password);
        if ($result === true) {
            $return['sts'] = 1;
        } else if ($result == 'email_not_verified') {
            $return['sts'] = 'email_not_verified';
        } else if ($result === false)
            $return['sts'] = 'not_valid';

        echo json_encode($return);
    }

    public function daftar()
    {
        $return = array();

        $data_receive = json_decode(urldecode($this->input->post('data_send')));

        $id_tipe_badan_usaha = htmlentities($data_receive->id_tipe_badan_usaha ?? '');
        $nama_perusahaan = htmlentities($data_receive->nama_perusahaan ?? '');
        $alamat_perusahaan = htmlentities($data_receive->alamat_perusahaan ?? '');
        $email = htmlentities($data_receive->email ?? '');
        $password_perusahaan = md5(htmlentities($data_receive->password_perusahaan) ?? '');
        $nama_pejabat_penghubung_proses_tkdn = htmlentities($data_receive->nama_pejabat_penghubung_proses_tkdn ?? '');
        $jabatan_pejabat_penghubung_proses_tkdn = htmlentities($data_receive->jabatan_pejabat_penghubung_proses_tkdn ?? '');
        $telepon_pejabat_penghubung_proses_tkdn = htmlentities($data_receive->telepon_pejabat_penghubung_proses_tkdn ?? '');
        $nama_pejabat_penghubung_invoice = htmlentities($data_receive->nama_pejabat_penghubung_invoice ?? '');
        $telepon_pejabat_penghubung_invoice = htmlentities($data_receive->telepon_pejabat_penghubung_invoice ?? '');
        $nama_pejabat_penghubung_pajak = htmlentities($data_receive->nama_pejabat_penghubung_pajak ?? '');
        $telepon_pejabat_penghubung_pajak = htmlentities($data_receive->telepon_pejabat_penghubung_pajak ?? '');

        #cek nama perusahaan..
        $where_perusahaan = array('active' => 1, 'id_tipe_badan_usaha' => $id_tipe_badan_usaha, 'nama_perusahaan' => $nama_perusahaan);
        $cek_perusahaan = $this->pelanggan->is_available($where_perusahaan);

        #cek email...
        $where_email = array('active' => 1, 'email' => $email);
        $cek_email = $this->pelanggan->is_available($where_perusahaan);


        if ($cek_perusahaan) {
            $return['sts'] = 'perusahaan_available';
        } else if ($cek_email) {
            $return['sts'] = 'email_available';
        } else {
            $data = array(
                'id_tipe_badan_usaha' => $id_tipe_badan_usaha,
                'nama_perusahaan' => $nama_perusahaan,
                'alamat_perusahaan' => $alamat_perusahaan,
                'email' => $email,
                'password_perusahaan' => $password_perusahaan,
                'nama_pejabat_penghubung_proses_tkdn' => $nama_pejabat_penghubung_proses_tkdn,
                'jabatan_pejabat_penghubung_proses_tkdn' => $jabatan_pejabat_penghubung_proses_tkdn,
                'telepon_pejabat_penghubung_proses_tkdn' => $telepon_pejabat_penghubung_proses_tkdn,
                'nama_pejabat_penghubung_invoice' => $nama_pejabat_penghubung_invoice,
                'telepon_pejabat_penghubung_invoice' => $telepon_pejabat_penghubung_invoice,
                'nama_pejabat_penghubung_pajak' => $nama_pejabat_penghubung_pajak,
                'telepon_pejabat_penghubung_pajak' => $telepon_pejabat_penghubung_pajak,
                'verifikasi_email' => 1 // 0 = Artinya butuh email verifikasi...
            );
            $exe = $this->pelanggan->save_with_autoincrement($data, 'guest', 'guest');
            if ($exe[0]) {
                $id_pelanggan = $exe[1];
                $data = array(
                    'user_create' => $id_pelanggan,
                    'time_create' => date('Y-m-d H:i:s'),
                    'time_update' => date('Y-m-d H:i:s'),
                    'user_update' => $id_pelanggan
                );
                $where = array('id_pelanggan' => $id_pelanggan);
                $this->pelanggan->update($data, $where, $id_pelanggan, 'pelanggan');

                #masking email...
                $pecah_email = explode('@', $email);
                $return['email'] = substr($pecah_email[0], 0, 1) . '****' . substr($pecah_email[0], -1) . '@' . $pecah_email[1];

                #send email...
                $this->send_email_verifikasi($id_pelanggan, $nama_perusahaan, $email);
            }

            $return['sts'] = $exe[0];
        }

        echo json_encode($return);
    }

    public function request_verifikasi_email()
    {
        $data_receive = json_decode(urldecode($this->input->post('data_send')));
        $email = $data_receive->email;
        $where = array('active' => 1, 'email' => $email);
        $data_send = array('where' => $where);
        $load_data = $this->pelanggan->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            $data = $load_data->row();
            $id_pelanggan = $data->id_pelanggan;
            $nama_perusahaan = $data->nama_perusahaan;

            $this->send_email_verifikasi($id_pelanggan, $nama_perusahaan, $email);

            $return['sts'] = true;

            #masking email...
            $pecah_email = explode('@', $email);
            $return['email'] = substr($pecah_email[0], 0, 1) . '****' . substr($pecah_email[0], -1) . '@' . $pecah_email[1];
        } else {
            $return['sts'] = 'email_tidak_ada';
        }
        echo json_encode($return);
    }

    function send_email_verifikasi($id_pelanggan, $nama_perusahaan, $email)
    {
        $kode = md5($id_pelanggan) . md5($email);
        $template = file_get_contents(base_url('page/mail_template'));
        $template = str_replace('{{nama_pengaju}}', $nama_perusahaan, $template);
        $template = str_replace('{{isi_pesan}}', 'Terima kasih telah mendaftar di akun website ' . $this->aplikasi . ". Silakan klik tautan di bawah ini untuk melakukan konfirmasi Email untuk menyelesaikan proses registrasi.", $template);
        $template = str_replace('{{isi_pesan_2}}', '', $template);
        $template = str_replace('{{button_label}}', 'Konfirmasi Akun', $template);
        $template = str_replace('{{button_link}}', base_url('pelanggan/verifikasi_email/?token=' . $kode), $template);

        $data = array(
            'penerima_email' => $email,
            'judul_email' => 'Verifikasi email untuk ' . $nama_perusahaan,
            'pesan_email' => $template
        );
        $this->send_bunker($data);
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);

                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $order = "id_pelanggan DESC";
                $join[0] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                $where = "pelanggan.active = 1  and (concat(tipe_badan_usaha.nama_badan_usaha,' ',pelanggan.nama_perusahaan) like '%" . $filter . "%' or pelanggan.nama_perusahaan like '%" . $filter . "%' or pelanggan.alamat_perusahaan like '%" . $filter . "%' or pelanggan.email like '%" . $filter . "%')";
                if (isset($data_receive->status_verifikasi)) {
                    $where .= " and status_verifikasi = '" . htmlentities($data_receive->status_verifikasi ?? '') . "'";
                }
                if (isset($data_receive->id_pelanggan)) {
                    $where .= " and id_pelanggan = '" . htmlentities($data_receive->id_pelanggan ?? '') . "'";
                }
                $send_data = array('where' => $where, 'limit' => $limit, 'order' => $order, 'join' => $join);
                $load_data = $this->pelanggan->load_data($send_data);
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'select' => $select, 'join' => $join);
                $load_data = $this->pelanggan->load_data($send_data);
                $total_data = $load_data->row()->jml;

                $last_page = ceil($total_data / $jml_data);
                $result = array('result' => $result, 'last_page' => $last_page);

                echo json_encode($result);
            }
        }
    }
}
