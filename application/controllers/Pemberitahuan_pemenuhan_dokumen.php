
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pemberitahuan_pemenuhan_dokumen extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('opening_meeting_model', 'opening_meeting');
        $this->load->model('mst_admin_model', 'mst_admin');
        $this->load->model('log_status_verifikasi_tkdn_model', 'log_status');
        $this->load->model("Pemberitahuan_pemenuhan_dokumen_model", "pemberitahuan_pemenuhan_dokumen");
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);

                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = pemberitahuan_pemenuhan_dokumen.id_opening_meeting', 'direction' => 'left');
                $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $join[2] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $join[3] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                $join[4] = array('tabel' => 'mst_admin', 'relation' => 'mst_admin.id_admin = opening_meeting.id_assesor', 'direction' => 'left');

                $where = "pemberitahuan_pemenuhan_dokumen.active = 1  and opening_meeting.active = 1  and (pemberitahuan_pemenuhan_dokumen.nomor_surat like '%" . $filter . "%' or concat(nama_badan_usaha,' ',nama_perusahaan) like '%" . $filter . "%')";

                if (isset($data_receive->from)) {
                    $from = $data_receive->from;
                    if ($from == 'verifikasi_pemberitahuan_pemenuhan_dokumen') {
                        if ($this->session->userdata('id_jns_admin') == 2) {
                            $id_status = 8;
                        } else if ($this->session->userdata('id_jns_admin') == 5) {
                            $id_status = 9;
                        } else {
                            $id_status = 'x';
                        }
                        $where .= " and opening_meeting.id_status = '" . $id_status . "'";
                    }
                }

                $send_data = array('where' => $where, 'join' => $join, 'limit' => $limit);
                $load_data = $this->pemberitahuan_pemenuhan_dokumen->load_data($send_data);
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'join' => $join, 'select' => $select);
                $load_data = $this->pemberitahuan_pemenuhan_dokumen->load_data($send_data);
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
                $id_pemberitahuan = htmlentities($this->input->post('id_pemberitahuan') ?? '');
                $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
                $nomor_surat = htmlentities($this->input->post('nomor_surat') ?? '');
                $tgl_surat = htmlentities($this->input->post('tgl_surat') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                #cek apakah sudah ada pemberitahuan sebelumnya...
                $cek = $this->pemberitahuan_pemenuhan_dokumen->is_available(
                    array(
                        'id_opening_meeting' => $id_opening_meeting
                    )
                );

                #jika setelah di cek dan hasilnya belum ada, maka buat surat...
                if (!$cek) {
                    $data = array(
                        'id_opening_meeting' => $id_opening_meeting,
                        'nomor_surat' => $nomor_surat,
                        'tgl_surat' => $tgl_surat,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $exe = $this->pemberitahuan_pemenuhan_dokumen->save($data);
                    $return['sts'] = $exe;
                } else {
                    #jika ada, ini adalah update pemberitahuan yang direvisi...
                    $data = array(
                        'nomor_surat' => $nomor_surat,
                        'tgl_surat' => $tgl_surat,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where = array('id_opening_meeting' => $id_opening_meeting);
                    $exe = $this->pemberitahuan_pemenuhan_dokumen->update($data, $where);
                    $return['sts'] = $exe;
                }

                if ($exe) {
                    #mencari status terakhir...
                    $order = "id_log_verifikasi_tkdn DESC";
                    $limit = "1,1";
                    $where = array('active' => 1, 'id_opening_meeting' => $id_opening_meeting);
                    $data_send = array('where' => $where, 'order' => $order, 'limit' => $limit);
                    $load_data = $this->log_status->load_data($data_send);
                    $log_status = $load_data->row();
                    #update status alur...
                    $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, $log_status->id_status);
                }
            }

            echo json_encode($return);
        }
    }

    public function verifikasi_pemberitahuan()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_opening_meeting = $data_receive->id_opening_meeting;
            $id_jns_admin = $this->session->userdata('id_jns_admin');

            if ($id_jns_admin == 5 or $id_jns_admin == 2) { #verifikatornya adalah koordinator dan kabid...
                if ($id_jns_admin == 2)
                    $id_status = ($data_receive->status_verifikasi == 'setuju' ? 9 : 10);
                else
                    $id_status = ($data_receive->status_verifikasi == 'setuju' ? 11 : 10);
                $alasan_verifikasi = (isset($data_receive->alasan_verifikasi) ? $data_receive->alasan_verifikasi : '');

                $return = array();
                if ($this->tokenStatus($token, 'SEND_DATA')) {
                    $exe = $this->simpan_log_status_verifikasi_tkdn($id_opening_meeting, $id_status, $alasan_verifikasi);

                    if ($exe and $id_status == 10) {
                        $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                        $join[1] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                        $where = array('opening_meeting.active' => 1, 'id_opening_meeting' => $id_opening_meeting);
                        $data_send = array('where' => $where, 'join' => $join);
                        $load_data = $this->opening_meeting->load_data($data_send);
                        if ($load_data->num_rows() > 0) {
                            $opening_meeting = $load_data->row();
                            $penerima_email = $opening_meeting->email;
                            #kirim email...
                            $template = file_get_contents(base_url('page/mail_template/tidak'));
                            $template = str_replace('{{nama_pengaju}}', $opening_meeting->nama_perusahaan, $template);
                            $template = str_replace('{{isi_pesan}}', 'Masa pengumpulan dokumen untuk permohonan Anda akan segera habis. Berikut kami kirimkan surat pemberitahuan pemenuhan dokumen. Silakan unduh dokumen pada bagian attachment email ini.', $template);

                            $attach = $this->dokumen_pdf($id_opening_meeting, 'ya');

                            #kirim surat pemberitahuan ke email...
                            $mail = array(
                                'penerima_email' => $penerima_email,
                                'judul_email' => 'Pemberitahuan Pemenuhan Dokumen',
                                'pesan_email' => $template,
                                'attach' => $attach
                            );
                            $this->send_bunker($mail);
                        }
                    }
                    $return['sts'] = $exe;
                }
            } else {
                $return['sts'] = 'tidak_berhak_ubah_data';
            }


            echo json_encode($return);
        }
    }
    public function coba()
    {
        $hasil = $this->dokumen_pdf(1, 'ya');
        echo $hasil;
    }
    public function dokumen_pdf($id_opening_meeting = '', $attach = 'tidak')
    {
        if ($this->validasi_login() or $this->validasi_login_pelanggan()) {
            $id_opening_meeting = htmlentities($id_opening_meeting ?? '');

            $login_as = $this->session->userdata('login_as');

            $join[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
            $join[1] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
            $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
            $join[3] = array('tabel' => 'surat_oc', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
            $join[4] = array('tabel' => 'proforma_invoice', 'relation' => 'proforma_invoice.id_surat_oc = surat_oc.id_surat_oc', 'direction' => 'left');
            $join[5] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
            $join[6] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');

            $join[7] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
            $join[8] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

            $join[9] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
            $join[10] = array('tabel' => 'mst_admin', 'relation' => 'opening_meeting.id_assesor = mst_admin.id_admin', 'direction' => 'left');

            $join[11] = array('tabel' => 'pemberitahuan_pemenuhan_dokumen', 'relation' => 'pemberitahuan_pemenuhan_dokumen.id_opening_meeting = opening_meeting.id_opening_meeting', 'direction' => 'left');
            $where = "opening_meeting.active = 1 and opening_meeting.id_opening_meeting = '" . $id_opening_meeting . "' and id_status >= 7";
            if ($login_as == 'pelanggan') {
                $where .= " and dokumen_permohonan.id_pelanggan = '" . $this->session->userdata('id_pelanggan') . "'";
            }
            $send_data = array('where' => $where, 'join' => $join);
            $load_data = $this->opening_meeting->load_data($send_data);
            if ($load_data->num_rows() > 0) {
                $opening_meeting = $load_data->row();

                $option_dateformat = array(
                    'new_delimiter' => ' ',
                    'month_type' => 'full',
                );

                $konten = $this->data_halaman();

                $tgl_mulai = $opening_meeting->tgl_mulai_verifikasi_dokumen;
                $tgl_selesai = date('Y-m-d', strtotime($tgl_mulai . ' + ' . $opening_meeting->masa_collecting_dokumen . ' days'));

                $nama_kabid = '';
                $ttd_kabid = '<br><img src="' . base_url() . 'assets/images/white.jpg" style="height: ' . $this->tinggi_ttd . ';">';

                #mencari data kabid...
                $where_kabid = array('id_jns_admin' => 5);
                $data_send_kabid = array('where' => $where_kabid);
                $load_data_kabid = $this->mst_admin->load_data($data_send_kabid);
                if ($load_data_kabid->num_rows() > 0) {
                    $kabid = $load_data_kabid->row();

                    $nama_kabid = $kabid->nama_admin;
                    if ($opening_meeting->id_status >= 10) { #jika sudah diverifikasi, munculkan tanda tangannya...
                        if (file_exists($kabid->ttd_admin))
                            $ttd_kabid = '<br><img src="' . base_url() . $kabid->ttd_admin . '" style="height: ' . $this->tinggi_ttd . ';">';
                        else
                            $ttd_kabid = '<br><img src="' . base_url() . 'assets/images/no_ttd.jpg" style="height: ' . $this->tinggi_ttd . ';">';
                    }
                }

                ob_start();
                $html = '';
                $html .= '<div>No. : ' . $opening_meeting->nomor_surat . '
                <br>' . $konten['cabang'] . ', ' . $this->reformat_date($opening_meeting->tgl_surat, $option_dateformat) . '</div>';
                $html .= '<div>Kepada
                <br>' . $opening_meeting->nama_badan_usaha . ' ' . $opening_meeting->nama_perusahaan . '
                <br>' . $opening_meeting->alamat_perusahaan . '</div>';
                $html .= '<div>Perihal: <span style="font-weight: bold; text-decoration: underline">Pemberitahuan Batas Pemenuhan Dokumen TKDN</span></div>';
                $html .= '<div>Dengan hormat,</div>';
                $html .= '<div style="text-align: justify">Dengan ini Kami informasikan bahwa pekerjaan Jasa ' . $opening_meeting->permohonan_verifikasi . ' sesuai dengan Konfirmasi Order No. ' . $opening_meeting->nomor_oc . ' tanggal  ' . $this->reformat_date($opening_meeting->tgl_oc, $option_dateformat) . ' sampai saat ini ada dokumen yang belum terpenuhi. Sesuai dengan scope of work dalam konfirmasi order, bahwa batas waktu pemenuhan data dan dokumen sesuai checklist adalah ' . $opening_meeting->masa_collecting_dokumen . ' hari. Maka dari itu Kami informasikan agar dokumen yang diperlukan segera dilengkapi sebelum tanggal ' . $this->reformat_date($tgl_selesai, $option_dateformat) . '. Apabila sampai tanggal ' . $this->reformat_date($tgl_selesai, $option_dateformat) . ' dokumen belum terpenuhi, maka Konfirmasi Order No. ' . $opening_meeting->nomor_oc . ' Jasa ' . $opening_meeting->permohonan_verifikasi . ' akan Kami batalkan dan uang muka biaya verifikasi tidak dapat dikembalikan.</div>';
                $html .= '<div style="text-align: justify">Demikian pemberitahuan ini Kami sampaikan,  atas perhatian dan kerjasama Bapak/Ibu Kami ucapkan terima kasih.</div>';
                $html .= '<br>';
                $html .= '<div style="font-weight: bold;">' . $konten['nama_instansi'] . '<br>CABANG ' . strtoupper($konten['cabang']) . '</div>';
                $html .= $ttd_kabid;
                $html .= '<div style="font-weight: bold;"><span style="text-decoration: underline">' . $nama_kabid . '</span><br>Kepala Bidang IG</div>';

                $this->setting_portrait(true);
                $this->pdf->SetFont('helvetica', '', 12);
                $this->pdf->SetAutoPageBreak(TRUE, 10);
                $this->pdf->writeHTML($html, true, false, true, false, '');
                if ($attach == 'ya') {
                    $filename = FCPATH . 'assets/uploads/dokumen/' . $opening_meeting->id_pelanggan . '/Surat Pemberitahuan Pemenuhan Dokumen.pdf';
                    $this->pdf->Output($filename, 'F');

                    return $filename;
                } else {
                    $this->pdf->Output('Surat Pemberitahuan Pemenuhan Dokumen.pdf', 'I');
                }
            } else {
                $this->lost();
            }
        } else {
            $this->lost();
        }
    }
}
