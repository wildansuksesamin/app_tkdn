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
                                                                    <th class="w-150px text-end pe-3">Action</th>
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
            data['for'] = 'approval_assesment_etc';

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
                            var orang_etc = '';
                            if (list_data[i].orang_etc) {
                                orang_etc = '<div class="mt-3 fs-7 fw-bold">ETC:</div>';
                                for (var j = 0; j < list_data[i].orang_etc.length; j++) {
                                    orang_etc += '<span class="badge badge-light-primary">' + list_data[i].orang_etc[j].nama_admin + '</span>';
                                }
                            }

                            //=== LIST FILE DRAFT TANDA SAH
                            //=================================
                            var list_draft_tanda_sah = '';
                            if (list_data[i].dokumen_for_etc.draft_tanda_sah) {
                                var draft_tanda_sah = list_data[i].dokumen_for_etc.draft_tanda_sah;

                                list_draft_tanda_sah = '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                    '<a href="#" class="menu-link px-3">' +
                                    '<span class="menu-title"><i class="fa fa-folder text-primary pe-3"></i> Draft Tanda Sah</span>' +
                                    '<span class="menu-arrow"></span>' +
                                    '</a>' +
                                    '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">';

                                for (var j = 0; j < draft_tanda_sah.length; j++) {
                                    var kolom_tambahan = safelyParseJSON(draft_tanda_sah[j].kolom_tambahan);
                                    var nama_file = '';

                                    if (Array.isArray(kolom_tambahan)) {
                                        for (var z = 0; z < kolom_tambahan.length; z++) {
                                            if (kolom_tambahan[z].field == 'nama_file') {
                                                nama_file = kolom_tambahan[z].value;
                                            }
                                        }
                                    }

                                    list_draft_tanda_sah += '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'page/preview_dokumen/?file=' + base_url + draft_tanda_sah[j].path_file + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> <label class="text-truncate cursor-pointer">' + draft_tanda_sah[j].value + '</label></a>' +
                                        '</div>';
                                }
                                list_draft_tanda_sah += '</div>' +
                                    '</div>';
                            }

                            //=== LIST FILE LHV
                            //=================================
                            var list_lhv = '';
                            if (list_data[i].dokumen_for_etc.lhv) {
                                var lhv = list_data[i].dokumen_for_etc.lhv;

                                list_lhv = '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                    '<a href="#" class="menu-link px-3">' +
                                    '<span class="menu-title"><i class="fa fa-folder text-primary pe-3"></i> LHV</span>' +
                                    '<span class="menu-arrow"></span>' +
                                    '</a>' +
                                    '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">';

                                for (var j = 0; j < lhv.length; j++) {
                                    list_lhv += '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'page/preview_dokumen/?file=' + base_url + 'panel_internal/dokumen_lhv/' + lhv[j].id_panel_internal_lhv + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> <label class="cursor-pointer text-truncate">' + lhv[j].lhv_jns_produk + '</label></a>' +
                                        '</div>';
                                }
                                list_lhv += '</div>' +
                                    '</div>';
                            }

                            //=== LIST FILE ASSESMENT
                            //=================================
                            var list_assesment = '';
                            if (list_data[i].dokumen_for_etc.assesment) {
                                var assesment = list_data[i].dokumen_for_etc.assesment;

                                list_assesment = '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                    '<a href="#" class="menu-link px-3">' +
                                    '<span class="menu-title"><i class="fa fa-folder text-primary pe-3"></i> Assessment</span>' +
                                    '<span class="menu-arrow"></span>' +
                                    '</a>' +
                                    '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">';

                                for (var j = 0; j < assesment.length; j++) {
                                    var kolom_tambahan = safelyParseJSON(assesment[j].kolom_tambahan);
                                    var nama_file = '';
                                    if (Array.isArray(kolom_tambahan)) {
                                        for (z = 0; z < kolom_tambahan.length; z++) {
                                            if (kolom_tambahan[z].field == 'nama_file') {
                                                nama_file = kolom_tambahan[z].value;
                                            }
                                        }
                                }
                                    list_assesment += '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'page/preview_dokumen/?file=' + base_url + assesment[j].path_file + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> <label class="cursor-pointer text-truncate">' + assesment[j].value + '</label></a>' +
                                        '</div>';
                                }
                                list_assesment += '</div>' +
                                    '</div>';
                            }


                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + list_data[i].nomor_order_payment + '</div>' +
                                render_badge_tipe_pengajuan(list_data[i].tipe_pengajuan) +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold fs-6" style="max-width: 350px; text-overflow:ellipsis;overflow: hidden;white-space: nowrap;">' + list_data[i].nama_badan_usaha + ' ' + list_data[i].nama_perusahaan + '</div>' +
                                (assesor_lapangan ? assesor_lapangan : 'Belum Ada Verifikator Lapangan') +
                                (orang_etc ? orang_etc : 'Belum Ada ETC') +
                                '</td>' +
                                '<td class="text-end pe-3">' +
                                '<div class="me-0">' +
                                '<button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-kt-menu="true" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">' +
                                'Actions' +
                                '</button>' +
                                '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true" style="">' +

                                '<div class="menu-item px-3">' +
                                '<a href="' + base_url + 'page/preview_dokumen/?file=' + base_url + list_data[i].dokumen_uiu_nib + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Ijin Usaha</a>' +
                                '</div>' +
                                list_draft_tanda_sah +
                                list_lhv +
                                list_assesment +

                                '<div class="separator mb-3 mt-3"></div>' +
                                '<div class="menu-item px-3">' +
                                '<a href="javascript:;" onclick="kirim_pelanggan(' + i + ')" class="menu-link px-3"><?php echo getSvgIcon('general/gen016', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Kirim Ke Pelanggan</a>' +
                                '</div>' +

                                '</div>' +
                                '</div>' +
                                '</td>' +
                                '</tr>';
                        }
                    }
                    console.log(rangkai)
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

        function kirim_pelanggan(i) {
            var pertanyaan = "Apakah Anda yakin ingin mengirimkan ke pelanggan?";

            konfirmasi(pertanyaan, function() {
                $("#setuju").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });
                proses_kirim_pelanggan(list_data[i].id_opening_meeting);
            });

        }

        function proses_kirim_pelanggan(id_opening_meeting) {
            if (id_opening_meeting) {
                //show loading animation...
                preloader('show');

                var data = new Object;
                data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
                data['id_opening_meeting'] = id_opening_meeting;

                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>opening_meeting_etc/kirim_pelanggan',
                    data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                    cache: false,
                    dataType: "json",
                    success: function(data) {
                        preloader('hide');

                        if (data.sts == 1) {
                            var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                            swalAlert(response);

                            load_data();
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }

                });
            }
        }
    </script>
</body>
<!-- end::Body -->

</html>