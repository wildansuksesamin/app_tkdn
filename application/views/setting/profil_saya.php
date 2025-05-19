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
                                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Profil Saya</h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                        </div>
                    </div>

                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <div id="kt_app_content_container" class="app-container container-fluid">
                            <div class="card card-flush">
                                <!--begin::Body-->
                                <div class="card-body p-lg-17">
                                    <!--begin::Layout-->
                                    <div class="d-flex flex-column flex-lg-row">
                                        <!--begin::Content-->
                                        <div class="flex-lg-row-fluid me-0">
                                            <!--begin::Form-->
                                            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_administrator" action="<?php echo base_url(); ?>administrator/update_profil" autocomplete="off">
                                                <div class="row mb-5">
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <div>
                                                            <label class="fs-5 fw-semibold mb-2">Foto</label>
                                                        </div>
                                                        <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true" style="background-image: url('<?php echo base_url().$no_avatar_url; ?>')">
                                                            <!--begin::Preview existing avatar-->
                                                            <div class="image-input-wrapper w-125px h-125px foto_admin_display_img" style="background-image: none;"></div>
                                                            <!--end::Preview existing avatar-->
                                                            <!--begin::Label-->
                                                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar" data-kt-initialized="1">
                                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                                <!--begin::Inputs-->
                                                                <input type="file" id="foto_admin" name="foto_admin" accept=".png, .jpg, .jpeg" onchange="imageCompressor('#foto_admin')">
                                                                <input type="hidden" id="foto_admin_blob" name="foto_admin_blob">
                                                                <input type="hidden" name="avatar_remove">
                                                                <!--end::Inputs-->
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Cancel-->
                                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar" data-kt-initialized="1">
																	<i class="bi bi-x fs-2"></i>
																</span>
                                                            <!--end::Cancel-->
                                                            <!--begin::Remove-->
                                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" id="hapus_foto_admin" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar" data-kt-initialized="1">
																	<i class="bi bi-x fs-2"></i>
																</span>
                                                            <!--end::Remove-->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <div>
                                                            <label class="fs-5 fw-semibold mb-2">Tanda Tangan</label>
                                                        </div>
                                                        <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true" style="background-image: url('<?php echo base_url().$no_photo_url; ?>'); background-position: center center;">
                                                            <!--begin::Preview existing avatar-->
                                                            <div class="image-input-wrapper w-125px h-125px ttd_admin_display_img" style="background-image: none; background-size: contain"></div>
                                                            <!--end::Preview existing avatar-->
                                                            <!--begin::Label-->
                                                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Ganti tanda tangan" data-kt-initialized="1">
                                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                                <!--begin::Inputs-->
                                                                <input type="file" id="ttd_admin" name="ttd_admin" accept=".png, .jpg, .jpeg" onchange="imageCompressor('#ttd_admin')">
                                                                <input type="hidden" id="ttd_admin_blob" name="ttd_admin_blob">
                                                                <input type="hidden" name="ttd_remove">
                                                                <!--end::Inputs-->
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Cancel-->
                                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar" data-kt-initialized="1">
																	<i class="bi bi-x fs-2"></i>
																</span>
                                                            <!--end::Cancel-->
                                                            <!--begin::Remove-->
                                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" id="hapus_ttd_admin" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar" data-kt-initialized="1">
																	<i class="bi bi-x fs-2"></i>
																</span>
                                                            <!--end::Remove-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-5">
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2">Nama Lengkap</label>
                                                        <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_lengkap" name="nama_lengkap" required>
                                                    </div>

                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2">Nomor Telepon</label>
                                                        <input type="text" class="form-control form-control-solid" autocomplete="off" id="telepon_admin" name="telepon_admin" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-5">
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2">Email</label>
                                                        <input type="text" class="form-control form-control-solid" autocomplete="off" id="email_admin" name="email_admin" required>
                                                    </div>

                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2">Username</label>
                                                        <input type="text" class="form-control form-control-solid" autocomplete="off" id="username" name="username" required>
                                                    </div>
                                                </div>

                                                <div class="separator mb-10 mt-10"></div>
                                                <button type="submit" id="simpan" class="btn btn-primary">
                                                    <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                                    <span class="indicator-progress">Loading...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
    var list_data;
    $("#input_form_administrator").on('submit', function(e){
        e.preventDefault();
        var nama_lengkap = $("#nama_lengkap").val();
        var email_admin = $("#email_admin").val();
        var telepon_admin = $("#telepon_admin").val();
        var username = $("#username").val();
        var password = $("#password").val();
        var password_ulang = $("#password_ulang").val();
        var tipe_admin = $("#tipe_admin").val();
        var foto_admin = $("#foto_admin_blob").val();
        var status_admin = $('input[name=status_admin]:checked').val();

        if(nama_lengkap == '' || email_admin == '' || telepon_admin == '' || username == '' || password == '' || password_ulang == '' || tipe_admin == '' || status_admin == ''){
            var response = JSON.parse('<?php echo alert('kosong'); ?>');
            swalAlert(response);
        }
        else if(password != password_ulang){
            var response = JSON.parse('<?php echo alert('password_tidak_sama'); ?>');
            swalAlert(response);
        }
        else{
            $("#simpan").attr({"data-kt-indicator": "on", 'disabled': true});

            jQuery(this).ajaxSubmit({
                dataType: 'json',
                success:  function(data){
                    $("#simpan").removeAttr('disabled data-kt-indicator');

                    if(data.sts == 1){
                        //load data..
                        load_data();

                        $("#input_form_administrator")[0].reset();
                        $("#action").val('save');
                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        toastrAlert(response);

                        form_action('hide');
                    }
                    else if(data.sts == 'username_available'){
                        var response = JSON.parse('<?php echo alert('username_available'); ?>');
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

    function edit(index){
        var data = list_data[index];
        $("#nama_lengkap").val(data.nama_admin);
        $("#email_admin").val(data.email_admin);
        $("#telepon_admin").val(data.telepon_admin);
        $("#username").val(data.username_admin);
        $("#tipe_admin").val(data.id_jns_admin);
        if(data.status_admin == 'A')
            $("#aktif").prop("checked", true);
        else
            $("#tidak_aktif").prop("checked", true);
        $("#action").val('update');

        var img_url =  '<?php echo base_url(); ?>'+data.foto_admin;
        $(".foto_admin_display_img").css('background-image', 'url('+img_url+')');

        var img_url =  '<?php echo base_url(); ?>'+data.ttd_admin;
        $(".ttd_admin_display_img").css('background-image', 'url('+img_url+')');

        //hidden password...
        $("#password_area").hide();
        //manipulasi password textbox agar tidak dianggap kosong..
        //value yang dipasang di textbox tidak akan digunakan untuk update password..
        $("#password").val('x');
        $("#password_ulang").val('x');

        //set fokus pada jenis admin...
        $("#nama_lengkap").focus();

        if(data.id_admin == 1){
            $("#username, #tipe_admin, [name='status_admin']").attr('disabled', 'disabled');
        }
    }


    function load_data(){
        var data = new Object;
        data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
        data['id_admin'] = '<?php echo $this->session->userdata('id_admin'); ?>';

        preloader('show');
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>administrator/load_data',
            data: 'data_send='+encodeURIComponent(JSON.stringify(data)),
            cache: false,
            dataType: "json",
            success: function(response){
                list_data = response;
                preloader('hide');
                if(list_data.length > 0){
                    edit(0);
                }
            }

        });
    }
    load_data();
</script>
</body>
<!-- end::Body -->
</html>
