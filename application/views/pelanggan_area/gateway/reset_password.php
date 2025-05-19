<!DOCTYPE html>
<html lang="en" >
	<!-- begin::Head -->
	<head>

        <?php $this->view('include/head'); ?>
        <?php $this->view('include/css'); ?>

	</head>
	<!-- end::Head -->

    <body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>body { background-attachment: fixed; background-image: url('<?php echo base_url(); ?>assets/media/auth/bg10.jpeg'); } [data-theme="dark"] body { background-image: url('<?php echo base_url(); ?>assets/media/auth/bg10-dark.jpeg'); }</style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Sign-in -->
        <div class="mx-auto d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <!--begin::Wrapper-->
                <div class="bg-body d-flex flex-center rounded-4 w-md-500px p-10">
                    <!--begin::Content-->
                    <div class="w-md-400px">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="#">
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <img src="<?php echo base_url(); ?>assets/images/logo_sambung.png" style="height: 50px; margin-bottom: 40px;">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">Buat Kata Sandi Yang Kuat</h1>
                                <!--end::Title-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <div class="fv-row fv-plugins-icon-container">
                                    <label class="required fs-5 fw-semibold mb-2">Password Baru</label>
                                    <input type="password" class="form-control form-control-solid" autocomplete="off" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="fv-row mb-8">
                                <div class="fv-row fv-plugins-icon-container">
                                    <label class="required fs-5 fw-semibold mb-2">Ulangi Password Baru</label>
                                    <input type="password" class="form-control form-control-solid" autocomplete="off" id="ulangi_password" name="ulangi_password" required>
                                </div>
                            </div>

                            <!--end::Input group=-->
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <input type="hidden" id="token" name="token" value="<?php echo $konten['token']; ?>">

                                <button type="button" id="simpan_password" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Atur Ulang Kata Sandi</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--begin::Javascript-->
    <script>var hostUrl = "assets/";</script>

    <?php $this->view('include/js'); ?>
    <script>
        $("#simpan_password").click(function(){
            var password = $("#password").val();
            var ulangi_password = $("#ulangi_password").val();
            var token = $("#token").val();

            if(password == '' || ulangi_password == ''){
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            }
            else if(password != ulangi_password){
                var response = JSON.parse('<?php echo alert('password_tidak_sama'); ?>');
                swalAlert(response);
            }
            else{
                //show loading animation...
                $("#simpan_password").attr({"data-kt-indicator": "on", 'disabled': true});
                //tampung value menjadi 1 varibel...
                var data = new Object;
                data['token'] = token;
                data['password'] = password;

                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>request_forgot_password/ganti_password',
                    data: 'data_send='+encodeURIComponent(JSON.stringify(data)),
                    cache: false,
                    dataType: "json",
                    success: function(data){
                        //hide loading animation...
                        $("#simpan_password").removeAttr('disabled data-kt-indicator');

                        if(data.sts == 1){
                            location.href = '<?php echo base_url(); ?>pelanggan/reset_password_berhasil';
                        }
                        else if(data.sts == 'not_valid'){
                            var response = JSON.parse('<?php echo alert('tidak_berhak_akses_data'); ?>');
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
</html>
