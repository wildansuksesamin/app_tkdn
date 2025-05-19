
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Verifikasi_tkdn extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Opening_meeting_model", "opening_meeting");
        $this->load->model('dokumen_permohonan_model', 'dokumen_permohonan');
        $this->load->model('surat_penawaran_model', 'surat_penawaran');
        $this->load->model('pemberitahuan_pemenuhan_dokumen_model', 'pemberitahuan_pemenuhan_dokumen');
    }

    public function load_data()
    {
        if ($this->validasi_login_pelanggan()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_pelanggan = $this->session->userdata('id_pelanggan');
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);
                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $join[0] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_oc', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[3] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[4] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');

                $join[5] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[6] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

                $join[7] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
                $join[8] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join[9] = array('tabel' => 'mst_admin', 'relation' => 'opening_meeting.id_assesor = mst_admin.id_admin', 'direction' => 'left');

                $where = array('' => 1, '' => 34);
                $where = "dokumen_permohonan.active = 1 and dokumen_permohonan.status_pengajuan = 34 and opening_meeting.id_status < 26 and dokumen_permohonan.id_pelanggan = '" . $id_pelanggan . "' and (nama_admin like '%" . $filter . "%' or nomor_order_payment like '%" . $filter . "%' or sub_unit_kerja like '%" . $filter . "%' or nama_tipe_permohonan like '%" . $filter . "%' or concat('Berbayar ', tipe_pengajuan) like '%" . $filter . "%')";
                $data_send = array('where' => $where, 'join' => $join, 'limit' => $limit);
                $load_data = $this->dokumen_permohonan->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $row) {
                        $row->pemberitahuan_pemenuhan_dokumen = null;

                        $where_pemberitahuan = array('pemberitahuan_pemenuhan_dokumen.active' => 1, 'id_opening_meeting' => $row->id_opening_meeting);
                        $data_send_pemberitahuan = array('where' => $where_pemberitahuan);
                        $load_data_pemberitahuan = $this->pemberitahuan_pemenuhan_dokumen->load_data($data_send_pemberitahuan);
                        if ($load_data_pemberitahuan->num_rows() > 0) {
                            $row->pemberitahuan_pemenuhan_dokumen = $load_data_pemberitahuan->row();
                        }

                        #get dokumen closing meeting...
                        if ($row->id_status >= 29) {
                            $row->closing_meeting = $this->getClosingMeeting($row->id_opening_meeting);
                        }
                    }
                }

                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'join' => $join, 'select' => $select);
                $load_data = $this->dokumen_permohonan->load_data($send_data);
                $total_data = $load_data->row()->jml;

                $last_page = ceil($total_data / $jml_data);
                $result = array('result' => $result, 'last_page' => $last_page);

                echo json_encode($result);
            }
        }
    }
}
