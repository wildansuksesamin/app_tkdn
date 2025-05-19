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

                                <div class="card card-flush h-lg-100 tabel_zone" id="tabel_surat_penawaran">
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
                                        <div id="data_zona_surat_penawaran">
                                            <div class="d-flex flex-column flex-lg-row">
                                                <!--begin::Content-->
                                                <div class="flex-lg-row-fluid me-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-striped gy-5" id="data_surat_penawaran">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th>No</th>
                                                                    <th>Perusahaan</th>
                                                                    <th>Nomor OC</th>
                                                                    <th>Termin</th>
                                                                    <th>Waktu Pelaksanaan</th>
                                                                    <th style="width: 150px;">Action</th>
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

        var list_data;
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
            data['from'] = '<?php echo $konten['from']; ?>';

            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>surat_oc/load_data',
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
                            var nilai_kontrak = list_data[i].nilai_kontrak;
                            var termin_1 = (list_data[i].termin_1 / 100) * nilai_kontrak;
                            var termin_2 = (list_data[i].termin_2 / 100) * nilai_kontrak;
                            var button_bukti_bayar = '';
                            if (list_data[i].termin_1 > 0) {
                                button_bukti_bayar = '<a class="dropdown-item text-hover-primary" href="' + base_url + 'page/lihat_bukti_bayar/' + list_data[i].id_surat_oc + '" target="_blank"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-3'); ?> Lihat Bukti Bayar</a>';
                            }

                            var btn_action = '<div class="dropdown">' +
                                '<button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-boundary="viewport" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                'Actions' +
                                '</button>' +
                                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
                                '<a class="dropdown-item text-hover-primary" href="' + base_url + 'page/verifikasi_form_01/' + list_data[i].id_surat_oc + '"><?php echo getSvgIcon('arrows/arr064', 'svg-icon svg-icon-3'); ?> Verifikasi Form 01</a>' +
                                '<div class="separator mb-3 mt-3"></div>' +
                                button_bukti_bayar +
                                '</div>' +
                                '</div>';
                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +
                                '<td>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7 mb-3">' + reformatDate(list_data[i].tgl_oc) + '</div>' +
                                '<div class="text-gray-800 fw-bold fs-6" style="max-width: 200px; text-overflow:ellipsis;overflow: hidden;white-space: nowrap;">' + list_data[i].nama_badan_usaha + ' ' + list_data[i].nama_perusahaan + '</div>' +
                                render_assesor('Verifikator: ' + list_data[i].assesor.nama_admin) +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + coverMe(list_data[i].nomor_oc) + '</div>' +
                                render_badge_tipe_pengajuan(list_data[i].tipe_pengajuan) +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7">Termin I (' + list_data[i].termin_1 + '%)</div>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">Rp ' + rupiah(termin_1) + '</div>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7 mt-4">Termin II (' + list_data[i].termin_2 + '%)</div>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">Rp ' + rupiah(termin_2) + '</div>' +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7">Tanggal Mulai</div>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + reformatDate(list_data[i].tgl_mulai_pelaksanaan) + '</div>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7 mt-4">Tanggal Selesai</div>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + reformatDate(list_data[i].tgl_akhir_pelaksanaan) + '</div>' +
                                '</td>' +
                                '<td>' +
                                btn_action +
                                '</td>' +
                                '</tr>';
                        }
                    }

                    if (rangkai) {
                        $("#empty_state").remove();
                        $("#data_zona_surat_penawaran").show();

                        $("#data_surat_penawaran tbody").html(rangkai);
                    } else {
                        if (page == 1 && filter == '') {
                            create_empty_state("#data_zona_surat_penawaran");
                        } else
                            $("#data_surat_penawaran tbody").html('');
                    }

                }

            });
        }
        load_data();
    </script>
</body>
<!-- end::Body -->

</html>