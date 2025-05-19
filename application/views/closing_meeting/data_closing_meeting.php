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
                                                                    <th>Closing Meeting</th>
                                                                    <th>Nomor Order</th>
                                                                    <th>Pelanggan</th>
                                                                    <th class="w-200px">Status</th>
                                                                    <th class="w-150px text-end">Action</th>
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

    <div class="modal fade" id="folder_kemenperin_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h2>Folder <span id="folder_kemenperin-nama_folder"></span></h2>
                        <h4 class="mt-3" id="folder_kemenperin-nama_perusahaan"></h4>
                        <h5 class="mt-1" id="folder_kemenperin-nomor_order"></h5>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="folder_kemenperin-id_opening_meeting" />
                    <input type="hidden" id="folder_kemenperin-id_closing_meeting" />
                    <input type="hidden" id="folder_kemenperin-id_nama_file" />
                    <table class="table table-sm table-striped gy-5" id="folder_kemenperin_file">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>File</th>
                                <th class="text-end pe-3 w-250px">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="folder_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h2>Folder Closing Meeting Tahap <span id="folder_dokumen-tahap_closing_meeting"></span></h2>
                        <h4 class="mt-3" id="folder_dokumen-nama_perusahaan"></h4>
                        <h4 class="mt-1" id="folder_dokumen-nomor_order"></h4>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">

                    <table class="table table-sm table-striped gy-5" id="folder_file">
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer" id="folder_dokumen-footer">
                    <input type="hidden" id="folder_dokumen-id_closing_meeting" class="id_closing_meeting">
                    <input type="hidden" id="folder_dokumen-action">
                    <button type="button" class="btn btn-primary btn-sm" id="folder_dokumen-kirim"><i class="fa fa-paper-plane me-2"></i> Kirim Ke Dokumen Kontrol</button>
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
            data['for'] = 'upload_closing_meeting';

            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>closing_meeting/load_data',
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


                            var list_folder =
                                '<div class="menu-item px-3">' +
                                '<a href="javascript:;" onclick="buka_folder(' + i + ')" class="menu-link px-3"><i class="fa fa-folder-plus text-primary pe-3"></i> Upload Closing Meeting</a>' +
                                '</div>';

                            jenis_dokumen.map(item => {
                                list_folder +=
                                    '<div class="menu-item px-3">' +
                                    '<a href="javascript:;" onclick="buka_folder_kemenperin(' + i + ', \'' + item.id_nama_file + '\', \'' + item.nama_file + '\')" class="menu-link px-3"><i class="fa fa-folder text-primary pe-3"></i> ' + item.nama_file + '</a>' +
                                    '</div>';
                            })

                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +
                                '<td class="fw-bold fs-6">Tahap ' + list_data[i].tahap_closing_meeting + '</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + list_data[i].nomor_order_payment + '</div>' +
                                render_badge_tipe_pengajuan(list_data[i].tipe_pengajuan) +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold fs-6" style="max-width: 200px; text-overflow:ellipsis;overflow: hidden;white-space: nowrap;">' + list_data[i].nama_badan_usaha + ' ' + list_data[i].nama_perusahaan + '</div>' +
                                (assesor_lapangan ? assesor_lapangan : 'Belum Ada') +
                                '</td>' +
                                '<td>' +
                                status_closing_meeting_badge(list_data[i].status) +
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
                                //'<button type="button" class="btn btn-sm btn-light-primary" onclick="buka_folder(' + i + ')"><i class="fa fa-folder"></i> Buka Folder</button>' +
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

        function buka_folder_kemenperin(index, id_nama_file, nama_file) {
            var data = list_data[index];

            $("#folder_kemenperin-id_opening_meeting").val(data.id_opening_meeting);
            $("#folder_kemenperin-id_closing_meeting").val(data.id_closing_meeting);
            $("#folder_kemenperin-id_nama_file").val(id_nama_file);
            $("#folder_kemenperin-nama_folder").html(nama_file);
            $("#folder_kemenperin-nama_perusahaan").html(data.nama_badan_usaha + ' ' + data.nama_perusahaan);
            $("#folder_kemenperin-nomor_order").html(data.nomor_order_payment);

            $("#folder_kemenperin_modal").modal('show');
            load_data_kemenperin();

        }

        function load_data_kemenperin() {
            $("#folder_kemenperin_file").show();
            $("#empty_state").remove();

            var id_opening_meeting = $("#folder_kemenperin-id_opening_meeting").val();
            var id_closing_meeting = $("#folder_kemenperin-id_closing_meeting").val();
            var id_nama_file = $("#folder_kemenperin-id_nama_file").val();

            if (id_opening_meeting) {
                preloader('show');

                var data = new Object;
                data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
                data['id_opening_meeting'] = id_opening_meeting;
                data['id_closing_meeting'] = id_closing_meeting;
                data['id_nama_file'] = id_nama_file;

                ajax_request = $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>Panel_kemenperin_dokumen/load_data',
                    data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                    cache: false,
                    dataType: "json",
                    success: function(list_dokumen) {
                        preloader('hide');

                        if (list_dokumen.length > 0) {

                            var rangkai = '';
                            list_dokumen.map((item, i) => {
                                var btn_action = '<a href="' + base_url + 'page/preview_dokumen/?id_opening_meeting=' + data.id_opening_meeting + '&file=' + base_url + item.path_file + '" target="_blank" class="btn btn-sm btn-primary me-2"><i class="fa fa-file me-2"></i> Buka File</a>';

                                rangkai += '<tr>' +
                                    '<td>' + (i + 1) + '</td>' +
                                    '<td>' +
                                    item.panel_kemenperin_dokumen_nama_file + '</td>' +
                                    '<td class="text-end pe-3">' + btn_action + '</td>' +
                                    '</tr>';
                            });

                            $("#folder_kemenperin_file tbody").html(rangkai);
                        } else {
                            create_empty_state("#folder_kemenperin_file");
                        }
                    }

                });

            }
        }

        function load_data_closing_meeting() {
            $("#folder_file").show();
            $("#empty_state").remove();

            var id_closing_meeting = $("#folder_dokumen-id_closing_meeting").val();

            if (id_closing_meeting) {
                preloader('show');

                var data = new Object;
                data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
                data['id_closing_meeting'] = id_closing_meeting;

                ajax_request = $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>closing_meeting_dokumen/load_data',
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
                                var btn_action = 'No Action';
                                var file = '';
                                var jns_file = item.jns_file.replace(/\|/g, ', ');

                                if (item.dokumen.length > 0) {
                                    btn_action = '<a href="' + base_url + 'page/preview_dokumen/?file=' + base_url + item.dokumen[0].path_file + '" target="_blank" class="btn btn-sm btn-primary me-2"><i class="fa fa-file me-2"></i> Buka File</a>';

                                    //jika status dokumen = 0 (ditolak) atau status dokumen = 2 (dalam persiapan)
                                    //maka boleh hapus file 
                                    if (item.dokumen[0].status == 0 || item.dokumen[0].status == 2) {
                                        btn_action += '<button type="button" class="btn btn-sm btn-danger" onclick="hapus_file(' + item.dokumen[0].id_closing_meeting_dokumen + ', \'' + item.nama_file + '\')"><i class="fa fa-trash me-2"></i> Hapus</button>';
                                    }

                                    var alasan_verifikasi = '';
                                    if (item.dokumen[0].status == 0) {
                                        alasan_verifikasi = render_badge('light-danger mt-3', 'Dokumen Ditolak');
                                        alasan_verifikasi += '<div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-2 mt-4">' +
                                            '<?php echo getSvgIcon('general/gen034', 'svg-icon svg-icon-2tx svg-icon-danger me-4') ?>' +
                                            '<div class="d-flex flex-stack flex-grow-1">' +
                                            '<div class="fw-semibold">' +
                                            '<div class="fs-6 text-gray-700">' + item.dokumen[0].alasan_verifikasi + '</div>' +
                                            '</div>' +
                                            '</div>' +
                                            '</div>';
                                    } else if (item.dokumen[0].status == 1) {
                                        alasan_verifikasi = render_badge('light-success mt-3', 'Dokumen Disetujui');
                                    }

                                    file += '<div class="fw-bold ' + (item.required && 'required') + '">' + item.nama_file + '</div>';
                                    file += alasan_verifikasi;
                                    file += '<div class="mt-3">' + btn_action + '</div>';
                                } else {
                                    file += '<form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="upload_closing_meeting_' + i + '" action="<?php echo base_url(); ?>closing_meeting_dokumen/simpan" autocomplete="off">';
                                    file += '<div class="fw-bold ' + (item.required && 'required') + '">' + item.nama_file + '</div>';
                                    file += '<div class="row">';

                                    file += '<div class="col-7">';
                                    file += '<input type="file" name="file" id="file_' + i + '" class="form-control mt-2" ' + (item.required && 'required') + ' />';
                                    file += '<input type="hidden" name="id_closing_meeting_nama_file" id="id_closing_meeting_nama_file_' + i + '" value="' + item.id_closing_meeting_nama_file + '" />';
                                    file += '<input type="hidden" name="id_closing_meeting" id="id_closing_meeting_' + i + '" class="id_closing_meeting" value="' + id_closing_meeting + '" />';
                                    file += '<input type="hidden" name="token" value="<?php echo genToken('SEND_DATA'); ?>" />';
                                    file += '</div>';

                                    file += '<div class="col-5 text-end">';
                                    file += '<button type="button" class="btn btn-primary mt-3" id="upload_' + i + '" onclick="upload_file(' + i + ')">' +
                                        '<span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>' +
                                        '<span class="indicator-progress">Tunggu...' +
                                        '<span class="spinner-border spinner-border-sm align-middle ms-2"></span>' +
                                        '</span>' +
                                        '</button>';
                                    file += '</div>';

                                    file += '</div>';

                                    file += '<div class="alert alert-primary d-flex align-items-center mt-3 mb-0 py-2 px-2 fs-8"><i class="fa fa-info-circle me-3 text-primary fs-6"></i> <div class="d-flex flex-column">Jenis file yang diperbolehkan adalah: ' + jns_file + '.</div></div>';
                                    file += '</form>';
                                }
                                rangkai += '<tr>' +
                                    '<td>' + (i + 1) + '</td>' +
                                    '<td>' +
                                    file + '</td>' +
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

        function buka_folder(index) {
            var data = list_data[index];

            $("#folder_dokumen-id_closing_meeting").val(data.id_closing_meeting);
            $("#folder_dokumen-nama_perusahaan").html(data.nama_badan_usaha + ' ' + data.nama_perusahaan);
            $("#folder_dokumen-nomor_order").html(data.nomor_order_payment);
            $("#folder_dokumen-tahap_closing_meeting").html(data.tahap_closing_meeting);

            $("#folder_modal").modal('show');
            load_data_closing_meeting();
        }

        function upload_file(i) {
            var id_closing_meeting = $("#id_closing_meeting_" + i).val();
            var file = $("#file_" + i).val();
            var id_closing_meeting_nama_file = $("#id_closing_meeting_nama_file_" + i).val();

            if (!id_closing_meeting || !file || !id_closing_meeting_nama_file) {

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
                            load_data_closing_meeting();

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
                url: '<?php echo base_url(); ?>closing_meeting_dokumen/hapus',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    //hide loading animation...
                    preloader('hide');

                    if (data.sts == 1) {
                        //load data..
                        load_data_closing_meeting();
                        var response = JSON.parse('<?php echo alert('hapus_berhasil'); ?>');
                        toastrAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }

            });
        }

        $("#folder_dokumen-kirim").click(function() {
            var pertanyaan = "Apakah Anda yakin akan mengirimkan dokumen ke dokumen kontrol?";

            konfirmasi(pertanyaan, function() {
                goto_kirim_dokumen_kontrol();
            });

        });

        function goto_kirim_dokumen_kontrol() {
            var id_closing_meeting = $("#folder_dokumen-id_closing_meeting").val();
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_closing_meeting'] = id_closing_meeting;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>closing_meeting_dokumen/goto_kirim_dokumen_kontrol',
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
                    } else if (data.sts == 'dokumen_belum_lengkap') {
                        var response = JSON.parse('<?php echo alert('dokumen_belum_lengkap'); ?>');
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