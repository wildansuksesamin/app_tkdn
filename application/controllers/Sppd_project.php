
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sppd_project extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('sppd_model', 'sppd');
        $this->load->model("Sppd_project_model", "sppd_project");
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
                $tgl_sppd = htmlentities($data_receive->tgl_sppd ?? '');
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');
                $nomor_sppd = htmlentities($data_receive->nomor_sppd ?? '');
                $tempat_pelaksanaan = htmlentities($data_receive->tempat_pelaksanaan ?? '');
                $tgl_berangkat = htmlentities($data_receive->tgl_berangkat ?? '');
                $tgl_tiba = htmlentities($data_receive->tgl_tiba ?? '');
                $jam_mulai = htmlentities($data_receive->jam_mulai ?? '');
                $jam_tiba = htmlentities($data_receive->jam_tiba ?? '');
                $uang_muka = str_replace('.', '', htmlentities($data_receive->uang_muka ?? ''));

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
                        'jns_sppd' => 'PTT Project',
                    );
                    $sppd = $this->sppd->save_with_autoincrement($data);
                    $id_sppd = $sppd[1];
                } else { #simpan sppd...
                    $data = array(
                        'id_opening_meeting' => $id_opening_meeting,
                        'nomor_sppd' => $nomor_sppd,
                        'jns_sppd' => 'PTT Project',
                    );
                    $where = array('id_sppd' => $id_sppd);
                    $this->sppd->update($data, $where);

                    #hapus rincian sppd...
                    $this->sppd_rincian_realisasi->delete($where);
                    #hapus ptt project...
                    $this->sppd_project->delete($where);
                }

                #simpan ptt project...
                $data = array(
                    'id_sppd' => $id_sppd,
                    'tgl_sppd' => $tgl_sppd,
                    'tempat_pelaksanaan' => $tempat_pelaksanaan,
                    'tgl_berangkat' => $tgl_berangkat,
                    'tgl_tiba' => $tgl_tiba,
                    'jam_mulai' => $jam_mulai,
                    'jam_tiba' => $jam_tiba,
                    'uang_muka' => $uang_muka,
                    'user_create' => $user_create,
                    'time_create' => $time_create,
                    'time_update' => $time_update,
                    'user_update' => $user_update
                );
                $exe = $this->sppd_project->save($data);

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

                if ($uang_muka > 0) {
                    $kurang_lebih = $uang_muka - $grand_total;
                    $this->sppd_project->update(array('kurang_lebih' => $kurang_lebih), array('id_sppd' => $id_sppd));
                } else {
                    $this->sppd_project->update(array('kurang_lebih' => 0), array('id_sppd' => $id_sppd));
                }

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
                    $join_sppd[0] = array('tabel' => 'sppd_project', 'relation' => 'sppd_project.id_sppd = sppd.id_sppd', 'direction' => 'left');
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

                        $tanda_tangan = array();
                        $where_ttd_dokumen = array('ttd_dokumen.active' => 1, 'surat' => 'PTT Project');
                        $data_send_ttd_dokumen = array('where' => $where_ttd_dokumen);
                        $load_data_ttd_dokumen = $this->ttd_dokumen->load_data($data_send_ttd_dokumen);
                        if ($load_data_ttd_dokumen->num_rows() > 0) {
                            $i = 0;
                            foreach ($load_data_ttd_dokumen->result() as $row) {
                                if ($i == 0) {
                                    $header = 'Menyetujui';
                                } else {
                                    $header = 'Mengetahui';
                                }
                                $tanda_tangan[$i] = array('header' => $header, 'nama' => $row->nama_pejabat, 'jabatan' => $row->jabatan);
                                $i++;
                            }
                        }


                        $date_option = array(
                            'date_reverse' => true
                        );

                        $jam_mulai_pecah = explode(':', $sppd->jam_mulai);
                        $jam_mulai = $jam_mulai_pecah[0] . ':' . $jam_mulai_pecah[1];

                        $jam_tiba_pecah = explode(':', $sppd->jam_tiba);
                        $jam_tiba = $jam_tiba_pecah[0] . ':' . $jam_tiba_pecah[1];

                        $kurang_lebih = $sppd->kurang_lebih;
                        $label = 'Kelebihan';
                        if ($kurang_lebih < 0) {
                            $kurang_lebih = $kurang_lebih * -1;
                            $label = 'Kekurangan';
                        }

                        $where_rincian = array('sppd_rincian_realisasi.active' => 1, 'id_sppd' => $sppd->id_sppd);
                        $data_send_rincian = array('where' => $where_rincian);
                        $load_data_rincian = $this->sppd_rincian_realisasi->load_data($data_send_rincian);
                        $rangkai_rincian = '';
                        if ($load_data_rincian->num_rows() > 0) {
                            foreach ($load_data_rincian->result() as $row) {
                                $rangkai_rincian .= '<tr>
                                        <td colspan="4" style="width:50%">' . $row->komponen_sppd . '</td>
                                        <td style="width: 3%">:</td>
                                        <td style="width:5%">' . $row->jml . '</td>
                                        <td style="width: 3%">x</td>
                                        <td style="width:19%; text-align: right;">Rp ' . $this->convertToRupiah($row->nilai) . '</td>
                                        <td style="width:20%; border:1px solid #000; text-align: right;">Rp ' . $this->convertToRupiah($row->total) . '</td>
                                    </tr>';
                            }
                        }

                        $html = '';
                        $html .= '<div style="text-align: right"><img src="' . base_url() . 'assets/images/sucofindo.png" style="height: 70px;"></div>';
                        $html .= '<div style="text-align: center; font-weight: bold; font-size: 19px;">RINCIAN PENGGANTI DANA OPERASI</div>';
                        $html .= '<table style="width: 100%" cellspacing="3">
                        <tr>
                            <td style="width: 25%">No. Order</td>
                            <td style="width: 3%">:</td>
                            <td style="width: 72%">' . $sppd->nomor_order_payment . '</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Nama Pelanggan</td>
                            <td style="width: 3%">:</td>
                            <td style="width: 72%">' . $sppd->nama_badan_usaha . ' ' . $sppd->nama_perusahaan . '</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Tempat Pelaksanaan</td>
                            <td style="width: 3%">:</td>
                            <td style="width: 72%">' . $sppd->tempat_pelaksanaan . '</td>
                        </tr>
                        </table>';
                        $html .= '<table style="width: 100%">
                            <tr style="font-weight: bold; text-align: center; border: 1px solid #000;">
                                <td style="width: 15%; border: 1px solid #000;">Tanggal Berangkat</td>
                                <td style="width: 15%; border: 1px solid #000;">Tanggal Tiba</td>
                                <td style="width: 10%; border: 1px solid #000;">Jam Mulai</td>
                                <td style="width: 10%; border: 1px solid #000;">Jam Tiba</td>
                                <td style="width: 30%; border: 1px solid #000;" colspan="4">Transport Antar Kota</td>
                                <td style="width: 20%; border: 1px solid #000;">Jumlah</td>
                            </tr>
                            <tr style="text-align: center">
                                <td style="border: 1px solid #000;">' . $this->reformat_date($sppd->tgl_berangkat, $date_option) . '</td>
                                <td style="border: 1px solid #000;">' . $this->reformat_date($sppd->tgl_tiba, $date_option) . '</td>
                                <td style="border: 1px solid #000;">' . $jam_mulai . '</td>
                                <td style="border: 1px solid #000;">' . $jam_tiba . '</td>
                                <td style="border: 1px solid #000;" colspan="4">-</td>
                                <td style="border: 1px solid #000;">-</td>
                            </tr>
                            ' . $rangkai_rincian . '
                            <tr>
                                <td colspan="5" style="width:80%; text-align: right;">Jumlah</td>
                                <td style="width:20%; border:1px solid #000; text-align: right;">Rp ' . $this->convertToRupiah($sppd->total_sppd) . '</td>
                            </tr>
                            <tr>
                                <td colspan="5" style="width:80%; text-align: right;">Uang Muka</td>
                                <td style="width:20%; border:1px solid #000; text-align: right;">Rp ' . $this->convertToRupiah($sppd->uang_muka) . '</td>
                            </tr>
                            <tr>
                                <td colspan="5" style="width:80%; text-align: right;">' . $label . '</td>
                                <td style="width:20%; border:1px solid #000; text-align: right;">Rp ' . $this->convertToRupiah($kurang_lebih) . '</td>
                            </tr>
                        </table><br><br>';

                        #cari Verifikator...
                        $print_html = '';
                        $where_assesor = array('mst_admin.status_admin' => 'A', 'id_jns_admin' => 2);
                        $where_assesor = "mst_admin.status_admin = 'A' and id_admin IN (select id_admin from survey_lapangan_assesor where active = 1 and id_opening_meeting = '" . $id_opening_meeting . "')";
                        $data_send_assesor = array('where' => $where_assesor);
                        $load_data_assesor = $this->mst_admin->load_data($data_send_assesor);
                        if ($load_data_assesor->num_rows() > 0) {
                            $loop = 0;
                            $i = 2;
                            foreach ($load_data_assesor->result() as $assesor) {

                                $kolom_ttd = '<table style="width:100%"><tr>';
                                for ($i = 0; $i < count($tanda_tangan); $i++) {
                                    if ($i > 0 and ($i % 3) == 0) {
                                        $kolom_ttd .= '</tr><tr>';
                                    }
                                    $kolom_ttd .= '<td style="width: 33%; text-align: center"><br><br>' . $tanda_tangan[$i]['header'] . ',<br><br><br><br><br>' . $tanda_tangan[$i]['nama'] . '<br>' . $tanda_tangan[$i]['jabatan'] . '</td>';
                                }
                                $kolom_ttd .= '<td style="width: 33%; text-align: center"><br><br>Pelaksana,<br><br><br><br><br>' . $assesor->nama_admin . '<br>Assesor</td>';

                                $kolom_ttd .= '</tr></table>';

                                $print_html .= $html . $kolom_ttd;
                                if ($loop != ($load_data_assesor->num_rows() - 1)) {
                                    $print_html .= '<br pagebreak="true"/>';
                                }

                                $loop++;
                            }
                        }

                        ob_start();

                        $this->setting_portrait(false);
                        $this->pdf->SetFont('helvetica', '', 12);
                        $this->pdf->writeHTML($print_html, true, false, true, false, '');

                        $this->pdf->Output('PTT Project.pdf', 'I');
                    } else {
                        $this->lost();
                    }
                } else {
                    $this->lost();
                }
            }
        }
    }
}
