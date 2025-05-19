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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h2>Folder Tanda Sah</h2>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-striped gy-5" id="folder_file">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>File</th>
                                <th class="w-150px text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer" id="folder_modal-footer">
                    <input type="hidden" id="folder_modal-id_opening_meeting">
                    <input type="hidden" id="folder_modal-action">
                    <button type="button" class="btn btn-primary btn-sm" id="folder_modal-selanjutnya"><i class="fa fa-paper-plane me-2"></i> <span id="label_btn"></span></button>
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
            data['for'] = 'verifikasi_draft_tanda_sah';

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
                                '<button type="button" class="btn btn-sm btn-light-primary" onclick="buka_folder(' + i + ')"><i class="fa fa-folder"></i> Buka Folder</button>' +
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

        function buka_folder(index) {
            var data = list_data[index];
            var rangkai = '';
            var setuju = 0;
            var tolak = 0;
            var menunggu = 0;

            for (var i = 0; i < data.tanda_sah.length; i++) {
                var data_file = '<div class="fw-bold">' + data.tanda_sah[i].value.replace(/_/g, ' ') + '</div>';

                var kolom_tambahan = '';
                if (data.tanda_sah[i].kolom_tambahan) {
                    var list_tambahan = safelyParseJSON(data.tanda_sah[i].kolom_tambahan);
                    if (list_tambahan.length > 0) {
                        kolom_tambahan = '<div class="row">';
                        for (var a = 0; a < list_tambahan.length; a++) {
                            kolom_tambahan += '<div class="col-sm-6 mb-3"><div class="text-gray-600 fs-7">' + list_tambahan[a].label + '</div><div>' + coverMe(list_tambahan[a].value) + '</div></div>';
                        }
                        kolom_tambahan += '</div>';
                    }
                }

                if (data.tanda_sah[i].status_verifikasi == 0) {
                    tolak++;
                }
                if (data.tanda_sah[i].status_verifikasi == 1) {
                    setuju++;
                }
                if (data.tanda_sah[i].status_verifikasi == 2) {
                    menunggu++;
                }

                var btn_action = '<a href="' + base_url + 'page/verifikasi_draft_tanda_sah/' + data.id_opening_meeting + '?dokumen=' + data.tanda_sah[i].id_panel_internal_dokumen + '" class="btn btn-sm btn-primary"><i class="fa fa-check-circle me-2"></i> Verifikasi</a>';
                rangkai += '<tr>' +
                    '<td>' + (i + 1) + '</td>' +
                    '<td>' +
                    data_file +
                    kolom_tambahan +
                    render_badge(data.tanda_sah[i].status[0], data.tanda_sah[i].status[1]) +
                    (data.tanda_sah[i].status_verifikasi == 0 ? '<div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-3 mt-3">' + data.tanda_sah[i].alasan_verifikasi + '</div>' : '') +
                    '</td>' +
                    '<td class="text-end pe-3">' + btn_action + '</td>' +
                    '</tr>';
            }
            $("#folder_file tbody").html(rangkai);

            $("#folder_modal-id_opening_meeting").val(data.id_opening_meeting);
            $("#folder_modal-footer").hide();
            if (tolak > 0 && menunggu == 0) {
                $("#folder_modal-footer").show();
                $("#folder_modal-action").val('tanda_sah_tolak');
                $("#label_btn").html('Kirim Ke Pelanggan');
            } else if (tolak == 0 && menunggu == 0) {
                $("#folder_modal-footer").show();
                $("#folder_modal-action").val('assesment_kemenperin');
                $("#label_btn").html('Save Draft Tanda Sah');
            }


            $("#folder_modal").modal('show');
        }

        $("#folder_modal-selanjutnya").click(function() {
            var id_opening_meeting = $("#folder_modal-id_opening_meeting").val();
            var action = $("#folder_modal-action").val();
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;
            data['action'] = action;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>panel_internal/lanjutan_proses_draft_tanda_sah',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    preloader('hide');
                    //hide loading animation...

                    if (data.sts == 1) {
                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        swalAlert(response);
                        load_data();

                        $("#folder_modal").modal('hide');
                    } else if (data.sts == 'tidak_berhak_ubah_data') {
                        var response = JSON.parse('<?php echo alert('tidak_berhak_ubah_data'); ?>');
                        swalAlert(response);

                    } else if (data.sts == 'belum_verifikasi_semua') {
                        var response = JSON.parse('<?php echo alert('belum_verifikasi_semua'); ?>');
                        swalAlert(response);

                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }

            });
        });
    </script>
</body>
<!-- end::Body -->

</html>