
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Surat_penawaran extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Surat_penawaran_model", "surat_penawaran");
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {

                $id_rab = $data_receive->id_rab;
                $relation[0] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');

                $where = "surat_penawaran.active = 1  and rab.active = 1  and rab.id_rab = '" . $id_rab . "'";
                $send_data = array('where' => $where, 'join' => $relation);
                $load_data = $this->surat_penawaran->load_data($send_data);
                $result = $load_data->result();

                $result = array('result' => $result);

                echo json_encode($result);
            }
        }
    }
    public function rilis()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $relation[0] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $relation[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'rab.id_dokumen_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $relation[2] = array('tabel' => 'pelanggan', 'relation' => 'pelanggan.id_pelanggan = dokumen_permohonan.id_pelanggan', 'direction' => 'left');
                $relation[3] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'pelanggan.id_tipe_badan_usaha = tipe_badan_usaha.id_tipe_badan_usaha', 'direction' => 'left');

                $where = "surat_penawaran.active = 1  and rab.active = 1";
                $send_data = array('where' => $where, 'join' => $relation);
                $load_data = $this->surat_penawaran->load_data($send_data);
                $result = $load_data->result();

                $result = array('result' => $result);

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
                $id_surat_penawaran = htmlentities($this->input->post('id_surat_penawaran') ?? '');
                $id_rab = htmlentities($this->input->post('id_rab') ?? '');
                $id_dokumen_permohonan = htmlentities($this->input->post('id_dokumen_permohonan') ?? '');
                $jns_surat_penawaran = htmlentities($this->input->post('jns_surat_penawaran') ?? '');
                $nama_up = htmlentities($this->input->post('nama_up') ?? '');
                $nomor_surat_penawaran = htmlentities($this->input->post('nomor_surat_penawaran') ?? '');
                $tgl_surat_penawaran = htmlentities($this->input->post('tgl_surat_penawaran') ?? '');
                $nomor_surat_permohonan = htmlentities($this->input->post('nomor_surat_permohonan') ?? '');
                $tgl_surat_permohonan = htmlentities($this->input->post('tgl_surat_permohonan') ?? '');
                $permohonan_verifikasi = htmlentities($this->input->post('permohonan_verifikasi') ?? '');
                $rincian_produk_pekerjaan = htmlentities($this->input->post('rincian_produk_pekerjaan') ?? '');
                $status_transport_akomodasi = htmlentities($this->input->post('status_transport_akomodasi') ?? '');
                $point_b2 = htmlentities($this->input->post('point_b2') ?? '');
                $termin_1 = htmlentities($this->input->post('termin_1') ?? '');
                $termin_2 = htmlentities($this->input->post('termin_2') ?? '');
                $masa_berlaku_penawaran = htmlentities($this->input->post('masa_berlaku_penawaran') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $action = htmlentities($this->input->post('action') ?? '');

                if ($jns_surat_penawaran == 'bmp') {
                    $point_b2 = 'Sesuai dengan Surat Permohonan Nomor <b>' . $nomor_surat_permohonan . '</b>';
                }

                #jika action memiliki value 'save' maka data akan disimpan.
                #jika action tidak memiliki value, maka akan dianggap sebagai upadate.
                if ($action == 'save') {
                    $data = array(
                        'id_rab' => $id_rab,
                        'jns_surat_penawaran' => $jns_surat_penawaran,
                        'nomor_surat_penawaran' => $nomor_surat_penawaran,
                        'nama_up' => $nama_up,
                        'tgl_surat_penawaran' => $tgl_surat_penawaran,
                        'nomor_surat_permohonan' => $nomor_surat_permohonan,
                        'tgl_surat_permohonan' => $tgl_surat_permohonan,
                        'permohonan_verifikasi' => $permohonan_verifikasi,
                        'rincian_produk_pekerjaan' => $rincian_produk_pekerjaan,
                        'point_b2' => ($point_b2 ?? 'Pelaporan'),
                        'termin_1' => $termin_1,
                        'termin_2' => $termin_2,
                        'masa_berlaku_penawaran' => $masa_berlaku_penawaran,
                        'status_transport_akomodasi' => $status_transport_akomodasi,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $exe = $this->surat_penawaran->save($data);
                    $return['sts'] = $exe;
                    if ($exe) {
                        $this->simpan_log_verifikasi($id_dokumen_permohonan, 8);
                    }
                } else {
                    $this->load->model('log_verifikasi_model', 'log_verifikasi');
                    $where_nego = "active = 1 and id_dokumen_permohonan = '" . $id_dokumen_permohonan . "' and status_verifikasi = '11'";
                    $pernah_nego = $this->log_verifikasi->is_available($where_nego);
                    $butuh_verifikasi_koordinator = 0;
                    if ($pernah_nego) {
                        $butuh_verifikasi_koordinator = 1;
                    }
                    $data = array(
                        'jns_surat_penawaran' => $jns_surat_penawaran,
                        'nomor_surat_penawaran' => $nomor_surat_penawaran,
                        'tgl_surat_penawaran' => $tgl_surat_penawaran,
                        'nama_up' => $nama_up,
                        'nomor_surat_permohonan' => $nomor_surat_permohonan,
                        'tgl_surat_permohonan' => $tgl_surat_permohonan,
                        'permohonan_verifikasi' => $permohonan_verifikasi,
                        'rincian_produk_pekerjaan' => $rincian_produk_pekerjaan,
                        'point_b2' => ($point_b2 ?? 'Pelaporan'),
                        'termin_1' => $termin_1,
                        'termin_2' => $termin_2,
                        'masa_berlaku_penawaran' => $masa_berlaku_penawaran,
                        'status_transport_akomodasi' => $status_transport_akomodasi,
                        'id_kabid' => null,
                        'butuh_verifikasi_koordinator' => $butuh_verifikasi_koordinator,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where = array('id_surat_penawaran' => $id_surat_penawaran, 'id_rab' => $id_rab);
                    $exe = $this->surat_penawaran->update($data, $where);
                    if ($exe) {
                        $this->simpan_log_verifikasi($id_dokumen_permohonan, 8);
                    }
                    $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }

    public function verifikasi_surat_penawaran()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_dokumen_permohonan = $data_receive->id_dokumen_permohonan;
                $id_surat_penawaran = $data_receive->id_surat_penawaran;
                $status_verifikasi = ($data_receive->status_verifikasi == 'setuju' ? 10 : 9);
                if ($data_receive->status_verifikasi == 'setuju') {
                    #cek apakah permohonan berbayar pemerintah atau bukan.
                    $join[0] = array('tabel' => 'rab', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                    $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                    $where = array('surat_penawaran.active' => 1, 'id_surat_penawaran' => $id_surat_penawaran, 'tipe_pengajuan' => 'PEMERINTAH');
                    $data_send = array('where' => $where, 'join' => $join);
                    $load_data = $this->surat_penawaran->load_data($data_send);
                    if ($load_data->num_rows() > 0) {
                        #jika pemerintah, maka lanjut ke Input masa collecting dokumen
                        $status_verifikasi = 12;
                    } else {
                        #cek apakah yang verifikasi koordinator atau bukan...
                        if ($this->session->userdata('id_jns_admin') == 2) {
                            $status_verifikasi = 8;

                            $data = array('butuh_verifikasi_koordinator' => '0');
                            $where = array('id_surat_penawaran' => $id_surat_penawaran);
                            $this->surat_penawaran->update($data, $where);
                        } else {
                            $status_verifikasi = 10;
                        }
                    }
                } else {
                    $status_verifikasi = 9;
                }
                $alasan_verifikasi = (isset($data_receive->alasan_verifikasi) ? $data_receive->alasan_verifikasi : '');

                $exe = $this->simpan_log_verifikasi($id_dokumen_permohonan, $status_verifikasi, $alasan_verifikasi);
                if ($status_verifikasi == 10) {
                    $data = array('id_kabid' => $this->session->userdata('id_admin'));
                    $where = array('id_surat_penawaran' => $id_surat_penawaran);
                    $this->surat_penawaran->update($data, $where);
                }
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
