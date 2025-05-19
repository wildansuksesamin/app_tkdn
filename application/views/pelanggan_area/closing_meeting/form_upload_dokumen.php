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

                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <?php $this->view('collecting_document/include/header'); ?>

                                <div class="card card-flush h-lg-100 tabel_zone" id="tabel_collecting_dokumen">
                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17" style="padding-top: unset!important;">
                                        <!--begin::Layout-->
                                        <div id="data_zona_collecting_dokumen">
                                            <div class="d-flex flex-column flex-lg-row">
                                                <!--begin::Content-->
                                                <div class="flex-lg-row-fluid me-0">
                                                    <div id="notice_ketentuan_upload" class="mt-10">
                                                        <?php $this->view('pelanggan_area/include/notice_ketentuan_upload_file'); ?>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-striped gy-5" id="folder_collecting_dokumen">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th style="width: 30px;">No</th>
                                                                    <th>Nama File</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                        <input type="hidden" name="id_opening_meeting" id="id_opening_meeting" value="<?php echo $konten['opening_meeting']->id_opening_meeting; ?>">
                                                    </div>


                                                    <div class="separator mb-10 mt-10"></div>
                                                    <button type="button" class="btn btn-primary btn-sm" id="kirim"><i class="fa fa-paper-plane me-2"></i> Kirim Ke Verifikator</button>

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
        var id_opening_meeting = '<?php echo $konten['opening_meeting']->id_opening_meeting; ?>';
        var list_data;

        function load_data(from = '') {
            var id_opening_meeting = $("#id_opening_meeting").val();
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;

            preloader('show');

            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/closing_meeting/load_file_closing_meeting',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    preloader('hide');
                    list_data = result;

                    var rangkai = '';
                    if (list_data.length > 0) {
                        list_data.map((item, i) => {
                            var file = '';
                            if (item.dokumen.length > 0) {
                                btn_action = '<a href="' + base_url + item.dokumen[0].path_file + '" target="_blank" class="btn btn-sm btn-primary me-2" download><i class="fa fa-download me-2"></i> Download file</a>';
                                btn_action += '<a href="javascript:;" class="btn btn-sm btn-danger" onclick="hapus_file(' + item.dokumen[0].id_closing_meeting_dokumen + ', \'' + item.nama_file + '\')"><i class="fa fa-trash me-2"></i> Hapus</a>';

                                file += '<div class="fw-bold ' + (item.required && 'required') + '">' + item.nama_file + '</div>';
                                file += '<div class="mt-3">' + btn_action + '</div>';
                            } else {
                                file += '<form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="upload_closing_meeting_' + i + '" action="<?php echo base_url(); ?>pelanggan_area/closing_meeting/simpan" autocomplete="off">';
                                file += '<div class="fw-bold ' + (item.required && 'required') + '">' + item.nama_file + '</div>';
                                file += '<input type="file" name="file" id="file_' + i + '" class="form-control mt-2" ' + (item.required && 'required') + ' />';
                                file += '<input type="hidden" name="id_closing_meeting_nama_file" id="id_closing_meeting_nama_file_' + i + '" value="' + item.id_closing_meeting_nama_file + '" />';
                                file += '<input type="hidden" name="id_opening_meeting" id="id_opening_meeting_' + i + '" class="id_opening_meeting" value="' + id_opening_meeting + '" />';
                                file += '<input type="hidden" name="token" value="<?php echo genToken('SEND_DATA'); ?>" />';
                                file += '<button type="button" class="btn btn-primary btn-sm mt-3" id="upload_' + i + '" onclick="upload_file(' + i + ')">' +
                                    '<span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>' +
                                    '<span class="indicator-progress">Tunggu sebentar...' +
                                    '<span class="spinner-border spinner-border-sm align-middle ms-2"></span>' +
                                    '</span>' +
                                    '</button>';
                                file += '</form>';
                            }


                            rangkai += '<tr>' +
                                '<td>' + (i + 1) + '</td>' +
                                '<td>' +
                                file + '</td>' +
                                '</tr>';
                        });
                    }

                    if (rangkai) {
                        $("#empty_state").remove();
                        $("#folder_collecting_dokumen tbody").html(rangkai);

                        if (from == 'modal_upload') {
                            rangkai_file();
                        }
                    } else {
                        create_empty_state("#folder_collecting_dokumen");
                    }

                }

            });
        }
        load_data();

        function upload_file(i) {
            var id_opening_meeting = $("#id_opening_meeting_" + i).val();
            var file = $("#file_" + i).val();
            var id_closing_meeting_nama_file = $("#id_closing_meeting_nama_file_" + i).val();

            if (!id_opening_meeting || !file || !id_closing_meeting_nama_file) {

                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else {
                $("#upload_" + i).attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });

                jQuery("#upload_closing_meeting_" + i).ajaxSubmit({
                    dataType: 'json',
                    success: function(data) {
                        $("#upload_" + i).removeAttr('disabled data-kt-indicator');

                        if (data.sts == 1) {
                            load_data();

                            var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                            toastrAlert(response);
                        } else if (data.sts == 'upload_error') {
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
        }

        function hapus_file(id_closing_meeting_dokumen, nama_file) {
            var pertanyaan = "Apakah Anda yakin akan menghapus file <b>" + nama_file + "</b>?";

            konfirmasi(pertanyaan, function() {
                proses_hapus_file(id_closing_meeting_dokumen);
            });
        }

        function proses_hapus_file(id_closing_meeting_dokumen) {
            preloader('show');
            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_closing_meeting_dokumen'] = id_closing_meeting_dokumen;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/closing_meeting/hapus',
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
                    } else if (data.sts == 'tidak_berhak_hapus_data') {
                        var response = JSON.parse('<?php echo alert('tidak_berhak_hapus_data'); ?>');
                        swalAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }

            });
        }


        $("#kirim").click(function() {
            var pertanyaan = "Apakah Anda yakin akan mengirimkan dokumen ke verifikator?";

            konfirmasi(pertanyaan, function() {
                goto_nextStep();
            });

        });

        function goto_nextStep() {
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/closing_meeting/goto_next_step',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    //hide loading animation...
                    preloader('hide');

                    if (data.sts == 1) {
                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        response.callback_yes = after_save;
                        swalAlert(response);

                    } else if (data.sts == 'belum_ada_file') {
                        var response = JSON.parse('<?php echo alert('belum_ada_file'); ?>');
                        swalAlert(response);
                    } else if (data.sts == 'tidak_berhak_akses_data') {
                        var response = JSON.parse('<?php echo alert('tidak_berhak_akses_data'); ?>');
                        swalAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }

            });
        }

        function after_save() {
            location.href = base_url + 'pelanggan/riwayat_verifikasi_tkdn';

        }
    </script>
</body>
<!-- end::Body -->

</html>