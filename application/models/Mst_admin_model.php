<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mst_admin_model extends MY_Model
{

    protected $table = 'mst_admin';

    public function login($username, $password, $from = '')
    {
        $this->db->select('id_admin,
                        nama_admin,
                        username_admin,
                        foto_admin,
                        status_admin,
                        mst_admin.id_jns_admin,
                        jns_admin');
        $this->db->from('mst_admin');
        $this->db->where('username_admin', $username);
        $this->db->where('credential.password', md5($password));
        $this->db->where('status_admin', 'A');
        $this->db->join('jns_admin', 'jns_admin.id_jns_admin = mst_admin.id_jns_admin', 'left');
        $this->db->join('credential', 'credential.id_pengguna = mst_admin.id_admin and tabel = \'mst_admin\' and credential.active = 1', 'left');
        $tabel = $this->db->get();

        $return = false;
        if ($tabel->num_rows() == 1) {
            $tabel = $tabel->row();

            if ($from == 'mobile') {
                $status = true;
                $return = array('status' => $status, 'data' => $tabel);
            } else {
                $session = array(
                    "id_admin" => $tabel->id_admin,
                    "nama_admin"            => $tabel->nama_admin,
                    "username_admin"        => $tabel->username_admin,
                    "password_admin"        => md5($password),
                    "id_jns_admin"          => $tabel->id_jns_admin,
                    "foto_admin"          => $tabel->foto_admin,
                    "jns_admin"          => $tabel->jns_admin,
                    "login_as"                => "administrator"
                );
                $this->session->set_userdata($session);
                $return = true;
            }
        }

        return $return;
    }
    public function checkAdmin($username, $password)
    {
        $this->db->select('*');
        $this->db->from('mst_admin');
        $this->db->where('username_admin', $username);
        $this->db->where('password_admin', $password);
        $this->db->where('status_admin', 'A');
        $data = $this->db->get();

        if ($data->num_rows() == 1)
            return true;
        else
            return false;
    }
}
