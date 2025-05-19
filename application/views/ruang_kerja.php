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
        <div class="mx-auto d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <!--begin::Wrapper-->
                <div class="bg-body d-flex flex-center rounded-4 w-md-400px p-10">
                    <!--begin::Content-->
                    <div class="w-md-300px">
                        <div class="text-center mb-11">
                            <img src="<?php echo base_url(); ?>assets/images/logo_sambung.png" style="height: 30px; margin-bottom: 40px;">
                            <h1 class="text-dark fw-bolder mb-3">Pilih Ruang Kerja</h1>
                            <div class="text-gray-500 fw-semibold fs-6">Silakan pilih ruang kerja terlebih dahulu.</div>

                            <div class="row mt-4">
                                <div class="col-sm-12 mb-3">
                                    <a href="<?php echo base_url() . 'page/ruang_kerja/ORDER_TKDN' ?>" class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary btn-block fw-bold fs-3">Order TKDN <?php echo ($konten['notif']['order_tkdn'] > 0 ? '<span class="menu-badge"><span class="badge badge-success ms-4">' . $konten['notif']['order_tkdn'] . '</span></span>' : ''); ?></a>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <a href="<?php echo base_url() . 'page/ruang_kerja/VERIFIKASI_TKDN' ?>" class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary btn-block fw-bold fs-3">Verifikasi TKDN <?php echo ($konten['notif']['verifikasi_tkdn'] > 0 ? '<span class="menu-badge"><span class="badge badge-success ms-4">' . $konten['notif']['verifikasi_tkdn'] . '</span></span>' : ''); ?></a>
                                </div>

                                <div style="display: none" id="log_notif">
                                    <?php
                                    print_r($konten['notif']);
                                    ?>
                                </div>
                            </div>
                        </div>
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
            var username = $("#username").val();
            var password = $("#password").val();

            if (username == '' || password == '') {
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
                data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
                data['username'] = username;
                data['password'] = password;

                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>gateway/login',
                    data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                    cache: false,
                    dataType: "json",
                    success: function(data) {
                        //hide loading animation...
                        $("#login").removeAttr('disabled data-kt-indicator');

                        if (data.sts == 1) {
                            var response = JSON.parse('<?php echo alert('login_berhasil'); ?>');
                            toastrAlert(response);
                            location.href = base_url + 'page/home';
                        } else if (data.sts == 'not_valid') {
                            var response = JSON.parse('<?php echo alert('not_valid'); ?>');
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