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

                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <!--begin::Secondary button-->
                                    <a href="<?php echo base_url('page/verifikasi_collecting_document_2'); ?>" class="btn btn-sm btn-light btn-active-light-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                                    <!--end::Secondary button-->
                                </div>
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <div class="card card-flush h-lg-100 mb-10">

                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="text-gray-600 fs-8">Nomor Order</div>
                                                <div class="fw-bold fs-4 mb-3"><?php echo $konten['opening_meeting']->nomor_order_payment; ?></div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="text-gray-600 fs-8">Nomor OC</div>
                                                <div class="fw-bold fs-4 mb-3"><?php echo $konten['opening_meeting']->nomor_oc; ?></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="text-gray-600 fs-8">Pelanggan</div>
                                                <div class="fw-bold fs-4 mb-3"><?php echo $konten['opening_meeting']->nama_badan_usaha . ' ' . $konten['opening_meeting']->nama_perusahaan; ?></div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary mt-5" id="lanjut_verifikasi_teknis"><i class="fa fa-paper-plane"></i> Lanjutkan Ke Verifikasi Teknis</button>
                                    </div>
                                    <!--end::Body-->
                                </div>

                                <div class="card card-flush h-lg-100 mb-10">
                                    <div class="card-header align-items-center py-5 gap-2 gap-md-5" data-select2-id="select2-data-124-ftn2">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>
                                                Data Dokumen Tahap 2
                                            </h2>
                                        </div>
                                        <!--end::Card title-->

                                    </div>

                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17" style="padding-top: unset!important;">
                                        <!--begin::Layout-->
                                        <div id="data_zona_collecting_dokumen_tahap2">
                                            <div class="d-flex flex-column flex-lg-row">
                                                <!--begin::Content-->
                                                <div class="flex-lg-row-fluid me-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-striped gy-5" id="data_collecting_dokumen_tahap2">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th>No</th>
                                                                    <th>File</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
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
        var ajax_request;

        $("#lanjut_verifikasi_teknis").click(function() {
            var pertanyaan = 'Apakah Anda yakin ingin melanjutkan ke tahap verifikasi teknis?';
            konfirmasi(pertanyaan, proses_verifikasi_teknis);
        });

        function proses_verifikasi_teknis() {
            preloader('show');
            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_opening_meeting'] = <?php echo $konten['opening_meeting']->id_opening_meeting; ?>;

            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>Collecting_dokumen_tahap2/lanjut_ke_verifikasi_teknis',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    preloader('hide');

                    if (result.sts == 1) {
                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        response.callback_yes = after_simpan;
                        swalAlert(response);

                    } else if (result.sts == 'dokumen_belum_disetujui') {
                        var response = JSON.parse('<?php echo alert('dokumen_belum_disetujui'); ?>');
                        swalAlert(response);

                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);

                    }

                    console.log(result);
                }

            });
        }

        function after_simpan() {
            location.href = base_url + 'page/verifikasi_collecting_document_2';
        }

        function load_data() {
            preloader('show');
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['id_opening_meeting'] = <?php echo $konten['opening_meeting']->id_opening_meeting; ?>;

            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>Collecting_dokumen_tahap2/load_data',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    preloader('hide');
                    list_data = result.result;

                    var rangkai = '';
                    if (list_data.length > 0) {
                        for (var i = 0; i < list_data.length; i++) {
                            var status_verifikasi = '';
                            if (list_data[i].status_verifikasi == 2) {
                                status_verifikasi = render_badge('info', 'Sedang Diverifikasi');
                            } else if (list_data[i].status_verifikasi == 1) {
                                status_verifikasi = render_badge('success', 'Disetujui');
                            } else {
                                status_verifikasi = render_badge('danger', 'Ditolak');
                            }
                            rangkai += '<tr>' +
                                '<td>' + (i + 1) + '.</td>' +
                                '<td><span class="text-link fw-bold">' + coverMe(list_data[i].nama_file) + '</span></td>' +
                                '<td>' + status_verifikasi + '</td>' +

                                '<td>' +
                                (list_data[i].status_verifikasi == 2 ? '<a href="' + base_url + 'page/proses_verifikasi_collecting_document_2/' + list_data[i].id_collecting_dokumen_2 + '" class="btn btn-sm btn-light-primary"><i class="fa fa-check"></i> Verifikasi</a>' : '<a href="' + base_url + list_data[i].path_file + '" download class="btn btn-sm btn-light-primary"><i class="fa fa-download"></i> Download</a>') +
                                '</td>' +
                                '</tr>';
                        }
                    }

                    if (rangkai) {
                        $("#empty_state").remove();
                        $("#data_zona_collecting_dokumen_tahap2").show();

                        $("#data_collecting_dokumen_tahap2 tbody").html(rangkai);
                    } else {
                        create_empty_state("#data_zona_collecting_dokumen_tahap2");
                    }

                }

            });
        }
        load_data();
    </script>
</body>
<!-- end::Body -->

</html>