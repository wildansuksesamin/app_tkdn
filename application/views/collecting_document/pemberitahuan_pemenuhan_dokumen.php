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

                                <?php $this->view('collecting_document/include/header'); ?>
                                <div class="card card-flush">
                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17">
                                        <div class="<?php echo ($konten['pemenuhan_dokumen'] ? '' : 'hidden'); ?>">
                                            <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-6 p-6 hidden">
                                                <!--begin::Icon-->
                                                <?php echo getSvgIcon('general/gen040', 'svg-icon svg-icon-2tx svg-icon-danger me-4'); ?>
                                                <!--end::Icon-->
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack flex-grow-1">
                                                    <!--begin::Content-->
                                                    <div class="fw-semibold">
                                                        <h4 class="text-gray-900 fw-bold">Alasan Penolakan</h4>
                                                        <div class="fs-6 text-gray-700" id="alasan_penolakan"><?php echo $konten['opening_meeting']->alasan_status; ?></div>
                                                    </div>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                        </div>
                                        <!--begin::Layout-->
                                        <div class="d-flex flex-column flex-lg-row">
                                            <!--begin::Content-->
                                            <div class="flex-lg-row-fluid me-0">
                                                <!--begin::Form-->
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_pemberitahuan_pemenuhan_dokumen" action="<?php echo base_url(); ?>Pemberitahuan_pemenuhan_dokumen/simpan" autocomplete="off">
                                                    <input type="hidden" class="form-control" id="id_pemberitahuan" name="id_pemberitahuan" maxlength="11" placeholder="">

                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nomor Surat</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nomor_surat" name="nomor_surat" maxlength="200" placeholder="" required value="<?php echo ($konten['pemenuhan_dokumen'] ? $konten['pemenuhan_dokumen']->nomor_surat : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tgl Surat</label>
                                                            <input type="text" class="form-control form-control-solid datepicker" autocomplete="off" id="tgl_surat" name="tgl_surat" placeholder="" required value="<?php echo ($konten['pemenuhan_dokumen'] ? $konten['pemenuhan_dokumen']->tgl_surat : ''); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="separator mb-10 mt-10"></div>
                                                    <button type="submit" id="simpan" class="btn btn-primary">
                                                        <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                                        <span class="indicator-progress">Loading...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>

                                                    <a href="<?php echo base_url('page/proses_collecting_document'); ?>" class="btn btn-light btn-active-light-primary me-2">
                                                        <i class="fa-solid fa-arrow-left me-2 fs-3"></i>
                                                        Kembali
                                                    </a>

                                                    <input type="hidden" id="action" name="action" value="save">
                                                    <input type="hidden" id="id_opening_meeting" name="id_opening_meeting" value="<?php echo $konten['opening_meeting']->id_opening_meeting; ?>">
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
        $("#input_form_pemberitahuan_pemenuhan_dokumen").on('submit', function(e) {
            e.preventDefault();

            var id_pemberitahuan = $("#id_pemberitahuan").val();
            var id_opening_meeting = $("#id_opening_meeting").val();
            var nomor_surat = $("#nomor_surat").val();
            var tgl_surat = $("#tgl_surat").val();

            if (!id_opening_meeting || !nomor_surat || !tgl_surat) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else if (!moment(tgl_surat).isValid()) {
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
                            response.callback_yes = after_verifikasi;
                            swalAlert(response);
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }
                });
            }
        });

        function after_verifikasi() {
            location.href = base_url + "page/proses_collecting_document";
        }
    </script>
</body>
<!-- end::Body -->

</html>