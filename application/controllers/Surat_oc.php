<?php if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Surat_oc extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Surat_oc_model", "surat_oc");
        $this->load->model("rab_detail_model", "rab_detail");
        $this->load->model("rekening_bank_model", "rekening_bank");
        $this->load->model("log_verifikasi_model", "log_verifikasi");
        $this->load->model("mst_admin_model", "mst_admin");
        $this->load->model('surat_oc_rincian_model', 'surat_oc_rincian');
        $this->load->model('kriteria_verifikasi_bmp_model', 'kriteria_verifikasi_bmp');
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);
                $relation[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $relation[1] = array('tabel' => 'rab', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');
                $relation[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $relation[3] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $relation[4] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');

                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $where = "surat_oc.active IN (1,2) and surat_penawaran.active = 1 and dokumen_permohonan.status_pengajuan >= 17 and (surat_oc.nomor_oc like '%" . $filter . "%' or concat(nama_badan_usaha, ' ', nama_perusahaan) like '%" . $filter . "%')";

                if (isset($data_receive->from)) {
                    $from = htmlentities($data_receive->from ?? '');
                    if ($from == 'buat_proforma_invoice') {
                        $where .= " and dokumen_permohonan.status_pengajuan IN (17, 18)";
                    }
                    if ($from == 'verifikasi_proforma_invoice_kabid') {
                        $where .= " and dokumen_permohonan.status_pengajuan = 19";
                    }
                    if ($from == 'verifikasi_proforma_invoice_kepkeu') {
                        $where .= " and dokumen_permohonan.status_pengajuan = 20";
                    }
                    if ($from == 'verifikasi_bukti_bayar') {
                        $where .= " and dokumen_permohonan.status_pengajuan = 23";
                    }
                    if ($from == 'waktu_pelaksanaan') {
                        $where .= " and dokumen_permohonan.status_pengajuan = 25 and dokumen_permohonan.id_dokumen_permohonan IN (select id_dokumen_permohonan from dokumen_permohonan_pic where dokumen_permohonan_pic.active = 1 and dokumen_permohonan_pic.id_admin = '" . $this->session->userdata('id_admin') . "')";
                    }
                    if ($from == 'buat_form_01') {
                        $where .= " and dokumen_permohonan.status_pengajuan IN (26, 27)";
                    }
                    if ($from == 'verifikasi_koordinator') {
                        $where .= " and dokumen_permohonan.status_pengajuan = 28";
                    }
                    if ($from == 'verifikasi_kabid') {
                        $where .= " and dokumen_permohonan.status_pengajuan = 29";
                    }
                    if ($from == 'reminder_pembayran_oc') {
                        $where .= " and dokumen_permohonan.status_pengajuan IN (21,22) 
                                    and dokumen_permohonan.id_dokumen_permohonan NOT IN (select id_dokumen_permohonan from pesan where tag = 'reminder_pembayaran_oc')
                                    and DATE_ADD(tgl_oc, INTERVAL (batas_waktu_pembayaran - 7) DAY) <= '" . date('Y-m-d') . "' 
                                    and dokumen_permohonan.id_dokumen_permohonan IN (
                                        select id_dokumen_permohonan 
                                        from dokumen_permohonan_pic 
                                        where dokumen_permohonan_pic.active = 1 
                                            and dokumen_permohonan_pic.id_admin = '" . $this->session->userdata('id_admin') . "'
                                    )";
                    }
                }
                if ($this->is_assesor()) {
                    $where .= " and dokumen_permohonan.id_dokumen_permohonan IN (select id_dokumen_permohonan from dokumen_permohonan_pic pic where pic.active = 1 and pic.id_admin = '" . $this->session->userdata('id_admin') . "') ";
                }

                $send_data = array('where' => $where, 'join' => $relation, 'limit' => $limit);
                $load_data = $this->surat_oc->load_data($send_data);
                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $row) {
                        $row->assesor = $this->siapaAssesor($row->id_dokumen_permohonan);
                    }
                }
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'join' => $relation, 'select' => $select);
                $load_data = $this->surat_oc->load_data($send_data);
                $total_data = $load_data->row()->jml;

                $last_page = ceil($total_data / $jml_data);
                $result = array('result' => $result, 'last_page' => $last_page);

                echo json_encode($result);
            }
        }
    }

    // public function rab_oc_subsidi_silang()
    // {
    //     if ($this->validasi_login()) {
    //         $data_receive = json_decode(urldecode($this->input->post('data_send')));
    //         $token = $data_receive->token;
    //         if ($this->tokenStatus($token, 'LOAD_DATA')) {
    //             $id_assesor = htmlentities($data_receive->id_assesor ?? '');
    //             $id_dokumen_permohonan = htmlentities($data_receive->id_dokumen_permohonan ?? '');
    //             $join[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
    //             $join[1] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
    //             $join[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
    //             $join[3] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
    //             $join[4] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
    //             $where = array('surat_oc.active' => 1, 'rab.id_assesor' => $id_assesor, 'dokumen_permohonan.id_dokumen_permohonan !=' => $id_dokumen_permohonan);
    //             $data_send = array('where' => $where, 'join' => $join);
    //             $load_data = $this->surat_oc->load_data($data_send);
    //             if ($load_data->num_rows() > 0) {
    //                 foreach ($load_data->result() as $row) {

    //                     #mencari detail rab...
    //                     $hasil = $this->getDetailRAB($row);
    //                     $row->detail_rab = $hasil['detail_rab'];
    //                     $row->anggaran = $hasil['anggaran'];
    //                 }
    //             }
    //             $result = $load_data->result();
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
                $id_surat_oc = htmlentities($this->input->post('id_surat_oc') ?? '');
                $id_surat_penawaran = htmlentities($this->input->post('id_surat_penawaran') ?? '');
                $id_dokumen_permohonan = htmlentities($this->input->post('id_dokumen_permohonan') ?? '');
                $nomor_oc = htmlentities($this->input->post('nomor_oc') ?? '');
                $tgl_oc = htmlentities($this->input->post('tgl_oc') ?? '');
                $jns_surat_penawaran = htmlentities($this->input->post('jns_surat_penawaran') ?? '');
                $kriteria_penilaian_bmp = htmlentities($this->input->post('kriteria_penilaian_bmp') ?? '');
                $batas_waktu_pembayaran = htmlentities($this->input->post('batas_waktu_pembayaran') ?? '');

                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $action = htmlentities($this->input->post('action') ?? '');

                #jika action memiliki value 'save' maka data akan disimpan.
                #jika action tidak memiliki value, maka akan dianggap sebagai upadate.
                if ($action == 'save') {
                    $data = array(
                        'id_surat_penawaran' => $id_surat_penawaran,
                        'nomor_oc' => $nomor_oc,
                        'tgl_oc' => $tgl_oc,
                        'batas_waktu_pembayaran' => $batas_waktu_pembayaran,
                        'id_kriteria_verifikasi_bmp' => ($jns_surat_penawaran == 'bmp' ? $kriteria_penilaian_bmp : null),
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $hasil = $this->surat_oc->save_with_autoincrement($data);
                    if ($hasil[0]) {
                        $id_surat_oc = $hasil[1];
                        $this->input_rincian_oc($id_surat_oc);

                        $this->simpan_log_verifikasi($id_dokumen_permohonan, 15);
                    }
                    $return['sts'] = $hasil[0];
                } else {
                    $data = array(
                        'tgl_oc' => $tgl_oc,
                        'nomor_oc' => $nomor_oc,
                        'batas_waktu_pembayaran' => $batas_waktu_pembayaran,
                        'id_kriteria_verifikasi_bmp' => ($jns_surat_penawaran == 'bmp' ? $kriteria_penilaian_bmp : null),
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where = array('id_surat_oc' => $id_surat_oc, 'id_surat_penawaran' => $id_surat_penawaran);
                    $exe = $this->surat_oc->update($data, $where);
                    if ($exe) {
                        #hapus rincian pembayaran...
                        $this->surat_oc_rincian->delete(array('id_surat_oc' => $id_surat_oc));

                        #input ulang rincian pembayaran...
                        $this->input_rincian_oc($id_surat_oc);

                        #cek siapa yang menolak...
                        $order_cek = "id_log_verifikasi DESC";
                        $limit_cek = "1,1";
                        $where_cek = array('active' => 1, 'id_dokumen_permohonan' => $id_dokumen_permohonan);
                        $data_send_cek = array('where' => $where_cek, 'order' => $order_cek, 'limit' => $limit_cek);
                        $load_data_cek = $this->log_verifikasi->load_data($data_send_cek);
                        if ($load_data_cek->num_rows() > 0) {
                            $log_verifikasi = $load_data_cek->row();
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

    function input_rincian_oc($id_surat_oc)
    {
        $index = htmlentities($this->input->post('index') ?? '');
        $user_create = $this->session->userdata('id_admin');
        $time_create = date('Y-m-d H:i:s');
        $time_update = date('Y-m-d H:i:s');
        $user_update = $this->session->userdata('id_admin');

        if ($index > 0) {
            $keterangan_list = $this->input->post('keterangan');
            $nilai_pembayaran_list = $this->input->post('nilai_pembayaran');

            for ($i = 0; $i < count($keterangan_list); $i++) {
                $keterangan = htmlentities($keterangan_list[$i] ?? '');
                $nilai_pembayaran = str_replace('.', '', htmlentities($nilai_pembayaran_list[$i] ?? ''));

                $data_rincian = array(
                    'id_surat_oc' => $id_surat_oc,
                    'keterangan' => $keterangan,
                    'nilai_pembayaran' => $nilai_pembayaran,
                    'user_create' => $user_create,
                    'time_create' => $time_create,
                    'time_update' => $time_update,
                    'user_update' => $user_update
                );
                $this->surat_oc_rincian->save($data_rincian);
            }
        }
    }

    public function bypass_alur()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_dokumen_permohonan = htmlentities($data_receive->id_dokumen_permohonan ?? '');
                $alasan_verifikasi = htmlentities($data_receive->alasan_verifikasi ?? '');
                $id_jns_admin = $this->session->userdata('id_jns_admin');

                if ($id_jns_admin == 2) {
                    $exe = $this->simpan_log_verifikasi($id_dokumen_permohonan, 25, 'Alasan bypass: ' . $alasan_verifikasi);
                    $return['sts'] = $exe;
                } else {
                    $return['sts'] = 'tidak_berhak_ubah_data';
                }
            }

            echo json_encode($return);
        }
    }
    public function set_waktu_pelaksanaan()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_surat_oc = htmlentities($this->input->post('id_surat_oc') ?? '');
                $id_dokumen_permohonan = htmlentities($this->input->post('id_dokumen_permohonan') ?? '');

                $tgl_mulai_pelaksanaan = htmlentities($this->input->post('tgl_mulai_pelaksanaan') ?? '');
                $tgl_akhir_pelaksanaan = htmlentities($this->input->post('tgl_akhir_pelaksanaan') ?? '');

                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $data = array(
                    'tgl_mulai_pelaksanaan' => $tgl_mulai_pelaksanaan,
                    'tgl_akhir_pelaksanaan' => $tgl_akhir_pelaksanaan,
                    'time_update' => $time_update,
                    'user_update' => $user_update
                );
                $where = array('id_surat_oc' => $id_surat_oc);
                $exe = $this->surat_oc->update($data, $where);
                if ($exe) {
                    $this->simpan_log_verifikasi($id_dokumen_permohonan, 26);
                }
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
    public function dokumen_pdf($id_surat_oc = '')
    {
        if ($this->validasi_login() or $this->validasi_login_pelanggan()) {
            if ($id_surat_oc) {
                $id_surat_oc = htmlentities($id_surat_oc ?? '');
                $option = array(
                    'new_delimiter' => ' ',
                    'month_type' => 'full',
                    'date_reverse' => true,
                    'show_time' => false,
                );

                ob_start();

                $join[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[1] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join[3] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join[4] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');
                $join[5] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
                $where = array('surat_penawaran.active' => 1, 'surat_oc.active' => 1, 'rab.active' => 1, 'id_surat_oc' => $id_surat_oc);
                if ($this->session->userdata('login_as') == 'pelanggan') {
                    $where['pelanggan.id_pelanggan'] = $this->session->userdata('id_pelanggan');
                }
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->surat_oc->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $surat_penawaran = $load_data->row();
                    $nama_pejabat_penghubung_proses_tkdn = $surat_penawaran->nama_pejabat_penghubung_proses_tkdn;

                    #cek apakah transportasi ditanggung perusahaan atau tidak...
                    #0 = Dengan survey vendor dan lapngan, 
                    #1 = Tanpa survey vendor, 
                    #2 = Tanpa survey vendor  dan lapangan
                    $transport_akomoidasi = '';
                    if ($surat_penawaran->status_transport_akomodasi == 2) {
                        $transport_akomoidasi = '<li>Biaya belum termasuk transport dan akomodasi survey proses produksi dan survey vendor (ditanggung <b>' . $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan . '</b>)</li>';
                    } else if ($surat_penawaran->status_transport_akomodasi == 1) {
                        $transport_akomoidasi = '<li>Biaya belum termasuk transport dan akomodasi survey vendor sampai dengan layer ke-2 (ditanggung <b>' . $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan . '</b>)</li>';
                    }

                    #cek apakah ada rincian pembayaran...
                    $list_rincian = '';
                    $where_rincian = array('active' => 1, 'id_surat_oc' => $surat_penawaran->id_surat_oc);
                    $data_send_rincian = array('where' => $where_rincian);
                    $load_data_rincian = $this->surat_oc_rincian->load_data($data_send_rincian);
                    if ($load_data_rincian->num_rows() > 0) {
                        $list_rincian = '<ol type="a">';
                        foreach ($load_data_rincian->result() as $row) {
                            $list_rincian .= '<li>Lampiran permohonan nomor ' . $surat_penawaran->nomor_surat_permohonan . ' (' . $row->keterangan . '), apabila hasil verifikasi telah diterima maka ' . $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan . ' wajib melakukan pembayaran Rp ' . $this->convertToRupiah($row->nilai_pembayaran) . ' belum termasuk PPN 12%.</li>';
                        }
                        $list_rincian .= '</ol>';
                    }

                    #kalimat pembayaran termin...
                    if ($surat_penawaran->termin_1 == 100) {
                        $butir = '1 (satu) dan 2 (dua)';
                        $pembayaran_termin = '<li>Pembayaran pelunasan sebesar <b>100% (Seratus Persen)</b> dari nilai kontrak setelah penandatanganan kontrak.</li>';
                    } else if ($surat_penawaran->termin_2 == 100) {
                        $butir = '1 (satu) dan 2 (dua)';
                        if ($list_rincian != '') {
                            $pembayaran_termin = '<li>Pembayaran dilakukan sebesar <b>' . $surat_penawaran->termin_2 . '% (' . $this->penyebut($surat_penawaran->termin_2) . ' Persen)</b> berdasarkan progress pekerjaan yang telah diselesaikan:
                                                    ' . $list_rincian . '
                                                </li>';
                        } else {
                            $pembayaran_termin = '<li>Pembayaran pelunasan sebesar <b>100% (seratus persen)</b> dari nilai kontrak setelah hasil verifikasi ' . ($surat_penawaran->jns_surat_penawaran == 'bmp' ? 'BMP' : 'TKDN') . ' selesai/laporan pekerjaan verifikasi ' . ($surat_penawaran->jns_surat_penawaran == 'bmp' ? 'BMP' : 'TKDN') . ' telah diterima.</li>';
                        }
                    } else {
                        $butir = '1 (satu)';
                        $termin1 = ($surat_penawaran->termin_1 / 100) * $surat_penawaran->nilai_kontrak;
                        $termin2 = ($surat_penawaran->termin_2 / 100) * $surat_penawaran->nilai_kontrak;
                        
                        $termin1 = round($termin1, 0);
                        $termin2 = round($termin2, 0);

                        $pembayaran_termin = '<li>Pembayaran <b>Termin I</b> sebesar <b>' . $surat_penawaran->termin_1 . '% (' . $this->penyebut($surat_penawaran->termin_1) . ' Persen)</b> dari nilai kontrak setelah penandatanganan kontrak/OC (Order Confirmation) dan pembayaran termin I tidak dapat dilakukan pengembalian.
                                                <br><u>Sejumlah <b>Rp ' . $this->convertToRupiah($termin1) . ' (' . $this->penyebut($termin1) . ' Rupiah) belum termasuk PPN sebesar 12% dan pembayaran termin I tidak dapat dilakukan pengembalian</b></u>.
                                            </li>';
                        if ($list_rincian != '') {
                            $pembayaran_termin .= '<li>Pembayaran selanjutnya dilakukan sebesar <b>' . $surat_penawaran->termin_2 . '% (' . $this->penyebut($surat_penawaran->termin_2) . ' Persen)</b> berdasarkan progress pekerjaan yang telah diselesaikan:
                                                    ' . $list_rincian . '
                                                </li>';
                        } else {
                            $pembayaran_termin .= '<li>Pembayaran <b>Termin II (Pelunasan)</b> sebesar <b>' . $surat_penawaran->termin_2 . '% (' . $this->penyebut($surat_penawaran->termin_2) . ' Persen)</b> dari nilai kontrak setelah hasil verifikasi ' . ($surat_penawaran->jns_surat_penawaran == 'bmp' ? 'BMP' : 'TKDN') . ' selesai/laporan pekerjaan verifikasi ' . ($surat_penawaran->jns_surat_penawaran == 'bmp' ? 'BMP' : 'TKDN') . ' telah diterima.
                                                    <br><u>Sejumlah <b>Rp ' . $this->convertToRupiah($termin2) . ' (' . $this->penyebut($termin2) . ' Rupiah) belum termasuk PPN sebesar 12%</b></u>.
                                                </li>';
                        }
                    }

                    #mencari rekening perusahaan...
                    $rekening_bank = '';
                    $where_bank = array('active' => 1);
                    $data_send_bank = array('where' => $where_bank);
                    $load_data_bank = $this->rekening_bank->load_data($data_send_bank);
                    if ($load_data_bank->num_rows() > 0) {
                        foreach ($load_data_bank->result() as $row) {
                            $rekening_bank .= '<table style="font-weight: bold">
                                    <tr>
                                        <td style="width: 110px;">Nama Rekening</td>
                                        <td>: ' . $row->nama_rekening . '</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 110px;">Pemilik Rekening</td>
                                        <td>: ' . $row->pemilik_rekening . '</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td>
                                        <td>: ' . $row->nomor_rekening . '</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Bank</td>
                                        <td>: ' . $row->nama_bank . '</td>
                                    </tr>
                                    <tr>
                                        <td>Cabang</td>
                                        <td>: ' . $row->kantor_cabang . '</td>
                                    </tr>
                                </table>';
                        }
                    }
                    #mencari apakah pernah ada negosiasi...
                    $negosiasi = '';
                    $where_nego = array('active' => 1, 'status_verifikasi' => 11, 'id_dokumen_permohonan' => $surat_penawaran->id_dokumen_permohonan);
                    $data_send_nego = array('where' => $where_nego);
                    $load_data_nego = $this->log_verifikasi->load_data($data_send_nego);
                    if ($load_data_nego->num_rows() > 0) {
                        $data_nego = $load_data_nego->row();
                        $negosiasi = '<li>Permohonan Negosiasi Harga dari ruang negosiasi tanggal ' . $this->reformat_date($data_nego->tgl_verifikasi, $option) . '.</li>';
                    }

                    #tanda tangan kabid...
                    $ttd_kabid = '<img src="' . base_url() . 'assets/images/white.jpg" style="height: ' . $this->tinggi_ttd . ';"><br>';
                    $join_kabid[0] = array('tabel' => 'jns_admin', 'relation' => 'jns_admin.id_jns_admin = mst_admin.id_jns_admin', 'direction' => 'left');
                    $where_kabid = array('active' => 1, 'id_admin' => 39); //saya ganti sementara urgent, karena pergantian Kabid (Idham)
                    $data_send_kabid = array('where' => $where_kabid, 'join' => $join_kabid);
                    $load_data_kabid = $this->mst_admin->load_data($data_send_kabid);
                    //var_dump($this->db->last_query());    

                    $nama_kabid = '';
                    $jabatan_kabid = '';
                    if ($load_data_kabid->num_rows() > 0) {
                        $kabid = $load_data_kabid->row();
                        $nama_kabid = $kabid->nama_admin;
                        $jabatan_kabid = $kabid->jns_admin;
                        if ($surat_penawaran->status_pengajuan > 16) {
                            if (file_exists($kabid->ttd_admin)) {
                                $ttd_kabid = '<img src="' . base_url() . $kabid->ttd_admin . '" style="height: ' . $this->tinggi_ttd . ';"><br>';
                            } else {
                                $ttd_kabid = '<img src="' . base_url() . 'assets/images/no_ttd.jpg" style="height: ' . $this->tinggi_ttd . ';"><br>';
                            }
                        }
                    }

                    $kriteria_verifikasi_bmp = '';
                    if ($surat_penawaran->jns_surat_penawaran == 'bmp') {
                        $where_kriteria = array('kriteria_verifikasi_bmp.active' => 1, 'id_kriteria_verifikasi_bmp' => $surat_penawaran->id_kriteria_verifikasi_bmp);
                        $data_send_kriteria = array('where' => $where_kriteria);
                        $load_data_kriteria = $this->kriteria_verifikasi_bmp->load_data($data_send_kriteria);
                        if ($load_data_kriteria->num_rows() > 0) {
                            $kriteria = $load_data_kriteria->row();
                            $kriteria_verifikasi_bmp = '<li>Verifikasi untuk ' . $kriteria->jml_kriteria_penilaian . ' kriteria penilaian BMP</li>';
                        }
                    }

                    //var_dump($surat_penawaran);


                    $html = '<div style="text-align: justify">';
                    $html .= '<table>
                                    <tr>
                                        <td style="width: 130px">Kepada Yth.</td>
                                        <td style="width: 510px"></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Perusahaan</td>
                                        <td>: <span style="font-weight: bold">' . $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan . '</span></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Perusahaan</td>
                                        <td>: ' . $surat_penawaran->alamat_perusahaan . '</td>
                                    </tr>
                                    <tr>
                                        <td>U.P.</td>
                                        <td>: ' . $surat_penawaran->nama_up . '</td>
                                    </tr>
                                </table>';
                    $html .= '<div style="text-align: center">
                                <span style="font-weight: bold">Konfirmasi Order</span><br>
                                <span style="font-weight: bold; font-style: italic">Order Confirmation</span><br>
                                <span>' . $surat_penawaran->nomor_oc . '</span><br>
                                <span>Tanggal ' . $this->reformat_date($surat_penawaran->tgl_oc, $option) . '</span><br>
                            </div>';
                    $html .= '<div>
                                Untuk melakukan pekerjaan sebagai berikut :<br>
                                <i>Scope of Work :</i>
                                <ol type="1">
                                    <li>
                                        <table>
                                            <tr>
                                                <td style="width: 130px">Jenis jasa</td>
                                                <td style="width: 15px">:</td>
                                                <td style="width: 450px">Verifikasi ' . $surat_penawaran->permohonan_verifikasi . '</td>
                                            </tr>
                                            <tr>
                                                <td>Objek Order</td>
                                                <td>:</td>
                                                <td>Verifikasi ' . ($surat_penawaran->jns_surat_penawaran == 'bmp' ? 'BMP' : 'TKDN') . ' (Sesuai Surat Permohonan Nomor ' . $surat_penawaran->nomor_surat_permohonan . ')</td>
                                            </tr>
                                            <tr>
                                                <td><i>Comodity / Object</i></td>
                                                <td>:</td>
                                                <td>' . ($surat_penawaran->jns_surat_penawaran == 'bmp' ? 'Bobot Manfaat Perusahaan (BMP)' : $surat_penawaran->permohonan_verifikasi . ' ' . $surat_penawaran->nama_tipe_permohonan) . '</td>
                                            </tr>
                                            <tr>
                                                <td>Waktu Pelaksanaan</td>
                                                <td>:</td>
                                                <td><b>' . $surat_penawaran->jml_hari_kerja . ' (' . $this->penyebut($surat_penawaran->jml_hari_kerja) . ')</b> Hari Kerja</td>
                                            </tr>
                                            <tr>
                                                <td><i>Time Of Execution</i></td>
                                                <td>:</td>
                                                <td><b>' . $surat_penawaran->jml_hari_kerja . ' (' . $this->penyebut($surat_penawaran->jml_hari_kerja) . ')</b> Working Days</td>
                                            </tr>
                                            <tr>
                                                <td>Keterangan</td>
                                                <td>:</td>
                                                <td>
                                                    <ol type="a" style="text-align: justify">
                                                        <li>Terhitung setelah dokumen pendukung diterima secara lengkap</li>
                                                        <li>Laporan hasil verifikasi terbit</li>
                                                        <li>Batas waktu pemenuhan data dan dokumen sesuai <i>checklist</i> adalah <b>' . $surat_penawaran->masa_collecting_dokumen . ' (' . $this->penyebut($surat_penawaran->masa_collecting_dokumen) . ') hari kalender</b>. Jika tidak terpenuhi, maka <i>order</i> akan dibatalkan dan uang muka biaya verifikasi tidak dapat dikembalikan.</li>
                                                        ' . $transport_akomoidasi . '
                                                        ' . $kriteria_verifikasi_bmp . '
                                                    </ol>
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                    <li>
                                        <table>
                                            <tr>
                                                <td style="width: 130px">Total Biaya</td>
                                                <td style="width: 15px">:</td>
                                                <td style="width: 450px">
                                                    <b>Rp ' . $this->convertToRupiah($surat_penawaran->nilai_kontrak) . ' (' . $this->penyebut($surat_penawaran->nilai_kontrak) . ' rupiah)</b><br>
                                                    Belum termasuk PPN 12%<br>
                                                    <i>Exclude 12% VAT</i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i>Total Expenses</i></td>
                                                <td>:</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Mata Uang</td>
                                                <td>:</td>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td>Rp</td>
                                                            <td>Kurs : -</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i>Currency</i></td>
                                                <td>:</td>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td>IDR</td>
                                                            <td>Rate : -</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Catatan</td>
                                                <td>:</td>
                                                <td>Pembayaran jasa dilakukan :</td>
                                            </tr>
                                            <tr>
                                                <td><i>Note</i></td>
                                                <td>:</td>
                                                <td>
                                                    <ol type="1">
                                                        ' . $pembayaran_termin . '
                                                        <li>
                                                            Pembayaran sesuai butir ' . $butir . ' di atas agar ditransfer ke:<br>
                                                            ' . $rekening_bank . '
                                                            <br><u>Batas waktu pembayaran selambat-lambatnya <b>' . $surat_penawaran->batas_waktu_pembayaran . ' (' . $this->penyebut($surat_penawaran->batas_waktu_pembayaran) . ')</b> hari kalender setelah persetujuan konfirmasi order diterima.</u>
                                                        </li>
                                                    </ol>
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                    <li>
                                        Seluruh biaya dibebankan kepada :<br>
                                        <i>All charges and expenses for account of  :</i><br>
                                        <table>
                                        <tr>
                                            <td style="font-weight: bold">' . $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan . '</td>
                                            <td style="text-align: center">' . $surat_penawaran->nomor_npwp . '</td>
                                            <td>' . $surat_penawaran->alamat_npwp . '</td>
                                        </tr>
                                    </table>                                
                                    </li>
                                    <li>
                                        <table>
                                            <tr>
                                                <td style="width: 130px">Referensi</td>
                                                <td style="width: 15px">:</td>
                                                <td style="width: 450px">
                                                    <ol type="1">
                                                        <li>Permohonan Verifikasi ' . $surat_penawaran->permohonan_verifikasi . ' <b>' . $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan . '</b> nomor ' . $surat_penawaran->nomor_surat_permohonan . ' tanggal ' . $this->reformat_date($surat_penawaran->tgl_surat_permohonan, $option) . '.</li>
                                                        <li>Surat Penawaran Biaya Jasa Verifikasi TKDN nomor ' . $surat_penawaran->nomor_surat_penawaran . ' tanggal ' . $this->reformat_date($surat_penawaran->tgl_surat_penawaran, $option) . '.</li>
                                                        ' . $negosiasi . '
                                                    </ol>
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                </ol>
                            </div>';
                    $html .= '<div>Jika pembatalan dilakukan sepihak oleh pemberi order, maka seluruh biaya yang timbul sampai dengan saat pembatalan akan dibebankan kepada pemberi order.
                                <br><i>If the order is cancelled by the client without any confirmation, all expenses untill the date of cancellation will be charged to the client.</i>
                            </div>';
                    $html .= '<br><table style="text-align: center">
                                <tr>
                                    <td>
                                        <b>Disetujui Oleh:<br><i>Approved By</i></b>
                                        <br><img src="' . base_url() . 'assets/images/white.jpg" style="height: ' . $this->tinggi_ttd . ';"><br>
                                        <br><b>(..................................................)</b>
                                        <br><br>Jabatan: .............................
                                        <br><br>Tanda tangan dan Cap Perusahaan
                                    </td>
                                    <td>
                                        <b>' . $this->nama_instansi . '</b><br>Cabang Utama Surabaya
                                        <br>' . $ttd_kabid . '
                                        <br><b>' . $nama_kabid . '</b>
                                        <br>Kabid Inspeksi Government
                                    </td>
                                </tr>
                            </table>';
                    $html .= '</div>';
                    // $html .= '<br pagebreak="true"/>';
                    // $html .= '<img src="' . base_url() . 'assets/images/skb_2023.png" style="width: 1000px">';


                    $this->setting_portrait(true);
                    $this->pdf->writeHTML($html, true, false, true, false, '');

                    // $html = '<img src="' . base_url() . 'assets/images/SKB_SUPERINTENDING.jpg" style="width: 1000px">';
                    // $this->setting_portrait(false);
                    // $this->pdf->writeHTML($html, true, false, true, false, '');

                    $this->pdf->Output('Surat OC ' . $surat_penawaran->nama_badan_usaha . ' ' . $surat_penawaran->nama_perusahaan . '.pdf', 'I');
                } else {
                    $this->redirect(base_url() . 'page/lost');
                }
            } else {
                $this->redirect(base_url() . 'page/lost');
            }
        }
    }

    public function verifikasi_surat_oc()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_surat_oc = $data_receive->id_surat_oc;
            $id_dokumen_permohonan = $data_receive->id_dokumen_permohonan;
            $id_jns_admin = $this->session->userdata('id_jns_admin');

            if ($id_jns_admin == 2) {
                $status_verifikasi = ($data_receive->status_verifikasi == 'setuju' ? 16 : 14);
            } else if ($id_jns_admin == 5) {
                $status_verifikasi = ($data_receive->status_verifikasi == 'setuju' ? 22 : 14);
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
    public function verifikasi_bukti_bayar()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_dokumen_permohonan = htmlentities($data_receive->id_dokumen_permohonan ?? '');
            if ($data_receive->status_verifikasi == 'setuju') {
                $status_verifikasi = 25;

                #cek apakah dokumen ini pernah di bypass...
                #jika pernah, maka kembalikan ke status terakhir...
                $this->load->model('log_verifikasi_model', 'log_verifikasi');
                $order = "status_verifikasi DESC";
                $limit = "1,0";
                $where = array('active' => 1, 'id_dokumen_permohonan' => $id_dokumen_permohonan);
                $data_send = array('where' => $where, 'order' => $order, 'limit' => $limit);
                $load_data = $this->log_verifikasi->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $log_verifikasi = $load_data->row();
                    if ($log_verifikasi->status_verifikasi > $status_verifikasi) {
                        $status_verifikasi = $log_verifikasi->status_verifikasi;
                    }
                }
            } else {
                $status_verifikasi = 24;
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
}
