<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->view('include/head'); ?>
    <?php $this->view('include/css'); ?>
</head>
<body <?php echo $body_parameter; ?>>
    <div class="page-loader flex-column">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-muted fs-6 fw-semibold mt-5">Loading...</span>
    </div>
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <?php $this->view('include/top_navbar'); ?>
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <?php $this->view('include/left_side_navbar'); ?>
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <div class="d-flex flex-column flex-column-fluid">
                        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                        <?php echo $konten['title']; ?>
                                    </h1>
                                    </div>
                                </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">

                                <?php if (!empty($konten['success_message'])): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php echo $konten['success_message']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($konten['error_message'])): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo $konten['error_message']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php endif; ?>

                                <div class="card card-flush h-lg-100">
                                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                        <div class="card-title">
                                            <div class="d-flex align-items-center position-relative my-1">
                                                <?php echo getSvgIcon('general/gen021', 'svg-icon svg-icon-1 position-absolute ms-4');?>
                                                <input type="text" class="form-control form-control-solid w-250px ps-14" id="filter" name="filter" placeholder="Masukkan kata kunci pencarian">
                                            </div>
                                            </div>
                                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                            <a href="<?php echo base_url('page/tambah_upload_invoice_faktur_pajak_2'); ?>" class="btn btn-primary">Tambah Data</a>
                                        </div>
                                        </div>

                                    <div class="card-body pt-0"> <div class="table-responsive">
                                            <table class="table table-sm table-striped gy-5" id="data_form_01">
                                                <thead>
                                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                        <th>No.</th>
                                                        <th>File Invoice</th>
                                                        <th>File Faktur</th>
                                                        <th>Tanggal Upload</th>
                                                        <th class="w-150px text-end pe-3">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    if (!empty($konten['data'])) {
                                                        foreach ($konten['data'] as $row) {
                                                            echo '<tr>';
                                                            echo '<td>' . $no . '</td>';
                                                            echo '<td><a href="' . base_url() . 'assets/uploads/invoice/' . $row['file_invoice'] . '" target="_blank">' . $row['file_invoice'] . '</a></td>';
                                                            echo '<td><a href="' . base_url() . 'assets/uploads/faktur/' . $row['file_faktur'] . '" target="_blank">' . $row['file_faktur'] . '</a></td>';
                                                            echo '<td>' . (new DateTime($row['created_at']))->format('d M Y H:i:s') . '</td>';
                                                            echo '<td class="text-end">';
                                                            echo '<a href="' . base_url('page/edit_upload_invoice_faktur_pajak_2/' . $row['id']) . '" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary me-1" title="Edit"><i class="fa fa-pencil-alt"></i></a>';
                                                            echo '<a href="' . base_url('page/hapus_upload_invoice_faktur_pajak_2/' . $row['id']) . '" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" title="Hapus" onclick="return confirm(\'Anda yakin ingin menghapus data ini beserta filenya?\');"><i class="fa fa-trash"></i></a>';
                                                            echo '</td>';
                                                            echo '</tr>';
                                                            $no++;
                                                        }
                                                    } else {
                                                        echo '<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>';
                                                    }
                                                    ?>
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
                                    </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->view('include/footer'); ?>
                </div>
                </div>
            </div>
        </div>

    <?php $this->view('include/js'); ?>
    <script>
        $(document).ready(function() {
            $("#filter").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#data_form_01 tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            }); 
        });
    </script>

</body>
</html>