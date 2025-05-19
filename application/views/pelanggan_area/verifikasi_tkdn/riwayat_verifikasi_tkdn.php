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
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <?php $this->view('pelanggan_area/include/top_navbar'); ?>
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <?php $this->view('pelanggan_area/include/left_side_navbar'); ?>
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
                                                <!--begin::Svg Icon | path: icons/duotune/.svg-->
                                                <?php echo getSvgIcon('general/gen021', 'svg-icon svg-icon-1 position-absolute ms-4') ?>
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
                                                                    <th>Pengajuan</th>
                                                                    <th>Verifikator</th>
                                                                    <th style="width: 250px;">Status</th>
                                                                    <th style="width: 110px;">Action</th>
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
    <div class="modal fade" id="permohonan_perpanjangan_waktu_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <div class="fw-bold fs-2">Permohonan Perpanjangan Waktu</div>
                        <div class="fw-fw-semibold fs-4">Nomor Order: <span id="perpanjangan_waktu-nomor_order"></span></div>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="perpanjangan_waktu-alasan_penolakan_box">
                        <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-5 p-6">
                            <?php echo getSvgIcon('general/gen034', 'svg-icon svg-icon-2tx svg-icon-danger me-4'); ?>
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-semibold">
                                    <h4 class="text-danger fw-bold">Alasan Penolakan!</h4>
                                    <div class="fs-6 text-gray-700" id="perpanjangan_waktu-alasan_penolakan"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->view('pelanggan_area/include/notice_ketentuan_upload_file'); ?>
                    <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_permohonan_perpanjangan_waktu" action="<?php echo base_url(); ?>pelanggan_area/collecting_dokumen/upload_permohonan_perpanjangan_waktu" autocomplete="off">
                        <div class="row mb-6">
                            <label class="col-lg-12 col-form-label fw-semibold fs-6 required">Surat Permohonan Perpanjangan Waktu</label>
                            <div class="col-lg-12 fv-row">
                                <input type="file" name="surat_permohonan_perpanjangan_waktu" id="perpanjangan_waktu-surat_permohonan" accept="application/pdf,image/jpeg" class="form-control form-control-lg form-control-solid" required>
                            </div>
                        </div>
                        <div class="separator mb-10 mt-10"></div>
                        <input type="hidden" id="perpanjangan_waktu-id_opening_meeting" name="id_opening_meeting">
                        <input type="hidden" id="perpanjangan_waktu-token" name="token" value="<?php echo genToken('SEND_DATA'); ?>">

                        <button type="submit" id="perpanjangan_waktu-simpan" class="btn btn-primary me-2">
                            <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                            <span class="indicator-progress">Loading...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $this->view('include/js'); ?>
    <script>
        function buka_upload_permohonan(i) {
            var data = list_data[i];

            $("#perpanjangan_waktu-nomor_order").html(data.nomor_order_payment);
            $("#perpanjangan_waktu-id_opening_meeting").val(data.id_opening_meeting);

            $("#perpanjangan_waktu-alasan_penolakan_box").hide();
            if (data.id_status == 13) {
                $("#perpanjangan_waktu-alasan_penolakan_box").show();
                $("#perpanjangan_waktu-alasan_penolakan").html(data.alasan_status);
            }

            $("#permohonan_perpanjangan_waktu_modal").modal('show');
        }
        $("#input_form_permohonan_perpanjangan_waktu").on('submit', function(e) {
            e.preventDefault();

            var id_opening_meeting = $("#perpanjangan_waktu-id_opening_meeting").val();
            var surat_permohonan = $("#perpanjangan_waktu-surat_permohonan").val();

            if (!id_opening_meeting || !surat_permohonan) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else {
                $("#perpanjangan_waktu-simpan").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });

                jQuery(this).ajaxSubmit({
                    dataType: 'json',
                    success: function(data) {
                        $("#perpanjangan_waktu-simpan").removeAttr('disabled data-kt-indicator');

                        if (data.sts == 1) {
                            $("#permohonan_perpanjangan_waktu_modal").modal('hide');
                            //hapus seluruh field...
                            $("#page").val(1);

                            //load data..
                            load_data();
                            var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                            swalAlert(response);
                        } else if (data.sts == 'tidak_berhak_akses_data') {
                            var response = JSON.parse('<?php echo alert('tidak_berhak_akses_data'); ?>');
                            swalAlert(response);
                        } else if (data.sts == 'kosong') {
                            var response = JSON.parse('<?php echo alert('kosong'); ?>');
                            swalAlert(response);
                        } else if (data.sts == 'upload_error') {
                            var response = JSON.parse('<?php echo alert('upload_error'); ?>');
                            response.message = response.message.replace('{{upload_error_msg}}', data.msg);
                            swalAlert(response);
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }
                });
            }
        })

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
                url: '<?php echo base_url(); ?>pelanggan_area/verifikasi_tkdn/load_data',
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
                            var tipe_pengajuan = '';
                            if (list_data[i].tipe_pengajuan == 'PEMERINTAH') {
                                tipe_pengajuan = 'Berbayar Pemerintah';
                            } else {
                                tipe_pengajuan = 'Berbayar Pelaku Usaha';
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
                                            '<a href="' + base_url + path_file + '" target="_blank" class="menu-link px-3" download><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> ' + item.nama_file + '</a>' +
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
                                            '<a href="' + base_url + path_file + '" target="_blank" class="menu-link px-3" download><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> ' + item.nama_file + '</a>' +
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

                            var button = '';
                            if (list_data[i].id_status >= 4) {
                                button = '<div class="me-0">' +
                                    '<button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-kt-menu="true" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">' +
                                    'Actions' +
                                    '</button>' +
                                    '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-300px py-3" data-kt-menu="true" style="">' +

                                    (list_data[i].id_status == 4 || list_data[i].id_status == 6 ?
                                        //Upload dokumen opening meeting
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'pelanggan/upload_opening_meeting/' + list_data[i].id_opening_meeting + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil009', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Upload Dokumen</a>' +
                                        '</div>' +

                                        //Request Revisi Dokumen Meeting
                                        '<div class="menu-item px-3">' +
                                        '<a href="javascript:;" onclick="revisi_dokumen_meeting(' + i + ')" class="menu-link px-3"><?php echo getSvgIcon('files/fil009', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Revisi Dokumen</a>' +
                                        '</div>' :
                                        '') +

                                    (list_data[i].id_status == 22 ?
                                        //Upload Draft tanda sah
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'pelanggan/upload_daftar_tanda_sah/' + list_data[i].id_opening_meeting + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil009', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Upload Draft Tanda Sah</a>' +
                                        '</div>' :
                                        '') +
                                    (list_data[i].id_status == 23 ?
                                        //Upload Draft tanda sah
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'pelanggan/upload_daftar_tanda_sah/' + list_data[i].id_opening_meeting + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil009', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Revisi Draft Tanda Sah</a>' +
                                        '</div>' :
                                        '') +
                                    (list_data[i].id_status == 29 ?
                                        //Upload Closing meeting
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'pelanggan/upload_closing_meeting/' + list_data[i].id_opening_meeting + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil009', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Upload Closing Meeting</a>' +
                                        '</div>' :
                                        '') +

                                    //=== OPENING MEETING ===//
                                    '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                    '<a href="#" class="menu-link px-3">' +
                                    '<span class="menu-title">Opening Meeting</span>' +
                                    '<span class="menu-arrow"></span>' +
                                    '</a>' +
                                    '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +

                                    //Download Surat Tugas Verifikator
                                    '<div class="menu-item px-3">' +
                                    '<a href="' + base_url + list_data[i].surat_tugas_assesor + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Surat Tugas Verifikator</a>' +
                                    '</div>' +
                                    //Download Risalah Rapat Verifikator
                                    '<div class="menu-item px-3">' +
                                    '<a href="' + base_url + list_data[i].risalah_rapat_assesor + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Risalah Rapat Verifikator</a>' +
                                    '</div>' +
                                    //Download Hadir Rapat Verifikator
                                    '<div class="menu-item px-3">' +
                                    '<a href="' + base_url + list_data[i].hadir_rapat_assesor + '" target="_blank" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Hadir Rapat Verifikator</a>' +
                                    '</div>' +

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
                                    '</div>' +
                                    //===============

                                    //=== COLLECTING DOCUMENT ===//
                                    (list_data[i].id_status >= 7 ?
                                        '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                        '<a href="#" class="menu-link px-3">' +
                                        '<span class="menu-title">Collecting Document</span>' +
                                        '<span class="menu-arrow"></span>' +
                                        '</a>' +
                                        '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +

                                        //Folder pengumpulan dokumen
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'pelanggan/collecting_dokumen/' + list_data[i].id_opening_meeting + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil012', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Pengumpulan Dokumen</a>' +
                                        '</div>' +

                                        //lihat surat pemberitahuan pemenuhan dokumen
                                        (list_data[i].id_status >= 11 && list_data[i].pemberitahuan_pemenuhan_dokumen ?
                                            '<div class="menu-item px-3">' +
                                            '<a href="' + base_url + 'pelanggan/lihat_surat_pemberitahuan_pemenuhan_dokumen/' + list_data[i].id_opening_meeting + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Surat Pemberitahuan Pemenuhan Dokumen</a>' +
                                            '</div>' :
                                            '') +

                                        //upload dokumen permohonan perpanjangan waktu
                                        ((list_data[i].id_status == 11 || list_data[i].id_status == 13) && list_data[i].pemberitahuan_pemenuhan_dokumen ?
                                            '<div class="menu-item px-3">' +
                                            '<a href="javascript:;" onclick="buka_upload_permohonan(' + i + ')" class="menu-link px-3"><?php echo getSvgIcon('files/fil022', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Upload Permohonan Perpanjangan Waktu</a>' +
                                            '</div>' :
                                            '') +

                                        //lihat dokumen permohonan perpanjangan waktu
                                        (list_data[i].id_status >= 12 && list_data[i].pemberitahuan_pemenuhan_dokumen ?
                                            '<div class="menu-item px-3">' +
                                            '<a href="' + base_url + 'pelanggan/lihat_surat_permohonan_perpanjangan_waktu/' + list_data[i].id_opening_meeting + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil003', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Surat Permohonan Perpanjangan Waktu</a>' +
                                            '</div>' :
                                            '') +

                                        '</div>' +
                                        '</div>'

                                        :
                                        '') +
                                    //===============

                                    //=== COLLECTING DOCUMENT 2 ===//
                                    (list_data[i].id_status >= 16 ?
                                        '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                        '<a href="#" class="menu-link px-3">' +
                                        '<span class="menu-title">Collecting Document Tahap 2</span>' +
                                        '<span class="menu-arrow"></span>' +
                                        '</a>' +
                                        '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +

                                        //Folder pengumpulan dokumen
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'pelanggan/collecting_dokumen_tahap_2/' + list_data[i].id_opening_meeting + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil012', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Pengumpulan Dokumen</a>' +
                                        '</div>' +

                                        '</div>' +
                                        '</div>' :
                                        '') +
                                    //===============

                                    //=== PANEL INTERNAL ===//
                                    (list_data[i].id_status >= 23 ?
                                        '<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">' +
                                        '<a href="#" class="menu-link px-3">' +
                                        '<span class="menu-title">Panel Internal</span>' +
                                        '<span class="menu-arrow"></span>' +
                                        '</a>' +
                                        '<div class="menu-sub menu-sub-dropdown w-250px py-4" style="">' +

                                        //Draft Tanda Sah
                                        '<div class="menu-item px-3">' +
                                        '<a href="' + base_url + 'pelanggan/daftar_tanda_sah/' + list_data[i].id_opening_meeting + '" class="menu-link px-3"><?php echo getSvgIcon('files/fil012', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Draft Tanda Sah</a>' +
                                        '</div>' +

                                        '</div>' +
                                        '</div>' :
                                        '') +
                                    //===============

                                    //=== CLOSING MEETING ===//
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
                                        '')
                                //===============

                            }

                            var nomor_hp_assesor = '';
                            if (list_data[i].telepon_admin) {
                                nomor_hp_assesor = render_badge('success', '<i class="fa fa-phone-square text-white" style="margin-right: 10px;"></i> ' + list_data[i].telepon_admin)
                            }

                            var sisa_hari = '';
                            if (list_data[i].tgl_mulai_verifikasi_dokumen && (list_data[i].id_status >= 7 && list_data[i].id_status < 15)) {
                                var startDate = moment(list_data[i].tgl_mulai_verifikasi_dokumen);
                                var endDate = moment();
                                var diffInDays = endDate.diff(startDate, 'days');
                                sisa_hari = list_data[i].masa_collecting_dokumen - diffInDays;

                                if (sisa_hari <= 7) {
                                    if (sisa_hari < 0) {
                                        sisa_hari = '<div class="mt-3">' + render_badge('danger', 'Lewat ' + (sisa_hari * -1) + ' hari') + '</div>';
                                    } else {
                                        sisa_hari = '<div class="mt-3">' + render_badge('danger', 'Sisa ' + sisa_hari + ' hari') + '</div>';
                                    }
                                } else if (sisa_hari <= 14 && sisa_hari > 7) {
                                    sisa_hari = '<div class="mt-3">' + render_badge('warning', 'Sisa ' + sisa_hari + ' hari') + '</div>';
                                } else {
                                    sisa_hari = '<div class="mt-3">' + render_badge('success', 'Sisa ' + sisa_hari + ' hari') + '</div>';
                                }

                            }
                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +
                                '<td class="text-gray-800 fw-bold fs-6">' + list_data[i].nomor_order_payment + '</td>' +
                                '<td>' +
                                '<span class="text-gray-800 fw-bold fs-6">' + coverMe(list_data[i].nama_tipe_permohonan) + '</span>' +
                                '<div class="text-gray-400 fw-semibold d-block mt-2 fs-7">Tipe Pengajuan</div>' +
                                '<span class="text-gray-800 fw-bold fs-6">' + tipe_pengajuan + '</span>' +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + coverMe(list_data[i].nama_admin, 'Belum Ada') + '</div>' +
                                nomor_hp_assesor +
                                '</td>' +
                                '<td>' + status_verifikasi_tkdn_pelanggan_badge(list_data[i].id_status ? list_data[i].id_status : '0') + sisa_hari + '</td>' +
                                '<td>' +
                                button +
                                '</td>' +
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

        function revisi_dokumen_meeting(i) {
            var data = list_data[i];
            swal.fire({
                title: 'Revisi Dokumen Meeting',
                html: 'Anda akan menolak dokumen yang dikirim oleh verifikator dan mengajukan pembaruan dokumen.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-paper-plane text-white"></i> Kirim',
                cancelButtonText: '<i class="fa fa-times-circle text-white"></i> Batalkan',
                confirmButtonColor: '#0abb87',
                cancelButtonColor: '#d33',
                allowOutsideClick: false,
                reverseButtons: true,
                input: 'textarea',
                inputLabel: 'Alasan Revisi Dokumen:',
                inputPlaceholder: 'Berikan alasan dengan jelas disini',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Anda harus menuliskan alasan dengan jelas!'
                    }
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    proses_revisi_dokumen(data.id_opening_meeting, result.value);
                }

            });
        }

        function proses_revisi_dokumen(id_opening_meeting, alasan) {
            //show loading animation...
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;
            data['alasan'] = alasan;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/opening_meeting/request_revisi_dokumen',
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