
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pesan extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model("Pesan_model","pesan");
	}
	
    public function load_data(){
        if($this->validasi_login_pelanggan()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if($this->tokenStatus($token, 'LOAD_DATA')){
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);
                $relation[0] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = pesan.id_pelanggan', 'direction' => 'left');
                $relation[1] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
                $relation[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = pesan.id_dokumen_permohonan', 'direction' => 'left');
                $relation[3] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $relation[4] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');
                $relation[5] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
                
                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;
                
                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data.','.$start;

                $where = "pesan.active = 1  and pelanggan.active = 1 and pesan.id_pelanggan = '".$this->session->userdata('id_pelanggan')."' and (concat(tipe_badan_usaha.nama_badan_usaha, ' ', pelanggan.nama_perusahaan) like '%".$filter."%' or pesan.nomor_surat like '%".$filter."%' or pesan.perihal_pesan like '%".$filter."%' or surat_oc.nomor_oc like '%".$filter."%')";
                $send_data = array('where' => $where, 'join' => $relation, 'limit' => $limit);
                $load_data = $this->pesan->load_data($send_data);
                $result = $load_data->result();
                
                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'join' => $relation, 'select' => $select);
                $load_data = $this->pesan->load_data($send_data);
                $total_data = $load_data->row()->jml;
                
                $last_page = ceil($total_data / $jml_data);
                $result = array('result' => $result, 'last_page' => $last_page);

                echo json_encode($result);
            }
        }

    }
}