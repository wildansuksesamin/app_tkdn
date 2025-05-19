
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dokumen_permohonan_pic extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("dokumen_permohonan_pic_model", "dokumen_permohonan_pic");
        $this->load->model("dokumen_permohonan_model", "dokumen_permohonan");
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $relation[0] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = dokumen_permohonan_pic.id_dokumen_permohonan', 'direction' => 'left');
                $relation[1] = array('tabel' => 'mst_admin', 'relation' => 'mst_admin.id_admin = dokumen_permohonan_pic.id_admin', 'direction' => 'left');
                $relation[2] = array('tabel' => 'jns_admin', 'relation' => 'mst_admin.id_jns_admin = jns_admin.id_jns_admin', 'direction' => 'left');

                $where = "dokumen_permohonan_pic.active = 1  and dokumen_permohonan.active = 1";
                if (isset($data_receive->id_dokumen_permohonan)) {
                    $where .= " and dokumen_permohonan_pic.id_dokumen_permohonan = '" . $data_receive->id_dokumen_permohonan . "'";
                }
                if (isset($data_receive->id_jns_admin)) {
                    $where .= " and mst_admin.id_jns_admin = '" . $data_receive->id_jns_admin . "'";
                }
                $send_data = array('where' => $where, 'join' => $relation);
                $load_data = $this->dokumen_permohonan_pic->load_data($send_data);
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
                $id_dokumen_permohonan = htmlentities($this->input->post('id_dokumen_permohonan') ?? '');
                $id_admin = htmlentities($this->input->post('id_admin') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $where = array('active' => 1, 'id_admin' => $id_admin, 'id_dokumen_permohonan' => $id_dokumen_permohonan);
                $cek = $this->dokumen_permohonan_pic->is_available($where);
                if (!$cek) {
                    $data = array(
                        'id_dokumen_permohonan' => $id_dokumen_permohonan,
                        'id_admin' => $id_admin,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $exe = $this->dokumen_permohonan_pic->save($data);
                    $return['sts'] = $exe;

                    if ($exe) {
                        $this->simpan_log_verifikasi($id_dokumen_permohonan, 2);
                    }
                } else {
                    $return['sts'] = 'data_available';
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
            $id_pic = $data_receive->id_pic;
            $id_dokumen_permohonan = $data_receive->id_dokumen_permohonan;

            $time_update = date('Y-m-d H:i:s');
            $user_update = $this->session->userdata('id_admin');

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $where = array('id_pic' => $id_pic);
                $exe = $this->dokumen_permohonan_pic->soft_delete($where);
                $return['sts'] = $exe;

                $cek_where = array('active' => 1, 'id_dokumen_permohonan' => $id_dokumen_permohonan);
                $cek = $this->dokumen_permohonan_pic->is_available($cek_where);
                if (!$cek) {
                    #jika tidak ada verifikator, maka ubah statusnya menjadi menunggu penugasan...
                    $data = array(
                        'status_pengajuan' => 2,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where_update = array('id_dokumen_permohonan' => $id_dokumen_permohonan);
                    $this->dokumen_permohonan->update($data, $where_update);
                }
            }

            echo json_encode($return);
        }
    }
}
