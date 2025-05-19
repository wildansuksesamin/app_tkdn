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
                                <div class="card card-flush form_zone">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>
                                                Form Payment Detail
                                            </h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17">
                                        <div class="<?php echo ($konten['action'] == 'revisi' ? '' : 'hidden'); ?>">
                                            <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-9 p-6 hidden">
                                                <!--begin::Icon-->
                                                <?php echo getSvgIcon('general/gen040', 'svg-icon svg-icon-2tx svg-icon-danger me-4'); ?>
                                                <!--end::Icon-->
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack flex-grow-1">
                                                    <!--begin::Content-->
                                                    <div class="fw-semibold">
                                                        <h4 class="text-gray-900 fw-bold">Alasan Penolakan</h4>
                                                        <div class="fs-6 text-gray-700" id="alasan_penolakan"><?php echo ($konten['action'] == 'revisi' ? $konten['form_01']->alasan_verifikasi : ''); ?></div>
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
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_payment_detail" action="<?php echo base_url(); ?>Payment_detail/simpan" autocomplete="off">
                                                    <input type="hidden" class="form-control" id="id_payment_detail" name="id_payment_detail" maxlength="11" placeholder="" value="<?php echo ($konten['payment_detail'] ? $konten['payment_detail']->id_payment_detail : ''); ?>">
                                                    <input type="hidden" class="form-control" id="id_form_01" name="id_form_01" value="<?php echo $konten['form_01']->id_form_01; ?>">
                                                    <input type="hidden" class="form-control" id="id_dokumen_permohonan" name="id_dokumen_permohonan" value="<?php echo $konten['form_01']->id_dokumen_permohonan; ?>">

                                                    <div class="row mb-5">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Bidang Operasi</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="bidang_operasi" name="bidang_operasi" maxlength="30" placeholder="" required value="<?php echo ($konten['payment_detail'] ? $konten['payment_detail']->bidang_operasi : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nomor Order</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nomor_order_payment" name="nomor_order_payment" maxlength="50" placeholder="" required value="<?php echo ($konten['payment_detail'] ? $konten['payment_detail']->nomor_order_payment : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Pelanggan</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo $konten['form_01']->nama_badan_usaha . ' ' . $konten['form_01']->nama_perusahaan; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Sertifikat</label>
                                                        <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo $konten['form_01']->nomor_oc; ?>">
                                                        </div>
                                                        <label class="col-lg-2 col-form-label fw-semibold fs-6">Tanggal</label>
                                                        <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo reformat_date($konten['form_01']->tgl_oc, array('new_delimiter' => ' ', 'month_type' => 'full', 'date_reverse' => true)); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Besar Tagihan</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" disabled value="Rp<?php echo convertToRupiah(($konten['form_01']->termin_1 / 100) * $konten['form_01']->nilai_kontrak); ?> Belum termasuk PPN 11%">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Catatan</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <textarea class="form-control form-control-solid" autocomplete="off" id="catatan" name="catatan" placeholder=""><?php echo ($konten['payment_detail'] ? $konten['payment_detail']->catatan : ''); ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="separator mb-10 mt-10"></div>
                                                    <button type="submit" id="simpan" class="btn btn-primary">
                                                        <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                                        <span class="indicator-progress">Loading...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>

                                                    <input type="hidden" id="action" name="action" value="<?php echo $konten['action']; ?>">
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
        $("#input_form_payment_detail").on('submit', function(e) {
            e.preventDefault();

            var id_payment_detail = $("#id_payment_detail").val();
            var id_form_01 = $("#id_form_01").val();
            var bidang_operasi = $("#bidang_operasi").val();
            var nomor_order_payment = $("#nomor_order_payment").val();
            var catatan = $("#catatan").val();
            var action = $("#action").val();

            if (!action || !id_form_01 || !bidang_operasi || !nomor_order_payment) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
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
            location.href = base_url + 'page/buat_payment_detail';
        }
    </script>
</body>
<!-- end::Body -->

</html>