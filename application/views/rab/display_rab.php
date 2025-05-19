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
    <div class="page-loader flex-column">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-muted fs-6 fw-semibold mt-5">Loading...</span>
    </div>
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <?php $this->view('include/top_navbar'); ?>
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <?php $this->view('include/left_side_navbar'); ?>
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

                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <!--begin::Secondary button-->
                                    <button type="button" class="btn btn-sm btn-light btn-active-light-primary" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Kembali</button>
                                    <!--end::Secondary button-->
                                </div>
                                <!--end::Page title-->
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <div class="card card-flush">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>
                                                Form RAB
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
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_rab" action="<?php echo base_url(); ?>Rab/simpan" autocomplete="off">

                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nama Perusahaan</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" value="<?php echo $konten['dokumen_permohonan']->nama_badan_usaha . ' ' . $konten['dokumen_permohonan']->nama_perusahaan; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nama <?php echo ucwords($konten['dokumen_permohonan']->nama_tipe_permohonan); ?></label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_produk_jasa" name="nama_produk_jasa" maxlength="200" placeholder="" disabled>
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Lokasi (Nama Kota)</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="lokasi" name="lokasi" maxlength="200" placeholder="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Jumlah <?php echo ucwords($konten['dokumen_permohonan']->nama_tipe_permohonan); ?></label>
                                                            <input type="number" class="form-control form-control-solid" autocomplete="off" id="jml_produk_jasa" name="jml_produk_jasa" maxlength="11" placeholder="" disabled>
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Jml Perhitungan</label>
                                                            <input type="number" class="form-control form-control-solid" autocomplete="off" id="jml_perhitungan" name="jml_perhitungan" maxlength="11" placeholder="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Jumlah Hari Kerja Dalam Surat Penawaran</label>
                                                            <div class="input-group input-group-solid mb-5">
                                                                <input type="number" class="form-control form-control-solid" autocomplete="off" id="jml_hari_kerja" name="jml_hari_kerja" maxlength="11" placeholder="" disabled>
                                                                <span class="input-group-text" id="basic-addon3">Hari Kerja</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Dokumen Permohonan</label>
                                                            <div>
                                                                <a href="<?php echo base_url() . $konten['dokumen_permohonan']->dokumen_permohonan; ?>" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-file-download"></i> Download Dokumen</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="separator mb-10 mt-10"></div>

                                                    <div class="mb-10" style="font-weight: bold; font-size: 17px">Rincian RAB</div>
                                                    <div class="table-responsive">
                                                        <table id="form_rincian_rab" class="table table-sm">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th style="width: 5%">No</th>
                                                                    <th class="required" style="width: 23%">Uraian Kegiatan</th>
                                                                    <th style="width: 10%">Satuan</th>
                                                                    <th style="width: 10%">Org/Unit</th>
                                                                    <th style="width: 10%">Hari/Kali</th>
                                                                    <th style="width: 17%">Biaya (Rp)</th>
                                                                    <th class="required" style="width: 20%">Total Biaya</th>
                                                                    <th style="width: 5%"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center">I</td>
                                                                    <td style="vertical-align: middle;">
                                                                        <?php echo $konten['anggaran'][2]['nama_mata_anggaran']; ?>
                                                                        <input type="hidden" name="uraian_kegiatan[]" value="<?php echo $konten['anggaran'][2]['nama_mata_anggaran']; ?>">
                                                                    </td>
                                                                    <td style="vertical-align: middle;">
                                                                        <?php echo $konten['anggaran'][2]['satuan']; ?>
                                                                        <input type="hidden" name="satuan[]" value="<?php echo $konten['anggaran'][2]['satuan']; ?>">
                                                                    </td>
                                                                    <td><input type="text" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td><input type="text" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td><input type="text" name="biaya[]" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo convertToRupiah($konten['anggaran'][2]['biaya']); ?>"> </td>
                                                                    <td><input type="text" name="total_biaya[]" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo convertToRupiah($konten['anggaran'][2]['biaya']); ?>"> </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center">II</td>
                                                                    <td style="vertical-align: middle;" colspan="5">
                                                                        SURVEY LAPANGAN
                                                                        <input type="hidden" name="uraian_kegiatan[]" value="SURVEY LAPANGAN">
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" name="satuan[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>
                                                                        <input type="hidden" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>
                                                                        <input type="hidden" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>
                                                                        <input type="hidden" name="biaya[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>
                                                                        <input type="text" id="total_survey_lapangan" name="total_biaya[]" class="form-control form-control-solid not_include_calc" autocomplete="off" value="" disabled>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr id="lokasi_survey" style="display: none">
                                                                    <td colspan="8">
                                                                        <input type="hidden" name="uraian_kegiatan[]" value="">
                                                                        <input type="hidden" name="satuan[]" class="form-control form-control-solid" autocomplete="off" value="">
                                                                        <input type="hidden" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" value="">
                                                                        <input type="hidden" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" value="">
                                                                        <input type="hidden" name="biaya[]" class="form-control form-control-solid" autocomplete="off" value="">
                                                                        <input type="hidden" name="total_biaya[]" class="form-control form-control-solid" autocomplete="off" value="">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center">III</td>
                                                                    <td style="vertical-align: middle;" colspan="6">
                                                                        IWO PUSAT
                                                                        <input type="hidden" name="uraian_kegiatan[]" value="IWO PUSAT">

                                                                        <input type="hidden" name="satuan[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>
                                                                        <input type="hidden" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>
                                                                        <input type="hidden" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>
                                                                        <input type="hidden" name="biaya[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>
                                                                        <input type="hidden" name="total_biaya[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center"></td>
                                                                    <td><input type="text" name="uraian_kegiatan[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td>
                                                                        <div class="input-group input-group-solid mb-5">
                                                                            <input type="text" id="persentase_iwo" name="satuan[]" class="form-control form-control-solid" autocomplete="off" disabled>
                                                                            <span class="input-group-text" id="basic-addon3" style="padding-left: 3px; padding-right: 3px;">%</span>
                                                                        </div>
                                                                    </td>
                                                                    <td><input type="hidden" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" value="1" disabled></td>
                                                                    <td><input type="hidden" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" value="1" disabled></td>
                                                                    <td><input type="hidden" id="biaya_iwo" name="biaya[]" class="form-control form-control-solid" autocomplete="off" value="" disabled></td>
                                                                    <td><input type="text" id="total_biaya_iwo" name="total_biaya[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center">IV</td>
                                                                    <td style="vertical-align: middle;" colspan="6">
                                                                        LAIN-LAIN
                                                                        <input type="hidden" name="uraian_kegiatan[]" value="LAIN-LAIN">
                                                                        <input type="hidden" name="satuan[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>
                                                                        <input type="hidden" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>
                                                                        <input type="hidden" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>
                                                                        <input type="hidden" name="biaya[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>
                                                                        <input type="hidden" name="total_biaya[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center"></td>
                                                                    <td style="vertical-align: middle;">
                                                                        <?php echo $konten['anggaran'][14]['nama_mata_anggaran']; ?>
                                                                        <input type="hidden" name="uraian_kegiatan[]" value="<?php echo $konten['anggaran'][14]['nama_mata_anggaran']; ?>">
                                                                    </td>
                                                                    <td style="vertical-align: middle;">
                                                                        <?php echo $konten['anggaran'][14]['satuan']; ?>
                                                                        <input type="hidden" name="satuan[]" value="<?php echo $konten['anggaran'][14]['satuan']; ?>">
                                                                    </td>
                                                                    <td><input type="text" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td><input type="text" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td><input type="text" name="biaya[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td><input type="text" name="total_biaya[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center"></td>
                                                                    <td style="vertical-align: middle;">
                                                                        <?php echo $konten['anggaran'][15]['nama_mata_anggaran']; ?>
                                                                        <input type="hidden" name="uraian_kegiatan[]" value="<?php echo $konten['anggaran'][15]['nama_mata_anggaran']; ?>">
                                                                    </td>
                                                                    <td style="vertical-align: middle;">
                                                                        <?php echo $konten['anggaran'][15]['satuan']; ?>
                                                                        <input type="hidden" name="satuan[]" value="<?php echo $konten['anggaran'][15]['satuan']; ?>">
                                                                    </td>
                                                                    <td><input type="text" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td><input type="text" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td><input type="text" name="biaya[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td><input type="text" name="total_biaya[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center"></td>
                                                                    <td style="vertical-align: middle;">
                                                                        <?php echo $konten['anggaran'][16]['nama_mata_anggaran']; ?>
                                                                        <input type="hidden" name="uraian_kegiatan[]" value="<?php echo $konten['anggaran'][16]['nama_mata_anggaran']; ?>">
                                                                    </td>
                                                                    <td style="vertical-align: middle;">
                                                                        <?php echo $konten['anggaran'][16]['satuan']; ?>
                                                                        <input type="hidden" name="satuan[]" value="<?php echo $konten['anggaran'][16]['satuan']; ?>">
                                                                    </td>
                                                                    <td><input type="text" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td><input type="text" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td><input type="text" name="biaya[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td><input type="text" name="total_biaya[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center"></td>
                                                                    <td style="vertical-align: middle;">
                                                                        <?php echo $konten['anggaran'][17]['nama_mata_anggaran']; ?>
                                                                        <input type="hidden" name="uraian_kegiatan[]" value="<?php echo $konten['anggaran'][17]['nama_mata_anggaran']; ?>">
                                                                    </td>
                                                                    <td style="vertical-align: middle;">

                                                                        <div class="input-group input-group-solid mb-5">
                                                                            <input type="text" id="persentase_safety_cost" name="satuan[]" class="form-control form-control-solid" autocomplete="off" disabled>
                                                                            <span class="input-group-text" id="basic-addon3" style="padding-left: 3px; padding-right: 3px;">%</span>
                                                                        </div>
                                                                    </td>
                                                                    <td><input type="hidden" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td><input type="hidden" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td><input type="hidden" name="biaya[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td><input type="text" name="total_biaya[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center"></td>
                                                                    <td style="vertical-align: middle;" colspan="5">
                                                                        TOTAL BIAYA OPERASIONAL
                                                                    </td>
                                                                    <td><input type="text" id="total_biaya_operasional" name="total_biaya_operasional" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center"></td>
                                                                    <td style="vertical-align: middle;" colspan="5">
                                                                        <span class="required">NILAI KONTRAK</span>
                                                                    </td>
                                                                    <td><input type="text" id="nilai_kontrak" name="nilai_kontrak" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center"></td>
                                                                    <td style="vertical-align: middle;" colspan="5">
                                                                        PROFIT OPERASIONAL SCI
                                                                    </td>
                                                                    <td><input type="text" id="profit_operasional" name="profit_operasional" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center"></td>
                                                                    <td style="vertical-align: middle;" colspan="5">
                                                                        PERSENTASE PROFIT
                                                                    </td>
                                                                    <td><input type="text" id="profit_persentase" name="profit_persentase" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center"></td>
                                                                    <td style="vertical-align: middle;" colspan="5">
                                                                        HARGA PER <?php echo strtoupper($konten['dokumen_permohonan']->nama_tipe_permohonan); ?>
                                                                    </td>
                                                                    <td><input type="text" id="harga_per_produk" name="harga_per_produk" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle; text-align: center"></td>
                                                                    <td style="vertical-align: middle;" colspan="5">
                                                                        HARGA PER PERHITUNGAN
                                                                    </td>
                                                                    <td><input type="text" id="harga_per_perhitungan" name="harga_per_perhitungan" class="form-control form-control-solid" autocomplete="off" disabled> </td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="separator mb-10 mt-10"></div>
                                                    <div class="mb-10" style="font-weight: bold; font-size: 17px">Yang Menandatangani RAB</div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Verifikator</label>
                                                            <select class="form-select form-select-solid" data-control="select2" id="id_assesor" name="id_assesor" disabled>
                                                                <?php
                                                                if ($konten['assesor']->num_rows() > 0) {
                                                                    foreach ($konten['assesor']->result() as $list) {
                                                                        echo '<option value="' . $list->id_admin . '">' . $list->nama_admin . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Koordinator</label>

                                                            <select class="form-select form-select-solid" data-control="select2" id="id_koordinator" name="id_koordinator" disabled>
                                                                <?php
                                                                if ($konten['koordinator']->num_rows() > 0) {
                                                                    foreach ($konten['koordinator']->result() as $list) {
                                                                        echo '<option value="' . $list->id_admin . '">' . $list->nama_admin . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="separator mb-10 mt-10"></div>
                                                    <?php
                                                    if (isset($konten['from'])) {
                                                        if ($konten['from'] == 'approval_rab') {
                                                    ?>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <button type="button" id="tolak" class="btn btn-danger">
                                                                        <span class="indicator-label"><i class="fa fa-times-circle text-white me-2 fs-3"></i> Tolak RAB</span>
                                                                        <span class="indicator-progress">Loading...
                                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                                    </button>

                                                                </div>
                                                                <div class="col-sm-6" style="text-align: right">
                                                                    <button type="button" id="terima" class="btn btn-primary">
                                                                        <span class="indicator-label"><i class="fa fa-check-circle text-white me-2 fs-3"></i> Setujui RAB</span>
                                                                        <span class="indicator-progress">Loading...
                                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                    <input type="hidden" id="index" value="0">
                                                    <input type="hidden" id="id_dokumen_permohonan" name="id_dokumen_permohonan" value="<?php echo $konten['id_dokumen_permohonan']; ?>">
                                                    <input type="hidden" id="id_rab" name="id_rab" value="<?php echo (isset($konten['id_rab']) ? $konten['id_rab'] : ''); ?>">
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
        function element_repeater(i) {
            var padding = 15;
            var element = '<tr id="baris_' + i + '">' +
                '<td></td>' +
                '<td colspan="5" style="padding-left: ' + padding + 'px"><input type="text" name="uraian_kegiatan[]" class="form-control form-control-solid" autocomplete="off" placeholder="Nama Lokasi Survey" readonly></td>' +
                '<td>' +
                '<input type="hidden" name="satuan[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>' +
                '<input type="hidden" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>' +
                '<input type="hidden" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>' +
                '<input type="hidden" name="biaya[]" class="form-control form-control-solid" autocomplete="off" value="" disabled>' +
                '<input type="text" id="total_biaya_lokasi_' + i + '" name="total_biaya[]" class="form-control form-control-solid not_include_calc" autocomplete="off" value="" disabled>' +
                '</td>' +
                '<td>' +

                '</td>' +
                '</tr>' +
                '<tr class="child_baris_' + i + '">' +
                '<td></td>' +
                '<td style="padding-left: ' + (padding * 2) + 'px">' +
                '<?php echo $konten['anggaran'][3]['nama_mata_anggaran']; ?>' +
                '<input type="hidden" name="uraian_kegiatan[]" value="<?php echo $konten['anggaran'][3]['nama_mata_anggaran']; ?>" disabled>' +
                '</td>' +
                '<td>' +
                '<?php echo $konten['anggaran'][3]['satuan']; ?>' +
                '<input type="hidden" name="satuan[]" value="<?php echo $konten['anggaran'][3]['satuan']; ?>" disabled>' +
                '</td>' +
                '<td><input type="text" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>' +
                '<td><input type="text" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>' +
                '<td><input type="text" name="biaya[]" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo convertToRupiah($konten['anggaran'][3]['biaya']); ?>"> </td>' +
                '<td><input type="text" id="total_biaya_' + i + '" name="total_biaya[]" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo convertToRupiah($konten['anggaran'][3]['biaya']); ?>"> </td>' +
                '<td></td>' +
                '</tr>' +
                '<tr class="child_baris_' + i + '">' +
                '<td></td>' +
                '<td style="padding-left: ' + (padding * 2) + 'px">' +
                '<?php echo $konten['anggaran'][4]['nama_mata_anggaran']; ?>' +
                '<input type="hidden" name="uraian_kegiatan[]" value="<?php echo $konten['anggaran'][4]['nama_mata_anggaran']; ?>" disabled>' +
                '</td>' +
                '<td>' +
                '<?php echo $konten['anggaran'][4]['satuan']; ?>' +
                '<input type="hidden" name="satuan[]" value="<?php echo $konten['anggaran'][4]['satuan']; ?>" disabled>' +
                '</td>' +
                '<td><input type="text" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>' +
                '<td><input type="text" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>' +
                '<td><input type="text" name="biaya[]" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo convertToRupiah($konten['anggaran'][4]['biaya']); ?>"> </td>' +
                '<td><input type="text" name="total_biaya[]" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo convertToRupiah($konten['anggaran'][4]['biaya']); ?>"> </td>' +
                '<td></td>' +
                '</tr>' +
                '<tr class="child_baris_' + i + '">' +
                '<td></td>' +
                '<td style="padding-left: ' + (padding * 2) + 'px">' +
                '<?php echo $konten['anggaran'][10]['nama_mata_anggaran']; ?>' +
                '<input type="hidden" name="uraian_kegiatan[]" value="<?php echo $konten['anggaran'][10]['nama_mata_anggaran']; ?>" disabled>' +
                '</td>' +
                '<td>' +
                '<?php echo $konten['anggaran'][10]['satuan']; ?>' +
                '<input type="hidden" name="satuan[]" value="<?php echo $konten['anggaran'][10]['satuan']; ?>" disabled>' +
                '</td>' +
                '<td><input type="text" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>' +
                '<td><input type="text" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>' +
                '<td><input type="text" name="biaya[]" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo convertToRupiah($konten['anggaran'][10]['biaya']); ?>"> </td>' +
                '<td><input type="text" name="total_biaya[]" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo convertToRupiah($konten['anggaran'][10]['biaya']); ?>"> </td>' +
                '<td></td>' +
                '</tr>' +
                '<tr class="child_baris_' + i + '">' +
                '<td></td>' +
                '<td style="padding-left: ' + (padding * 2) + 'px">' +
                '<?php echo $konten['anggaran'][11]['nama_mata_anggaran']; ?>' +
                '<input type="hidden" name="uraian_kegiatan[]" value="<?php echo $konten['anggaran'][11]['nama_mata_anggaran']; ?>" disabled>' +
                '</td>' +
                '<td>' +
                '<?php echo $konten['anggaran'][11]['satuan']; ?>' +
                '<input type="hidden" name="satuan[]" value="<?php echo $konten['anggaran'][11]['satuan']; ?>" disabled>' +
                '</td>' +
                '<td><input type="text" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>' +
                '<td><input type="text" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>' +
                '<td><input type="text" name="biaya[]" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo convertToRupiah($konten['anggaran'][11]['biaya']); ?>"> </td>' +
                '<td><input type="text" name="total_biaya[]" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo convertToRupiah($konten['anggaran'][11]['biaya']); ?>"> </td>' +
                '<td></td>' +
                '</tr>' +
                '<tr class="child_baris_' + i + '">' +
                '<td></td>' +
                '<td style="padding-left: ' + (padding * 2) + 'px">' +
                '<?php echo $konten['anggaran'][12]['nama_mata_anggaran']; ?>' +
                '<input type="hidden" name="uraian_kegiatan[]" value="<?php echo $konten['anggaran'][12]['nama_mata_anggaran']; ?>">' +
                '</td>' +
                '<td>' +
                '<?php echo $konten['anggaran'][12]['satuan']; ?>' +
                '<input type="hidden" name="satuan[]" value="<?php echo $konten['anggaran'][12]['satuan']; ?>">' +
                '</td>' +
                '<td><input type="text" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>' +
                '<td><input type="text" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>' +
                '<td><input type="text" name="biaya[]" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo convertToRupiah($konten['anggaran'][12]['biaya']); ?>"> </td>' +
                '<td><input type="text" name="total_biaya[]" class="form-control form-control-solid" disabled value="<?php echo convertToRupiah($konten['anggaran'][12]['biaya']); ?>"> </td>' +
                '<td></td>' +
                '</tr>' +
                '<tr class="child_baris_' + i + '">' +
                '<td></td>' +
                '<td style="padding-left: ' + (padding * 2) + 'px">' +
                '<?php echo $konten['anggaran'][13]['nama_mata_anggaran']; ?>' +
                '<input type="hidden" name="uraian_kegiatan[]" value="<?php echo $konten['anggaran'][13]['nama_mata_anggaran']; ?>" disabled>' +
                '</td>' +
                '<td>' +
                '<?php echo $konten['anggaran'][13]['satuan']; ?>' +
                '<input type="hidden" name="satuan[]" value="<?php echo $konten['anggaran'][13]['satuan']; ?>" disabled>' +
                '</td>' +
                '<td><input type="text" name="org_unit[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>' +
                '<td><input type="text" name="hari_kali[]" class="form-control form-control-solid" autocomplete="off" disabled> </td>' +
                '<td><input type="text" name="biaya[]" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo convertToRupiah($konten['anggaran'][13]['biaya']); ?>"> </td>' +
                '<td><input type="text" name="total_biaya[]" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo convertToRupiah($konten['anggaran'][13]['biaya']); ?>"> </td>' +
                '<td></td>' +
                '</tr>';
            return element;
        }

        function add_baris() {
            var i = $("#index").val();
            var get_element = element_repeater(i);
            $(get_element).insertBefore('#lokasi_survey');
            $("#index").val(parseInt(i) + 1);

        }
        add_baris();

        function hapus_baris(i) {
            $("#baris_" + i).remove();
            $(".child_baris_" + i).remove();
        }

        function load_rab() {
            var id_rab = $("#id_rab").val();
            if (id_rab) {
                var rab = safelyParseJSON('<?php echo json_encode((isset($konten['rab']) ? $konten['rab'] : '')); ?>');
                var detail_rab = safelyParseJSON('<?php echo json_encode((isset($konten['rab_detail']) ? $konten['rab_detail'] : '')); ?>');

                $("#nama_produk_jasa").val(rab.nama_produk_jasa);
                $("#lokasi").val(rab.lokasi);
                $("#jml_produk_jasa").val(rab.jml_produk_jasa);
                $("#jml_perhitungan").val(rab.jml_perhitungan);
                $("#jml_hari_kerja").val(rab.jml_hari_kerja);
                $("#id_assesor").val(rab.id_assesor).trigger('change');
                $("#id_koordinator").val(rab.id_koordinator).trigger('change');

                hapus_baris(0);
                for (var i = 0; i < detail_rab.length; i++) {
                    if (detail_rab[i]['uraian_kegiatan'] == 'TIKET PESAWAT (PP)') {
                        add_baris();
                    }
                }

                $('#form_rincian_rab > tbody  > tr').each(function(i, tr) {
                    if (i < detail_rab.length) {
                        var uraian_kegiatan = detail_rab[i]['uraian_kegiatan'];
                        var satuan = detail_rab[i]['satuan'];
                        var orang_unit = detail_rab[i]['orang_unit'];
                        var hari_kali = detail_rab[i]['hari_kali'];
                        var biaya = rupiah(detail_rab[i]['biaya']);
                        var total_biaya = rupiah(detail_rab[i]['total_biaya']);

                        var uraian_table = $(this).find('td input[name="uraian_kegiatan[]"]').val();
                        if (!uraian_table) {
                            $(this).find('td input[name="uraian_kegiatan[]"]').val(uraian_kegiatan);
                        }

                        $(this).find('td input[name="satuan[]"]').val(satuan);
                        $(this).find('td input[name="org_unit[]"]').val((orang_unit > 0 ? orang_unit : ''));
                        $(this).find('td input[name="hari_kali[]"]').val((hari_kali > 0 ? hari_kali : ''));
                        $(this).find('td input[name="biaya[]"]').val(biaya);
                        $(this).find('td input[name="total_biaya[]"]').val(total_biaya);
                    }
                })

                $("#total_biaya_operasional").val(rupiah(rab.total_biaya_operasional));
                $("#nilai_kontrak").val(rupiah(rab.nilai_kontrak));
                $("#profit_operasional").val(rupiah(rab.profit_operasional));
                $("#profit_persentase").val(rupiah(rab.profit_persentase) + '%');
                $("#harga_per_produk").val(rupiah(rab.harga_per_produk));
                $("#harga_per_perhitungan").val(rupiah(rab.harga_per_perhitungan));
            }
        }
        load_rab();

        $("#terima").click(function() {
            var pertanyaan = "Apakah Anda yakin menyetujui RAB ini?";

            konfirmasi(pertanyaan, function() {
                $("#terima").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });
                proses_verifikasi_rab('setuju');
            });

        });
        $("#tolak").click(function() {
            var pertanyaan = "Apakah Anda yakin menolak RAB ini?";

            swal.fire({
                title: konfirmasi_title,
                html: pertanyaan,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan!',
                cancelButtonText: 'Tidak, batalkan',
                confirmButtonColor: '#0abb87',
                cancelButtonColor: '#d33',
                allowOutsideClick: false,
                reverseButtons: true,
                input: 'textarea',
                inputLabel: 'Alasan Penolakan',
                inputPlaceholder: 'Tuliskan alasan penolakan Anda disini',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Anda harus menuliskan alasan penolakan dengan jelas!'
                    }
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    $("#tolak").attr({
                        "data-kt-indicator": "on",
                        'disabled': true
                    });
                    proses_verifikasi_rab('ditolak', result.value);
                }

            });
        });

        function proses_verifikasi_rab(status_verifikasi, alasan_verifikasi) {
            //show loading animation...
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_rab'] = $("#id_rab").val();
            data['status_verifikasi'] = status_verifikasi;
            data['alasan_verifikasi'] = alasan_verifikasi;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>rab/verifikasi_rab',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    preloader('hide');
                    //hide loading animation...
                    $("#terima, #ditolak").removeAttr('disabled data-kt-indicator');

                    if (data.sts == 1) {
                        var response = JSON.parse('<?php echo alert('verifikasi_berhasil'); ?>');
                        response.callback_yes = after_verifikasi;
                        swalAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }

            });
        }

        function after_verifikasi() {
            location.href = base_url + "page/approval_rab";
        }
    </script>
</body>
<!-- end::Body -->

</html>