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

                                <div class="d-flex align-items-center gap-2 gap-lg-3">

                                    <a href="<?php echo base_url() . 'panel_internal/dokumen_lhv/' . $konten['id_panel_internal_lhv']; ?>" class="btn btn-sm fw-bold btn-primary" target="_blank"><i class="fa fa-file-pdf me-3"></i>Lihat Dokumen</a>
                                    <a href="<?php echo base_url('page/upload_dokumen_panel_internal/' . $konten['opening_meeting']->id_opening_meeting); ?>" class="btn btn-sm fw-bold btn-light-primary btn-active-light-primary"><i class="fa fa-arrow-left fs-5 me-2"></i> Kembali</a>
                                </div>
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <?php $this->view('collecting_document/include/header'); ?>

                                <div class="card card-flush h-lg-100 tabel_zone mb-5 mb-xl-10">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>Form LHV</h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <div class="d-flex flex-column flex-lg-row">
                                            <!--begin::Content-->
                                            <div class="flex-lg-row-fluid me-0">
                                                <!--begin::Form-->
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_lhv" action="<?php echo base_url(); ?>panel_internal/simpan_lhv" autocomplete="off">

                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Jenis Produk</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="lhv_jns_produk" name="lhv_jns_produk" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Spesifikasi</label>
                                                            <textarea class="form-control form-control-solid" name="lhv_spesifikasi" id="lhv_spesifikasi"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class=" row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tipe</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="lhv_tipe" name="lhv_tipe" required>
                                                        </div>

                                                    </div>

                                                    <div class="separator mb-10 mt-10"></div>

                                                    <button type="submit" id="simpan" class="btn btn-primary">
                                                        <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                                        <span class="indicator-progress">Loading...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>

                                                    <input type="hidden" id="id_opening_meeting" name="id_opening_meeting" value="<?php echo $konten['opening_meeting']->id_opening_meeting; ?>">
                                                    <input type="hidden" id="id_panel_internal_lhv" name="id_panel_internal_lhv" value="<?php echo $konten['id_panel_internal_lhv']; ?>">
                                                    <input type="hidden" id="token" name="token" value="<?php echo genToken('SEND_DATA'); ?>">

                                                </form>
                                                <!--end::Form-->

                                            </div>
                                            <!--end::Content-->

                                        </div>

                                    </div>
                                    <!--end::Body-->
                                </div>

                                <div class="card card-flush h-lg-100 mb-5 mb-xl-10 update_mode hidden">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>Bahan Baku</h2>
                                        </div>
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-sm btn-primary" onclick="tambah_bahan_baku()">
                                                <i class="fa fa-plus"></i> Bahan Baku
                                            </button>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped gy-5" id="tabel_bahan_baku">
                                                <thead>
                                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                        <th class="w-20px">No</th>
                                                        <th>Bahan Baku</th>
                                                        <th>Negara</th>
                                                        <th>Produsen</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-flush h-lg-100 mb-5 mb-xl-10 update_mode hidden">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>Galeri Foto</h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <div class="d-flex flex-column flex-lg-row">
                                            <div class="flex-lg-row-fluid me-0 mb-10">
                                                <h4>Foto Perusahaan</h4>
                                                <div class="d-flex flex-wrap" id="galeri_foto_perusahaan">
                                                    <div class="text-center me-3">
                                                        <button class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary w-125px h-125px" onclick="upload_foto('foto_perusahaan', 'Foto Perusahaan')"><i class="fa fa-image fs-1"></i></button>
                                                        <div class="fw-bold fs-6 mt-2">Tambah Foto</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-lg-row">
                                            <div class="flex-lg-row-fluid me-0 mb-10">
                                                <h4>Foto Mesin / Alat Kerja</h4>
                                                <div class="d-flex flex-wrap" id="galeri_foto_alat_kerja">
                                                    <div class="text-center me-3">
                                                        <button class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary w-125px h-125px" onclick="upload_foto('foto_alat_kerja', 'Foto Mesin / Alat Kerja')"><i class="fa fa-image fs-1"></i></button>
                                                        <div class="fw-bold fs-6 mt-2">Tambah Foto</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-lg-row">
                                            <div class="flex-lg-row-fluid me-0 mb-10">
                                                <h4>Foto Bahan Baku</h4>
                                                <div class="d-flex flex-wrap" id="galeri_foto_bahan_baku">
                                                    <div class="text-center me-3">
                                                        <button class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary w-125px h-125px" onclick="upload_foto('foto_bahan_baku', 'Foto Bahan Baku')"><i class="fa fa-image fs-1"></i></button>
                                                        <div class="fw-bold fs-6 mt-2">Tambah Foto</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-lg-row">
                                            <div class="flex-lg-row-fluid me-0 mb-10">
                                                <h4>Foto Produk</h4>
                                                <div class="d-flex flex-wrap" id="galeri_foto_produk">
                                                    <div class="text-center me-3">
                                                        <button class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary w-125px h-125px" onclick="upload_foto('foto_produk', 'Foto Produk')"><i class="fa fa-image fs-1"></i></button>
                                                        <div class="fw-bold fs-6 mt-2">Tambah Foto</div>
                                                    </div>
                                                </div>
                                            </div>
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

    <div class="modal fade" id="file_assesment_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h2>File Assessment</h2>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped gy-5" id="file_collecting_dokumen">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                    <th class="w-20px">No</th>
                                    <th>Data</th>
                                    <th class="w-100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="upload_foto_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h2>Upload <span id="judul_galeri"></span></h2>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">

                    <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_foto" action="<?php echo base_url(); ?>panel_internal/simpan_foto_lhv" autocomplete="off">
                        <input type="hidden" name="group_file" id="group_file">
                        <input type="hidden" name="id_panel_internal_dokumen" id="id_panel_internal_dokumen">
                        <input type="hidden" name="id_nama_file" id="id_nama_file" value="<?php echo $konten['nama_file']->id_nama_file; ?>">
                        <div class="text-center">
                            <!--begin::Image input-->
                            <div class="image-input image-input-empty" data-kt-image-input="true" style="background-image: url('<?php echo base_url() . $no_photo_url; ?>'); background-repeat:no-repeat; background-position: center center;">
                                <!--begin::Image preview wrapper-->
                                <div class="image-input-wrapper w-200px h-200px shadow" id="tempat_foto"></div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-40px h-40px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Upload Foto">
                                    <i class="bi bi-upload fs-4"></i>

                                    <!--begin::Inputs-->
                                    <input type="file" id="foto" name="foto" accept=".png, .jpg, .jpeg" onchange="imageCompressor('#foto')">
                                    <input type="hidden" id="foto_blob" name="foto_blob">
                                    <input type="hidden" name="foto_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-40px h-40px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Hapus Foto">
                                    <i class="fa fa-times fs-4"></i>
                                </span>
                                <!--end::Cancel button-->

                                <!--begin::Remove button-->
                                <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-40px h-40px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Hapus Foto">
                                    <i class="fa fa-times fs-4"></i>
                                </span>
                                <!--end::Remove button-->
                            </div>
                            <!--end::Image input-->

                        </div>

                        <div class="row mb-5 mt-5">
                            <div class="col-md-12 fv-row fv-plugins-icon-container text-center">
                                <label class="required fs-5 fw-semibold mb-2">Judul Foto</label>
                                <input type="text" class="form-control form-control-solid text-center" autocomplete="off" id="judul_foto" name="judul_foto" required>
                            </div>
                        </div>

                        <div class="separator mb-10 mt-10"></div>

                        <div class="text-center">
                            <button type="submit" id="upload_foto" class="btn btn-primary">
                                <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                <span class="indicator-progress">Loading...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <button type="button" id="batal" class="btn btn-light-primary btn-active-light-primary btn-outline-primary btn-outline" onclick="$('#upload_foto_modal').modal('hide')">
                                <span class="indicator-label"><i class="fa-solid fa-times me-2 fs-3"></i> Batal</span>
                            </button>
                        </div>

                        <input type="hidden" name="id_opening_meeting" value="<?php echo $konten['opening_meeting']->id_opening_meeting; ?>">
                        <input type="hidden" name="id_panel_internal_lhv" value="<?php echo $konten['id_panel_internal_lhv']; ?>">
                        <input type="hidden" name="token" value="<?php echo genToken('SEND_DATA'); ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $this->view('include/js'); ?>

    <script>
        function tambah_bahan_baku() {
            $("#empty_state").remove();
            preloader('show');
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['id_opening_meeting'] = $("#id_opening_meeting").val();
            data['id_nama_file'] = 2; //id_nama_file = 2 adalah untuk file assesment

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>panel_internal/load_folder',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    preloader('hide');
                    var rangkai = '';
                    if (result.length > 0) {
                        var files = result[0].files;
                        if (files.length > 0) {
                            for (var i = 0; i < files.length; i++) {
                                var data_file = '<a href="' + base_url + files[i].path_file + '" download class="text-gray-800 text-hover-primary fw-bold">' + files[i].value.replace(/_/g, ' ') + '</a>';
                                if (files[i].jns_file == 'textarea') {
                                    data_file = '<div class="text-gray-800 fw-bold">' + files[i].value + '</div>';
                                }

                                var kolom_tambahan = '';
                                if (files[i].kolom_tambahan) {
                                    var list_tambahan = safelyParseJSON(files[i].kolom_tambahan);
                                    if (list_tambahan.length > 0) {
                                        kolom_tambahan = '<div class="row">';
                                        for (var a = 0; a < list_tambahan.length; a++) {
                                            kolom_tambahan += '<div class="col-sm-6 mb-3"><div class="text-gray-600 fs-7">' + list_tambahan[a].label + '</div><div>' + coverMe(list_tambahan[a].value) + '</div></div>';
                                        }
                                        kolom_tambahan += '</div>';
                                    }
                                }

                                rangkai += '<tr>' +
                                    '<td>' + (i + 1) + '</td>' +
                                    '<td>' +
                                    data_file +
                                    kolom_tambahan +
                                    '</td>' +
                                    '<td>' +
                                    '<button type="button" class="btn btn-sm btn-primary" onclick="pilih_assesment(' + files[i].id_panel_internal_dokumen + ')"><i class="fa fa-check"></i> Pilih</button>' +
                                    '</td>' +
                                    '</tr>';
                            }

                            $("#file_collecting_dokumen tbody").html(rangkai);
                        } else {
                            create_empty_state('#file_collecting_dokumen');

                        }
                    } else {
                        create_empty_state('#file_collecting_dokumen');
                    }
                }

            });
            $("#file_assesment_modal").modal('show');
        }

        function pilih_assesment(id_panel_internal_dokumen) {
            var id_opening_meeting = $("#id_opening_meeting").val();
            var id_panel_internal_lhv = $("#id_panel_internal_lhv").val();

            preloader('show');
            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_opening_meeting'] = id_opening_meeting;
            data['id_panel_internal_lhv'] = id_panel_internal_lhv;
            data['id_panel_internal_dokumen'] = id_panel_internal_dokumen;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>panel_internal/pilih_assesment',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    preloader('hide');
                    if (data.sts == 1) {
                        $("#file_assesment_modal").modal('hide');
                        load_bahan_baku();
                        load_foto();

                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        toastrAlert(response);

                    } else if (data.sts == 'file_tidak_ditemukan') {
                        var response = JSON.parse('<?php echo alert('file_tidak_ditemukan'); ?>');
                        swalAlert(response);

                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }
            });
        }

        function load_bahan_baku() {
            preloader('show');
            $("#empty_state").remove();
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['id_panel_internal_lhv'] = $("#id_panel_internal_lhv").val();

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>panel_internal/load_bahan_baku',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    preloader('hide');
                    var rangkai = '';
                    if (result.length > 0) {
                        for (var i = 0; i < result.length; i++) {
                            rangkai += '<tr>' +
                                '<td>' + (i + 1) + '</td>' +
                                '<td>' + result[i].bahan_baku + '</td>' +
                                '<td>' + result[i].negara + '</td>' +
                                '<td>' + result[i].produsen + '</td>' +
                                '</tr>';
                        }

                        $("#tabel_bahan_baku").show();
                        $("#tabel_bahan_baku tbody").html(rangkai);
                    } else {
                        create_empty_state('#tabel_bahan_baku');
                    }
                }

            });

        }

        function upload_foto(group_file, judul_galeri, id_panel_internal_dokumen, judul_foto, path_file) {
            $("#input_form_foto")[0].reset();
            $("#foto_blob").val('');
            $("#judul_galeri").html(judul_galeri);
            $("#group_file").val(group_file);
            $("#id_panel_internal_dokumen").val((id_panel_internal_dokumen ? id_panel_internal_dokumen : ''));
            $("#judul_foto").val((judul_foto ? judul_foto : ''));

            if (path_file) {
                setTimeout(() => {
                    $("#tempat_foto").css('background-image', "url('" + base_url + path_file + "')");
                }, 300);
            } else {
                $("#tempat_foto").css('background-image', 'unset');
            }
            $('[data-kt-image-input-action="cancel"]').click();
            $("#upload_foto_modal").modal('show');
        }
        $("#input_form_foto").on('submit', function(e) {
            e.preventDefault();
            var foto_blob = $("#foto_blob").val();
            var judul_foto = $("#judul_foto").val();

            if (judul_foto == '' || judul_foto == '') {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else {

                $("#upload_foto").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });

                jQuery(this).ajaxSubmit({
                    dataType: 'json',
                    success: function(data) {
                        $("#upload_foto").removeAttr('disabled data-kt-indicator');

                        if (data.sts == 1) {
                            load_foto();
                            $("#upload_foto_modal").modal('hide');
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

        function load_foto() {
            preloader('show');
            $(".galeri").remove();
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['id_opening_meeting'] = $("#id_opening_meeting").val();
            data['id_panel_internal_lhv'] = $("#id_panel_internal_lhv").val();
            data['id_nama_file'] = $("[name=\"id_nama_file\"]").val();

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>panel_internal/load_foto_lhv',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    preloader('hide');
                    var rangkai = '';
                    if (result.length > 0) {
                        for (var i = 0; i < result.length; i++) {
                            var gambar = '<div class="text-center me-5 mb-10 galeri">' +
                                '<div class="symbol symbol-125px">' +
                                '<img src="' + base_url + result[i].path_file + '" class="w-125px h-125px border border-dashed border-primary cursor-pointer" onclick="upload_foto(\'foto_bahan_baku\', \'Foto Bahan Baku\', ' + result[i].id_panel_internal_dokumen + ', \'' + result[i].value + '\', \'' + result[i].path_file + '\')" style="object-fit: cover;" <?php echo $no_photo_for_js; ?>>' +
                                '<button class="position-absolute translate-middle top-0 start-100 bg-danger rounded-circle border border-4 border-body h-30px w-30px" onclick="hapus_gambar(\'' + result[i].id_panel_internal_dokumen + '\')"><i class="fa fa-trash fs-8 text-white"></i></button>' +
                                '</div>' +
                                '<div class="w-125px fs-8 mt-2">' + result[i].value + '</div>' +
                                '</div>';

                            $("#galeri_" + result[i].group_file).append(gambar);
                        }
                    }
                }

            });
        }

        function hapus_gambar(id_panel_internal_dokumen) {
            var pertanyaan = "Apakah Anda yakin ingin menghapus gambar ini?";

            konfirmasi(pertanyaan, function() {
                proses_hapus(id_panel_internal_dokumen);
            });
        }

        function proses_hapus(id_panel_internal_dokumen) {
            preloader('show');
            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_panel_internal_dokumen'] = id_panel_internal_dokumen;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>panel_internal/hapus_foto_lhv',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    preloader('hide');

                    if (data.sts == 1) {
                        //load data..
                        load_foto();
                        var response = JSON.parse('<?php echo alert('hapus_berhasil'); ?>');
                        toastrAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }


                }

            });
        }
        var list_data;
        $("#input_form_lhv").on('submit', function(e) {
            e.preventDefault();
            var lhv_jns_produk = $("#lhv_jns_produk").val();
            var lhv_spesifikasi = $("#lhv_spesifikasi").val();
            var lhv_tipe = $("#lhv_tipe").val();

            if (lhv_jns_produk == '' || lhv_spesifikasi == '' || lhv_tipe == '') {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else {

                $("#simpan").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });

                jQuery(this).ajaxSubmit({
                    dataType: 'json',
                    success: function(data) {
                        $("#simpan").removeAttr('disabled data-kt-indicator');

                        if (data.sts == 1) {
                            var id_panel_internal_lhv = data.id_panel_internal_lhv;
                            $("#id_panel_internal_lhv").val(id_panel_internal_lhv);

                            $("#input_form_lhv")[0].reset();
                            var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                            response.callback_yes = after_simpan;
                            swalAlert(response);

                            form_action('hide');
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }

                    }
                });
            }

        });

        function after_simpan() {
            var id_opening_meeting = $("#id_opening_meeting").val();
            var id_panel_internal_lhv = $("#id_panel_internal_lhv").val();
            location.href = base_url + 'page/lhv/' + id_opening_meeting + '?id_lhv=' + id_panel_internal_lhv;
        }

        function load_data() {
            var id_opening_meeting = $("#id_opening_meeting").val();
            var id_panel_internal_lhv = $("#id_panel_internal_lhv").val();

            if (id_opening_meeting && id_panel_internal_lhv) {
                preloader('show');
                var data = new Object;
                data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
                data['id_opening_meeting'] = id_opening_meeting
                data['id_panel_internal_lhv'] = id_panel_internal_lhv

                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>panel_internal/load_lhv',
                    data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                    cache: false,
                    dataType: "json",
                    success: function(result) {
                        preloader('hide');
                        var rangkai = '';
                        if (result.length > 0) {
                            var row = result[0];
                            $("#lhv_jns_produk").val(row.lhv_jns_produk);
                            $("#lhv_spesifikasi").val(row.lhv_spesifikasi);
                            $("#lhv_tipe").val(row.lhv_tipe);
                        }
                    }

                });
            }
        }

        $(document).ready(function() {
            var id_panel_internal_lhv = $("#id_panel_internal_lhv").val();
            if (id_panel_internal_lhv) {
                $(".update_mode").show();
            }
            load_data();
            load_foto();
            load_bahan_baku();
        });
    </script>
</body>
<!-- end::Body -->

</html>