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
                                <!--end::Page title-->
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <div class="card card-flush">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title" style="max-width: 50%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                            <h2>
                                                <?php echo $konten['rab']->nama_badan_usaha . ' ' . $konten['rab']->nama_perusahaan; ?>
                                            </h2>
                                        </div>
                                        <div class="card-toolbar">
                                            <a href="<?php echo base_url() . 'page/detail_dokumen_permohonan/' . $konten['rab']->id_dokumen_permohonan; ?>" class="btn btn-light-success btn-sm" style="margin-right: 10px;"><i class="fa fa-file"></i> Lihat Dokumen Permohonan</a>
                                            <a href="<?php echo base_url() . 'page/lihat_detail_rab/' . $konten['rab']->id_rab; ?>" class="btn btn-light-success btn-sm"><i class="fa fa-calculator"></i> Lihat RAB</a>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17">
                                        <!--begin::Layout-->
                                        <div class="d-flex flex-column flex-lg-row">
                                            <!--begin::Content-->
                                            <div class="flex-lg-row-fluid me-0">

                                                <div id="penolakan_box" class="<?php echo ($konten['rab']->alasan_verifikasi ? '' : 'hidden'); ?>">
                                                    <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-9 p-6 hidden">
                                                        <!--begin::Icon-->
                                                        <?php echo getSvgIcon('general/gen040', 'svg-icon svg-icon-2tx svg-icon-danger me-4'); ?>
                                                        <!--end::Icon-->
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex flex-stack flex-grow-1">
                                                            <!--begin::Content-->
                                                            <div class="fw-semibold">
                                                                <h4 class="text-gray-900 fw-bold">Alasan Penolakan</h4>
                                                                <div class="fs-6 text-gray-700" id="alasan_penolakan"><?php echo (isset($konten['id_rab']) ? $konten['rab']->alasan_verifikasi : ''); ?></div>
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                </div>

                                                <!--begin::Form-->
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_surat_penawaran" action="<?php echo base_url(); ?>Surat_penawaran/simpan" autocomplete="off">
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Jenis Surat Penawaran</label>
                                                            <select id="jns_surat_penawaran" name="jns_surat_penawaran" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih data" required>
                                                                <option value="barang" <?php echo ($konten['status'] == 'revisi' and $konten['surat_penawaran']->jns_surat_penawaran == 'barang' ? 'selected' : ''); ?>>Surat Penawaran TKDN Barang</option>
                                                                <option value="gabungan" <?php echo ($konten['status'] == 'revisi' and $konten['surat_penawaran']->jns_surat_penawaran == 'gabungan' ? 'selected' : ''); ?>>Surat Penawaran TKDN Gabungan</option>
                                                                <option value="budgetary" <?php echo ($konten['status'] == 'revisi' and $konten['surat_penawaran']->jns_surat_penawaran == 'budgetary' ? 'selected' : ''); ?>>Surat Penawaran Budgetary</option>
                                                                <option value="bmp" <?php echo ($konten['status'] == 'revisi' and $konten['surat_penawaran']->jns_surat_penawaran == 'bmp' ? 'selected' : ''); ?>>Surat Penawaran BMP</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nama U.P</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_up" name="nama_up" maxlength="50" placeholder="" required value="<?php echo ($konten['status'] == 'revisi' ? $konten['surat_penawaran']->nama_up :  $konten['rab']->nama_pejabat_penghubung_proses_tkdn); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nomor Surat Penawaran</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nomor_surat_penawaran" name="nomor_surat_penawaran" maxlength="50" placeholder="" required value="<?php echo ($konten['status'] == 'revisi' ? $konten['surat_penawaran']->nomor_surat_penawaran : ''); ?>">
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tanggal Surat Penawaan</label>
                                                            <input type="text" class="form-control form-control-solid datepicker" autocomplete="off" id="tgl_surat_penawaran" name="tgl_surat_penawaran" placeholder="" required value="<?php echo ($konten['status'] == 'revisi' ? $konten['surat_penawaran']->tgl_surat_penawaran : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nomor Surat Permohonan</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nomor_surat_permohonan" name="nomor_surat_permohonan" maxlength="50" placeholder="" required value="<?php echo ($konten['status'] == 'revisi' ? $konten['surat_penawaran']->nomor_surat_permohonan : ''); ?>">
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tanggal Surat Permohonan</label>
                                                            <input type="text" class="form-control form-control-solid datepicker" autocomplete="off" id="tgl_surat_permohonan" name="tgl_surat_permohonan" placeholder="" required value="<?php echo ($konten['status'] == 'revisi' ? $konten['surat_penawaran']->tgl_surat_permohonan : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Permohonan Verifikasi</label>
                                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih data" id="permohonan_verifikasi" name="permohonan_verifikasi" required>
                                                                <?php
                                                                if ($konten['permohonan_verifikasi']->num_rows() > 0) {
                                                                    foreach ($konten['permohonan_verifikasi']->result() as $data) {
                                                                        $selected = "";
                                                                        if ($konten['status'] == 'revisi') {
                                                                            if ($data->nama_permohonan_verifikasi == $konten['surat_penawaran']->permohonan_verifikasi) {
                                                                                $selected = "selected";
                                                                            }
                                                                        }
                                                                        echo '<option value="' . $data->nama_permohonan_verifikasi . '" ' . $selected . '>' . $data->nama_permohonan_verifikasi . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Rincian Produk / Pekerjaan</label>
                                                            <textarea class="form-control form-control-solid" autocomplete="off" id="rincian_produk_pekerjaan" name="rincian_produk_pekerjaan" placeholder="" required><?php echo ($konten['status'] == 'revisi' ? $konten['surat_penawaran']->rincian_produk_pekerjaan : ''); ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Point B.2</label>
                                                            <textarea class="form-control form-control-solid" autocomplete="off" id="point_b2" name="point_b2" placeholder="" required><?php echo ($konten['status'] == 'revisi' ? $konten['surat_penawaran']->point_b2 : ''); ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Termin I</label>
                                                            <div class="input-group input-group-solid mb-5">
                                                                <input type="number" class="form-control form-control-solid" autocomplete="off" id="termin_1" name="termin_1" maxlength="3" placeholder="" required value="<?php echo ($konten['status'] == 'revisi' ? $konten['surat_penawaran']->termin_1 : ''); ?>">
                                                                <span class="input-group-text" id="basic-addon2">%</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Termin II</label>

                                                            <div class="input-group input-group-solid mb-5">
                                                                <input type="number" class="form-control form-control-solid" autocomplete="off" id="termin_2" name="termin_2" maxlength="3" placeholder="" required value="<?php echo ($konten['status'] == 'revisi' ? $konten['surat_penawaran']->termin_2 : ''); ?>">
                                                                <span class="input-group-text" id="basic-addon2">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Masa Berlaku Penawaran</label>
                                                            <div class="input-group input-group-solid mb-5">
                                                                <input type="number" class="form-control form-control-solid" autocomplete="off" id="masa_berlaku_penawaran" name="masa_berlaku_penawaran" maxlength="11" placeholder="" required value="<?php echo ($konten['status'] == 'revisi' ? $konten['surat_penawaran']->masa_berlaku_penawaran : ''); ?>">
                                                                <span class="input-group-text" id="basic-addon2">Hari Kalender</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="fs-5 fw-semibold mb-2">Biaya Transport & Akomodasi</label>

                                                            <select id="status_transport_akomodasi" name="status_transport_akomodasi" class="form-select form-select-solid" data-control="select2">
                                                                <option value="0" <?php echo ($konten['status'] == 'revisi' ? ($konten['surat_penawaran']->status_transport_akomodasi == 0 ? 'selected' : '') : ''); ?>>Dengan Survey Lapangan & Survey Vendor</option>
                                                                <option value="1" <?php echo ($konten['status'] == 'revisi' ? ($konten['surat_penawaran']->status_transport_akomodasi == 1 ? 'selected' : '') : ''); ?>>Tanpa Survey Vendor</option>
                                                                <option value="2" <?php echo ($konten['status'] == 'revisi' ? ($konten['surat_penawaran']->status_transport_akomodasi == 2 ? 'selected' : '') : ''); ?>>Tanpa Survey Lapangan & Survey Vendor</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="separator mb-10 mt-10"></div>
                                                    <button type="submit" id="simpan" class="btn btn-primary">
                                                        <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                                        <span class="indicator-progress">Loading...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>

                                                    <a href="<?php echo base_url() . 'page/buat_penawaran'; ?>" class="btn btn-light btn-active-light-primary me-2">
                                                        <i class="fa-solid fa-arrow-left me-2 fs-3"></i>
                                                        Kembali
                                                    </a>
                                                    <input type="hidden" id="id_surat_penawaran" name="id_surat_penawaran" value="<?php echo ($konten['status'] == 'revisi' ? $konten['surat_penawaran']->id_surat_penawaran : 'save'); ?>">
                                                    <input type="hidden" id="id_rab" name="id_rab" value="<?php echo $konten['rab']->id_rab; ?>">
                                                    <input type="hidden" id="id_dokumen_permohonan" name="id_dokumen_permohonan" value="<?php echo $konten['rab']->id_dokumen_permohonan; ?>">
                                                    <input type="hidden" id="action" name="action" value="<?php echo ($konten['status'] == 'revisi' ? 'update' : 'save'); ?>">
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
        $("#jns_surat_penawaran").change(function() {
            var jns_surat_penawaran = $("#jns_surat_penawaran").val();
            if (jns_surat_penawaran == 'bmp') {
                $("#point_b2").removeAttr('required');
                $("#point_b2,#status_transport_akomodasi").parent().parent().hide();
                $("#status_transport_akomodasi").val(0).trigger('change');
            } else {
                $("#point_b2").attr('required', 'required');
                $("#point_b2,#status_transport_akomodasi").parent().parent().show();
                $("#status_transport_akomodasi").val(0).trigger('change');
            }
        });
        $("#tgl_surat_penawaran, #tgl_surat_permohonan").flatpickr(datepicker_variable);
        var list_data;
        $("#input_form_surat_penawaran").on('submit', function(e) {
            e.preventDefault();

            var id_surat_penawaran = $("#id_surat_penawaran").val();
            var id_rab = $("#id_rab").val();
            var jns_surat_penawaran = $("#jns_surat_penawaran").val();
            var nama_up = $("#nama_up").val();
            var nomor_surat_penawaran = $("#nomor_surat_penawaran").val();
            var tgl_surat_penawaran = $("#tgl_surat_penawaran").val();
            var nomor_surat_permohonan = $("#nomor_surat_permohonan").val();
            var tgl_surat_permohonan = $("#tgl_surat_permohonan").val();
            var permohonan_verifikasi = $("#permohonan_verifikasi").val();
            var rincian_produk_pekerjaan = $("#rincian_produk_pekerjaan").val();
            var point_b2 = $("#point_b2").val();
            var termin_1 = convertToAngka($("#termin_1").val());
            var termin_2 = convertToAngka($("#termin_2").val());
            var masa_berlaku_penawaran = convertToAngka($("#masa_berlaku_penawaran").val());
            var persen_termin = termin_1 + termin_2;
            var action = $("#action").val();

            if (!action || !id_rab || !jns_surat_penawaran || !nama_up || !nomor_surat_penawaran || !tgl_surat_penawaran || !nomor_surat_permohonan || !tgl_surat_permohonan || !permohonan_verifikasi || !rincian_produk_pekerjaan || !masa_berlaku_penawaran) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            }
            if (persen_termin != 100) {
                var response = JSON.parse('<?php echo alert('termin_harus_100'); ?>');
                swalAlert(response);
            } else if (!moment(tgl_surat_penawaran).isValid()) {
                var response = JSON.parse('<?php echo alert('format_tgl_salah'); ?>');
                swalAlert(response);
            } else if (!moment(tgl_surat_permohonan).isValid()) {
                var response = JSON.parse('<?php echo alert('format_tgl_salah'); ?>');
                swalAlert(response);
            } else {
                $("#simpan").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });

                jQuery(this).ajaxSubmit({
                    dataType: 'json',
                    success: function(data) {
                        $("#simpan").removeAttr('disabled data-kt-indicator');

                        if (data.sts == 1) {
                            var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                            response.callback_yes = after_save;
                            swalAlert(response);
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }
                });
            }
        });

        function after_save() {
            location.href = base_url + 'page/buat_penawaran';
        }
    </script>
</body>
<!-- end::Body -->

</html>