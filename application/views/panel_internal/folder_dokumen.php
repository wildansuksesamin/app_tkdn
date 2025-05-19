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

                                                        <button type="button" id="kirim_assesor" class="btn btn-primary hidden">
                                                            <span class="indicator-label"><i class="fa-solid fa-paper-plane me-2 fs-3"></i> Kirim Ke Verifikator</span>
                                                            <span class="indicator-progress">Loading...
                                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </button>
                                                        <button type="button" id="penugasan_etc" class="btn btn-primary hidden">
                                                            <span class="indicator-label"><i class="fa-solid fa-users me-2 fs-3"></i> Penugasan ETC</span>
                                                            <span class="indicator-progress">Loading...
                                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </button>

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
                    <div class="table-responsive">
                        <table class="table table-sm table-striped gy-5" id="file_collecting_dokumen">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                    <th class="w-20px">No</th>
                                    <th>Data</th>
                                    <th class="w-150px">Action</th>
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
                        <table class="table table-sm table-striped gy-5" id="file_lhv">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                    <th class="w-20px">No</th>
                                    <th>produk</th>
                                    <th class="w-150px">Action</th>
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
                    if (files[i].status_verifikasi == 1) {
                        verifikasi = render_badge('light-success py-3 px-4 fs-7', 'Dokumen Disetujui');
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
                        verifikasi = render_badge('light-primary py-3 px-4 fs-7', 'Menunggu Verifikasi');
                    }
                    var data_file = files[i].lhv_jns_produk;

                    var btn_action = '<a href="' + base_url + files[i].path_file + '" class="btn btn-sm me-3 btn-primary"><i class="fa fa-check-circle"></i> Verifikasi</a>';
                    var btn_action = '<a href="' + base_url + 'page/verifikasi_dokumen_panel_internal/<?php echo $konten['opening_meeting']->id_opening_meeting; ?>?id_panel_internal_lhv=' + files[i].id_panel_internal_lhv + '" class="btn btn-sm me-3 btn-primary"><i class="fa fa-check-circle"></i> Verifikasi</a>';
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

                $("#file_lhv").show();
                $("#file_lhv tbody").html(rangkai);
            } else {
                if (data.aktor != aktor) {
                    create_empty_state('#file_lhv');
                } else {
                    create_empty_state('#file_lhv', '<a href="' + base_url + 'page/lhv/' + data.id_opening_meeting + '" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Buat Dokumen LHV</a>');

                }
            }
        }

        function buka_folder(index) {
            selected_index = index;
            var data = list_data[index];
            $("#folder_dokumen-id_nama_file").val(data.id_nama_file);

            $("#folder_dokumen-nama_file").html(data.nama_file);
            $("#folder_dokumen-keterangan").html(data.keterangan);
            $("#folder_dokumen-kolom_tambahan").val(data.kolom_tambahan);

            rangkai_file();
            $("#folder_dokumen_modal").modal('show');
        }

        function rangkai_file() {
            $("#empty_state").remove();
            var data = list_data[selected_index];
            var files = data.files;
            var rangkai = '';
            if (files.length > 0) {
                for (var i = 0; i < files.length; i++) {
                    var verifikasi = '';
                    if (files[i].status_verifikasi == 1) {
                        verifikasi = render_badge('light-success py-3 px-4 fs-7', 'Dokumen Disetujui');
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
                        verifikasi = render_badge('light-primary py-3 px-4 fs-7', 'Menunggu Verifikasi');
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

                    var btn_action = '<a href="' + base_url + 'page/verifikasi_dokumen_panel_internal/<?php echo $konten['opening_meeting']->id_opening_meeting; ?>?id_panel_internal_dokumen=' + files[i].id_panel_internal_dokumen + '" class="btn btn-sm me-3 btn-primary"><i class="fa fa-check-circle"></i> Verifikasi</a>';
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

                $("#file_collecting_dokumen").show();
                $("#file_collecting_dokumen tbody").html(rangkai);
            } else {
                $("#file_collecting_dokumen").hide();
                if (data.aktor != aktor) {
                    create_empty_state('#file_collecting_dokumen');
                }
            }
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
                        $disetujui = 0;
                        $ditolak = 0;

                        for (var i = 0; i < list_data.length; i++) {
                            var status = render_badge('secondary', 'Folder Kosong');
                            if (list_data[i].dokumen_status.length > 0) {
                                if (list_data[i].dokumen_status[0] == 'Disetujui') {
                                    $disetujui++;
                                } else if (list_data[i].dokumen_status[0] == 'Ditolak') {
                                    $ditolak++;
                                }
                                status = render_badge(list_data[i].dokumen_status[1], list_data[i].dokumen_status[0]);
                            }

                            var button = '<button type="button" class="btn btn-sm btn-light-primary" onClick="buka_folder(' + i + ')"><i class="fa fa-folder"></i> Buka Folder</button>';
                            if (list_data[i].referensi == 'lhv') {
                                var button = '<button type="button" class="btn btn-sm btn-light-primary" onClick="buka_folder_lhv(' + i + ')"><i class="fa fa-folder"></i> Buka Folder</button>';
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

                        if ($disetujui == list_data.length) {
                            $("#kirim_assesor").hide();
                            $("#penugasan_etc").show();
                        } else if ($ditolak > 0) {
                            $("#kirim_assesor").show();
                            $("#penugasan_etc").hide();
                        } else {
                            $("#kirim_assesor, #penugasan_etc").hide();
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

        $("#kirim_assesor").click(function() {
            var pertanyaan = 'Apakah Anda yakin ingin mengirimkan semua dokumen ke Verifikator?';
            konfirmasi(pertanyaan, function() {
                update_status('kirim_assesor');
            });
        });
        $("#penugasan_etc").click(function() {
            var pertanyaan = 'Apakah Anda yakin ingin melanjutkan ke penugasan ETC?';
            konfirmasi(pertanyaan, function() {
                update_status('penugasan_etc');
            });
        });

        function update_status(from) {
            var id_opening_meeting = $("#id_opening_meeting").val();
            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>panel_internal/kirim_assesor',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    preloader('hide');

                    if (data.sts == 1) {
                        //load data..
                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        if (from == 'penugasan_etc') {
                            response.callback_yes = redirect_penugasan_etc;
                        } else {
                            response.callback_yes = after_save;
                        }
                        swalAlert(response);
                    } else if (data.sts == 'belum_verifikasi_semua') {
                        var response = JSON.parse('<?php echo alert('belum_verifikasi_semua'); ?>');
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
            location.href = base_url + 'page/verifikasi_dokumen_panel_internal';
        }

        function redirect_penugasan_etc() {
            location.href = base_url + 'page/penugasan_etc';
        }
    </script>
</body>
<!-- end::Body -->

</html>