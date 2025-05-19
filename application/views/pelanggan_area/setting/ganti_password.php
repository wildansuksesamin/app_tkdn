<!DOCTYPE html>
<html lang="en" >
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
                                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Ganti Password</h1>
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
                                        <h2>Form Ganti Password</h2>
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
                                            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_jns_admin" action="" autocomplete="off">
                                                <input type="hidden" class="form-control" id="id_jns_admin" name="id_jns_admin" maxlength="11" placeholder="">

                                                <div class="row mb-5">
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2">Password Lama</label>
                                                        <input type="password" class="form-control form-control-solid" autocomplete="off" id="pwd_lama" name="pwd_lama" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-5">
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2">Password Baru</label>
                                                        <input type="password" class="form-control form-control-solid" autocomplete="off" id="pwd_baru" name="pwd_baru" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-5">
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2">Ulangi Password Baru</label>
                                                        <input type="password" class="form-control form-control-solid" autocomplete="off" id="ulang_pwd_baru" name="ulang_pwd_baru" required>
                                                    </div>
                                                </div>

                                                <div class="separator mb-10 mt-10"></div>
                                                <button type="button" class="btn btn-primary" id="simpan">
                                                    <i class="fa-solid fa-floppy-disk me-2 fs-3"></i>
                                                    Simpan
                                                </button>

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
    $("#simpan").click(function(){
        var pass_lama = $("#pwd_lama").val();
        var pass_baru = $("#pwd_baru").val();
        var ulang_pass_baru = $("#ulang_pwd_baru").val();

        if(pass_lama == '' || pass_baru == '' || ulang_pass_baru == ''){
            var response = JSON.parse('<?php echo alert('kosong'); ?>');
            swalAlert(response);
        }
        else if(pass_baru != ulang_pass_baru){
            var response = JSON.parse('<?php echo alert('password_tidak_sama'); ?>');
            swalAlert(response);
        }
        else{
            //show loading animation...
            var blockUI = generate_blockUI("#kt_app_body");
            blockUI.block();
            //tampung value menjadi 1 varibel...
            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['pass_lama'] = pass_lama;
            data['pass_baru'] = pass_baru;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/pelanggan/ganti_password',
                data: 'data_send='+encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data){
                    //hide loading animation...
                    blockUI.release(); blockUI.destroy();

                    if(data.sts == 1){
                        //hapus seluruh field...
                        $("#pwd_lama").val('');
                        $("#pwd_baru").val('');
                        $("#ulang_pwd_baru").val('');

                        var response = JSON.parse('<?php echo alert('ganti_pwd_berhasil'); ?>');
                        toastrAlert(response);
                    }
                    else if(data.sts == 'password_salah'){
                        var response = JSON.parse('<?php echo alert('password_salah'); ?>');
                        swalAlert(response);
                    }
                    else{
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
