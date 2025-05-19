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
                                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"><?php echo $konten['title']; ?></h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                        </div>
                    </div>

                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <div id="kt_app_content_container" class="app-container container-fluid">
                            <div class="card card-flush">
                                <div class="card-header pt-7">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--begin::Body-->
                                <div class="card-body p-lg-17">
                                    <!--begin::Layout-->
                                    <div class="d-flex flex-column flex-lg-row">
                                        <!--begin::Content-->
                                        <div class="flex-lg-row-fluid me-0">
                                            <!--begin::Form-->
                                            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_jns_admin" action="<?php echo base_url(); ?>hak_akses_permohonan_pemerintah/simpan" autocomplete="off">

                                                <div class="py-2">
													<!--begin::Item-->
													<div class="d-flex flex-stack">
														<div class="d-flex">
                                                            <?php echo getSvgIcon('general/gen062', 'scg-icon svg-icon-primary svg-icon-4x me-6'); ?>
															<img src="assets/media/svg/brand-logos/google-icon.svg" class="" alt="">
															<div class="d-flex flex-column">
																<a href="#" class="fs-5 text-dark text-hover-primary fw-bold">Akses Permohonan Pemerintah</a>
																<div class="fs-6 fw-semibold text-gray-400">Gunakan fitur ini hanya jika diperlukan</div>
															</div>
														</div>
														<div class="d-flex justify-content-end">
															<div class="form-check form-check-solid form-check-custom form-switch">
																<input class="form-check-input w-45px h-30px" type="checkbox" id="saklar" <?php echo $konten['checked']; ?> value="1">
																<label class="form-check-label" for="saklar"></label>
															</div>
														</div>
													</div>
													<!--end::Item-->
													<div class="separator separator-dashed my-5"></div>
													
												</div>

                                                <div class="separator mb-10 mt-10"></div>
                                                <button type="button" class="btn btn-primary" id="simpan">
                                                    <i class="fa-solid fa-floppy-disk me-2 fs-3"></i>
                                                    Simpan
                                                </button>

                                                <input type="hidden" id="action" name="action" value="save">
                                                <input type="hidden" id="token" name="token" value="<?php echo genToken('SEND_DATA'); ?>">

                                            </form>
                                            <!--end::Form-->

                                        </div>
                                        <!--end::Content-->

                                    </div>
                                    <!--end::Layout-->
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
    $("#simpan").click(function(){
        var saklar = $("#saklar").is(":checked");
        if(saklar){
            var status = 'aktif';
            var pertanyaan = "Apakah Anda yakin ingin mengaktifkan menu akses permohonan pemerintah?";
        }
        else{
            var status = 'off';
            var pertanyaan = "Apakah Anda yakin ingin menonaktifkan menu akses permohonan pemerintah?";
        }


        konfirmasi(pertanyaan, function(){
            proses_saklar(status);
        });
    });

    function proses_saklar(status){
        //show loading animation...
        preloader('show');

        var data = new Object;
        data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
        data['status'] = status;

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Hak_akses_permohonan_pemerintah/simpan',
            data: 'data_send='+encodeURIComponent(JSON.stringify(data)),
            cache: false,
            dataType: "json",
            success: function(data){
                //hide loading animation...
                preloader('hide');

                if(data.sts == 1){
                    var response = JSON.parse('<?php echo alert('hapus_berhasil'); ?>');
                    toastrAlert(response);
                }
                else{
                    var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                    swalAlert(response);
                }
            }

        });
    }
</script>
</body>
<!-- end::Body -->
</html>
