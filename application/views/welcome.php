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
                                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Beranda</h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                        </div>
                    </div>

                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <div id="kt_app_content_container" class="app-container container-fluid">
                            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                                <div class="col-xxl-6">
                                    <!--begin::Engage widget 10-->
                                    <div class="card card-flush h-md-100">
                                        <!--begin::Body-->
                                        <div class="card-body d-flex flex-column justify-content-between mt-9 bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0" style="background-position: 100% 50%; background-image:url('assets/media/stock/900x600/42.png')">
                                            <!--begin::Wrapper-->
                                            <div class="mb-10">
                                                <!--begin::Title-->
                                                <div class="fs-2hx fw-bold text-gray-800 text-center mb-13">
                                                    <span class="me-2">
                                                        Selamat Datang Di
                                                        <br>
                                                        <span class="position-relative d-inline-block text-danger">
                                                            <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-danger opacity-75-hover"><?php echo $aplikasi; ?></a>
                                                            <!--begin::Separator-->
                                                            <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                                                            <!--end::Separator-->
                                                        </span>
                                                    </span>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--begin::Wrapper-->
                                            <!--begin::Illustration-->
                                            <img class="mx-auto h-150px h-lg-200px theme-light-show" src="<?php echo base_url(); ?>assets/media/illustrations/dozzy-1/2.png" alt="">
                                            <img class="mx-auto h-150px h-lg-200px theme-dark-show" src="<?php echo base_url(); ?>assets/media/illustrations/dozzy-1/2-dark.png" alt="">
                                            <!--end::Illustration-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Engage widget 10-->
                                </div>
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
</body>
<!-- end::Body -->
</html>
