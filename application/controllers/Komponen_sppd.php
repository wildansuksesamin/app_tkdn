
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Komponen_sppd extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Komponen_sppd_model", "komponen_sppd");
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

                $where = "komponen_sppd.active = 1  and (komponen_sppd.nama_komponen like '%" . $filter . "%' or komponen_sppd.nilai like '%" . $filter . "%')";
                $send_data = array('where' => $where, 'limit' => $limit);
                $load_data = $this->komponen_sppd->load_data($send_data);
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'select' => $select);
                $load_data = $this->komponen_sppd->load_data($send_data);
                $total_data = $load_data->row()->jml;

                $last_page = ceil($total_data / $jml_data);
                $result = array('result' => $result, 'last_page' => $last_page);

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
                $id_komponen_sppd = htmlentities($this->input->post('id_komponen_sppd') ?? '');
                $nama_komponen = htmlentities($this->input->post('nama_komponen') ?? '');
                $default = htmlentities($this->input->post('default') ?? '');
                $nilai = htmlentities($this->input->post('nilai') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $action = htmlentities($this->input->post('action') ?? '');

                $nilai = str_replace('.', '', $nilai);

                #jika action memiliki value 'save' maka data akan disimpan.
                #jika action tidak memiliki value, maka akan dianggap sebagai upadate.
                if ($action == 'save') {
                    $data = array(
                        'nama_komponen' => $nama_komponen,
                        'default' => $default,
                        'nilai' => $nilai,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $exe = $this->komponen_sppd->save($data);
                    $return['sts'] = $exe;
                } else {
                    $data = array(
                        'nama_komponen' => $nama_komponen,
                        'default' => $default,
                        'nilai' => $nilai,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where = array('id_komponen_sppd' => $id_komponen_sppd);
                    $exe = $this->komponen_sppd->update($data, $where);
                    $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }
    public function hapus()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_komponen_sppd = $data_receive->id_komponen_sppd;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $where = array('id_komponen_sppd' => $id_komponen_sppd);
                $exe = $this->komponen_sppd->soft_delete($where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
