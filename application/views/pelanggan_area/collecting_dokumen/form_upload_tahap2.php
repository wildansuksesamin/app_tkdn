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
            <?php $this->view('pelanggan_area/include/top_navbar'); ?>
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <?php $this->view('pelanggan_area/include/left_side_navbar'); ?>
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
                                <?php
                                if ($konten['opening_meeting']->id_status == 16) {
                                ?>
                                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                                        <button type="button" class="btn btn-sm fw-bold btn-primary tabel_zone" onclick="form_action('show')">
                                            <i class="fa fa-square-plus fs-1 me-2"></i>
                                            Upload Dokumen
                                        </button>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">

                                <?php $this->view('collecting_document/include/header'); ?>

                                <div class="card card-flush form_zone hidden" id="form_collecting_dokumen_tahap2">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>
                                                Form Collecting Dokumen Tahap 2
                                            </h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17">

                                        <?php
                                        $allow_extension = 'PDF, JPG, JPEG, Excel, Word, Rar dan ZIP';
                                        $this->load->view('pelanggan_area/include/notice_ketentuan_upload_file', array('allow_extension' => $allow_extension));
                                        ?>
                                        <!--begin::Layout-->
                                        <div class="d-flex flex-column flex-lg-row">
                                            <!--begin::Content-->
                                            <div class="flex-lg-row-fluid me-0">
                                                <!--begin::Form-->
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_collecting_dokumen_tahap2" action="<?php echo base_url(); ?>pelanggan_area/Collecting_dokumen_tahap2/simpan" autocomplete="off">
                                                    <input type="hidden" id="id_collecting_dokumen_2" name="id_collecting_dokumen_2">
                                                    <input type="hidden" id="id_opening_meeting" name="id_opening_meeting" value="<?php echo $konten['opening_meeting']->id_opening_meeting; ?>">

                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nama File</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_file" name="nama_file" maxlength="200" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">File</label>
                                                            <input type="file" class="form-control form-control-solid" autocomplete="off" id="path_file" name="path_file" maxlength="200" placeholder="" required accept=".pdf, .jpg, .jpeg, .xls, .xlsx, .doc, docx, .zip, .rar">
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

                                <div class="card card-flush h-lg-100 tabel_zone" id="tabel_collecting_dokumen_tahap2">
                                    <div class="card-header align-items-center py-5 gap-2 gap-md-5" data-select2-id="select2-data-124-ftn2">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>
                                                Data Dokumen Tahap 2
                                            </h2>
                                        </div>
                                        <!--end::Card title-->

                                    </div>

                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17" style="padding-top: unset!important;">
                                        <!--begin::Layout-->
                                        <div id="data_zona_collecting_dokumen_tahap2">
                                            <div class="d-flex flex-column flex-lg-row">
                                                <!--begin::Content-->
                                                <div class="flex-lg-row-fluid me-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-striped gy-5" id="data_collecting_dokumen_tahap2">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th>No</th>
                                                                    <th>File</th>
                                                                    <th style="max-width: 250px;">Status</th>
                                                                    <th style="width: 250px;">Action</th>
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
        function form_action(action) {
            //reset form...
            $("#input_form_collecting_dokumen_tahap2")[0].reset();
            $("#action").val('save');

            if (action == 'show') {
                $(".form_zone").fadeIn(300);
                $(".tabel_zone").hide();
            } else {
                $(".form_zone").hide();
                $(".tabel_zone").fadeIn(300);
            }
        }

        var list_data;
        $("#input_form_collecting_dokumen_tahap2").on('submit', function(e) {
            e.preventDefault();

            var id_opening_meeting = $("#id_opening_meeting").val();
            var nama_file = $("#nama_file").val();
            var path_file = $("#path_file").val();

            if (!id_opening_meeting || !nama_file || !path_file) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else {
                $("#simpan").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });

                jQuery(this).ajaxSubmit({
                    dataType: 'json',
                    success: function(data) {
                        $("#simpan").removeAttr('disabled data-kt-indicator');

                        if (data.sts == 1) {
                            //hapus seluruh field...
                            $("#last_page_status").val('false');
                            $("#page").val(1);

                            $("#input_form_collecting_dokumen_tahap2")[0].reset();
                            $("#action").val('save');
                            form_action('hide');
                            //load data..
                            load_data();
                            var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                            toastrAlert(response);
                        } else if (data.sts == 'upload_gagal') {
                            var response = JSON.parse('<?php echo alert('upload_error'); ?>');
                            response.message = response.message.replace('{{upload_error_msg}}', data.msg);
                            toastrAlert(response);
                        } else if (data.sts == 'tidak_berhak') {
                            var response = JSON.parse('<?php echo alert('tidak_berhak_ubah_data'); ?>');
                            swalAlert(response);
                            form_action('hide');

                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }
                });
            }
        });

        function hapus(index) {
            var data = list_data[index];
            var pertanyaan = "Apakah Anda yakin ingin mengahapus file <strong>" + data.nama_file + "</strong>?";

            konfirmasi(pertanyaan, function() {
                proses_hapus(data.id_collecting_dokumen_2);
            });
        }

        function proses_hapus(id) {
            //show loading animation...
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_collecting_dokumen_2'] = id;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/Collecting_dokumen_tahap2/hapus',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    //hide loading animation...
                    preloader('hide');

                    if (data.sts == 1) {
                        //load data..
                        load_data();
                        var response = JSON.parse('<?php echo alert('hapus_berhasil'); ?>');
                        toastrAlert(response);
                    } else if (data.sts == 'tidak_berhak') {
                        var response = JSON.parse('<?php echo alert('tidak_berhak_hapus_data'); ?>');
                        toastrAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }

            });
        }

        var ajax_request;

        function load_data() {
            preloader('show');
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['id_opening_meeting'] = $("#id_opening_meeting").val();

            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/Collecting_dokumen_tahap2/load_data',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    preloader('hide');
                    list_data = result.result;

                    var rangkai = '';
                    if (list_data.length > 0) {
                        for (var i = 0; i < list_data.length; i++) {
                            var status_verifikasi = '';
                            if (list_data[i].status_verifikasi == 2) {
                                status_verifikasi = render_badge('info', 'Sedang Diverifikasi');
                            } else if (list_data[i].status_verifikasi == 1) {
                                status_verifikasi = render_badge('success', 'Disetujui');
                            } else {
                                status_verifikasi = render_badge('danger', 'Ditolak');
                                status_verifikasi += '<div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-3 mt-3 w-250px">' +
                                    '<div class="d-flex flex-stack flex-grow-1">' +
                                    '<div class="fw-semibold">' +
                                    '<div class="fs-6 text-gray-700">' + list_data[i].alasan_verifikasi_cd2 + '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                            }
                            rangkai += '<tr>' +
                                '<td>' + (i + 1) + '.</td>' +
                                '<td><a href="' + base_url + list_data[i].path_file + '" download class="text-link fw-bold">' + coverMe(list_data[i].nama_file) + '</a></td>' +
                                '<td>' + status_verifikasi + '</td>' +

                                '<td>' +
                                '<a href="' + base_url + list_data[i].path_file + '" download class="btn btn-sm btn-light-primary"><i class="fa fa-download"></i> Download</a>' +
                                (list_data[i].status_verifikasi != 1 ? '<button type="button" class="btn btn-sm btn-light-danger" onClick="hapus(' + i + ')" title="<?php _lang('hapus'); ?>"><i class="fa fa-trash"></i> Hapus</button>' : '') +
                                '</td>' +
                                '</tr>';
                        }
                    }

                    if (rangkai) {
                        $("#empty_state").remove();
                        $("#data_zona_collecting_dokumen_tahap2").show();

                        $("#data_collecting_dokumen_tahap2 tbody").html(rangkai);
                    } else {
                        create_empty_state("#data_zona_collecting_dokumen_tahap2");
                    }

                }

            });
        }
        load_data();
    </script>
</body>
<!-- end::Body -->

</html>