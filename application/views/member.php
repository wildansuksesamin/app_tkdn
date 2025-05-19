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
                                        <?php _lang('Member'); ?>
                                    </h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <button type="button" class="btn btn-sm fw-bold btn-primary tabel_zone" onclick="form_action('show')">
                                        <i class="fa fa-square-plus fs-1 me-2"></i>
                                        <?php _lang('Tambah Member'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <div class="card card-flush form_zone hidden" id="form_administrator">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>
                                                <?php _lang('Form Member'); ?>
                                            </h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17">
                                        <!--begin::Layout-->
                                        <div class="d-flex flex-column flex-lg-row">
                                            <!--begin::Content-->
                                            <div class="flex-lg-row-fluid me-0">
                                                <!--begin::Form-->
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_member" action="<?php echo base_url(); ?>Member/simpan" autocomplete="off">
                                                    <input type="hidden" class="form-control" id="id_member" name="id_member" maxlength="11" placeholder="">
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2"><?php _lang('Nama Member') ?></label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_member" name="nama_member" maxlength="200" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2"><?php _lang('Tgl Lahir') ?></label>
                                                            <input type="text" class="form-control form-control-solid datepicker" autocomplete="off" id="tgl_lahir" name="tgl_lahir" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2"><?php _lang('Tgl Daftar') ?></label>
                                                            <input type="text" class="form-control form-control-solid datetimepicker" autocomplete="off" id="tgl_daftar" name="tgl_daftar" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class=" fs-5 fw-semibold mb-2"><?php _lang('Waktu Login') ?></label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="waktu_login" name="waktu_login" maxlength="100" placeholder="">
                                                        </div>
                                                    </div>


                                                    <div class="separator mb-10 mt-10"></div>
                                                    <button type="submit" class="btn btn-primary" id="simpan">
                                                        <i class="fa-solid fa-floppy-disk me-2 fs-3"></i>
                                                        <?php _lang('simpan'); ?>
                                                    </button>

                                                    <button class="btn btn-light btn-active-light-primary me-2" type="button" onclick="form_action('hide')">
                                                        <i class="fa-solid fa-times me-2 fs-3"></i>
                                                        <?php _lang('batal'); ?>
                                                    </button>

                                                    <input type="hidden" id="action" name="action" value="save">
                                                    <input type="hidden" id="token" name="token" value="<?php echo genToken('SEND_DATA'); ?>">

                                                </form>
                                                <!--end::Form-->

                                            </div>
                                            <!--end::Content-->

                                        </div>
                                        <!--end::Layout-->
                                    </div>
                                    <!--end::Body-->
                                </div>

                                <div class="card card-flush h-lg-100 tabel_zone" id="tabel_member">
                                    <div class="card-header align-items-center py-5 gap-2 gap-md-5" data-select2-id="select2-data-124-ftn2">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <!--begin::Search-->
                                            <div class="d-flex align-items-center position-relative my-1">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                <?php echo getSvgIcon('general/gen021', 'svg-icon svg-icon-1 position-absolute ms-4'); ?>
                                                <!--end::Svg Icon-->
                                                <input type="text" class="form-control form-control-solid w-250px ps-14" id="filter" name="filter" placeholder="<?php _lang('keyword_pencarian'); ?>">
                                            </div>
                                            <!--end::Search-->
                                        </div>
                                        <!--end::Card title-->

                                    </div>

                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17" style="padding-top: unset!important;">
                                        <!--begin::Layout-->
                                        <div id="data_zona_member">
                                            <div class="d-flex flex-column flex-lg-row">
                                                <!--begin::Content-->
                                                <div class="flex-lg-row-fluid me-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-striped gy-5" id="data_member">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th><?php _lang('nomor'); ?></th>
                                                                    <th><?php _lang('Nama Member') ?></th>
                                                                    <th><?php _lang('Tgl Lahir') ?></th>
                                                                    <th><?php _lang('Tgl Daftar') ?></th>
                                                                    <th><?php _lang('Waktu Login') ?></th>

                                                                    <th><?php _lang('action'); ?></th>
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
        function form_action(action) {
            //reset form...
            $("#input_form_member")[0].reset();
            $("#action").val('save');

            if (action == 'show') {
                $(".form_zone").fadeIn(300);
                $(".tabel_zone").hide();
            } else {
                $(".form_zone").hide();
                $(".tabel_zone").fadeIn(300);
            }
        }

        var list_data;
        $("#input_form_member").on('submit', function(e) {
            e.preventDefault();

            var id_member = $("#id_member").val();
            var nama_member = $("#nama_member").val();
            var tgl_lahir = $("#tgl_lahir").val();
            var tgl_daftar = $("#tgl_daftar").val();
            var waktu_login = $("#waktu_login").val();

            var action = $("#action").val();

            if (!action || !nama_member || !tgl_lahir || !tgl_daftar) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else if (!moment(tgl_lahir).isValid()) {
                var response = JSON.parse('<?php echo alert('format_tgl_salah'); ?>');
                swalAlert(response);
            } else if (!moment(tgl_daftar).isValid()) {
                var response = JSON.parse('<?php echo alert('format_tgl_salah'); ?>');
                swalAlert(response);
            } else {
                var blockUI = generate_blockUI("#kt_app_body");
                blockUI.block();

                jQuery(this).ajaxSubmit({
                    dataType: 'json',
                    success: function(data) {
                        blockUI.release();
                        blockUI.destroy();

                        if (data.sts == 1) {
                            //hapus seluruh field...
                            $("#page").val(1);

                            $("#input_form_member")[0].reset();
                            $("#action").val('save');
                            form_action('hide');
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
        });

        function edit(index) {
            form_action('show');
            var data = list_data[index];
            $("#id_member").val(decodeHtml(data.id_member));
            $("#nama_member").val(decodeHtml(data.nama_member));
            $("#tgl_lahir").val(reformatDate(data.tgl_lahir));
            $("#tgl_daftar").val(reformatDate(data.tgl_daftar));
            $("#waktu_login").val(decodeHtml(data.waktu_login));

            $("#action").val('update');

        }

        function hapus(index) {
            var data = list_data[index];
            var pertanyaan = "<?php _lang('konfirmasi_hapus'); ?>";

            konfirmasi(pertanyaan, function() {
                proses_hapus(data.id_member);
            });
        }

        function proses_hapus(id) {
            //show loading animation...
            var blockUI = generate_blockUI("#kt_app_body");
            blockUI.block();

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_member'] = id;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>Member/hapus',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
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
        var blockUI_data;

        function load_data() {
            var page = $("#page").val();
            var jml_data = 10;

            var filter = $("#filter").val();

            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['page'] = page;
            data['jml_data'] = jml_data;
            data['filter'] = filter;


            var blockUI_data = generate_blockUI("#data_member");
            blockUI_data.block();

            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>Member/load_data',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    blockUI_data.release();
                    blockUI_data.destroy();

                    //parse JSON...
                    $("#last_page").val(result.last_page);
                    list_data = result.result;
                    generatePages('#pagination', page, result.last_page);

                    var rangkai = '';
                    if (list_data.length > 0) {
                        for (var i = 0; i < list_data.length; i++) {
                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +
                                '<td>' + coverMe(list_data[i].nama_member) + '</td>' +
                                '<td>' + reformatDate(list_data[i].tgl_lahir) + '</td>' +
                                '<td>' + reformatDate(list_data[i].tgl_daftar) + '</td>' +
                                '<td>' + coverMe(list_data[i].waktu_login) + '</td>' +

                                '<td>' +
                                '<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md" onClick="edit(' + i + ')" title="<?php _lang('edit'); ?>"><i class="la la-edit"></i></button>' +
                                '<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md" onClick="hapus(' + i + ')" title="<?php _lang('hapus'); ?>"><i class="la la-trash"></i></button>' +
                                '</td>' +
                                '</tr>';
                        }
                    }

                    if (rangkai) {
                        $("#empty_state").remove();
                        $("#data_zona_member").show();

                        $("#data_member tbody").html(rangkai);
                    } else {
                        if (page == 1 && filter == '') {
                            create_empty_state("#data_zona_member");
                        } else
                            $("#data_member tbody").html('');
                    }

                }

            });
        }
        load_data();
    </script>
</body>
<!-- end::Body -->

</html>