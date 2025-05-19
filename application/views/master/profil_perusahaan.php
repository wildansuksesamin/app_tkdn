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
                                                Form Profil Perusahaan
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
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_profil_perusahaan" action="<?php echo base_url(); ?>Profil_perusahaan/simpan" autocomplete="off">
                                                    <input type="hidden" class="form-control" id="id_profil_perusahaan" name="id_profil_perusahaan" maxlength="11" placeholder="">
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nama Perusahaan</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_perusahaan" name="nama_perusahaan" maxlength="100" placeholder="" required value="<?php echo $konten['profil_perusahaan']->nama_perusahaan; ?>">
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nama Lengkap Perusahaan</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_lengkap_perusahaan" name="nama_lengkap_perusahaan" maxlength="100" placeholder="" required value="<?php echo $konten['profil_perusahaan']->nama_lengkap_perusahaan; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Alamat Pusat</label>
                                                            <textarea class="form-control form-control-solid" autocomplete="off" id="alamat_pusat" name="alamat_pusat" placeholder="" required><?php echo $konten['profil_perusahaan']->alamat_pusat; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Kantor Cabang</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="kantor_cabang" name="kantor_cabang" maxlength="100" placeholder="" required value="<?php echo $konten['profil_perusahaan']->kantor_cabang; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Alamat Kantor Cabang</label>
                                                            <textarea class="form-control form-control-solid" autocomplete="off" id="alamat_kantor_cabang" name="alamat_kantor_cabang" placeholder="" required><?php echo $konten['profil_perusahaan']->alamat_kantor_cabang; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">NPWP Perusahaan</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="npwp_perusahaan" name="npwp_perusahaan" maxlength="50" placeholder="" required value="<?php echo $konten['profil_perusahaan']->npwp_perusahaan; ?>">
                                                        </div>
                                                    </div>


                                                    <div class="separator mb-10 mt-10"></div>
                                                    <button type="submit" id="simpan" class="btn btn-primary">
                                                        <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                                        <span class="indicator-progress">Loading...
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
        $("#input_form_profil_perusahaan").on('submit', function(e) {
            e.preventDefault();

            var nama_perusahaan = $("#nama_perusahaan").val();
            var nama_lengkap_perusahaan = $("#nama_lengkap_perusahaan").val();
            var alamat_pusat = $("#alamat_pusat").val();
            var kantor_cabang = $("#kantor_cabang").val();
            var alamat_kantor_cabang = $("#alamat_kantor_cabang").val();
            var npwp_perusahaan = $("#npwp_perusahaan").val();

            if (!nama_perusahaan || !nama_lengkap_perusahaan || !alamat_pusat || !kantor_cabang || !alamat_kantor_cabang || !npwp_perusahaan) {
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
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }
                });
            }
        });
    </script>
</body>
<!-- end::Body -->

</html>