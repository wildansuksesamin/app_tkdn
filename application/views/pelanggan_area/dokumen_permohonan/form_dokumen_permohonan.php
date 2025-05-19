<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->

<head>
    <?php $this->view('include/head'); ?>
    <?php $this->view('include/css'); ?>
</head>
<!-- end::Head -->
<!-- end::Body -->


<body <?php echo $body_parameter; ?>>
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <?php $this->view('pelanggan_area/include/top_navbar'); ?>
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <?php $this->view('pelanggan_area/include/left_side_navbar'); ?>
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                            <!--begin::Toolbar container-->
                            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                                <!--begin::Page title-->
                                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                    <!--begin::Title-->
                                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                        <?php echo $konten['title']; ?>
                                    </h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <button type="button" class="btn btn-sm fw-bold btn-secondary" onclick="window.history.back()">
                                        <i class="fa fa-arrow-left fs-1 me-2"></i>
                                        Kembali
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <div class="card card-flush">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>
                                                Form Permohonan TKDN
                                            </h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17">
                                        <!--begin::Layout-->
                                        <div class="d-flex flex-column flex-lg-row">
                                            <!--begin::Content-->
                                            <div class="flex-lg-row-fluid me-0">
                                                <!--begin::Form-->
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_dokumen_permohonan" action="<?php echo base_url(); ?>pelanggan_area/dokumen_permohonan/simpan" autocomplete="off">
                                                    <input type="hidden" class="select2" id="id_dokumen_permohonan" name="id_dokumen_permohonan" maxlength="11" placeholder="">

                                                    <div id="penolakan_box" class="hidden">
                                                        <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-9 p-6 hidden">
                                                            <!--begin::Icon-->
                                                            <?php echo getSvgIcon('general/gen040', 'svg-icon svg-icon-2tx svg-icon-danger me-4'); ?>
                                                            <!--end::Icon-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex flex-stack flex-grow-1">
                                                                <!--begin::Content-->
                                                                <div class="fw-semibold">
                                                                    <h4 class="text-gray-900 fw-bold">Alasan Penolakan</h4>
                                                                    <div class="fs-6 text-gray-700" id="alasan_penolakan"></div>
                                                                </div>
                                                                <!--end::Content-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                    </div>
                                                    <?php $this->view('pelanggan_area/include/notice_ketentuan_upload_file'); ?>

                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tipe Permohonan</label>
                                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih data" id="id_tipe_permohonan" name="id_tipe_permohonan" required>
                                                                <?php
                                                                
                                                                if ($konten['tipe_permohonan']->num_rows() > 0) {
                                                                    foreach ($konten['tipe_permohonan']->result() as $list) {
                                                                        echo '<option value="' . $list->id_tipe_permohonan . '" data-template_dokumen="' . $list->template_dokumen . '" data-checklist_dokumen="' . $list->checklist_dokumen . '" data-dokumen_tambahan="' . $list->dokumen_tambahan . '">' . $list->nama_tipe_permohonan . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <a href="#" id="download_template" class="btn btn-link btn-color-info btn-active-color-primary me-5 mb-2" style="display: none;" target="_blank"><i class="fa fa-file-download"></i> Download Template Permohonan</a>
                                                            <a href="#" id="download_checklist" class="btn btn-link btn-color-info btn-active-color-primary me-5 mb-2" style="display: none;" target="_blank"><i class="fa fa-file-download"></i> Download Checklist Dokumen</a>
                                                        </div>
                                                    </div>
                                                    <div class="separator mb-10 mt-10"></div>
                                                    <div class="row mb-5 align-items-center">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold">Dokumen Permohonan</label>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <input type="file" accept="application/pdf,image/jpeg" class="form-control form-control-solid" id="dokumen_permohonan" name="dokumen_permohonan" placeholder="">

                                                            <div id="dokumen_permohonan_box" class="file_box" style="display: none">
                                                                <div class="row">
                                                                    <div class="col-sm-7">
                                                                        <a id="link_dokumen_permohonan" href="<?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->dokumen_permohonan) ? base_url() . $konten['dokumen_permohonan']->dokumen_permohonan : 'javascript:;'); ?>" class="btn btn-icon-primary btn-text-primary" style="background: #FFF; text-align: left; width: 100%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                                                            <?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-muted svg-icon-2'); ?>
                                                                            <span id="nama_file_dokumen_permohonan"><?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->dokumen_permohonan) ? str_replace('assets/uploads/dokumen/' . $this->session->userdata('id_pelanggan') . '/', '', coverMe($konten['dokumen_permohonan']->dokumen_permohonan)) : 'Tidak ada file'); ?></span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-sm-5" style="text-align: right">
                                                                        <a href="javascript:;" class="btn btn-light-success btn-block" onclick="hapus_file('dokumen_permohonan')">Update Dokumen</a>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5 align-items-center">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold">Nomor NPWP (Kantor Pusat)</label>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-solid" id="nomor_npwp" name="nomor_npwp" placeholder="" autocomplete="off" required value="<?php echo ($konten['dokumen_ready'] == 1 ? $konten['dokumen_permohonan']->nomor_npwp : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5 align-items-center">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold">Alamat NPWP (Kantor Pusat)</label>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <textarea class="form-control form-control-solid" id="alamat_npwp" name="alamat_npwp" placeholder="" autocomplete="off" required><?php echo ($konten['dokumen_ready'] == 1 ? $konten['dokumen_permohonan']->alamat_npwp : ''); ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5 align-items-center">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold">Scan Kartu NPWP (Kantor Pusat)</label>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <input type="file" accept="application/pdf,image/jpeg" class="form-control form-control-solid" id="kartu_npwp" name="kartu_npwp" placeholder="">

                                                            <div id="kartu_npwp_box" class="file_box" style="display: none">
                                                                <div class="row">
                                                                    <div class="col-sm-7">
                                                                        <a id="link_kartu_npwp" download href="<?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->kartu_npwp) ? base_url() . $konten['dokumen_permohonan']->kartu_npwp : 'javascript:;'); ?>" class="btn btn-icon-primary btn-text-primary" style="background: #FFF; text-align: left; width: 100%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                                                            <?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-muted svg-icon-2'); ?>
                                                                            <span id="nama_file_kartu_npwp"><?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->kartu_npwp) ? str_replace('assets/uploads/dokumen/' . $this->session->userdata('id_pelanggan') . '/', '', coverMe($konten['dokumen_permohonan']->kartu_npwp)) : 'Tidak ada file'); ?></span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-sm-5" style="text-align: right">
                                                                        <a href="javascript:;" class="btn btn-light-success btn-block" onclick="hapus_file('kartu_npwp')">Update Dokumen</a>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5 align-items-center">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold">Dokumen Surat Keterangan Terdaftar (SKT)</label>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <input type="file" accept="application/pdf,image/jpeg" class="form-control form-control-solid" id="dokumen_skt" name="dokumen_skt" placeholder="">

                                                            <div id="dokumen_skt_box" class="file_box" style="display: none">
                                                                <div class="row">
                                                                    <div class="col-sm-7">
                                                                        <a id="link_dokumen_skt" download href="<?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->dokumen_skt) ? base_url() . $konten['dokumen_permohonan']->dokumen_skt : 'javascript:;'); ?>" class="btn btn-icon-primary btn-text-primary" style="background: #FFF; text-align: left; width: 100%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                                                            <?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-muted svg-icon-2'); ?>
                                                                            <span id="nama_file_dokumen_skt"><?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->dokumen_skt) ? str_replace('assets/uploads/dokumen/' . $this->session->userdata('id_pelanggan') . '/', '', coverMe($konten['dokumen_permohonan']->dokumen_skt)) : 'Tidak ada file'); ?></span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-sm-5" style="text-align: right">
                                                                        <a href="javascript:;" class="btn btn-light-success btn-block" onclick="hapus_file('dokumen_skt')">Update Dokumen</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5 align-items-center">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold">Surat Pernyataan Kebenaran Data NPWP (Kantor Pusat)</label>
                                                            <br><a href="/assets/uploads/template/surat_pernyataan_kebenaran_data_npwp.docx" class="btn btn-link btn-color-info btn-active-color-primary" style="text-align: left;" target="_blank"><i class="fa fa-file-download"></i> Download Template Surat Pernyataan</a>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <input type="file" accept="application/pdf,image/jpeg" class="form-control form-control-solid" id="dokumen_alamat_antar_invoice" name="dokumen_alamat_antar_invoice" placeholder="">

                                                            <div id="dokumen_alamat_antar_invoice_box" class="file_box" style="display: none">
                                                                <div class="row">
                                                                    <div class="col-sm-7">
                                                                        <a id="link_dokumen_alamat_antar_invoice" download href="<?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->dokumen_alamat_antar_invoice) ? base_url() . $konten['dokumen_permohonan']->dokumen_alamat_antar_invoice : 'javascript:;'); ?>" class="btn btn-icon-primary btn-text-primary" style="background: #FFF; text-align: left; width: 100%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                                                            <?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-muted svg-icon-2'); ?>
                                                                            <span id="nama_file_dokumen_alamat_antar_invoice"><?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->dokumen_alamat_antar_invoice) ? str_replace('assets/uploads/dokumen/' . $this->session->userdata('id_pelanggan') . '/', '', coverMe($konten['dokumen_permohonan']->dokumen_alamat_antar_invoice)) : 'Tidak ada file'); ?></span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-sm-5" style="text-align: right">
                                                                        <a href="javascript:;" class="btn btn-light-success btn-block" onclick="hapus_file('dokumen_alamat_antar_invoice')">Update Dokumen</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5 align-items-center">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold">Dokumen Izin Usaha Industri (IUI)/ Nomor Induk Berusaha (NIB)</label>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <input type="file" accept="application/pdf,image/jpeg" class="form-control form-control-solid" id="dokumen_uiu_nib" name="dokumen_uiu_nib" placeholder="">

                                                            <div id="dokumen_uiu_nib_box" class="file_box" style="display: none">
                                                                <div class="row">
                                                                    <div class="col-sm-7">
                                                                        <a id="link_dokumen_uiu_nib" download href="<?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->dokumen_uiu_nib) ? base_url() . $konten['dokumen_permohonan']->dokumen_uiu_nib : 'javascript:;'); ?>" class="btn btn-icon-primary btn-text-primary" style="background: #FFF; text-align: left; width: 100%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                                                            <?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-muted svg-icon-2'); ?>
                                                                            <span id="nama_file_dokumen_uiu_nib"><?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->dokumen_uiu_nib) ? str_replace('assets/uploads/dokumen/' . $this->session->userdata('id_pelanggan') . '/', '', coverMe($konten['dokumen_permohonan']->dokumen_uiu_nib)) : 'Tidak ada file'); ?></span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-sm-5" style="text-align: right">
                                                                        <a href="javascript:;" class="btn btn-light-success btn-block" onclick="hapus_file('dokumen_uiu_nib')">Update Dokumen</a>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5 align-items-center">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="fs-5 fw-semibold">Dokumen Nomor Izin Edar</label>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <input type="file" accept="application/pdf,image/jpeg" class="form-control form-control-solid" id="dokumen_nomor_izin_edar" name="dokumen_nomor_izin_edar" placeholder="">

                                                            <div id="dokumen_nomor_izin_edar_box" class="file_box" style="display: none">
                                                                <div class="row">
                                                                    <div class="col-sm-7">
                                                                        <a id="link_dokumen_nomor_izin_edar" download href="<?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->dokumen_nomor_izin_edar) ? base_url() . $konten['dokumen_permohonan']->dokumen_nomor_izin_edar : 'javascript:;'); ?>" class="btn btn-icon-primary btn-text-primary" style="background: #FFF; text-align: left; width: 100%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                                                            <?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-muted svg-icon-2'); ?>
                                                                            <span id="nama_file_dokumen_nomor_izin_edar"><?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->dokumen_nomor_izin_edar) ? str_replace('assets/uploads/dokumen/' . $this->session->userdata('id_pelanggan') . '/', '', coverMe($konten['dokumen_permohonan']->dokumen_nomor_izin_edar)) : 'Tidak ada file'); ?></span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-sm-5" style="text-align: right">
                                                                        <a href="javascript:;" class="btn btn-light-success btn-block" onclick="hapus_file('dokumen_nomor_izin_edar')">Update Dokumen</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div id="dokumen_tambahan_1_box" class="dokumen_tambahan_box" style="display: none">

                                                        <div class="row mb-5 align-items-center">
                                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                                <label class="fs-5 fw-semibold">Dokumen Kontrak Lengkap Dengan Amandemen</label>
                                                            </div>
                                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                                <input type="file" accept="application/pdf,image/jpeg" class="form-control form-control-solid" id="dokumen_kontrak_amandemen" name="dokumen_kontrak_amandemen" placeholder="">

                                                                <div id="dokumen_kontrak_amandemen_box" class="file_box" style="display: none">
                                                                    <div class="row">
                                                                        <div class="col-sm-7">
                                                                            <a id="link_dokumen_kontrak_amandemen" download href="<?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->dokumen_kontrak_amandemen) ? base_url() . $konten['dokumen_permohonan']->dokumen_kontrak_amandemen : 'javascript:;'); ?>" class="btn btn-icon-primary btn-text-primary" style="background: #FFF; text-align: left; width: 100%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                                                                <?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-muted svg-icon-2'); ?>
                                                                                <span id="nama_file_dokumen_kontrak_amandemen"><?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->dokumen_kontrak_amandemen) ? str_replace('assets/uploads/dokumen/' . $this->session->userdata('id_pelanggan') . '/', '', coverMe($konten['dokumen_permohonan']->dokumen_kontrak_amandemen)) : 'Tidak ada file'); ?></span>
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-sm-5" style="text-align: right">
                                                                            <a href="javascript:;" class="btn btn-light-success btn-block" onclick="hapus_file('dokumen_kontrak_amandemen')">Update Dokumen</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-5 align-items-center">
                                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                                <label class="required fs-5 fw-semibold">Nilai Tagihan Kontrak</label>
                                                            </div>
                                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                                <div class="input-group input-group-solid mb-5">
                                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                                    <input type="text" class="form-control form-control-solid" id="nilai_tagihan_kontrak" name="nilai_tagihan_kontrak" placeholder="" onkeyup="convertToRupiah(this)">
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="row mb-5 align-items-center">
                                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                                <label class="required fs-5 fw-semibold">Form Komitmen TKDN</label>
                                                            </div>
                                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                                <input type="file" accept="application/pdf,image/jpeg" class="form-control form-control-solid" id="dokumen_komitmen_tkdn" name="dokumen_komitmen_tkdn" placeholder="">

                                                                <div id="dokumen_komitmen_tkdn_box" class="file_box" style="display: none">
                                                                    <div class="row">
                                                                        <div class="col-sm-7">
                                                                            <a id="link_dokumen_komitmen_tkdn" download href="<?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->dokumen_komitmen_tkdn) ? base_url() . $konten['dokumen_permohonan']->dokumen_komitmen_tkdn : 'javascript:;'); ?>" class="btn btn-icon-primary btn-text-primary" style="background: #FFF; text-align: left; width: 80%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                                                                <?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-muted svg-icon-2'); ?>
                                                                                <span id="nama_file_dokumen_komitmen_tkdn"><?php echo (($konten['dokumen_ready'] == 1 and $konten['dokumen_permohonan']->dokumen_komitmen_tkdn) ? str_replace('assets/uploads/dokumen/' . $this->session->userdata('id_pelanggan') . '/', '', coverMe($konten['dokumen_permohonan']->dokumen_komitmen_tkdn)) : 'Tidak ada file'); ?></span>
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-sm-5" style="text-align: right">
                                                                            <a href="javascript:;" class="btn btn-light-success btn-block" onclick="hapus_file('dokumen_komitmen_tkdn')">Update Dokumen</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div id="dokumen_tambahan_2_box" class="dokumen_tambahan_box" style="display: none">
                                                        <div class="row mb-5 align-items-top">
                                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                                <label class="required fs-5 fw-semibold mt-3">Kriteria Yang Diajukan</label>
                                                            </div>
                                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                                <?php
                                                                if ($konten['kriteria_bpm']->num_rows() > 0) {
                                                                    foreach ($konten['kriteria_bpm']->result() as $kriteria_bpm) {
                                                                        echo '<div data-kt-buttons="true">
                                                                                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-3 mb-3">
                                                                                    <div class="d-flex align-items-center me-2">
                                                                                        <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                                                            <input class="form-check-input" type="checkbox" name="kriteria_pengajuan[]" value="' . $kriteria_bpm->judul_kriteria . '"/>
                                                                                        </div>
                                                                                        <div class="flex-grow-1">
                                                                                            <div class="d-flex align-items-center fs-5 fw-bold flex-wrap">
                                                                                                ' . $kriteria_bpm->judul_kriteria . '
                                                                                            </div>
                                                                                            <div class="fw-semibold opacity-50 fs-7">
                                                                                                ' . $kriteria_bpm->keterangan . '
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </label>
                                                                            </div>';
                                                                    }
                                                                }
                                                                ?>

                                                                <div id="bpm_keterangan_box" class="alert alert-dismissible bg-light-primary border border-primary flex-column flex-sm-row p-5 mt-5" style="display: none;">
                                                                    <!--begin::Icon-->
                                                                    <span class="svg-icon svg-icon-2hx svg-icon-primary me-4 mb-5 mb-sm-0"><i class="fa fa-info-circle svg-icon svg-icon-primary me-4 mb-5 mb-sm-0" style="font-size: 20px;"></i></span>
                                                                    <div class="d-flex flex-column pe-0 pe-sm-10">
                                                                        <span id="keterangan_bpm"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="separator mb-10 mt-10"></div>

                                                    <button type="submit" id="simpan" class="btn btn-primary">
                                                        <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                                        <span class="indicator-progress">Tunggu sebentar...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>

                                                    <input type="hidden" id="action" name="action" value="save">
                                                    <input type="hidden" id="tipe_pengajuan" name="tipe_pengajuan" value="<?php echo $konten['tipe_pengajuan']; ?>">
                                                    <input type="hidden" id="dokumen_ready" name="dokumen_ready" value="<?php echo $konten['dokumen_ready']; ?>">
                                                    <input type="hidden" id="token" name="token" value="<?php echo genToken('SEND_DATA'); ?>">

                                                </form>
                                                <!--end::Form-->

                                            </div>
                                            <!--end::Content-->

                                        </div>
                                        <!--end::Layout-->
                                    </div>
                                    <!--end::Body-->
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--end::Content wrapper-->
                    <?php $this->view('include/footer'); ?>

                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>


    <?php $this->view('include/js'); ?>

    <script>
        $("#input_form_dokumen_permohonan")[0].reset();
        $("#action").val('save');
        $("#id_tipe_permohonan").val('').trigger('change');
        $("#penolakan_box").hide();
        show_dokumen_ready();
        $("#input_form_dokumen_permohonan").attr('action', base_url + 'pelanggan_area/dokumen_permohonan/simpan');


        $("#id_tipe_permohonan").change(function() {
            var template_dokumen = $('#id_tipe_permohonan option:selected').data('template_dokumen');
            var checklist_dokumen = $('#id_tipe_permohonan option:selected').data('checklist_dokumen');
            var dokumen_tambahan = $('#id_tipe_permohonan option:selected').data('dokumen_tambahan');

            if (template_dokumen) {
                $("#download_template").attr('href', base_url + template_dokumen);
                $("#download_template").show(300);
                $("#download_checklist").attr('href', base_url + checklist_dokumen);
                $("#download_checklist").show(300);
            } else {
                $("#download_template").attr('href', 'javascript:;');
                $("#download_template").hide();
                $("#download_checklist").attr('href', 'javascript:;');
                $("#download_checklist").hide();
            }

            $(".dokumen_tambahan_box").hide();
            if (dokumen_tambahan == 1) {
                $("#dokumen_tambahan_1_box").show(300);
            } else if (dokumen_tambahan == 2) {
                $("#dokumen_tambahan_2_box").show(300);
            }
        });

        function hapus_file(element) {
            $("#" + element + "_box").hide();
            $("#" + element).show();

        }

        function show_dokumen_ready() {
            var dokumen_ready = $("#dokumen_ready").val();
            if (dokumen_ready == 1) {
                $(".file_box").show();

                //hide box file ini karena pasti berdeda setiap permohonannya...
                $("#dokumen_permohonan_box, #dokumen_kontrak_amandemen_box, #dokumen_komitmen_tkdn_box").hide();

                //hide input file...
                $("#kartu_npwp, #dokumen_skt, #dokumen_alamat_antar_invoice, #dokumen_uiu_nib, #dokumen_nomor_izin_edar").hide();

            }
        }

        var list_data;
        $("#input_form_dokumen_permohonan").on('submit', function(e) {
            e.preventDefault();

            var dokumen_tambahan = $('#id_tipe_permohonan option:selected').data('dokumen_tambahan');
            var id_dokumen_permohonan = $("#id_dokumen_permohonan").val();
            var id_tipe_permohonan = $("#id_tipe_permohonan").val();
            var dokumen_permohonan = $("#dokumen_permohonan").val();
            var kartu_npwp = $("#kartu_npwp").val();
            var dokumen_skt = $("#dokumen_skt").val();
            var dokumen_alamat_antar_invoice = $("#dokumen_alamat_antar_invoice").val();
            var dokumen_uiu_nib = $("#dokumen_uiu_nib").val();
            var dokumen_nomor_izin_edar = $("#dokumen_nomor_izin_edar").val();
            var dokumen_kontrak_amandemen = $("#dokumen_kontrak_amandemen").val();
            var nilai_tagihan_kontrak = convertToAngka($("#nilai_tagihan_kontrak").val());
            var dokumen_komitmen_tkdn = $("#dokumen_komitmen_tkdn").val();
            var dokumen_ready = $("#dokumen_ready").val();
            var nomor_npwp = $("#nomor_npwp").val();
            var alamat_npwp = $("#alamat_npwp").val();

            var action = $("#action").val();
            var allow = true;

            if (action == 'update') {
                if (!action || !id_tipe_permohonan || !nomor_npwp || !alamat_npwp || (dokumen_tambahan == 1 && !nilai_tagihan_kontrak)) {
                    allow = false;
                    var response = JSON.parse('<?php echo alert('kosong'); ?>');
                    swalAlert(response);
                }
            } else {
                if (dokumen_ready == 1) {
                    if (!action || !id_tipe_permohonan || !dokumen_permohonan || !nomor_npwp || !alamat_npwp) {
                        allow = false;
                        var response = JSON.parse('<?php echo alert('kosong'); ?>');
                        swalAlert(response);
                    } else if (dokumen_tambahan == 1 && (!nilai_tagihan_kontrak || !dokumen_komitmen_tkdn)) {
                        allow = false;
                        var response = JSON.parse('<?php echo alert('kosong'); ?>');
                        swalAlert(response);
                    } else if (dokumen_tambahan == 2 && $('input[name="kriteria_pengajuan[]"]:checked').length == 0) {
                        allow = false;
                        var response = JSON.parse('<?php echo alert('kosong'); ?>');
                        swalAlert(response);
                    }
                } else {
                    if (!action || !id_tipe_permohonan || !dokumen_permohonan || !kartu_npwp || !dokumen_skt || !dokumen_uiu_nib || !nomor_npwp || !alamat_npwp || (dokumen_tambahan == 1 && (!nilai_tagihan_kontrak || !dokumen_komitmen_tkdn))) {
                        allow = false;
                        var response = JSON.parse('<?php echo alert('kosong'); ?>');
                        swalAlert(response);
                    }
                }
            }

            if (allow) {
                $("#simpan").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });

                jQuery(this).ajaxSubmit({
                    dataType: 'json',
                    success: function(data) {
                        $("#simpan").removeAttr('disabled data-kt-indicator');

                        if (data.sts == 1) {
                            //hapus seluruh field...

                            var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                            response.callback_yes = reload_after_save;
                            swalAlert(response);
                        } else if (data.sts == 'tidak_berhak_akses_data') {
                            var response = JSON.parse('<?php echo alert('tidak_berhak_akses_data'); ?>');
                            swalAlert(response);
                        } else if (data.sts == 'upload_error') {
                            var response = JSON.parse('<?php echo alert('upload_error'); ?>');
                            response.message = response.message.replace('{{upload_error_msg}}', data.error_msg);
                            swalAlert(response);
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }
                });
            }
        });

        function reload_after_save() {
            location.href = base_url + 'pelanggan/riwayat_permohonan_tkdn';
        }

        function edit() {
            $("#input_form_dokumen_permohonan").attr('action', base_url + 'pelanggan_area/dokumen_permohonan/edit');
            var data = safelyParseJSON('<?php echo ($konten['data_edit'] ? json_encode($konten['data_edit']) : ''); ?>');
            var prefix_replace = "assets/uploads/dokumen/" + data.id_pelanggan + "/";

            $("#id_dokumen_permohonan").val(decodeHtml(data.id_dokumen_permohonan));
            $("#id_tipe_permohonan").val(decodeHtml(data.id_tipe_permohonan)).trigger('change');

            if (data.dokumen_permohonan) {
                $("#dokumen_permohonan_box").show();
                $("#nama_file_dokumen_permohonan").html(data.dokumen_permohonan.replace(prefix_replace, ""));
                $("#link_dokumen_permohonan").attr('href', base_url + data.dokumen_permohonan);
                $("#dokumen_permohonan").hide();
            } else {
                $("#dokumen_permohonan_box").hide();
                $("#dokumen_permohonan").show();
            }

            if (data.kartu_npwp) {
                $("#kartu_npwp_box").show();
                $("#nama_file_kartu_npwp").html(data.kartu_npwp.replace(prefix_replace, ""));
                $("#link_kartu_npwp").attr('href', base_url + data.kartu_npwp);
                $("#kartu_npwp").hide();

            } else {
                $("#kartu_npwp_box").hide();
                $("#kartu_npwp").show();
            }

            $("#nomor_npwp").val(decodeHtml(data.nomor_npwp));
            $("#alamat_npwp").val(decodeHtml(data.alamat_npwp));

            if (data.dokumen_skt) {
                $("#dokumen_skt_box").show();
                $("#nama_file_dokumen_skt").html(data.dokumen_skt.replace(prefix_replace, ""));
                $("#link_dokumen_skt").attr('href', base_url + data.dokumen_skt);
                $("#dokumen_skt").hide();
            } else {
                $("#dokumen_skt_box").hide();
                $("#dokumen_skt").show();
            }

            if (data.dokumen_alamat_antar_invoice) {
                $("#dokumen_alamat_antar_invoice_box").show();
                $("#nama_file_dokumen_alamat_antar_invoice").html(data.dokumen_alamat_antar_invoice.replace(prefix_replace, ""));
                $("#link_dokumen_alamat_antar_invoice").attr('href', base_url + data.dokumen_alamat_antar_invoice);
                $("#dokumen_alamat_antar_invoice").hide();
            } else {
                $("#dokumen_alamat_antar_invoice_box").hide();
                $("#dokumen_alamat_antar_invoice").show();
            }

            if (data.dokumen_uiu_nib) {
                $("#dokumen_uiu_nib_box").show();
                $("#nama_file_dokumen_uiu_nib").html(data.dokumen_uiu_nib.replace(prefix_replace, ""));
                $("#link_dokumen_uiu_nib").attr('href', base_url + data.dokumen_uiu_nib);
                $("#dokumen_uiu_nib").hide();
            } else {
                $("#dokumen_uiu_nib_box").hide();
                $("#dokumen_uiu_nib").show();
            }

            if (data.dokumen_nomor_izin_edar) {
                $("#dokumen_nomor_izin_edar_box").show();
                $("#nama_file_dokumen_nomor_izin_edar").html(data.dokumen_nomor_izin_edar.replace(prefix_replace, ""));
                $("#link_dokumen_nomor_izin_edar").attr('href', base_url + data.dokumen_nomor_izin_edar);
                $("#dokumen_nomor_izin_edar").hide();
            } else {
                $("#dokumen_nomor_izin_edar_box").hide();
                $("#dokumen_nomor_izin_edar").show();
            }

            var dokumen_tambahan = $('#id_tipe_permohonan option:selected').data('dokumen_tambahan');
            if (dokumen_tambahan == 1) {

                if (data.dokumen_kontrak_amandemen) {
                    $("#dokumen_kontrak_amandemen_box").show();
                    $("#nama_file_dokumen_kontrak_amandemen").html(data.dokumen_kontrak_amandemen.replace(prefix_replace, ""));
                    $("#link_dokumen_kontrak_amandemen").attr('href', base_url + data.dokumen_kontrak_amandemen);
                    $("#dokumen_kontrak_amandemen").hide();
                } else {
                    $("#dokumen_kontrak_amandemen_box").hide();
                    $("#dokumen_kontrak_amandemen").show();
                }

                if (data.dokumen_komitmen_tkdn) {
                    $("#dokumen_komitmen_tkdn_box").show();
                    $("#nama_file_dokumen_komitmen_tkdn").html(data.dokumen_komitmen_tkdn.replace(prefix_replace, ""));
                    $("#link_dokumen_komitmen_tkdn").attr('href', base_url + data.dokumen_komitmen_tkdn);
                    $("#dokumen_komitmen_tkdn").hide();
                } else {
                    $("#dokumen_komitmen_tkdn_box").hide();
                    $("#dokumen_komitmen_tkdn").show();
                }

                $("#nilai_tagihan_kontrak").val(rupiah(data.nilai_tagihan_kontrak));
            } else if (dokumen_tambahan == 2) {
                var dd = $('#kriteria_pengajuan');
                var options = $('option', dd);
                var value = '';
                options.each(function() {
                    if ($(this).text() == data.kriteria_bpm) {
                        value = $(this).val();
                    }
                });
                dd.val(value).trigger('change');
            }

            if (data.status_pengajuan == 3) {
                $("#penolakan_box").show();
                $("#alasan_penolakan").html(data.alasan_verifikasi);
            }

            $("#action").val('update');
        }
        <?php echo ($konten['data_edit'] ? 'edit();' : ''); ?>
    </script>
</body>
<!-- end::Body -->

</html>