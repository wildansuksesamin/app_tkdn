<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->

<head>

    <?php $this->view('include/head'); ?>
    <?php $this->view('include/css'); ?>

</head>
<!-- end::Head -->

<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-theme-mode");
            } else {
                if (localStorage.getItem("data-theme") !== null) {
                    themeMode = localStorage.getItem("data-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url('<?php echo base_url(); ?>assets/media/auth/bg10.jpeg');
            }

            [data-theme="dark"] body {
                background-image: url('<?php echo base_url(); ?>assets/media/auth/bg10-dark.jpeg');
            }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-none d-lg-block d-flex flex-lg-row-fluid">
                <!--begin::Content-->
                <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                    <!--begin::Image-->
                    <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="<?php echo base_url(); ?>assets/media/auth/agency.png" alt="" />
                    <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="<?php echo base_url(); ?>assets/media/auth/agency-dark.png" alt="" />
                    <!--end::Image-->
                    <!--begin::Title-->
                    <h1 class="text-gray-100 fs-2qx fw-bold text-center mb-7">Fast, Efficient and Productive</h1>
                    <!--end::Title-->
                    <!--begin::Text-->
                    <div class="text-gray-300 fs-base text-center fw-semibold">In this kind of post,
                        <a href="#" class="opacity-75-hover text-primary me-1">the blogger</a>introduces a person they’ve interviewed
                        <br />and provides some background information about
                        <a href="#" class="opacity-75-hover text-primary me-1">the interviewee</a>and their
                        <br />work following this is a transcript of the interview.
                    </div>
                    <!--end::Text-->
                </div>
                <!--end::Content-->
            </div>
            <!--begin::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
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
                                <h1 class="text-dark fw-bolder mb-3">Login</h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">Silahkan masukkan email dan password yang sudah terdaftar untuk dapat masuk ke aplikasi pelanggan.</div>
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Heading-->

                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="email" placeholder="Email" name="email" id="email" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <!--end::Input group=-->
                            <div class="fv-row mb-3">
                                <!--begin::Password-->
                                <input type="password" placeholder="Password" name="password" id="password" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Password-->
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div></div>
                                <!--begin::Link-->
                                <a href="<?php echo base_url() . 'pelanggan/lupa_password'; ?>" class="link-primary">Lupa password ?</a>
                                <!--end::Link-->
                            </div>
                            <!--end::Wrapper-->
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
                            <!--end::Submit button-->
                            <!--begin::Sign up-->
                            <div class="text-gray-500 text-center fw-semibold fs-6">Belum memiliki akun?
                                <a href="<?php echo base_url() . 'pelanggan/daftar'; ?>" class="link-primary">Daftar</a>
                            </div>
                            <!--end::Sign up-->
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
    <script>
        var hostUrl = "assets/";
    </script>

    <?php $this->view('include/js'); ?>
    <script>
        $('#username').keyup(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                login();
            }
        });
        $('#password').keyup(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                login();
            }
        });

        $("#login").click(function() {
            login();
        });

        function login() {
            var email = $("#email").val();
            var password = $("#password").val();

            if (email == '' || password == '') {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else {
                //show loading animation...
                $("#login").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });
                //tampung value menjadi 1 varibel...
                var data = new Object;
                data['email'] = email;
                data['password'] = password;

                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>data_pelanggan/login',
                    data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                    cache: false,
                    dataType: "json",
                    success: function(data) {
                        //hide loading animation...
                        $("#login").removeAttr('disabled data-kt-indicator');

                        if (data.sts == 1) {
                            var response = JSON.parse('<?php echo alert('login_berhasil'); ?>');
                            toastrAlert(response);
                            location.href = '<?php echo base_url(); ?>pelanggan/beranda';
                        } else if (data.sts == 'not_valid') {
                            var response = JSON.parse('<?php echo alert('not_valid'); ?>');
                            swalAlert(response);
                        } else if (data.sts == 'email_not_verified') {
                            var response = JSON.parse('<?php echo alert('email_not_verified'); ?>');
                            swal.fire({
                                title: response.title,
                                text: response.message,
                                icon: response.type,
                                showCancelButton: true,
                                confirmButtonText: 'Ok, mengerti',
                                cancelButtonText: 'Request Email',
                                confirmButtonColor: '#0abb87',
                                cancelButtonColor: '#d33',
                                allowOutsideClick: false,
                                reverseButtons: true
                            }).then(function(result) {
                                if (result.dismiss === 'cancel') {
                                    location.href = '<?php echo base_url(); ?>pelanggan/request_verifikasi_email';
                                }
                            });
                        } else {
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