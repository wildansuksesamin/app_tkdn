<!DOCTYPE html>
<html lang="en" >
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
                                   <?php echo $konten['title']; ?>
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <div class="d-flex align-items-center gap-2 gap-lg-3">
                                <!--begin::Secondary button-->
                                <button type="button" class="btn btn-sm btn-light btn-active-light-primary" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Kembali</button>
                                <!--end::Secondary button-->
                            </div>
                        </div>
                    </div>

                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <div id="kt_app_content_container" class="app-container container-fluid">
                            <div class="card card-flush">
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
                                                        <span class="fw-bold fs-6 text-gray-800" id="nama_perusahaan"><?php echo $konten['pelanggan']->nama_badan_usaha.' '.$konten['pelanggan']->nama_perusahaan; ?></span>
                                                    </div>
                                                </div>
                                                <div class="row mb-7">
                                                    <label class="col-lg-4 fw-semibold text-muted">Alamat</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bold fs-6 text-gray-800" id="alamat_perusahaan"><?php echo $konten['pelanggan']->alamat_perusahaan; ?></span>
                                                    </div>
                                                </div>
                                                <div class="row mb-7">
                                                    <label class="col-lg-4 fw-semibold text-muted">Email</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bold fs-6 text-gray-800" id="email"><?php echo $konten['pelanggan']->email; ?></span>
                                                    </div>
                                                </div>

                                                <div class="mb-7" style="font-weight: bold; font-size: 18px;">Pejabat Penghubung Proses TKDN</div>
                                                <div class="row mb-7">
                                                    <label class="col-lg-4 fw-semibold text-muted">Nama Lengkap</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bold fs-6 text-gray-800" id="nama_pejabat_penghubung_proses_tkdn"><?php echo $konten['pelanggan']->nama_pejabat_penghubung_proses_tkdn; ?></span>
                                                    </div>
                                                </div>
                                                <div class="row mb-7">
                                                    <label class="col-lg-4 fw-semibold text-muted">Jabatan</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bold fs-6 text-gray-800" id="jabatan_pejabat_penghubung_proses_tkdn"><?php echo $konten['pelanggan']->jabatan_pejabat_penghubung_proses_tkdn; ?></span>
                                                    </div>
                                                </div>
                                                <div class="row mb-7">
                                                    <label class="col-lg-4 fw-semibold text-muted">Nomor Telepon</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bold fs-6 text-gray-800" id="telepon_pejabat_penghubung_proses_tkdn"><?php echo $konten['pelanggan']->telepon_pejabat_penghubung_proses_tkdn; ?></span>
                                                    </div>
                                                </div>

                                                <div class="mb-7" style="font-weight: bold; font-size: 18px;">Pejabat Penghubung Invoice</div>
                                                <div class="row mb-7">
                                                    <label class="col-lg-4 fw-semibold text-muted">Nama Lengkap</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bold fs-6 text-gray-800" id="nama_pejabat_penghubung_invoice"><?php echo $konten['pelanggan']->nama_pejabat_penghubung_invoice; ?></span>
                                                    </div>
                                                </div>
                                                <div class="row mb-7">
                                                    <label class="col-lg-4 fw-semibold text-muted">Nomor Telepon</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bold fs-6 text-gray-800" id="telepon_pejabat_penghubung_invoice"><?php echo $konten['pelanggan']->telepon_pejabat_penghubung_invoice; ?></span>
                                                    </div>
                                                </div>

                                                <div class="mb-7" style="font-weight: bold; font-size: 18px;">Pejabat Penghubung Pajak</div>
                                                <div class="row mb-7">
                                                    <label class="col-lg-4 fw-semibold text-muted">Nama Lengkap</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bold fs-6 text-gray-800" id="nama_pejabat_penghubung_pajak"><?php echo $konten['pelanggan']->nama_pejabat_penghubung_pajak; ?></span>
                                                    </div>
                                                </div>
                                                <div class="row mb-7">
                                                    <label class="col-lg-4 fw-semibold text-muted">Nomor Telepon</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bold fs-6 text-gray-800" id="telepon_pejabat_penghubung_pajak"><?php echo $konten['pelanggan']->telepon_pejabat_penghubung_pajak; ?></span>
                                                    </div>
                                                </div>
                                            </form>
                                            <!--end::Form-->

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
</body>
<!-- end::Body -->
</html>
