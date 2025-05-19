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
                                                <?php echo getSvgIcon('general/gen021', 'svg-icon svg-icon-1 position-absolute ms-4'); ?>
                                                <!--end::Svg Icon-->
                                                <input type="text" class="form-control form-control-solid w-250px ps-14" id="filter" name="filter" placeholder="Masukkan kata kunci pencarian">
                                            </div>
                                            <!--end::Search-->
                                            <div class="d-flex align-items-center position-relative my-1 ms-2">
                                                <?php echo getSvgIcon('text/txt010', 'svg-icon svg-icon-1 position-absolute ms-4'); ?>
                                                <select class="form-control form-control-solid"></select>
                                                <select id="field_sort" name="field_sort" class="form-select form-select-solid" data-control="select2">
                                                    <option value="dokumen_permohonan.id_dokumen_permohonan">Tanggal Permohonan</option>
                                                    <option value="nama_perusahaan">Nama Perusahaan</option>
                                                    <option value="tanggal_invoice">Tanggal Invoice</option>
                                                </select>
                                            </div>
                                            <div class="d-flex align-items-center position-relative my-1 ms-2">
                                                <?php echo getSvgIcon('arrows/arr082', 'svg-icon svg-icon-1 position-absolute ms-4'); ?>
                                                <select class="form-control form-control-solid"></select>
                                                <select id="field_order" name="field_order" class="form-select form-select-solid" data-control="select2">
                                                    <option value="DESC">Descending</option>
                                                    <option value="ASC">Ascending</option>
                                                </select>
                                            </div>
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
                                                                    <th>Tanggal Invoice</th>
                                                                    <th>Termin Pembayaran</th>
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
                    <iframe style="width: 100%; height: 400px" id="bukti_bayar-display_bukti_bayar_pdf"></iframe>
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
        $("#field_sort, #field_order").change(function() {
            $("#page").val(1);
            ajax_request.abort();

            load_data();
        });

        var ajax_request;

        function load_data() {
            var page = $("#page").val();
            var jml_data = 10;
            var filter = $("#filter").val();
            var field_sort = $("#field_sort").val();
            var field_order = $("#field_order").val();

            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['page'] = page;
            data['jml_data'] = jml_data;
            data['filter'] = filter;
            data['field_sort'] = field_sort;
            data['field_order'] = field_order;
            data['from'] = 'riwayat_permohonan';

            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>dokumen_permohonan/riwayat_pembayaran',
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
                            var rupiah_termin_1 = 0;
                            var rupiah_termin_2 = 0;

                            if (list_data[i].termin_1 > 0) {
                                rupiah_termin_1 = (list_data[i].termin_1 / 100) * list_data[i].nilai_kontrak;
                            }
                            if (list_data[i].termin_2 > 0) {
                                rupiah_termin_2 = (list_data[i].termin_2 / 100) * list_data[i].nilai_kontrak;
                            }

                            var btn_action = '<div class="dropdown">' +
                                '<button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-boundary="viewport" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                'Actions' +
                                '</button>' +
                                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
                                (list_data[i].tipe_pengajuan != 'PEMERINTAH' && list_data[i].status_pengajuan >= 25 && list_data[i].termin_1 > 0 ? '<a class="dropdown-item" href="javascript:;" onclick="lihat_bukti_bayar(' + i + ')"><?php echo getSvgIcon('finance/fin003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Bukti Bayar Termin I</a>' : '') +
                                (list_data[i].tipe_pengajuan != 'PEMERINTAH' && list_data[i].status_pengajuan >= 34 && list_data[i].id_payment_detail && list_data[i].invoice ? '<a class="dropdown-item" href="' + base_url + 'page/lihat_invoice/' + list_data[i].id_payment_detail + '" target="_blank"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Invoice</a>' : '') +
                                (list_data[i].tipe_pengajuan != 'PEMERINTAH' && list_data[i].status_pengajuan >= 34 && list_data[i].id_payment_detail && list_data[i].faktur_pajak ? '<a class="dropdown-item" href="' + base_url + 'page/lihat_faktur_pajak/' + list_data[i].id_payment_detail + '" target="_blank"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Faktur Pajak</a>' : '') +
                                (list_data[i].tipe_pengajuan != 'PEMERINTAH' && list_data[i].status_pengajuan >= 34 && list_data[i].id_payment_detail && list_data[i].bukti_potong_pph21 ? '<a class="dropdown-item" href="' + base_url + 'page/lihat_bukti_potong_pph_23/' + list_data[i].id_payment_detail + '" target="_blank"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Bukti Potong PPh 23</a>' : '') +
                                '</div>' +
                                '</div>';

                            var badge_dokumen = '';
                            badge_dokumen += (list_data[i].tipe_pengajuan != 'PEMERINTAH' && list_data[i].status_pengajuan >= 34 && list_data[i].id_payment_detail && list_data[i].invoice ? '<div>' + render_badge('success', 'Invoice Terbit') + '</div>' : '');
                            badge_dokumen += (list_data[i].tipe_pengajuan != 'PEMERINTAH' && list_data[i].status_pengajuan >= 34 && list_data[i].id_payment_detail && list_data[i].faktur_pajak ? '<div>' + render_badge('info', 'Faktur Pajak Terbit') + '</div>' : '');

                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +
                                '<td style="max-width: 200px; text-overflow:ellipsis;overflow: hidden;white-space: nowrap;">' +
                                '<a href="' + base_url + 'page/profil_pelanggan/' + list_data[i].id_pelanggan + '" class="fw-bold" target="_blank">' + list_data[i].nama_badan_usaha + ' ' + list_data[i].nama_perusahaan + '</a>' +

                                '<div class="text-gray-400 fw-semibold d-block fs-7">Nomor OC</div>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + coverMe(list_data[i].nomor_oc, 'Belum Ada') + '</div>' +
                                badge_dokumen +

                                '</td>' +
                                '<td>' +
                                '<div>' + coverMe(list_data[i].nama_tipe_permohonan) + '</div>' +
                                render_badge_tipe_pengajuan(list_data[i].tipe_pengajuan) +
                                '<div class="text-gray-400 fw-semibold d-block fs-7">Nomor Invoice</div>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + coverMe(list_data[i].nomor_invoice, 'Belum Ada') + '</div>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7">Nomor Faktur Pajak</div>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + coverMe(list_data[i].nomor_faktur_pajak, 'Belum Ada') + '</div>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7">Verifikator</div>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + list_data[i].assesor.nama_admin + '</div>' +

                                '</td>' +
                                '<td>' + reformatDate(list_data[i].tgl_pengajuan, 'DD MMMM YYYY') + '</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + (list_data[i].tanggal_invoice ? reformatDate(list_data[i].tanggal_invoice) : 'Belum Ada') + '</div>' +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7">TERMIN I (' + coverMe(list_data[i].termin_1) + '%)</div>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">Rp ' + rupiah(rupiah_termin_1) + '</div>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7">TERMIN II (' + coverMe(list_data[i].termin_2) + '%)</div>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">Rp ' + rupiah(rupiah_termin_2) + '</div>' +
                                '</td>' +
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

        function lihat_bukti_bayar(i) {
            var data = list_data[i];
            var id_dokumen_permohonan = data.id_dokumen_permohonan;
            var nama_perusahaan = data.nama_badan_usaha + ' ' + data.nama_perusahaan;
            $("#bukti_bayar-nama_perusahaan").html(nama_perusahaan);
            $("#bukti_bayar-tipe_permohonan").html(data.nama_tipe_permohonan);
            $("#bukti_bayar-tgl_permohonan").html(reformatDate(data.tgl_pengajuan, 'DD MMMM YYYY'));

            const fileExt = data.bukti_bayar.split(".").pop();
            $("#bukti_bayar-display_bukti_bayar, #bukti_bayar-display_bukti_bayar_pdf").hide();
            $("#bukti_bayar-display_bukti_bayar, #bukti_bayar-display_bukti_bayar_pdf").attr('src', '');
            $("#bukti_bayar-bukti_bayar_download").attr('href', '#');

            if (fileExt == 'pdf') {
                $("#bukti_bayar-display_bukti_bayar_pdf").show();
                $("#bukti_bayar-bukti_bayar_download").attr('href', base_url + data.bukti_bayar);
                $("#bukti_bayar-display_bukti_bayar_pdf").attr('src', base_url + data.bukti_bayar);
            } else {
                $("#bukti_bayar-display_bukti_bayar").show();
                $("#bukti_bayar-bukti_bayar_download").attr('href', base_url + data.bukti_bayar);
                $("#bukti_bayar-display_bukti_bayar")
                    .on('error', function() {
                        $("#bukti_bayar-bukti_bayar_download").attr('href', '#');
                        $(this).attr('src', '<?php echo base_url($no_photo_url); ?>');
                    })
                    .attr('src', base_url + data.bukti_bayar);
            }
            $("#modal_bukti_bayar").modal('show');
        }
    </script>
</body>
<!-- end::Body -->

</html>