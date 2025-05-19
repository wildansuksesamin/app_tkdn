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
                                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Profil Pelaggan</h1>
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
                                        <div class="card-title">
                                            <h2>Form Data Pelanggan</h2>
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
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_profil_pelanggan" action="<?php echo base_url(); ?>pelanggan_area/pelanggan/simpan" autocomplete="off">
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nama Perusahaan</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_perusahaan" name="nama_perusahaan" required>
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Alamat</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="alamat_perusahaan" name="alamat_perusahaan" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Email</label>
                                                            <input type="email" class="form-control form-control-solid" autocomplete="off" id="email" name="email" required>
                                                        </div>
                                                    </div>
                                                    <div style="font-weight: bold; font-size: 17px; padding: 10px 0;">Pejabat Penghubung Proses TKDN</div>
                                                    <div class="row mb-5" id="password_area">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nama Lengkap</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_pejabat_penghubung_proses_tkdn" name="nama_pejabat_penghubung_proses_tkdn" required>
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Jabatan</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="jabatan_pejabat_penghubung_proses_tkdn" name="jabatan_pejabat_penghubung_proses_tkdn" required>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-5" id="password_area">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nomor Telepon</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="telepon_pejabat_penghubung_proses_tkdn" name="telepon_pejabat_penghubung_proses_tkdn" required>
                                                        </div>
                                                    </div>
                                                    <div style="font-weight: bold; font-size: 17px; padding: 10px 0;">Pejabat Penghubung Invoice</div>
                                                    <div class="row mb-5" id="password_area">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nama Lengkap</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_pejabat_penghubung_invoice" name="nama_pejabat_penghubung_invoice" required>
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nomor Telepon</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="telepon_pejabat_penghubung_invoice" name="telepon_pejabat_penghubung_invoice" required>
                                                        </div>
                                                    </div>
                                                    <div style="font-weight: bold; font-size: 17px; padding: 10px 0;">Pejabat Penghubung Pajak</div>
                                                    <div class="row mb-5" id="password_area">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nama Lengkap</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_pejabat_penghubung_pajak" name="nama_pejabat_penghubung_pajak" required>
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nomor Telepon</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="telepon_pejabat_penghubung_pajak" name="telepon_pejabat_penghubung_pajak" required>
                                                        </div>
                                                    </div>

                                                    <div class="separator mb-10 mt-10"></div>
                                                    <button type="submit" id="simpan" class="btn btn-primary">
                                                        <!--begin::Indicator label-->
                                                        <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                                        <span class="indicator-progress">Tunggu Sebentar...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
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
        $("#input_form_profil_pelanggan").on('submit', function(e) {
            e.preventDefault();

            var nama_perusahaan = $("#nama_perusahaan").val();
            var alamat_perusahaan = $("#alamat_perusahaan").val();
            var email = $("#email").val();

            var nama_pejabat_penghubung_proses_tkdn = $("#nama_pejabat_penghubung_proses_tkdn").val();
            var jabatan_pejabat_penghubung_proses_tkdn = $("#jabatan_pejabat_penghubung_proses_tkdn").val();
            var telepon_pejabat_penghubung_proses_tkdn = $("#telepon_pejabat_penghubung_proses_tkdn").val();

            var nama_pejabat_penghubung_invoice = $("#nama_pejabat_penghubung_invoice").val();
            var telepon_pejabat_penghubung_invoice = $("#telepon_pejabat_penghubung_invoice").val();

            var nama_pejabat_penghubung_pajak = $("#nama_pejabat_penghubung_pajak").val();
            var telepon_pejabat_penghubung_pajak = $("#telepon_pejabat_penghubung_pajak").val();

            if (nama_perusahaan == '' ||
                alamat_perusahaan == '' ||
                email == '' ||
                nama_pejabat_penghubung_proses_tkdn == '' ||
                jabatan_pejabat_penghubung_proses_tkdn == '' ||
                telepon_pejabat_penghubung_proses_tkdn == '' ||
                nama_pejabat_penghubung_invoice == '' ||
                telepon_pejabat_penghubung_invoice == '' ||
                nama_pejabat_penghubung_pajak == '' ||
                telepon_pejabat_penghubung_pajak == '') {
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
                            toastrAlert(response);
                        } else if (data.sts == 'username_available') {
                            var response = JSON.parse('<?php echo alert('username_available'); ?>');
                            swalAlert(response);
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }

                    }
                });
            }

        });

        function load_data() {
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';

            var blockUI = generate_blockUI("#kt_app_root");
            blockUI.block();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/pelanggan/load_data',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(response) {
                    list_data = response;
                    blockUI.release();
                    blockUI.destroy();

                    if (list_data.length > 0) {
                        var data = list_data[0];
                        $("#nama_perusahaan").val(data.nama_perusahaan);
                        $("#alamat_perusahaan").val(data.alamat_perusahaan);
                        $("#email").val(data.email);

                        $("#nama_pejabat_penghubung_proses_tkdn").val(data.nama_pejabat_penghubung_proses_tkdn);
                        $("#jabatan_pejabat_penghubung_proses_tkdn").val(data.jabatan_pejabat_penghubung_proses_tkdn);
                        $("#telepon_pejabat_penghubung_proses_tkdn").val(data.telepon_pejabat_penghubung_proses_tkdn);

                        $("#nama_pejabat_penghubung_invoice").val(data.nama_pejabat_penghubung_invoice);
                        $("#telepon_pejabat_penghubung_invoice").val(data.telepon_pejabat_penghubung_invoice);

                        $("#nama_pejabat_penghubung_pajak").val(data.nama_pejabat_penghubung_pajak);
                        $("#telepon_pejabat_penghubung_pajak").val(data.telepon_pejabat_penghubung_pajak);
                    }

                }

            });
        }
        load_data();
    </script>
</body>
<!-- end::Body -->

</html>