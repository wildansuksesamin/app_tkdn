
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Form_01 extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Form_01_model", "form_01");
        $this->load->model('surat_oc_model', 'surat_oc');
    }


    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);

                $join[0] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
                $join[2] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[3] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join[4] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join[5] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
                $join[6] = array('tabel' => 'mst_admin petugas_entri', 'relation' => 'petugas_entri.id_admin = form_01.id_petugas_entri', 'direction' => 'left');

                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $where = "form_01.active = 1  and surat_oc.active IN (1,2) and (surat_oc.nomor_oc like '%" . $filter . "%' or form_01.sub_unit_kerja like '%" . $filter . "%' or concat(nama_badan_usaha,' ',nama_perusahaan) like '%" . $filter . "%')";

                if (isset($data_receive->from)) {
                    $from = htmlentities($data_receive->from ?? '');
                    if ($from == 'buat_payment_detail') {
                        $where .= " and dokumen_permohonan.status_pengajuan IN (30, 31)";
                    }
                }
                if ($this->is_assesor()) {
                    $where .= " and dokumen_permohonan.id_dokumen_permohonan IN (select id_dokumen_permohonan from dokumen_permohonan_pic pic where pic.active = 1 and pic.id_admin = '" . $this->session->userdata('id_admin') . "') ";
                }

                $send_data = array('where' => $where, 'join' => $join, 'limit' => $limit);
                $load_data = $this->form_01->load_data($send_data);
                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $row) {
                        $row->assesor = $this->siapaAssesor($row->id_dokumen_permohonan);
                    }
                }
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'join' => $join, 'select' => $select);
                $load_data = $this->form_01->load_data($send_data);
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
                $id_form_01 = htmlentities($this->input->post('id_form_01') ?? '');
                $id_surat_oc = htmlentities($this->input->post('id_surat_oc') ?? '');
                $id_dokumen_permohonan = htmlentities($this->input->post('id_dokumen_permohonan') ?? '');

                $sub_unit_kerja = htmlentities($this->input->post('sub_unit_kerja') ?? '');

                $nama_kontak_pelanggan = htmlentities($this->input->post('nama_kontak_pelanggan') ?? '');
                $jabatan_pelanggan = htmlentities($this->input->post('jabatan_pelanggan') ?? '');
                $nomor_telepon_pelanggan = htmlentities($this->input->post('nomor_telepon_pelanggan') ?? '');

                $nomor_spk_po_iwo = htmlentities($this->input->post('nomor_spk_po_iwo') ?? '');
                $tgl_spk_po_iwo = htmlentities($this->input->post('tgl_spk_po_iwo') ?? '');

                $nama_komoditas = htmlentities($this->input->post('nama_komoditas') ?? '');
                $deskripsi_komoditas = htmlentities($this->input->post('deskripsi_komoditas') ?? '');
                $kuantitas_komoditas = htmlentities($this->input->post('kuantitas_komoditas') ?? '');
                $nilai_komoditas = htmlentities($this->input->post('nilai_komoditas') ?? '');
                $informasi_tambahan = htmlentities($this->input->post('informasi_tambahan') ?? '');

                $jenis_jasa = htmlentities($this->input->post('jenis_jasa') ?? '');
                $kode_jasa = htmlentities($this->input->post('kode_jasa') ?? '');
                $kegiatan_kegiatan = htmlentities($this->input->post('kegiatan_kegiatan') ?? '');
                $tgl_mulai_pelaksanaan = htmlentities($this->input->post('tgl_mulai_pelaksanaan') ?? '');
                $tgl_akhir_pelaksanaan = htmlentities($this->input->post('tgl_akhir_pelaksanaan') ?? '');
                $nama_kontak_jasa = htmlentities($this->input->post('nama_kontak_jasa') ?? '');
                $jabatan_kontak_jasa = htmlentities($this->input->post('jabatan_kontak_jasa') ?? '');
                $nomor_telepon_kontak_jasa = htmlentities($this->input->post('nomor_telepon_kontak_jasa') ?? '');

                $dasar_penetapan_tarif = htmlentities($this->input->post('dasar_penetapan_tarif') ?? '');
                $tarif = htmlentities($this->input->post('tarif') ?? '');
                $perkiraan_fee = htmlentities($this->input->post('perkiraan_fee') ?? '');

                $biaya_transport = str_replace('.', '', htmlentities($this->input->post('biaya_transport') ?? ''));
                $akomodasi = str_replace('.', '', htmlentities($this->input->post('akomodasi') ?? ''));
                $biaya_kurir = str_replace('.', '', htmlentities($this->input->post('biaya_kurir') ?? ''));
                $biaya_tunggu = str_replace('.', '', htmlentities($this->input->post('biaya_tunggu') ?? ''));
                $biaya_lain_lain = str_replace('.', '', htmlentities($this->input->post('biaya_lain_lain') ?? ''));

                $bahasa_sertifikat = htmlentities($this->input->post('bahasa_sertifikat') ?? '');
                $jumlah_sertifikat = str_replace('.', '', htmlentities($this->input->post('jumlah_sertifikat') ?? ''));
                $penerbit_sertifikat = htmlentities($this->input->post('penerbit_sertifikat') ?? '');

                $catatan = htmlentities($this->input->post('catatan') ?? '');

                $id_petugas_entri = $this->session->userdata('id_admin');

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
                        'sub_unit_kerja' => $sub_unit_kerja,
                        'nama_kontak_pelanggan' => $nama_kontak_pelanggan,
                        'jabatan_pelanggan' => $jabatan_pelanggan,
                        'nomor_telepon_pelanggan' => $nomor_telepon_pelanggan,
                        'nomor_spk_po_iwo' => $nomor_spk_po_iwo,
                        'tgl_spk_po_iwo' => $tgl_spk_po_iwo,
                        'nama_komoditas' => $nama_komoditas,
                        'deskripsi_komoditas' => $deskripsi_komoditas,
                        'kuantitas_komoditas' => $kuantitas_komoditas,
                        'nilai_komoditas' => $nilai_komoditas,
                        'informasi_tambahan' => $informasi_tambahan,
                        'jenis_jasa' => $jenis_jasa,
                        'kode_jasa' => $kode_jasa,
                        'kegiatan_kegiatan' => $kegiatan_kegiatan,
                        'nama_kontak_jasa' => $nama_kontak_jasa,
                        'jabatan_kontak_jasa' => $jabatan_kontak_jasa,
                        'nomor_telepon_kontak_jasa' => $nomor_telepon_kontak_jasa,
                        'dasar_penetapan_tarif' => $dasar_penetapan_tarif,
                        'tarif' => $tarif,
                        'perkiraan_fee' => $perkiraan_fee,
                        'biaya_transport' => $biaya_transport,
                        'akomodasi' => $akomodasi,
                        'biaya_kurir' => $biaya_kurir,
                        'biaya_tunggu' => $biaya_tunggu,
                        'biaya_lain_lain' => $biaya_lain_lain,
                        'bahasa_sertifikat' => $bahasa_sertifikat,
                        'jumlah_sertifikat' => $jumlah_sertifikat,
                        'penerbit_sertifikat' => $penerbit_sertifikat,
                        'catatan' => $catatan,
                        'id_petugas_entri' => $id_petugas_entri,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $exe = $this->form_01->save($data);
                    if ($exe) {
                        #update rencana tanggal pelaksanaan...
                        $data_surat_oc = array(
                            'tgl_mulai_pelaksanaan' => $tgl_mulai_pelaksanaan,
                            'tgl_akhir_pelaksanaan' => $tgl_akhir_pelaksanaan,
                            'time_update' => $time_update,
                            'user_update' => $user_update
                        );
                        $where_surat_oc = array('id_surat_oc' => $id_surat_oc);
                        $this->surat_oc->update($data_surat_oc, $where_surat_oc);

                        $this->simpan_log_verifikasi($id_dokumen_permohonan, 28);
                    }
                    $return['sts'] = $exe;
                } else {
                    $data = array(
                        'sub_unit_kerja' => $sub_unit_kerja,
                        'nama_kontak_pelanggan' => $nama_kontak_pelanggan,
                        'jabatan_pelanggan' => $jabatan_pelanggan,
                        'nomor_telepon_pelanggan' => $nomor_telepon_pelanggan,
                        'nomor_spk_po_iwo' => $nomor_spk_po_iwo,
                        'tgl_spk_po_iwo' => $tgl_spk_po_iwo,
                        'nama_komoditas' => $nama_komoditas,
                        'deskripsi_komoditas' => $deskripsi_komoditas,
                        'kuantitas_komoditas' => $kuantitas_komoditas,
                        'nilai_komoditas' => $nilai_komoditas,
                        'informasi_tambahan' => $informasi_tambahan,
                        'jenis_jasa' => $jenis_jasa,
                        'kode_jasa' => $kode_jasa,
                        'kegiatan_kegiatan' => $kegiatan_kegiatan,
                        'nama_kontak_jasa' => $nama_kontak_jasa,
                        'jabatan_kontak_jasa' => $jabatan_kontak_jasa,
                        'nomor_telepon_kontak_jasa' => $nomor_telepon_kontak_jasa,
                        'dasar_penetapan_tarif' => $dasar_penetapan_tarif,
                        'tarif' => $tarif,
                        'perkiraan_fee' => $perkiraan_fee,
                        'biaya_transport' => $biaya_transport,
                        'akomodasi' => $akomodasi,
                        'biaya_kurir' => $biaya_kurir,
                        'biaya_tunggu' => $biaya_tunggu,
                        'biaya_lain_lain' => $biaya_lain_lain,
                        'bahasa_sertifikat' => $bahasa_sertifikat,
                        'jumlah_sertifikat' => $jumlah_sertifikat,
                        'penerbit_sertifikat' => $penerbit_sertifikat,
                        'catatan' => $catatan,
                        'id_petugas_entri' => $id_petugas_entri,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where = array('id_form_01' => $id_form_01, 'id_surat_oc' => $id_surat_oc);
                    $exe = $this->form_01->update($data, $where);
                    if ($exe) {
                        #update rencana tanggal pelaksanaan...
                        $data_surat_oc = array(
                            'tgl_mulai_pelaksanaan' => $tgl_mulai_pelaksanaan,
                            'tgl_akhir_pelaksanaan' => $tgl_akhir_pelaksanaan,
                            'time_update' => $time_update,
                            'user_update' => $user_update
                        );
                        $where_surat_oc = array('id_surat_oc' => $id_surat_oc);
                        $this->surat_oc->update($data_surat_oc, $where_surat_oc);

                        #cek siapa yg menolak...
                        $this->load->model("log_verifikasi_model", "log_verifikasi");
                        $order_log_verifikasi = "id_log_verifikasi DESC";
                        $where_log_verifikasi = array('active' => 1, 'id_dokumen_permohonan' => $id_dokumen_permohonan);
                        $limit_log_verifikasi = '1,1';
                        $data_send_log_verifikasi = array('where' => $where_log_verifikasi, 'order' => $order_log_verifikasi, 'limit' => $limit_log_verifikasi);
                        $load_data_log_verifikasi = $this->log_verifikasi->load_data($data_send_log_verifikasi);
                        if ($load_data_log_verifikasi->num_rows() > 0) {
                            $log_verifikasi = $load_data_log_verifikasi->row();

                            $status_verifikasi = $log_verifikasi->status_verifikasi;
                            $this->simpan_log_verifikasi($id_dokumen_permohonan, $status_verifikasi);
                        }
                    }
                    $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }
    public function verifikasi_form_01()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_surat_oc = $data_receive->id_surat_oc;
            $id_form_01 = $data_receive->id_form_01;
            $id_dokumen_permohonan = $data_receive->id_dokumen_permohonan;
            $id_jns_admin = $this->session->userdata('id_jns_admin');

            if ($id_jns_admin == 2) { #verifikatornya adalah koordinator...
                $status_verifikasi = ($data_receive->status_verifikasi == 'setuju' ? 29 : 27);
            } else if ($id_jns_admin == 5) { #verifikatornya adalah kabid...
                $status_verifikasi = ($data_receive->status_verifikasi == 'setuju' ? 30 : 27);
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
    public function dokumen_pdf($id_form_01 = '')
    {
        if ($this->validasi_login() or $this->validasi_login_pelanggan()) {
            if ($id_form_01) {

                $id_form_01 = htmlentities($id_form_01 ?? '');
                $option_date_format = array(
                    'new_delimiter' => ' ',
                    'month_type' => 'full',
                    'date_reverse' => true,
                    'show_time' => false,
                );

                $data_halaman = $this->data_halaman();

                ob_start();

                $select = "*, 
                    form_01.time_create tgl_entry, 
                    petugas_entri.nama_admin nama_petugas_entri, petugas_entri.ttd_admin ttd_petugas_entri,
                    koordinator.nama_admin nama_koordinator, koordinator.ttd_admin ttd_koordinator, 
                    kabid.nama_admin nama_kabid, kabid.ttd_admin ttd_kabid";
                $join[0] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_oc.id_surat_penawaran = surat_penawaran.id_surat_penawaran', 'direction' => 'left');
                $join[2] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[3] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join[4] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join[5] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
                $join[6] = array('tabel' => 'mst_admin petugas_entri', 'relation' => 'petugas_entri.id_admin = form_01.id_petugas_entri', 'direction' => 'left');
                $join[7] = array('tabel' => 'mst_admin koordinator', 'relation' => 'koordinator.id_admin = rab.id_koordinator', 'direction' => 'left');
                $join[8] = array('tabel' => 'mst_admin kabid', 'relation' => 'kabid.id_admin = surat_penawaran.id_kabid', 'direction' => 'left');

                $where = array('form_01.active' => 1, 'id_form_01' => $id_form_01);
                if ($this->session->userdata('login_as') == 'pelanggan') {
                    $where['dokumen_permohonan.id_pelanggan'] = $this->session->userdata('id_pelanggan');
                }
                $data_send = array('select' => $select, 'where' => $where, 'join' => $join);
                $load_data = $this->form_01->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $form_01 = $load_data->row();

                    $ttd_petugas_entry = '<br><br><img src="' . base_url() . 'assets/images/white.jpg" style="height: ' . $this->tinggi_ttd . ';">';
                    if (file_exists($form_01->ttd_petugas_entri)) {
                        $ttd_petugas_entry = '<br><br><img src="' . base_url() . $form_01->ttd_petugas_entri . '" style="height: ' . $this->tinggi_ttd . ';">';
                    } else {
                        $ttd_petugas_entry = '<br><br><img src="' . base_url() . 'assets/images/no_ttd.jpg" style="height: ' . $this->tinggi_ttd . ';">';
                    }

                    $ttd_koordinator = '<br><br><img src="' . base_url() . 'assets/images/white.jpg" style="height: ' . $this->tinggi_ttd . ';">';
                    if ($form_01->status_pengajuan >= 29) {
                        if (file_exists($form_01->ttd_koordinator))
                            $ttd_koordinator = '<br><br><img src="' . base_url() . $form_01->ttd_koordinator . '" style="height: ' . $this->tinggi_ttd . ';">';
                        else
                            $ttd_koordinator = '<br><br><img src="' . base_url() . 'assets/images/no_ttd.jpg" style="height: ' . $this->tinggi_ttd . ';">';
                    }

                    $ttd_kabid = '<br><img src="' . base_url() . 'assets/images/white.jpg" style="height: ' . $this->tinggi_ttd . ';">';
                    if ($form_01->status_pengajuan >= 30) {
                        if (file_exists($form_01->ttd_kabid))
                            $ttd_kabid = '<br><img src="' . base_url() . $form_01->ttd_kabid . '" style="height: ' . $this->tinggi_ttd . ';">';
                        else
                            $ttd_kabid = '<br><img src="' . base_url() . 'assets/images/no_ttd.jpg" style="height: ' . $this->tinggi_ttd . ';">';
                    }

                    $html = '';
                    $html .= '<table>
                                    <tr>
                                        <td rowspan="3" style="width: 130px;"><img src="' . base_url() . 'assets/images/sucofindo.png" style="height: 70px;"></td>
                                        <td style="width: 230px;"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><div style="font-weight: bold; font-size: 16px;">PENERIMAAN ORDER</div></td>
                                        <td>Unit Kerja SBU/Cabang</td>
                                        <td style="text-transform: uppercase">: ' . $this->cabang . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Sub Untit Kerja (Operasional)</td>
                                        <td style="text-transform: uppercase">: ' . $form_01->sub_unit_kerja . '</td>
                                    </tr>
                                </table>';
                    $html .= '<hr>';
                    $html .= '<table style="font-size: 12px">
                                    <tr>
                                        <td colspan="7" style="font-weight: bold">1. PELANGGAN</td>
                                    </tr>
                                    <tr style="">
                                        <td style="width: 3%;"></td>
                                        <td style="width: 5%;">1.1</td>
                                        <td style="width: 27%;">Nama Pelanggan</td>
                                        <td style="width: 2%;">:</td>
                                        <td style="width: 63%; border-bottom: 1px solid #000;" colspan="3">' . $form_01->nama_badan_usaha . ' ' . $form_01->nama_perusahaan . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >1.2</td>
                                        <td>Alamat Pelanggan</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . $form_01->alamat_perusahaan . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >1.3</td>
                                        <td>NPWP</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . coverMe($form_01->nomor_npwp) . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >1.4</td>
                                        <td>Nama Kontak</td>
                                        <td>:</td>
                                        <td style="width: 30%; border-bottom: 1px solid #000;">' . coverMe($form_01->nama_kontak_pelanggan) . '</td>
                                        <td style="width: 12%">Jabatan :</td>
                                        <td style="width: 21%; border-bottom: 1px solid #000;">' . coverMe($form_01->jabatan_pelanggan) . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >1.5</td>
                                        <td>Nomor Telepon/HP/faks</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . coverMe($form_01->nomor_telepon_pelanggan) . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" style="font-weight: bold">2. REFERENSI</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>2.1</td>
                                        <td>Nomor Kontrak</td>
                                        <td>:</td>
                                        <td style="width: 30%; border-bottom: 1px solid #000;">' . $form_01->nomor_oc . '</td>
                                        <td style="width: 12%">Tanggal :</td>
                                        <td style="width: 21%; border-bottom: 1px solid #000;">' . $this->reformat_date($form_01->tgl_oc, $option_date_format) . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>2.2</td>
                                        <td>Nomor SPK/PO/IWO</td>
                                        <td>:</td>
                                        <td style="width: 30%; border-bottom: 1px solid #000;">' . coverMe($form_01->nomor_spk_po_iwo) . '</td>
                                        <td style="width: 12%">Tanggal :</td>
                                        <td style="width: 21%; border-bottom: 1px solid #000;">' . ($form_01->tgl_spk_po_iwo != '0000-00-00' ? $this->reformat_date($form_01->tgl_spk_po_iwo, $option_date_format) : '') . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" style="font-weight: bold">3. KOMODITAS/OBJEK</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >3.1</td>
                                        <td>Nama komoditas/objek</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . coverMe($form_01->nama_komoditas) . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >3.2</td>
                                        <td>Deskripsi komoditas/objek</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . coverMe($form_01->deskripsi_komoditas) . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>3.3</td>
                                        <td>Kuantitas komoditas/objek</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . coverMe($form_01->kuantitas_komoditas) . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >3.4</td>
                                        <td>Nilai komoditas/objek(FOB)</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . coverMe($form_01->nilai_komoditas) . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >3.5</td>
                                        <td>Informasi tambahan</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . coverMe($form_01->informasi_tambahan) . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" style="font-weight: bold">4. JASA</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >4.1</td>
                                        <td>Nama jenis jasa</td>
                                        <td>:</td>
                                        <td style="width: 30%; border-bottom: 1px solid #000;">' . coverMe($form_01->jenis_jasa) . '</td>
                                        <td style="width: 12%">Kode :</td>
                                        <td style="width: 21%; border-bottom: 1px solid #000;">' . coverMe($form_01->kode_jasa) . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >4.2</td>
                                        <td>Kegiatan-kegiatan</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . coverMe($form_01->kegiatan_kegiatan) . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >4.3</td>
                                        <td>Rencana pelaksanaan tanggal</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . $this->reformat_date($form_01->tgl_mulai_pelaksanaan, $option_date_format) . ' hingga ' . $this->reformat_date($form_01->tgl_akhir_pelaksanaan, $option_date_format) . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >4.4</td>
                                        <td>Lokasi pelaksanaan</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . coverMe($form_01->lokasi) . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >4.5</td>
                                        <td>Nama kontak</td>
                                        <td>:</td>
                                        <td style="width: 30%; border-bottom: 1px solid #000;">' . coverMe($form_01->nama_kontak_jasa) . '</td>
                                        <td style="width: 12%">Jabatan :</td>
                                        <td style="width: 21%; border-bottom: 1px solid #000;">' . coverMe($form_01->jabatan_kontak_jasa) . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >4.6</td>
                                        <td>Nomor telepon/HP/faks</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . coverMe($form_01->nomor_telepon_kontak_jasa) . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" style="font-weight: bold">5. TARIF</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >5.1</td>
                                        <td>Dasar penetapan tarif</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . coverMe($form_01->dasar_penetapan_tarif) . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >5.2</td>
                                        <td>Tarif</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . $form_01->tarif . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >5.3</td>
                                        <td>Perkiraan fee</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . ($form_01->perkiraan_fee > 0 ? 'Rp ' . $this->convertToRupiah($form_01->perkiraan_fee) : '') . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >5.4</td>
                                        <td>Biaya-biaya lain:</td>
                                        <td></td>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>Biaya transport</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . ($form_01->biaya_transport > 0 ? 'Rp ' . $this->convertToRupiah($form_01->biaya_transport) : '') . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>Akomodasi</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . ($form_01->akomodasi > 0 ? 'Rp ' . $this->convertToRupiah($form_01->akomodasi) : '') . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>Biaya kurir untuk sample dan sertifikat</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . ($form_01->biaya_kurir > 0 ? $this->convertToRupiah($form_01->biaya_kurir) : '') . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>Biaya tunggu</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . ($form_01->biaya_tunggu > 0 ? $this->convertToRupiah($form_01->biaya_tunggu) : '') . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>Biaya lain-lain</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . ($form_01->biaya_lain_lain > 0 ? $this->convertToRupiah($form_01->biaya_lain_lain) : '') . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >5.5</td>
                                        <td>Penerbit invoice</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . strtoupper($data_halaman['nama_instansi']) . ' CABANG ' . strtoupper($data_halaman['cabang']) . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" style="font-weight: bold">6. SERTIFIKAT</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >6.1</td>
                                        <td>Bahasa sertifikat</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . coverMe($form_01->bahasa_sertifikat) . '</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >6.2</td>
                                        <td>Jumlah sertifikat</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . coverMe($form_01->jumlah_sertifikat, 0) . ' Invoice</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td >6.3</td>
                                        <td>Penerbit serifikat</td>
                                        <td>:</td>
                                        <td colspan="3" style="border-bottom: 1px solid #000;">' . $form_01->penerbit_sertifikat . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" style="font-weight: bold">7. CATATAN</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" style="border-bottom: 1px solid #000;">' . coverMe($form_01->catatan) . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" style="font-weight: bold">Note: SO</td>
                                    </tr>
                                   
                                </table>';
                    $html .= '<br><br>';
                    $html .= '<table style="font-size:14px;">
                                    <tr style="text-align: center">
                                        <td>Dientri Tanggal: 
                                            <br>Petugas entri: ' . $form_01->nama_petugas_entri . '
                                            ' . $ttd_petugas_entry . '
                                        </td>
                                        <td>Penerima Order
                                            ' . $ttd_koordinator . '
                                            <br>(' . $form_01->nama_koordinator . ')
                                        </td>
                                        <td>
                                            ' . $this->cabang . ', ' . $this->reformat_date($form_01->tgl_entry, $option_date_format) . '
                                            <br>Menyetujui
                                            ' . $ttd_kabid . '
                                            <br>(' . $form_01->nama_kabid . ')
                                        </td>
                                    </tr>
                                </table>';

                    $this->setting_portrait(false);
                    $this->pdf->SetAutoPageBreak(TRUE, 10);
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
}
