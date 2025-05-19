
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel_internal_nama_file extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model("Panel_internal_nama_file_model","panel_internal_nama_file");
	}
	
	public function index(){
        $menu = 'panel_internal_nama_file';
        if($this->validasi_controller($menu) && $this->validasi_login()){
            $this->load->model('tipe_permohonan_model', 'tipe_permohonan');
                $where = array('active' => 1);  #show active data...
                $send_data = array('where' => $where);
                $tipe_permohonan = $this->tipe_permohonan->load_data($send_data);

            $konten = array('tipe_permohonan' => $tipe_permohonan);
            $this->load->view('', $this->data_halaman($konten));
        }
        else
            $this->redirect(base_url().'gateway/keluar');
    }

    public function load_data(){
        if($this->validasi_login()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if($this->tokenStatus($token, 'LOAD_DATA')){
                
                $relation[0] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = panel_internal_nama_file.id_tipe_permohonan', 'direction' => 'left');

                
                $where = array('panel_internal_nama_file.active' => 1 , 'tipe_permohonan.active' => 1 ); #show active data...

                $send_data = array('where' => $where, 'join' => $relation);
                $load_data = $this->panel_internal_nama_file->load_data($send_data);
                $result = $load_data->result();
                
                
                echo json_encode($result);
            }
        }

    }

    public function simpan(){
        if($this->validasi_login()){
            $token = $this->input->post('token');
            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
                $id_nama_file = htmlentities($this->input->post('id_nama_file') ?? '');
				$id_tipe_permohonan = htmlentities($this->input->post('id_tipe_permohonan') ?? '');
				$nama_file = htmlentities($this->input->post('nama_file') ?? '');
				$keterangan = htmlentities($this->input->post('keterangan') ?? '');
				$template = htmlentities($this->input->post('template') ?? '');
				$required = htmlentities($this->input->post('required') ?? '');
				$multi_file = htmlentities($this->input->post('multi_file') ?? '');
				$jns_file = htmlentities($this->input->post('jns_file') ?? '');
				$referensi = htmlentities($this->input->post('referensi') ?? '');
				$aktor = htmlentities($this->input->post('aktor') ?? '');
				$urutan = htmlentities($this->input->post('urutan') ?? '');
				$user_create = $this->session->userdata('id_admin');
				$time_create = date('Y-m-d H:i:s');
				$time_update = date('Y-m-d H:i:s');
				$user_update = $this->session->userdata('id_admin');

                $action = htmlentities($this->input->post('action') ?? '');

                #jika action memiliki value 'save' maka data akan disimpan.
                #jika action tidak memiliki value, maka akan dianggap sebagai upadate.
                if($action == 'save'){
                    $data = array(								'id_tipe_permohonan' => $id_tipe_permohonan,
								'nama_file' => $nama_file,
								'keterangan' => $keterangan,
								'template' => $template,
								'required' => $required,
								'multi_file' => $multi_file,
								'jns_file' => $jns_file,
								'referensi' => $referensi,
								'aktor' => $aktor,
								'urutan' => $urutan,
								'user_create' => $user_create,
								'time_create' => $time_create,
								'time_update' => $time_update,
								'user_update' => $user_update);
                        $exe = $this->panel_internal_nama_file->save($data);
                        $return['sts'] = $exe;
                }
                else{
                    $data = array(								'id_tipe_permohonan' => $id_tipe_permohonan,
								'nama_file' => $nama_file,
								'keterangan' => $keterangan,
								'template' => $template,
								'required' => $required,
								'multi_file' => $multi_file,
								'jns_file' => $jns_file,
								'referensi' => $referensi,
								'aktor' => $aktor,
								'urutan' => $urutan,
								'time_update' => $time_update,
								'user_update' => $user_update);
                        $where = array('id_nama_file' => $id_nama_file);
                        $exe = $this->panel_internal_nama_file->update($data, $where);
                        $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }
    public function hapus(){
        if($this->validasi_login()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_nama_file = $data_receive->id_nama_file;

            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
                $where = array('id_nama_file' => $id_nama_file);
                $exe = $this->panel_internal_nama_file->soft_delete($where);
                $return['sts'] = $exe;

            }

            echo json_encode($return);
        }
    }
    
}