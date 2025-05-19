
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Verifikasi_tkdn extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('dokumen_permohonan_model', 'dokumen_permohonan');
        $this->load->model('collecting_dokumen_model', 'collecting_dokumen');
        $this->load->model('opening_meeting_model', 'opening_meeting');
        $this->load->model('log_status_verifikasi_tkdn_model', 'log_status_verifikasi_tkdn');
        $this->load->model('pemberitahuan_pemenuhan_dokumen_model', 'pemberitahuan_pemenuhan_dokumen');
        $this->load->model('rab_detail_model', 'rab_detail');
        $this->load->model('sppd_model', 'sppd');
        $this->load->model('survey_lapangan_perjab_model', 'survey_lapangan_perjab');
        $this->load->model('panel_internal_dokumen_model', 'panel_internal_dokumen');
        $this->load->model('panel_kemenperin_nama_file_model', 'panel_kemenperin_nama_file');
        $this->load->model('panel_kemenperin_dokumen_model', 'panel_kemenperin_dokumen');
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $filter = (isset($data_receive->filter) ? htmlentities($data_receive->filter ?? '') : null);
                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $join[0] = array('tabel' => 'rab', 'relation' => 'dokumen_permohonan.id_dokumen_permohonan = rab.id_dokumen_permohonan', 'direction' => 'left');
                $join[1] = array('tabel' => 'surat_penawaran', 'relation' => 'rab.id_rab = surat_penawaran.id_rab', 'direction' => 'left');
                $join[2] = array('tabel' => 'surat_oc', 'relation' => 'surat_penawaran.id_surat_penawaran = surat_oc.id_surat_penawaran', 'direction' => 'left');
                $join[3] = array('tabel' => 'proforma_invoice', 'relation' => 'proforma_invoice.id_surat_oc = surat_oc.id_surat_oc', 'direction' => 'left');
                $join[4] = array('tabel' => 'form_01', 'relation' => 'surat_oc.id_surat_oc = form_01.id_surat_oc', 'direction' => 'left');
                $join[5] = array('tabel' => 'payment_detail', 'relation' => 'form_01.id_form_01 = payment_detail.id_form_01', 'direction' => 'left');

                $join[6] = array('tabel' => 'pelanggan', 'relation' => 'dokumen_permohonan.id_pelanggan = pelanggan.id_pelanggan', 'direction' => 'left');
                $join[7] = array('tabel' => 'tipe_badan_usaha', 'relation' => 'tipe_badan_usaha.id_tipe_badan_usaha = pelanggan.id_tipe_badan_usaha', 'direction' => 'left');

                $join[8] = array('tabel' => 'tipe_permohonan', 'relation' => 'tipe_permohonan.id_tipe_permohonan = dokumen_permohonan.id_tipe_permohonan', 'direction' => 'left');
                $join[9] = array('tabel' => 'opening_meeting', 'relation' => 'opening_meeting.id_permohonan = dokumen_permohonan.id_dokumen_permohonan', 'direction' => 'left');
                $join[10] = array('tabel' => 'mst_admin', 'relation' => 'opening_meeting.id_assesor = mst_admin.id_admin', 'direction' => 'left');

                $where = "dokumen_permohonan.active = 1 and status_pengajuan = 34 and (nomor_order_payment like '%" . $filter . "%' or sub_unit_kerja like '%" . $filter . "%' or concat(nama_badan_usaha, ' ', nama_perusahaan) like '%" . $filter . "%')";
                if (isset($data_receive->for)) {
                    if ($data_receive->for == 'histori_dokumen_verifikasi') {
                        if ($this->session->userdata('id_jns_admin') == '3') { #khusus Verifikator
                            $where .= " and (opening_meeting.id_assesor = '" . $this->session->userdata('id_admin') . "'
                                or opening_meeting.id_opening_meeting in (select id_opening_meeting from opening_meeting_asisten_assesor a where a.active = 1 and a.id_admin = '" . $this->session->userdata('id_admin') . "')
                                or opening_meeting.id_opening_meeting in (select id_opening_meeting from survey_lapangan_assesor b where b.active = 1 and b.id_admin = '" . $this->session->userdata('id_admin') . "')
                                )";
                        }
                    }
                    if ($data_receive->for == 'buat_surat_tugas') {
                        #tampilkan data yang belum ada surat tugasnya untuk Verifikator bersangkutan...
                        $where .= " and id_status IN (1, 2) and opening_meeting.id_assesor = '" . $this->session->userdata('id_admin') . "'";
                    }
                    if ($data_receive->for == 'upload_dokumen_opening_meeting') {
                        #tampilkan data yang sudah ada surat tugasnya untuk Verifikator bersangkutan...
                        $where .= " and id_status = 3 and opening_meeting.id_assesor = '" . $this->session->userdata('id_admin') . "'";
                    }
                    if ($data_receive->for == 'verifikasi_dokumen_opening_meeting') {
                        #tampilkan data yang sudah ada surat tugasnya untuk Verifikator bersangkutan...
                        $where .= " and id_status = 5 and opening_meeting.id_assesor = '" . $this->session->userdata('id_admin') . "'";
                    }
                    if ($data_receive->for == 'collecting_document') {
                        $where .= " and (id_status >= 7 and id_status < 15) and (opening_meeting.id_assesor = '" . $this->session->userdata('id_admin') . "' or opening_meeting.id_opening_meeting IN (select id_opening_meeting from opening_meeting_asisten_assesor where active = 1 and id_admin = '" . $this->session->userdata('id_admin') . "'))";
                    }
                    if ($data_receive->for == 'penugasan_assesor_lapangan') {
                        $where .= " and id_status >= 15";
                    }
                    if ($data_receive->for == 'pekerjaan') {
                        $where .= " and id_status >= 15 and id_opening_meeting IN (select id_opening_meeting from survey_lapangan_assesor a where a.active = 1 and a.id_admin = '" . $this->session->userdata('id_admin') . "')";
                    }
                    if ($data_receive->for == 'subsidi_silang') {
                        $where .= " and rab.id_assesor = '" . htmlentities($data_receive->id_assesor ?? '') . "' and dokumen_permohonan.id_dokumen_permohonan != '" . htmlentities($data_receive->id_dokumen_permohonan ?? '') . "'";
                    }
                    if ($data_receive->for == 'collecting_document_tahap_2') {
                        $where .= " and id_status = 16 and id_opening_meeting IN (select id_opening_meeting from survey_lapangan_assesor a where a.active = 1 and a.id_admin = '" . $this->session->userdata('id_admin') . "')";
                    }
                    if ($data_receive->for == 'upload_dokumen_panel_dokumen') {
                        $where .= " and (id_status >= 17 and id_status <= 18)";
                        $id_jns_admin = $this->session->userdata('id_jns_admin');
                        if ($id_jns_admin == 3) {
                            $where .= " and id_opening_meeting IN (select id_opening_meeting from survey_lapangan_assesor a where a.active = 1 and a.id_admin = '" . $this->session->userdata('id_admin') . "')";
                        }
                    }
                    if ($data_receive->for == 'verifikasi_panel_internal') {
                        $where .= " and id_status = 19";
                    }
                    if ($data_receive->for == 'penugasan_etc') {
                        $where .= " and id_status = 20";
                    }
                    if ($data_receive->for == 'approval_assesment_etc') {
                        $where .= " and id_status = 21 and id_opening_meeting IN (select id_opening_meeting from opening_meeting_etc where opening_meeting_etc.active = 1 and opening_meeting_etc.id_admin = '" . $this->session->userdata('id_admin') . "')";
                    }
                    if ($data_receive->for == 'verifikasi_draft_tanda_sah') {
                        $where .= " and id_status = 24";
                    }
                    if ($data_receive->for == 'assesment_kemenperin') {
                        $where .= " and (
                            id_status IN (25, 26) 
                            or (
                                select count(-1) jml 
                                from panel_kemenperin_dokumen 
                                where panel_kemenperin_dokumen.active = 1 
                                    and id_closing_meeting = 0 
                                    and panel_kemenperin_dokumen.id_opening_meeting = opening_meeting.id_opening_meeting 
                                    and id_nama_file in 
                                        (
                                        select id_nama_file 
                                        from panel_kemenperin_nama_file 
                                        where panel_kemenperin_nama_file.active = 1 and to_closing_meeting = 1
                                        )
                            ) > 0
                        )";
                    }
                    if ($data_receive->for == 'upload_closing_meeting') {
                        $where .= " and id_status IN (26, 27)";
                    }
                    if ($data_receive->for == 'verifikasi_closing_meeting') {
                        $where .= " and id_status = 28";
                    }
                }
                $data_send = array('where' => $where, 'join' => $join, 'limit' => $limit);
                $load_data = $this->dokumen_permohonan->load_data($data_send);
                if ($load_data->num_rows() > 0) {
                    foreach ($load_data->result() as $row) {
                        #surat tugas opening meeting... 
                        $row->surat_tugas = $this->suratTugasOpeningMeeting($row->id_opening_meeting);
                        #Verifikator lama...
                        $row->assesor = $this->siapaAssesor($row->id_dokumen_permohonan);

                        #asisten Verifikator...
                        $row->asisten_assesor = $this->AsistenAssesor($row->id_opening_meeting);

                        $row->orang_etc = $this->OrangEtc($row->id_opening_meeting);

                        #verifikator survey lapangan
                        if ($data_receive->for == 'penugasan_assesor_lapangan') {
                            $row->assesor_lapangan = $this->AssesorLapangan($row->id_opening_meeting);
                        }

                        if ($data_receive->for == 'histori_dokumen_verifikasi' or $data_receive->for == 'pekerjaan') {
                            $row->assesor_lapangan = $this->AssesorLapangan($row->id_opening_meeting);
                            $row->surat_tugas_lapangan = $this->suratTugasLapangan($row->id_opening_meeting);
                            $row->sppd = $this->getSPPD($row->id_opening_meeting);
                            $row->rab = $this->getRAB($row->id_opening_meeting);
                            $row->realisasi_anggaran = $this->getRealisasiAnggaran($row->id_opening_meeting);
                            $row->subsidi_silang = $this->getSubsidiSilang($row->id_opening_meeting);
                            $row->collecting_document_2 = $this->getCollectingDokumen2($row->id_opening_meeting);
                            $row->panel_internal = $this->getPanelInternal($row->id_opening_meeting);
                            $row->panel_kemenperin = $this->getPanelKemenperin($row->id_opening_meeting);
                            $row->closing_meeting = $this->getClosingMeeting($row->id_opening_meeting);
                        }

                        #only for pekerjaan...
                        if ($data_receive->for == 'pekerjaan') {
                            $row->dokumen_tolak = $this->getSurveyLapanganDokumen($row->id_opening_meeting, 0);
                            $row->for = $data_receive->for;
                            #mencari detail rab...
                            $hasil = $this->getDetailRAB($row);
                            $row->detail_rab = $hasil['detail_rab'];
                            $row->anggaran = $hasil['anggaran'];
                        }

                        if ($data_receive->for == 'subsidi_silang') {
                            #mencari detail rab...
                            $hasil = $this->getDetailRAB($row);
                            $row->detail_rab = $hasil['detail_rab'];
                            $row->anggaran = $hasil['anggaran'];
                        }

                        if ($data_receive->for == 'collecting_document_tahap_2') {
                            #mencari dokumen
                            $dokumen_menunggu_verifikasi = false;
                            $this->load->model('collecting_dokumen_tahap2_model', 'collecting_dokumen_tahap2');
                            $where_collecting_dokumen_tahap2 = array('collecting_dokumen_tahap2.active' => 1, 'id_opening_meeting' => $row->id_opening_meeting);
                            $data_send_collecting_dokumen_tahap2 = array('where' => $where_collecting_dokumen_tahap2);
                            $load_data_collecting_dokumen_tahap2 = $this->collecting_dokumen_tahap2->load_data($data_send_collecting_dokumen_tahap2);
                            if ($load_data_collecting_dokumen_tahap2->num_rows() > 0) {
                                foreach ($load_data_collecting_dokumen_tahap2->result() as $list) {
                                    if ($list->status_verifikasi == 2) {
                                        $dokumen_menunggu_verifikasi = true;
                                    }
                                }
                            }

                            $row->collecting_dokumen_tahap2 = array(
                                'jml_dokumen' => $load_data_collecting_dokumen_tahap2->num_rows(),
                                'list_dokumen' => $load_data_collecting_dokumen_tahap2->result(),
                                'dokumen_menunggu_verifikasi' => $dokumen_menunggu_verifikasi
                            );
                        }

                        if ($data_receive->for == 'upload_dokumen_panel_dokumen') {
                            $row->assesor_lapangan = $this->AssesorLapangan($row->id_opening_meeting);
                            $row->status = array('warning', 'Upload dokumen');

                            $jml_setuju = 0;
                            $jml_tolak = 0;
                            $jml_menunggu = 0;
                            #cek apakah dokumen ada yang ditolak
                            $where_dokumen = array('panel_internal_dokumen.active' => 1, 'id_opening_meeting' => $row->id_opening_meeting);
                            $data_send_dokumen = array('where' => $where_dokumen);
                            $load_data_dokumen = $this->panel_internal_dokumen->load_data($data_send_dokumen);
                            if ($load_data_dokumen->num_rows() > 0) {
                                foreach ($load_data_dokumen->result() as $dokumen) {
                                    if ($dokumen->status_verifikasi == 1) {
                                        $jml_setuju++;
                                    } else if ($dokumen->status_verifikasi == 0) {
                                        $jml_tolak++;
                                    } else if ($dokumen->status_verifikasi == 2) {
                                        $jml_menunggu++;
                                    }
                                }
                            }

                            #cek apakah lhv ada yang ditolak...
                            $this->load->model('panel_internal_lhv_model', 'panel_internal_lhv');
                            $where_lhv = array('panel_internal_lhv.active' => 1, 'id_opening_meeting' => $row->id_opening_meeting);
                            $data_send_lhv = array('where' => $where_lhv);
                            $load_data_lhv = $this->panel_internal_lhv->load_data($data_send_lhv);
                            if ($load_data_lhv->num_rows() > 0) {
                                foreach ($load_data_lhv->result() as $dokumen) {
                                    if ($dokumen->status_verifikasi == 1) {
                                        $jml_setuju++;
                                    } else if ($dokumen->status_verifikasi == 0) {
                                        $jml_tolak++;
                                    } else if ($dokumen->status_verifikasi == 2) {
                                        $jml_menunggu++;
                                    }
                                }
                            }

                            if ($load_data_dokumen->num_rows() > 0) {
                                if ($jml_tolak > 0) {
                                    $row->status = array('danger', 'Ditolak');
                                } else if ($jml_tolak == 0 and $jml_menunggu > 0) {
                                    $row->status = array('primary', 'Dalam Proses');
                                } else if ($jml_setuju == $load_data_dokumen->num_rows()) {
                                    $row->status = array('success', 'Disetujui');
                                }
                            } else {
                                $row->status = array('primary', 'Dalam Proses');
                            }
                        }

                        if ($data_receive->for == 'verifikasi_panel_internal') {
                            $row->assesor_lapangan = $this->AssesorLapangan($row->id_opening_meeting);
                        }

                        if ($data_receive->for == 'penugasan_etc') {
                            $row->assesor_lapangan = $this->AssesorLapangan($row->id_opening_meeting);
                            $row->jml_etc = $this->jmlETC($row->id_opening_meeting);
                        }

                        if ($data_receive->for == 'approval_assesment_etc') {
                            $row->assesor_lapangan = $this->AssesorLapangan($row->id_opening_meeting);
                            $row->OrangEtc = $this->OrangEtc($row->id_opening_meeting);

                            $dokumen = array();
                            #draft tanda sah...
                            $where_draft_tanda_sah = array('panel_internal_dokumen.active' => 1, 'id_opening_meeting' => $row->id_opening_meeting, 'id_nama_file' => 1);
                            $data_send_draft_tanda_sah = array('where' => $where_draft_tanda_sah);
                            $load_data_draft_tanda_sah = $this->panel_internal_dokumen->load_data($data_send_draft_tanda_sah);
                            $dokumen['draft_tanda_sah'] = $load_data_draft_tanda_sah->result();

                            #Assesment
                            $where_assesment = array('panel_internal_dokumen.active' => 1, 'id_opening_meeting' => $row->id_opening_meeting, 'id_nama_file' => 2);
                            $data_send_assesment = array('where' => $where_assesment);
                            $load_data_assesment = $this->panel_internal_dokumen->load_data($data_send_assesment);
                            $dokumen['assesment'] = $load_data_assesment->result();

                            #LHV
                            $this->load->model('panel_internal_lhv_model', 'panel_internal_lhv');
                            $where_lhv = array('panel_internal_lhv.active' => 1, 'id_opening_meeting' => $row->id_opening_meeting);
                            $data_send_lhv = array('where' => $where_lhv);
                            $load_data_lhv = $this->panel_internal_lhv->load_data($data_send_lhv);
                            $dokumen['lhv'] = $load_data_lhv->result();

                            $row->dokumen_for_etc = $dokumen;
                        }

                        if ($data_receive->for == 'verifikasi_draft_tanda_sah') {
                            $row->assesor_lapangan = $this->AssesorLapangan($row->id_opening_meeting);
                            $row->tanda_sah = null;

                            #mencari daftar sah yang diupload oleh pelanggan...

                            $where_dokumen = array('panel_internal_dokumen.active' => 1, 'id_opening_meeting' => $row->id_opening_meeting, 'id_nama_file' => 9);
                            $data_send_dokumen = array('where' => $where_dokumen);
                            $load_data_dokumen = $this->panel_internal_dokumen->load_data($data_send_dokumen);
                            if ($load_data_dokumen->num_rows() > 0) {
                                foreach ($load_data_dokumen->result() as $dokumen) {
                                    if ($dokumen->status_verifikasi == 0) {
                                        $dokumen->status = array('danger', 'Ditolak');
                                    } else if ($dokumen->status_verifikasi == 2) {
                                        $dokumen->status = array('warning', 'Menunggu Verifikasi');
                                    } else if ($dokumen->status_verifikasi == 1) {
                                        $dokumen->status = array('success', 'Disetujui');
                                    }
                                }
                                $row->tanda_sah = $load_data_dokumen->result();
                            }
                        }

                        if ($data_receive->for == 'assesment_kemenperin') {
                            $id_opening_meeting = $row->id_opening_meeting;
                            $row->assesor_lapangan = $this->AssesorLapangan($id_opening_meeting);

                            #mencari file kemenperin...
                            $where_file_kemenperin = array('panel_kemenperin_nama_file.active' => 1);
                            $data_send_file_kemenperin = array('where' => $where_file_kemenperin);
                            $load_data_file_kemenperin = $this->panel_kemenperin_nama_file->load_data($data_send_file_kemenperin);
                            if ($load_data_file_kemenperin->num_rows() > 0) {
                                foreach ($load_data_file_kemenperin->result() as $file) {
                                    $where_file = array('panel_kemenperin_dokumen.active' => 1, 'id_nama_file' => $file->id_nama_file, 'id_opening_meeting' => $id_opening_meeting);
                                    $data_send_file = array('where' => $where_file);
                                    $load_data_file = $this->panel_kemenperin_dokumen->load_data($data_send_file);

                                    $file->files = $load_data_file->result();
                                }
                            }

                            $row->file_kemenperin = $load_data_file_kemenperin->result();
                        }
                        if ($data_receive->for == 'upload_closing_meeting') {
                            $row->assesor_lapangan = $this->AssesorLapangan($row->id_opening_meeting);
                        }
                        if ($data_receive->for == 'verifikasi_closing_meeting') {
                            $row->assesor_lapangan = $this->AssesorLapangan($row->id_opening_meeting);
                        }

                        #mencari surat pemberitahuan...
                        $row->surat_pemberitahuan_pemenuhan_dokumen = null;
                        $where_pemenuhan_dokumen = array('pemberitahuan_pemenuhan_dokumen.active' => 1, 'id_opening_meeting' => $row->id_opening_meeting);
                        $data_send_pemenuhan_dokumen = array('where' => $where_pemenuhan_dokumen);
                        $load_data_pemenuhan_dokumen = $this->pemberitahuan_pemenuhan_dokumen->load_data($data_send_pemenuhan_dokumen);
                        if ($load_data_pemenuhan_dokumen->num_rows() > 0) {
                            $row->surat_pemberitahuan_pemenuhan_dokumen = $load_data_pemenuhan_dokumen->row();
                        }

                        #apakah ada dokumen yang perlu diverifikasi...
                        $row->jml_verifikasi = $this->collecting_dokumen->is_available(array(
                            'active' => 1,
                            'id_opening_meeting' => $row->id_opening_meeting,
                            'status_verifikasi' => '0'
                        ));
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
    public function log_status()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $id_opening_meeting = htmlentities($data_receive->id_opening_meeting ?? '');

                $order = "id_opening_meeting DESC";
                $where = array('active' => 1, 'id_opening_meeting' => $id_opening_meeting);
                $data_send = array('where' => $where, 'order' => $order);
                $load_data = $this->log_status_verifikasi_tkdn->load_data($data_send);

                $result = $load_data->result();

                echo json_encode($result);
            }
        }
    }
}
