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
                                    <div class="card-body p-lg-17" style="padding-top: unset!important;">
                                        <!--begin::Layout-->
                                        <div id="data_zona_collecting_dokumen">
                                            <div class="d-flex flex-column flex-lg-row">
                                                <!--begin::Content-->
                                                <div class="flex-lg-row-fluid me-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-striped gy-5" id="folder_collecting_dokumen">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th style="width: 30px;">No</th>
                                                                    <th>Nama Folder</th>
                                                                    <th style="width: 150px;">Status</th>
                                                                    <th style="width: 150px;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                        <input type="hidden" name="id_opening_meeting" id="id_opening_meeting" value="<?php echo $konten['opening_meeting']->id_opening_meeting; ?>">

                                                        <?php
                                                        if ($konten['btn_siap_survey'] === true) {
                                                        ?>
                                                            <button type="button" id="simpan" class="btn btn-primary">
                                                                <span class="indicator-label"><i class="fa-solid fa-paper-plane me-2 fs-3"></i> Siap Survey</span>
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
                    <form id="dropzone" class="form" action="#" method="post">
                        <input type="hidden" name="id_opening_meeting" id="folder_dokumen-id_opening_meeting" value="<?php echo $konten['opening_meeting']->id_opening_meeting; ?>">
                        <input type="hidden" name="id_nama_file" id="folder_dokumen-id_nama_file">
                        <input type="hidden" name="token" id="folder_dokumen-token" value="<?php echo genToken('SEND_DATA'); ?>">
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
                                    <th style="width: 20px">No</th>
                                    <th>Data</th>
                                    <th style="width: 130px;">Action</th>
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

    <?php $this->view('include/js'); ?>
    <?php $this->view('collecting_document/include/bom'); ?>
    <script>
        // set the dropzone container id
        const id = "#kt_dropzonejs_example_2";
        const dropzone = document.querySelector(id);

        // set the preview element template
        var previewNode = dropzone.querySelector(".dropzone-item");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone(id, { // Make the whole body a dropzone
            url: base_url + "pelanggan_area/collecting_dokumen/upload_file", // Set the url for your upload script location
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
                            '<label class="' + (kolom_tambahan[i].mandatory ? 'required' : '') + ' fs-6 fw-semibold mb-2">' + kolom_tambahan[i].label + '</label>' +
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
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
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

        function buka_folder(index) {
            clear_all_list();
            selected_index = index;
            var data = list_data[index];
            $("#folder_dokumen-id_nama_file").val(data.id_nama_file);

            $("#folder_dokumen-nama_file").html(data.nama_file);
            $("#folder_dokumen-keterangan").html(data.keterangan);

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
            if (data.jns_file) {
                // Pisahkan string jns_file menjadi array
                var exts = data.jns_file.split('|');

                // Buat array baru yang berisi MIME type dari ekstensi file yang diberikan
                var mimes = exts.map(function(ext) {
                    return mimeTypes[ext];
                });

                // Gabungkan array mimes menjadi string dengan dipisahkan oleh koma
                var acceptedFiles = mimes.join(',');
            }
            myDropzone.options.acceptedFiles = acceptedFiles;

            rangkai_file();

            // cek apakah yang dibuka adalah folder milik assesor atau pelanggan...
            if (data.aktor == 'assesor') {
                //jika milik assesor, maka tampilkan dropzone...
                $("#dropzone, .separator_dropzone").show();
            } else {
                setTimeout(function() {
                    $("#dropzone, .separator_dropzone").hide();
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
            $("#empty_state").remove();
            if (files.length > 0) {
                for (var i = 0; i < files.length; i++) {
                    var verifikasi = '';
                    var btn_action = '<button type="button" class="btn btn-sm btn-block mt-3 btn-success" onClick="verifikasi_dokumen(' + files[i].id_collecting_dokumen + ', \'' + files[i].value + '\', \'setuju\')"><i class="fa fa-check"></i> Setuju</button>' +
                        '<button type="button" class="btn btn-sm btn-block mt-3 btn-danger" onClick="verifikasi_dokumen(' + files[i].id_collecting_dokumen + ', \'' + files[i].value + '\', \'tolak\')"><i class="fa fa-times"></i> Tolak</button>';
                    if (files[i].status_verifikasi == 1) {
                        verifikasi = render_badge('light-success', 'Dokumen Disetujui');
                        btn_action = '';
                    } else if (files[i].status_verifikasi == 2) {
                        verifikasi = render_badge('light-danger', 'Dokumen Ditolak');
                        verifikasi += '<div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-2 mt-4">' +
                            '<?php echo getSvgIcon('general/gen034', 'svg-icon svg-icon-2tx svg-icon-danger me-4') ?>' +
                            '<div class="d-flex flex-stack flex-grow-1">' +
                            '<div class="fw-semibold">' +
                            '<div class="fs-6 text-gray-700">' + files[i].alasan_verifikasi + '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        btn_action = '';
                    } else if (files[i].status_verifikasi == 3) {
                        verifikasi = render_badge('light-warning', 'Dalam Pengecekan');
                    } else {
                        verifikasi = render_badge('light-info', 'Menunggu Verifikasi');
                    }
                    var data_file = '<a href="' + base_url + files[i].resource + '" download class="text-gray-800 text-hover-primary fw-bold">' + files[i].value.replace(/_/g, ' ') + '</a>';
                    if (files[i].jns_file == 'textarea') {
                        data_file = '<div class="text-gray-800 fw-bold">' + files[i].value + '</div>';
                    }

                    var kolom_tambahan = '';
                    if (files[i].kolom_tambahan) {
                        var list_tambahan = safelyParseJSON(files[i].kolom_tambahan);
                        if (list_tambahan.length > 0) {
                            kolom_tambahan = '<div class="row">';
                            for (var a = 0; a < list_tambahan.length; a++) {
                                kolom_tambahan += '<div class="col-sm-6 mb-3"><div class="text-gray-600 fs-7">' + list_tambahan[a].label + '</div><div>' + list_tambahan[a].value + '</div></div>';
                            }
                            kolom_tambahan += '</div>';
                        }
                    }

                    if (files[i].referensi == 'BOM') {
                        btn_action = '<button class="btn btn-sm btn-light-primary" onclick="buka_folder_bom(' + files[i].id_collecting_dokumen + ')"><i class="fa fa-folder"></i> Folder BOM</button>';
                    }
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
                create_empty_state("#file_collecting_dokumen");
            }
        }

        function verifikasi_dokumen(id_collecting_dokumen, nama_file, status) {
            if (status == 'setuju') {
                var pertanyaan = "Apakah Anda yakin ingin <strong>menyetujui</strong> dokumen <strong>" + nama_file + "</strong>?";

                konfirmasi(pertanyaan, function() {
                    proses_verifikasi_dokumen(id_collecting_dokumen, status);
                });
            } else {
                $("#folder_dokumen_modal").modal('hide');
                swal.fire({
                    title: 'Tolak Dokumen',
                    html: 'Apakah Anda yakin ingin <Strong>menolak</strong> dokumen  <strong>' + nama_file + '</strong>?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, lanjutkan!',
                    cancelButtonText: 'Tidak, batalkan',
                    confirmButtonColor: '#0abb87',
                    cancelButtonColor: '#d33',
                    allowOutsideClick: false,
                    reverseButtons: true,
                    input: 'textarea',
                    inputLabel: 'Alasan Penolakan',
                    inputPlaceholder: 'Tuliskan alasan penolakan Anda disini',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Anda harus menuliskan alasan penolakan dengan jelas!'
                        }
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $("#tolak").attr({
                            "data-kt-indicator": "on",
                            'disabled': true
                        });

                        buka_folder(selected_index);
                        proses_verifikasi_dokumen(id_collecting_dokumen, status, result.value);
                    } else {
                        buka_folder(selected_index);

                    }

                });
            }
        }

        function proses_verifikasi_dokumen(id_collecting_dokumen, status, alasan_verifikasi = '') {
            //show loading animation...
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_collecting_dokumen'] = id_collecting_dokumen;
            data['status'] = status;
            data['alasan_verifikasi'] = alasan_verifikasi;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>collecting_dokumen/verifikasi_dokumen',
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

        $("#simpan").click(function() {
            var id_opening_meeting = $("#id_opening_meeting").val();
            //show loading animation...
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>collecting_dokumen/submit_semua_dokumen',
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
        })

        function after_save() {
            window.history.back();
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
                url: '<?php echo base_url(); ?>pelanggan_area/collecting_dokumen/load_folder',
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
                            if (list_data[i].kriteria_bmp) {
                                if (list_data[i].kriteria_bmp.id_kriteria_bpm != id_kriteria_bmp) {
                                    rangkai += '<tr>' +
                                        '<td colspan="4">' +
                                        '<div class="fw-bold fs-4">' + list_data[i].kriteria_bmp.judul_kriteria + '</div>' +
                                        (list_data[i].kriteria_bmp.keterangan ? '<div class="">' + list_data[i].kriteria_bmp.keterangan + '</div>' : '') +
                                        '</td>' +
                                        '</tr>';

                                    id_kriteria_bmp = list_data[i].kriteria_bmp.id_kriteria_bpm;
                                    no = 1;
                                }
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
                                '<button type="button" class="btn btn-sm btn-light-primary" onClick="buka_folder(' + i + ')"><i class="fa fa-folder"></i> Buka Folder</button>' +
                                '</td>' +
                                '</tr>';

                            no++;
                        }
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

        function buka_folder_bom(id_collecting_dokumen) {
            $("#folder_dokumen_modal").modal('hide');
            $("#folder_bom_modal").modal('show');
            load_bom(id_collecting_dokumen);
        }
    </script>
</body>
<!-- end::Body -->

</html>