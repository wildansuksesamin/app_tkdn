
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mata_anggaran extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model("Mata_anggaran_model","mata_anggaran");
	}

    public function load_data(){
        if($this->validasi_login()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if($this->tokenStatus($token, 'LOAD_DATA')){
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);


                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data.','.$start;

                $where = "mata_anggaran.active = 1  and (mata_anggaran.nama_mata_anggaran like '%".$filter."%' )";
                $send_data = array('where' => $where, 'limit' => $limit);
                $load_data = $this->mata_anggaran->load_data($send_data);
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'select' => $select);
                $load_data = $this->mata_anggaran->load_data($send_data);
                $total_data = $load_data->row()->jml;

                $last_page = ceil($total_data / $jml_data);
                $result = array('result' => $result, 'last_page' => $last_page);

                echo json_encode($result);
            }
        }

    }

    public function simpan(){
        if($this->validasi_login()){
            $token = $this->input->post('token');
            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
                $id_mata_anggaran = htmlentities($this->input->post('id_mata_anggaran') ?? '');
				$biaya = htmlentities($this->input->post('biaya') ?? '');
				$satuan = htmlentities($this->input->post('satuan') ?? '');
				$time_update = date('Y-m-d H:i:s');
				$user_update = $this->session->userdata('id_admin');

                $biaya = str_replace('.', '', $biaya);
                $biaya = str_replace('_', '', $biaya);
                $biaya = str_replace(',', '.', $biaya);

                #jika action memiliki value 'save' maka data akan disimpan.
                #jika action tidak memiliki value, maka akan dianggap sebagai upadate.

                    $data = array(
								'biaya' => $biaya,
								'satuan' => $satuan,
								'time_update' => $time_update,
								'user_update' => $user_update);
                        $where = array('id_mata_anggaran' => $id_mata_anggaran);
                        $exe = $this->mata_anggaran->update($data, $where);
                        $return['sts'] = $exe;

            }

            echo json_encode($return);
        }
    }
    public function hapus(){
        if($this->validasi_login()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_mata_anggaran = $data_receive->id_mata_anggaran;

            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
                $where = array('id_mata_anggaran' => $id_mata_anggaran);
                $exe = $this->mata_anggaran->soft_delete($where);
                $return['sts'] = $exe;

            }

            echo json_encode($return);
        }
    }

}
