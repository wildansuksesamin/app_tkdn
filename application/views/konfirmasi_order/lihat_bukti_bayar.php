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
                                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                    <?php echo $konten['title']; ?>
                                </h1>
                                <!--end::Title-->
                            </div>

                            <div class="d-flex align-items-center gap-2 gap-lg-3">
                                <!--begin::Secondary button-->
                                <button type="button" class="btn btn-sm btn-light btn-active-light-primary" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Kembali</button>
                                <!--end::Secondary button-->
                            </div>
                            <!--end::Page title-->
                        </div>
                    </div>

                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <div id="kt_app_content_container" class="app-container container-fluid">

                            <div class="card card-flush h-lg-100 tabel_zone" id="tabel_dokumen_penawaran">

                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="mb-5" id="only_image" style="display: none;">
                                        <button type="button" id="print" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Print</button>
                                        <a href="<?php echo base_url().$konten['surat_oc']->bukti_bayar; ?>" download class="btn btn-sm btn-primary"><i class="fa fa-download"></i> Download</a>
                                    </div>
                                    <input type="hidden" id="id_surat_oc" name="id_surat_oc" value="<?php echo $konten['surat_oc']->id_surat_oc; ?>">
                                    <input type="hidden" id="id_dokumen_permohonan" name="id_dokumen_permohonan" value="<?php echo $konten['surat_oc']->id_dokumen_permohonan; ?>">
                                    <iframe id="iframe" src="<?php echo base_url().$konten['surat_oc']->bukti_bayar; ?>" style="width: 100%; border: unset; height: 500px;"></iframe>
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
    var url = $("#iframe").attr('src');
    var pecah = url.split('.');
    var extention = pecah[pecah.length - 1];
    if(extention != 'pdf'){
        $("#only_image").show();
    }
    $("#print").click(function(){
        document.getElementById("iframe").contentWindow.print();
    });
</script>
</body>
<!-- end::Body -->
</html>
