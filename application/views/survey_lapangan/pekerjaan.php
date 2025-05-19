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
                                                                    <th>Anggaran</th>
                                                                    <th>Dokumen</th>
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

    <div class="modal fade" id="rab_subsidi_silang_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h2>RAB Subsidi Silang</h2>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped gy-5" id="data_rab_subsidi_silang">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                    <th>No.</th>
                                    <th>Nomor Order</th>
                                    <th>Sisa Dana</th>
                                    <th class="w-150px text-end pe-3">Action</th>
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

    <div class="modal fade" id="subsidi_silang_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h2>Subsidi Silang</h2>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="form_subsidi_silang" action="<?php echo base_url(); ?>survey_lapangan_subsidi_silang/simpan" autocomplete="off">
                        <div>
                            <div class="text-gray-800 fw-bold" id="subsidi-nomor_oc"></div>
                            <div class="badge badge-info" id="subsidi-perusahaan"></div>
                            <div class="mt-3 fs-6 text-gray-500">Sisa Dana</div>
                            <div class="text-gray-800 fw-bold fs-3" id="subsidi-sisa_dana_text"></div>

                            <input type="hidden" name="id_rab_sumber" id="subsidi-id_rab_sumber">
                            <input type="hidden" name="id_rab_tujuan" id="subsidi-id_rab_tujuan">
                            <input type="hidden" name="sisa_dana" id="subsidi-sisa_dana">

                            <div class="separator mb-10 mt-10"></div>
                            <div class="mt-3 fs-6 text-gray-500 required">Dana Yang Diambil</div>
                            <div class="input-group input-group-solid mb-5">
                                <span class="input-group-text" id="basic-addon2">Rp</span>
                                <input type="text" id="subsidi-pengambilan_dana" name="pengambilan_dana" class="form-control form-control-lg fs-2" autocomplete="off" onkeyup="convertToRupiah(this)" required />
                            </div>

                            <input type="hidden" name="token" id="subsidi-token" value="<?php echo genToken('SEND_DATA'); ?>">

                            <button type="submit" id="subsidi-simpan" class="btn btn-primary">
                                <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                <span class="indicator-progress">Loading...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="upload_dokumen_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h2>Upload Dokumen <span id="judul_upload"></span></h2>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_survey_lapangan_dokumen" action="<?php echo base_url(); ?>/survey_lapangan_perjab/simpan" autocomplete="off" enctype="multipart/form-data">
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                            <!--begin::Icon-->
                            <?php echo getSvgIcon('general/gen045', 'svg-icon svg-icon-2tx svg-icon-primary me-4') ?>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1">
                                <!--begin::Content-->
                                <div class="fw-semibold">
                                    <div class="fs-6 text-gray-700">
                                        <div class="fw-bold text-danger">Harap Dibaca!</div>Dokumen yang diperbolehkan hanya dokumen yang berjenis <b>PDF</b>.</span>
                                    </div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-12 fv-row fv-plugins-icon-container">
                                <label class=" fs-5 fw-semibold mb-2">File Surat Tugas</label>
                                <input type="file" class="form-control form-control-solid" autocomplete="off" id="upload_file-file_surat_tugas" name="file_surat_tugas">
                            </div>

                            <div class="col-md-12 fv-row fv-plugins-icon-container">
                                <label class=" fs-5 fw-semibold mb-2">File Perjab</label>
                                <input type="file" class="form-control form-control-solid" autocomplete="off" id="upload_file-file_perjab" name="file_perjab">
                            </div>
                            <div class="col-md-12 fv-row fv-plugins-icon-container">
                                <label class="required fs-5 fw-semibold mb-2">Biaya Operasional</label>
                                <div class="input-group input-group-solid mb-5">
                                    <span class="input-group-text" id="basic-addon2">Rp</span>
                                    <input type="text" class="form-control form-control-solid" autocomplete="off" id="upload_file-biaya_operasional" name="biaya_operasional" onkeyup="convertToRupiah(this)" required>

                                </div>
                            </div>
                        </div>

                        <button type="submit" id="upload_file-simpan" class="btn btn-primary">
                            <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                            <span class="indicator-progress">Loading...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>

                        <input type="hidden" class="form-control" id="upload_file-id_opening_meeting" name="id_opening_meeting">
                        <input type="hidden" class="form-control" id="upload_file-tipe_file" name="tipe_file">
                        <input type="hidden" id="token" name="token" value="<?php echo genToken('SEND_DATA'); ?>">

                    </form>
                    <div class="table-responsive" id="data_dokumen_zone">
                        <div class="separator mb-10 mt-10"></div>
                        <h4>Data Dokumen</h4>
                        <div id="data_dokumen"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detail_anggaran_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h2>Detail Anggaran</h2>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-wrap align-items-center">
                        <div>Pendapatan (Excl PPN)</div>
                        <div class="ms-auto" id="detail_anggaran-nilai_kontrak" style="text-align: right;">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center">
                        <div>Verifikasi dokumen</div>
                        <div class="ms-auto" id="detail_anggaran-verifikasi_dokumen" style="text-align: right;">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center">
                        <div>Factory overhead</div>
                        <div class="ms-auto" id="detail_anggaran-factory_overhead" style="text-align: right;">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center">
                        <div>IWO</div>
                        <div class="ms-auto" id="detail_anggaran-iwo" style="text-align: right;">
                        </div>
                    </div>

                    <div class="d-flex flex-wrap align-items-center">
                        <div class="fw-bold">Nilai RAB</div>
                        <div class="ms-auto fw-bold" id="detail_anggaran-nilai_rab" style="text-align: right; border-top: 1px solid #000">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center">
                        <div>Profit Operasional SCI</div>
                        <div class="ms-auto" id="detail_anggaran-profit_operasional_sci" style="text-align: right;">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center">
                        <div>Tambahan subsidi silang</div>
                        <div class="ms-auto" id="detail_anggaran-tambahan_subsidi_silang" style="text-align: right;">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="fw-bold">Biaya operasi</div>
                        <div class="ms-auto fw-bold" id="detail_anggaran-anggaran_operasional" style="text-align: right; border-top: 1px solid #000">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center">
                        <div>SPPD</div>
                        <div class="ms-auto" id="detail_anggaran-sppd" style="text-align: right;">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center">
                        <div>Biaya operasional</div>
                        <div class="ms-auto" id="detail_anggaran-biaya_operasional" style="text-align: right;">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center">
                        <div>Pengambilan subsidi silang</div>
                        <div class="ms-auto" id="detail_anggaran-pengurangan_subsidi_silang" style="text-align: right;">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="fw-bold">Laba operasi</div>
                        <div class="ms-auto fw-bold" id="detail_anggaran-sisa_biaya" style="text-align: right;border-top: 1px solid #000">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="fw-bold">Profit margin (%)</div>
                        <div class="ms-auto fw-bold" id="detail_anggaran-sisa_biaya_persen" style="text-align: right">
                        </div>
                    </div>

                    <input type="hidden" name="from" id="from">
                    <input type="hidden" name="index_from" id="index_from">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="riwayat_subsidi_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h2>Riwayat Subsidi Silang</h2>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped gy-5" id="data_subsidi_silang">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                    <th>No</th>
                                    <th>Tgl Subsidi</th>
                                    <th>Nomor Order</th>
                                    <th>Pelanggan</th>
                                    <th>Nominal Subsidi</th>
                                    <th>Action</th>
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

  <script>
$(document).ready(function() {
    function loadData() {
          var page = $("#page").val();
            var jml_data = 10;

            var filter = $("#filter").val();

            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['page'] = page;
            data['jml_data'] = jml_data;
            data['filter'] = filter;
            
            function escapeHtml(text) {
    return $('<div>').text(text).html();
}
      $.ajax({
    type: "POST",
    url: '<?php echo base_url(); ?>data_pekerjaan/load_data',
    data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
    cache: false,
    dataType: "json",
    success: function(res) {
        let html = '';

        if (res.result && res.result.length > 0) {
            res.result.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${((page - 1) * jml_data) + index + 1}</td>
                        <td>${escapeHtml(item.biaya_operasional)}</td>
                        <td>` +
                            (item.file_perjab !== '' ?
                                `<a href="` + base_url + `page/preview_dokumen/?file=` + base_url + escapeHtml(item.file_perjab) + `" target="_blank" class="menu-link px-3"><?php echo getSvgIcon(`files/fil003`, `svg-icon svg-icon-2 svg-icon-primary me-3`); ?> File Perjab</a>
                                <br>` : '') +
                            (item.file_surat_tugas !== '' ?
                                `<a href="` + base_url + `page/preview_dokumen/?file=` + base_url + escapeHtml(item.file_surat_tugas) + `" target="_blank" class="menu-link px-3"><?php echo getSvgIcon(`files/fil003`, `svg-icon svg-icon-2 svg-icon-primary me-3`); ?> File Surat Tugas</a>` : '') +

                            // `<div class="me-0">` +
                            // `<button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-kt-menu="true" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">` +
                            // `Dokumen` +
                            // `</button>` +
                            // `<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true" style="">` +

                            // `<div class="menu-item px-3">` +
                            // `</div>` +

                            // `</div>` +
                            // `</div>` +
                        `</td>
                        <td>` +
                        
                            `<td class="text-end pe-3">` +
                            `<div class="me-0">` +
                            `<button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" data-kt-menu="true" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">` +
                            `Actions` +
                            `</button>` +
                            `<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true" style="">` +
                            `<a href="${base_url}page/update_pekerjaan/${item.id_survey_lapangan_perjab}" type="button" class="btn btn-primary" >Update Data</a>` +
                            
                            `</div>` +
                            `</div>` +
                            `</td>` + 
                            // <button class="btn btn-sm btn-primary" data-id="${escapeHtml(item.id_survey_lapangan_perjab)}">Detail</button>
                        `</td>
                    </tr>
                `;
            });
        } else {
            html = `<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>`;
        }

        // Tampilkan data ke tabel #data_form_01
        $('#data_form_01 tbody').html(html);
        KTMenu.createInstances();

        // Set halaman saat ini dan total halaman
        $('#page').val(res.current_page);
        $('#last_page').val(res.last_page);

        // Render pagination jika ada fungsi renderPagination
        if (typeof renderPagination === 'function') {
            renderPagination(res.current_page, res.last_page);
        }
    },
    error: function(err) {
        console.error('Gagal load data:', err.responseText);
        $('#data_form_01 tbody').html('<tr><td colspan="6" class="text-center text-danger">Terjadi kesalahan saat mengambil data</td></tr>');
    }
});
    }

    function renderPagination(current, last) {
        let pagination = '';
        for (let i = 1; i <= last; i++) {
            pagination += `<button class="btn btn-sm ${i === current ? 'btn-primary' : 'btn-light'} me-1" data-page="${i}">${i}</button>`;
        }
        $('#pagination').html(pagination);
    }

    $('#pagination').on('click', 'button', function() {
        let page = $(this).data('page');
        let keyword = $('#filter').val();
        loadData(page, keyword);
    });

    $('#filter').on('keyup', function() {
        let keyword = $(this).val();
        loadData(1, keyword);
    });

    // Load awal
    loadData();

    $('#updateFileModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var anggaran = button.data('anggaran')
        var modal = $(this)
        modal.find('.modal-body input #anggaran').val(anggaran)
    })
});
</script>

</body>
<!-- end::Body -->

</html>