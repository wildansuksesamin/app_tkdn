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
                                    <div class="card-body p-lg-17">
                                        <!--begin::Layout-->
                                        <div id=" data_zona_collecting_dokumen">
                                            <div class="d-flex flex-column flex-lg-row">
                                                <!--begin::Content-->
                                                <div class="flex-lg-row-fluid me-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-striped gy-5" id="folder_upload_dokumen">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th class="w-30px">No</th>
                                                                    <th>Nama Folder</th>
                                                                    <th class="w-200px">Status</th>
                                                                    <th class="w-150px">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                        <input type="hidden" name="id_opening_meeting" id="id_opening_meeting" value="<?php echo $konten['opening_meeting']->id_opening_meeting; ?>">

                                                        <?php
                                                        if ($konten['btn_siap_lanjut'] === true) {
                                                        ?>
                                                            <button type="button" id="kirim_koordinator" class="btn btn-primary">
                                                                <span class="indicator-label"><i class="fa-solid fa-paper-plane me-2 fs-3"></i> Kirim Ke Koordinator</span>
                                                                <span class="indicator-progress">Loading...
                                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                            </button>

                                                        <?php
                                                        }
                                                        ?>
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

    <div class="modal fade" id="folder_dokumen_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <div class="fw-bold fs-4" id="folder_dokumen-nama_file"></div>
                        <div class="text-gray-600" id="folder_dokumen-keterangan"></div>
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
                        <input type="hidden" name="id_opening_meeting" id="folder_dokumen-id_opening_meeting" value="<?php echo $konten['opening_meeting']->id_opening_meeting; ?>">
                        <input type="hidden" name="id_nama_file" id="folder_dokumen-id_nama_file">
                        <input type="hidden" name="token" id="folder_dokumen-token" value="<?php echo genToken('SEND_DATA'); ?>">
                        <input type="hidden" id="folder_dokumen-kolom_tambahan">
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
                    <div class="separator separator_dropzone mb-5 mt-5"></div>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped gy-5" id="file_collecting_dokumen">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                    <th class="w-20px">No</th>
                                    <th>Data</th>
                                    <th class="w-300px">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <input type="hidden" name="id_opening_meeting" id="id_opening_meeting" value="<?php echo $konten['opening_meeting']->id_opening_meeting; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="folder_lhv_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h2>Folder LHV</h2>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <a href="<?php echo base_url(); ?>page/lhv/<?php echo $konten['opening_meeting']->id_opening_meeting; ?>" id="btn_buat_lhv" class="btn btn-sm btn-primary mb-5"><i class="fa fa-plus"></i> Buat Dokumen LHV</a>
                        <table class="table table-sm table-striped gy-5" id="file_lhv">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                    <th class="w-20px">No</th>
                                    <th>produk</th>
                                    <th class="w-200px">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->view('include/js'); ?>
    <script>
        // set the dropzone container id
        const id = "#kt_dropzonejs_example_2";
        const dropzone = document.querySelector(id);
        var aktor = '<?php echo $konten['aktor']; ?>';

        // set the preview element template
        var previewNode = dropzone.querySelector(".dropzone-item");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone(id, { // Make the whole body a dropzone
            url: base_url + "panel_internal/upload_file", // Set the url for your upload script location
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
            var kolom_tambahan = $("#folder_dokumen-kolom_tambahan").val();
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
            var id_opening_meeting = $("#folder_dokumen-id_opening_meeting").val();
            var id_nama_file = $("#folder_dokumen-id_nama_file").val();
            var token = $("#folder_dokumen-token").val();

            formData.append("id_opening_meeting", id_opening_meeting);
            formData.append("id_nama_file", id_nama_file);
            formData.append("token", token);

            var kolom_tambahan = $("#folder_dokumen-kolom_tambahan").val();
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

            load_data('modal_upload');
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

        function buka_folder_lhv(index) {
            selected_index = index;
            var data = list_data[index];

            rangkai_file_lhv();
            $("#folder_lhv_modal").modal('show');
        }

        function rangkai_file_lhv() {
            $("#empty_state").remove();
            var data = list_data[selected_index];
            var files = data.files;
            var rangkai = '';
            $("#empty_state").remove();
            $("#btn_buat_lhv").show();

            if (files.length > 0) {
                for (var i = 0; i < files.length; i++) {
                    var verifikasi = '';
                    var btn_hapus = '<button type="button" class="btn btn-sm me-3 btn-danger" onClick="hapus_lhv(' + data.id_opening_meeting + ', ' + files[i].id_panel_internal_lhv + ', \'' + files[i].lhv_jns_produk + '\')"><i class="fa fa-times"></i> Hapus</button>';
                    if (files[i].status_verifikasi == 1) {
                        verifikasi = render_badge('light-success py-3 px-4 fs-7', 'Dokumen Disetujui');
                        btn_hapus = '';
                    } else if (files[i].status_verifikasi == 0) {
                        verifikasi = render_badge('light-danger py-3 px-4 fs-7', 'Dokumen Ditolak');
                        verifikasi += '<div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-2 mt-4">' +
                            '<?php echo getSvgIcon('general/gen034', 'svg-icon svg-icon-2tx svg-icon-danger me-4') ?>' +
                            '<div class="d-flex flex-stack flex-grow-1">' +
                            '<div class="fw-semibold">' +
                            '<div class="fs-6 text-gray-700">' + files[i].alasan_verifikasi + '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    } else {
                        verifikasi = render_badge('light-primary py-3 px-4 fs-7', 'Dalam Proses');
                    }
                    var data_file = files[i].lhv_jns_produk;


                    btn_action = '<a href="' + base_url + 'page/lhv/' + data.id_opening_meeting + '?id_lhv=' + files[i].id_panel_internal_lhv + '" class="btn btn-sm me-3 btn-primary"><i class="fa fa-file"></i> Buka</a>' + btn_hapus;
                    rangkai += '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' +
                        data_file +
                        '<div class="mt-2">' + verifikasi + '</div>' +
                        '</td>' +
                        '<td>' +
                        btn_action +
                        '</td>' +
                        '</tr>';
                }

                $("#file_lhv, #btn_buat_lhv").show();
                $("#file_lhv tbody").html(rangkai);
            } else {
                $("#btn_buat_lhv").hide();
                if (data.aktor != aktor) {
                    create_empty_state('#file_lhv');
                } else {
                    create_empty_state('#file_lhv', '<a href="' + base_url + 'page/lhv/' + data.id_opening_meeting + '" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Buat Dokumen LHV</a>');

                }
            }
        }

        function hapus_lhv(id_opening_meeting, id_panel_internal_lhv, lhv_jns_produk) {
            var pertanyaan = 'Apakah Anda yakin ingin menghapus file LHV <b>' + lhv_jns_produk + '</b>?';
            konfirmasi(pertanyaan, function() {
                proses_hapus_lhv(id_opening_meeting, id_panel_internal_lhv);
            });
        }

        function proses_hapus_lhv(id_opening_meeting, id_panel_internal_lhv) {
            //show loading animation...
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;
            data['id_panel_internal_lhv'] = id_panel_internal_lhv;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>panel_internal/hapus_lhv',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    preloader('hide');

                    if (data.sts == 1) {
                        //load data..
                        load_data('modal_lhv');
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

        function buka_folder(index) {
            clear_all_list();
            selected_index = index;
            var data = list_data[index];
            $("#folder_dokumen-id_nama_file").val(data.id_nama_file);

            $("#folder_dokumen-nama_file").html(data.nama_file);
            $("#folder_dokumen-keterangan").html(data.keterangan);
            $("#folder_dokumen-kolom_tambahan").val(data.kolom_tambahan);

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

            rangkai_file();

            if (data.aktor == aktor) {
                $("#dropzone, .separator_dropzone").show();
            } else {
                setTimeout(function() {
                    $("#dropzone, .separator_dropzone, #notice_ketentuan_upload").hide();
                }, 200);
            }

            setTimeout(function() {
                $("#folder_dokumen_modal").modal('show');
            }, 201);
        }

        function rangkai_file() {
            $("#empty_state").remove();
            var data = list_data[selected_index];
            var files = data.files;
            var rangkai = '';
            if (files.length > 0) {
                for (var i = 0; i < files.length; i++) {
                    var verifikasi = '';
                    var btn_hapus = '<button type="button" class="btn btn-sm me-3 btn-danger" onClick="hapus_file(' + data.id_opening_meeting + ', ' + files[i].id_panel_internal_dokumen + ', \'' + files[i].value + '\')"><i class="fa fa-times"></i> Hapus</button>';
                    if (files[i].status_verifikasi == 1) {
                        verifikasi = render_badge('light-success py-3 px-4 fs-7', 'Dokumen Disetujui');
                        btn_hapus = '';
                    } else if (files[i].status_verifikasi == 0) {
                        verifikasi = render_badge('light-danger py-3 px-4 fs-7', 'Dokumen Ditolak');
                        verifikasi += '<div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-2 mt-4">' +
                            '<?php echo getSvgIcon('general/gen034', 'svg-icon svg-icon-2tx svg-icon-danger me-4') ?>' +
                            '<div class="d-flex flex-stack flex-grow-1">' +
                            '<div class="fw-semibold">' +
                            '<div class="fs-6 text-gray-700">' + files[i].alasan_verifikasi + '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    } else {
                        verifikasi = render_badge('light-primary py-3 px-4 fs-7', 'Dalam Proses');
                    }
                    var data_file = '<a href="' + base_url + files[i].path_file + '" download class="text-gray-800 text-hover-primary fw-bold">' + files[i].value.replace(/_/g, ' ') + '</a>';
                    if (files[i].jns_file == 'textarea') {
                        data_file = '<div class="text-gray-800 fw-bold">' + files[i].value + '</div>';
                    }

                    var kolom_tambahan = '';
                    if (files[i].kolom_tambahan) {
                        var list_tambahan = safelyParseJSON(files[i].kolom_tambahan);
                        if (list_tambahan.length > 0) {
                            kolom_tambahan = '<div class="row">';
                            for (var a = 0; a < list_tambahan.length; a++) {
                                kolom_tambahan += '<div class="col-sm-6 mb-3"><div class="text-gray-600 fs-7">' + list_tambahan[a].label + '</div><div>' + coverMe(list_tambahan[a].value) + '</div></div>';
                            }
                            kolom_tambahan += '</div>';
                        }
                    }

                    if (data.aktor != aktor) {
                        btn_hapus = '';
                    }

                    var btn_action = '<a href="' + base_url + files[i].path_file + '" class="btn btn-sm me-3 btn-primary" download><i class="fa fa-download"></i> Download</a>' + btn_hapus;
                    rangkai += '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' +
                        data_file +
                        kolom_tambahan +
                        '<div class="mt-2">' + verifikasi + '</div>' +
                        '</td>' +
                        '<td>' +
                        btn_action +
                        '</td>' +
                        '</tr>';
                }

                $("#file_collecting_dokumen, .separator_dropzone").show();
                $("#file_collecting_dokumen tbody").html(rangkai);
            } else {
                $("#file_collecting_dokumen, .separator_dropzone").hide();
                if (data.aktor != aktor) {
                    create_empty_state('#file_collecting_dokumen');
                }
            }
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
                url: '<?php echo base_url(); ?>panel_internal/hapus_file',
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

        var selected_index;
        var list_data;

        function load_data(from = '') {
            var id_opening_meeting = $("#id_opening_meeting").val();
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;

            preloader('show');

            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>panel_internal/load_folder',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    preloader('hide');
                    list_data = result;

                    var rangkai = '';
                    if (list_data.length > 0) {
                        var id_kriteria_bmp = '';
                        var no = 1;
                        for (var i = 0; i < list_data.length; i++) {
                            var status = render_badge('secondary', 'Folder Kosong');
                            if (list_data[i].dokumen_status.length > 0) {
                                status = render_badge(list_data[i].dokumen_status[1], list_data[i].dokumen_status[0]);
                            }

                            var button = '<button type="button" class="btn btn-sm btn-light-primary" onClick="buka_folder(' + i + ')"><i class="fa fa-folder"></i> Buka Folder</button>';
                            if (list_data[i].referensi == 'lhv') {
                                var button = '<button type="button" class="btn btn-sm btn-light-primary" onClick="buka_folder_lhv(' + i + ')"><i class="fa fa-folder"></i> Buka Folder</button>';
                                // button = '<a href="' + base_url + 'page/lhv/' + list_data[i].id_opening_meeting + '" class="btn btn-sm btn-light-primary"><i class="fa fa-folder"></i> Buka Folder</a>';
                            }

                            rangkai += '<tr>' +
                                '<td>' + no + '.</td>' +
                                '<td>' +
                                '<div class="fw-bold fs-5 ' + (list_data[i].required == 1 ? 'required' : '') + '">' + list_data[i].nama_file + '</div>' +
                                (list_data[i].keterangan ? '<div class="text-gray-600">' + list_data[i].keterangan + '</div>' : '') +
                                '<div class=" mt-3"><span class="badge badge-' + (list_data[i].aktor == 'assesor' ? 'success' : 'secondary') + '"><i class="fa fa-user-circle text-gray-' + (list_data[i].aktor == 'assesor' ? '100' : '700') + ' me-3"></i> ' + list_data[i].aktor + '</span></div>' +
                                '</td>' +
                                '<td>' + status + '</td>' +

                                '<td>' +
                                button +
                                '</td>' +
                                '</tr>';

                            no++;
                        }
                    }

                    if (rangkai) {
                        $("#empty_state").remove();
                        $("#folder_upload_dokumen tbody").html(rangkai);

                        if (from == 'modal_lhv') {
                            rangkai_file_lhv();
                        } else if (from == 'modal_upload') {
                            rangkai_file();
                        }
                    } else {
                        create_empty_state("#folder_upload_dokumen");
                    }

                }

            });
        }
        load_data();

        $("#kirim_koordinator").click(function() {
            var pertanyaan = 'Apakah Anda yakin ingin mengirimkan semua dokumen ke koordinator?';
            konfirmasi(pertanyaan, function() {
                kirim_koordinator();
            });
        });

        function kirim_koordinator() {
            var id_opening_meeting = $("#id_opening_meeting").val();
            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>panel_internal/kirim_koordinator',
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
            location.href = base_url + 'page/upload_dokumen_panel_internal';
        }
    </script>
</body>
<!-- end::Body -->

</html>