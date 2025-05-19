
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rekening_bank extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Rekening_bank_model", "rekening_bank");
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $where = "rekening_bank.active = 1";
                $send_data = array('where' => $where);
                $load_data = $this->rekening_bank->load_data($send_data);
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'select' => $select);
                $load_data = $this->rekening_bank->load_data($send_data);
                $total_data = $load_data->row()->jml;

                $result = array('result' => $result);

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
                $id_rekening_bank = htmlentities($this->input->post('id_rekening_bank') ?? '');
                $nama_bank = htmlentities($this->input->post('nama_bank') ?? '');
                $nomor_rekening = htmlentities($this->input->post('nomor_rekening') ?? '');
                $nama_rekening = htmlentities($this->input->post('nama_rekening') ?? '');
                $pemilik_rekening = htmlentities($this->input->post('pemilik_rekening') ?? '');
                $kantor_cabang = htmlentities($this->input->post('kantor_cabang') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $action = htmlentities($this->input->post('action') ?? '');

                #jika action memiliki value 'save' maka data akan disimpan.
                #jika action tidak memiliki value, maka akan dianggap sebagai upadate.
                if ($action == 'save') {
                    $data = array(
                        'nama_bank' => $nama_bank,
                        'nomor_rekening' => $nomor_rekening,
                        'nama_rekening' => $nama_rekening,
                        'pemilik_rekening' => $pemilik_rekening,
                        'kantor_cabang' => $kantor_cabang,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $exe = $this->rekening_bank->save($data);
                    $return['sts'] = $exe;
                } else {
                    $data = array(
                        'nama_bank' => $nama_bank,
                        'nomor_rekening' => $nomor_rekening,
                        'nama_rekening' => $nama_rekening,
                        'pemilik_rekening' => $pemilik_rekening,
                        'kantor_cabang' => $kantor_cabang,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where = array('id_rekening_bank' => $id_rekening_bank);
                    $exe = $this->rekening_bank->update($data, $where);
                    $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }
}
