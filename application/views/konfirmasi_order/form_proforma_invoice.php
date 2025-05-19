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
                                <div class="card card-flush mb-5">
                                    <div class="card-body p-lg-17">
                                        <div class="flex-grow-1">
                                            <!--begin::Title-->
                                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                                <!--begin::User-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Name-->
                                                    <div class="d-flex align-items-center mb-2">
                                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?php echo $konten['surat_oc']->nama_badan_usaha . ' ' . $konten['surat_oc']->nama_perusahaan; ?></a>
                                                        <a href="#">
                                                            <?php echo getSvgIcon('general/gen026', 'svg-icon svg-icon-1 svg-icon-primary'); ?>
                                                        </a>
                                                    </div>
                                                    <!--end::Name-->
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-wrap fw-semibold fs-6 pe-2">
                                                        <a href="#" class="text-gray-400 text-hover-primary me-10">
                                                            <div class="text-gray-400 fw-semibold d-block fs-7">Tgl Surat Penawaran</div>
                                                            <div class="fw-bold text-gray-800"><?php echo reformat_date($konten['surat_oc']->tgl_surat_penawaran, array('new_delimiter' => ' ', 'month_type' => 'full')); ?></div>
                                                        </a>
                                                        <a href="#" class="text-gray-400 text-hover-primary me-10">
                                                            <div class="text-gray-400 fw-semibold d-block fs-7">Nomor Surat Penawaran</div>
                                                            <div class="fw-bold text-gray-800"><?php echo $konten['surat_oc']->nomor_surat_penawaran; ?></div>
                                                        </a>
                                                        <a href="#" class="text-gray-400 text-hover-primary">
                                                            <div class="text-gray-400 fw-semibold d-block fs-7">Jenis</div>
                                                            <div class="fw-bold text-gray-800"><?php echo $konten['surat_oc']->jns_surat_penawaran; ?></div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="d-flex my-4">
                                                    <a href="<?php echo base_url() . 'page/profil_pelanggan/' . $konten['surat_oc']->id_pelanggan; ?>" class="btn btn-sm btn-light-success me-2" target="_blank">
                                                        <?php echo getSvgIcon('general/gen049', 'svg-icon svg-icon-3'); ?>
                                                        Pelanggan
                                                    </a>
                                                    <a href="<?php echo base_url() . 'page/detail_dokumen_permohonan/' . $konten['surat_oc']->id_dokumen_permohonan; ?>" class="btn btn-sm btn-light-success me-2" target="_blank">
                                                        <?php echo getSvgIcon('files/fil008', 'svg-icon svg-icon-3'); ?>
                                                        Dok. Permohonan
                                                    </a>
                                                    <a href="<?php echo base_url() . 'page/lihat_surat_penawaran/' . $konten['surat_oc']->id_surat_penawaran; ?>" class="btn btn-sm btn-light-success me-2" target="_blank">
                                                        <?php echo getSvgIcon('files/fil008', 'svg-icon svg-icon-3'); ?>
                                                        Penawaran
                                                    </a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="card card-flush form_zone">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>
                                                Form Proforma Invoice
                                            </h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <div class="<?php echo ($konten['surat_oc']->status_pengajuan == 18 ? '' : 'hidden'); ?>">
                                        <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mx-6 p-6 hidden">
                                            <!--begin::Icon-->
                                            <?php echo getSvgIcon('general/gen040', 'svg-icon svg-icon-2tx svg-icon-danger me-4'); ?>
                                            <!--end::Icon-->
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <!--begin::Content-->
                                                <div class="fw-semibold">
                                                    <h4 class="text-gray-900 fw-bold">Alasan Penolakan</h4>
                                                    <div class="fs-6 text-gray-700" id="alasan_penolakan"><?php echo ($konten['surat_oc']->status_pengajuan == 18 ? $konten['surat_oc']->alasan_verifikasi : ''); ?></div>
                                                </div>
                                                <!--end::Content-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                    </div>

                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17">
                                        <!--begin::Layout-->
                                        <div class="d-flex flex-column flex-lg-row">
                                            <!--begin::Content-->
                                            <div class="flex-lg-row-fluid me-0">
                                                <!--begin::Form-->
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_proforma_invoice" action="<?php echo base_url(); ?>Proforma_invoice/simpan" autocomplete="off">
                                                    <input type="hidden" class="form-control" id="id_proforma_invoice" name="id_proforma_invoice" maxlength="11" placeholder="">

                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class=" fs-5 fw-semibold mb-2">Nomor Invoice</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nomor_invoice" name="nomor_invoice" maxlength="100" placeholder="" value="<?php echo ($konten['surat_oc']->status_pengajuan == 18 ? $konten['proforma_invoice']->nomor_invoice : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tanggal Awal Pelaksanaan</label>
                                                            <input type="text" class="form-control form-control-solid datepicker" autocomplete="off" id="tgl_awal_pelaksanaan" name="tgl_awal_pelaksanaan" placeholder="" required value="<?php echo ($konten['surat_oc']->status_pengajuan == 18 ? $konten['proforma_invoice']->tgl_awal_pelaksanaan : ''); ?>">
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tgl Akhir Pelaksanaan</label>
                                                            <input type="text" class="form-control form-control-solid datepicker" autocomplete="off" id="tgl_akhir_pelaksanaan" name="tgl_akhir_pelaksanaan" placeholder="" required value="<?php echo ($konten['surat_oc']->status_pengajuan == 18 ? $konten['proforma_invoice']->tgl_akhir_pelaksanaan : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class=" fs-5 fw-semibold mb-2">Catatan</label>
                                                            <textarea class="form-control form-control-solid" autocomplete="off" id="catatan" name="catatan" placeholder=""><?php echo ($konten['surat_oc']->status_pengajuan == 18 ? $konten['proforma_invoice']->catatan : ''); ?></textarea>
                                                        </div>
                                                    </div>


                                                    <div class="separator mb-10 mt-10"></div>
                                                    <button type="submit" id="simpan" class="btn btn-primary">
                                                        <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                                        <span class="indicator-progress">Loading...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>

                                                    <button class="btn btn-light btn-active-light-primary me-2" type="button" onclick="window.history.back()">
                                                        <i class="fa-solid fa-times me-2 fs-3"></i>
                                                        Batal
                                                    </button>

                                                    <input type="hidden" id="action" name="action" value="<?php echo ($konten['surat_oc']->status_pengajuan == 18 ? 'update' : 'save'); ?>">
                                                    <input type="hidden" id="id_dokumen_permohonan" name="id_dokumen_permohonan" value="<?php echo $konten['surat_oc']->id_dokumen_permohonan; ?>">
                                                    <input type="hidden" id="id_surat_oc" name="id_surat_oc" value="<?php echo $konten['surat_oc']->id_surat_oc; ?>">
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
        $("#tgl_awal_pelaksanaan, #tgl_akhir_pelaksanaan").flatpickr(datepicker_variable);
        $("#input_form_proforma_invoice").on('submit', function(e) {
            e.preventDefault();

            var id_proforma_invoice = $("#id_proforma_invoice").val();
            var id_surat_oc = $("#id_surat_oc").val();
            var nomor_invoice = $("#nomor_invoice").val();
            var tgl_awal_pelaksanaan = $("#tgl_awal_pelaksanaan").val();
            var tgl_akhir_pelaksanaan = $("#tgl_akhir_pelaksanaan").val();
            var catatan = $("#catatan").val();

            var action = $("#action").val();

            if (!action || !id_surat_oc || !tgl_awal_pelaksanaan || !tgl_akhir_pelaksanaan) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else if (!moment(tgl_awal_pelaksanaan).isValid()) {
                var response = JSON.parse('<?php echo alert('format_tgl_salah'); ?>');
                swalAlert(response);
            } else if (!moment(tgl_akhir_pelaksanaan).isValid()) {
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
            location.href = base_url + 'page/buat_proforma_invoice';
        }
    </script>
</body>
<!-- end::Body -->

</html>