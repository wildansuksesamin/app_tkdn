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
                                    <h1
                                        class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                        <?php echo $konten['title']; ?>
                                    </h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <a href="<?php echo base_url(); ?>pelanggan/berbayar_pelaku_usaha"
                                        class="btn btn-sm fw-bold btn-primary">
                                        <i class="fa fa-square-plus fs-1 me-2"></i>
                                        Ajukan Permohonan
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">

                                <div class="card card-flush h-lg-100 tabel_zone" id="tabel_dokumen_permohonan">
                                    <div class="card-header align-items-center py-5 gap-2 gap-md-5"
                                        data-select2-id="select2-data-124-ftn2">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <!--begin::Search-->
                                            <div class="d-flex align-items-center position-relative my-1">
                                                <!--begin::Svg Icon | path: icons/duotune/.svg-->
                                                <?php echo getSvgIcon('general/gen021', 'svg-icon svg-icon-1 position-absolute ms-4') ?>
                                                <!--end::Svg Icon-->
                                                <input type="text" class="form-control form-control-solid w-250px ps-14"
                                                    id="filter" name="filter"
                                                    placeholder="Masukkan kata kunci pencarian">
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
                                                        <table class="table table-sm table-striped gy-5"
                                                            id="data_dokumen_permohonan">
                                                            <thead>
                                                                <tr
                                                                    class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th>No</th>
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


    <?php $this->view('include/js'); ?>
    <div class="modal fade" id="upload_bukti_bayar_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Upload Konfirmasi Order & Bukti Bayar
                    </h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="bukti_bayar_ditolak">
                        <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-9 p-6">
                            <?php echo getSvgIcon('general/gen040', 'svg-icon svg-icon-2tx svg-icon-danger me-4'); ?>
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">Alasan Penolakan</h4>
                                    <div class="fs-6 text-gray-700" id="bukti_bayar-alasan_penolakan"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php $this->view('pelanggan_area/include/notice_ketentuan_upload_file'); ?>

                    <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post"
                        id="input_form_bukti_bayar"
                        action="<?php echo base_url(); ?>pelanggan_area/Surat_oc/upload_bukti_bayar" autocomplete="off">
                        <div class="row mb-5">
                            <div class="row mb-5 align-items-center">
                                <div class="col-md-12 fv-row fv-plugins-icon-container">
                                    <label class="required fs-5 fw-semibold">Konfirmasi Order</label>
                                    <input type="file" accept="application/pdf"
                                        class="form-control mb-5 form-control-solid" id="surat_oc_pelanggan"
                                        name="surat_oc_pelanggan" placeholder="" required>

                                    <div id="surat_oc_pelanggan_box" class="file_box">
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <a id="link_surat_oc_pelanggan" href="#"
                                                    class="btn btn-icon-primary btn-text-primary"
                                                    style="background: #FFF; text-align: left; width: 100%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                                    <?php echo getSvgIcon('files/file003', 'svg-icon svg-icon-muted svg-icon-2') ?>
                                                    <span id="nama_file_surat_oc_pelanggan"></span>
                                                </a>
                                            </div>
                                            <div class="col-sm-5" style="text-align: right">
                                                <a href="javascript:;" class="btn btn-light-success"
                                                    onclick="hapus_file('surat_oc_pelanggan'); $('#surat_oc_pelanggan').attr('required', 'required'); ">Update
                                                    Dokumen</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row mb-5 align-items-center" id="bukti_bayar_container">
                                <div class="col-md-12 fv-row fv-plugins-icon-container">
                                    <label class="required fs-5 fw-semibold">Bukti Bayar</label>
                                    <input type="file" accept="application/pdf,image/x-png,image/gif,image/jpeg"
                                        class="form-control mb-5 form-control-solid" id="bukti_bayar" name="bukti_bayar"
                                        placeholder="" required>

                                    <div id="bukti_bayar_box" class="file_box">
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <a id="link_bukti_bayar" href="#"
                                                    class="btn btn-icon-primary btn-text-primary"
                                                    style="background: #FFF; text-align: left; width: 100%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                                    <?php echo getSvgIcon('files/file003', 'svg-icon svg-icon-muted svg-icon-2') ?>
                                                    <span id="nama_file_bukti_bayar"></span>
                                                </a>
                                            </div>
                                            <div class="col-sm-5" style="text-align: right">
                                                <a href="javascript:;" class="btn btn-light-success"
                                                    onclick="hapus_file('bukti_bayar'); $('#bukti_bayar').attr('required', 'required'); ">Update
                                                    Dokumen</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="mt-10">
                                <input type="hidden" name="token" value="<?php echo genToken('SEND_DATA'); ?>">
                                <input type="hidden" id="upload_bukti_bayar_modal-id_dokumen_permohonan"
                                    name="id_dokumen_permohonan">
                                <input type="hidden" id="upload_bukti_bayar_modal-action" name="action" value="save">
                                <button type="submit" id="upload_bukti_bayar_modal-simpan" class="btn btn-primary">
                                    <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i>
                                        Simpan</span>
                                    <span class="indicator-progress">Loading...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="upload_bukti_potong_pph21_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Upload Bukti Potong PPh 23
                    </h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <?php $this->view('pelanggan_area/include/notice_ketentuan_upload_file'); ?>

                    <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post"
                        id="input_form_bukti_potong_pph21"
                        action="<?php echo base_url(); ?>pelanggan_area/payment_detail/upload_bukti_potong_pph21"
                        autocomplete="off">
                        <div class="row mb-5">
                            <div class="row mb-5 align-items-center">
                                <div class="col-md-12 fv-row fv-plugins-icon-container">
                                    <label class="required fs-5 fw-semibold">File Bukti Potong PPh 23</label>
                                    <input type="file" accept="application/pdf"
                                        class="form-control mb-5 form-control-solid" id="bukti_potong_pph21"
                                        name="bukti_potong_pph21" placeholder="" required>
                                </div>
                            </div>

                            <div class="mt-10">
                                <input type="hidden" name="token" value="<?php echo genToken('SEND_DATA'); ?>">
                                <input type="hidden" id="upload_bukti_potong_pph21_modal-id_dokumen_permohonan"
                                    name="id_dokumen_permohonan">
                                <input type="hidden" id="upload_bukti_potong_pph21_modal-action" name="action"
                                    value="save">
                                <button type="submit" id="upload_bukti_potong_pph21_modal-simpan"
                                    class="btn btn-primary">
                                    <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i>
                                        Simpan</span>
                                    <span class="indicator-progress">Loading...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        function batalkan_pengajuan(index) {
            var data = list_data[index];
            var pertanyaan = "Apakah Anda yakin ingin membatalkan pengajuan penawaran ini?";

            konfirmasi(pertanyaan, function () {
                proses_batal(data.id_dokumen_permohonan);
            });
        }

        function proses_batal(id) {
            //show loading animation...
            var blockUI = generate_blockUI("#kt_app_body");
            blockUI.block();

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_dokumen_permohonan'] = id;
            data['status_verifikasi'] = 'batalkan';

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/dokumen_permohonan/verifikasi_surat_penawaran',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function (data) {
                    //hide loading animation...
                    blockUI.release();
                    blockUI.destroy();

                    if (data.sts == 1) {
                        //load data..
                        load_data();
                        var response = JSON.parse('<?php echo alert('hapus_berhasil'); ?>');
                        toastrAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }

            });
        }

        function upload_bukti_potong_pph21(i) {
            var data = list_data[i];
            if (data.status_pengajuan >= 29 || data.status_pengajuan != 99) {

                $("#upload_bukti_potong_pph21_modal-id_dokumen_permohonan").val(data.id_dokumen_permohonan);
                $("#upload_bukti_potong_pph21_modal").modal('show');
            }
        }
        $("#input_form_bukti_potong_pph21").on('submit', function (e) {
            e.preventDefault();

            var id_dokumen_permohonan = $("#upload_bukti_potong_pph21_modal-id_dokumen_permohonan").val();
            var bukti_potong_pph21 = $("#bukti_potong_pph21").val();


            if (!id_dokumen_permohonan || !bukti_potong_pph21) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else {
                $("#upload_bukti_potong_pph21_modal-simpan").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });

                jQuery(this).ajaxSubmit({
                    dataType: 'json',
                    success: function (data) {
                        $("#upload_bukti_potong_pph21_modal-simpan").removeAttr('disabled data-kt-indicator');

                        if (data.sts == 1) {
                            $("#upload_bukti_potong_pph21_modal").modal('hide');
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
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }
                });
            }
        })

        // function request_proforma_invoice(i) {
        //     var data = list_data[i];
        //     var pertanyaan = "Apakah Anda yakin ingin request proforma invoice untuk permohonan ini?";
        //     konfirmasi(pertanyaan, function() {
        //         proses_request_invoice(data.id_dokumen_permohonan);
        //     });
        // }

        // function proses_request_invoice(id_dokumen_permohonan) {
        //     //show loading animation...
        //     preloader('show');

        //     var data = new Object;
        //     data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
        //     data['id_dokumen_permohonan'] = id_dokumen_permohonan;

        //     $.ajax({
        //         type: "POST",
        //         url: '<?php echo base_url(); ?>pelanggan_area/proforma_invoice/request_proforma_invoice',
        //         data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
        //         cache: false,
        //         dataType: "json",
        //         success: function(data) {
        //             //hide loading animation...
        //             preloader('hide');

        //             if (data.sts == 1) {
        //                 //load data..
        //                 load_data();
        //                 var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
        //                 toastrAlert(response);
        //             } else if (data.sts == 'tidak_berhak_ubah_data') {
        //                 var response = JSON.parse('<?php echo alert('tidak_berhak_ubah_data'); ?>');
        //                 swalAlert(response);
        //             } else {
        //                 var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
        //                 swalAlert(response);
        //             }
        //         }
        //     });
        // }

        function upload_bukti_bayar(i) {
            var data = list_data[i];
            if (data.status_pengajuan >= 21) {
                //normalisasi...
                $("#surat_oc_pelanggan, #bukti_bayar").show();
                $("#surat_oc_pelanggan_box, #bukti_bayar_box, #bukti_bayar_ditolak").hide();
                $("#bukti_bayar-alasan_penolakan, #nama_file_surat_oc_pelanggan, #nama_file_bukti_bayar").html('');
                $("#link_surat_oc_pelanggan, #link_bukti_bayar").attr('href', '#');
                $("#surat_oc_pelanggan, #bukti_bayar").attr('required', 'required');

                $("#upload_bukti_bayar_modal-action").val('save');

                //cek apakah ada termin I...
                if (data.surat_oc.termin_1 == 0) {
                    $("#bukti_bayar_container").hide();
                    $("#bukti_bayar").removeAttr('required');
                }

                //jika bukti upload ditolak...
                if (data.status_pengajuan == 24) {
                    var nama_file_oc_pelanggan = data.surat_oc.surat_oc_pelanggan.replace('assets/uploads/dokumen/' + data.id_pelanggan + '/', '')
                    var nama_file_bukti_bayar = data.surat_oc.bukti_bayar.replace('assets/uploads/dokumen/' + data.id_pelanggan + '/', '')

                    $("#surat_oc_pelanggan, #bukti_bayar").hide();
                    $("#surat_oc_pelanggan_box, #bukti_bayar_box, #bukti_bayar_ditolak").show();

                    $("#bukti_bayar-alasan_penolakan").html(data.alasan_verifikasi);
                    $("#nama_file_surat_oc_pelanggan").html(nama_file_oc_pelanggan);
                    $("#nama_file_bukti_bayar").html(nama_file_bukti_bayar);


                    $("#link_surat_oc_pelanggan").attr('href', base_url + data.surat_oc.surat_oc_pelanggan);
                    $("#link_bukti_bayar").attr('href', base_url + data.surat_oc.bukti_bayar);

                    $("#surat_oc_pelanggan, #bukti_bayar").removeAttr('required');

                    $("#upload_bukti_bayar_modal-action").val('update');
                }

                $("#upload_bukti_bayar_modal-id_dokumen_permohonan").val(data.id_dokumen_permohonan);
                $("#upload_bukti_bayar_modal").modal('show');
            }
        }

        function hapus_file(element) {
            $("#" + element + "_box").hide();
            $("#" + element).show();

        }

        $("#input_form_bukti_bayar").on('submit', function (e) {
            e.preventDefault();

            var id_dokumen_permohonan = $("#upload_bukti_bayar_modal-id_dokumen_permohonan").val();
            var surat_oc_pelanggan = $("#surat_oc_pelanggan").val();
            var bukti_bayar = $("#bukti_bayar").val();
            var action = $("#upload_bukti_bayar_modal-action").val();

            if (!id_dokumen_permohonan) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else if (action == 'save' && (!surat_oc_pelanggan)) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else {
                $("#upload_bukti_bayar_modal-simpan").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });

                jQuery(this).ajaxSubmit({
                    dataType: 'json',
                    success: function (data) {
                        $("#upload_bukti_bayar_modal-simpan").removeAttr('disabled data-kt-indicator');

                        if (data.sts == 1) {
                            $("#upload_bukti_bayar_modal").modal('hide');
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
                            response.message = response.message.replace('{{upload_error_msg}}', data.error_msg);
                            swalAlert(response);
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }
                });
            }
        })

        $(document).on('click', '#pagination > ul > li > a', function () {
            var page = $(this).text(); // mendapatkan nomor halaman yang di-klik
            // lakukan sesuatu dengan nomor halaman tersebut, misalnya:
            $("#page").val(page);
            load_data();
        });
        $("#filter").keyup(function () {
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
                url: '<?php echo base_url(); ?>pelanggan_area/dokumen_permohonan/load_data',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function (result) {
                    //parse JSON...
                    $("#last_page").val(result.last_page);
                    list_data = result.result;
                    generatePages('#pagination', page, result.last_page);

                    var rangkai = '';
                    if (list_data.length > 0) {
                        for (var i = 0; i < list_data.length; i++) {
                            var tipe_pengajuan = '';
                            var url_form = base_url + 'pelanggan/';
                            if (list_data[i].tipe_pengajuan == 'PEMERINTAH') {
                                url_form += 'berbayar_pemerintah/';
                                tipe_pengajuan = 'Berbayar Pemerintah';
                            } else {
                                url_form += 'berbayar_pelaku_usaha/';
                                tipe_pengajuan = 'Berbayar Pelaku Usaha';
                            }

                            if (list_data[i].tipe_pengajuan == 'PEMERINTAH' && list_data[i].status_pengajuan > 3 && list_data[i].status_pengajuan < 34) {
                                list_data[i].status_pengajuan = 33;
                            }

                            var info_tambahan = '';
                            var button_menu = '';
                            if (list_data[i].status_pengajuan == 3) {
                                button_menu = '<a href="' + url_form + list_data[i].id_dokumen_permohonan + '" class="dropdown-item text-hover-primary">Edit Data</a>';
                                button_menu += '<a href="javascript:;" class="dropdown-item text-hover-danger" onclick="batalkan_pengajuan(' + i + ')">Batalkan Pengajuan</a>';
                            } else {
                                if (list_data[i].tipe_pengajuan == 'PELAKU USAHA') {

                                    if (list_data[i].status_pengajuan >= 10 && list_data[i].status_pengajuan != 99) {
                                        button_menu += '<a href="' + base_url + 'pelanggan/lihat_penawaran/' + list_data[i].id_dokumen_permohonan + '" class="dropdown-item text-hover-primary">Lihat Surat Penawaran</a>';
                                    }
                                    if (list_data[i].status_pengajuan >= 17 && list_data[i].status_pengajuan != 99) {
                                        button_menu += '<a href="' + base_url + 'pelanggan/lihat_oc/' + list_data[i].id_dokumen_permohonan + '" class="dropdown-item text-hover-primary">Lihat Konfirmasi Order</a>';

                                        var proforma_invoice_exist = false;
                                        //cek apakah sudah pernah melakukan request proforma invoice...
                                        if (list_data[i].proforma_invoice) {
                                            proforma_invoice_exist = true;
                                        }

                                        if (list_data[i].status_pengajuan >= 21 && proforma_invoice_exist && list_data[i].status_pengajuan != 99) {
                                            button_menu += '<a href="' + base_url + 'pelanggan/lihat_proforma_invoice/' + list_data[i].id_dokumen_permohonan + '" class="dropdown-item text-hover-primary">Lihat Proforma Invoice</a>';
                                        }

                                        if (list_data[i].status_pengajuan == 21 || list_data[i].status_pengajuan == 22 || list_data[i].status_pengajuan == 24) {
                                            //cek apakah ada termin I...
                                            var tambahan_btn = '';
                                            var info_bukti_pembayaran = '';
                                            if (list_data[i].surat_oc.termin_1 > 0) {
                                                tambahan_btn = ' & Bukti Pembayaran';
                                                info_bukti_pembayaran = ' dan bukti pembayaran sesuai termin I';
                                            }
                                            button_menu += '<div class="separator mb-3 mt-3"></div>';

                                            // if (!proforma_invoice_exist) {
                                            //     button_menu += '<a href="javascript:;" onclick="request_proforma_invoice(' + i + ')" class="dropdown-item text-hover-primary"><?php echo getSvgIcon('general/gen005', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Request Proforma Invoice</a>';
                                            // }

                                            button_menu += '<a href="javascript:;" onclick="upload_bukti_bayar(' + i + ')" class="dropdown-item text-hover-primary"><?php echo getSvgIcon('files/fil022', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Upload Konfirmasi Order' + tambahan_btn + '</a>';

                                            info_tambahan = '<div class="fw-semibold d-block fs-7 mt-3 bg-light-warning rounded border-warning border border-dashed p-3" style="max-width: 350px; text-align: justify; ">Segera upload konfirmasi order yang sudah Anda tanda tangani' + info_bukti_pembayaran + '.</div>';
                                        }
                                    }

                                    if (list_data[i].status_pengajuan >= 25 && list_data[i].status_pengajuan != 99) {
                                        //jika status pengajuan >= 25 tapi belum upload bukti bayar & surat_oc, maka perlu dimunculkan tombolnya
                                        //karena kemungkinan permohonan ini statusnya di bypass...
                                        var dokumen_komplit = true;
                                        if (!list_data[i].surat_oc.surat_oc_pelanggan) {
                                            dokumen_komplit = false;
                                        }
                                        var tambahan_btn = '';
                                        var info_bukti_pembayaran = '';
                                        if (list_data[i].surat_oc.termin_1 > 0) {
                                            tambahan_btn = ' & Bukti Pembayaran';
                                            info_bukti_pembayaran = ' dan bukti pembayaran sesuai termin I';
                                        }

                                        if (list_data[i].surat_oc.termin_1 > 0 && !list_data[i].surat_oc.bukti_bayar) {
                                            dokumen_komplit = false;
                                        }

                                        if (!dokumen_komplit) {
                                            button_menu += '<div class="separator mb-3 mt-3"></div>' +
                                                '<a href="javascript:;" onclick="upload_bukti_bayar(' + i + ')" class="dropdown-item text-hover-primary"><?php echo getSvgIcon('files/fil022', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Upload Konfirmasi Order' + tambahan_btn + '</a>' +
                                                '<div class="separator mb-3 mt-3"></div>';
                                            info_tambahan = '<div class="fw-semibold d-block fs-7 mt-3 bg-light-warning rounded border-warning border border-dashed p-3" style="max-width: 350px; text-align: justify; ">Segera upload konfirmasi order yang sudah Anda tanda tangani' + info_bukti_pembayaran + '.</div>';
                                        } else {
                                            button_menu += '<a href="' + base_url + 'pelanggan/lihat_oc_pelanggan/' + list_data[i].id_dokumen_permohonan + '" class="dropdown-item text-hover-primary">Lihat Konfirmasi Order Pelanggan</a>';
                                        }

                                    }
                                    if (list_data[i].status_pengajuan >= 30 && list_data[i].status_pengajuan != 99) {
                                        button_menu += '<a href="' + base_url + 'pelanggan/lihat_form_01/' + list_data[i].id_dokumen_permohonan + '" class="dropdown-item text-hover-primary">Lihat Form 01</a>';
                                    }

                                }

                                if (list_data[i].status_pengajuan >= 34 && list_data[i].status_pengajuan != 99) {
                                    button_menu += '<a href="' + base_url + 'pelanggan/lihat_invoice/' + list_data[i].id_dokumen_permohonan + '" class="dropdown-item text-hover-primary">Lihat Invoice</a>';
                                    button_menu += '<a href="' + base_url + 'pelanggan/lihat_faktur_pajak/' + list_data[i].id_dokumen_permohonan + '" class="dropdown-item text-hover-primary">Lihat Faktur Pajak</a>';
                                    if (list_data[i].payment_detail.bukti_potong_pph21) {
                                        button_menu += '<a href="' + base_url + 'pelanggan/lihat_bukti_potong_pph21/' + list_data[i].id_dokumen_permohonan + '" class="dropdown-item text-hover-primary">Lihat Bukti Potong PPh 23</a>';
                                    } else {
                                        button_menu += '<div class="separator mb-3 mt-3"></div>';
                                        button_menu += '<a href="javascript:;" onclick="upload_bukti_potong_pph21(' + i + ')" class="dropdown-item text-hover-primary"><?php echo getSvgIcon('files/fil022', 'svg-icon svg-icon-2 svg-icon-primary me-3'); ?> Upload Bukti Potong PPh 23</a>';
                                    }
                                }
                            }

                            var button = '-';
                            if (button_menu != '') {
                                button = '<div class="dropdown">' +
                                    '<button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-boundary="viewport" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                    'Actions' +
                                    '</button>' +
                                    '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
                                    button_menu +
                                    '</div>' +
                                    '</div>';
                            }
                            var nomor_hp_assesor = '';
                            if (list_data[i].nomor_hp_assesor) {
                                nomor_hp_assesor = render_badge('success', '<i class="fa fa-phone-square text-white" style="margin-right: 10px;"></i> ' + list_data[i].nomor_hp_assesor)
                            }
                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +
                                '<td>' +
                                '<div class="text-gray-400 fw-semibold d-block fs-7">' + reformatDate(list_data[i].tgl_pengajuan) + '</div>' +
                                '<span class="text-gray-800 fw-bold fs-6">' + coverMe(list_data[i].nama_tipe_permohonan) + '</span>' +
                                '<div class="text-gray-400 fw-semibold d-block mt-2 fs-7">Tipe Pengajuan</div>' +
                                '<span class="text-gray-800 fw-bold fs-6">' + tipe_pengajuan + '</span>' +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + coverMe(list_data[i].assesor_utama, 'Belum Ada') + '</div>' +
                                nomor_hp_assesor +
                                '</td>' +
                                '<td>' + status_pengajuan_pelanggan_badge(list_data[i].status_pengajuan) + info_tambahan + '</td>' +
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
    </script>
</body>
<!-- end::Body -->

</html>