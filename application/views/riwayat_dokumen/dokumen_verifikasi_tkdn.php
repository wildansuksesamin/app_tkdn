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

                                <div class="card card-flush h-lg-100 tabel_zone" id="tabel_dokumen_permohonan">
                                    <div class="card-header align-items-center py-5 gap-2 gap-md-5" data-select2-id="select2-data-124-ftn2">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <!--begin::Search-->
                                            <div class="d-flex align-items-center position-relative my-1">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
                                                    </svg>
                                                </span>
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
                                        <div id="data_zona_dokumen_permohonan">
                                            <div class="d-flex flex-column flex-lg-row">
                                                <!--begin::Content-->
                                                <div class="flex-lg-row-fluid me-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-striped gy-5" id="data_dokumen_permohonan">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th>No</th>
                                                                    <th>Nomor Order</th>
                                                                    <th>Unit Kerja</th>
                                                                    <th>Pelanggan</th>
                                                                    <th>Status</th>
                                                                    <th style="min-width: 100px;">Action</th>
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

    <div class="modal fade" id="modal_riwayat_status" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <div id="riwayat_status-nama_perusahaan" class="text-gray-800 fw-bold mb-1 fs-5 text-start pe-0"></div>
                        <div id="riwayat_status-nomor_order_payment" class="text-gray-400 pt-1 fw-semibold fs-5"></div>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body bg-color">
                    <div id="riwayat_status-list_log" class="scroll mh-400px"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_bukti_bayar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <div id="bukti_bayar-nama_perusahaan" class="text-gray-800 fw-bold mb-1 fs-5 text-start pe-0"></div>
                        <div id="bukti_bayar-tipe_permohonan" class="text-gray-400 pt-1 fw-semibold fs-6"></div>
                        <div id="bukti_bayar-tgl_permohonan" class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0"></div>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <img src="" style="width: 100%; height: auto" id="bukti_bayar-display_bukti_bayar">
                    <a href="" id="bukti_bayar-bukti_bayar_download" download class="btn btn-sm fw-bold btn-primary mt-4">Download Bukti Bayar</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        function form_action(action) {
            //reset form...
            $("#input_form_dokumen_permohonan")[0].reset();
            $("#action").val('save');

            if (action == 'show') {
                $(".form_zone").fadeIn(300);
                $(".tabel_zone").hide();
            } else {
                $(".form_zone").hide();
                $(".tabel_zone").fadeIn(300);
            }
        }

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

        $("#filter").keyup(function() {
            $("#page").val(1);
            ajax_request.abort();
            load_data();
        });

        var ajax_request;

        function load_data() {
            var page = $("#page").val();
            var jml_data = 10;
            var filter = $("#filter").val();

            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['page'] = page;
            data['jml_data'] = jml_data;
            data['filter'] = filter;
            data['for'] = 'histori_dokumen_verifikasi';

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
                            var status_pengajuan = status_verifikasi_tkdn_badge(list_data[i].id_status);

                            var surat_tugas_lapangan = '';
                            if (list_data[i].surat_tugas_lapangan) {
                                surat_tugas_lapangan = '<div class="menu-item px-3">' +
                                    '<div class="menu-content px-3 text-gray-700">Surat Tugas</div>' +
                                    '</div>';
                                for (var x = 0; x < list_data[i].surat_tugas_lapangan.length; x++) {
                                    surat_tugas_lapangan += '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'page/lihat_surat_tugas/' + list_data[i].surat_tugas_lapangan[x].id_surat_tugas + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> ' + list_data[i].surat_tugas_lapangan[x].nomor_surat_tugas + '</a>' +
                                        '</div>';
                                };
                            }

                            var collecting_document_2 = '';
                            list_data[i].collecting_document_2?.map((item) => {
                                collecting_document_2 += '<div class="menu-item px-3">' +
                                    '<a href="' + base_url + item.path_file + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> ' + item.nama_file + '</a>' +
                                    '</div>';
                            })

                            var panel_internal = '';
                            if (list_data[i].panel_internal) {
                                var list_panel_internal = list_data[i].panel_internal;

                                list_panel_internal?.map((item, index) => {
                                    var nama_folder = item.nama_folder;
                                    var files = '';
                                    item.files?.map((item) => {
                                        var nama_file = '';
                                        var path_file = '';
                                        if (nama_folder == 'LHV') {
                                            nama_file = item.lhv_jns_produk;
                                            path_file = 'panel_internal/dokumen_lhv/' + item.id_panel_internal_lhv;
                                        } else {
                                            //mencari nama file...
                                            var kolom_tambahan = safelyParseJSON(item.kolom_tambahan);
                                            kolom_tambahan?.map((item) => {
                                                if (item.field == 'nama_file') {
                                                    nama_file = item.value;
                                                }
                                            })

                                            path_file = item.path_file;
                                        }

                                        files += '<div class="menu-item px-3">' +
                                            '<a href="' + base_url + path_file + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> ' + nama_file + '</a>' +
                                            '</div>';

                                    });

                                    panel_internal += '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="left-end">' +
                                        '<a href="#" class="menu-link px-3">' +
                                        '<span class="menu-title"><?php echo getSvgIcon('files/fil012', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> ' + nama_folder + '</span>' +
                                        '<span class="menu-arrow"></span>' +
                                        '</a>' +
                                        '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +
                                        files +
                                        '</div>' +
                                        '</div>';
                                })


                            }

                            var panel_kemenperin = '';
                            if (list_data[i].panel_kemenperin) {
                                var list_panel_kemenperin = list_data[i].panel_kemenperin;
                                list_panel_kemenperin?.map((item, index) => {
                                    panel_kemenperin += '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + item.path_file + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> ' + item.nama_file + '</a>' +
                                        '</div>';
                                });
                            }

                            var closing_meeting = '';
                            if (list_data[i].closing_meeting) {
                                if (list_data[i].closing_meeting['verifikator'] && list_data[i].id_status >= 29) {
                                    var files = '';
                                    list_data[i].closing_meeting['verifikator']?.map((item, index) => {
                                        var path_file = '';
                                        item.dokumen.map((dokumen, index) => {
                                            path_file = dokumen.path_file;
                                        });

                                        files += '<div class="menu-item px-3">' +
                                            '<a href="' + base_url + 'page/preview_dokumen/?file=' + base_url + path_file + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> ' + item.nama_file + '</a>' +
                                            '</div>';
                                    });

                                    closing_meeting += '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="left-end">' +
                                        '<a href="#" class="menu-link px-3">' +
                                        '<span class="menu-title"><?php echo getSvgIcon('files/fil012', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Verifikator</span>' +
                                        '<span class="menu-arrow"></span>' +
                                        '</a>' +
                                        '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +
                                        files +
                                        '</div>' +
                                        '</div>';
                                }

                                if (list_data[i].closing_meeting['pelanggan'] && list_data[i].id_status >= 30) {
                                    var files = '';
                                    list_data[i].closing_meeting['pelanggan']?.map((item, index) => {
                                        var path_file = '';
                                        item.dokumen.map((dokumen, index) => {
                                            path_file = dokumen.path_file;
                                        });

                                        files += '<div class="menu-item px-3">' +
                                            '<a href="' + base_url + 'page/preview_dokumen/?file=' + base_url + path_file + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> ' + item.nama_file + '</a>' +
                                            '</div>';
                                    });

                                    closing_meeting += '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="left-end">' +
                                        '<a href="#" class="menu-link px-3">' +
                                        '<span class="menu-title"><?php echo getSvgIcon('files/fil012', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Pelanggan</span>' +
                                        '<span class="menu-arrow"></span>' +
                                        '</a>' +
                                        '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +
                                        files +
                                        '</div>' +
                                        '</div>';
                                }
                            }

                            var btn_action = '<div class="me-0">' +
                                '<button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-kt-menu="true" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">' +
                                'Actions' +
                                '</button>' +
                                '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-250px py-3" data-kt-menu="true" style="">' +

                                //Pelanggan
                                '<div class="menu-item px-3">' +
                                '<a href="' + base_url + 'page/profil_pelanggan/' + list_data[i].id_pelanggan + '" class="menu-link px-3"><?php echo getSvgIcon('communication/com006', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> pelanggan</a>' +
                                '</div>' +

                                //RAB
                                (list_data[i].id_rab ?
                                    '<div class="menu-item px-3">' +
                                    '<a href="' + base_url + 'page/lihat_detail_rab/' + list_data[i].id_rab + '" class="menu-link px-3"><?php echo getSvgIcon('finance/fin007', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> RAB</a>' +
                                    '</div>' :
                                    '') +

                                '<div class="separator mb-3 mt-3"></div>' +

                                '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                '<a href="#" class="menu-link px-3">' +
                                '<span class="menu-title">Permohonan TKDN</span>' +
                                '<span class="menu-arrow"></span>' +
                                '</a>' +
                                '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +

                                //Dokumen Permohonan
                                '<div class="menu-item px-3">' +
                                '<a href="' + base_url + 'page/detail_dokumen_permohonan/' + list_data[i].id_dokumen_permohonan + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Dokumen Permohonan</a>' +
                                '</div>' +

                                //Surat Penawaran
                                (list_data[i].id_surat_penawaran ?
                                    '<div class="menu-item px-3">' +
                                    '<a href="' + base_url + 'page/lihat_surat_penawaran/' + list_data[i].id_surat_penawaran + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Surat Penawaran</a>' +
                                    '</div>' :
                                    '') +
                                //Konfirmasi Order
                                (list_data[i].id_surat_oc && list_data[i].tipe_pengajuan != 'PEMERINTAH' ?
                                    '<div class="menu-item px-3">' +
                                    '<a href="' + base_url + 'page/lihat_oc/' + list_data[i].id_surat_oc + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Konfirmasi Order</a>' +
                                    '</div>' :
                                    '') +

                                //Lihat Proforma Invoice
                                (list_data[i].id_proforma_invoice ?
                                    '<div class="menu-item px-3">' +
                                    '<a href="' + base_url + 'page/lihat_proforma_invoice/' + list_data[i].id_proforma_invoice + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Lihat Proforma Invoice</a>' +
                                    '</div>' :
                                    '') +

                                //Konfirmasi Order Pelanggan
                                (list_data[i].id_surat_oc && list_data[i].tipe_pengajuan != 'PEMERINTAH' ?
                                    '<div class="menu-item px-3">' +
                                    '<a href="' + base_url + 'page/lihat_oc_pelanggan/' + list_data[i].id_surat_oc + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Konfirmasi Order Pelanggan</a>' +
                                    '</div>' :
                                    '') +

                                //Bukti Bayar
                                (list_data[i].id_surat_oc && list_data[i].tipe_pengajuan != 'PEMERINTAH' && list_data[i].termin_1 > 0 ?
                                    '<div class="menu-item px-3">' +
                                    '<a href="javascript:;" onclick="lihat_bukti_bayar(' + i + ')" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Bukti Bayar</a>' +
                                    '</div>' :
                                    '') +

                                //Form 01
                                (list_data[i].id_form_01 ?
                                    '<div class="menu-item px-3">' +
                                    '<a href="' + base_url + 'page/lihat_form_01/' + list_data[i].id_surat_oc + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Form 01</a>' +
                                    '</div>' :
                                    '') +

                                //Payment Detail
                                (list_data[i].id_payment_detail ?
                                    '<div class="menu-item px-3">' +
                                    '<a href="' + base_url + 'page/lihat_payment_detail/' + list_data[i].id_payment_detail + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Payment Detail</a>' +
                                    '</div>' :
                                    '') +

                                //Invoice
                                (list_data[i].id_payment_detail ?
                                    '<div class="menu-item px-3">' +
                                    '<a href="' + base_url + 'page/lihat_invoice/' + list_data[i].id_payment_detail + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Invoice</a>' +
                                    '</div>' :
                                    '') +

                                //Faktur Pajak
                                (list_data[i].id_payment_detail ?
                                    '<div class="menu-item px-3">' +
                                    '<a href="' + base_url + 'page/lihat_faktur_pajak/' + list_data[i].id_payment_detail + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Faktur Pajak</a>' +
                                    '</div>' :
                                    '') +

                                //Bukti Potong PPh 21
                                (list_data[i].id_payment_detail && list_data[i].bukti_potong_pph21 ?
                                    '<div class="menu-item px-3">' +
                                    '<a href="' + base_url + 'page/lihat_bukti_potong_pph_21/' + list_data[i].id_payment_detail + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Bukti Potong PPh 21</a>' +
                                    '</div>' :
                                    '') +

                                '</div>' +
                                '</div>' +

                                (list_data[i].id_status >= 2 ?
                                    '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                    '<a href="#" class="menu-link px-3">' +
                                    '<span class="menu-title">Opening Meeting</span>' +
                                    '<span class="menu-arrow"></span>' +
                                    '</a>' +
                                    '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +


                                    (list_data[i].surat_tugas ?
                                        //Download Surat Tugas
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'page/lihat_surat_tugas/' + list_data[i].surat_tugas.id_surat_tugas + '" class="menu-link px-3"><?php echo getSvgIcon('arrows/arr044', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Download Surat Tugas</a>' +
                                        '</div>' :
                                        '') +

                                    (list_data[i].id_status >= 4 ?
                                        '<div class="separator mb-3 mt-3"></div>' +
                                        //Download Surat Tugas Assesor
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + list_data[i].surat_tugas_assesor + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Surat Tugas Verifikator</a>' +
                                        '</div>' +
                                        //Download Risalah Rapat Assesor
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + list_data[i].risalah_rapat_assesor + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Risalah Rapat Verifikator</a>' +
                                        '</div>' +
                                        //Download Hadir Rapat Assesor
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + list_data[i].hadir_rapat_assesor + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Hadir Rapat Verifikator</a>' +
                                        '</div>' :
                                        '') +

                                    (list_data[i].id_status >= 5 ?
                                        '<div class="separator mb-3 mt-3"></div>' +
                                        //Download Surat Tugas Pelanggan
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + list_data[i].surat_tugas_pelanggan + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Surat Tugas Pelanggan</a>' +
                                        '</div>' +
                                        //Download Risalah Rapat Pelanggan
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + list_data[i].risalah_rapat_pelanggan + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Risalah Rapat Pelanggan</a>' +
                                        '</div>' +
                                        //Download Hadir Rapat Pelanggan
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + list_data[i].hadir_rapat_pelanggan + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Hadir Rapat Pelanggan</a>' +
                                        '</div>' :
                                        '') +
                                    '</div>' +
                                    '</div>' :
                                    '') +

                                //Collecting Dokumen

                                (list_data[i].id_status >= 10 ? '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                    '<a href="#" class="menu-link px-3">' +
                                    '<span class="menu-title">Collecting Document</span>' +
                                    '<span class="menu-arrow"></span>' +
                                    '</a>' +
                                    '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +

                                    //Buka Folder Collecting Dokumen
                                    (list_data[i].id_status >= 15 ?
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'page/folder_collecting_document/' + list_data[i].id_opening_meeting + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil012', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Folder Collecting Document</a>' +
                                        '</div>' :
                                        '') +

                                    (list_data[i].surat_pemberitahuan_pemenuhan_dokumen && list_data[i].id_status >= 10 ?
                                        //Surat Pemberitahuan Pemenuhan Dokumen
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'page/lihat_pemberitahuan_pemenuhan_dokumen/' + list_data[i].id_opening_meeting + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Surat Pemberitahuan Pemenuhan Dokumen</a>' +
                                        '</div>' :
                                        '') +
                                    (list_data[i].surat_pemberitahuan_pemenuhan_dokumen && list_data[i].id_status >= 11 ?
                                        //Surat Pemberitahuan Pemenuhan Dokumen
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'page/lihat_surat_permohonan_perpanjangan_waktu/' + list_data[i].id_opening_meeting + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Surat Permohonan Perpanjangan Waktu</a>' +
                                        '</div>' :
                                        '') +

                                    '</div>' +
                                    '</div>' :
                                    '') +

                                //survey lapangan
                                (list_data[i].id_status > 15 && list_data[i].surat_tugas_lapangan.length > 0 ? '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                    '<a href="#" class="menu-link px-3">' +
                                    '<span class="menu-title">Survey Lapangan</span>' +
                                    '<span class="menu-arrow"></span>' +
                                    '</a>' +
                                    '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +
                                    surat_tugas_lapangan +
                                    '</div>' +
                                    '</div>' :
                                    '') +

                                //Collecting Document II
                                (list_data[i].id_status >= 16 ?
                                    '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                    '<a href="#" class="menu-link px-3">' +
                                    '<span class="menu-title">Collecting Document II</span>' +
                                    '<span class="menu-arrow"></span>' +
                                    '</a>' +
                                    '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +
                                    collecting_document_2 +
                                    '</div>' +
                                    '</div>' :
                                    '') +
                                //Panel Internal
                                (list_data[i].id_status >= 20 ?
                                    '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                    '<a href="#" class="menu-link px-3">' +
                                    '<span class="menu-title">Panel Internal</span>' +
                                    '<span class="menu-arrow"></span>' +
                                    '</a>' +
                                    '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +
                                    panel_internal +
                                    '</div>' +
                                    '</div>' :
                                    '') +
                                //Panel Kemenperin
                                (list_data[i].id_status >= 25 ?
                                    '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                    '<a href="#" class="menu-link px-3">' +
                                    '<span class="menu-title">Panel Kemenperin</span>' +
                                    '<span class="menu-arrow"></span>' +
                                    '</a>' +
                                    '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +
                                    panel_kemenperin +
                                    '</div>' +
                                    '</div>' :
                                    '') +

                                //Closing Meeting...
                                (list_data[i].id_status >= 29 ?
                                    '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                    '<a href="#" class="menu-link px-3">' +
                                    '<span class="menu-title">Closing Meeting</span>' +
                                    '<span class="menu-arrow"></span>' +
                                    '</a>' +
                                    '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +
                                    closing_meeting +
                                    '</div>' +
                                    '</div>' :
                                    '') +


                                '<div class="separator mb-3 mt-3"></div>' +

                                //Riwayat Status
                                '<div class="menu-item px-3">' +
                                '<a href="javascript:;" onclick="riwayat_status(' + i + ')" class="menu-link px-3"><?php echo getSvgIcon('text/txt010', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Riwayat Status</a>' +
                                '</div>' +

                                '</div>' +
                                '</div>';

                            var asisten_assesor = '';
                            if (list_data[i].asisten_assesor) {
                                asisten_assesor = '<div class="mt-3 fs-7 fw-bold">Asisten Verifikator:</div>';
                                for (var j = 0; j < list_data[i].asisten_assesor.length; j++) {
                                    asisten_assesor += '<span class="badge badge-light-primary">' + list_data[i].asisten_assesor[j].nama_admin + '</span>';
                                }
                            }

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

                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + list_data[i].nomor_order_payment + '</div>' +
                                render_badge_tipe_pengajuan(list_data[i].tipe_pengajuan) +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6"><?php echo $cabang; ?></div>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7">' + list_data[i].sub_unit_kerja + '</div>' +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold fs-6" style="max-width: 200px; text-overflow:ellipsis;overflow: hidden;white-space: nowrap;">' + list_data[i].nama_badan_usaha + ' ' + list_data[i].nama_perusahaan + '</div>' +
                                '<div class="mt-3 fs-7 fw-bold">Verifikator Opening Meeting:</div>' +
                                render_assesor(coverMe(list_data[i].nama_admin, 'Belum Ada')) +
                                asisten_assesor +
                                assesor_lapangan +
                                orang_etc +
                                '</td>' +
                                '<td>' + status_pengajuan + '</td>' +
                                '<td style="padding-top: 10px;">' + btn_action + '</td>' +
                                '</tr>';
                        }
                    }


                    if (rangkai) {
                        $("#empty_state").remove();
                        $("#data_zona_dokumen_permohonan").show();

                        $("#data_dokumen_permohonan tbody").html(rangkai);
                        KTMenu.createInstances();
                    } else {
                        if (page == 1 && filter == '') {
                            create_empty_state("#data_zona_dokumen_permohonan");
                        } else
                            $("#data_dokumen_permohonan tbody").html('');
                    }

                }

            });
        }
        load_data();

        function lihat_bukti_bayar(i) {
            var data = list_data[i];
            var id_dokumen_permohonan = data.id_dokumen_permohonan;
            var nama_perusahaan = data.nama_badan_usaha + ' ' + data.nama_perusahaan;
            $("#bukti_bayar-nama_perusahaan").html(nama_perusahaan);
            $("#bukti_bayar-tipe_permohonan").html(data.nama_tipe_permohonan);
            $("#bukti_bayar-tgl_permohonan").html(reformatDate(data.tgl_pengajuan, 'DD MMMM YYYY'));

            $("#bukti_bayar-bukti_bayar_download").attr('href', base_url + data.bukti_bayar);
            $("#bukti_bayar-display_bukti_bayar")
                .on('error', function() {
                    $("#bukti_bayar-bukti_bayar_download").attr('href', '#');
                    $(this).attr('src', '<?php echo base_url($no_photo_url); ?>');
                })
                .attr('src', base_url + data.bukti_bayar);
            $("#modal_bukti_bayar").modal('show');
        }

        function riwayat_status(i) {
            var data = list_data[i];
            var id_opening_meeting = data.id_opening_meeting;
            var nama_perusahaan = data.nama_badan_usaha + ' ' + data.nama_perusahaan;
            $("#riwayat_status-nama_perusahaan").html(nama_perusahaan);
            $("#riwayat_status-nomor_order_payment").html(data.nomor_order_payment);
            preloader('show');
            $("#empty_state").remove();

            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>verifikasi_tkdn/log_status',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(list) {
                    preloader('hide');
                    if (list.length > 0) {
                        var rangkai = '';
                        for (var i = 0; i < list.length; i++) {
                            rangkai += '<div class="card mb-3">' +
                                '<div class="card-body">' +
                                status_verifikasi_tkdn_badge(list[i].id_status) +
                                (list[i].alasan_status ? '<div class="align-items-center py-2">' + list[i].alasan_status + '</div>' : '') +
                                '<div class="text-muted font-weight-bold fs-8 pt-3">' +
                                reformatDate(list[i].tgl_log_status) +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        }
                        $("#riwayat_status-list_log").html(rangkai);
                    } else {
                        create_empty_state("#riwayat_status-list_log");
                    }

                    $("#modal_riwayat_status").modal('show');
                }
            })
        }
    </script>
</body>
<!-- end::Body -->

</html>