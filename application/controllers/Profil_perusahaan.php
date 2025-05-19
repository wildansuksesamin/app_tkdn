
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profil_perusahaan extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Profil_perusahaan_model", "profil_perusahaan");
    }

    public function simpan()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $nama_perusahaan = htmlentities($this->input->post('nama_perusahaan') ?? '');
                $nama_lengkap_perusahaan = htmlentities($this->input->post('nama_lengkap_perusahaan') ?? '');
                $alamat_pusat = htmlentities($this->input->post('alamat_pusat') ?? '');
                $kantor_cabang = htmlentities($this->input->post('kantor_cabang') ?? '');
                $alamat_kantor_cabang = htmlentities($this->input->post('alamat_kantor_cabang') ?? '');
                $npwp_perusahaan = htmlentities($this->input->post('npwp_perusahaan') ?? '');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $data = array(
                    'nama_perusahaan' => $nama_perusahaan,
                    'nama_lengkap_perusahaan' => $nama_lengkap_perusahaan,
                    'alamat_pusat' => $alamat_pusat,
                    'kantor_cabang' => $kantor_cabang,
                    'alamat_kantor_cabang' => $alamat_kantor_cabang,
                    'npwp_perusahaan' => $npwp_perusahaan,
                    'time_update' => $time_update,
                    'user_update' => $user_update
                );
                $where = array('id_profil_perusahaan' => 1);
                $exe = $this->profil_perusahaan->update($data, $where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
