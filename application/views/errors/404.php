<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href="../../"/>

    <?php $this->view('include/head'); ?>
    <?php $this->view('include/css'); ?>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Page bg image-->
    <style>body { background-image: url('<?php echo base_url(); ?>assets/media/auth/bg1.jpg'); } [data-theme="dark"] body { background-image: url('assets/media/auth/bg1-dark.jpg'); }</style>
    <!--end::Page bg image-->
    <!--begin::Authentication - Signup Welcome Message -->
    <div class="d-flex flex-column flex-center flex-column-fluid">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center text-center p-10">
            <!--begin::Wrapper-->
            <div class="card card-flush w-lg-400px py-5">
                <div class="card-body py-5">
                    <!--begin::Title-->
                    <h1 class="fw-bolder fs-2hx text-gray-900 mb-4">Oops!</h1>
                    <!--end::Title-->
                    <!--begin::Text-->
                    <div class="fw-semibold fs-6 text-gray-500 mb-7">Alamat URL tidak tidak ditemukan dalam server kami.</div>
                    <!--end::Text-->
                    <!--begin::Illustration-->
                    <div class="mb-3">
                        <img src="<?php echo base_url(); ?>assets/media/auth/404-error.png" class="mw-80 mh-300px theme-light-show" alt="" />
                        <img src="<?php echo base_url(); ?>assets/media/auth/404-error-dark.png" class="mw-80 mh-300px theme-dark-show" alt="" />
                    </div>
                    <!--end::Illustration-->
                    <!--begin::Link-->
                    <div class="mb-0">
                        <a href="<?php echo base_url().($this->session->userdata('login_as') == 'administrator' ? 'page/home' : 'pelanggan/beranda'); ?>" class="btn btn-primary">Kembali Ke Beranda</a>
                    </div>
                    <!--end::Link-->
                </div>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Authentication - Signup Welcome Message-->
</div>
<!--end::Root-->
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<?php $this->view('include/js'); ?>
</body>
<!--end::Body-->
</html>
