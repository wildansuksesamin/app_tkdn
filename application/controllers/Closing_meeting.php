
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Closing_meeting extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Closing_meeting_model", "closing_meeting");
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);
                $join[0] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_opening_meeting = closing_meeting.id_opening_meeting', 'direction' => 'left');
                $join[1] = array('tabel' => 'dokumen_permohonan', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = opening_meeting.id_permohonan', 'direction' => 'left');
                $join[2] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[3] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

                $join[4] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[5] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[6] = array('tabel' => 'surat_oc', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[7] = array('tabel' => 'proforma_invoice', 'relation' => 'proforma_invoice.id_surat_oc = surat_oc.id_surat_oc', 'direction' => 'left');
                $join[8] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[9] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');


                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $order = "id_closing_meeting asc";

                $where = "closing_meeting.active = 1  and opening_meeting.active = 1 and (nomor_order_payment like '%" . $filter . "%' or sub_unit_kerja like '%" . $filter . "%' or concat(nama_badan_usaha, ' ', nama_perusahaan) like '%" . $filter . "%')";

                if (isset($data_receive->for)) {
                    $for = htmlentities($data_receive->for ?? '');
                    if ($for == 'upload_closing_meeting') {
                        $where .= " and closing_meeting.status IN (0,1)";
                    } else if ($for == 'verifikasi_closing_meeting') {

                        $id_jns_admin = $this->session->userdata('id_jns_admin');
                        #cek apakah jenis admin adalah koordinator atau dokumen kontrol...
                        $status = 'x';
                        if ($id_jns_admin == 2) { #koordinator...
                            $status = 3;
                        } else if ($id_jns_admin == 8) { #dokumen kontrol...
                            $status = 2;
                        }
                        $where .= " and closing_meeting.status = '" . $status . "'";
                    }
                }

                $send_data = array('where' => $where, 'join' => $join, 'limit' => $limit, 'order' => $order);
                $load_data = $this->closing_meeting->load_data($send_data);
                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $row) {
                        $row->assesor_lapangan = $this->AssesorLapangan($row->id_opening_meeting);
                    }
                }
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'join' => $join, 'select' => $select);
                $load_data = $this->closing_meeting->load_data($send_data);
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
                $id_closing_meeting = htmlentities($this->input->post('id_closing_meeting') ?? '');
                $id_opening_meeting = htmlentities($this->input->post('id_opening_meeting') ?? '');
                $tahap_closing_meeting = htmlentities($this->input->post('tahap_closing_meeting') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $action = htmlentities($this->input->post('action') ?? '');

                #jika action memiliki value 'save' maka data akan disimpan.
                #jika action tidak memiliki value, maka akan dianggap sebagai upadate.
                if ($action == 'save') {
                    $data = array(
                        'id_opening_meeting' => $id_opening_meeting,
                        'tahap_closing_meeting' => $tahap_closing_meeting,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $exe = $this->closing_meeting->save($data);
                    $return['sts'] = $exe;
                } else {
                    $data = array(
                        'id_opening_meeting' => $id_opening_meeting,
                        'tahap_closing_meeting' => $tahap_closing_meeting,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where = array('id_closing_meeting' => $id_closing_meeting);
                    $exe = $this->closing_meeting->update($data, $where);
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
            $id_closing_meeting = $data_receive->id_closing_meeting;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $where = array('id_closing_meeting' => $id_closing_meeting);
                $exe = $this->closing_meeting->soft_delete($where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
