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
                                        Data Pelanggan
                                    </h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <div class="card card-flush form_zone hidden" id="form_pelanggan">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>
                                                Detail Pelanggan
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
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_pelanggan" action="<?php echo base_url(); ?>/simpan" autocomplete="off">
                                                    <input type="hidden" class="form-control" id="id_pelanggan" name="id_pelanggan" maxlength="11" placeholder="">
                                                    <div class="row mb-7">
                                                        <label class="col-lg-4 fw-semibold text-muted">Nama Perusahaan</label>
                                                        <div class="col-lg-8">
                                                            <span class="fw-bold fs-6 text-gray-800" id="nama_perusahaan"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-7">
                                                        <label class="col-lg-4 fw-semibold text-muted">Alamat</label>
                                                        <div class="col-lg-8">
                                                            <span class="fw-bold fs-6 text-gray-800" id="alamat_perusahaan"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-7">
                                                        <label class="col-lg-4 fw-semibold text-muted">Email</label>
                                                        <div class="col-lg-8">
                                                            <span class="fw-bold fs-6 text-gray-800" id="email"></span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-7" style="font-weight: bold; font-size: 18px;">Pejabat Penghubung Proses TKDN</div>
                                                    <div class="row mb-7">
                                                        <label class="col-lg-4 fw-semibold text-muted">Nama Lengkap</label>
                                                        <div class="col-lg-8">
                                                            <span class="fw-bold fs-6 text-gray-800" id="nama_pejabat_penghubung_proses_tkdn"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-7">
                                                        <label class="col-lg-4 fw-semibold text-muted">Jabatan</label>
                                                        <div class="col-lg-8">
                                                            <span class="fw-bold fs-6 text-gray-800" id="jabatan_pejabat_penghubung_proses_tkdn"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-7">
                                                        <label class="col-lg-4 fw-semibold text-muted">Nomor Telepon</label>
                                                        <div class="col-lg-8">
                                                            <span class="fw-bold fs-6 text-gray-800" id="telepon_pejabat_penghubung_proses_tkdn"></span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-7" style="font-weight: bold; font-size: 18px;">Pejabat Penghubung Invoice</div>
                                                    <div class="row mb-7">
                                                        <label class="col-lg-4 fw-semibold text-muted">Nama Lengkap</label>
                                                        <div class="col-lg-8">
                                                            <span class="fw-bold fs-6 text-gray-800" id="nama_pejabat_penghubung_invoice"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-7">
                                                        <label class="col-lg-4 fw-semibold text-muted">Nomor Telepon</label>
                                                        <div class="col-lg-8">
                                                            <span class="fw-bold fs-6 text-gray-800" id="telepon_pejabat_penghubung_invoice"></span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-7" style="font-weight: bold; font-size: 18px;">Pejabat Penghubung Pajak</div>
                                                    <div class="row mb-7">
                                                        <label class="col-lg-4 fw-semibold text-muted">Nama Lengkap</label>
                                                        <div class="col-lg-8">
                                                            <span class="fw-bold fs-6 text-gray-800" id="nama_pejabat_penghubung_pajak"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-7">
                                                        <label class="col-lg-4 fw-semibold text-muted">Nomor Telepon</label>
                                                        <div class="col-lg-8">
                                                            <span class="fw-bold fs-6 text-gray-800" id="telepon_pejabat_penghubung_pajak"></span>
                                                        </div>
                                                    </div>

                                                    <div class="separator mb-10 mt-10"></div>
                                                    <button class="btn btn-light btn-active-light-primary me-2" type="button" onclick="form_action('hide')">
                                                        <i class="fa-solid fa-arrow-left me-2 fs-3"></i>
                                                        Kembali
                                                    </button>
                                                </form>
                                                <!--end::Form-->

                                            </div>
                                            <!--end::Content-->

                                        </div>
                                        <!--end::Layout-->
                                    </div>
                                    <!--end::Body-->
                                </div>

                                <div class="card card-flush h-lg-100 tabel_zone" id="tabel_pelanggan">
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
                                        <div id="data_zona_pelanggan">
                                            <div class="d-flex flex-column flex-lg-row">
                                                <!--begin::Content-->
                                                <div class="flex-lg-row-fluid me-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-striped gy-5" id="data_pelanggan">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th>No</th>
                                                                    <th>Nama Perusahaan</th>
                                                                    <th>Email</th>
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
        function form_action(action) {
            //reset form...
            $("#input_form_pelanggan")[0].reset();
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

        function edit(index) {
            form_action('show');
            var data = list_data[index];
            $("#nama_perusahaan").html(data.nama_badan_usaha + ' ' + data.nama_perusahaan);
            $("#alamat_perusahaan").html(decodeHtml(data.alamat_perusahaan));
            $("#email").html(decodeHtml(data.email));
            $("#nama_pejabat_penghubung_proses_tkdn").html(decodeHtml(data.nama_pejabat_penghubung_proses_tkdn));
            $("#jabatan_pejabat_penghubung_proses_tkdn").html(decodeHtml(data.jabatan_pejabat_penghubung_proses_tkdn));
            $("#telepon_pejabat_penghubung_proses_tkdn").html(decodeHtml(data.telepon_pejabat_penghubung_proses_tkdn));
            $("#nama_pejabat_penghubung_invoice").html(decodeHtml(data.nama_pejabat_penghubung_invoice));
            $("#telepon_pejabat_penghubung_invoice").html(decodeHtml(data.telepon_pejabat_penghubung_invoice));
            $("#nama_pejabat_penghubung_pajak").html(decodeHtml(data.nama_pejabat_penghubung_pajak));
            $("#telepon_pejabat_penghubung_pajak").html(decodeHtml(data.telepon_pejabat_penghubung_pajak));


        }

        function hapus(index) {
            var data = list_data[index];
            var pertanyaan = "Apakah Anda yakin akan menghapus data pelanggan <b>" + data.nama_badan_usaha + ' ' + data.nama_perusahaan + "</b>?";

            konfirmasi(pertanyaan, function() {
                proses_hapus(data.id_pelanggan);
            });
        }

        function proses_hapus(id) {
            //show loading animation...
            var blockUI = generate_blockUI("#kt_app_body");
            blockUI.block();

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_pelanggan'] = id;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>data_pelanggan/hapus',
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
                url: '<?php echo base_url(); ?>data_pelanggan/load_data',
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
                                '<td class="mw-350px">' +
                                '<div style="font-weight: bold;">' + list_data[i].nama_badan_usaha + ' ' + list_data[i].nama_perusahaan + '</div>' +
                                '<div class="text-gray-600">' + list_data[i].alamat_perusahaan + '</div>' +
                                '</td>' +
                                '<td>' + coverMe(list_data[i].email) + '</td>' +
                                '<td>' +
                                '<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-primary" onClick="edit(' + i + ')" title="Lihat detail pelanggan"><span class="svg-icon svg-icon-muted svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"/><path d="M12.0006 11.1542C13.1434 11.1542 14.0777 10.22 14.0777 9.0771C14.0777 7.93424 13.1434 7 12.0006 7C10.8577 7 9.92348 7.93424 9.92348 9.0771C9.92348 10.22 10.8577 11.1542 12.0006 11.1542Z" fill="currentColor"/><path d="M15.5652 13.814C15.5108 13.6779 15.4382 13.551 15.3566 13.4331C14.9393 12.8163 14.2954 12.4081 13.5697 12.3083C13.479 12.2993 13.3793 12.3174 13.3067 12.3718C12.9257 12.653 12.4722 12.7981 12.0006 12.7981C11.5289 12.7981 11.0754 12.653 10.6944 12.3718C10.6219 12.3174 10.5221 12.2902 10.4314 12.3083C9.70578 12.4081 9.05272 12.8163 8.64456 13.4331C8.56293 13.551 8.49036 13.687 8.43595 13.814C8.40875 13.8684 8.41781 13.9319 8.44502 13.9864C8.51759 14.1133 8.60828 14.2403 8.68991 14.3492C8.81689 14.5215 8.95295 14.6757 9.10715 14.8208C9.23413 14.9478 9.37925 15.0657 9.52439 15.1836C10.2409 15.7188 11.1026 15.9999 11.9915 15.9999C12.8804 15.9999 13.7421 15.7188 14.4586 15.1836C14.6038 15.0748 14.7489 14.9478 14.8759 14.8208C15.021 14.6757 15.1661 14.5215 15.2931 14.3492C15.3838 14.2312 15.4655 14.1133 15.538 13.9864C15.5833 13.9319 15.5924 13.8684 15.5652 13.814Z" fill="currentColor"/></svg></span></button>' +
                                '<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-danger" onClick="hapus(' + i + ')" title="Hapus pelanggan"><span class="svg-icon svg-icon-muted svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"/><path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"/><path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"/></svg></span></button>' +
                                '</td>' +
                                '</tr>';
                        }
                    }

                    if (rangkai) {
                        $("#empty_state").remove();
                        $("#data_zona_pelanggan").show();

                        $("#data_pelanggan tbody").html(rangkai);
                    } else {
                        if (page == 1 && filter == '') {
                            create_empty_state("#data_zona_pelanggan");
                        } else
                            $("#data_pelanggan tbody").html('');
                    }

                }

            });
        }
        load_data();
    </script>
</body>
<!-- end::Body -->

</html>