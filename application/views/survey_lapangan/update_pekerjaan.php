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
                                    <h1
                                        class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                        <?php echo $konten['title']; ?>
                                    </h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">

                                <div class="card card-flush h-lg-100">
                                    <div class="card-header align-items-center py-5 gap-2 gap-md-5"></div>

                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17" style="padding-top: unset!important;">
                                        <!--begin::Layout-->

                                        <form action="<?= base_url('page/save_update_pekerjaan') ?>" method="post"
                                            enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?= $result->id ?? '' ?>">

                                            <p>
                                                <label>File Perjab:</label><br>
                                                <input type="file" name="file_perjab">
                                            </p>

                                            <p>
                                                <label>File Surat Tugas:</label><br>
                                                <input type="file" name="file_surat_tugas">
                                            </p>

                                            <p>
                                                <div class="mt-3 fs-6 text-gray-500 required">Anggaran</div>
                                                <div class="input-group input-group-solid mb-5">
                                                    <span class="input-group-text" id="basic-addon2">Rp</span>
                                                    <input type="text" id="subsidi-anggaran" name="anggaran" class="form-control form-control-lg fs-2" autocomplete="off" value="<?= $konten['data']->biaya_operasional ?>" required />
                                                </div>
                                            </p>

                                            <p>
                                                <button type="submit">Simpan</button>
                                            </p>
                                        </form>
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
        $(document).ready(function () {
        });
    </script>

</body>
<!-- end::Body -->

</html>