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
                                                                    <th style="width: 150px;">Waktu Collecting Dokumen</th>
                                                                    <th>Status</th>
                                                                    <th style="width: 120px;">Action</th>
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
        function batalkan_verifikasi(i) {
            var data = list_data[i];
            var nama_pelanggan = data.nama_badan_usaha + ' ' + data.nama_perusahaan;
            swal.fire({
                title: 'Selesai & Tutup Permohonan',
                html: 'Apakah Anda yakin ingin <Strong>menutup pengajuan</strong> dari pelanggan  <strong>' + nama_pelanggan + '</strong>?<div class="mt-3 text-danger fw-bold">Perhatian! Proses ini tidak bisa dibatalkan.</div>',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan!',
                cancelButtonText: 'Tidak, batalkan',
                confirmButtonColor: '#0abb87',
                cancelButtonColor: '#d33',
                allowOutsideClick: false,
                reverseButtons: true,
                input: 'textarea',
                inputLabel: 'Alasan Penutupan',
                inputPlaceholder: 'Tuliskan alasan penutupan Anda disini',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Anda harus menuliskan alasan penutupan dengan jelas!'
                    }
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    $("#tolak").attr({
                        "data-kt-indicator": "on",
                        'disabled': true
                    });

                    proses_penutupan_permohonan(data.id_opening_meeting, result.value);
                }
            });
        }

        function proses_penutupan_permohonan(id_opening_meeting, alasan_verifikasi = '') {
            //show loading animation...
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;
            data['alasan_verifikasi'] = alasan_verifikasi;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>collecting_dokumen/proses_penutupan_permohonan',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    preloader('hide');

                    if (data.sts == 1) {
                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        toastrAlert(response);
                        load_data();
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

        var ajax_request;
        var list_data;

        function load_data() {
            var page = $("#page").val();
            var jml_data = 10;

            var filter = $("#filter").val();

            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['page'] = page;
            data['jml_data'] = jml_data;
            data['filter'] = filter;
            data['for'] = 'collecting_document';


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
                            var sign = redDot('danger');
                            var sign_right = redDot('danger', 'style="right: 10px;"');

                            var notif_global = '';
                            var notif_lihat_folder = '';

                            if (list_data[i].jml_verifikasi > 0) {
                                notif_global = sign;
                                notif_lihat_folder = sign_right;
                            }

                            var startDate = moment(list_data[i].tgl_mulai_verifikasi_dokumen);
                            var endDate = moment();
                            var diffInDays = endDate.diff(startDate, 'days');
                            var sisa_hari = list_data[i].masa_collecting_dokumen - diffInDays;
                            var display_sisa_hari = '';
                            if (sisa_hari <= 7) {
                                notif_global = sign;
                                if (sisa_hari < 0) {
                                    display_sisa_hari = '<div class="">' + render_badge('danger', 'Lewat ' + sisa_hari + ' hari') + '</div>';
                                } else {
                                    display_sisa_hari = '<div class="">' + render_badge('danger', sisa_hari + ' hari lagi') + '</div>';
                                }
                            } else if (sisa_hari <= 14 && sisa_hari > 7) {
                                display_sisa_hari = '<div class="">' + render_badge('warning', sisa_hari + ' hari lagi') + '</div>';
                            } else {
                                display_sisa_hari = '<div class="">' + render_badge('success', sisa_hari + ' hari lagi') + '</div>';
                            }
                            var tgl_berakhir_verifikasi_dokumen = reformatDate(moment(startDate, 'YYYY-MM-DD').add(90, 'days').format('YYYY-MM-DD'));

                            var btn_pemberitahuan_pemenuhan = '';
                            if (list_data[i].id_status >= 7) {
                                if (list_data[i].id_status == 7) {
                                    btn_pemberitahuan_pemenuhan = '<a href="' + base_url + 'page/buat_reminder_collecting_document_habis/' + list_data[i].id_opening_meeting + '" class="menu-link px-3 text-hover-primary"><?php echo getSvgIcon('general/gen035', 'svg-icon svg-icon-3 me-5'); ?> Buat Pemberitahuan Pemenuhan Dokumen' + (sisa_hari <= 7 ? sign_right : '') + '</a>';
                                } else if (list_data[i].id_status == 8) {
                                    notif_global = sign;
                                    btn_pemberitahuan_pemenuhan = '<a href="' + base_url + 'page/lihat_pemberitahuan_pemenuhan_dokumen/' + list_data[i].id_opening_meeting + '" class="menu-link px-3 text-hover-primary"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-3 me-5'); ?> Lihat Pemberitahuan Pemenuhan Dokumen' + sign_right + '</a>';
                                } else if (list_data[i].id_status >= 11) {
                                    btn_pemberitahuan_pemenuhan = '<a href="' + base_url + 'page/lihat_pemberitahuan_pemenuhan_dokumen/' + list_data[i].id_opening_meeting + '" class="menu-link px-3 text-hover-primary"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-3 me-5'); ?> Lihat Pemberitahuan Pemenuhan Dokumen</a>';
                                } else if (list_data[i].id_status == 10) { //dokumen surat pemberitahuan pemenuhan dokumen ditolak...
                                    notif_global = sign;
                                    btn_pemberitahuan_pemenuhan = '<a href="' + base_url + 'page/buat_reminder_collecting_document_habis/' + list_data[i].id_opening_meeting + '" class="menu-link px-3 text-hover-primary"><?php echo getSvgIcon('general/gen035', 'svg-icon svg-icon-3 me-5'); ?> Revisi Pemberitahuan Pemenuhan Dokumen' + sign_right + '</a>';
                                    btn_pemberitahuan_pemenuhan += '<a href="' + base_url + 'page/lihat_pemberitahuan_pemenuhan_dokumen/' + list_data[i].id_opening_meeting + '" class="menu-link px-3 text-hover-primary"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-3 me-5'); ?> Lihat Pemberitahuan Pemenuhan Dokumen</a>';

                                }

                            }


                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + list_data[i].nomor_order_payment + '</div>' +
                                render_badge_tipe_pengajuan(list_data[i].tipe_pengajuan) +
                                '<div class="text-gray-400 fw-semibold d-block fs-7 mt-2">Nomor OC:</div>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + list_data[i].nomor_oc + '</div>' +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold fs-6" style="max-width: 200px; text-overflow:ellipsis;overflow: hidden;white-space: nowrap;">' + list_data[i].nama_badan_usaha + ' ' + list_data[i].nama_perusahaan + '</div>' +
                                'PIC: ' + list_data[i].nama_pejabat_penghubung_proses_tkdn +
                                '</td>' +
                                '<td class="text-gray-800 fw-bold mb-1 fs-6">' +
                                '<div class="text-gray-800 fw-bold fs-6" style="max-width: 200px; text-overflow:ellipsis;overflow: hidden;white-space: nowrap;">' + display_sisa_hari + '</div>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7 mt-2">Tgl berakhir:</div>' +
                                '<div class="text-gray-800 fw-semibold d-block">' + tgl_berakhir_verifikasi_dokumen + '</div>' +
                                '</td>' +
                                '<td class="text-gray-800 fw-bold mb-1 fs-6">' +
                                status_verifikasi_tkdn_badge(list_data[i].id_status) +
                                '</td>' +
                                '<td>' +
                                '<div class="me-0">' +
                                '<button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-kt-menu="true" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">' +
                                'Actions ' + notif_global +
                                '</button>' +
                                '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-350px py-3" data-kt-menu="true" style="">' +
                                '<div class="menu-item px-3">' +
                                '<a href="' + base_url + 'page/proses_collecting_document/' + list_data[i].id_opening_meeting + '" class="menu-link px-3 text-hover-primary"><?php echo getSvgIcon('files/fil012', 'svg-icon svg-icon-3 me-5'); ?> Lihat Folder Dokumen ' + notif_lihat_folder + '</a>' +
                                btn_pemberitahuan_pemenuhan +

                                (list_data[i].id_status == 12 ?
                                    '<a href="' + base_url + 'page/verifikasi_surat_permohonan_perpanjangan_waktu/' + list_data[i].id_opening_meeting + '" class="menu-link px-3 text-hover-primary"><?php echo getSvgIcon('general/gen043', 'svg-icon svg-icon-3 me-5'); ?> Verifikasi Permohonan Perpanjangan Waktu ' + sign_right + '</a>' :
                                    '') +

                                (list_data[i].id_status >= 10 && list_data[i].id_status < 13 ?
                                    '<div class="separator mb-3 mt-3"></div>' +
                                    '<a href="javascript:;" onclick="batalkan_verifikasi(' + i + ')" class="menu-link px-3 text-danger"><?php echo getSvgIcon('general/gen034', 'svg-icon svg-icon-3 me-5 svg-icon-danger'); ?> Selesai & Tutup Permohonan</a>' :
                                    '') +
                                '</div>' +

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
    </script>
</body>
<!-- end::Body -->

</html>