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
                <div class="bg-body d-flex flex-center rounded-4 w-md-400px p-10">
                    <!--begin::Content-->
                    <div class="w-md-400px">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="#">
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <img src="<?php echo base_url(); ?>assets/images/logo_sambung.png" style="height: 50px; margin-bottom: 40px;">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">Email Berhasil Diverifikasi</h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">Selamat, email Anda berhasil diverifikasi, silahkan masuk ke aplikasi pelanggan dengan menggunakan email dan password yang telah Anda daftarkan.</div>
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <a href="<?php echo base_url().'pelanggan'; ?>" class="btn btn-primary">Login</a>
                            </div>
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
    <script>var hostUrl = "assets/";</script>

    <?php $this->view('include/js'); ?>
    </body>
</html>
