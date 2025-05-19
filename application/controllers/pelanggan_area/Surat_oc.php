
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Surat_oc extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Surat_oc_model", "surat_oc");
    }

    var $manual_tipe_file = 'application/pdf'; //,image/jpeg';
    public function upload_bukti_bayar()
    {
        if ($this->validasi_login_pelanggan()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_pelanggan = $this->session->userdata('id_pelanggan');

                $id_dokumen_permohonan = htmlentities($this->input->post('id_dokumen_permohonan') ?? '');
                $action = htmlentities($this->input->post('action') ?? '');
                $user_update = $this->session->userdata('id_pelanggan');
                $time_update = date('Y-m-d H:i:s');

                $join[0] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[1] = array('tabel' => 'rab', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');
                $join[2] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[3] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[4] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                $where = array('surat_oc.active' => 1, 'dokumen_permohonan.id_dokumen_permohonan' => $id_dokumen_permohonan, 'dokumen_permohonan.id_pelanggan' => $user_update, 'status_pengajuan >=' => 21);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->surat_oc->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $surat_oc = $load_data->row();

                    $allow = true;
                    #cek jika status_pengajuan >= 25, apakah pernah di bypass.. 
                    #jika tidak ada by pass, maka tidak boleh upload...
                    if ($surat_oc->status_pengajuan >= 25) {
                        $this->load->model('log_verifikasi_model', 'log_verifikasi');
                        $where_log = "active = 1 and id_dokumen_permohonan = '" . $surat_oc->id_dokumen_permohonan . "' and alasan_verifikasi like '%Alasan bypass:%'";
                        $cek = $this->log_verifikasi->is_available($where_log);
                        if (!$cek) {
                            $allow = false;
                        }
                    }

                    if ($allow) {
                        $data_update_oc = array(
                            'time_update' => $time_update,
                            'user_update' => $user_update
                        );

                        $id_dokumen_permohonan = $surat_oc->id_dokumen_permohonan;
                        $id_surat_oc = $surat_oc->id_surat_oc;
                        $nama_perusahaan = $surat_oc->nama_badan_usaha . ' ' . $surat_oc->nama_perusahaan;

                        $allow = true;
                        $dir = 'assets/uploads/dokumen/' . $id_pelanggan . '/';

                        if (isset($_FILES['bukti_bayar'])) {
                            $var = array(
                                'dir' => $dir,
                                'allowed_types' => 'pdf|jpeg|jpg',
                                'file' => 'bukti_bayar',
                                'encrypt_name' => true,
                                'new_name' => 'Bukti Bayar-' . $nama_perusahaan . '-' . date('ymd') . '-' . $this->generateRandomString(5), #string => isi jika ingin merename nama file sesuai kebutuhan. biarkan kosong jika tidak ingin rename.
                            );
                            $hasil = $this->upload_v2($var);
                            if ($hasil['sts']) {
                                $data_update_oc['bukti_bayar'] = $dir . $hasil['file'];
                            } else {
                                $allow = false;
                                $return['sts'] = 'upload_error';
                                $return['error_msg'] = $hasil['msg'];
                            }
                        }

                        if (isset($_FILES['surat_oc_pelanggan'])) {
                            $var_surat_oc = array(
                                'dir' => $dir,
                                'allowed_types' => 'pdf',
                                'file' => 'surat_oc_pelanggan',
                                'encrypt_name' => true,
                                'new_name' => 'Surat OC Pelanggan-' . $nama_perusahaan . '-' . date('ymd') . '-' . $this->generateRandomString(5), #string => isi jika ingin merename nama file sesuai kebutuhan. biarkan kosong jika tidak ingin rename.
                            );
                            $hasil = $this->upload_v2($var_surat_oc);
                            if ($hasil['sts']) {
                                $data_update_oc['surat_oc_pelanggan'] = $dir . $hasil['file'];
                            } else {
                                $allow = false;
                                $return['sts'] = 'upload_error';
                                $return['error_msg'] = $hasil['msg'];
                            }
                        }

                        if ($allow) {
                            $where = array('id_surat_oc' => $id_surat_oc);
                            $exe = $this->surat_oc->update($data_update_oc, $where, $user_update, 'pelanggan');
                            if ($exe) {
                                #update status permohonan...
                                $this->simpan_log_verifikasi($id_dokumen_permohonan, 23);
                            }
                            $return['sts'] = $exe;
                        }
                    } else {
                        $return['sts'] = 'tidak_berhak_akses_data';
                    }
                } else {
                    $return['sts'] = 'tidak_berhak_akses_data';
                }
            }
            echo json_encode($return);
        }
    }
}
