
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_detail extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Payment_detail_model", "payment_detail");
        $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);

                $select = "*, payment_detail.time_create tgl_payment_detail";
                $join[0] = array('tabel' => 'form_01', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
                $join[3] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[4] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join[5] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join[6] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
                $join[7] = array('tabel' => 'mst_admin petugas_entri', 'relation' => 'petugas_entri.id_admin = form_01.id_petugas_entri', 'direction' => 'left');

                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $where = "payment_detail.active = 1 and (surat_oc.nomor_oc like '%" . $filter . "%' or form_01.sub_unit_kerja like '%" . $filter . "%' or concat(nama_badan_usaha,' ',nama_perusahaan) like '%" . $filter . "%')";
                if ($this->is_assesor()) {
                    $where .= " and dokumen_permohonan.id_dokumen_permohonan IN (select id_dokumen_permohonan from dokumen_permohonan_pic pic where pic.active = 1 and pic.id_admin = '" . $this->session->userdata('id_admin') . "') ";
                }
                if (isset($data_receive->from)) {
                    $from = htmlentities($data_receive->from ?? '');
                    if ($from == 'verifikasi_payment_detail') {
                        $where .= " and dokumen_permohonan.status_pengajuan = 32";
                    }
                    if ($from == 'riwayat_payment_detail') {
                        $where .= " and dokumen_permohonan.status_pengajuan >= 33";
                    }
                    if ($from == 'upload_invoice_faktur_pajak') {
                        $where .= " and dokumen_permohonan.status_pengajuan = 33";
                    }
                    if ($from == 'riwayat_invoice_faktur_pajak') {
                        $where .= " and dokumen_permohonan.status_pengajuan >= 34";
                    }
                }

                $send_data = array('select' => $select, 'where' => $where, 'join' => $join, 'limit' => $limit);
                $load_data = $this->payment_detail->load_data($send_data);
                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $row) {
                        $row->assesor = $this->siapaAssesor($row->id_dokumen_permohonan);
                    }
                }
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'join' => $join, 'select' => $select);
                $load_data = $this->payment_detail->load_data($send_data);
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
                $id_payment_detail = htmlentities($this->input->post('id_payment_detail') ?? '');
                $id_dokumen_permohonan = htmlentities($this->input->post('id_dokumen_permohonan') ?? '');
                $id_form_01 = htmlentities($this->input->post('id_form_01') ?? '');
                $bidang_operasi = htmlentities($this->input->post('bidang_operasi') ?? '');
                $nomor_order_payment = htmlentities($this->input->post('nomor_order_payment') ?? '');
                $catatan = htmlentities($this->input->post('catatan') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $action = htmlentities($this->input->post('action') ?? '');

                #jika action memiliki value 'save' maka data akan disimpan.
                #jika action tidak memiliki value, maka akan dianggap sebagai upadate.
                if ($action == 'save') {
                    $data = array(
                        'id_form_01' => $id_form_01,
                        'bidang_operasi' => $bidang_operasi,
                        'nomor_order_payment' => $nomor_order_payment,
                        'catatan' => $catatan,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $exe = $this->payment_detail->save($data);
                    if ($exe) {
                        $this->simpan_log_verifikasi($id_dokumen_permohonan, 32);
                    }
                    $return['sts'] = $exe;
                } else {
                    $data = array(
                        'bidang_operasi' => $bidang_operasi,
                        'nomor_order_payment' => $nomor_order_payment,
                        'catatan' => $catatan,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where = array('id_payment_detail' => $id_payment_detail, 'id_form_01' => $id_form_01);
                    $exe = $this->payment_detail->update($data, $where);
                    if ($exe) {
                        $this->simpan_log_verifikasi($id_dokumen_permohonan, 32);
                    }
                    $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }

    public function verifikasi_payment_detail()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_dokumen_permohonan = $data_receive->id_dokumen_permohonan;

            $status_verifikasi = ($data_receive->status_verifikasi == 'setuju' ? 33 : 31);
            $alasan_verifikasi = (isset($data_receive->alasan_verifikasi) ? $data_receive->alasan_verifikasi : '');

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $exe = $this->simpan_log_verifikasi($id_dokumen_permohonan, $status_verifikasi, $alasan_verifikasi);

                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
    public function dokumen_pdf($id_payment_detail = '')
    {
        if ($this->validasi_login()) {
            if ($id_payment_detail) {
                $this->data_halaman();

                $id_payment_detail = htmlentities($id_payment_detail ?? '');
                $option_date_format = array(
                    'new_delimiter' => ' ',
                    'month_type' => 'full',
                    'date_reverse' => true,
                    'show_time' => false,
                );

                ob_start();
                $select = "*, 
                    payment_detail.catatan catatan_payment_detail,
                    payment_detail.time_create waktu_buat_payment_detail,
                    kabid.nama_admin nama_kabid, kabid.ttd_admin ttd_kabid";
                $join[0] = array('tabel' => 'form_01', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
                $join[3] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[4] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join[5] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join[6] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
                $join[7] = array('tabel' => 'mst_admin kabid', 'relation' => 'kabid.id_admin = surat_penawaran.id_kabid', 'direction' => 'left');

                $where = array('payment_detail.active' => 1, 'id_payment_detail' => $id_payment_detail);

                $data_send = array('where' => $where, 'join' => $join, 'select' => $select);
                $load_data = $this->payment_detail->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $payment_detail = $load_data->row();

                    $ttd_kabid = '<br><br><br><br><br>';
                    if ($payment_detail->status_pengajuan >= 33) {
                        $ttd_kabid = '<br><img src="' . base_url() . $payment_detail->ttd_kabid . '" style="height: 70px;">';
                    }

                    $html = '';
                    $html .= '<div style="text-align: center; font-weight: bold; font-size: 20px;">Payment Detail - Invoice</div>';
                    $html .= '<br><br><br>';
                    $html .= '<table style="font-size: 14px; line-height: 30px; text-align: justify" cellspacing="10">
                                    <tr>
                                        <td style="width: 20%">Bidang Operasi</td>
                                        <td style="width: 5%; text-align: right">:</td>
                                        <td style="width: 75%">' . $payment_detail->bidang_operasi . '</td>
                                    </tr>
                                    <tr>
                                        <td>No. Order</td>
                                        <td style="width: 5%; text-align: right">:</td>
                                        <td>' . $payment_detail->nomor_order_payment . '</td>
                                    </tr>
                                    <tr>
                                        <td>Pelanggan</td>
                                        <td style="width: 5%; text-align: right">:</td>
                                        <td>' . $payment_detail->nama_badan_usaha . ' ' . $payment_detail->nama_perusahaan . '</td>
                                    </tr>
                                    <tr>
                                        <td>Sertifikat</td>
                                        <td style="width: 5%; text-align: right">:</td>
                                        <td>' . $payment_detail->nomor_oc . '<br>Tanggal' . $this->reformat_date($payment_detail->tgl_oc, $option_date_format) . '</td>
                                    </tr>
                                    <tr>
                                        <td>Besar Tagihan</td>
                                        <td style="width: 5%; text-align: right">:</td>
                                        <td>Rp ' . $this->convertToRupiah(($payment_detail->termin_1 / 100) * $payment_detail->nilai_kontrak) . ' belum termasuk PPN 11%</td>
                                    </tr>
                                    <tr>
                                        <td>Catatan</td>
                                        <td style="width: 5%; text-align: right">:</td>
                                        <td>' . $payment_detail->catatan_payment_detail . '</td>
                                    </tr>
                                </table>';
                    $html .= '<br><br>';
                    $html .= '<table style="font-size: 14px;">
                                    <tr style="text-align: center">
                                        <td></td>
                                        <td></td>
                                        <td>
                                            ' . $this->cabang . ', ' . $this->reformat_date($payment_detail->waktu_buat_payment_detail, $option_date_format) . '
                                            ' . $ttd_kabid . '
                                            <br>(' . $payment_detail->nama_kabid . ')
                                        </td>
                                    </tr>
                                </table>';

                    $this->setting_portrait();
                    $this->pdf->writeHTML($html, true, false, true, false, '');
                    $this->pdf->Output('Surat OC.pdf', 'I');
                } else {
                    $this->redirect(base_url() . 'page/lost');
                }
            } else {
                $this->redirect(base_url() . 'page/lost');
            }
        }
    }

    var $manual_tipe_file = 'application/pdf';
    public function upload_invoice_faktur_pajak()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_payment_detail = htmlentities($this->input->post('id_payment_detail') ?? '');
                $id_dokumen_permohonan = htmlentities($this->input->post('id_dokumen_permohonan') ?? '');
                $nomor_invoice = htmlentities($this->input->post('nomor_invoice') ?? '');
                $tanggal_invoice = htmlentities($this->input->post('tanggal_invoice') ?? '');
                $nomor_faktur_pajak = htmlentities($this->input->post('nomor_faktur_pajak') ?? '');

                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $join[0] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join[1] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

                $where = array('dokumen_permohonan.active' => 1, 'status_pengajuan' => 33);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->dokumen_permohonan->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $permohonan = $load_data->row();
                    $id_pelanggan = $permohonan->id_pelanggan;
                    $nama_perusahaan = $permohonan->nama_badan_usaha . ' ' . $permohonan->nama_perusahaan;

                    $allow = true;
                    $dir_parent = 'assets/uploads/dokumen';
                    $dir = $dir_parent . '/' . $id_pelanggan;
                    #create pelanggan folder...
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                        copy($dir_parent . '/index.html', $dir . '/index.html');
                    }

                    $prefix_rename = $nama_perusahaan . '-' . date('ymd') . '-' . $this->generateRandomString(5) . '.pdf';
                    $new_name = 'dokumen-' . $id_pelanggan . '-' . date('YmdHis') . $this->generateRandomString(5);
                    $variable = array(
                        'new_name' => $new_name,
                        'dir' => $dir,
                    );

                    $invoice = '';
                    if (isset($_FILES['invoice'])) {
                        $var_dokumen_permohonan = $variable;
                        $var_dokumen_permohonan['file'] = 'invoice';
                        $result = $this->upload($var_dokumen_permohonan);
                        if ($result['sts'] == 'sukses') {
                            $rename = 'Invoice-' . $prefix_rename;
                            rename($dir . '/' . $result['file'], $dir . '/' . $rename);
                            $invoice = $dir . '/' . $rename;
                        } else {
                            $allow = false;
                            $return['sts'] = 'upload_error';
                            $return['error_msg'] = $result['msg'];
                        }
                    }

                    $faktur_pajak = '';
                    if (isset($_FILES['faktur_pajak'])) {
                        $var_dokumen_permohonan = $variable;
                        $var_dokumen_permohonan['file'] = 'faktur_pajak';
                        $result = $this->upload($var_dokumen_permohonan);
                        if ($result['sts'] == 'sukses') {
                            $rename = 'Faktur Pajak-' . $prefix_rename;
                            rename($dir . '/' . $result['file'], $dir . '/' . $rename);
                            $faktur_pajak = $dir . '/' . $rename;
                        } else {
                            $allow = false;
                            $return['sts'] = 'upload_error';
                            $return['error_msg'] = $result['msg'];
                        }
                    }

                    if ($allow) {
                        $data = array(
                            'nomor_invoice' => $nomor_invoice,
                            'tanggal_invoice' => $tanggal_invoice,
                            'invoice' => $invoice,
                            'nomor_faktur_pajak' => $nomor_faktur_pajak,
                            'faktur_pajak' => $faktur_pajak,
                            'time_update' => $time_update,
                            'user_update' => $user_update
                        );
                        $where = array('id_payment_detail' => $id_payment_detail);
                        $exe = $this->payment_detail->update($data, $where);
                        if ($exe) {
                            $this->simpan_log_verifikasi($id_dokumen_permohonan, 34);
                        }
                        $return['sts'] = $exe;
                    }
                } else {
                    $return['sts'] = 'tidak_berhak_akses_data';
                }
            }

            echo json_encode($return);
        }
    }
}
