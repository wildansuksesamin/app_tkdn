
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_pekerjaan extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Survey_lapangan_perjab_model", "survey_lapangan_perjab");
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

                $order = "id_survey_lapangan_perjab DESC";
                // $join[0] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                // $where = "pelanggan.active = 1  and (concat(tipe_badan_usaha.nama_badan_usaha,' ',pelanggan.nama_perusahaan) like '%" . $filter . "%' or pelanggan.nama_perusahaan like '%" . $filter . "%' or pelanggan.alamat_perusahaan like '%" . $filter . "%' or pelanggan.email like '%" . $filter . "%')";
                // if (isset($data_receive->status_verifikasi)) {
                //     $where .= " and status_verifikasi = '" . htmlentities($data_receive->status_verifikasi ?? '') . "'";
                // }
                // if (isset($data_receive->id_pelanggan)) {
                //     $where .= " and id_pelanggan = '" . htmlentities($data_receive->id_pelanggan ?? '') . "'";
                // }
                // $send_data = array('where' => $where, 'limit' => $limit, 'order' => $order, 'join' => $join);
                $send_data = array( 'limit' => $limit, 'order' => $order);
               
                $load_data = $this->survey_lapangan_perjab->load_data($send_data);
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                // $send_data = array('where' => $where, 'select' => $select, 'join' => $join);
                $send_data = array('select' => $select, 'limit' => $limit, 'order' => $order);
               
                $load_data = $this->survey_lapangan_perjab->load_data($send_data);
                $total_data = $load_data->row()->jml;

                $last_page = ceil($total_data / $jml_data);
                $result = array('result' => $result, 'last_page' => $last_page);

                echo json_encode($result);
            }
        }
    }
}
