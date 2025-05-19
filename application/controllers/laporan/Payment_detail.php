
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_detail extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model("Payment_detail_model","payment_detail");
	}
	

    public function ajax_request(){
        if($this->validasi_login()){
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if($this->tokenStatus($token, 'LOAD_DATA')){
                $tgl_awal = (isset($data_receive->tgl_awal) ? $data_receive->tgl_awal : null);
                $tgl_akhir = (isset($data_receive->tgl_akhir) ? $data_receive->tgl_akhir : null);
                $kode_jasa = (isset($data_receive->kode_jasa) ? $data_receive->kode_jasa : null);
                $jenis_permohonan = (isset($data_receive->jenis_permohonan) ? $data_receive->jenis_permohonan : null);

                $hasil = $this->load_data($tgl_awal, $tgl_akhir, $kode_jasa, $jenis_permohonan);
                echo json_encode($hasil);
            }
        }
    }
    public function download_file(){
        if($this->validasi_login()){
            $token = htmlentities($this->input->get('token') ?? '');
            if($this->tokenStatus($token, 'LOAD_DATA')){
                $type = htmlentities($this->input->get('type') ?? '');
                $tgl_awal = htmlentities($this->input->get('tgl_awal') ?? '');
                $tgl_akhir = htmlentities($this->input->get('tgl_akhir') ?? '');
                $kode_jasa = htmlentities($this->input->get('kode_jasa') ?? '');
                $jenis_permohonan = htmlentities($this->input->get('jenis_permohonan') ?? '');

                $type = ($type ? $type : '');
                $tgl_awal = ($tgl_awal ? $tgl_awal : '');
                $tgl_akhir = ($tgl_akhir ? $tgl_akhir : '');
                $kode_jasa = ($kode_jasa ? $kode_jasa : '');
                $jenis_permohonan = ($jenis_permohonan ? $jenis_permohonan : '');

                $tgl_awal_pecah = explode('-', $tgl_awal);
                $tgl_akhir_pecah = explode('-', $tgl_akhir);
                $tanggal = $this->bulan(intval($tgl_awal_pecah[1])).' '.$tgl_awal_pecah[0].' - '.$this->bulan(intval($tgl_akhir_pecah[1])).' '.$tgl_akhir_pecah[0];
                

                $date_option = array(
                    'new_delimiter' => ' ',
                    'month_type' => 'full',
                    'show_time' => false
                );

                $hasil = $this->load_data($tgl_awal, $tgl_akhir, $kode_jasa, $jenis_permohonan);
                $rangkai = '';
                if(count($hasil) > 0){
                    $no = 1;
                    
                    $grand_total = 0;
                    $total_pendapatan = 0;
                    $bulan_ini = '';
                    foreach($hasil as $list){
                        $pendapatan = ($list->termin_1 / 100) * $list->nilai_kontrak;
                        $tgl_pecah = explode('-', $list->tgl_nomor_order);

                        $bulan_ini_formated = $this->bulan(intval($tgl_pecah[1])).' '.$tgl_pecah[0];
                        if($bulan_ini != $bulan_ini_formated){
                            $bulan_ini = $bulan_ini_formated;

                            if($no != 1){
                                $rangkai .= '<tr class="fw-bold" style="text-align: right; font-weight: bold;">
                                    <td colspan="4">TOTAL '.strtoupper($bulan_ini).'</td>
                                    <td>Rp '.$this->convertToRupiah($total_pendapatan).'</td>
                                </tr>';
                                $total_pendapatan = 0;
                            }
                        }

                        $total_pendapatan += $pendapatan;
                        $grand_total += $pendapatan;
                        $rangkai .= '<tr>
                            <td>'.$no.'</td>
                            <td>'.$this->reformat_date($list->tgl_nomor_order, $date_option).'</td>
                            <td>'.$list->nama_badan_usaha.' '.$list->nama_perusahaan.'</td>
                            <td>'.$list->kode_jasa.'</td>
                            <td style="text-align: right">Rp '.$this->convertToRupiah($pendapatan).'</td>
                        </tr>';
                        $no++;
                    }
                    
                    $rangkai .= '<tr class="fw-bold" style="text-align: right; font-weight: bold;">
                        <td colspan="4">TOTAL '.strtoupper($bulan_ini).'</td>
                        <td>Rp '.$this->convertToRupiah($total_pendapatan).'</td>
                    </tr>';
                    
                    $rangkai .= '<tr class="fw-bold" style="text-align: right; font-weight: bold;">
                        <td colspan="4">GRAND TOTAL</td>
                        <td>Rp '.$this->convertToRupiah($grand_total).'</td>
                    </tr>';
                }
                else{
                    $rangkai = '<tr><td colspan="5">TIDAK ADA</td></tr>';
                }

                $html = '<div style="text-align: center; font-weight: bold; font-size: 15px;">LAPORAN PENDAPATAN</div>';
                $html .= '<table style="width: 100%">
                <tr>
                    <td style="width: 20%">Tanggal</td>
                    <td>: '.$tanggal.'</td>
                </tr>
                <tr>
                    <td>Kode Sub Unit</td>
                    <td>: '.($kode_jasa ? $kode_jasa : '-').'</td>
                </tr>
                <tr>
                    <td>Jenis Peromohonan</td>
                    <td>: '.($jenis_permohonan ? $jenis_permohonan : '-').'</td>
                </tr>
                </table>';
                $html .= '<table border="1" cellpadding="3">
                    <tr style="font-weight: bold; text-align: center;">
                        <td style="width: 7%;">No.</td>
                        <td style="width: 20%;">Tgl Nomor Order</td>
                        <td style="width: 42%;">Pelanggan</td>
                        <td style="width: 10%;">Kode</td>
                        <td style="width: 20%;">Pendapatan</td>
                    </tr>
                    '.$rangkai.'
                </table>';

                if($type == 'pdf'){
                    ob_start();
                    $this->setting_portrait(true);
                    $this->pdf->writeHTML($html, true, false, true, false, '');
    
                    $this->pdf->Output('Laporan pendapatan.pdf', 'I');
                }
                else if($type == 'excel'){
                    header('Content-type: application/x-msdownload; charset=utf-16');
                    header('Content-Disposition: attachment; filename=Laporan pendapatan.xls');
                    header('Pragma: no-cache');
                    header('Expires: 0');
                    echo $html;
                }
            }
        }
    }

    function load_data($tgl_awal, $tgl_akhir, $kode_jasa = '', $jenis_permohonan = ''){
        $id_jns_admin = $this->session->userdata('id_jns_admin');
        $id_admin = $this->session->userdata('id_admin');

        $join[0] = array('tabel' => 'form_01', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');
        $join[1] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
        $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
        $join[3] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
        $join[4] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
        $join[5] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
        $join[6] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

        $where = "payment_detail.active = 1";
        if($tgl_awal){
            $tgl_awal = $tgl_awal.'-01';
            $where .= " and date_format(payment_detail.time_create, '%Y-%m-%d') >= '".$tgl_awal."'";
        }
        if($tgl_akhir){
            $tgl_akhir = $tgl_akhir.date('t',strtotime($tgl_akhir.'-01'));
            $where .= " and date_format(payment_detail.time_create, '%Y-%m-%d') <= '".$tgl_akhir."'";
        }
        if($kode_jasa){
            $where .= " and kode_jasa = '".$kode_jasa."'";
        }
        if($id_jns_admin == '3'){
            $where .= " and dokumen_permohonan.id_dokumen_permohonan IN (select id_dokumen_permohonan from dokumen_permohonan_pic where dokumen_permohonan_pic.active = 1 and id_admin = '".$id_admin."')";
        }
        $select = "*, payment_detail.time_create tgl_nomor_order";
        $send_data = array('where' => $where, 'join' => $join, 'select' => $select);
        $load_data = $this->payment_detail->load_data($send_data);
        $result = $load_data->result();

        return $result;
    }
}