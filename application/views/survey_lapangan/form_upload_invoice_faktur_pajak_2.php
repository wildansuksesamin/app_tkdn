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

                                <?php if ($this->session->flashdata('error_message')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo $this->session->flashdata('error_message'); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php endif; ?>

                                <div class="card card-flush">
                                    <div class="card-body">
                                        <?php
                                        $is_edit = isset($konten['data_edit']);
                                        $form_action = base_url('page/proses_upload_invoice_faktur_pajak_2');
                                        ?>
                                        <form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data">
                                            <?php if ($is_edit): ?>
                                                <input type="hidden" name="id" value="<?php echo $konten['data_edit']->id; ?>">
                                                <input type="hidden" name="old_file_invoice" value="<?php echo $konten['data_edit']->file_invoice; ?>">
                                                <input type="hidden" name="old_file_faktur" value="<?php echo $konten['data_edit']->file_faktur; ?>">
                                            <?php endif; ?>

                                            <div class="mb-5">
                                                <label for="file_invoice" class="form-label required">File Invoice</label>
                                                <input type="file" class="form-control form-control-solid" id="file_invoice" name="file_invoice" <?php echo !$is_edit ? 'required' : ''; ?>>
                                                <?php if ($is_edit && $konten['data_edit']->file_invoice): ?>
                                                    <div class="form-text">File saat ini:
                                                        <a href="<?php echo base_url('assets/uploads/invoice/' . $konten['data_edit']->file_invoice); ?>" target="_blank">
                                                            <?php echo $konten['data_edit']->file_invoice; ?>
                                                        </a>. Kosongkan jika tidak ingin mengubah.
                                                    </div>
                                                <?php endif; ?>
                                                <div class="form-text">Tipe file yang diizinkan: pdf, jpg, jpeg, png.</div>
                                            </div>

                                            <div class="mb-5">
                                                <label for="file_faktur" class="form-label required">File Faktur Pajak</label>
                                                <input type="file" class="form-control form-control-solid" id="file_faktur" name="file_faktur" <?php echo !$is_edit ? 'required' : ''; ?>>
                                                <?php if ($is_edit && $konten['data_edit']->file_faktur): ?>
                                                    <div class="form-text">File saat ini:
                                                        <a href="<?php echo base_url('assets/uploads/faktur/' . $konten['data_edit']->file_faktur); ?>" target="_blank">
                                                            <?php echo $konten['data_edit']->file_faktur; ?>
                                                        </a>. Kosongkan jika tidak ingin mengubah.
                                                    </div>
                                                <?php endif; ?>
                                                <div class="form-text">Tipe file yang diizinkan: pdf, jpg, jpeg, png.</div>
                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <a href="<?php echo base_url('page/upload_invoice_faktur_pajak_2'); ?>" class="btn btn-light me-3">Batal</a>
                                                <button type="submit" class="btn btn-primary">
                                                    <?php echo $is_edit ? 'Update Data' : 'Simpan Data'; ?>
                                                </button>
                                            </div>
                                        </form>
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
</body>
</html>