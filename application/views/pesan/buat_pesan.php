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
                            <!--end::Page title-->
                        </div>
                    </div>

                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <div id="kt_app_content_container" class="app-container container-fluid">
                            <div class="card card-flush">
                                <div class="card-header pt-7">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>
                                            Form Buat Pesan
                                        </h2>
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
                                            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_pesan" action="<?php echo base_url(); ?>Pesan/simpan" autocomplete="off">
                                                <input type="hidden" class="form-control" id="id_pesan" name="id_pesan" maxlength="11" placeholder="">
							
                                                <div class="row mb-5">
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2">Nomor Surat</label>
                                                        <input type="text" class="form-control form-control-solid" autocomplete="off" id="nomor_surat" name="nomor_surat" maxlength="100" placeholder="" required>
                                                    </div>
                                                    
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2">Tanggal Surat</label>
                                                        <input type="text" class="form-control form-control-solid datepicker" autocomplete="off" id="tgl_surat" name="tgl_surat" placeholder="" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-5">
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2">Perusahaan</label>
                                                        <input type="text" class="form-control form-control-solid" autocomplete="off" disabled value="<?php echo $konten['pelanggan']['nama_perusahaan']?>">
                                                    </div>
                                                </div>
                                                <div class="row mb-5">
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2">Alamat</label>
                                                        <textarea class="form-control form-control-solid" autocomplete="off" disabled><?php echo $konten['pelanggan']['alamat_perusahaan']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-5">
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2">Perihal Pesan</label>
                                                        <input type="text" class="form-control form-control-solid" autocomplete="off" id="perihal_pesan" name="perihal_pesan" maxlength="200" placeholder="" required value="<?php echo $konten['perihal']; ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="separator mb-10 mt-10"></div>
                                                <button type="submit" id="simpan" class="btn btn-primary">
                                                    <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                                    <span class="indicator-progress">Loading...
										            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>

                                                <button class="btn btn-light btn-active-light-primary me-2" type="button" onclick="form_action('hide')">
                                                    <i class="fa-solid fa-times me-2 fs-3"></i>
                                                    Batal
                                                </button>

                                                <textarea id="isi_pesan" name="isi_pesan" style="display: none;">
                                                    <?php echo $konten['isi_pesan'] ?>
                                                </textarea>
                                                <input type="hidden" id="id_pelanggan" name="id_pelanggan" value="<?php echo $konten['pelanggan']['id_pelanggan'] ?>">
                                                <input type="hidden" id="id_dokumen_permohonan" name="id_dokumen_permohonan" value="<?php echo $konten['id_dokumen_permohonan']; ?>">
                                                <input type="hidden" id="tag" name="tag" value="<?php echo $konten['tag']; ?>">
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
    
    var list_data;
    $("#input_form_pesan").on('submit', function(e){
        e.preventDefault();

        var id_pesan = $("#id_pesan").val();
        var id_pelanggan = $("#id_pelanggan").val();
        var nomor_surat = $("#nomor_surat").val();
        var tgl_surat = $("#tgl_surat").val();
        var perihal_pesan = $("#perihal_pesan").val();
        var isi_pesan = $("#isi_pesan").val();

        var action = $("#action").val();

        if(!action  || !id_pelanggan || !nomor_surat || !tgl_surat || !perihal_pesan){
            var response = JSON.parse('<?php echo alert('kosong'); ?>');
            swalAlert(response);
        }
        else if(!moment(tgl_surat).isValid()){
            var response = JSON.parse('<?php echo alert('format_tgl_salah'); ?>');
            swalAlert(response);
        }
        else{
            $("#simpan").attr({"data-kt-indicator": "on", 'disabled': true});

            jQuery(this).ajaxSubmit({
                dataType: 'json',
                success:  function(data){
                    $("#simpan").removeAttr('disabled data-kt-indicator');

                    if(data.sts == 1){
                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        response.callback_yes = after_save;
                        swalAlert(response);
                    }
                    else{
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }
            });
        }
    });
    function after_save(){
        history.back();
    }
</script>
</body>
<!-- end::Body -->
</html>
