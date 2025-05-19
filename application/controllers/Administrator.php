<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Mst_admin_model", 'master_admin');
        $this->load->model('credential_model', 'credential');
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $where = array('status_admin !=' => 'D', 'id_admin !=' => 1);
                if (isset($data_receive->id_admin))
                    $where['id_admin'] = $data_receive->id_admin;

                $join[0] = array('tabel' => 'jns_admin', 'relation' => 'jns_admin.id_jns_admin = mst_admin.id_jns_admin', 'direction' => 'left');
                $order = ' nama_admin ASC';

                $data_send = array('where' => $where, 'order' => $order, 'join' => $join);
                $load_data = $this->master_admin->load_data($data_send);
                $result = $load_data->result();
                echo json_encode($result);
            }
        }
    }

    public function simpan()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {

                $id_admin = $this->input->post('id_admin');
                $nama_lengkap = htmlentities($this->input->post('nama_lengkap') ?? '');
                $username = htmlentities($this->input->post('username') ?? '');
                $email_admin = htmlentities($this->input->post('email_admin') ?? '');
                $telepon_admin = htmlentities($this->input->post('telepon_admin') ?? '');
                $password = htmlentities($this->input->post('password') ?? '');
                $tipe_admin = htmlentities($this->input->post('tipe_admin') ?? '');
                $jns_sppd = htmlentities($this->input->post('jns_sppd') ?? '');
                $foto_admin_blob = $this->input->post('foto_admin_blob');
                $ttd_admin_blob = $this->input->post('ttd_admin_blob');
                $etc = $this->input->post('etc');
                $status_admin = $this->input->post('status_admin');

                $action = $this->input->post('action');

                #check if etc exists so set to 1 else set to 0
                if (isset($etc)) {
                    $etc = 1;
                } else {
                    $etc = 0;
                }

                if (isset($status_admin)) {
                    $status_admin = 'A';
                } else {
                    $status_admin = 'N';
                }

                $file_foto = '';
                if ($foto_admin_blob != '') {
                    $new_name = date('ymdHis') . '_' . $this->generateRandomString(5);
                    $output = 'assets/uploads/admin/';
                    $filename = $new_name . '.jpg';
                    $file_foto = $this->base64_to_file($foto_admin_blob, $output, $filename);
                }

                $ttd_admin = '';
                if ($ttd_admin_blob != '') {
                    $new_name = 'ttd-' . date('ymdHis') . '_' . $this->generateRandomString(5);
                    $output = 'assets/uploads/admin/';
                    $filename = $new_name . '.jpg';
                    $ttd_admin = $this->base64_to_file($ttd_admin_blob, $output, $filename);
                }

                #jika action memiliki value 'save' maka data akan disimpan.
                #jika action tidak memiliki value, maka akan dianggap sebagai upadate.
                if ($action == 'save') {
                    #cek apakah username yang dimasukan sudah ada sebelumnya...
                    $where_username = array('username_admin' => $username);
                    $hasil_username = $this->master_admin->is_available($where_username);

                    if ($hasil_username)
                        $return['sts'] = 'username_available';
                    else {
                        $data = array(
                            'nama_admin' => $nama_lengkap,
                            'username_admin' => $username,
                            'email_admin' => $email_admin,
                            'telepon_admin' => $telepon_admin,
                            'foto_admin' => $file_foto,
                            'ttd_admin' => $ttd_admin,
                            'status_admin' => $status_admin,
                            'jns_sppd' => $jns_sppd,
                            'etc' => $etc,
                            'id_jns_admin' => $tipe_admin
                        );
                        $hasil = $this->master_admin->save_with_autoincrement($data);
                        $return['sts'] = $hasil[0];
                        $id_admin = $hasil[1];

                        #create credential...
                        if ($hasil[0]) {
                            $data_credential = array(
                                'id_pengguna' => $id_admin,
                                'tabel' => 'mst_admin',
                                'password' => md5($password),
                                'active' => 1,
                                'user_create' => $id_admin,
                                'time_create' => date('Y-m-d'),
                                'user_update' => $id_admin,
                                'time_update' => date('Y-m-d')
                            );
                            $this->credential->save($data_credential);
                        }
                    }
                } else {
                    #cek apakah username yang dimasukan sudah ada sebelumnya...
                    $where_username = array(
                        'username_admin' => $username,
                        'id_admin !='   => $id_admin
                    );
                    $hasil_username = $this->master_admin->is_available($where_username);

                    if ($hasil_username)
                        $return['sts'] = 'username_available';
                    else {
                        $data = array(
                            'nama_admin' => $nama_lengkap,
                            'email_admin' => $email_admin,
                            'jns_sppd' => $jns_sppd,
                            'telepon_admin' => $telepon_admin,
                            'etc' => $etc,
                            'status_admin' => $status_admin,
                        );

                        if ($id_admin != 1) {
                            $data['username_admin'] = $username;
                            $data['status_admin'] = $status_admin;
                            $data['id_jns_admin'] = $tipe_admin;
                        }

                        if ($file_foto != '') {
                            $data['foto_admin'] = $file_foto;
                        }
                        if ($ttd_admin != '') {
                            $data['ttd_admin'] = $ttd_admin;
                        }
                        $where = array('id_admin' => $id_admin);
                        $exe = $this->master_admin->update($data, $where);
                        $return['sts'] = $exe;
                    }
                }
            }

            echo json_encode($return);
        }
    }
    public function update_profil()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {

                $id_admin = $this->session->userdata('id_admin');
                $nama_lengkap = $this->input->post('nama_lengkap');
                $username = $this->input->post('username');
                $email_admin = $this->input->post('email_admin');
                $telepon_admin = $this->input->post('telepon_admin');

                $foto_admin_blob = $this->input->post('foto_admin_blob');
                $ttd_admin_blob = $this->input->post('ttd_admin_blob');

                $file_foto = '';
                if ($foto_admin_blob != '') {
                    $new_name = date('ymdHis') . '_' . $this->generateRandomString(5);
                    $output = 'assets/uploads/admin/';
                    $filename = $new_name . '.jpg';
                    $file_foto = $this->base64_to_file($foto_admin_blob, $output, $filename);
                }

                $ttd_admin = '';
                if ($ttd_admin_blob != '') {
                    $new_name = 'ttd-' . date('ymdHis') . '_' . $this->generateRandomString(5);
                    $output = 'assets/uploads/admin/';
                    $filename = $new_name . '.jpg';
                    $ttd_admin = $this->base64_to_file($ttd_admin_blob, $output, $filename);
                }

                #cek apakah username yang dimasukan sudah ada sebelumnya...
                $where_username = array(
                    'username_admin' => $username,
                    'id_admin !='   => $id_admin
                );
                $hasil_username = $this->master_admin->is_available($where_username);

                if ($hasil_username)
                    $return['sts'] = 'username_available';
                else {
                    $data = array(
                        'nama_admin' => $nama_lengkap,
                        'email_admin' => $email_admin,
                        'telepon_admin' => $telepon_admin,
                        'username_admin' => $username,
                    );

                    if ($file_foto != '') {
                        $data['foto_admin'] = $file_foto;
                    }
                    if ($ttd_admin != '') {
                        $data['ttd_admin'] = $ttd_admin;
                    }
                    $where = array('id_admin' => $id_admin);
                    $exe = $this->master_admin->update($data, $where);
                    $return['sts'] = $exe;
                    if ($exe) {
                        if ($file_foto != '') {
                            $this->session->foto_admin = $file_foto;
                        }
                    }
                }

                echo json_encode($return);
            }
        }
    }
    public function hapus()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_admin = htmlentities($data_receive->id_admin ?? '');

                if ($id_admin != 1) {
                    $data = array('status_admin' => 'D');
                    $where = array('id_admin' => $id_admin);
                    $exe = $this->master_admin->update($data, $where);
                    $return['sts'] = $exe;
                } else
                    $return['sts'] = 'tidak_berhak';
            }

            echo json_encode($return);
        }
    }
    public function reset_password()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_admin = htmlentities($data_receive->id_admin ?? '');
                $username = htmlentities($data_receive->username ?? '');

                $data = array('password' => md5($username));
                $where = array('id_pengguna' => $id_admin, 'tabel' => 'mst_admin');
                $exe = $this->credential->update($data, $where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }



    public function ganti_password()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                //cek password lama sama dengan database..
                $where = array(
                    'id_pengguna' => $this->session->userdata('id_admin'),
                    'password' => md5($data_receive->pass_lama),
                    'tabel' => 'mst_admin'
                );
                $status = $this->credential->is_available($where);
                if ($status) {
                    //proses update password..
                    $data = array('password' => md5($data_receive->pass_baru));
                    $exe = $this->credential->update($data, $where);

                    //ganti session password...
                    $session = array("password_admin" => md5($data_receive->pass_baru));
                    $this->session->set_userdata($session);

                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'password_salah';
                }
            }
        }
        echo json_encode($return);
    }
}
