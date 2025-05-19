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
                                                                    <th>ETC</th>
                                                                    <th class="w-150px text-end pe-3">Action</th>
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

    <div class="modal fade" id="penugasan_etc_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h5>Data ETC</h5>
                        <h3 id="display_nama_pelanggan" class="mt-3"></h3>
                        <div id="display_nomor_order"></div>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form fv-plugins-bootstrap5 fv-plugins-framework mb-12" method="post" id="input_penugasan_etc" action="<?php echo base_url(); ?>opening_meeting_etc/simpan" autocomplete="off">
                        <div class="row">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="required fs-5 fw-semibold mb-2">Nama ETC</label>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih data" id="id_admin" name="id_admin" required>
                                            <?php
                                            if ($konten['verifikator']->num_rows() > 0) {
                                                foreach ($konten['verifikator']->result() as $list) {
                                                    echo '<option value="' . $list->id_admin . '">' . $list->nama_admin . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 text-end">
                                        <input type="hidden" name="token" value="<?php echo genToken('SEND_DATA'); ?>">
                                        <input type="hidden" id="id_opening_meeting" name="id_opening_meeting">
                                        <button type="submit" id="modal_assesor-simpan" class="btn btn-primary">
                                            <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                            <span class="indicator-progress">Loading...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="zona_data_etc">
                        <div class="d-flex flex-column flex-lg-row">
                            <!--begin::Content-->
                            <div class="flex-lg-row-fluid me-0">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped gy-5" id="data_etc">
                                        <thead>
                                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                <th>No.</th>
                                                <th>ETC Terpilih</th>
                                                <th class="w-150px text-end pe-3">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <!--end::Content-->

                    </div>
                    <!--end::Layout-->
                </div>
            </div>
        </div>
    </div>
    </div>

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

        var ajax_request;
        var list_data;

        function load_data() {
            var page = $("#page").val();
            var jml_data = 10;
            var blink_notif = '<span class="bullet bullet-dot bg-danger h-6px w-6px translate-middle animation-blink ms-2"></span>';

            var filter = $("#filter").val();

            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['page'] = page;
            data['jml_data'] = jml_data;
            data['filter'] = filter;
            data['for'] = 'penugasan_etc';

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
                            var assesor_lapangan = '';
                            if (list_data[i].assesor_lapangan) {
                                assesor_lapangan = '<div class="mt-3 fs-7 fw-bold">Verifikator Survey Lapangan:</div>';
                                for (var j = 0; j < list_data[i].assesor_lapangan.length; j++) {
                                    assesor_lapangan += '<span class="badge badge-light-primary">' + list_data[i].assesor_lapangan[j].nama_admin + '</span>';
                                }
                            }

                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold mb-1 fs-6">' + list_data[i].nomor_order_payment + '</div>' +
                                render_badge_tipe_pengajuan(list_data[i].tipe_pengajuan) +
                                '</td>' +
                                '<td>' +
                                '<div class="text-gray-800 fw-bold fs-6" style="max-width: 350px; text-overflow:ellipsis;overflow: hidden;white-space: nowrap;">' + list_data[i].nama_badan_usaha + ' ' + list_data[i].nama_perusahaan + '</div>' +
                                (assesor_lapangan ? assesor_lapangan : 'Belum Ada Verifikator Lapangan') +
                                '</td>' +
                                '<td>' +
                                render_badge('success', list_data[i].jml_etc + ' Orang') +
                                '</td>' +
                                '<td class="text-end pe-3">' +
                                '<div class="me-0">' +
                                '<button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-kt-menu="true" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">' +
                                'Actions' +
                                '</button>' +
                                '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true" style="">' +

                                '<div class="menu-item px-3">' +
                                '<a href="javascript:;" onclick="penugasan_etc(' + i + ')" class="menu-link px-3"><i class="fa fa-users pe-3"></i> ETC</a>' +
                                '</div>' +

                                (list_data[i].jml_etc > 0 ?
                                    '<div class="menu-item px-3">' +
                                    '<a href="javascript:;" onclick="kirim_etc(' + i + ')" class="menu-link px-3"><i class="fa fa-paper-plane pe-3"></i> Kirim Ke ETC</a>' +
                                    '</div>' :
                                    '') +

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

        function kirim_etc(i) {
            var pertanyaan = "Apakah Anda yakin ingin menyerahkan ke ETC?";

            konfirmasi(pertanyaan, function() {
                $("#setuju").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });
                proses_kirim_etc(list_data[i].id_opening_meeting);
            });

        }

        function proses_kirim_etc(id_opening_meeting) {
            if (id_opening_meeting) {
                //show loading animation...
                preloader('show');

                var data = new Object;
                data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
                data['id_opening_meeting'] = id_opening_meeting;

                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>opening_meeting_etc/kirim_etc',
                    data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                    cache: false,
                    dataType: "json",
                    success: function(data) {
                        preloader('hide');

                        if (data.sts == 1) {
                            var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                            swalAlert(response);

                            load_data();
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }

                });
            }
        }

        function penugasan_etc(i) {
            $("#id_opening_meeting").val(list_data[i].id_opening_meeting);

            $("#display_nama_pelanggan").html(list_data[i].nama_badan_usaha + ' ' + list_data[i].nama_perusahaan);
            $("#display_nomor_order").html(render_badge_tipe_pengajuan(list_data[i].nomor_order_payment));
            $("#penugasan_etc_modal").modal('show');

            if (list_data[i].id_opening_meeting) {
                load_etc(list_data[i].id_opening_meeting);
            }
        }

        function load_etc(id_opening_meeting) {
            preloader('show');
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;

            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>opening_meeting_etc/load_data',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(list_data) {
                    preloader('hide');

                    var rangkai = '';
                    if (list_data.length > 0) {
                        for (var i = 0; i < list_data.length; i++) {
                            rangkai += '<tr>' +
                                '<td>' + (i + 1) + '.</td>' +
                                '<td>' +
                                list_data[i].nama_admin +
                                '</td>' +

                                '<td class="text-end pe-3">' +
                                '<button type="button" class="btn btn-danger btn-sm" onclick="hapus_etc(' + list_data[i].id_opening_meeting_etc + ', \'' + list_data[i].nama_admin + '\')"><i class="fa fa-trash me-3"></i> Hapus</button>' +
                                '</td>' +
                                '</tr>';
                        }

                        $("#empty_state").remove();
                        $("#zona_data_etc").show();

                        $("#data_etc tbody").html(rangkai);
                    } else {
                        create_empty_state("#zona_data_etc");
                    }
                }
            })

        }

        $("#input_penugasan_etc").on('submit', function(e) {
            e.preventDefault();

            var id_opening_meeting = $("#id_opening_meeting").val();
            var id_admin = $("#id_admin").val();

            if (!id_opening_meeting || !id_admin) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else {
                $("#modal_assesor-simpan").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });
                jQuery(this).ajaxSubmit({
                    dataType: 'json',
                    success: function(data) {
                        $("#modal_assesor-simpan").removeAttr('disabled data-kt-indicator');

                        if (data.sts == 1) {
                            load_data();
                            load_etc(id_opening_meeting);

                            var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                            toastrAlert(response);
                        } else if (data.sts == 'data_available') {
                            var response = JSON.parse('<?php echo alert('data_available'); ?>');
                            swalAlert(response);
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }
                });
            }
        });

        function hapus_etc(id_opening_meeting_etc, nama_assesor) {
            var pertanyaan = "Apakah Anda yakin ingin menghapus verifikator <strong>" + nama_assesor + "</strong>?";

            konfirmasi(pertanyaan, function() {
                proses_hapus_etc(id_opening_meeting_etc);
            });
        }

        function proses_hapus_etc(id_opening_meeting_etc) {
            preloader('show');
            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_opening_meeting_etc'] = id_opening_meeting_etc;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>opening_meeting_etc/hapus',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    //hide loading animation...
                    preloader('hide');

                    if (data.sts == 1) {
                        var id_opening_meeting = $("#id_opening_meeting").val();

                        //load data..
                        load_data();
                        load_etc(id_opening_meeting);
                        var response = JSON.parse('<?php echo alert('hapus_berhasil'); ?>');
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