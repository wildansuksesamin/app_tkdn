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
                                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Jabatan</h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <button type="button" class="btn btn-sm fw-bold btn-primary tabel_zone" onclick="form_action('show')"><i class="fa fa-square-plus fs-1 me-2"></i> Tambah Jabatan</button>
                                </div>
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <div class="card card-flush form_zone hidden" id="form_jns_admin">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>Form Jabatan</h2>
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
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_jns_admin" action="<?php echo base_url(); ?>jns_admin/simpan" autocomplete="off">
                                                    <input type="hidden" class="form-control" id="id_jns_admin" name="id_jns_admin" maxlength="11" placeholder="">

                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nama Jabatan</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="jns_admin" name="jns_admin" maxlength="50" placeholder="" required>
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

                                <div class="card card-flush h-lg-100 tabel_zone" id="tabel_jns_admin">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <!--begin::Search-->
                                            <div class="d-flex align-items-center position-relative my-1">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                <?php echo getSvgIcon('general/gen021', 'svg-icon svg-icon-1 position-absolute ms-4'); ?>
                                                <!--end::Svg Icon-->
                                                <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="<?php _lang('keyword_pencarian'); ?>" id="filter" name="filter">
                                            </div>
                                            <!--end::Search-->
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17">
                                        <!--begin::Layout-->
                                        <div class="d-flex flex-column flex-lg-row">
                                            <!--begin::Content-->
                                            <div class="flex-lg-row-fluid me-0">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-striped gy-5" id="data_jns_admin">
                                                        <thead>
                                                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                <th>No.</th>
                                                                <th>Jabatan</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div>
                                                    <input type="hidden" id="page" name="page" value="1">
                                                    <input type="hidden" id="last_page" name="last_page">
                                                    <div id="pagination"></div>
                                                </div>
                                            </div>
                                            <!--end::Content-->

                                        </div>
                                        <!--end::Layout-->
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
            $("#input_form_jns_admin")[0].reset();
            if (action == 'show') {
                $(".form_zone").fadeIn(300);
                $(".tabel_zone").hide();
            } else {
                $(".form_zone").hide();
                $(".tabel_zone").fadeIn(300);
            }
        }

        var list_data;
        $("#input_form_jns_admin").on('submit', function(e) {
            e.preventDefault();

            var id_jns_admin = $("#id_jns_admin").val();
            var jns_admin = $("#jns_admin").val();

            var action = $("#action").val();

            if (!action) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
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

                            $("#input_form_jns_admin")[0].reset();
                            $("#action").val('save');
                            form_action('hide');
                            //load data..
                            load_data();

                            var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                            toastrAlert(response);
                        } else if (data.sts == 'tidak_berhak') {
                            var response = JSON.parse('<?php echo alert('tidak_berhak_ubah_data'); ?>');
                            swalAlert(response);
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
            $("#id_jns_admin").val(decodeHtml(data.id_jns_admin));
            $("#jns_admin").val(decodeHtml(data.jns_admin));

            $("#action").val('update');

        }

        function hapus(index) {
            var data = list_data[index];
            var pertanyaan = "<?php _lang('konfirmasi_hapus'); ?>";

            konfirmasi(pertanyaan, function() {
                proses_hapus(data.id_jns_admin);
            });
        }

        function proses_hapus(id) {
            //show loading animation...
            var blockUI = generate_blockUI("#kt_app_body");
            blockUI.block();

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_jns_admin'] = id;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>Jns_admin/hapus',
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
                    } else if (data.sts == 'tidak_berhak') {
                        var response = JSON.parse('<?php echo alert('tidak_berhak_hapus_data'); ?>');
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

            var blockUI = generate_blockUI("#data_jns_admin");
            blockUI.block();
            ajax_request = $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>Jns_admin/load_data',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    blockUI.release();
                    blockUI.destroy();

                    $("#last_page").val(result.last_page);
                    generatePages('#pagination', page, result.last_page);
                    list_data = result.result;

                    var rangkai = '';
                    if (list_data.length > 0) {
                        for (var i = 0; i < list_data.length; i++) {
                            var btn_action = '<div class="dropdown">' +
                                '<button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-boundary="viewport" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                'Actions' +
                                '</button>' +
                                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
                                '<a class="dropdown-item" href="#" onclick="edit(' + i + ')"><?php _lang('edit'); ?></a>' +
                                '<a class="dropdown-item" href="#" onclick="hapus(' + i + ')"><?php _lang('hapus'); ?></a>' +
                                '</div>' +
                                '</div>';

                            if (list_data[i].id_jns_admin == 1) {
                                btn_action = '<i><?php _lang('Tidak ada hak'); ?></i>';
                            }
                            rangkai += '<tr>' +
                                '<td>' + (((page - 1) * jml_data) + i + 1) + '.</td>' +
                                '<td>' + list_data[i].jns_admin + '</td>' +
                                '<td>' +

                                btn_action +
                                '</td>' +
                                '</tr>';
                        }
                    }

                    if (rangkai) {
                        $("#empty_state").remove();
                        $("#data_zona_jns_admin").show();

                        $("#data_jns_admin tbody").html(rangkai);
                    } else {
                        if (page == 1 && filter == '')
                            create_empty_state("#data_zona_jns_admin");
                        else
                            $("#data_jns_admin tbody").html('');
                    }

                }

            });
        }
        load_data();
    </script>
</body>
<!--begin::Theme mode setup on page load-->
<!-- end::Body -->

</html>