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
        <style>body { background-image: url('<?php echo base_url(); ?>assets/media/auth/bg10.jpeg'); } [data-theme="dark"] body { background-image: url('<?php echo base_url(); ?>assets/media/auth/bg10-dark.jpeg'); }</style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Sign-in -->
        <div class="mx-auto d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <!--begin::Wrapper-->
                <div class="bg-body d-flex flex-center rounded-4 w-md-400px p-10">
                    <!--begin::Content-->
                    <div class="w-md-300px">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="../../demo1/dist/index.html" action="#">
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <img src="<?php echo base_url(); ?>assets/images/logo_sambung.png" style="height: 30px; margin-bottom: 40px;">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">Manajemen TKDN</h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">Silahkan masukkan username dan password Anda untuk masuk ke aplikasi E-TKDN SBA</div>
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Heading-->

                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="Username" name="username" id="username" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <!--end::Input group=-->
                            <div class="fv-row mb-3">
                                <!--begin::Password-->
                                <input type="password" placeholder="Password" name="password" id="password" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Password-->
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="button" id="login" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Sign In</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            
                            <div style="text-align: center;">PHP Version: <?php echo PHP_VERSION; ?></div>
                            <!--end::Submit button-->
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

    <?php $this->view('include/js'); ?>
    <script>

        $('#username').keyup(function(e) {
            if(e.which == 13) {
                e.preventDefault();
                login();
            }
        });
        $('#password').keyup(function(e) {
            if(e.which == 13) {
                e.preventDefault();
                login();
            }
        });

        $("#login").click(function(){
            login();
        });

        function login(){
            var username = $("#username").val();
            var password = $("#password").val();

            if(username == '' || password == ''){
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            }
            else{
                //show loading animation...
                $("#login").attr({"data-kt-indicator": "on", 'disabled': true});
                //tampung value menjadi 1 varibel...
                var data = new Object;
                data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
                data['username'] = username;
                data['password'] = password;

                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>gateway/login',
                    data: 'data_send='+encodeURIComponent(JSON.stringify(data)),
                    cache: false,
                    dataType: "json",
                    success: function(data){
                        //hide loading animation...
                        $("#login").removeAttr('disabled data-kt-indicator');

                        if(data.sts == 1){
                            var response = JSON.parse('<?php echo alert('login_berhasil'); ?>');
                            toastrAlert(response);
                            location.href = base_url+'page/home';
                        }
                        else if(data.sts == 'not_valid'){
                            var response = JSON.parse('<?php echo alert('not_valid'); ?>');
                            swalAlert(response);
                        }
                        else{
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }

                });
            }
        }
    </script>
    </body>
</html>
