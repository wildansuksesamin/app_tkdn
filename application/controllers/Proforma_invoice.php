
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Proforma_invoice extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Proforma_invoice_model", "proforma_invoice");
        $this->load->model('log_verifikasi_model', 'log_verifikasi');
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);
                $select = "*, proforma_invoice.tgl_awal_pelaksanaan tgl_awal_proforma_invoice, proforma_invoice.tgl_akhir_pelaksanaan tgl_akhir_proforma_invoice";
                $relation[0] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = proforma_invoice.id_surat_oc', 'direction' => 'left');
                $relation[1] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
                $relation[2] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $relation[3] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $relation[4] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $relation[5] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');

                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $where = "proforma_invoice.active = 1  and surat_oc.active = 1  and (surat_oc.nomor_oc like '%" . $filter . "%')";
                if (isset($data_receive->from)) {
                    $from = htmlentities($data_receive->from ?? '');

                    if ($from == 'riwayat_proforma_invoice') {
                        $where .= " and status_pengajuan >= 21";
                    }
                }
                $send_data = array('select' => $select, 'where' => $where, 'join' => $relation, 'limit' => $limit);
                $load_data = $this->proforma_invoice->load_data($send_data);
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'join' => $relation, 'select' => $select);
                $load_data = $this->proforma_invoice->load_data($send_data);
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
                $id_dokumen_permohonan = htmlentities($this->input->post('id_dokumen_permohonan') ?? '');
                $id_proforma_invoice = htmlentities($this->input->post('id_proforma_invoice') ?? '');
                $id_surat_oc = htmlentities($this->input->post('id_surat_oc') ?? '');
                $nomor_invoice = htmlentities($this->input->post('nomor_invoice') ?? '');
                // $tgl_proforma = htmlentities($this->input->post('tgl_proforma') ?? '');
                $tgl_awal_pelaksanaan = htmlentities($this->input->post('tgl_awal_pelaksanaan') ?? '');
                $tgl_akhir_pelaksanaan = htmlentities($this->input->post('tgl_akhir_pelaksanaan') ?? '');
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
                        'id_surat_oc' => $id_surat_oc,
                        'nomor_invoice' => $nomor_invoice,
                        // 'tgl_proforma' => $tgl_proforma,
                        'tgl_awal_pelaksanaan' => $tgl_awal_pelaksanaan,
                        'tgl_akhir_pelaksanaan' => $tgl_akhir_pelaksanaan,
                        'catatan' => $catatan,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $exe = $this->proforma_invoice->save($data);
                    if ($exe) {
                        $this->simpan_log_verifikasi($id_dokumen_permohonan, 19);
                    }
                    $return['sts'] = $exe;
                } else {
                    $data = array(
                        'id_surat_oc' => $id_surat_oc,
                        'nomor_invoice' => $nomor_invoice,
                        // 'tgl_proforma' => $tgl_proforma,
                        'tgl_awal_pelaksanaan' => $tgl_awal_pelaksanaan,
                        'tgl_akhir_pelaksanaan' => $tgl_akhir_pelaksanaan,
                        'catatan' => $catatan,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where = array('id_proforma_invoice' => $id_proforma_invoice);
                    $exe = $this->proforma_invoice->update($data, $where);
                    if ($exe) {
                        #mencari siapa yang menolak...
                        $order_log_verifikasi = "id_log_verifikasi DESC";
                        $limit_log_verifikasi = "1,1";
                        $where_log_verifikasi = array('active' => 1, 'id_dokumen_permohonan' => $id_dokumen_permohonan);
                        $data_send_log_verifikasi = array('where' => $where_log_verifikasi, 'order' => $order_log_verifikasi, 'limit' => $limit_log_verifikasi);
                        $load_data_log_verifikasi = $this->log_verifikasi->load_data($data_send_log_verifikasi);
                        if ($load_data_log_verifikasi->num_rows() > 0) {
                            $log_verifikasi = $load_data_log_verifikasi->row();
                            $this->simpan_log_verifikasi($id_dokumen_permohonan, $log_verifikasi->status_verifikasi);
                        }
                    }

                    $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }
    public function verifikasi_proforma_invoice()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_proforma_invoice = $data_receive->id_proforma_invoice;
            $id_dokumen_permohonan = $data_receive->id_dokumen_permohonan;
            $id_jns_admin = $this->session->userdata('id_jns_admin');

            if ($id_jns_admin == 5) {
                $status_verifikasi = ($data_receive->status_verifikasi == 'setuju' ? 20 : 18);
            } else if ($id_jns_admin == 7) {
                $status_verifikasi = ($data_receive->status_verifikasi == 'setuju' ? 21 : 18);
            }
            $alasan_verifikasi = (isset($data_receive->alasan_verifikasi) ? $data_receive->alasan_verifikasi : '');

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $exe = $this->simpan_log_verifikasi($id_dokumen_permohonan, $status_verifikasi, $alasan_verifikasi);

                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
    public function dokumen_pdf($id_proforma_invoice = '')
    {
        if ($this->validasi_login() or $this->validasi_login_pelanggan()) {
            if ($id_proforma_invoice) {
                $id_proforma_invoice = htmlentities($id_proforma_invoice ?? '');
                $data_halaman = $this->data_halaman();
                $option = array(
                    'new_delimiter' => ' ',
                    'month_type' => 'full',
                    'date_reverse' => true,
                    'show_time' => false,
                );

                ob_start();
                $select = "*, proforma_invoice.tgl_awal_pelaksanaan tgl_awal_proforma_invoice, proforma_invoice.tgl_akhir_pelaksanaan tgl_akhir_proforma_invoice, proforma_invoice.catatan catatan_proforma_invoice";
                $join[0] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = proforma_invoice.id_surat_oc', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[2] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[3] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join[4] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join[5] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
                $join[6] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
                $where = array('proforma_invoice.active' => 1, 'rab.active' => 1, 'id_proforma_invoice' => $id_proforma_invoice);
                if ($this->session->userdata('login_as') == 'pelanggan') {
                    $where['pelanggan.id_pelanggan'] = $this->session->userdata('id_pelanggan');
                }
                $data_send = array('where' => $where, 'join' => $join, 'select' => $select);
                $load_data = $this->proforma_invoice->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $proforma_invoice = $load_data->row();

                    $termin = $proforma_invoice->termin_1;
                    if ($termin == 0) {
                        $termin = $proforma_invoice->termin_2;
                    }

                    $fee_kegiatan = ($termin / 100) * $proforma_invoice->nilai_kontrak;
                    $ppn = (11 / 100) * $fee_kegiatan;
                    $total_setelah_pajak = $fee_kegiatan + $ppn;
                    $terbilang = $this->convertAngkaToTeks($total_setelah_pajak);

                    $this->load->model('mst_admin_model', 'mst_admin');

                    $ttd_kepkeu = '<img src="' . base_url() . 'assets/images/white.jpg" style="height: ' . $this->tinggi_ttd . ';"><br>';
                    $nama_kepkeu = '';

                    $where_kepkeu = array('id_jns_admin' => '7');
                    $data_send_kepkeu = array('where' => $where_kepkeu);
                    $load_data_kepkeu = $this->mst_admin->load_data($data_send_kepkeu);
                    if ($load_data_kepkeu->num_rows() > 0) {
                        $kepkeu = $load_data_kepkeu->row();
                        $nama_kepkeu = $kepkeu->nama_admin;

                        if (file_exists($kepkeu->ttd_admin)) {
                            $ttd_kepkeu = '<img src="' . base_url() . $kepkeu->ttd_admin . '" style="height: ' . $this->tinggi_ttd . ';"><br>';
                        } else {
                            $ttd_kepkeu = '<img src="' . base_url() . 'assets/images/no_ttd.jpg" style="height: ' . $this->tinggi_ttd . ';"><br>';
                        }
                    }

                    if ($proforma_invoice->status_pengajuan < 21) {
                        $ttd_kepkeu = '<img src="' . base_url() . 'assets/images/white.jpg" style="height:70px;">';
                    }

                    $html = '';
                    $html .= '<table>
                        <tr>
                            <td style="text-align: left;"><br><br><img src="' . base_url() . 'assets/images/IDSurvey_Utama.png" style="height: 25px;"></td>
                            <td style="text-align: center; font-size: 17px; font-weight: bold;"><br><br>PROFORMA INVOICE</td>
                            <td style="text-align: right;"><img src="' . base_url() . 'assets/images/sucofindo.png" style="height: 50px;"></td>
                        </tr>
                    </table>';
                    $html .= '<table>
                        <tr>
                            <td style="width: 49%">
                                <span style="font-weight: bold;">' . $proforma_invoice->nama_badan_usaha . ' ' . $proforma_invoice->nama_perusahaan . '</span><br>
                                <span>' . $proforma_invoice->alamat_perusahaan . '</span>
                            </td>
                            <td style="width: 2%"></td>
                            <td style="width: 49%">
                                <table>
                                    <tr>
                                        <td style="width: 28%">Kode Pelanggan</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 70%"></td>
                                    </tr>
                                    <tr>
                                        <td>No. Invoice</td>
                                        <td>:</td>
                                        <td>' . $proforma_invoice->nomor_invoice . '</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>NPWP: ' . $proforma_invoice->nomor_npwp . '</td>
                            <td></td>
                            <td>
                            <b>' . $data_halaman['nama_lengkap_perusahaan'] . '</b><br>
                            <table>
                                <tr>
                                    <td style="width: 28%">NPWP</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 70%">' . $data_halaman['npwp_perusahaan'] . '</td>
                                </tr>
                                <tr>
                                    <td>Kantor Pusat</td>
                                    <td>:</td>
                                    <td>' . $data_halaman['alamat_pusat'] . '</td>
                                </tr>
                                <tr>
                                    <td>Kantor Penerbit</td>
                                    <td>:</td>
                                    <td>Cabang ' . $data_halaman['cabang'] . '<br>' . $data_halaman['alamat'] . '</td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                    </table>';
                    $html .= '<table>
                        <tr style="">
                            <td style="width:36%; border-top: 1px solid #000; border-bottom: 1px solid #000;"><br><br>Keterangan<br></td>
                            <td style="width:2%; border-top: 1px solid #000; border-bottom: 1px solid #000;"></td>
                            <td style="width:20%; border-top: 1px solid #000; border-bottom: 1px solid #000;"></td>
                            <td style="width:2%; border-top: 1px solid #000; border-bottom: 1px solid #000;"></td>
                            <td style="width:20%; border-top: 1px solid #000; border-bottom: 1px solid #000;"></td>
                            <td style="width:20%; border-top: 1px solid #000; border-bottom: 1px solid #000;"><br><br>Jumlah<br></td>
                        </tr>
                        <tr>
                            <td>No / Tgl Order</td>
                            <td>:</td>
                            <td></td>
                            <td>/</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No. OC / No. Kontrak / Tanggal</td>
                            <td>:</td>
                            <td>' . $proforma_invoice->nomor_oc . '</td>
                            <td>/</td>
                            <td>' . $this->reformat_date($proforma_invoice->tgl_oc, $option) . '</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No. Reff : PO / WO / SPK / Tanggal</td>
                            <td>:</td>
                            <td></td>
                            <td>/</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No. / Tgl. Certificate / Report</td>
                            <td>:</td>
                            <td></td>
                            <td>/</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Kegiatan *)</td>
                            <td>:</td>
                            <td colspan="4">' . $proforma_invoice->permohonan_verifikasi . '</td>
                        </tr>
                        <tr>
                            <td>Tgl. Pelaksanaan</td>
                            <td>:</td>
                            <td colspan="4">' . $this->reformat_date($proforma_invoice->tgl_awal_proforma_invoice, $option) . ' - ' . $this->reformat_date($proforma_invoice->tgl_akhir_proforma_invoice, $option) . '</td>
                        </tr>
                        <tr>
                            <td>Fee Kegiatan</td>
                            <td>:</td>
                            <td></td>
                            <td></td>
                            <td style="text-align: center">IDR</td>
                            <td style="text-align: right">' . $this->convertToRupiah($fee_kegiatan) . '</td>
                        </tr>
                        <tr>
                            <td>Biaya Lain</td>
                            <td>:</td>
                            <td></td>
                            <td></td>
                            <td style="text-align: center">IDR</td>
                            <td style="text-align: right">-</td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td></td>
                            <td></td>
                            <td>Total</td>
                            <td></td>
                            <td style="text-align: center; border-top: 1px solid #000">IDR</td>
                            <td style="text-align: right; border-top: 1px solid #000">' . $this->convertToRupiah($fee_kegiatan) . '</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Diskon</td>
                            <td></td>
                            <td style="text-align: center">IDR</td>
                            <td style="text-align: right">-</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>DPP</td>
                            <td></td>
                            <td style="text-align: center">IDR</td>
                            <td style="text-align: right">' . $this->convertToRupiah($fee_kegiatan) . '</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>PPN</td>
                            <td></td>
                            <td style="text-align: center">IDR</td>
                            <td style="text-align: right">' . $this->convertToRupiah($ppn) . '</td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td></td>
                            <td></td>
                            <td>Total Setelah Pajak</td>
                            <td></td>
                            <td style="text-align: center; border-top: 1px solid #000">IDR</td>
                            <td style="text-align: right; border-top: 1px solid #000">' . $this->convertToRupiah($total_setelah_pajak) . '</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Reimburse</td>
                            <td></td>
                            <td style="text-align: center">IDR</td>
                            <td style="text-align: right">-</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Deposit</td>
                            <td></td>
                            <td style="text-align: center">IDR</td>
                            <td style="text-align: right">-</td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td></td>
                            <td></td>
                            <td>Grand Total</td>
                            <td></td>
                            <td style="text-align: center; border-top: 1px solid #000">IDR</td>
                            <td style="text-align: right; border-top: 1px solid #000">' . $this->convertToRupiah($total_setelah_pajak) . '</td>
                        </tr>
                    </table>';
                    $html .= '<br><br><br><table>
                        <tr>
                            <td width="48%"><b>Terbilang</b><br>' . ucwords($terbilang) . ' Rupiah<br><br>*) ' . $proforma_invoice->catatan_proforma_invoice . '</td>
                            <td width="2%"></td>
                            <td width="25%"></td>
                            <td width="25%" style="text-align: center;">' . $ttd_kepkeu . '<br>(' . $nama_kepkeu . ')</td>
                        </tr>
                    </table>';
                    $html .= '<br><br><br><Br><hr><b>CATATAN</b>';

                    if ($data_halaman['rekening_bank']->num_rows() > 0) {
                        foreach ($data_halaman['rekening_bank']->result() as $rekening_bank) {
                            $html .= '<br>Pembayaran ke rekening ' . $rekening_bank->nama_bank . '
                            <br>Nomor rekening ' . $rekening_bank->nomor_rekening . ' a.n. ' . $rekening_bank->nama_rekening;
                        }
                    }

                    $this->setting_portrait(false);
                    $this->pdf->writeHTML($html, true, false, true, false, '');

                    $this->pdf->Output('Proforma Invoice.pdf', 'I');
                } else {
                    $this->redirect(base_url() . 'page/lost');
                }
            } else {
                $this->redirect(base_url() . 'page/lost');
            }
        }
    }
}
