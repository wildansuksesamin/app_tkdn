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

                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <!--begin::Secondary button-->
                                    <button type="button" class="btn btn-sm btn-light btn-active-light-primary" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Kembali</button>
                                    <!--end::Secondary button-->
                                </div>

                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">

                                <?php $this->view('collecting_document/include/header'); ?>

                                <div class="card card-flush h-lg-100 mb-10">
                                    <div class="card-header align-items-center py-5 gap-2 gap-md-5" data-select2-id="select2-data-124-ftn2">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>
                                                Draft Tanda Sah
                                            </h2>
                                        </div>
                                        <!--end::Card title-->
                                        <div class="card-toolbar">
                                            <?php
                                            if ($konten['opening_meeting']->id_status == 22 or $konten['opening_meeting']->id_status == 23) {
                                            ?>
                                                <button type="button" class="btn btn-sm btn-light-primary hidden" id="kirim_assesor">
                                                    <i class="fa fa-paper-plane fs-4 me-2"></i> Kirim Ke Verifikator
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17" style="padding-top: unset!important;">
                                        <!--begin::Layout-->
                                        <div id="data_zona_daftar_tanda_sah_assesor">
                                            <div class="d-flex flex-column flex-lg-row">
                                                <!--begin::Content-->
                                                <div class="flex-lg-row-fluid me-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-striped gy-5" id="data_daftar_tanda_sah">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th>No</th>
                                                                    <th>File</th>
                                                                    <th class="text-end w-250px pe-3">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                            <tfoot class="vertical-align: top"></tfoot>
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
    <div class="modal fade" id="upload_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <div class="fw-bold fs-4" id="upload_daftar_tandah_sah-nama_file"></div>
                        <div class="text-gray-600" id="upload_daftar_tandah_sah-keterangan"></div>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="notice_ketentuan_upload">
                        <?php $this->view('pelanggan_area/include/notice_ketentuan_upload_file'); ?>
                    </div>
                    <form id="dropzone" class="form" action="#" method="post">
                        <input type="hidden" name="id_opening_meeting" id="upload_daftar_tandah_sah-id_opening_meeting" value="<?php echo $konten['opening_meeting']->id_opening_meeting; ?>">
                        <input type="hidden" name="id_nama_file" id="upload_daftar_tandah_sah-id_nama_file">
                        <input type="hidden" name="token" id="upload_daftar_tandah_sah-token" value="<?php echo genToken('SEND_DATA'); ?>">
                        <input type="hidden" id="upload_daftar_tandah_sah-kolom_tambahan">
                        <!--begin::Input group-->
                        <div class="form-group row">
                            <!--begin::Label-->
                            <label class="col-lg-2 col-form-label text-lg-right">Upload File:</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-10">
                                <!--begin::Dropzone-->
                                <div class="dropzone dropzone-queue mb-2" id="kt_dropzonejs_example_2">
                                    <!--begin::Controls-->
                                    <div class="dropzone-panel mb-lg-0 mb-2">
                                        <a class="dropzone-select btn btn-sm btn-primary me-2">Attach files</a>
                                        <a class="dropzone-upload btn btn-sm btn-light-primary me-2">Upload Semua</a>
                                        <a class="dropzone-remove-all btn btn-sm btn-light-danger">Hapus Semua</a>
                                    </div>
                                    <!--end::Controls-->

                                    <!--begin::Items-->
                                    <div class="dropzone-items wm-200px">
                                        <div class="dropzone-item" style="display:none">
                                            <!--begin::File-->
                                            <div class="dropzone-file">
                                                <div class="dropzone-filename" title="some_image_file_name.jpg">
                                                    <span data-dz-name>some_image_file_name.jpg</span>
                                                    <strong>(<span data-dz-size>340kb</span>)</strong>
                                                </div>

                                                <div class="dropzone-error" data-dz-errormessage></div>
                                            </div>
                                            <!--end::File-->

                                            <!--begin::Progress-->
                                            <div class="dropzone-progress">
                                                <div class="progress">
                                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Progress-->

                                            <!--begin::Toolbar-->
                                            <div class="dropzone-toolbar">
                                                <span class="dropzone-start"><i class="bi bi-play-fill fs-3"></i></span>
                                                <span class="dropzone-cancel" data-dz-remove style="display: none;"><i class="bi bi-x fs-3"></i></span>
                                                <span class="dropzone-delete" data-dz-remove><i class="bi bi-x fs-1"></i></span>
                                            </div>
                                            <!--end::Toolbar-->
                                        </div>
                                    </div>
                                    <!--end::Items-->
                                </div>
                                <!--end::Dropzone-->

                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        <?php
        if ($konten['opening_meeting']->id_status == 22 or $konten['opening_meeting']->id_status == 23) {
        ?>
            // set the dropzone container id
            const id = "#kt_dropzonejs_example_2";
            const dropzone = document.querySelector(id);

            // set the preview element template
            var previewNode = dropzone.querySelector(".dropzone-item");
            previewNode.id = "";
            var previewTemplate = previewNode.parentNode.innerHTML;
            previewNode.parentNode.removeChild(previewNode);

            var myDropzone = new Dropzone(id, { // Make the whole body a dropzone
                url: base_url + "pelanggan_area/panel_internal/upload_daftar_tanda_sah", // Set the url for your upload script location
                parallelUploads: 3,
                maxFiles: 1,
                previewTemplate: previewTemplate,
                // maxFilesize: 1, // Max filesize in MB
                autoQueue: false, // Make sure the files aren't queued until manually added
                previewsContainer: id + " .dropzone-items", // Define the container to display the previews
                clickable: id + " .dropzone-select" // Define the element that should be used as click trigger to select files.
            });

            myDropzone.on("addedfile", function(file) {
                // Hookup the start button
                file.previewElement.querySelector(id + " .dropzone-start").onclick = function() {
                    myDropzone.enqueueFile(file);
                };
                const dropzoneItems = dropzone.querySelectorAll('.dropzone-item');
                dropzoneItems.forEach(dropzoneItem => {
                    dropzoneItem.style.display = '';
                });
                dropzone.querySelector('.dropzone-upload').style.display = "inline-block";
                dropzone.querySelector('.dropzone-remove-all').style.display = "inline-block";

                var rangkai = '';
                var kolom_tambahan = $("#upload_daftar_tandah_sah-kolom_tambahan").val();
                if (kolom_tambahan) {
                    kolom_tambahan = JSON.parse(kolom_tambahan.replace(/'/g, "\""));
                    if (kolom_tambahan.length > 0) {

                        for (var i = 0; i < kolom_tambahan.length; i++) {
                            var input_element = '<input type="text" name="' + kolom_tambahan[i].field + '[]" ' + (kolom_tambahan[i].mandatory ? 'required' : '') + ' class="form-control form-control-solid" style="background:#FFF">';
                            if (kolom_tambahan[i].input_type == 'textarea') {
                                input_element = '<textarea name="' + kolom_tambahan[i].field + '[]" ' + (kolom_tambahan[i].mandatory ? 'required' : '') + ' class="form-control form-control-solid" style="background:#FFF"></textarea>';
                            }

                            rangkai += '<div class="dropzone-tambahan">' +
                                '<label class="' + (kolom_tambahan[i].mandatory ? 'required' : '') + ' fs-6 fw-bold mb-2 mt-3">' + kolom_tambahan[i].label + '</label>' +
                                '<div>' + input_element + '</div>' +
                                '</div>';
                        }
                    }
                }

                file.previewElement.querySelector('.dropzone-error').insertAdjacentHTML('afterend', rangkai);
            });

            // Update the total progress bar
            myDropzone.on("totaluploadprogress", function(progress) {
                const progressBars = dropzone.querySelectorAll('.progress-bar');
                progressBars.forEach(progressBar => {
                    progressBar.style.width = progress + "%";
                });
            });

            myDropzone.on("sending", function(file, xhr, formData) {
                console.log(file);
                console.log(file.previewElement);
                var id_opening_meeting = $("#upload_daftar_tandah_sah-id_opening_meeting").val();
                var id_nama_file = $("#upload_daftar_tandah_sah-id_nama_file").val();
                var token = $("#upload_daftar_tandah_sah-token").val();

                formData.append("id_opening_meeting", id_opening_meeting);
                formData.append("id_nama_file", id_nama_file);
                formData.append("token", token);

                var kolom_tambahan = $("#upload_daftar_tandah_sah-kolom_tambahan").val();
                if (kolom_tambahan) {
                    kolom_tambahan = JSON.parse(kolom_tambahan.replace(/'/g, "\""));
                    if (kolom_tambahan.length > 0) {

                        var inputs = $(file.previewElement).find('input[type="text"], textarea');
                        var inputObject = [];
                        var i = 0;
                        inputs.each(function(inputIndex, inputElement) {
                            var object = {
                                'field': kolom_tambahan[i].field,
                                'label': kolom_tambahan[i].label,
                                'value': $(inputElement).val(),
                            }
                            inputObject.push(object);
                            i++;
                        });
                        formData.append("kolom_tambahan", JSON.stringify(inputObject));

                    }
                }

                // Show the total progress bar when upload starts
                const progressBars = dropzone.querySelectorAll('.progress-bar');
                progressBars.forEach(progressBar => {
                    progressBar.style.opacity = "1";
                });
                // And disable the start button
                file.previewElement.querySelector(id + " .dropzone-start").setAttribute("disabled", "disabled");
            });

            // Hide the total progress bar when nothing's uploading anymore
            myDropzone.on("complete", function(progress) {
                const progressBars = dropzone.querySelectorAll('.dz-complete');

                setTimeout(function() {
                    progressBars.forEach(progressBar => {
                        progressBar.querySelector('.progress-bar').style.opacity = "0";
                        progressBar.querySelector('.progress').style.opacity = "0";
                        progressBar.querySelector('.dropzone-start').style.opacity = "0";
                    });
                }, 300);
            });

            // Setup the buttons for all transfers
            dropzone.querySelector(".dropzone-upload").addEventListener('click', function() {
                var allow = true;
                var inputs = $('.dropzone-item').find('input[type="text"], textarea');
                var inputObject = [];
                var i = 0;
                inputs.each(function(inputIndex, inputElement) {
                    var value = $(inputElement).val();
                    var required = $(inputElement).attr('required');

                    if (required == 'required' && value == '') {
                        allow = false;
                    }
                });

                if (allow) {
                    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
                } else {
                    var response = JSON.parse('<?php echo alert('kosong'); ?>');
                    swalAlert(response);

                }
            });

            // Setup the button for remove all files
            dropzone.querySelector(".dropzone-remove-all").addEventListener('click', function() {
                clear_all_list();
            });

            function clear_all_list() {
                dropzone.querySelector('.dropzone-upload').style.display = "none";
                dropzone.querySelector('.dropzone-remove-all').style.display = "none";
                myDropzone.removeAllFiles(true);
            }

            // On all files completed upload
            myDropzone.on("queuecomplete", function(progress) {
                const uploadIcons = dropzone.querySelectorAll('.dropzone-upload');
                uploadIcons.forEach(uploadIcon => {
                    uploadIcon.style.display = "none";
                });

                load_data();
            });

            // On all files removed
            myDropzone.on("removedfile", function(file) {
                if (myDropzone.files.length < 1) {
                    dropzone.querySelector('.dropzone-upload').style.display = "none";
                    dropzone.querySelector('.dropzone-remove-all').style.display = "none";
                }
            });

            myDropzone.on("success", function(file, result, xhr) {
                var errorNode = document.createElement("div");

                result = safelyParseJSON(result);

                var message = '';
                if (result.sts == true) {
                    var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                    toastrAlert(response);
                    clear_all_list();
                } else if (result.sts == 'upload_error') {
                    errorNode.className = "dz-error-message";
                    var response = JSON.parse('<?php echo alert('upload_error'); ?>');
                    message = response.message.replace('{{upload_error_msg}}', result.msg);

                } else if (result.sts == 'mencapai_batas_upload') {
                    errorNode.className = "dz-error-message";
                    var response = JSON.parse('<?php echo alert('mencapai_batas_upload'); ?>');
                    message = response.message;

                } else if (result.sts == 'tidak_berhak_akses_data') {
                    errorNode.className = "dz-error-message";
                    var response = JSON.parse('<?php echo alert('tidak_berhak_akses_data'); ?>');
                    message = response.message;

                } else {
                    errorNode.className = "dz-error-message";
                    var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                    message = response.message;
                }
                $(file.previewElement).find('.dropzone-error').html(message);
            });

            function upload_daftar_tanda_sah() {
                clear_all_list();
                <?php
                $kolom_tambahan = $konten['ketentuan_file']->kolom_tambahan;
                $konten['ketentuan_file']->kolom_tambahan = null;

                echo 'var data = safelyParseJSON(\'' . json_encode($konten['ketentuan_file']) . '\');';
                ?>

                $("#upload_daftar_tandah_sah-id_nama_file").val(data.id_nama_file);

                $("#upload_daftar_tandah_sah-nama_file").html(data.nama_file);
                $("#upload_daftar_tandah_sah-keterangan").html(data.keterangan);
                $("#upload_daftar_tandah_sah-kolom_tambahan").val("<?php echo $kolom_tambahan; ?>");

                //jumlah file yang boleh di upload...
                if (data.multi_file == 1) {
                    //jumlah per sekali upload.. 
                    //jika ingin lebih, maka submit dulu kloter pertama. lalu upload lagi di kloter kedua dan selanjutnya...
                    myDropzone.options.maxFiles = 10;
                } else {
                    myDropzone.options.maxFiles = 1;
                }

                //mengganti tipe file yang diperbolehkan...
                var acceptedFiles = '*';
                var rangkai_acceptedFiles = '';
                if (data.jns_file) {
                    // Pisahkan string jns_file menjadi array
                    var exts = data.jns_file.split('|');

                    // Buat array baru yang berisi MIME type dari ekstensi file yang diberikan
                    var mimes = exts.map(function(ext) {
                        rangkai_acceptedFiles += ext + ', ';
                        return mimeTypes[ext];
                    });

                    // Gabungkan array mimes menjadi string dengan dipisahkan oleh koma
                    var acceptedFiles = mimes.join(',');
                }
                // myDropzone.options.acceptedFiles = acceptedFiles;

                rangkai_acceptedFiles = rangkai_acceptedFiles.slice(0, -2)
                if (rangkai_acceptedFiles == '*') {
                    $("#notice_ketentuan_upload").hide();
                } else {
                    $("#notice_ketentuan_upload").show();
                    $("#ketentuan_file").html(rangkai_acceptedFiles);
                }

                setTimeout(function() {
                    $("#upload_modal").modal('show');
                }, 201);
            }
        <?php } ?>

        var ajax_request;

        function load_data() {
            preloader('show');
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['id_opening_meeting'] = '<?php echo $konten['opening_meeting']->id_opening_meeting; ?>';

            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/panel_internal/load_daftar_tanda_sah/pelanggan',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    preloader('hide');
                    var list_data = result.result;

                    var rangkai = '<tr>' +
                        '<td class="text-center">2.</td>' +
                        '<td><a href="#" class="text-gray-800 text-hover-primary fw-bold" style="font-size: 14px;">Draft Tanda sah yang disetujui</a></td>' +
                        '<td class="text-end pe-3">' +
                        '<?php
                            if ($konten['opening_meeting']->id_status == 22 or $konten['opening_meeting']->id_status == 23) {
                            ?>' +
                        '<button type="button" class="btn btn-sm btn-light-primary me-2" onclick="upload_daftar_tanda_sah()">' +
                        '<i class="fa fa-square-plus fs-4 me-2"></i> Upload Dokumen' +
                        '</button>' +
                        '<?php } ?>' +
                        '</td>' +
                        '</tr>';
                    if (list_data.length > 0) {
                        for (var i = 0; i < list_data.length; i++) {
                            var data_file = '<a href="' + base_url + list_data[i].path_file + '" download class="text-gray-800 text-hover-primary fw-bold">' + list_data[i].value.replace(/_/g, ' ') + '</a>';
                            if (list_data[i].jns_file == 'textarea') {
                                data_file = '<div class="text-gray-800 fw-bold">' + list_data[i].value + '</div>';
                            }
                            var kolom_tambahan = '';
                            if (list_data[i].kolom_tambahan) {
                                var list_tambahan = safelyParseJSON(list_data[i].kolom_tambahan);
                                if (list_tambahan.length > 0) {
                                    kolom_tambahan = '<div class="row">';
                                    for (var a = 0; a < list_tambahan.length; a++) {
                                        kolom_tambahan += '<div class="col-sm-6 mb-3"><div class="text-gray-600 fs-7">' + list_tambahan[a].label + '</div><div>' + coverMe(list_tambahan[a].value) + '</div></div>';
                                    }
                                    kolom_tambahan += '</div>';
                                }
                            }

                            var verifikasi = '';
                            if (list_data[i].status_verifikasi == 1) {
                                verifikasi = render_badge('light-success py-3 px-4 fs-7', 'Dokumen Disetujui');
                            } else if (list_data[i].status_verifikasi == 0) {
                                verifikasi = render_badge('light-danger py-3 px-4 fs-7', 'Dokumen Ditolak');
                                verifikasi += '<div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-2 mt-4">' +
                                    '<?php echo getSvgIcon('general/gen034', 'svg-icon svg-icon-2tx svg-icon-danger me-4') ?>' +
                                    '<div class="d-flex flex-stack flex-grow-1">' +
                                    '<div class="fw-semibold">' +
                                    '<div class="fs-6 text-gray-700">' + list_data[i].alasan_verifikasi_dokumen + '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                            } else {
                                verifikasi = render_badge('light-primary py-3 px-4 fs-7', 'Menunggu Verifikasi');
                            }

                            var btn_hapus = '';
                            if (list_data[i].id_status == 22 || list_data[i].id_status == 23) {
                                btn_hapus = '<button type="button" class="btn btn-sm me-3 btn-light-danger" onClick="hapus_file(' + data.id_opening_meeting + ', ' + list_data[i].id_panel_internal_dokumen + ', \'' + list_data[i].value + '\')"><i class="fa fa-times"></i> Hapus</button>';
                            }
                            rangkai += '<tr>' +
                                '<td class="text-center">2.' + (i + 1) + '.</td>' +
                                '<td>' +
                                data_file +
                                kolom_tambahan +
                                '<div class="mt-3">' + verifikasi + '</div>' +
                                '</td>' +
                                '<td class="text-end pe-3">' +
                                '<a href="' + base_url + list_data[i].path_file + '" download class="btn btn-sm btn-light-primary me-3"><i class="fa fa-download"></i> Download</a>' +
                                btn_hapus +
                                '</td>' +
                                '</tr>';
                        }

                        $("#kirim_assesor").show();
                    } else {
                        rangkai += '<tr id="empty_state">' +
                            '<td colspan="3">' +
                            '<div style="text-align: center"><img src="' + base_url + 'assets/images/empty.png" width="200px">' +
                            '<h5>Belum ada dokumen tersedia</h5></div>'
                        '</td>' +
                        '</tr>';
                        $("#kirim_assesor").hide();
                    }
                    $("#data_daftar_tanda_sah tfoot").html(rangkai);
                }
            });
        }

        $("#kirim_assesor").click(function() {
            var pertanyaan = 'Apakah Anda yakin ingin mengirimkan semua dokumen ke verifikator?';
            konfirmasi(pertanyaan, function() {
                kirim_assesor();
            });
        });

        function kirim_assesor() {
            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_opening_meeting'] = '<?php echo $konten['opening_meeting']->id_opening_meeting; ?>';;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/panel_internal/kirim_assesor',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    preloader('hide');

                    if (data.sts == 1) {
                        //load data..
                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        response.callback_yes = after_save;
                        swalAlert(response);
                    } else if (data.sts == 'dokumen_belum_lengkap') {
                        var response = JSON.parse('<?php echo alert('dokumen_belum_lengkap'); ?>');
                        swalAlert(response);

                    } else if (data.sts == 'tidak_berhak_ubah_data') {
                        var response = JSON.parse('<?php echo alert('tidak_berhak_ubah_data'); ?>');
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

        function hapus_file(id_opening_meeting, id_panel_internal_dokumen, value) {
            var pertanyaan = 'Apakah Anda yakin ingin menghapus file <b>' + value + '</b>?';

            konfirmasi(pertanyaan, function() {
                proses_hapus_file(id_opening_meeting, id_panel_internal_dokumen);
            });
        }

        function proses_hapus_file(id_opening_meeting, id_panel_internal_dokumen) {
            //show loading animation...
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;
            data['id_panel_internal_dokumen'] = id_panel_internal_dokumen;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/panel_internal/hapus_file',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    preloader('hide');

                    if (data.sts == 1) {
                        //load data..
                        load_data('modal_upload');
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

        function load_data_assesor() {
            preloader('show');
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['id_opening_meeting'] = '<?php echo $konten['opening_meeting']->id_opening_meeting; ?>';

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/panel_internal/load_daftar_tanda_sah/assesor',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    load_data();
                    preloader('hide');
                    var list_data = result.result;

                    var rangkai = '';
                    if (list_data.length > 0) {
                        for (var i = 0; i < list_data.length; i++) {
                            var data_file = '<a href="' + base_url + list_data[i].path_file + '" download class="text-gray-800 text-hover-primary fw-bold">Draft Tanda Sah Verifikator</a>';
                            data_file += '<div class="text-gray-600 fs-7">' + list_data[i].value + '</div>';

                            if (list_data[i].jns_file == 'textarea') {
                                data_file = '<div class="text-gray-800 fw-bold">' + list_data[i].value + '</div>';
                            }

                            data_file += '<div class="alert alert-primary d-flex align-items-center border-dashed border-primary p-5 mt-5">' +
                                '<?php echo getSvgIcon('general/gen045', 'svg-icon svg-icon-2tx svg-icon-primary me-4'); ?>' +
                                '<div class="d-flex flex-column">' +
                                '<h4 class="mb-1 text-primary">Informasi</h4>' +
                                '<span>Apabila ada perubahan mohon menghubungi verifikator</span>' +
                                '</div>' +
                                '</div>';

                            rangkai += '<tr>' +
                                '<td class="text-center">' + (i + 1) + '.</td>' +
                                '<td>' +
                                data_file +
                                '</td>' +
                                '<td class="text-end w-250px pe-3">' +
                                '<a href="' + base_url + list_data[i].path_file + '" download class="btn btn-sm btn-light-primary"><i class="fa fa-download"></i> Download</a>' +
                                '</td>' +
                                '</tr>';
                        }
                    }

                    $("#data_daftar_tanda_sah tbody").html(rangkai);
                }

            });
        }
        load_data_assesor();
    </script>
</body>
<!-- end::Body -->

</html>