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

                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <button onclick="kembali_buat_surat_tugas()" type="button" class="btn btn-light btn-active-light-primary">
                                        <i class="fa fa-arrow-left fs-1 me-2"></i>
                                        kembali
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
                                                Form Surat Tugas
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
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_surat_tugas" action="<?php echo base_url(); ?>Surat_tugas/simpan" autocomplete="off">
                                                    <input type="hidden" class="form-control" id="id_surat_tugas" name="id_surat_tugas" maxlength="11" placeholder="" value="<?php echo ($konten['opening_meeting']->id_status == 2 ? $konten['surat_tugas']->id_surat_tugas : ''); ?>">

                                                    <?php
                                                    if ($konten['opening_meeting']->id_status == 2) {
                                                        #terjadi penolakan dari pelanggan terhadap dokumen surat tugas..
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
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nomor Order</label>
                                                            <input type="text" class="form-control form-control-solid" readonly value="<?php echo $konten['opening_meeting']->nomor_order_payment; ?>">
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class=" fs-5 fw-semibold mb-2">Pelanggan</label>
                                                            <input type="text" class="form-control form-control-solid" readonly value="<?php echo $konten['opening_meeting']->nama_badan_usaha . ' ' . $konten['opening_meeting']->nama_perusahaan; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Jenis Jasa / Sub Kelompok / Obyek komoditi</label>
                                                            <input type="text" class="form-control form-control-solid" readonly value="<?php echo ($konten['opening_meeting']->tipe_pengajuan == 'PEMERINTAH' ? 'Inspeksi Verifikasi TKDN Berbayar Pemerintah / Non Komoditas' : 'Inspeksi Verifikasi TKDN Berbayar Pelaku Usaha / Non Komoditas'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="separator mb-10 mt-10"></div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nomor Surat Tugas</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nomor_surat_tugas" name="nomor_surat_tugas" value="<?php echo ($konten['opening_meeting']->id_status == 2 ? $konten['surat_tugas']->nomor_surat_tugas : ''); ?>" maxlength="100" placeholder="" required>
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tgl Surat Tugas</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="tgl_surat_tugas" name="tgl_surat_tugas" value="<?php echo ($konten['opening_meeting']->id_status == 2 ? $konten['surat_tugas']->tgl_surat_tugas : ''); ?>" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class=" fs-5 fw-semibold mb-2">Komoditi</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="komoditi" name="komoditi" value="<?php echo ($konten['opening_meeting']->id_status == 2 ? $konten['surat_tugas']->komoditi : ''); ?>" maxlength="200" placeholder="">
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class=" fs-5 fw-semibold mb-2">Kuantitas / Satuan</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="kuantitas_satuan" name="kuantitas_satuan" value="<?php echo ($konten['opening_meeting']->id_status == 2 ? $konten['surat_tugas']->kuantitas_satuan : ''); ?>" maxlength="200" placeholder="">
                                                        </div>

                                                    </div>
                                                    <div class="row mb-5">

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tempat Pelaksanaan</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="tempat_pelaksanaan" name="tempat_pelaksanaan" value="<?php echo ($konten['opening_meeting']->id_status == 2 ? $konten['surat_tugas']->tempat_pelaksanaan : ''); ?>" maxlength="200" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tgl Berangkat</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="tgl_berangkat" name="tgl_berangkat" value="<?php echo ($konten['opening_meeting']->id_status == 2 ? $konten['surat_tugas']->tgl_berangkat : ''); ?>" placeholder="" required>
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Rencana Selesai</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="rencana_selesai" name="rencana_selesai" value="<?php echo ($konten['opening_meeting']->id_status == 2 ? $konten['surat_tugas']->rencana_selesai : ''); ?>" placeholder="" required>
                                                        </div>
                                                    </div>

                                                    <div class="separator mb-10 mt-10"></div>
                                                    <button type="submit" id="simpan" class="btn btn-primary">
                                                        <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                                        <span class="indicator-progress">Loading...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>

                                                    <button onclick="kembali_buat_surat_tugas()" class="btn btn-light btn-active-light-primary me-2" type="button">
                                                        <i class="fa-solid fa-times me-2 fs-3"></i>
                                                        Batal
                                                    </button>
                                                    <input type="hidden" name="id_opening_meeting" id="id_opening_meeting" value="<?php echo $konten['opening_meeting']->id_opening_meeting; ?>">
                                                    <input type="hidden" id="action" name="action" value="<?php echo ($konten['opening_meeting']->id_status == 2 ? 'revisi' : 'save'); ?>">
                                                    <input type="hidden" id="token" name="token" value="<?php echo genToken('SEND_DATA'); ?>">
                                                    <input type="hidden" id="tipe_surat_tugas" name="tipe_surat_tugas" value="<?php echo $konten['tipe_surat_tugas']; ?>">

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
        var tipe_surat_tugas = '<?php echo $konten['tipe_surat_tugas']; ?>';
        $('#tgl_surat_tugas, #tgl_berangkat, #rencana_selesai').flatpickr(datepicker_variable);
        var list_data;
        $("#input_form_surat_tugas").on('submit', function(e) {
            e.preventDefault();

            var id_surat_tugas = $("#id_surat_tugas").val();
            var id_opening_meeting = $("#id_opening_meeting").val();
            var nomor_surat_tugas = $("#nomor_surat_tugas").val();
            var tgl_surat_tugas = $("#tgl_surat_tugas").val();
            var komoditi = $("#komoditi").val();
            var tempat_pelaksanaan = $("#tempat_pelaksanaan").val();
            var tgl_berangkat = $("#tgl_berangkat").val();
            var rencana_selesai = $("#rencana_selesai").val();

            var action = $("#action").val();

            if (!action || !id_opening_meeting || !nomor_surat_tugas || !tgl_surat_tugas || !tempat_pelaksanaan || !tgl_berangkat || !rencana_selesai) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else if (!moment(tgl_surat_tugas).isValid()) {
                var response = JSON.parse('<?php echo alert('format_tgl_salah'); ?>');
                swalAlert(response);
            } else if (!moment(tgl_berangkat).isValid()) {
                var response = JSON.parse('<?php echo alert('format_tgl_salah'); ?>');
                swalAlert(response);
            } else if (!moment(rencana_selesai).isValid()) {
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
                            $("#id_surat_tugas").val(data.id_surat_tugas);
                            response.callback_yes = lihat_surat_tugas;
                            swalAlert(response);
                        } else if (data.sts == 'tidak_berhak_ubah_data') {
                            var response = JSON.parse('<?php echo alert('tidak_berhak_ubah_data'); ?>');
                            response.callback_yes = kembali_buat_surat_tugas;
                            swalAlert(response);

                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }
                });
            }
        });

        function lihat_surat_tugas() {
            var id_surat_tugas = $("#id_surat_tugas").val();
            location.href = base_url + 'page/lihat_surat_tugas/' + id_surat_tugas;
        }

        function kembali_buat_surat_tugas() {
            if (tipe_surat_tugas == 'opening_meeting') {
                location.href = base_url + 'page/buat_surat_tugas';

            } else if (tipe_surat_tugas == 'survey_lapangan') {
                location.href = base_url + 'page/surat_tugas_lapangan';

            }
        }
    </script>
</body>
<!-- end::Body -->

</html>