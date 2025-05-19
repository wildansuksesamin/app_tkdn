
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Request_forgot_password extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model("Request_forgot_password_model","request_forgot_password");
        $this->load->model("pelanggan_model", "pelanggan");
	}

    public function ganti_password(){
        $data_receive = json_decode(urldecode($this->input->post('data_send')));
        $token = htmlentities($data_receive->token ?? '');
        $password = htmlentities($data_receive->password ?? '');
        $time_update = date('Y-m-d H:i:s');

        $where = array('active' => 1, 'kode' => $token);
        $data_send = array('where' => $where);
        $load_data = $this->request_forgot_password->load_data($data_send);
        if($load_data->num_rows() > 0){
            $request = $load_data->row();

            $data = array(
                'password_perusahaan' => md5($password),
                'time_update' => $time_update,
                'user_update' => $request->id_pelanggan
            );
            $where = array('id_pelanggan' => $request->id_pelanggan);
            $exe = $this->pelanggan->update($data, $where, $request->id_pelanggan, 'pelanggan');
            $return['sts'] = $exe;
            if($exe){
                $this->request_forgot_password->delete(array('id_pelanggan' => $request->id_pelanggan), $request->id_pelanggan, 'pelanggan');
            }
        }
        else{
            $return['sts'] = 'tidak_berhak_akses_data';
        }
        echo json_encode($return);
    }

    public function proses(){
        $data_receive = json_decode(urldecode($this->input->post('data_send')));
        $email = htmlentities($data_receive->email ?? '');
        $time_create = date('Y-m-d H:i:s');
        $time_update = date('Y-m-d H:i:s');

        $where = array('active' => 1, 'email' => $email);
        $data_send = array('where' => $where);
        $load_data = $this->pelanggan->load_data($data_send);
        if($load_data->num_rows() > 0){
            $pelanggan = $load_data->row();
            $this->request_forgot_password->delete(array('id_pelanggan' => $pelanggan->id_pelanggan), $pelanggan->id_pelanggan, 'pelanggan');

            $kode = md5($this->generateRandomString());
            #input request password...
            $data = array('id_pelanggan' => $pelanggan->id_pelanggan,
                'tgl_request' => $time_create,
                'kode' => $kode,
                'user_create' => $pelanggan->id_pelanggan,
                'time_create' => $time_create,
                'time_update' => $time_update,
                'user_update' => $pelanggan->id_pelanggan);
            $exe = $this->request_forgot_password->save($data, $pelanggan->id_pelanggan, 'pelanggan');
            $return['sts'] = $exe;

            #masking email...
            $pecah_email = explode('@', $pelanggan->email);
            $return['email'] = substr($pecah_email[0], 0, 1).'****'.substr($pecah_email[0], -1).'@'.$pecah_email[1];
            if($exe){
                #kirim email...
                $template = file_get_contents(base_url('page/mail_template'));
                $template = str_replace('{{nama_pengaju}}', $pelanggan->nama_perusahaan, $template);
                $template = str_replace('{{isi_pesan}}', 'Maaf mendengar Anda mengalami masalah masuk ke '.$this->aplikasi.'. Kami mendapat pesan bahwa Anda lupa kata sandi Anda. Jika ini adalah Anda, Anda dapat langsung kembali ke akun atau menyetel ulang sandi sekarang.', $template);
                $template = str_replace('{{isi_pesan_2}}', 'Jika Anda tidak meminta tautan masuk atau pengaturan ulang kata sandi, Anda dapat mengabaikan pesan ini.<br><br>Hanya orang yang mengetahui kata sandi '.$this->aplikasi.' Anda atau mengeklik tautan masuk di email ini yang dapat masuk ke akun Anda.', $template);
                $template = str_replace('{{button_label}}', 'Reset Password Sekarang', $template);
                $template = str_replace('{{button_link}}', base_url('pelanggan/reset_password/?token='.$kode), $template);

                $data = array('penerima_email' => $pelanggan->email,
                    'judul_email' => $pelanggan->nama_perusahaan.', kami akan bantu mengembalikan akun anda.',
                    'pesan_email' => $template);
                $this->send_bunker($data);
            }
        }
        else{
            $return['sts'] = 'email_tidak_ada';
        }

        echo json_encode($return);
    }
}
