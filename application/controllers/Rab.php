<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rab extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Rab_model", "rab");
        $this->load->model("Rab_detail_model", "rab_detail");
        $this->load->model("dokumen_permohonan_pic_model", "dokumen_permohonan_pic");
        $this->load->model("surat_penawaran_model", "surat_penawaran");
        $this->load->model("rekening_bank_model", "rekening_bank");
        $this->load->model('kriteria_verifikasi_bmp_model', 'kriteria_verifikasi_bmp');
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);
                $relation[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $relation[1] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $relation[2] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                $relation[3] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');

                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $order = "id_rab DESC";

                $where = "rab.active = 1  and dokumen_permohonan.active = 1  and (concat(nama_badan_usaha, ' ', nama_perusahaan) like '%" . $filter . "%' or rab.nama_produk_jasa like '%" . $filter . "%')";
                if (isset($data_receive->from)) {
                    if ($data_receive->from == 'approval_rab') {
                        $where .= " and dokumen_permohonan.status_pengajuan = '5' and id_koordinator = '" . $this->session->userdata('id_admin') . "'";
                    }
                    if ($data_receive->from == 'rab_ditolak') {
                        $where .= " and dokumen_permohonan.status_pengajuan = '6' and id_assesor = '" . $this->session->userdata('id_admin') . "'";
                    }
                    if ($data_receive->from == 'buat_penawaran') {
                        $where .= " and dokumen_permohonan.status_pengajuan IN (7,9)";
                    }
                    if ($data_receive->from == 'verifikasi_surat_penawaran') {
                        $where .= " and dokumen_permohonan.status_pengajuan = '8'";

                        if ($this->session->userdata('id_jns_admin') == 2) {
                            $where .= " and (select count(-1) jml from surat_penawaran where active = 1 and butuh_verifikasi_koordinator = 1 and surat_penawaran.id_rab = rab.id_rab) = 1";
                        } else if ($this->session->userdata('id_jns_admin') == 5) {
                            $where .= " and (select count(-1) jml from surat_penawaran where active = 1 and butuh_verifikasi_koordinator = 0 and surat_penawaran.id_rab = rab.id_rab) = 1";
                        }
                    }
                }


                $send_data = array('where' => $where, 'join' => $relation, 'limit' => $limit, 'order' => $order);
                $load_data = $this->rab->load_data($send_data);
                $result = $load_data->result();
                if (isset($data_receive->from)) {
                    if ($load_data->num_rows() > 0) {
                        foreach ($load_data->result() as $list) {
                            $list->assesor = $this->siapaAssesor($list->id_dokumen_permohonan);

                            if ($data_receive->from == 'buat_penawaran') {
                                #mencari status surat penawaran...
                                $where_surat_penawaran = array('active' => 1, 'id_rab' => $list->id_rab);
                                $data_send_surat_penawaran = array('where' => $where_surat_penawaran);
                                $load_data_surat_penawaran = $this->surat_penawaran->load_data($data_send_surat_penawaran);

                                $list->surat_penawaran = $load_data_surat_penawaran->row();
                            }
                        }
                    }
                }

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'join' => $relation, 'select' => $select);
                $load_data = $this->rab->load_data($send_data);
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
                $id_rab = htmlentities($this->input->post('id_rab') ?? '');
                $id_dokumen_permohonan = htmlentities($this->input->post('id_dokumen_permohonan') ?? '');
                $id_assesor = htmlentities($this->input->post('id_assesor') ?? '');
                $id_koordinator = htmlentities($this->input->post('id_koordinator') ?? '');
                $nama_produk_jasa = htmlentities($this->input->post('nama_produk_jasa') ?? '');
                $nama_produk_jasa = preg_replace('/\s+/', ' ', $nama_produk_jasa);

                $lokasi = htmlentities($this->input->post('lokasi') ?? '');
                $lokasi = preg_replace('/\s+/', ' ', $lokasi);

                $jml_produk_jasa = htmlentities($this->input->post('jml_produk_jasa') ?? '');
                $jml_perhitungan = htmlentities($this->input->post('jml_perhitungan') ?? '');
                $jml_hari_kerja = htmlentities($this->input->post('jml_hari_kerja') ?? '');
                $total_biaya_operasional = $this->input->post('total_biaya_operasional');
                $nilai_kontrak = $this->input->post('nilai_kontrak');
                $profit_operasional = $this->input->post('profit_operasional');
                $profit_persentase = $this->input->post('profit_persentase');
                $harga_per_produk = $this->input->post('harga_per_produk');
                $harga_per_perhitungan = $this->input->post('harga_per_perhitungan');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $action = htmlentities($this->input->post('action') ?? '');

                #jika action memiliki value 'save' maka data akan disimpan.
                #jika action tidak memiliki value, maka akan dianggap sebagai upadate.
                if ($action == 'save') {
                    $data = array(
                        'id_dokumen_permohonan' => $id_dokumen_permohonan,
                        'id_assesor' => $id_assesor,
                        'id_koordinator' => $id_koordinator,
                        'tgl_penyusunan_rab' => date('Y-m-d H:i:s'),
                        'nama_produk_jasa' => $nama_produk_jasa,
                        'lokasi' => $lokasi,
                        'jml_produk_jasa' => $jml_produk_jasa,
                        'jml_perhitungan' => $jml_perhitungan,
                        'jml_hari_kerja' => $jml_hari_kerja,
                        'profit_persentase' => $this->convertToAngka($profit_persentase),
                        'harga_per_produk' => $this->convertToAngka($harga_per_produk),
                        'harga_per_perhitungan' => $this->convertToAngka($harga_per_perhitungan),
                        'total_biaya_operasional' => $this->convertToAngka($total_biaya_operasional),
                        'nilai_kontrak' => $this->convertToAngka($nilai_kontrak),
                        'profit_operasional' => $this->convertToAngka($profit_operasional),
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $result = $this->rab->save_with_autoincrement($data);
                    $exe = $result[0];
                    $id_rab = $result[1];
                    if ($exe) {
                        $this->simpan_log_verifikasi($id_dokumen_permohonan, 5);
                        #hapus pic...
                        $data_hapus = array(
                            'id_dokumen_permohonan' => $id_dokumen_permohonan,
                            'id_admin' => $id_koordinator
                        );
                        $this->dokumen_permohonan_pic->delete($data_hapus);
                        #tambahkan PIC
                        $data_pic = array(
                            'id_dokumen_permohonan' => $id_dokumen_permohonan,
                            'id_admin' => $id_koordinator,
                            'user_create' => $user_create,
                            'time_create' => $time_create,
                            'time_update' => $time_update,
                            'user_update' => $user_update
                        );
                        $this->dokumen_permohonan_pic->save($data_pic);

                        $this->simpan_detail($id_rab);
                    }
                    $return['sts'] = $exe;
                } else {
                    $data = array(
                        'nama_produk_jasa' => $nama_produk_jasa,
                        'jml_produk_jasa' => $jml_produk_jasa,
                        'jml_perhitungan' => $jml_perhitungan,
                        'lokasi' => $lokasi,
                        'jml_hari_kerja' => $jml_hari_kerja,
                        'profit_persentase' => $this->convertToAngka($profit_persentase),
                        'harga_per_produk' => $this->convertToAngka($harga_per_produk),
                        'harga_per_perhitungan' => $this->convertToAngka($harga_per_perhitungan),
                        'total_biaya_operasional' => $this->convertToAngka($total_biaya_operasional),
                        'nilai_kontrak' => $this->convertToAngka($nilai_kontrak),
                        'profit_operasional' => $this->convertToAngka($profit_operasional),
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where = array('id_rab' => $id_rab);
                    $exe = $this->rab->update($data, $where);
                    if ($exe) {
                        $this->simpan_log_verifikasi($id_dokumen_permohonan, 5);
                        $where_delete = array('id_rab' => $id_rab);
                        $this->rab_detail->delete($where_delete);

                        $this->simpan_detail($id_rab);
                    }
                    $return['sts'] = $exe;
                }
            }
            echo json_encode($return);
        }
    }
    function simpan_detail($id_rab)
    {
        $user_create = $this->session->userdata('id_admin');
        $time_create = date('Y-m-d H:i:s');
        $time_update = date('Y-m-d H:i:s');
        $user_update = $this->session->userdata('id_admin');

        #simpan detail rab...
        $uraian_kegiatan_list = $this->input->post('uraian_kegiatan');
        $satuan_list = $this->input->post('satuan');
        $orang_unit_list = $this->input->post('org_unit');
        $hari_kali_list = $this->input->post('hari_kali');
        $biaya_list = $this->input->post('biaya');
        $total_biaya_list = $this->input->post('total_biaya');

        for ($i = 0; $i < count($uraian_kegiatan_list); $i++) {
            $uraian_kegiatan = htmlentities($uraian_kegiatan_list[$i] ?? '');
            $satuan = htmlentities((isset($satuan_list[$i]) ? $satuan_list[$i] : ''));
            $orang_unit = htmlentities((isset($orang_unit_list[$i]) ? $orang_unit_list[$i] : ''));
            $hari_kali = htmlentities((isset($hari_kali_list[$i]) ? $hari_kali_list[$i] : ''));
            $biaya = htmlentities((isset($biaya_list[$i]) ? $biaya_list[$i] : ''));
            $total_biaya = htmlentities((isset($total_biaya_list[$i]) ? $total_biaya_list[$i] : ''));

            #simpan...
            $data_detail = array(
                'id_rab' => $id_rab,
                'uraian_kegiatan' => $uraian_kegiatan,
                'satuan' => $satuan,
                'orang_unit' => $orang_unit,
                'hari_kali' => $hari_kali,
                'biaya' => $this->convertToAngka($biaya),
                'total_biaya' => $this->convertToAngka($total_biaya),
                'user_create' => $user_create,
                'time_create' => $time_create,
                'time_update' => $time_update,
                'user_update' => $user_update
            );
            $this->rab_detail->save($data_detail);
        }
    }
    public function verifikasi_rab()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_rab = $data_receive->id_rab;
            if ($data_receive->status_verifikasi == 'setuju') {
                $status_verifikasi = 7;
            } else {
                $status_verifikasi = 6;
            }
            $alasan_verifikasi = (isset($data_receive->alasan_verifikasi) ? $data_receive->alasan_verifikasi : '');

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $where = array('active' => 1, 'id_rab' => $id_rab);
                $data_send = array('where' => $where);
                $load_data = $this->rab->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $rab = $load_data->row();
                    $id_dokumen_permohonan = $rab->id_dokumen_permohonan;
                    $exe = $this->simpan_log_verifikasi($id_dokumen_permohonan, $status_verifikasi, $alasan_verifikasi);
                    $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }
    public function hapus()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_rab = $data_receive->id_rab;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $where = array('id_rab' => $id_rab);
                $exe = $this->rab->soft_delete($where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }

    public function surat_penawaran($id_rab = '')
    {
        if ($this->validasi_login() or $this->validasi_login_pelanggan()) {
            if ($id_rab) {
                $halaman = $this->data_halaman();

                ob_start();
                $this->load->model("surat_penawaran_model", "surat_penawaran");
                $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join[2] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join[3] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
                $where = array('surat_penawaran.active' => 1, 'rab.active' => 1, 'surat_penawaran.id_rab' => $id_rab);
                if ($this->session->userdata('login_as') == 'pelanggan') {
                    $where['pelanggan.id_pelanggan'] = $this->session->userdata('id_pelanggan');
                }
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->surat_penawaran->load_data($data_send);
            //var_dump($this->db->last_query());
                if ($load_data->num_rows() > 0) {
                    $surat_penawaran = $load_data->row();

                    #find id_kabid...
                    $this->load->model("mst_admin_model", "admin");
                    $ttd_kabid = '<img src="' . base_url() . 'assets/images/white.jpg" style="height: ' . $this->tinggi_ttd . ';"><br>';
                    $nama_admin = '                 ';
                    $jabatan_admin = 'Kabid Inspeksi Government';

                    $where_admin = array('mst_admin.id_jns_admin' => 5);
                    if ($surat_penawaran->id_kabid) {
                        $where_admin['id_admin'] = $surat_penawaran->id_kabid;
                    }
                    $join_admin[0] = array('tabel' => 'jns_admin', 'relation' => 'jns_admin.id_jns_admin = mst_admin.id_jns_admin', 'direction' => 'left');
                    $data_send_admin = array('where' => $where_admin, 'join' => $join_admin);
                    $load_data_admin = $this->admin->load_data($data_send_admin);
                    if ($load_data_admin->num_rows() > 0) {
                        $admin = $load_data_admin->row();

                        $nama_admin = $admin->nama_admin;
                        if ($admin->ttd_admin != '' and $surat_penawaran->id_kabid) {
                            if (file_exists($admin->ttd_admin)) {
                                $ttd_kabid = '<img src="' . base_url() . $admin->ttd_admin . '" style="height: ' . $this->tinggi_ttd . ';"><br>';
                            } else {
                                $ttd_kabid = '<img src="' . base_url() . 'assets/images/no_ttd.jpg" style="height: ' . $this->tinggi_ttd . ';"><br>';
                            }
                        }
                    }

                    $option = array(
                        'new_delimiter' => ' ',
                        'month_type' => 'full',
                        'date_reverse' => 'true',
                    );

                    $html = '<div style="text-align: justify">';

                    $html .= '<span>Nomor: ' . $surat_penawaran->nomor_surat_penawaran . '</span><br>';
                    $html .= '<span>Surabaya, ' . $this->reformat_date($surat_penawaran->tgl_surat_penawaran, $option) . '</span><br>';
                    $html .= '<br>';
                    $html .= '<span>Kepada Yth.</span><br>';
                    $html .= '<span style="font-weight: bold">' . $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan . '</span><br>';
                    $html .= '<span>' . $surat_penawaran->alamat_perusahaan . '</span><br>';
                    $html .= '<br>';
                    $html .= '<span>U.P. Bapak/Ibu ' . $surat_penawaran->nama_up . '</span><br>';
                    $html .= '<br>';
                    $html .= '<span>Perihal: <span style="font-weight: bold; text-decoration: underline">Penawaran Harga Pekerjaan ' . $surat_penawaran->permohonan_verifikasi . '</span></span><br>';
                    $html .= '<br>';
                    $html .= '<span>Dengan hormat,</span><br>';

                    if ($surat_penawaran->jns_surat_penawaran == 'barang') {
                        $html .= $this->surat_penawaran_barang($surat_penawaran);
                    } else if ($surat_penawaran->jns_surat_penawaran == 'gabungan') {
                        $html .= $this->surat_penawaran_gabungan($surat_penawaran);
                    } else if ($surat_penawaran->jns_surat_penawaran == 'budgetary') {
                        $html .= $this->surat_penawaran_budgetary($surat_penawaran);
                    } else if ($surat_penawaran->jns_surat_penawaran == 'bmp') {
                        $html .= $this->surat_penawaran_bmp($surat_penawaran);
                    }

                    $html .= 'Demikian, atas kerja sama bapak/ibu kami ucapkan terima kasih.<br>';
                    $html .= '<br>';
                    $html .= 'Hormat kami,<br>';
                    $html .= $ttd_kabid;
                    $html .= '<span style="font-weight: bold; text-decoration: underline">' . $nama_admin . '</span><br>';
                    $html .= '<span style="font-weight: bold;">' . $jabatan_admin . '</span><br>';

                    $html .= '</div>';


                    $this->setting_portrait(true);
                    $this->pdf->writeHTML($html, true, false, true, false, '');

                    $jml_halaman = $this->pdf->getNumPages();

                    if ($jml_halaman > 1) {
                        $this->pdf->deletePage(1);
                        $this->pdf->deletePage(1);
                        $html_pecah = explode('[split_here]', $html);
                        for ($i = 0; $i < count($html_pecah); $i++) {
                            $this->pdf->AddPage('P', 'A4', false, false);
                            $this->pdf->writeHTML($html_pecah[$i], true, false, true, false, '');
                        }
                    } else {
                        $this->pdf->deletePage(1);
                        $html = str_replace('[split_here]', '', $html);
                        $this->pdf->AddPage('P', 'A4', false, false);
                        $this->pdf->writeHTML($html, true, false, true, false, '');
                    }


                    $this->pdf->Output('Surat Penawaran.pdf', 'I');
                } else {
                    $this->redirect(base_url() . 'page/lost');
                }
            } else {
                $this->redirect(base_url() . 'page/lost');
            }
        }
    }

    function kalimat_transport($status_transport_akomodasi, $perusahaan, $jns_surat_penawaran = '')
    {

        $kalimat_ada_transport = '';
        #0 = Dengan survey vendor dan lapangan, 
        #1 = Tanpa survey vendor
        #2 = Tanpa survey vendor dan lapangan, 
        if ($status_transport_akomodasi == 1) {
            $kalimat_ada_transport = '<li>Biaya Transportasi dan Akomodasi survey proses produksi</li>
                <li>Biaya Transportasi dan Akomodasi survey vendor sampai dengan layer ke-2 menjadi tanggung jawab dan atau beban biaya untuk <b>' . $perusahaan . '</b></li>';
        } else if ($status_transport_akomodasi == 2) {
            $kalimat_ada_transport = '<li>Biaya Transportasi dan Akomodasi survey proses produksi dan survey vendor sampai dengan layer ke-2 menjadi tanggung jawab dan atau beban biaya untuk <b>' . $perusahaan . '</b></li>';
        } else {
            if ($jns_surat_penawaran == 'bmp') {
                $kalimat_ada_transport = '<li>Biaya transportasi dan akomodasi survey dan kunjungan lapangan</li>';
            } else {
                $kalimat_ada_transport = '<li>Biaya Transportasi dan Akomodasi survey proses produksi</li>
                <li>Biaya Transportasi dan Akomodasi survey vendor sampai dengan layer ke-2</li>';
            }
        }

        return $kalimat_ada_transport;
    }
    function tabel_rekening()
    {
        $rekening_bank = '';
        $where = array('active' => 1);
        $data_send = array('where' => $where);
        $load_data = $this->rekening_bank->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            foreach ($load_data->result() as $row) {
                $rekening_bank .= '<table style="width: 100%; font-weight: bold">
                                    <tr>
                                        <td style="width: 20%;">Nama Rekening</td>
                                        <td>: ' . $row->nama_rekening . '</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%;">Pemilik Rekening</td>
                                        <td>: ' . $row->pemilik_rekening . '</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%;">Nomor Rekening</td>
                                        <td>: ' . $row->nomor_rekening . '</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%;">Nama Bank</td>
                                        <td>: ' . $row->nama_bank . '</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%;">Cabang</td>
                                        <td>: ' . $row->kantor_cabang . '</td>
                                    </tr>
                                </table>';
            }
        }
        return $rekening_bank;
    }
    function kalimat_termin($surat_penawaran)
    {
        if ($surat_penawaran->termin_1 == 100) {
            $pembayaran_termin = '<li>Pembayaran sebesar <b>' . $surat_penawaran->termin_1 . '% (' . strtolower($this->convertAngkaToTeks($surat_penawaran->termin_1)) . ' Persen)</b> dari nilai kontrak dan pembayaran termin I tidak dapat dilakukan pengembalian.</li>';
        } else if ($surat_penawaran->termin_2 == 100) {
            $pembayaran_termin = '<li>Pembayaran sebesar <b>' . $surat_penawaran->termin_2 . '% (' . strtolower($this->convertAngkaToTeks($surat_penawaran->termin_2)) . ' Persen)</b> dari nilai kontrak setelah hasil verifikasi <b>' . ($surat_penawaran->jns_surat_penawaran == 'bmp' ? 'BMP' : 'TKDN') . '</b> selesai/laporan pekerjaan verfikasi <b>' . ($surat_penawaran->jns_surat_penawaran == 'bmp' ? 'BMP' : 'TKDN') . '</b> telah diterima.</li>';
        } else {
            $pembayaran_termin = '<li>Pembayaran <b>Termin I</b> sebesar <b>' . $surat_penawaran->termin_1 . '% (' . strtolower($this->convertAngkaToTeks($surat_penawaran->termin_1)) . ' Persen)</b> dari nilai kontrak dan pembayaran termin I tidak dapat dilakukan pengembalian.</li>';
            $pembayaran_termin .= '<li>Pembayaran <b>Termin II (Pelunasan)</b> sebesar <b>' . $surat_penawaran->termin_2 . '% (' . strtolower($this->convertAngkaToTeks($surat_penawaran->termin_2)) . ' Persen)</b> dari nilai kontrak setelah hasil verifikasi <b>' . ($surat_penawaran->jns_surat_penawaran == 'bmp' ? 'BMP' : 'TKDN') . '</b> selesai/laporan pekerjaan verfikasi <b>' . ($surat_penawaran->jns_surat_penawaran == 'bmp' ? 'BMP' : 'TKDN') . '</b> telah diterima.</li>';
        }

        return $pembayaran_termin;
    }

    function surat_penawaran_barang($surat_penawaran)
    {
        $rekening_bank = $this->tabel_rekening();

        #kalimat pembayaran termin...
        $pembayaran_termin = $this->kalimat_termin($surat_penawaran);

        #cek apakah pengajuan BMP atau tidak...
        $layer_2 = '<li>Survey vendor sampai dengan <i>layer</i> ke-2;</li>';
        if ($surat_penawaran->id_tipe_permohonan == 5) { #pengajuan BMP
            $layer_2 = '';
        }

        $kalimat_ada_transport = $this->kalimat_transport($surat_penawaran->status_transport_akomodasi, $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan);

        #mencari lama verifikasi dokumen..
        $lama_verifikasi_dokumen = $surat_penawaran->jml_hari_kerja;

        $html = '';
        $html .= 'Menindaklanjuti surat bapak/ibu Nomor ' . $surat_penawaran->nomor_surat_permohonan . ' perihal Permohonan Verifikasi ' . $surat_penawaran->permohonan_verifikasi . ', dengan ini kami sampaikan ruang lingkup dan tarif jasa atas pekerjaan dimaksud :';
        $html .= '<ol type="A">
                    <li>Ruang Lingkup Pekerjaan
                        <ol type="1">
                            <li>Survey proses produksi <b>' . $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan . '</b>;</li>
                            ' . $layer_2 . '
                            <li>Verifikasi dokumen;</li>
                            <li>Pelaporan hasil verifikasi;</li>
                        </ol>
                    </li>
                    <li>Tarif jasa untuk pekerjaan diatas adalah <b>Rp ' . $this->convertToRupiah($surat_penawaran->nilai_kontrak) . ' (' . strtolower($this->convertAngkaToTeks($surat_penawaran->nilai_kontrak)) . ' Rupiah) <span style="text-decoration: underline">belum termasuk PPN 12%</span></b> dengan rincian sebagai berikut :
                        <ol type="1">
                            <li>Verifikasi untuk produk : 
                                <ul>
                                    <li><b>Sesuai dengan lampiran surat permohonan bapak/ibu nomor ' . $surat_penawaran->nomor_surat_permohonan . ' (Rincian Produk: ' . $surat_penawaran->rincian_produk_pekerjaan . ')</b></li>                                
                                </ul>
                            </li>
                            <li>' . ($surat_penawaran->point_b2 ?? 'Pelaporan') . '</li>
                            ' . $kalimat_ada_transport . '
                        </ol>
                    </li>
                    <li><i>Term of payment</i> tarif jasa diatas sebagai berikut :
                        <ol type="1">
                            ' . $pembayaran_termin . '
                           <li>Pembayaran dapat ditransfer ke rekening:<br>' . $rekening_bank . '</li>
                        </ol>
                    </li>
                </ol>
                [split_here]
                <ol type="A" start="4">
                    <li>Waktu pelaksanaan pekerjaan selama <b>' . $lama_verifikasi_dokumen . ' (' . strtolower($this->convertAngkaToTeks($lama_verifikasi_dokumen)) . ')</b> hari kerja <b>setelah dokumen lengkap</b>.</li>
                    <li>Surat penawaran ini berlaku selama <b>' . $surat_penawaran->masa_berlaku_penawaran . ' (' . strtolower($this->convertAngkaToTeks($surat_penawaran->masa_berlaku_penawaran)) . ')</b> hari kalender.</li>
                </ol>';
        return $html;
    }
    function surat_penawaran_gabungan($surat_penawaran)
    {
        $rekening_bank = $this->tabel_rekening();

        #kalimat pembayaran termin...
        $pembayaran_termin = $this->kalimat_termin($surat_penawaran);

        #cek apakah pengajuan BMP atau tidak...
        $layer_2 = '<li>Survey vendor sampai dengan <i>layer</i> ke-2;</li>';
        if ($surat_penawaran->id_tipe_permohonan == 5) { #pengajuan BMP
            $layer_2 = '';
        }

        #cek apakah transportasi ditanggung perusahaan atau tidak...
        $kalimat_ada_transport = $this->kalimat_transport($surat_penawaran->status_transport_akomodasi, $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan);

        #mencari lama verifikasi dokumen..
        $lama_verifikasi_dokumen = $surat_penawaran->jml_hari_kerja;

        $html = '';
        $html .= 'Menindaklanjuti surat bapak/ibu Nomor ' . $surat_penawaran->nomor_surat_permohonan . ' perihal Permohonan Verifikasi ' . $surat_penawaran->permohonan_verifikasi . ', dengan ini kami sampaikan ruang lingkup dan tarif jasa atas pekerjaan dimaksud :';
        $html .= '<ol type="A">
                    <li>Ruang Lingkup Pekerjaan
                        <ol type="1">
                            <li>Survey proses produksi <b>' . $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan . '</b>;</li>
                            ' . $layer_2 . '
                            <li>Verifikasi dokumen;</li>
                            <li>Pelaporan hasil verifikasi;</li>
                        </ol>
                    </li>
                    <li>Tarif jasa untuk pekerjaan diatas adalah <b>Rp ' . $this->convertToRupiah($surat_penawaran->nilai_kontrak) . ' (' . strtolower($this->convertAngkaToTeks($surat_penawaran->nilai_kontrak)) . ' Rupiah) <span style="text-decoration: underline">belum termasuk PPN 12%</span></b> dengan rincian sebagai berikut :
                        <ol type="1">
                            <li>Verifikasi untuk pekerjaan : 
                                <ul>
                                    <li><b>Sesuai dengan lampiran surat permohonan bapak/ibu nomor ' . $surat_penawaran->nomor_surat_permohonan . ' untuk pekerjaan "' . $surat_penawaran->rincian_produk_pekerjaan . '"</b></li>                                
                                </ul>
                            </li>
                            <li>' . ($surat_penawaran->point_b2 ?? 'Pelaporan') . '</li>
                            ' . $kalimat_ada_transport . '
                        </ol>
                    </li>
                    <li><i>Term of payment</i> tarif jasa diatas sebagai berikut :
                        <ol type="1">
                            ' . $pembayaran_termin . '
                           <li>Pembayaran dapat ditransfer ke rekening:<br>' . $rekening_bank . '</li>
                        </ol>
                    </li>
                </ol>
                [split_here]
                <ol type="A" start="4">
                    <li>Waktu pelaksanaan pekerjaan selama <b>' . $lama_verifikasi_dokumen . ' (' . strtolower($this->convertAngkaToTeks($lama_verifikasi_dokumen)) . ')</b> hari kerja <b>setelah dokumen lengkap</b>.</li>
                    <li>Surat penawaran ini berlaku selama <b>' . $surat_penawaran->masa_berlaku_penawaran . ' (' . strtolower($this->convertAngkaToTeks($surat_penawaran->masa_berlaku_penawaran)) . ')</b> hari kalender.</li>
                </ol>';
        return $html;
    }
    function surat_penawaran_budgetary($surat_penawaran)
    {
        $rekening_bank = $this->tabel_rekening();

        #kalimat pembayaran termin...
        $pembayaran_termin = $this->kalimat_termin($surat_penawaran);

        #cek apakah transportasi ditanggung perusahaan atau tidak...
        $kalimat_ada_transport = $this->kalimat_transport($surat_penawaran->status_transport_akomodasi, $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan);

        #mencari lama verifikasi dokumen..
        $lama_verifikasi_dokumen = $surat_penawaran->jml_hari_kerja;

        $html = '';
        $html .= 'Menindaklanjuti Permohonan Verifikasi ' . $surat_penawaran->permohonan_verifikasi . ' oleh <b>' . $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan . '</b> melalui whatsapp perihal ' . $surat_penawaran->permohonan_verifikasi . ' <i>Project</i> <b>"' . $surat_penawaran->rincian_produk_pekerjaan . '"</b>.<br>';
        $html .= '<br>';
        $html .= 'Sesuai dengan Schedule 3. Scope of Services dalam rangka memenuhi persyaratan TKDN sebagaimana telah ditetapkan dalam kontrak, bersama ini kami sampaikan ruang lingkup dan tarif jasa atas kegiatan dimaksud, bersama ini kami sampaikan ruang lingkup dan tarif jasa atas pekerjaan dimaksud:';
        $html .= '<ol type="A">
                    <li>Ruang Lingkup Pekerjaan :</li>
                    <li>Tarif jasa verifikasi TKDN atas <i>Project</i> <b>"' . $surat_penawaran->rincian_produk_pekerjaan . '"</b> sebesar <b>Rp ' . $this->convertToRupiah($surat_penawaran->nilai_kontrak) . ' (' . strtolower($this->convertAngkaToTeks($surat_penawaran->nilai_kontrak)) . ' Rupiah)</b>;
                        <br><i>Terms of Condition:</i>
                        <ol type="1">
                            <li>Penawaran harga belum termasuk PPN 12%;</li>
                            ' . $kalimat_ada_transport . '
                            <li>Jangka Waktu pelaksanaan pekerjaan selama <b>' . $lama_verifikasi_dokumen . ' (' . strtolower($this->convertAngkaToTeks($lama_verifikasi_dokumen)) . ')</b> hari kerja <b>setelah dokumen lengkap</b>;</li>
                            <li>Penawaran bersifat budgetary</li>
                        </ol>
                    </li>
                    <li><i>Term of payment</i> tarif jasa diatas sebagi berikut :
                        <ol type="1">
                            ' . $pembayaran_termin . '
                            <li>Pembayaran dapat ditransfer ke rekening:<br>' . $rekening_bank . '</li>
                        </ol>
                    </li>
                </ol>
                [split_here]
                <ol type="A" start="4">
                    <li>Surat Penawaran ini berlaku selama <b>' . $surat_penawaran->masa_berlaku_penawaran . ' (' . strtolower($this->convertAngkaToTeks($surat_penawaran->masa_berlaku_penawaran)) . ')</b> hari kalender.</li>
                </ol>';

        return $html;
    }
    function surat_penawaran_bmp($surat_penawaran)
    {
        $rekening_bank = $this->tabel_rekening();

        #kalimat pembayaran termin...
        $pembayaran_termin = $this->kalimat_termin($surat_penawaran);

        $kalimat_ada_transport = $this->kalimat_transport($surat_penawaran->status_transport_akomodasi, $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan, $surat_penawaran->jns_surat_penawaran);

        $kriteria_verifikasi_bmp = '';
        $where = array('kriteria_verifikasi_bmp.active' => 1);
        $data_send = array('where' => $where);
        $load_data = $this->kriteria_verifikasi_bmp->load_data($data_send);
        if ($load_data->num_rows() > 0) {
            foreach ($load_data->result() as $row) {
                $kriteria_verifikasi_bmp .= '<li>' . $row->jml_kriteria_penilaian . ' kriteria penilaian BMP <b>Rp ' . $this->convertToRupiah($row->biaya) . ' (' . strtolower($this->convertAngkaToTeks($row->biaya)) . ' rupiah)</b></li>';
            }
        }

        #mencari lama verifikasi dokumen..
        $lama_verifikasi_dokumen = $surat_penawaran->jml_hari_kerja;

        $html = '';
        $html .= 'Menindaklanjuti surat bapak/ibu Nomor ' . $surat_penawaran->nomor_surat_permohonan . ' perihal Permohonan <b>' . $surat_penawaran->permohonan_verifikasi . '</b>, bersama ini kami sampaikan ruang lingkup dan tarif jasa atas pekerjaan dimaksud :';
        $html .= '<ol type="A">
                    <li>Ruang Lingkup Pekerjaan
                        <ol type="1">
                            <li>Verifikasi Bobot Manfaat Perusahaan (BMP) <b>' . $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan . '</b>;</li>
                            <li>Survey dan kunjungan lapangan;</li>
                            <li>Verifikasi dokumen;</li>
                            <li>Pelaporan hasil verifikasi;</li>
                            <li>Penyampaian Draft Tanda Sah ke Kementerian Perindustrian</li>
                        </ol>
                    </li>
                    <li>Tarif jasa untuk pekerjaan <b>BMP (Bobot Manfaat Perusahaan)</b> adalah:
                        <ol type="1">
                            <li>Verifikasi untuk kriteria 
                                <ol type="a">
                                
                                    ' . $kriteria_verifikasi_bmp . '                         
                                
                                </ol>
                                <li>Pada nomor 1 point a sampai dengan point d, harga tersebut <b>belum termasuk PPN 12%</b></li>
                            </li>
                            <li>Verifikasi untuk penilaian BMP:
                                <ul>
                                    <li>' . $surat_penawaran->point_b2 . '</li>
                                </ul>
                            <li>Pelaporan</li>
                            ' . $kalimat_ada_transport . '
                        </ol>
                    </li>
                    <li><i>Term of payment</i> tarif jasa diatas sebagai berikut :
                        <ol type="1">
                            ' . $pembayaran_termin . '
                           <li>Pembayaran dapat ditransfer ke rekening:<br>' . $rekening_bank . '</li>
                        </ol>
                    </li>
                </ol>
                [split_here]
                <ol type="A" start="4">
                    <li>Waktu pelaksanaan pekerjaan selama <b>' . $lama_verifikasi_dokumen . ' (' . strtolower($this->convertAngkaToTeks($lama_verifikasi_dokumen)) . ')</b> hari kerja <b>setelah dokumen lengkap</b>.</li>
                    <li>Surat penawaran ini berlaku selama <b>' . $surat_penawaran->masa_berlaku_penawaran . ' (' . strtolower($this->convertAngkaToTeks($surat_penawaran->masa_berlaku_penawaran)) . ')</b> hari kalender.</li>
                </ol>';
        return $html;
    }
}
