<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pelanggan extends MY_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("Pelanggan_model",'pelanggan');
    }

    public function load_data(){
        if($this->validasi_login_pelanggan()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if($this->tokenStatus($token, 'LOAD_DATA')){
                $where = array('active' => 1, 'id_pelanggan' => $this->session->userdata('id_pelanggan'));

                $data_send = array('where' => $where);
                $load_data = $this->pelanggan->load_data($data_send);
                $result = $load_data->result();
                echo json_encode($result);
            }
        }

    }

    public function simpan(){
        if($this->validasi_login_pelanggan()){
            $token = $this->input->post('token');
            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
                $id_pelanggan = $this->session->userdata('id_pelanggan');
                $nama_perusahaan = htmlentities($this->input->post('nama_perusahaan') ?? '');
                $alamat_perusahaan = htmlentities($this->input->post('alamat_perusahaan') ?? '');
                $email = htmlentities($this->input->post('email') ?? '');
                $nama_pejabat_penghubung_proses_tkdn = htmlentities($this->input->post('nama_pejabat_penghubung_proses_tkdn') ?? '');
                $jabatan_pejabat_penghubung_proses_tkdn = htmlentities($this->input->post('jabatan_pejabat_penghubung_proses_tkdn') ?? '');
                $telepon_pejabat_penghubung_proses_tkdn = htmlentities($this->input->post('telepon_pejabat_penghubung_proses_tkdn') ?? '');

                $nama_pejabat_penghubung_invoice = htmlentities($this->input->post('nama_pejabat_penghubung_invoice') ?? '');
                $telepon_pejabat_penghubung_invoice = htmlentities($this->input->post('telepon_pejabat_penghubung_invoice') ?? '');

                $nama_pejabat_penghubung_pajak = htmlentities($this->input->post('nama_pejabat_penghubung_pajak') ?? '');
                $telepon_pejabat_penghubung_pajak = htmlentities($this->input->post('telepon_pejabat_penghubung_pajak') ?? '');

                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_pelanggan');

                #cek apakah email sudah dipakai...
                $where_email = array('email' => $email, 'id_pelanggan != ' => $id_pelanggan);
                $hasil_email = $this->pelanggan->is_available($where_email);

                if($hasil_email)
                    $return['sts'] = 'email_available';
                else{
                    $data = array('nama_perusahaan' => $nama_perusahaan,
                        'alamat_perusahaan' => $alamat_perusahaan,
                        'email' => $email,
                        'nama_pejabat_penghubung_proses_tkdn' => $nama_pejabat_penghubung_proses_tkdn,
                        'jabatan_pejabat_penghubung_proses_tkdn' => $jabatan_pejabat_penghubung_proses_tkdn,
                        'telepon_pejabat_penghubung_proses_tkdn' => $telepon_pejabat_penghubung_proses_tkdn,
                        'nama_pejabat_penghubung_invoice' => $nama_pejabat_penghubung_invoice,
                        'telepon_pejabat_penghubung_invoice' => $telepon_pejabat_penghubung_invoice,
                        'nama_pejabat_penghubung_pajak' => $nama_pejabat_penghubung_pajak,
                        'telepon_pejabat_penghubung_pajak' => $telepon_pejabat_penghubung_pajak,
                        'time_update' => $time_update,
                        'user_update' => $user_update);
                    $where = array('id_pelanggan' => $id_pelanggan);
                    $exe = $this->pelanggan->update($data, $where, $id_pelanggan, 'pelanggan');
                    $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }

    public function ganti_password(){
        if($this->validasi_login_pelanggan()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
                $id_pelanggan = $this->session->userdata('id_pelanggan');
                //cek password lama sama dengan database..
                $where = array('id_pelanggan' => $id_pelanggan,
                    'password_perusahaan' => md5($data_receive->pass_lama));
                $status = $this->pelanggan->is_available($where);
                if($status){
                    //proses update password..
                    $data = array('password_perusahaan' => md5($data_receive->pass_baru));
                    $exe = $this->pelanggan->update($data, $where, $id_pelanggan, 'pelanggan');

                    //ganti session password...
                    $session = array("password_perusahaan" => md5($data_receive->pass_baru) );
                    $this->session->set_userdata($session);

                    $return['sts'] = $exe;
                }
                else{
                    $return['sts'] = 'password_salah';
                }
            }
        }
        echo json_encode($return);

    }


}
