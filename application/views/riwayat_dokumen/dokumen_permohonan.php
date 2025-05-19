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
                                        Riwayat Permohonan
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
                                                                    <th>Perusahaan</th>
                                                                    <th>Tipe Permohonan</th>
                                                                    <th>Tanggal Permohonan</th>
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
    <div class="modal fade" id="modal_assesor" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <div id="modal_assesor-nama_perusahaan" class="text-gray-800 fw-bold mb-1 fs-5 text-start pe-0"></div>
                        <div id="modal_assesor-tipe_permohonan" class="text-gray-400 pt-1 fw-semibold fs-6"></div>
                        <div id="modal_assesor-tgl_permohonan" class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0"></div>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="data_zona_assesor_modal" class="table-responsive">
                        <div id="modal_assesor-list_assesor"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_riwayat_status" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <div id="riwayat_status-nama_perusahaan" class="text-gray-800 fw-bold mb-1 fs-5 text-start pe-0"></div>
                        <div id="riwayat_status-tipe_permohonan" class="text-gray-400 pt-1 fw-semibold fs-6"></div>
                        <div id="riwayat_status-tgl_permohonan" class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0"></div>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body bg-color">
                    <div id="riwayat_status-list_log" style="max-height: 400px; overflow: auto"></div>
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

            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>dokumen_permohonan/load_data',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    //parse JSON...
                    $("#last_page").val(result.last_page);
                    generatePages('#pagination', page, result.last_page);
                    list_data = result.result;

                    var rangkai = '';
                    if (list_data.length > 0) {
                        for (var i = 0; i < list_data.length; i++) {
                            var status_pengajuan = '';
                            if (list_data[i].status_pengajuan == 8) {
                                if (list_data[i].surat_penawaran.butuh_verifikasi_koordinator == 1) {
                                    // butuh verifikasi koordinator...
                                    status_pengajuan = '<div>' + render_badge('warning', 'Dalam Pengecekan') + '</div><div class="fw-bold text-gray-800 fs-7 mt-2"><i class="fa fa-user-circle text-primary me-3"></i> Koordiantor</div>';
                                } else {
                                    status_pengajuan = status_pengajuan_badge(list_data[i].status_pengajuan);
                                }
                            } else {
                                status_pengajuan = status_pengajuan_badge(list_data[i].status_pengajuan);
                            }
                            var btn_action = '<div class="dropdown">' +
                                '<button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-boundary="viewport" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                'Actions' +
                                '</button>' +
                                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
                                '<a class="dropdown-item" href="#" onclick="list_assesor(' + i + ')"><?php echo getSvgIcon('communication/com006', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Verifikator</a>' +
                                (list_data[i].id_rab ? '<a class="dropdown-item" href="' + base_url + 'page/lihat_detail_rab/' + list_data[i].id_rab + '"><?php echo getSvgIcon('finance/fin007', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> RAB</a>' : '') +
                                '<div class="separator mb-3 mt-3"></div>' +
                                '<a class="dropdown-item" href="' + base_url + 'page/detail_dokumen_permohonan/' + list_data[i].id_dokumen_permohonan + '"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Dokumen Permohonan</a>' +
                                (list_data[i].surat_penawaran ? '<a class="dropdown-item" href="' + base_url + 'page/lihat_surat_penawaran/' + list_data[i].surat_penawaran.id_rab + '"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Surat Penawaran</a>' : '') +
                                (list_data[i].surat_oc && list_data[i].tipe_pengajuan != 'PEMERINTAH' ? '<a class="dropdown-item" href="' + base_url + 'page/lihat_oc/' + list_data[i].surat_oc.id_surat_oc + '"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Konfirmasi Order</a>' : '') +
                                (list_data[i].proforma_invoice && list_data[i].status_pengajuan >= 21 ? '<a class="dropdown-item" href="' + base_url + 'page/lihat_proforma_invoice/' + list_data[i].proforma_invoice.id_proforma_invoice + '"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Lihat Proforma Invoice</a>' : '') +
                                (list_data[i].surat_oc && list_data[i].tipe_pengajuan != 'PEMERINTAH' && list_data[i].status_pengajuan >= 25 ? '<a class="dropdown-item" href="' + base_url + 'page/lihat_oc_pelanggan/' + list_data[i].surat_oc.id_surat_oc + '"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Konfirmasi Order Pelanggan</a>' : '') +
                                (list_data[i].surat_oc && list_data[i].tipe_pengajuan != 'PEMERINTAH' && list_data[i].status_pengajuan >= 25 && list_data[i].surat_penawaran.termin_1 > 0 ? '<a class="dropdown-item" href="javascript:;" onclick="lihat_bukti_bayar(' + i + ')"><?php echo getSvgIcon('finance/fin003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Bukti Bayar</a>' : '') +
                                (list_data[i].form_01 && list_data[i].status_pengajuan >= 30 ? '<a class="dropdown-item" href="' + base_url + 'page/lihat_form_01/' + list_data[i].surat_oc.id_surat_oc + '"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Form 01</a>' : '') +
                                (list_data[i].payment_detail && list_data[i].status_pengajuan >= 33 ? '<a class="dropdown-item" href="' + base_url + 'page/lihat_payment_detail/' + list_data[i].payment_detail.id_payment_detail + '"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Payment Detail</a>' : '') +
                                (list_data[i].payment_detail && list_data[i].status_pengajuan >= 34 ? '<a class="dropdown-item" href="' + base_url + 'page/lihat_invoice/' + list_data[i].payment_detail.id_payment_detail + '"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Invoice</a>' : '') +
                                (list_data[i].payment_detail && list_data[i].status_pengajuan >= 34 ? '<a class="dropdown-item" href="' + base_url + 'page/lihat_faktur_pajak/' + list_data[i].payment_detail.id_payment_detail + '"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Faktur Pajak</a>' : '') +
                                (list_data[i].payment_detail && list_data[i].status_pengajuan >= 34 && list_data[i].payment_detail.bukti_potong_pph21 ? '<a class="dropdown-item" href="' + base_url + 'page/lihat_bukti_potong_pph_23/' + list_data[i].payment_detail.id_payment_detail + '"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Bukti Potong PPh 23</a>' : '') +
                                '<div class="separator mb-3 mt-3"></div>' +
                                '<a class="dropdown-item" href="#" onclick="riwayat_status(' + i + ')"><?php echo getSvgIcon('text/txt010', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Riwayat Status</a>' +
                                ((list_data[i].status_pengajuan != 99 && '<?php echo $this->session->userdata('id_jns_admin'); ?>' == '2') ? '<div class="separator mb-3 mt-3"></div>' +
                                    '<a class="dropdown-item text-danger" href="#" onclick="batalkan_permohonan(' + i + ')"><?php echo getSvgIcon('general/gen027', 'svg-icon svg-icon-2 svg-icon-danger me-3'); ?> Batalkan Permohonan</a>' :
                                    '') +
                                '</div>' +
                                '</div>';

                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +
                                '<td style="max-width: 200px; text-overflow:ellipsis;overflow: hidden;white-space: nowrap;">' + list_data[i].nama_badan_usaha + ' ' + list_data[i].nama_perusahaan + '</td>' +
                                '<td><div>' + coverMe(list_data[i].nama_tipe_permohonan) + '</div>' + render_badge_tipe_pengajuan(list_data[i].tipe_pengajuan) + '</td>' +
                                '<td>' + reformatDate(list_data[i].tgl_pengajuan, 'DD MMMM YYYY') + '</td>' +
                                '<td>' + status_pengajuan + '</td>' +
                                '<td style="padding-top: 10px;">' + btn_action + '</td>' +
                                '</tr>';
                        }
                    }

                    if (rangkai) {
                        $("#empty_state").remove();
                        $("#data_zona_dokumen_permohonan").show();

                        $("#data_dokumen_permohonan tbody").html(rangkai);
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

        function list_assesor(i) {
            var data = list_data[i];
            var id_dokumen_permohonan = data.id_dokumen_permohonan;
            var nama_perusahaan = data.nama_badan_usaha + ' ' + data.nama_perusahaan;
            $("#modal_assesor-nama_perusahaan").html(nama_perusahaan);
            $("#modal_assesor-tipe_permohonan").html(data.nama_tipe_permohonan);
            $("#modal_assesor-tgl_permohonan").html(reformatDate(data.tgl_pengajuan, 'DD MMMM YYYY'));

            preloader('show');
            $("#empty_state").remove();
            $("#data_zona_assesor_modal").show();

            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['id_dokumen_permohonan'] = id_dokumen_permohonan;
            data['id_jns_admin'] = 3; //ini adalah ID untuk assesor
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>dokumen_permohonan_pic/load_data',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    var list = result.result;

                    preloader('hide');
                    if (list.length > 0) {
                        var rangkai = '';
                        for (var i = 0; i < list.length; i++) {
                            rangkai += '<div class="d-flex flex-stack">' +
                                '<div class="symbol symbol-40px me-5">' +
                                '<img src="' + base_url + list[i].foto_admin + '" class="h-50 align-self-center" alt="" <?php echo $no_avatar_for_js; ?>>' +
                                '</div>' +
                                '<div class="d-flex align-items-center flex-row-fluid flex-wrap">' +
                                '<div class="flex-grow-1 me-2">' +
                                '<a href="javascript:;" class="text-gray-800 text-hover-primary fs-6 fw-bold">' + list[i].nama_admin + '</a>' +
                                '<span class="text-muted fw-semibold d-block fs-7">' + list[i].jns_admin + '</span>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        }
                        $("#modal_assesor-list_assesor").html(rangkai);
                    } else {
                        create_empty_state("#data_zona_assesor_modal");
                    }

                    $("#modal_assesor").modal('show');
                }
            })
        }

        function riwayat_status(i) {
            var data = list_data[i];
            var id_dokumen_permohonan = data.id_dokumen_permohonan;
            var nama_perusahaan = data.nama_badan_usaha + ' ' + data.nama_perusahaan;
            $("#riwayat_status-nama_perusahaan").html(nama_perusahaan);
            $("#riwayat_status-tipe_permohonan").html(data.nama_tipe_permohonan);
            $("#riwayat_status-tgl_permohonan").html(reformatDate(data.tgl_pengajuan, 'DD MMMM YYYY'));
            preloader('show');
            $("#empty_state").remove();

            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['id_dokumen_permohonan'] = id_dokumen_permohonan;
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>log_verifikasi/load_data',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(list) {
                    preloader('hide');
                    if (list.length > 0) {
                        var rangkai = '';
                        var status_verifikasi_sebelumnya = '';
                        for (var i = 0; i < list.length; i++) {
                            var manual_pic = '';
                            if (status_verifikasi_sebelumnya == 8 && list[i].status_verifikasi == 8) {
                                manual_pic = 'Koordinator';
                            }
                            rangkai += '<div class="card mb-3">' +
                                '<div class="card-body">' +
                                status_pengajuan_badge(list[i].status_verifikasi, manual_pic) +
                                (list[i].log_alasan ? '<div class="align-items-center py-2">' + list[i].log_alasan + '</div>' : '') +
                                '<div class="text-muted font-weight-bold fs-8 pt-3">' +
                                reformatDate(list[i].tgl_verifikasi) +
                                '</div>' +
                                '</div>' +
                                '</div>';
                            status_verifikasi_sebelumnya = list[i].status_verifikasi;
                            // console.log();
                        }
                        $("#riwayat_status-list_log").html(rangkai);
                    } else {
                        create_empty_state("#riwayat_status-list_log");
                    }

                    $("#modal_riwayat_status").modal('show');
                }
            })
        }

        function lihat_bukti_bayar(i) {
            var data = list_data[i];
            var id_dokumen_permohonan = data.id_dokumen_permohonan;
            var nama_perusahaan = data.nama_badan_usaha + ' ' + data.nama_perusahaan;
            $("#bukti_bayar-nama_perusahaan").html(nama_perusahaan);
            $("#bukti_bayar-tipe_permohonan").html(data.nama_tipe_permohonan);
            $("#bukti_bayar-tgl_permohonan").html(reformatDate(data.tgl_pengajuan, 'DD MMMM YYYY'));

            var ext = data.surat_oc.bukti_bayar.split(".").pop();

            $("#bukti_bayar-bukti_bayar_download").attr('href', base_url + data.surat_oc.bukti_bayar);
            if (ext == 'pdf') {
                $("#bukti_bayar-display_bukti_bayar").hide();
            } else {
                $("#bukti_bayar-display_bukti_bayar").show();
                $("#bukti_bayar-display_bukti_bayar")
                    .on('error', function() {
                        $("#bukti_bayar-bukti_bayar_download").attr('href', '#');
                        $(this).attr('src', '<?php echo base_url($no_photo_url); ?>');
                    })
                    .attr('src', base_url + data.surat_oc.bukti_bayar);
            }

            $("#modal_bukti_bayar").modal('show');
        }

        function batalkan_permohonan(i) {
            var data = list_data[i];

            var pertanyaan = "Apakah Anda yakin ingin membatalkan permohonan dari <strong>" + data.nama_badan_usaha + ' ' + data.nama_perusahaan + "</strong>?";

            swal.fire({
                title: 'Pembatalan Permohonan',
                html: pertanyaan,
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
                    proses_batalkan_permohonan(data.id_dokumen_permohonan, result.value);
                }

            });
        }

        function proses_batalkan_permohonan(id_dokumen_permohonan, alasan_verifikasi) {
            preloader('show');
            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_dokumen_permohonan'] = id_dokumen_permohonan;
            data['alasan_verifikasi'] = alasan_verifikasi;
            data['from'] = 'dokumen_permohonan';

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>dokumen_permohonan/batalkan_permohonan',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    preloader('hide');

                    if (data.sts == 1) {
                        //load data..
                        load_data();
                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        toastrAlert(response);
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
    </script>
</body>
<!-- end::Body -->

</html>