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
                    <h1 class="text-white fs-2qx fw-bold text-center mb-7">Fast, Efficient and Productive</h1>
                    <!--end::Title-->
                    <!--begin::Text-->
                    <div class="text-gray-600 fs-base text-center fw-semibold">In this kind of post,
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
                                <h1 class="text-dark fw-bolder mb-3">Email Belum Diverifikasi?</h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">Masukkan email yang terdaftar dan kami akan mengirimi Anda tautan untuk memverifikasi email Anda.</div>
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Heading-->

                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="email" placeholder="Email" name="email" id="email" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="button" id="kirim" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Kirim Verifikasi Email</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Silahkan Tunggu...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            <!--end::Submit button-->
                            <!--begin::Sign up-->
                            <div class="text-gray-500 text-center fw-semibold fs-6">
                                <a href="<?php echo base_url() . 'pelanggan'; ?>" class="link-primary">Kembali Ke Halaman Login</a>
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
        $("#kirim").click(function() {
            kirim_verifikasi();
        });

        function kirim_verifikasi() {
            var email = $("#email").val();

            if (email == '') {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else {
                //show loading animation...
                $("#kirim").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });
                //tampung value menjadi 1 varibel...
                var data = new Object;
                data['email'] = email;

                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>data_pelanggan/request_verifikasi_email',
                    data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                    cache: false,
                    dataType: "json",
                    success: function(data) {
                        //hide loading animation...
                        $("#kirim").removeAttr('disabled data-kt-indicator');

                        if (data.sts == 1) {
                            location.href = '<?php echo base_url(); ?>pelanggan/daftar/berhasil?email=' + data.email;
                        } else if (data.sts == 'email_tidak_ada') {
                            var response = JSON.parse('<?php echo alert('email_tidak_ada'); ?>');
                            swalAlert(response);
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