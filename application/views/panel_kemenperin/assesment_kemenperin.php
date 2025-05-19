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
                                <!--end::Page title-->
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">

                                <div class="card card-flush h-lg-100">
                                    <div class="card-header align-items-center py-5 gap-2 gap-md-5" data-select2-id="select2-data-124-ftn2">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <!--begin::Search-->
                                            <div class="d-flex align-items-center position-relative my-1">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                <?php echo getSvgIcon('general/gen021', 'svg-icon svg-icon-1 position-absolute ms-4'); ?>
                                                <!--end::Svg Icon-->
                                                <input type="text" class="form-control form-control-solid w-250px ps-14" id="filter" name="filter" placeholder="Masukkan kata kunci pencarian">
                                            </div>
                                            <!--end::Search-->
                                        </div>
                                        <!--end::Card title-->

                                    </div>

                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17" style="padding-top: unset!important;">
                                        <!--begin::Layout-->
                                        <div id="data_zona_form_01">
                                            <div class="d-flex flex-column flex-lg-row">
                                                <!--begin::Content-->
                                                <div class="flex-lg-row-fluid me-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-striped gy-5" id="data_form_01">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th>No.</th>
                                                                    <th>Nomor Order</th>
                                                                    <th>Pelanggan</th>
                                                                    <th style="width: 200px;">Status</th>
                                                                    <th class="text-end pe-3 w-150px">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="kt-datatable kt-datatable--default">
                                                        <div class="kt-datatable__pager kt-datatable--paging-loaded">
                                                            <input type="hidden" id="page" name="page" value="1">
                                                            <input type="hidden" id="last_page" name="last_page">
                                                            <div id="pagination"></div>
                                                        </div>
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

    <div class="modal fade" id="folder_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h2>Folder <span id="folder_dokumen-nama_folder"></span></h2>
                        <h4 class="mt-3" id="folder_dokumen-nama_perusahaan"></h4>
                        <h5 class="mt-1" id="folder_dokumen-nomor_order"></h5>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                        <!--begin::Icon-->
                        <?php echo getSvgIcon('general/gen045', 'svg-icon svg-icon-2tx svg-icon-primary me-4') ?>
                        <!--end::Svg Icon-->
                        <!--end::Icon-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-grow-1">
                            <!--begin::Content-->
                            <div class="fw-semibold">
                                <div class="fs-6 text-gray-700">
                                    <div class="fw-bold text-danger">Harap Dibaca!</div>Dokumen yang diperbolehkan hanya dokumen yang berjenis <span class="fw-bold text-uppercase" id="folder_dokumen-ekstensi_file"></span>.</span>
                                </div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <form id="dropzone" class="form" action="#" method="post">
                        <input type="hidden" id="folder_dokumen-id_opening_meeting">
                        <input type="hidden" id="folder_dokumen-id_nama_file" class="id_nama_file">
                        <input type="hidden" id="folder_dokumen-to_closing_meeting">
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

                    <table class="table table-sm table-striped gy-5" id="folder_file">
                        <thead>
                            <tr>
                                <th id="folder_file-nomor">No</th>
                                <th>File</th>
                                <th class="text-end pe-3 w-250px">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" id="proses_closing_meeting">
                        <i class="fa fa-paper-plane me-2"></i> Closing Meeting
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php $this->view('include/js'); ?>

    <script>
        $(document).on('click', '#pagination > ul > li > a', function() {
            var page = $(this).text(); // mendapatkan nomor halaman yang di-klik
            // lakukan sesuatu dengan nomor halaman tersebut, misalnya:
            $("#page").val(page);
            load_data();
        });
        $("#filter").keyup(function() {
            $("#page").val(1);
            load_data();
        });

        var ajax_request;
        var list_data;
        var jenis_dokumen = [];
        <?php
        //change array to string
        if ($konten['panel_kemenperin_nama_file']->num_rows() > 0) {
            $data = json_encode($konten['panel_kemenperin_nama_file']->result());

            echo 'jenis_dokumen = safelyParseJSON(\'' . $data . '\');';
        }
        ?>

        function load_data() {
            var page = $("#page").val();
            var jml_data = 10;
            var blink_notif = '<span class="bullet bullet-dot bg-danger h-6px w-6px translate-middle animation-blink ms-2"></span>';

            var filter = $("#filter").val();

            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['page'] = page;
            data['jml_data'] = jml_data;
            data['filter'] = filter;
            data['for'] = 'assesment_kemenperin';

            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>verifikasi_tkdn/load_data',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    //parse JSON...
                    $("#last_page").val(result.last_page);
                    list_data = result.result;
                    generatePages('#pagination', page, result.last_page);

                    var rangkai = '';
                    if (list_data.length > 0) {
                        for (var i = 0; i < list_data.length; i++) {
                            var assesor_lapangan = '';
                            if (list_data[i].assesor_lapangan) {
                                assesor_lapangan = '<div class="mt-3 fs-7 fw-bold">Verifikator Survey Lapangan:</div>';
                                for (var j = 0; j < list_data[i].assesor_lapangan.length; j++) {
                                    assesor_lapangan += '<span class="badge badge-light-primary">' + list_data[i].assesor_lapangan[j].nama_admin + '</span>';
                                }
                            }

                            var list_folder = '';
                            jenis_dokumen.map(item => {
                                var jml_file = 0;
                                if (list_data[i].file_kemenperin.length > 0) {
                                    list_data[i].file_kemenperin.map(file_kemenperin => {
                                        if (file_kemenperin.id_nama_file == item.id_nama_file) {
                                            jml_file = file_kemenperin.files.length;

                                        }
                                    });
                                }
                                jml_file = '<span class="menu-badge"><span class="badge badge-primary ms-5">' + jml_file + '</span></span>';

                                list_folder +=
                                    '<div class="menu-item px-3">' +
                                    '<a href="javascript:;" onclick="buka_folder(' + i + ', \'' + item.id_nama_file + '\', \'' + item.nama_file + '\', \'' + item.jns_file + '\', \'' + item.to_closing_meeting + '\')" class="menu-link px-3">' +
                                    '<span class="menu-icon">' +
                                    '<i class="fa fa-folder-plus text-primary pe-3"></i>' +
                                    '</span>' +
                                    '<span class="menu-title">Upload ' + item.nama_file + '</span>' +
                                    jml_file +
                                    '</a>' +
                                    '</div>';
                            })

                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + list_data[i].nomor_order_payment + '</div>' +
                                render_badge_tipe_pengajuan(list_data[i].tipe_pengajuan) +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold fs-6" style="max-width: 200px; text-overflow:ellipsis;overflow: hidden;white-space: nowrap;">' + list_data[i].nama_badan_usaha + ' ' + list_data[i].nama_perusahaan + '</div>' +
                                (assesor_lapangan ? assesor_lapangan : 'Belum Ada') +
                                '</td>' +
                                '<td>' +
                                status_verifikasi_tkdn_badge(list_data[i].id_status) +
                                '</td>' +
                                '<td class="text-end pe-3 w-150px">' +

                                '<div class="me-0">' +
                                '<button class="btn btn-sm btn-light-primary btn-active-light-primary dropdown-toggle" data-kt-menu="true" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">' +
                                '<i class="fa fa-folder"></i> Folder' +
                                '</button>' +
                                '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-250px py-3" data-kt-menu="true" style="">' +
                                list_folder +

                                '</div>' +
                                '</div>' +

                                '</td>' +
                                '</tr>';
                        }
                    }

                    if (rangkai) {
                        $("#empty_state").remove();
                        $("#data_zona_form_01").show();

                        $("#data_form_01 tbody").html(rangkai);
                        KTMenu.createInstances();
                    } else {
                        if (page == 1 && filter == '') {
                            create_empty_state("#data_zona_form_01");
                        } else
                            $("#data_form_01 tbody").html('');
                    }

                }

            });
        }
        load_data();

        // set the dropzone container id
        const id = "#kt_dropzonejs_example_2";
        const dropzone = document.querySelector(id);

        // set the preview element template
        var previewNode = dropzone.querySelector(".dropzone-item");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone(id, { // Make the whole body a dropzone
            url: base_url + "panel_kemenperin_dokumen/simpan", // Set the url for your upload script location
            parallelUploads: 3,
            maxFiles: 10,
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

            load_data_dokumen();

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

        function load_data_dokumen() {
            $("#folder_file").show();
            $("#empty_state").remove();

            var id_opening_meeting = $("#folder_dokumen-id_opening_meeting").val();
            var id_nama_file = $("#folder_dokumen-id_nama_file").val();
            var to_closing_meeting = $("#folder_dokumen-to_closing_meeting").val();

            if (id_opening_meeting) {
                preloader('show');

                var data = new Object;
                data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
                data['id_opening_meeting'] = id_opening_meeting;
                data['id_nama_file'] = id_nama_file;

                ajax_request = $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>Panel_kemenperin_dokumen/load_data',
                    data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                    cache: false,
                    dataType: "json",
                    success: function(list_dokumen) {
                        $("#folder_modal").modal('show');
                        $("#folder_modal-footer").hide();
                        preloader('hide');

                        if (list_dokumen.length > 0) {
                            $("#folder_modal-footer").show();

                            var rangkai = '';
                            list_dokumen.map((item, i) => {
                                var btn_action = '<a href="' + base_url + 'page/preview_dokumen/?id_opening_meeting=' + data.id_opening_meeting + '&file=' + base_url + item.path_file + '" target="_blank" class="btn btn-sm btn-primary me-2"><i class="fa fa-file me-2"></i> Buka File</a>';

                                var kolom_nomor = i + 1;
                                var disabled_status = '';
                                var disabled_delete = '';

                                if (to_closing_meeting == 1) {
                                    var fileExt = item.panel_kemenperin_dokumen_nama_file.split('.').pop();
                                    if (item.id_closing_meeting || fileExt != 'pdf') {
                                        disabled_status = 'disabled';
                                        disabled_delete = 'disabled';

                                        if (fileExt != 'pdf') {
                                            disabled_delete = '';
                                        }

                                    }


                                    kolom_nomor = '<div class="form-check">' +
                                        '<input class="form-check-input dokumen_panel_kemenperin" type="checkbox" value="' + item.id_panel_kemenperin_dokumen + '" ' + disabled_status + '  />' +
                                        '</div>';
                                }

                                btn_action += '<button type="button" class="btn btn-sm btn-danger" onclick="hapus_file(' + item.id_panel_kemenperin_dokumen + ', \'' + item.nama_file + '\')" ' + disabled_delete + '><i class="fa fa-trash me-2"></i> Hapus</button>';

                                rangkai += '<tr>' +
                                    '<td>' + kolom_nomor + '</td>' +
                                    '<td class="' + (disabled_status ? 'text-muted' : '') + '">' +
                                    item.panel_kemenperin_dokumen_nama_file + '</td>' +
                                    '<td class="text-end pe-3">' + btn_action + '</td>' +
                                    '</tr>';
                            });

                            $("#folder_file tbody").html(rangkai);
                        } else {
                            create_empty_state("#folder_file");
                        }
                    }

                });

            }
        }

        function buka_folder(index, id_nama_file, nama_file, ekstensi_file, to_closing_meeting) {
            var data = list_data[index];

            //replace | with ,
            ekstensi_file = ekstensi_file.replace(/[|]/g, ', ');

            $("#folder_dokumen-id_opening_meeting").val(data.id_opening_meeting);
            $("#folder_dokumen-nama_perusahaan").html(data.nama_badan_usaha + ' ' + data.nama_perusahaan);
            $("#folder_dokumen-nomor_order").html(data.nomor_order_payment);

            $("#folder_dokumen-id_nama_file").val(id_nama_file);
            $("#folder_dokumen-to_closing_meeting").val(to_closing_meeting);
            $("#folder_dokumen-nama_folder").html(nama_file);
            $("#folder_dokumen-ekstensi_file").html(ekstensi_file);



            if (to_closing_meeting == 1) {
                $("#folder_file-nomor").html('#');

            } else {
                $("#folder_file-nomor").html('No');
            }

            $("#folder_modal").modal('show');
            clear_all_list();
            load_data_dokumen();

        }

        function hapus_file(id_panel_kemenperin_dokumen, nama_file) {
            var pertanyaan = "Apakah Anda yakin akan menghapus file <b>" + nama_file + "</b>?";
            konfirmasi(pertanyaan, function() {
                proses_hapus_file(id_panel_kemenperin_dokumen);
            });
        }

        function proses_hapus_file(id_panel_kemenperin_dokumen) {
            preloader('show');
            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_panel_kemenperin_dokumen'] = id_panel_kemenperin_dokumen;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>panel_kemenperin_dokumen/hapus',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    //hide loading animation...
                    preloader('hide');

                    if (data.sts == 1) {
                        //load data..
                        clear_all_list();
                        load_data_dokumen();
                        var response = JSON.parse('<?php echo alert('hapus_berhasil'); ?>');
                        toastrAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }

            });
        }

        $("#proses_closing_meeting").click(function() {
            //cek apakah file ada yang dipilih...
            var list_file = [];

            $(".dokumen_panel_kemenperin:checked").each(function() {
                list_file.push($(this).val());
            });

            if (list_file.length > 0) {
                var pertanyaan = "Apakah Anda yakin akan melanjutkan ke proses closing meeting?";

                konfirmasi(pertanyaan, function() {
                    proses_closing_meeting(list_file);
                });
            } else {
                var response = JSON.parse('<?php echo alert('pilih_satu'); ?>');
                swalAlert(response);
            }


        });

        function proses_closing_meeting(id_panel_kemenperin_dokumen) {
            var id_opening_meeting = $("#folder_dokumen-id_opening_meeting").val();
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;
            data['id_panel_kemenperin_dokumen'] = id_panel_kemenperin_dokumen;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>panel_kemenperin_dokumen/goto_closing_meeting',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    //hide loading animation...
                    preloader('hide');

                    if (data.sts == 1) {
                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        swalAlert(response);
                        load_data();

                        $("#folder_modal").modal('hide');
                    } else if (data.sts == 'tidak_berhak_ubah_data') {
                        var response = JSON.parse('<?php echo alert('tidak_berhak_ubah_data'); ?>');
                        swalAlert(response);

                    } else if (data.sts == 'belum_ada_file') {
                        var response = JSON.parse('<?php echo alert('belum_ada_file'); ?>');
                        swalAlert(response);

                    } else {
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