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
                                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Pengguna</h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <button type="button" class="btn btn-sm fw-bold btn-primary tabel_zone" onclick="form_action('show')"><i class="fa fa-square-plus fs-1 me-2"></i> Tambah Pengguna</button>
                                </div>
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <div class="card card-flush form_zone hidden" id="form_administrator">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>Form Pengguna</h2>
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
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_administrator" action="<?php echo base_url(); ?>administrator/simpan" autocomplete="off">
                                                    <input type="hidden" id="id_admin" name="id_admin">

                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <div>
                                                                <label class="fs-5 fw-semibold mb-2">Foto</label>
                                                            </div>
                                                            <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true" style="background-image: url('<?php echo base_url() . $no_avatar_url; ?>')">
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
                                                            <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true" style="background-image: url('<?php echo base_url() . $no_photo_url; ?>'); background-position: center center;">
                                                                <!--begin::Preview existing avatar-->
                                                                <div class="image-input-wrapper w-125px h-125px ttd_admin_display_img" style="background-image: none; background-size: contain;"></div>
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
                                                    <div class="row mb-5" id="password_area">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Password</label>
                                                            <input type="password" class="form-control form-control-solid" autocomplete="off" id="password" name="password" required>
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Ulangi Password</label>
                                                            <input type="password" class="form-control form-control-solid" autocomplete="off" id="password_ulang" name="password_ulang" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Jabatan</label>
                                                            <select class="form-select form-select-solid" data-control="select2" id="tipe_admin" name="tipe_admin" required>
                                                                <?php
                                                                $jns_admin = $konten['jns_admin'];
                                                                if ($jns_admin->num_rows() > 0) {
                                                                    foreach ($jns_admin->result() as $data_jns_admin) {
                                                                        echo '<option value="' . $data_jns_admin->id_jns_admin . '">' . $data_jns_admin->jns_admin . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class=" fs-5 fw-semibold mb-2">Status Pegawai</label>
                                                            <select class="form-select form-select-solid" data-control="select2" id="jns_sppd" name="jns_sppd">
                                                                <option value="PTT Reguler">PTT Reguler</option>
                                                                <option value="PTT Project">PTT Project</option>
                                                                <option value="PT">PT</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">ETC</label>
                                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="checkbox" value="1" id="etc" name="etc" onchange="checkSwitchETC()" />
                                                                <label class="form-check-label" for="etc">
                                                                    Saya tidak ingin menjadikan ETC.
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Status Pengguna</label>

                                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="checkbox" value="A" id="status_admin" name="status_admin" onchange="checkSwitchStatusAdmin()" />
                                                                <label class="form-check-label" for="status_admin">
                                                                    Saya tidak menonaktifkan pengguna ini.
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="separator mb-10 mt-10"></div>
                                                    <button type="submit" class="btn btn-primary" id="simpan">
                                                        <i class="fa-solid fa-floppy-disk me-2 fs-3"></i>
                                                        <?php _lang('simpan'); ?>
                                                    </button>

                                                    <button class="btn btn-light btn-active-light-primary me-2" type="button" onclick="form_action('hide')">
                                                        <i class="fa-solid fa-times me-2 fs-3"></i>
                                                        <?php _lang('batal'); ?>
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

                                <div class="card card-flush h-lg-100 tabel_zone" id="tabel_administrator">

                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17">
                                        <!--begin::Layout-->
                                        <div class="d-flex flex-column flex-lg-row">
                                            <!--begin::Content-->
                                            <div class="flex-lg-row-fluid me-0">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-striped gy-5" id="data_administrator">
                                                        <thead>
                                                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                <th>No.</th>
                                                                <th>Nama Pengguna</th>
                                                                <th>Username</th>
                                                                <th>Email</th>
                                                                <th>ETC</th>
                                                                <th>Status</th>
                                                                <th class="text-end w-100px pe-3">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
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
        function checkSwitchETC() {
            //check checkbox #etc has selected or not
            if ($("#etc").is(":checked")) {
                $('[for="etc"]').html('Ya, saya ingin menjadikan ETC.');
            } else {
                $('[for="etc"]').html('Saya tidak ingin menjadikan ETC.');
            }
        }

        function checkSwitchStatusAdmin() {
            if ($("#status_admin").is(":checked")) {
                $('[for="status_admin"]').html('Saya ingin mengaktifkan pengguna ini.');
            } else {
                $('[for="status_admin"]').html('Saya tidak menonaktifkan pengguna ini.');
            }
        }

        function form_action(action) {
            //reset form...
            $("#input_form_administrator")[0].reset();
            $("#username, #tipe_admin, [name='status_admin']").removeAttr('disabled');
            $("#hapus_foto_admin, #hapus_ttd_admin").click();
            $("#foto_admin_blob, #ttd_admin_blob").val('');
            $("#tipe_admin, #jns_sppd").val('').trigger('change');
            $("#password_area").show();
            if (action == 'show') {
                $(".form_zone").fadeIn(300);
                $(".tabel_zone").hide();
            } else {
                $(".form_zone").hide();
                $(".tabel_zone").fadeIn(300);
            }
        }

        var list_data;
        $("#input_form_administrator").on('submit', function(e) {
            e.preventDefault();
            var id_admin = $("#id_admin").val();
            var nama_lengkap = $("#nama_lengkap").val();
            var email_admin = $("#email_admin").val();
            var telepon_admin = $("#telepon_admin").val();
            var username = $("#username").val();
            var password = $("#password").val();
            var password_ulang = $("#password_ulang").val();
            var tipe_admin = $("#tipe_admin").val();
            var foto_admin = $("#foto_admin_blob").val();
            var status_admin = $('input[name=status_admin]:checked').val();
            var action = $("#action").val();

            if (nama_lengkap == '' || email_admin == '' || telepon_admin == '' || username == '' || password == '' || password_ulang == '' || tipe_admin == '' || status_admin == '') {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else if (password != password_ulang) {
                var response = JSON.parse('<?php echo alert('password_tidak_sama'); ?>');
                swalAlert(response);
            } else {
                var blockUI = generate_blockUI("#kt_app_body");
                preloader('show');

                jQuery(this).ajaxSubmit({
                    dataType: 'json',
                    success: function(data) {
                        preloader('hide');

                        if (data.sts == 1) {
                            //load data..
                            load_data();

                            $("#input_form_administrator")[0].reset();
                            $("#action").val('save');
                            var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                            toastrAlert(response);

                            form_action('hide');
                        } else if (data.sts == 'username_available') {
                            var response = JSON.parse('<?php echo alert('username_available'); ?>');
                            swalAlert(response);
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }

                    }
                });
            }

        });

        function edit(index) {
            form_action('show');
            var data = list_data[index];
            $("#id_admin").val(data.id_admin);
            $("#nama_lengkap").val(data.nama_admin);
            $("#email_admin").val(data.email_admin);
            $("#telepon_admin").val(data.telepon_admin);
            $("#username").val(data.username_admin);

            $("#tipe_admin").val(data.id_jns_admin).trigger('change');

            if (data.etc == 1) {
                $("#etc").prop("checked", true);
            } else {
                $("#etc").prop("checked", false);
            }

            if (data.status_admin == 'A') {
                $("#status_admin").prop("checked", true);
            } else {
                $("#status_admin").prop("checked", false);
            }

            if (data.jns_sppd) {
                $("#jns_sppd").val(data.jns_sppd).trigger('change');
            }

            $("#action").val('update');

            var img_url = '<?php echo base_url(); ?>' + data.foto_admin;
            $(".foto_admin_display_img").css('background-image', 'url(' + img_url + ')');

            var img_url = '<?php echo base_url(); ?>' + data.ttd_admin;
            $(".ttd_admin_display_img").css('background-image', 'url(' + img_url + ')');

            //hidden password...
            $("#password_area").hide();
            //manipulasi password textbox agar tidak dianggap kosong..
            //value yang dipasang di textbox tidak akan digunakan untuk update password..
            $("#password").val('x');
            $("#password_ulang").val('x');

            //set fokus pada jenis admin...
            $("#nama_lengkap").focus();

            if (data.id_admin == 1) {
                $("#username, #tipe_admin, [name='status_admin']").attr('disabled', 'disabled');
            }
        }

        function hapus(index) {
            var data = list_data[index];
            var pertanyaan = "Apakah Anda yakin ingin menghapus pengguna " + data.nama_admin + "?";

            konfirmasi(pertanyaan, function() {
                proses_hapus(data.id_admin);
            });
        }

        function proses_hapus(id) {
            var blockUI = generate_blockUI("#kt_app_body");
            blockUI.block();

            $("#pertanyaan").modal('hide');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_admin'] = id;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>administrator/hapus',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    blockUI.release();
                    blockUI.destroy();

                    if (data.sts == 1) {
                        //load data..
                        load_data();
                        var response = JSON.parse('<?php echo alert('hapus_berhasil'); ?>');
                        toastrAlert(response);
                    } else if (data.sts == 'tidak_berhak') {
                        var response = JSON.parse('<?php echo alert('tidak_berhak_hapus_data'); ?>');
                        swalAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }


                }

            });
        }

        function reset_pwd(index) {
            var data = list_data[index];
            var pertanyaan = "<?php _lang('konfirmasi_reset_password'); ?>";

            konfirmasi(pertanyaan, function() {
                proses_reset(data.id_admin, data.username_admin);
            });

        }

        function proses_reset(id, username) {
            var blockUI = generate_blockUI("#kt_app_body");
            blockUI.block();

            $("#pertanyaan").modal('hide');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_admin'] = id;
            data['username'] = username;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>administrator/reset_password',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    blockUI.release();
                    blockUI.destroy();

                    if (data.sts == 1) {
                        //load data..
                        load_data();
                        var response = JSON.parse('<?php echo alert('reset_password_berhasil'); ?>');
                        toastrAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }


                }

            });
        }

        function load_data() {
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';

            var blockUI = generate_blockUI("#data_administrator");
            blockUI.block();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>administrator/load_data',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(response) {
                    list_data = response;
                    blockUI.release();
                    blockUI.destroy();

                    var rangkai = '';
                    if (list_data.length > 0) {
                        for (var i = 0; i < list_data.length; i++) {

                            var hapus = '<a class="dropdown-item" href="#" onclick="hapus(' + i + ')"><?php _lang('hapus'); ?></a>';
                            if (list_data[i].id_admin == 1)
                                hapus = '';

                            var btn_action = '<div class="dropdown">' +
                                '<button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-boundary="viewport" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                'Actions' +
                                '</button>' +
                                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
                                '<a class="dropdown-item" href="#" onclick="reset_pwd(' + i + ')">Reset Password</a>' +
                                '<a class="dropdown-item" href="#" onclick="edit(' + i + ')"><?php _lang('edit'); ?></a>' +
                                hapus +
                                '</div>' +
                                '</div>';

                            if (list_data[i].status_admin == 'A')
                                var status = render_badge('light-success', '<?php _lang('aktif'); ?>');
                            else
                                var status = render_badge('light-danger', '<?php _lang('tidak_aktif'); ?>');

                            if (list_data[i].etc == 1)
                                var etc_status = render_badge('light-success', 'Ya');
                            else
                                var etc_status = render_badge('light-dark', 'Tidak');

                            rangkai += '<tr>' +
                                '<td>' + (i + 1) + '.</td>' +
                                '<td>' +
                                '<div class="d-flex align-items-center">' +
                                '<div class="symbol symbol-50px me-3">' +
                                '<img src="<?php echo base_url(); ?>' + list_data[i].foto_admin + '" style="object-fit: cover;" <?php echo $no_avatar_for_js; ?>>' +
                                '</div>' +
                                '<div class="d-flex justify-content-start flex-column">' +
                                '<a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">' + list_data[i].nama_admin + '</a>' +
                                '<span class="text-gray-400 fw-semibold fs-7">' + render_badge('light-primary', list_data[i].jns_admin) + (list_data[i].jns_sppd ? ' ' + render_badge('light-success', list_data[i].jns_sppd) : '') + '</span>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +
                                '<td>' + list_data[i].username_admin + '</td>' +
                                '<td>' + list_data[i].email_admin + '</td>' +
                                '<td>' + etc_status + '</td>' +
                                '<td>' + status + '</td>' +
                                '<td class="text-end w-100px pe-3">' +
                                btn_action +
                                '</td>' +
                                '</tr>';
                        }
                    }

                    if (rangkai) {
                        $("#empty_state").remove();
                        $("#data_administrator").show();
                        $("#data_administrator tbody").html(rangkai);
                    } else {
                        create_empty_state("#data_administrator");
                    }
                }

            });
        }
        load_data();
    </script>
</body>
<!-- end::Body -->

</html>