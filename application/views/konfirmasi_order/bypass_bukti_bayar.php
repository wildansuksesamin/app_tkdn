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
                                        <div id="data_zona_surat_penawaran">
                                            <div class="d-flex flex-column flex-lg-row">
                                                <!--begin::Content-->
                                                <div class="flex-lg-row-fluid me-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-striped gy-5" id="data_surat_penawaran">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th>No</th>
                                                                    <th style="width: 300px;">Surat Penawaran</th>
                                                                    <th>permohonan Verifikasi</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
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
        function konfirmasi_bypass(i) {
            var data = list_data[i];
            var pertanyaan =
                '<div class="alert alert-danger d-flex align-items-center p-5" style="text-align: left">' +
                '<?php echo getSvgIcon('general/gen044', 'svg-icon svg-icon-2hx svg-icon-danger me-3') ?>' +
                '<div class="d-flex flex-column">' +
                '<span>Proses ini akan bypass alur menuju status "Penentuan Waktu Pelaksanaan".</span>' +
                '</div>' +
                '</div>' +
                '<div class="mt-5 text-gray-800 fw-bold fs-6">Apakah Anda yakin ingin melakukan bypass permohonan ini?</div>';

            swal.fire({
                title: konfirmasi_title,
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
                inputLabel: 'Alasan By Pass Alur Sistem',
                inputPlaceholder: 'Tuliskan alasan by pass Anda disini',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Anda harus menuliskan alasan by pass dengan jelas!'
                    }
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    proses_bypass(data.id_dokumen_permohonan, result.value);
                }
            });
        }

        function proses_bypass(id_dokumen_permohonan, alasan) {
            //show loading animation...
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_dokumen_permohonan'] = id_dokumen_permohonan;
            data['alasan_verifikasi'] = alasan;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>surat_oc/bypass_alur',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    //hide loading animation...
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
            data['from'] = 'bypass_bukti_bayar';

            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>Surat_penawaran_rilis/load_data',
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
                            var download = '<a href="' + base_url + 'page/lihat_surat_penawaran/' + list_data[i].id_rab + '" target="_blank" class="btn btn-light-success btn-sm mt-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-3'); ?> Surat Penawaran</a>';
                            var button = '<a href="javascript:;" onclick="konfirmasi_bypass(' + i + ')" class="btn btn-icon-primary btn-text-primary btn-sm"><?php echo getSvgIcon('arrows/arr030', 'svg-icon svg-icon-3'); ?> By Pass Alur</a>';

                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +
                                '<td>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7">' + coverMe(list_data[i].nomor_surat_penawaran) + '</div>' +
                                '<div class="text-gray-800 fw-bold mb-2 fs-6"  style="max-width: 280px; text-overflow:ellipsis;overflow: hidden;white-space: nowrap;">' + list_data[i].nama_badan_usaha + ' ' + list_data[i].nama_perusahaan + '</div>' +
                                '<div class="text-gray-400 fw-semibold fs-7">Masa Collecting: <span class="text-primary fw-semibold">' + list_data[i].masa_collecting_dokumen + ' Hari</span></div>' +
                                download +
                                '</td>' +
                                '<td style="max-width: 300px; ">' + list_data[i].rincian_produk_pekerjaan + '</td>' +
                                '<td>' + status_pengajuan_badge(list_data[i].status_pengajuan) + '</td>' +
                                '<td>' + button + '</td>' +
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