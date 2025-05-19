
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Surat_tugas extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('opening_meeting_model', 'opening_meeting');
        $this->load->model("Surat_tugas_model", "surat_tugas");
    }

    // public function load_data()
    // {
    //     if ($this->validasi_login()) {
    //         $data_receive = json_decode(urldecode($this->input->post('data_send')));
    //         $token = $data_receive->token;
    //         if ($this->tokenStatus($token, 'LOAD_DATA')) {
    //             $filter = (isset($data_receive->filter) ? $data_receive->filter : null);
    //             $relation[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = surat_tugas.id_opening_meeting', 'direction' => 'left');


    //             $page = $data_receive->page;
    //             $jml_data = $data_receive->jml_data;

    //             $page = (empty($page) ? 1 : $page);
    //             $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
    //             $start = ($page - 1) * $jml_data;
    //             $limit = $jml_data . ',' . $start;

    //             $where = "surat_tugas.active = 1  and opening_meeting.active = 1  and (surat_tugas.id_surat_tugas like '%" . $filter . "%' or surat_tugas.id_opening_meeting like '%" . $filter . "%' or surat_tugas.nomor_surat_tugas like '%" . $filter . "%' or surat_tugas.tgl_surat_tugas like '%" . $filter . "%' or surat_tugas.komoditi like '%" . $filter . "%' or surat_tugas.jenis_jasa like '%" . $filter . "%' or surat_tugas.tempat_pelaksanaan like '%" . $filter . "%' or surat_tugas.tgl_berangkat like '%" . $filter . "%' or surat_tugas.rencana_selesai like '%" . $filter . "%' or surat_tugas.catatan like '%" . $filter . "%' or surat_tugas.user_create like '%" . $filter . "%' or surat_tugas.time_create like '%" . $filter . "%' or surat_tugas.time_update like '%" . $filter . "%' or surat_tugas.user_update like '%" . $filter . "%' )";
    //             $send_data = array('where' => $where, 'join' => $relation, 'limit' => $limit);
    //             $load_data = $this->surat_tugas->load_data($send_data);
    //             $result = $load_data->result();

    //             #find last page...
    //             $select = "count(-1) jml";
    //             $send_data = array('where' => $where, 'join' => $relation, 'select' => $select);
    //             $load_data = $this->surat_tugas->load_data($send_data);
    //             $total_data = $load_data->row()->jml;

    //             $last_page = ceil($total_data / $jml_data);
    //             $result = array('result' => $result, 'last_page' => $last_page);

    //             echo json_encode($result);
    //         }
    //     }
    // }

    public function simpan()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_surat_tugas = htmlentities($this->input->post('id_surat_tugas') ?? '');
                $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
                $nomor_surat_tugas = htmlentities($this->input->post('nomor_surat_tugas') ?? '');
                $tgl_surat_tugas = htmlentities($this->input->post('tgl_surat_tugas') ?? '');
                $kuantitas_satuan = htmlentities($this->input->post('kuantitas_satuan') ?? '');
                $komoditi = htmlentities($this->input->post('komoditi') ?? '');
                $tempat_pelaksanaan = htmlentities($this->input->post('tempat_pelaksanaan') ?? '');
                $tgl_berangkat = htmlentities($this->input->post('tgl_berangkat') ?? '');
                $rencana_selesai = htmlentities($this->input->post('rencana_selesai') ?? '');
                $tipe_surat_tugas = htmlentities($this->input->post('tipe_surat_tugas') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $action = htmlentities($this->input->post('action') ?? '');

                $tipe_surat_tugas = ($tipe_surat_tugas ? $tipe_surat_tugas : 'opening_meeting');

                #mencari jenis jasa...
                $jenis_jasa = '';
                $id_status = '';
                $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->opening_meeting->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $opening_meeting = $load_data->row();
                    $id_status = $opening_meeting->id_status;
                    if ($opening_meeting->tipe_pengajuan == 'PEMERINTAH') {
                        $jenis_jasa = 'Inspeksi Verifikasi TKDN Berbayar Pemerintah / Non Komoditas';
                    } else {
                        $jenis_jasa = 'Inspeksi Verifikasi TKDN Berbayar Pelaku Usaha / Non Komoditas';
                    }
                }

                #jika action memiliki value 'save' maka data akan disimpan.
                #jika action tidak memiliki value, maka akan dianggap sebagai upadate.
                if ($action == 'save') {
                    $data = array(
                        'id_opening_meeting' => $id_opening_meeting,
                        'nomor_surat_tugas' => $nomor_surat_tugas,
                        'tgl_surat_tugas' => $tgl_surat_tugas,
                        'kuantitas_satuan' => $kuantitas_satuan,
                        'komoditi' => $komoditi,
                        'jenis_jasa' => $jenis_jasa,
                        'tempat_pelaksanaan' => $tempat_pelaksanaan,
                        'tgl_berangkat' => $tgl_berangkat,
                        'rencana_selesai' => $rencana_selesai,
                        'tipe_surat_tugas' => $tipe_surat_tugas,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $hasil = $this->surat_tugas->save_with_autoincrement($data);
                    $exe = $hasil[0];
                    $id_surat_tugas = $hasil[1];
                    $return['sts'] = $exe;
                    $return['id_surat_tugas'] = $id_surat_tugas;

                    if ($exe) {
                        if ($tipe_surat_tugas == 'opening_meeting') {
                            #update status ke upload surat tugas...
                            $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 3);
                        }
                    }
                } else {

                    if ($id_status == 2 and $id_surat_tugas) {
                        #bagian revisi
                        $data = array(
                            'nomor_surat_tugas' => $nomor_surat_tugas,
                            'tgl_surat_tugas' => $tgl_surat_tugas,
                            'kuantitas_satuan' => $kuantitas_satuan,
                            'komoditi' => $komoditi,
                            'jenis_jasa' => $jenis_jasa,
                            'tempat_pelaksanaan' => $tempat_pelaksanaan,
                            'tgl_berangkat' => $tgl_berangkat,
                            'rencana_selesai' => $rencana_selesai,
                            'tipe_surat_tugas' => $tipe_surat_tugas,
                            'time_update' => $time_update,
                            'user_update' => $user_update
                        );
                        $where = array('id_opening_meeting' => $id_opening_meeting, 'id_surat_tugas' => $id_surat_tugas);
                        $exe = $this->surat_tugas->update($data, $where);
                        $return['sts'] = $exe;
                        $return['id_surat_tugas'] = $id_surat_tugas;

                        if ($exe) {
                            if ($tipe_surat_tugas == 'opening_meeting') {
                                #update status ke upload surat tugas...
                                $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, 3);
                            }
                        }
                    } else {
                        $return['sts'] = 'tidak_berhak_ubah_data';
                    }
                }
            }

            echo json_encode($return);
        }
    }

    public function dokumen_pdf($id_surat_tugas = '')
    {
        if ($this->validasi_login()) {
            if ($id_surat_tugas) {
                $this->load->model('surat_tugas_model', 'surat_tugas');
                $select = "*, surat_tugas.jenis_jasa jns_jasa_surat_tugas";
                $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = surat_tugas.id_opening_meeting', 'direction' => 'left');
                $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');

                $join[2] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[3] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[4] = array('tabel' => 'surat_oc', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[5] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[6] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');

                $join[7] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[8] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

                $join[9] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
                // $join[10] = array('tabel' => 'mst_admin', 'relation' => 'opening_meeting.id_assesor = mst_admin.id_admin', 'direction' => 'left');

                $where = array('surat_tugas.active' => 1, 'id_surat_tugas' => $id_surat_tugas, 'opening_meeting.id_status >=' => 2);
                $data_send = array('select' => $select, 'where' => $where, 'join' => $join);
                $load_data = $this->surat_tugas->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $surat_tugas = $load_data->row();

                    $id_assesor = array();
                    if ($surat_tugas->tipe_surat_tugas == 'opening_meeting') {
                        $id_assesor[0] = $surat_tugas->id_assesor;
                    } else if ($surat_tugas->tipe_surat_tugas == 'survey_lapangan') {
                        $this->load->model('survey_lapangan_assesor_model', 'survey_lapangan_assesor');
                        $where_survey_lapangan = array('survey_lapangan_assesor.active' => 1, 'id_opening_meeting' => $surat_tugas->id_opening_meeting);
                        $data_send_survey_lapangan = array('where' => $where_survey_lapangan);
                        $load_data_survey_lapangan = $this->survey_lapangan_assesor->load_data($data_send_survey_lapangan);
                        if ($load_data_survey_lapangan->num_rows() > 0) {
                            $i = 0;
                            foreach ($load_data_survey_lapangan->result() as $row) {
                                $id_assesor[$i] = $row->id_admin;
                                $i++;
                            }
                        }
                    }

                    $date_option = array(
                        'new_delimiter' => ' ',
                        'month_type' => 'full'
                    );

                    $html = '';

                    $this->load->model('mst_admin_model', 'mst_admin');
                    for ($z = 0; $z < count($id_assesor); $z++) {
                        $where_admin = array('id_admin' => $id_assesor[$z]);
                        $data_send_admin = array('where' => $where_admin);
                        $load_data_admin = $this->mst_admin->load_data($data_send_admin);
                        if ($load_data_admin->num_rows() > 0) {
                            $admin = $load_data_admin->row();

                            if ($z > 0) {
                                $html .= '<br pagebreak="true"/>';
                            }
                            $html .= '<div style="text-align: right; display: block;">
                                        <img src="' . base_url() . 'assets/images/sucofindo.png" style="height: 80px;">
                                    </div>';
                            $html .= '<div style="text-align: center; display: block">
                                        <div style="font-weight: bold; font-size: 20px;">SURAT TUGAS</div>
                                    </div>';
                            $html .= '<table style="width: 100%">
                                    <tr>
                                        <td style="width: 25%">No. Order</td>
                                        <td style="width: 75%">: ' . $surat_tugas->nomor_order_payment . '</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%">No. Surat Tugas</td>
                                        <td style="width: 75%">: ' . $surat_tugas->nomor_surat_tugas . '</td>
                                    </tr>
                                    </table>';
                            $html .= '<br>';
                            $html .= '<div>Pimpinan PT Superintending Company of Indonesia:
                                    <br>Memerintahkan:</div>';
                            $html .= '<br>';
                            $html .= '<table style="width: 100%">
                                    <tr>
                                        <td style="width: 25%">Nama</td>
                                        <td style="width: 75%">: ' . $admin->nama_admin . '</td>
                                    </tr>
                                    </table>';
                            $html .= '<br>';

                            $html .= '<div>Untuk melakukan pemeriksaan atas</div>';
                            $html .= '<table style="width: 100%">
                                    <tr>
                                        <td style="width: 5%">1.</td>
                                        <td style="width: 20%">Komoditi</td>
                                        <td style="width: 75%">: ' . $surat_tugas->komoditi . '</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%">2.</td>
                                        <td style="width: 20%">Kuantitas / Satuan</td>
                                        <td style="width: 75%">: ' . $surat_tugas->kuantitas_satuan . '</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%">3.</td>
                                        <td style="width: 95%" colspan="2">Jenis Jasa / Sub Kelompok / Obyek komoditi:</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%"></td>
                                        <td style="width: 95%" colspan="2">' . $surat_tugas->jns_jasa_surat_tugas . '</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%">4.</td>
                                        <td style="width: 20%">Nama Pelanggan</td>
                                        <td style="width: 75%">: ' . $surat_tugas->nama_badan_usaha . ' ' . $surat_tugas->nama_perusahaan . '</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%">5.</td>
                                        <td style="width: 20%">Alamat</td>
                                        <td style="width: 75%">: ' . $surat_tugas->alamat_perusahaan . '</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%">6.</td>
                                        <td style="width: 20%">Rencana Berangkat</td>
                                        <td style="width: 75%">: ' . $this->reformat_date($surat_tugas->tgl_berangkat, $date_option) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%">7.</td>
                                        <td style="width: 20%">Rencana Selesai</td>
                                        <td style="width: 75%">: ' . $this->reformat_date($surat_tugas->rencana_selesai, $date_option) . '</td>
                                    </tr>
                                    </table>';
                            $html .= '<br>';
                            $html .= '<div>Harap dilaksanakan dengan sebaik-baiknya.</div>';

                            $html .= '<table style="width: 100%">
                                        <tr>
                                        <td style="70%">Catatan *)<div style="line-height: 24px">' . $this->titik_titik(261) . '</div></td>
                                        <td style="30%">
                                            <div>' . strtoupper($this->reformat_date($surat_tugas->tgl_surat_tugas, $date_option)) . '
                                            <br>Yang Memberi Tugas:</div>
                                            <table style="width: 100%">
                                                <tr>
                                                    <td style="width: 40%">Nama: </td>
                                                    <td style="width: 60%">Sholeh Hasan</td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 40%">NPP: </td>
                                                    <td style="width: 60%">04415</td>
                                                </tr>
                                            </table>
                                        </td>
                                        </tr>
                                    </table>';
                            $html .= '<div>PELAKSANAAN</div>';
                            $html .= '<table style="width: 100%">
                                    <tr>
                                    <td style="70%"><table style="width: 100%; text-align: center" border="1">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">Tanggal</th>
                                                    <th colspan="3">Jam Kerja</th>
                                                    <th rowspan="2">Disetujui Oleh</th>
                                                </tr>
                                                <tr>
                                                    <th>Mulai</th>
                                                    <th>Selesai</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><br><br><br><br><br><br><br><br></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="text-align: left;">Total Jam kerja:</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        *) - Instruksi Lapangan agar dibawa
                                    </td>
                                    <td style="30%"><table style="width: 100%" border="1">
                                            <tr>
                                                <td colspan="2">Diisi oleh pelanggan:</td>
                                            </tr>
                                            <tr>
                                                <td>Tgl Mulai</td>
                                                <td>:</td>
                                            </tr>
                                            <tr>
                                                <td>Tgl Selesai</td>
                                                <td>:</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Tanda Tangan dan Cap Perusahaan</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><br><br><br><br><br><br></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Jabatan:</td>
                                            </tr>
                                        </table>
                                    </td>
                                    </tr>
                                </table>';
                        }
                    }
                    ob_start();
                    $this->setting_portrait(false);

                    $this->pdf->SetFont('times', '', 12);
                    $this->pdf->SetAutoPageBreak(TRUE, 10);
                    $this->pdf->writeHTML($html, true, false, true, false, '');
                    $this->pdf->Output('Surat Tugas.pdf', 'I');
                } else {
                    $this->redirect(base_url() . 'page/lost');
                }
            } else {
                $this->redirect(base_url() . 'page/lost');
            }
        } else {
            $this->redirect(base_url() . 'page/lost');
        }
    }
}
