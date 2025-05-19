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
                                                                    <th>Nomor Kontrak</th>
                                                                    <th>Pelanggan</th>
                                                                    <th style="width: 100px;">Action</th>
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
    <div class="modal fade" id="upload_invoice_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-2">
                        <div id="nama_perusahan" class="text-gray-900 text-hover-primary fs-4 fw-bold me-1"></div>
                        <a href="javascript:;">
                            <!--begin::Svg Icon | path: icons/duotune/.svg-->
                            <?php echo getSvgIcon('general/gen026', 'svg-icon svg-icon-1 svg-icon-primary'); ?>
                            <!--end::Svg Icon-->
                        </a>
                    </div>
                    <div class="row mb-6">
                        <div class="col-sm-6">
                            <div>Nomor Order</div>
                            <div id="nomor_order" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6"></div>
                            <div id="tgl_order" class="text-gray-400 fw-semibold d-block fs-7"></div>
                        </div>
                        <div class="col-sm-6">
                            <div>Nomor Kontrak</div>
                            <div id="nomor_kontrak" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6"></div>
                            <div id="tgl_kontrak" class="text-gray-400 fw-semibold d-block fs-7"></div>
                        </div>
                    </div>

                    <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_invoice" action="<?php echo base_url(); ?>payment_detail/upload_invoice_faktur_pajak" autocomplete="off">
                        <div class="separator mb-10 mt-10"></div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6 required">Nomor Invoice</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="nomor_invoice" id="nomor_invoice" class="form-control form-control-lg form-control-solid" required>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6 required">Tanggal Invoice</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="tanggal_invoice" id="tanggal_invoice" class="form-control form-control-lg form-control-solid" required>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6 required">Invoice</label>
                            <div class="col-lg-8 fv-row">
                                <input type="file" name="invoice" id="invoice" accept="application/pdf" class="form-control form-control-lg form-control-solid" required>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6 required">Nomor Faktur Pajak</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="nomor_faktur_pajak" id="nomor_faktur_pajak" class="form-control form-control-solid" required>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6 required">Faktur Pajak</label>
                            <div class="col-lg-8 fv-row">
                                <input type="file" name="faktur_pajak" id="faktur_pajak" accept="application/pdf" class="form-control form-control-lg form-control-solid" required>
                            </div>
                        </div>
                        <div class="separator mb-10 mt-10"></div>
                        <input type="hidden" id="id_dokumen_permohonan" name="id_dokumen_permohonan">
                        <input type="hidden" id="id_payment_detail" name="id_payment_detail">
                        <input type="hidden" id="token" name="token" value="<?php echo genToken('SEND_DATA'); ?>">

                        <button type="submit" id="simpan" class="btn btn-primary me-2">
                            <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                            <span class="indicator-progress">Loading...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <button type="button" class="btn btn-light btn-active-light-primary" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-times me-2 fs-3"></i>
                            Batal
                        </button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        setDatePicker('#tanggal_invoice');
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

        $("#input_form_invoice").on('submit', function(e) {
            e.preventDefault();

            var invoice = $("#invoice").val();
            var faktur_pajak = $("#faktur_pajak").val();
            var id_dokumen_permohonan = $("#id_dokumen_permohonan").val();
            var id_payment_detail = $("#id_payment_detail").val();
            var nomor_invoice = $("#nomor_invoice").val();
            var tanggal_invoice = $("#tanggal_invoice").val();
            var nomor_faktur_pajak = $("#nomor_faktur_pajak").val();

            if (!invoice || !faktur_pajak || !id_dokumen_permohonan || !id_payment_detail || !nomor_invoice || !nomor_faktur_pajak || !tanggal_invoice) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else {
                var pertanyaan = "Dokumen invoice dan faktur pajak yang Anda upload akan dikirim ke pelanggan. Pastikan file yang Anda upload sudah benar. Apakah Anda ingin menlanjutkan proses upload ini?";

                konfirmasi(pertanyaan, function() {
                    proses_submit_invoice();
                });

            }
        });

        function proses_submit_invoice() {
            $("#simpan").attr({
                "data-kt-indicator": "on",
                'disabled': true
            });
            jQuery("#input_form_invoice").ajaxSubmit({
                dataType: 'json',
                success: function(data) {
                    $("#simpan").removeAttr('disabled data-kt-indicator');

                    if (data.sts == 1) {
                        $("#upload_invoice_modal").modal('hide');
                        $("#input_form_invoice")[0].reset();

                        load_data();
                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        toastrAlert(response);
                    } else if (data.sts == 'tidak_berhak_akses_data') {
                        var response = JSON.parse('<?php echo alert('tidak_berhak_akses_data'); ?>');
                        swalAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }
            });
        }

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
            data['from'] = 'upload_invoice_faktur_pajak';


            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/payment_detail/load_data',
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
                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +

                                '<td>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + list_data[i].nomor_order_payment + '</div>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7 mb-3">' + reformatDate(list_data[i].tgl_payment_detail, 'DD MMMM YYYY') + '</div>' +
                                render_badge_tipe_pengajuan(list_data[i].tipe_pengajuan) +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + list_data[i].nomor_oc + '</div>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7">' + reformatDate(list_data[i].tgl_oc) + '</div>' +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + list_data[i].nama_badan_usaha + ' ' + list_data[i].nama_perusahaan + '</div>' +
                                '</td>' +
                                '<td>' +
                                '<div class="dropdown">' +
                                '<button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-boundary="viewport" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                'Actions' +
                                '</button>' +
                                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
                                '<a class="dropdown-item text-hover-primary" href="' + base_url + 'page/profil_pelanggan/' + list_data[i].id_pelanggan + '">Lihat Pelanggan</a>' +
                                '<a class="dropdown-item text-hover-primary" href="javascript:;" onclick="upload_invoice(' + i + ')">Upload Invoice & Faktur Pajak</a>' +
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

        function upload_invoice(i) {
            var data = list_data[i];

            $("#nama_perusahan").html(data.nama_badan_usaha + ' ' + data.nama_perusahaan);
            $("#nomor_order").html(data.nomor_order_payment);
            $("#tgl_order").html(reformatDate(data.tgl_payment_detail, 'DD MMMM YYYY'));

            $("#nomor_kontrak").html(data.nomor_oc);
            $("#tgl_kontrak").html(reformatDate(data.tgl_oc, 'DD MMMM YYYY'));

            $("#id_dokumen_permohonan").val(data.id_dokumen_permohonan);
            $("#id_payment_detail").val(data.id_payment_detail);

            $("#upload_invoice_modal").modal('show');
        }
    </script>
</body>
<!-- end::Body -->

</html>