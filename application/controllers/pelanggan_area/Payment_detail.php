
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_detail extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("payment_detail_model", "payment_detail");
    }

    var $manual_tipe_file = 'application/pdf';
    public function upload_bukti_potong_pph21()
    {
        if ($this->validasi_login_pelanggan()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_dokumen_permohonan = htmlentities($this->input->post('id_dokumen_permohonan') ?? '');
                $action = htmlentities($this->input->post('action') ?? '');
                $user_update = $this->session->userdata('id_pelanggan');
                $time_update = date('Y-m-d H:i:s');

                $join[0] = array('tabel' => 'form_01', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_oc', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_penawaran', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[3] = array('tabel' => 'rab', 'relation' => 'surat_penawaran.id_rab = rab.id_rab', 'direction' => 'left');
                $join[4] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[5] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[6] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');
                $where = array('surat_oc.active' => 1, 'dokumen_permohonan.id_dokumen_permohonan' => $id_dokumen_permohonan, 'dokumen_permohonan.id_pelanggan' => $user_update, 'status_pengajuan >=' => 29);
                $data_send = array('where' => $where, 'join' => $join);
                $load_data = $this->payment_detail->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    $payment_detail = $load_data->row();

                    $id_payment_detail = $payment_detail->id_payment_detail;
                    $id_dokumen_permohonan = $payment_detail->id_dokumen_permohonan;
                    $nama_perusahaan = $payment_detail->nama_badan_usaha . ' ' . $payment_detail->nama_perusahaan;

                    $dir_parent = 'assets/uploads/dokumen';
                    $dir = $dir_parent . '/' . $user_update;

                    $new_name = 'Bukti Potong PPh 23-' . $nama_perusahaan . '-' . date('YmdHis') . $this->generateRandomString(5);
                    $variable = array(
                        'new_name' => $new_name,
                        'dir' => $dir,
                    );
                    $allow = true;
                    $bukti_potong_pph21 = '';
                    if (isset($_FILES['bukti_potong_pph21'])) {
                        $var_bukti_potong_pph21 = $variable;
                        $var_bukti_potong_pph21['file'] = 'bukti_potong_pph21';
                        $result = $this->upload($var_bukti_potong_pph21);
                        if ($result['sts'] == 'sukses') {
                            $bukti_potong_pph21 = $dir . '/' . str_replace(' ', '_', $new_name) . '.pdf';
                        } else {
                            $allow = false;
                            $return['sts'] = 'upload_error';
                            $return['error_msg'] = $result['msg'];
                        }
                    } else {
                        $allow = false;
                        $return['sts'] = 'kosong';
                    }

                    if ($allow) {
                        $data = array(
                            'bukti_potong_pph21' => $bukti_potong_pph21,
                            'time_update' => $time_update,
                            'user_update' => $user_update
                        );

                        $where = array('id_payment_detail' => $id_payment_detail);
                        $exe = $this->payment_detail->update($data, $where, $user_update, 'pelanggan');

                        $return['sts'] = $exe;
                    }
                } else {
                    $return['sts'] = 'tidak_berhak_akses_data';
                }
            }
            echo json_encode($return);
        }
    }
}
