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
                                    <a href="<?php echo base_url() . 'pelanggan/riwayat_verifikasi_tkdn'; ?>" class="btn btn-light btn-active-light-primary">
                                        <i class="fa fa-arrow-left fs-1 me-2"></i>
                                        Kembali
                                    </a>
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
                                                Form Upload Dokumen Opening Meeting
                                            </h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17">
                                        <?php $this->view('pelanggan_area/include/notice_ketentuan_upload_file'); ?>

                                        <?php
                                        if ($konten['opening_meeting']->id_status == 6) {
                                            #jika id_status = 6 artinya dokumen ditolak Verifikator dan harus direvisi oleh pelanggan...
                                            #tampilkan alasan penolakkannya...

                                            echo '<div class="notice d-flex bg-light-warning rounded border-danger border border-dashed p-6 mb-13">
                                            ' . getSvgIcon('general/gen040', 'svg-icon svg-icon-2tx svg-icon-danger me-4') . '

                                                    <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                                        <div class="mb-3 mb-md-0 fw-semibold">
                                                            <h4 class="text-gray-900 fw-bold">Alasan Revisi Dokumen</h4>
                                                            <div class="fs-6 text-gray-700 pe-7">' . $konten['opening_meeting']->alasan_status . '</div>
                                                        </div>
                                                    </div>
                                                </div>';
                                        }
                                        ?>

                                        <div class="d-flex flex-column flex-lg-row">
                                            <!--begin::Content-->
                                            <div class="flex-lg-row-fluid me-0">
                                                <!--begin::Form-->
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_opening_meeting" action="<?php echo base_url(); ?>pelanggan_area/opening_meeting/upload_dokumen_opening_meeting" autocomplete="off">
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Surat Tugas Pelanggan</label>
                                                            <input type="file" required class="form-control form-control-solid" autocomplete="off" id="surat_tugas_pelanggan" name="surat_tugas_pelanggan" accept="application/pdf,image/jpeg">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Risalah Rapat Pelanggan</label>
                                                            <input type="file" required class="form-control form-control-solid" autocomplete="off" id="risalah_rapat_pelanggan" name="risalah_rapat_pelanggan" accept="application/pdf,image/jpeg">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Hadir Rapat Pelanggan</label>
                                                            <input type="file" required class="form-control form-control-solid" autocomplete="off" id="hadir_rapat_pelanggan" name="hadir_rapat_pelanggan" accept="application/pdf,image/jpeg">
                                                        </div>
                                                    </div>

                                                    <div class="separator mb-10 mt-10"></div>
                                                    <button type="submit" id="simpan" class="btn btn-primary">
                                                        <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> simpan</span>
                                                        <span class="indicator-progress">Loading...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>

                                                    <a href="<?php echo base_url() . 'pelanggan/riwayat_verifikasi_tkdn'; ?>" class="btn btn-light btn-active-light-primary me-2">
                                                        <i class="fa-solid fa-times me-2 fs-3"></i>
                                                        batal
                                                    </a>

                                                    <input type="hidden" id="id_opening_meeting" name="id_opening_meeting" value="<?php echo $konten['opening_meeting']->id_opening_meeting; ?>">
                                                    <input type="hidden" id="action" name="action" value="save">
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
        var list_data;
        $("#input_form_opening_meeting").on('submit', function(e) {
            e.preventDefault();

            var id_opening_meeting = $("#id_opening_meeting").val();
            var surat_tugas_pelanggan = $("#surat_tugas_pelanggan").val();
            var risalah_rapat_pelanggan = $("#risalah_rapat_pelanggan").val();
            var hadir_rapat_pelanggan = $("#hadir_rapat_pelanggan").val();

            if (!surat_tugas_pelanggan || !risalah_rapat_pelanggan || !hadir_rapat_pelanggan) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else {
                var pertanyaan = "Pastikan data yang Anda upload sudah benar. Apakah Anda ingin melanjutkan upload dokumen ini?";

                konfirmasi(pertanyaan, function() {
                    $("#simpan").attr({
                        "data-kt-indicator": "on",
                        'disabled': true
                    });

                    jQuery("#input_form_opening_meeting").ajaxSubmit({
                        dataType: 'json',
                        success: function(data) {
                            $("#simpan").removeAttr('disabled data-kt-indicator');

                            if (data.sts == 1) {
                                var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                                response.callback_yes = setelah_simpan;
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

                });
            }
        });

        function setelah_simpan() {
            location.href = base_url + 'pelanggan/riwayat_verifikasi_tkdn';
        }
    </script>
</body>
<!-- end::Body -->

</html>