
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Pelanggan_model extends MY_Model{

        protected $table = 'pelanggan';

        public function login($username, $password, $from = ''){
            $this->db->select('id_pelanggan,
                        nama_perusahaan,
                        email,
                        verifikasi_email,
                        nama_badan_usaha');
            $this->db->from($this->table);
            $this->db->where('email',$username);
            $this->db->where('password_perusahaan',md5($password));
            $this->db->where($this->table.'.active','1');
            $this->db->join('tipe_badan_usaha', 'tipe_badan_usaha.id_tipe_badan_usaha = '.$this->table.'.id_tipe_badan_usaha', 'LEFT');
            $tabel = $this->db->get();

            $return = false;
            if($tabel->num_rows()==1){
                $tabel = $tabel->row();

                if($tabel->verifikasi_email == 1){
                    if($from == 'mobile'){
                        $status = true;
                        $return = array('status' => $status, 'data' => $tabel);
                    }
                    else{
                        $session = array("id_pelanggan" => $tabel->id_pelanggan,
                            "nama_perusahaan"		    => $tabel->nama_badan_usaha.' '.$tabel->nama_perusahaan,
                            "email"	                    => $tabel->email,
                            "password_perusahaan"	    => md5($password),
                            "login_as"	                => "pelanggan"
                        );
                        $this->session->set_userdata($session);
                        $return = true;
                    }
                }
                else{
                    return 'email_not_verified';
                }
            }

            return $return;
        }
        public function checkPelanggan($email, $password){
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where('email',$email);
            $this->db->where('password_perusahaan',$password);
            $this->db->where('active','1');
            $data = $this->db->get();

            if($data->num_rows()==1)
                return true;
            else
                return false;

        }
    }
?>
