
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ttd_dokumen extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Ttd_dokumen_model", "ttd_dokumen");
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);

                $page = (isset($data_receive->page) ? htmlentities($data_receive->page ?? '') : 1);
                $jml_data = (isset($data_receive->jml_data) ? htmlentities($data_receive->jml_data ?? '') : $this->qty_data);

                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $group = '';
                $where = "ttd_dokumen.active = 1  and (ttd_dokumen.surat like '%" . $filter . "%')";
                if (isset($data_receive->for)) {
                    $for = $data_receive->for;
                    if ($for == 'load_ttd_dokumen') {
                        $group = "surat";
                    } else if ($for == 'edit_ttd_dokumen') {
                        $where .= " and surat = '" . htmlentities($data_receive->surat ?? '') . "'";
                    }
                }
                $send_data = array('where' => $where, 'limit' => $limit, 'group' => $group);
                $load_data = $this->ttd_dokumen->load_data($send_data);
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'select' => $select);
                $load_data = $this->ttd_dokumen->load_data($send_data);
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
                $id_ttd_dokumen = $this->input->post('id_ttd_dokumen');
                $nama_pejabat = $this->input->post('nama_pejabat');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                for ($i = 0; $i < count($id_ttd_dokumen); $i++) {
                    $data = array(
                        'nama_pejabat' => htmlentities($nama_pejabat[$i] ?? ''),
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where = array('id_ttd_dokumen' => htmlentities($id_ttd_dokumen[$i] ?? ''));
                    $this->ttd_dokumen->update($data, $where);
                }

                $return['sts'] = true;
            }

            echo json_encode($return);
        }
    }
    public function hapus()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_ttd_dokumen = $data_receive->id_ttd_dokumen;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $where = array('id_ttd_dokumen' => $id_ttd_dokumen);
                $exe = $this->ttd_dokumen->soft_delete($where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
