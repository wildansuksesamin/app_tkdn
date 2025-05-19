
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sppd_reguler extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('sppd_model', 'sppd');
        $this->load->model("Sppd_reguler_model", "sppd_reguler");
        $this->load->model('sppd_rincian_realisasi_model', 'sppd_rincian_realisasi');
        $this->load->model('mst_admin_model', 'mst_admin');
        $this->load->model('ttd_dokumen_model', 'ttd_dokumen');
    }

    public function simpan()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_sppd = htmlentities($data_receive->id_sppd ?? '');
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $nomor_sppd = htmlentities($data_receive->nomor_sppd ?? '');
                $tgl_sppd = htmlentities($data_receive->tgl_sppd ?? '');
                $nama = htmlentities($data_receive->nama ?? '');
                $tingkat_jabatan = htmlentities($data_receive->tingkat_jabatan ?? '');
                $npp = htmlentities($data_receive->npp ?? '');
                $tingkat_pangkat = htmlentities($data_receive->tingkat_pangkat ?? '');
                $jabatan = htmlentities($data_receive->jabatan ?? '');
                $mata_uang = htmlentities($data_receive->mata_uang ?? '');
                $unit_kerja = htmlentities($data_receive->unit_kerja ?? '');
                $no_rekening = htmlentities($data_receive->no_rekening ?? '');
                $biaya_perjalanan_dinas = str_replace('.', '', htmlentities($data_receive->biaya_perjalanan_dinas ?? ''));
                $tgl_bpuk = htmlentities($data_receive->tgl_bpuk ?? '');
                $biaya_bpuk = str_replace('.', '', htmlentities($data_receive->biaya_bpuk ?? ''));
                $tgl_payment = htmlentities($data_receive->tgl_payment ?? '');
                $umur_biaya = htmlentities($data_receive->umur_biaya ?? '');

                $rincian = $data_receive->rincian;
                $action = htmlentities($data_receive->action ?? '');

                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');


                if ($action == 'new') {
                    #simpan sppd...
                    $data = array(
                        'id_opening_meeting' => $id_opening_meeting,
                        'nomor_sppd' => $nomor_sppd,
                        'jns_sppd' => 'PTT Reguler',
                    );
                    $sppd = $this->sppd->save_with_autoincrement($data);
                    $id_sppd = $sppd[1];
                } else { #simpan sppd...
                    $data = array(
                        'id_opening_meeting' => $id_opening_meeting,
                        'nomor_sppd' => $nomor_sppd,
                        'jns_sppd' => 'PTT Reguler',
                    );
                    $where = array('id_sppd' => $id_sppd);
                    $this->sppd->update($data, $where);

                    #hapus rincian sppd...
                    $this->sppd_rincian_realisasi->delete($where);
                    #hapus ptt reguler...
                    $this->sppd_reguler->delete($where);
                }

                #simpan ptt reguler...
                $data = array(
                    'id_sppd' => $id_sppd,
                    'tgl_sppd' => $tgl_sppd,
                    'nama' => $nama,
                    'tingkat_jabatan' => $tingkat_jabatan,
                    'npp' => $npp,
                    'tingkat_pangkat' => $tingkat_pangkat,
                    'jabatan' => $jabatan,
                    'mata_uang' => $mata_uang,
                    'unit_kerja' => $unit_kerja,
                    'no_rekening' => $no_rekening,
                    'biaya_perjalanan_dinas' => $biaya_perjalanan_dinas,
                    'tgl_bpuk' => $tgl_bpuk,
                    'biaya_bpuk' => $biaya_bpuk,
                    'tgl_payment' => $tgl_payment,
                    'umur_biaya' => $umur_biaya,
                    'user_create' => $user_create,
                    'time_create' => $time_create,
                    'time_update' => $time_update,
                    'user_update' => $user_update
                );
                $exe = $this->sppd_reguler->save($data);

                #simpan rincian realisasi...
                $grand_total = 0;
                for ($i = 0; $i < count($rincian); $i++) {
                    $jml = str_replace('.', '', $rincian[$i]->jml);
                    $nilai = str_replace('.', '', $rincian[$i]->nilai);
                    $total = $jml * $nilai;
                    $grand_total += $total;

                    $data = array(
                        'id_sppd' => $id_sppd,
                        'komponen_sppd' => $rincian[$i]->komponen_sppd,
                        'jml' => $jml,
                        'nilai' => $nilai,
                        'total' => $total
                    );
                    $this->sppd_rincian_realisasi->save($data);
                }

                #update total sppd...
                $this->sppd->update(array('total_sppd' => $grand_total), array('id_sppd' => $id_sppd));

                if ($biaya_perjalanan_dinas > 0) {
                    $kurang_lebih = $biaya_perjalanan_dinas - $grand_total;
                    $this->sppd_reguler->update(array('kurang_lebih' => $kurang_lebih), array('id_sppd' => $id_sppd));
                } else {
                    $this->sppd_reguler->update(array('kurang_lebih' => 0), array('id_sppd' => $id_sppd));
                }

                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
    public function hapus()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_sppd = $data_receive->id_sppd;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $where = array('id_sppd' => $id_sppd);
                $exe = $this->sppd_reguler->soft_delete($where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }

    public function dokumen_pdf($id_opening_meeting = '')
    {
        if ($this->validasi_login()) {
            $token = $this->input->get('token');
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_sppd = htmlentities($this->input->get('id_sppd') ?? '');
                $id_opening_meeting = htmlentities($id_opening_meeting ?? '');

                if ($id_opening_meeting and $id_sppd) {
                    $join_sppd[0] = array('tabel' => 'sppd_reguler', 'relation' => 'sppd_reguler.id_sppd = sppd.id_sppd', 'direction' => 'left');
                    $join_sppd[1] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = sppd.id_opening_meeting', 'direction' => 'left');
                    $join_sppd[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                    $join_sppd[3] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = rab.id_dokumen_permohonan', 'direction' => 'left');
                    $join_sppd[4] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');
                    $join_sppd[5] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
                    $join_sppd[6] = array('tabel' => 'form_01', 'relation' => 'form_01.id_surat_oc = surat_oc.id_surat_oc', 'direction' => 'left');
                    $join_sppd[7] = array('tabel' => 'payment_detail', 'relation' => 'payment_detail.id_form_01 = form_01.id_form_01', 'direction' => 'left');
                    $join_sppd[8] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                    $join_sppd[9] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

                    $where_sppd = array('sppd.active' => 1, 'sppd.id_opening_meeting' => $id_opening_meeting, 'sppd.id_sppd' => $id_sppd);
                    $data_send_sppd = array('where' => $where_sppd, 'join' => $join_sppd);
                    $load_data_sppd = $this->sppd->load_data($data_send_sppd);
                    if ($load_data_sppd->num_rows() > 0) {
                        $sppd = $load_data_sppd->row();

                        $date_option = array(
                            'date_reverse' => true,
                            'new_delimiter' => ' ',
                            'month_type' => 'full'
                        );

                        $terima_kembali = '';
                        if ($sppd->kurang_lebih > 0) {
                            $terima_kembali = 'dikembalikan';
                        } else {
                            $sppd->kurang_lebih = $sppd->kurang_lebih * -1;
                            $terima_kembali = 'diterima';
                        }

                        $list_ttd = '';
                        $where_ttd_dokumen = array('ttd_dokumen.active' => 1, 'surat' => 'PTT Reguler');
                        $data_send_ttd_dokumen = array('where' => $where_ttd_dokumen);
                        $load_data_ttd_dokumen = $this->ttd_dokumen->load_data($data_send_ttd_dokumen);
                        if ($load_data_ttd_dokumen->num_rows() > 0) {
                            foreach ($load_data_ttd_dokumen->result() as $row) {
                                $list_ttd .= '<tr>
                                    <td style="text-align: center">' . $row->nama_pejabat . '</td>
                                    <td style="text-align: center">' . $row->jabatan . '</td>
                                    <td></td>
                                    <td></td>
                                </tr>';
                            }
                        }

                        $where_rincian = array('sppd_rincian_realisasi.active' => 1, 'id_sppd' => $sppd->id_sppd);
                        $data_send_rincian = array('where' => $where_rincian);
                        $load_data_rincian = $this->sppd_rincian_realisasi->load_data($data_send_rincian);
                        $rangkai_rincian = '';
                        if ($load_data_rincian->num_rows() > 0) {
                            foreach ($load_data_rincian->result() as $row) {
                                $rangkai_rincian .= '<tr>
                                    <td style="width: 45%">- ' . $row->komponen_sppd . '</td>
                                    <td style="width: 10%; text-align: center;">' . $row->jml . '</td>
                                    <td style="width: 3%">x</td>
                                    <td style="width: 20%; text-align: right;">Rp ' . $this->convertToRupiah($row->nilai) . '</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 20%; text-align: right;">Rp ' . $this->convertToRupiah($row->total) . '</td>
                                </tr>';
                                $rangkai_rincian .= '<tr>
                                    <td colspan="4" style="width: 78%">
                                        <table>
                                            <tr style="text-align: center;">
                                                <td style="border: 1px solid #000">1</td>
                                                <td style="border: 1px solid #000">0</td>
                                                <td>-</td>
                                                <td style="border: 1px solid #000">7</td>
                                                <td style="border: 1px solid #000">1</td>
                                                <td>-</td>
                                                <td style="border: 1px solid #000">0</td>
                                                <td style="border: 1px solid #000"></td>
                                                <td>-</td>
                                                <td style="border: 1px solid #000"></td>
                                                <td style="border: 1px solid #000"></td>
                                                <td>-</td>
                                                <td style="border: 1px solid #000"></td>
                                                <td style="border: 1px solid #000"></td>
                                                <td style="border: 1px solid #000"></td>
                                                <td style="border: 1px solid #000"></td>
                                                <td>-</td>
                                                <td style="border: 1px solid #000">0</td>
                                                <td style="border: 1px solid #000">0</td>
                                                <td>-</td>
                                                <td style="border: 1px solid #000"></td>
                                                <td style="border: 1px solid #000"></td>
                                                <td>-</td>
                                                <td style="border: 1px solid #000"></td>
                                                <td style="border: 1px solid #000"></td>
                                                <td style="border: 1px solid #000"></td>
                                                <td>-</td>
                                                <td style="border: 1px solid #000">0</td>
                                                <td>-</td>
                                                <td style="border: 1px solid #000">0</td>
                                                <td style="border: 1px solid #000">0</td>
                                                <td style="border: 1px solid #000">0</td>
                                                <td style="border: 1px solid #000">0</td>
                                                <td>-</td>
                                                <td style="border: 1px solid #000">0</td>
                                                <td style="border: 1px solid #000">0</td>
                                                <td style="border: 1px solid #000">0</td>
                                                <td style="border: 1px solid #000">0</td>
                                                <td style="border: 1px solid #000">0</td>
                                                <td style="border: 1px solid #000">0</td>
                                                </tr>
                                        </table>
                                    </td>
                                    <td style="width: 2%"></td>
                                    <td style="width: 20%; text-align: right;"></td>
                                </tr>';
                            }
                            $rangkai_rincian .= '<tr>
                                    <td colspan="4" style="width: 78%; text-align: right">Jumlah Pengeluaran</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 20%; text-align: right; border-top: 1px solid #000;">Rp ' . $this->convertToRupiah($sppd->total_sppd) . '</td>
                                </tr>';
                            $rangkai_rincian .= '<tr><td colspan="6">&nbsp;</td></tr>';
                            $rangkai_rincian .= '<tr>
                                    <td colspan="4" style="width: 78%">Jumlah Biaya Perjalanan Dinas Masih Harus Dipertanggungjawabkan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 20%; text-align: right;">Rp ' . $this->convertToRupiah($sppd->biaya_perjalanan_dinas) . '</td>
                                    </tr>';
                            $rangkai_rincian .= '<tr>
                                    <td colspan="4" style="width: 78%">No BPUK Biaya Perjalanan Dinas Masih Harus Dipertanggungjawabkan Tgl. ' . ($sppd->tgl_bpuk != '0000-00-00' ? $this->reformat_date($sppd->tgl_bpuk, $date_option) : '-') . '</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 20%; text-align: right;">' . ($sppd->biaya_bpuk > 0 ? 'Rp ' . $this->convertToRupiah($sppd->biaya_bpuk) : '-') . '</td>
                                </tr>';
                            $rangkai_rincian .= '<tr>
                                    <td colspan="4" style="width: 78%">Tanggal Payment: ' . ($sppd->tgl_payment != '0000-00-00' ? $this->reformat_date($sppd->tgl_payment, $date_option) : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;') . 'Umur Biaya Masih harus Dipertanggungjawabkan : ' . $sppd->umur_biaya . ' Hari *)</td>
                                    <td style="width: 2%"></td>
                                    <td style="width: 20%; text-align: right;"></td>
                                </tr>';

                            $rangkai_rincian .= '<tr>
                                <td colspan="4" style="width: 78%">Jumlah yang harus ' . $terima_kembali . '</td>
                                <td style="width: 2%">:</td>
                                <td style="width: 20%; text-align: right;">Rp ' . $this->convertToRupiah($sppd->kurang_lebih) . '</td>
                            </tr>';
                            $rangkai_rincian .= '<tr><td colspan="6">&nbsp;</td></tr>';
                            $rangkai_rincian .= '<tr><td colspan="6">Terbilang: ' . ucwords($this->convertAngkaToTeks($sppd->total_sppd)) . ' Rupiah</td></tr>';
                        }

                        $html = '';
                        $html .= '<table>
                            <tr>
                                <td style="width: 24%">
                                <img src="' . base_url() . 'assets/images/sucofindo.png" style="height: 110px;">
                                </td>
                                <td style="width: 76%; text-align: center">
                                    <div style="font-weight: bold; font-size: 17px">' . $sppd->nama_badan_usaha . ' ' . $sppd->nama_perusahaan . '
                                    <br>REALISASI BIAYA PERJALANAN DINAS (RBPD)</div>
                                    <div style="font-weight: bold;">No: ' . $sppd->nomor_sppd . '<br>Tanggal: ' . $this->reformat_date($sppd->tgl_sppd, $date_option) . '</div>
                                </td>
                            </tr>
                        </table><br>';
                        $html .= '<hr>';
                        $html .= '<table style="width: 100%">
                        <tr>
                            <td style="width:12%">Nama</td>
                            <td style="width:3%">:</td>
                            <td style="width:37%">' . $sppd->nama . '</td>
                            <td style="width:20%">Tingkat Jabatan</td>
                            <td style="width:3%">:</td>
                            <td style="width:23%">' . $sppd->tingkat_jabatan . '</td>
                        </tr>
                        <tr>
                            <td style="width:12%">NPP</td>
                            <td style="width:3%">:</td>
                            <td style="width:37%">' . $sppd->npp . '</td>
                            <td style="width:20%">Tingkat Pangkat</td>
                            <td style="width:3%">:</td>
                            <td style="width:23%">' . $sppd->tingkat_pangkat . '</td>
                        </tr>
                        <tr>
                            <td style="width:12%">Jabatan</td>
                            <td style="width:3%">:</td>
                            <td style="width:37%">' . $sppd->jabatan . '</td>
                            <td style="width:20%">Currency</td>
                            <td style="width:3%">:</td>
                            <td style="width:23%">' . $sppd->mata_uang . '</td>
                        </tr>
                        <tr>
                            <td style="width:12%">Unit Kerja</td>
                            <td style="width:3%">:</td>
                            <td style="width:37%">' . $sppd->unit_kerja . '</td>
                            <td style="width:20%">No. Rekening</td>
                            <td style="width:3%">:</td>
                            <td style="width:23%">' . $sppd->no_rekening . '</td>
                        </tr>
                        </table>';
                        $html .= '<hr>';
                        $html .= '<div style="font-weight: bold; font-size: 17px">1. RINCIAN REALISASI BIAYA PERJALANAN DINAS</div>';
                        $html .= '<table style="width: 100%" cellspacing="4">
                            ' . $rangkai_rincian . '
                        </table>';
                        $html .= '<hr>';
                        $html .= '<div style="font-weight: bold; font-size: 17px">2. PERSETUJUAN DAN TANDA TANGAN</div>';
                        $html .= '<table style="width: 100%" border="1" cellpadding="4">
                            <tr style="text-align: center">
                                <td style="width:25%; font-weight: bold; font-size: 15px;">NAMA</td>
                                <td style="width:35%; font-weight: bold; font-size: 15px;">JABATAN</td>
                                <td style="width:20%; font-weight: bold; font-size: 15px;">TANGGAL</td>
                                <td style="width:20%; font-weight: bold; font-size: 15px;">TANDA TANGAN</td>
                            </tr>
                            ' . $list_ttd . '
                        </table>';
                        $html .= 'Catatan:';
                        $html .= '<ol>
                            <li>Pengajuan baru bisa dilakukan pertanggungjawaban biaya sebelumnya telah selesai dilaksanakan;</li>
                            <li>Pertanggungjawaban biaya paling lambat dilaksanakan 14 (empat belas) hari setelah tanggal terbit BPDMHD;</li>
                            <li>Apabila setelah 21 hari hari sejak tanggal belum dipertanggungjawabkan maka akan dikenakan pemotongan gaji 100 persen dari nilai pertanggungjawaban yang bersangkutan.</li>
                        </ol>';
                        ob_start();

                        $this->setting_portrait(false);
                        $this->pdf->SetFont('helvetica', '', 11);
                        $this->pdf->writeHTML($html, true, false, true, false, '');

                        $this->pdf->Output('PTT Reguler.pdf', 'I');
                    } else {
                    }
                }
            }
        }
    }
}
