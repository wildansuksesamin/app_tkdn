
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pesan extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model("Pesan_model","pesan");
	}
	
    public function load_data(){
        if($this->validasi_login()){
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

                $where = "pesan.active = 1  and pelanggan.active = 1  and (concat(tipe_badan_usaha.nama_badan_usaha, ' ', pelanggan.nama_perusahaan) like '%".$filter."%' or pesan.nomor_surat like '%".$filter."%' or pesan.perihal_pesan like '%".$filter."%' or surat_oc.nomor_oc like '%".$filter."%')";
                if(isset($data_receive->from)){
                    $from = $data_receive->from;
                    if($from == 'riwayat_reminder_pembayaran_oc'){
                        $where .= " and tag = 'reminder_pembayaran_oc'";
                    }
                }
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

    public function simpan(){
        if($this->validasi_login()){
            $token = $this->input->post('token');
            $return = array();
            if($this->tokenStatus($token, 'SEND_DATA')){
				$id_pelanggan = htmlentities($this->input->post('id_pelanggan') ?? '');
				$id_dokumen_permohonan = htmlentities($this->input->post('id_dokumen_permohonan') ?? '');
				$tag = htmlentities($this->input->post('tag') ?? '');
				$nomor_surat = htmlentities($this->input->post('nomor_surat') ?? '');
				$tgl_surat = htmlentities($this->input->post('tgl_surat') ?? '');
				$perihal_pesan = htmlentities($this->input->post('perihal_pesan') ?? '');
				$isi_pesan = $this->input->post('isi_pesan');
				$user_create = $this->session->userdata('id_admin');
				$time_create = date('Y-m-d H:i:s');
				$time_update = date('Y-m-d H:i:s');
				$user_update = $this->session->userdata('id_admin');

                $data = array('id_pelanggan' => $id_pelanggan,
                            'id_dokumen_permohonan' => $id_dokumen_permohonan,
                            'tag' => $tag,
                            'nomor_surat' => $nomor_surat,
                            'tgl_surat' => $tgl_surat,
                            'perihal_pesan' => $perihal_pesan,
                            'isi_pesan' => $isi_pesan,
                            'user_create' => $user_create,
                            'time_create' => $time_create,
                            'time_update' => $time_update,
                            'user_update' => $user_update);
                    $exe = $this->pesan->save($data);
                    $return['sts'] = $exe;
                
            }

            echo json_encode($return);
        }
    }

    public function pesan_pdf($id_pesan = ''){
        if($this->validasi_login() or $this->validasi_login_pelanggan()){
            $join[0] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = pesan.id_pelanggan', 'direction' => 'left');
            $join[1] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
            $where = "pesan.active = 1 and id_pesan = '".$id_pesan."'";
            if($this->session->userdata('login_as') == 'pelanggan'){
                $where .= " and pesan.id_pelanggan = '".$this->session->userdata('id_pelanggan')."'";
            }
            $data_send = array('where' => $where, 'join' => $join);
            $load_data = $this->pesan->load_data($data_send);
            if($load_data->num_rows() > 0){
                $pesan = $load_data->row();
                $option_dateformat = array(
                    'new_delimiter' => ' ',
                    'month_type' => 'full',
                );

                ob_start();
                $html = 'No.    : '.$pesan->nomor_surat;
                $html .= '<br>Surabaya, '.$this->reformat_date($pesan->tgl_surat, $option_dateformat);
                $html .= '<br><br>';
                $html .= '<b>Kepada</b>';
                $html .= '<br><b>'.$pesan->nama_badan_usaha.' '.$pesan->nama_perusahaan.'</b>';
                $html .= '<br>'.$pesan->alamat_perusahaan;
                $html .= '<br><br>';
                $html .= 'Perihal : <span style="font-weight: bold; text-decoration: underline">'.$pesan->perihal_pesan.'</span>';
                $html .= '<br><br>';
                $html .= $pesan->isi_pesan;

                $this->setting_portrait();
                $this->pdf->writeHTML($html, true, false, true, false, '');
                $this->pdf->Output($pesan->perihal_pesan.'.pdf', 'I');
            }
            else{
                $this->lost();
            }
        }
    }
}