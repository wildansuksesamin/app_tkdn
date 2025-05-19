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
                                <div class="card card-flush form_zone">
                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17">
                                        <div class="<?php echo ($konten['action'] == 'revisi' ? '' : 'hidden'); ?>">
                                            <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-9 p-6 hidden">
                                                <!--begin::Icon-->
                                                <?php echo getSvgIcon('general/gen040', 'svg-icon svg-icon-2tx svg-icon-danger me-4'); ?>
                                                <!--end::Icon-->
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack flex-grow-1">
                                                    <!--begin::Content-->
                                                    <div class="fw-semibold">
                                                        <h4 class="text-gray-900 fw-bold">Alasan Penolakan</h4>
                                                        <div class="fs-6 text-gray-700" id="alasan_penolakan"><?php echo ($konten['action'] == 'revisi' ? $konten['surat_oc']->alasan_verifikasi : ''); ?></div>
                                                    </div>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                        </div>
                                        <!--begin::Layout-->
                                        <div class="d-flex flex-column flex-lg-row">
                                            <!--begin::Content-->
                                            <div class="flex-lg-row-fluid me-0">
                                                <!--begin::Form-->
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_form_01" action="<?php echo base_url(); ?>Form_01/simpan" autocomplete="off">
                                                    <input type="hidden" class="form-control" id="id_form_01" name="id_form_01" maxlength="11" placeholder="" value="<?php echo ($konten['form_01'] ? $konten['form_01']->id_form_01 : ''); ?>">
                                                    <input type="hidden" class="form-control" id="id_surat_oc" name="id_surat_oc" value="<?php echo $konten['surat_oc']->id_surat_oc; ?>">
                                                    <input type="hidden" class="form-control" id="id_dokumen_permohonan" name="id_dokumen_permohonan" value="<?php echo $konten['surat_oc']->id_dokumen_permohonan; ?>">

                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="fs-5 fw-semibold mb-2">Unit Kerja SBU / Cabang</label>
                                                            <input type="text" class="form-control form-control-solid" value="<?php echo $cabang; ?>" disabled>
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Sub Untit Kerja (Operasional)</label>
                                                            <select class="form-select" data-control="select2" id="sub_unit_kerja" name="sub_unit_kerja">
                                                                <option value="B01 / LSI">B01 / LSI</option>
                                                                <option value="B01 / PIK">B01 / PIK</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="fw-bold fs-4 mb-3 pt-10">1. PELANGGAN</div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama Pelanggan</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" value="<?php echo $konten['surat_oc']->nama_badan_usaha . ' ' . $konten['surat_oc']->nama_perusahaan; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Alamat Pelanggan</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" value="<?php echo $konten['surat_oc']->alamat_perusahaan; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">NPWP</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="npwp" name="npwp" value="<?php echo $konten['surat_oc']->nomor_npwp; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama Kontak</label>
                                                        <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="nama_kontak_pelanggan" name="nama_kontak_pelanggan" required value="<?php echo ($konten['form_01'] ? $konten['form_01']->nama_kontak_pelanggan : $konten['surat_oc']->nama_pejabat_penghubung_proses_tkdn); ?>">
                                                        </div>
                                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6">Jabatan</label>
                                                        <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="jabatan_pelanggan" name="jabatan_pelanggan" required value="<?php echo ($konten['form_01'] ? $konten['form_01']->jabatan_pelanggan : $konten['surat_oc']->jabatan_pejabat_penghubung_proses_tkdn); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nomor Telepon/HP/faks</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="nomor_telepon_pelanggan" name="nomor_telepon_pelanggan" required value="<?php echo ($konten['form_01'] ? $konten['form_01']->nomor_telepon_pelanggan : $konten['surat_oc']->telepon_pejabat_penghubung_proses_tkdn); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="fw-bold fs-4 mb-3 pt-10">2. REFERENSI</div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Nomor Kontrak</label>
                                                        <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" disabled value="<?php echo $konten['surat_oc']->nomor_oc; ?>">
                                                        </div>
                                                        <label class="col-lg-2 col-form-label fw-semibold fs-6">Tanggal</label>
                                                        <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" disabled value="<?php echo reformat_date($konten['surat_oc']->tgl_oc, $konten['date_option']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Nomor SPK/PO/IWO</label>
                                                        <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="nomor_spk_po_iwo" name="nomor_spk_po_iwo" maxlength="100" value="<?php echo ($konten['form_01'] ? $konten['form_01']->nomor_spk_po_iwo : ''); ?>">
                                                        </div>
                                                        <label class="col-lg-2 col-form-label fw-semibold fs-6">Tanggal</label>
                                                        <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="tgl_spk_po_iwo" name="tgl_spk_po_iwo" value="<?php echo ($konten['form_01'] and $konten['form_01']->tgl_spk_po_iwo != '0000-00-00' ? $konten['form_01']->tgl_spk_po_iwo : ''); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="fw-bold fs-4 mb-3 pt-10">3. KOMODITAS/OBJEK</div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama komoditas/objek</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="nama_komoditas" name="nama_komoditas" required value="<?php echo ($konten['form_01'] ? $konten['form_01']->nama_komoditas : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Deskripsi komoditas/objek</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="deskripsi_komoditas" name="deskripsi_komoditas" value="<?php echo ($konten['form_01'] ? $konten['form_01']->deskripsi_komoditas : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Kuantitas Komoditas/objek</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="number" class="form-control form-control-lg form-control-solid" autocomplete="off" id="kuantitas_komoditas" name="kuantitas_komoditas" value="<?php echo ($konten['form_01'] ? $konten['form_01']->kuantitas_komoditas : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Nilai Komoditas/objek(FOB)</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="nilai_komoditas" name="nilai_komoditas" value="<?php echo ($konten['form_01'] ? $konten['form_01']->nilai_komoditas : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Informasi Tambahan</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="informasi_tambahan" name="informasi_tambahan" value="<?php echo ($konten['form_01'] ? $konten['form_01']->informasi_tambahan : ''); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="fw-bold fs-4 mb-3 pt-10">4. JASA</div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama Jenis Jasa</label>
                                                        <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="jenis_jasa" name="jenis_jasa" readonly>
                                                        </div>
                                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6">Kode</label>
                                                        <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="kode_jasa" name="kode_jasa" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Kegiatan Kegiatan</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="kegiatan_kegiatan" name="kegiatan_kegiatan" value="<?php echo ($konten['form_01'] ? $konten['form_01']->kegiatan_kegiatan : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tanggal Pelaksanaan Awal</label>
                                                        <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="tgl_mulai_pelaksanaan" name="tgl_mulai_pelaksanaan" value="<?php echo $konten['surat_oc']->tgl_mulai_pelaksanaan; ?>">
                                                        </div>
                                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6">Tanggal Pelaksanaan Akhir</label>
                                                        <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="tgl_akhir_pelaksanaan" name="tgl_akhir_pelaksanaan" value="<?php echo $konten['surat_oc']->tgl_akhir_pelaksanaan; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Lokasi Pelaksanaan</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="lokasi_pelaksanaan" name="lokasi_pelaksanaan" disabled value="<?php echo $konten['surat_oc']->lokasi; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Nama Kontak</label>
                                                        <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="nama_kontak_jasa" name="nama_kontak_jasa" value="<?php echo ($konten['form_01'] ? $konten['form_01']->nama_kontak_jasa : $konten['surat_oc']->nama_pejabat_penghubung_proses_tkdn); ?>">
                                                        </div>
                                                        <label class="col-lg-2 col-form-label fw-semibold fs-6">Jabatan</label>
                                                        <div class="col-lg-3 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="jabatan_kontak_jasa" name="jabatan_kontak_jasa" value="<?php echo ($konten['form_01'] ? $konten['form_01']->jabatan_kontak_jasa : $konten['surat_oc']->jabatan_pejabat_penghubung_proses_tkdn); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Nomor telepon/HP/faks</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="nomor_telepon_kontak_jasa" name="nomor_telepon_kontak_jasa" value="<?php echo ($konten['form_01'] ? $konten['form_01']->nomor_telepon_kontak_jasa : $konten['surat_oc']->telepon_pejabat_penghubung_proses_tkdn); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="fw-bold fs-4 mb-3 pt-10">5. TARIF</div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Dasar Penetapan Tarif</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="dasar_penetapan_tarif" name="dasar_penetapan_tarif" maxlength="200" value="<?php echo ($konten['form_01'] ? $konten['form_01']->dasar_penetapan_tarif : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tarif</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="tarif" name="tarif" value="Rp <?php echo convertToRupiah(($konten['surat_oc']->termin_1 / 100) * $konten['surat_oc']->nilai_kontrak); ?> belum termasuk PPN 11%">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Perkiraan Fee</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="perkiraan_fee" name="perkiraan_fee">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Biaya Lain-Lain</label>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6" style="padding-left:40px;">Biaya Transport</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <div class="input-group input-group-solid mb-5">
                                                                <span class="input-group-text" id="basic-addon2" style="border: unset">
                                                                    Rp
                                                                </span>
                                                                <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="biaya_transport" name="biaya_transport" onkeyup="convertToRupiah(this)" value="<?php echo ($konten['form_01'] ? $konten['form_01']->biaya_transport : ''); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6" style="padding-left:40px;">Akomodasi</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <div class="input-group input-group-solid mb-5">
                                                                <span class="input-group-text" id="basic-addon2" style="border: unset">
                                                                    Rp
                                                                </span>
                                                                <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="akomodasi" name="akomodasi" onkeyup="convertToRupiah(this)" value="<?php echo ($konten['form_01'] ? $konten['form_01']->akomodasi : ''); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6" style="padding-left:40px;">Biaya Kurir<br><span class="text-gray-400 fw-semibold d-block fs-7">Untuk sample dan sertifikat</span></label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <div class="input-group input-group-solid mb-5">
                                                                <span class="input-group-text" id="basic-addon2" style="border: unset">
                                                                    Rp
                                                                </span>
                                                                <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="biaya_kurir" name="biaya_kurir" onkeyup="convertToRupiah(this)" value="<?php echo ($konten['form_01'] ? $konten['form_01']->biaya_kurir : ''); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6" style="padding-left:40px;">Biaya Tunggu</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <div class="input-group input-group-solid mb-5">
                                                                <span class="input-group-text" id="basic-addon2" style="border: unset">
                                                                    Rp
                                                                </span>
                                                                <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="biaya_tunggu" name="biaya_tunggu" onkeyup="convertToRupiah(this)" value="<?php echo ($konten['form_01'] ? $konten['form_01']->biaya_tunggu : ''); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6" style="padding-left:40px;">Biaya Lain Lain</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <div class="input-group input-group-solid mb-5">
                                                                <span class="input-group-text" id="basic-addon2" style="border: unset">
                                                                    Rp
                                                                </span>
                                                                <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="biaya_lain_lain" name="biaya_lain_lain" onkeyup="convertToRupiah(this)" value="<?php echo ($konten['form_01'] ? $konten['form_01']->biaya_lain_lain : ''); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Penerbit Invoice</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" value="<?php echo $nama_instansi . ' CABANG ' . strtoupper($cabang); ?>" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="fw-bold fs-4 mb-3 pt-10">6. SERTIFIKAT</div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Bahasa Sertifikat</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="bahasa_sertifikat" name="bahasa_sertifikat" maxlength="200" value="<?php echo ($konten['form_01'] ? $konten['form_01']->bahasa_sertifikat : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Jumlah Sertifikat</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <div class="input-group input-group-solid mb-5">
                                                                <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="jumlah_sertifikat" name="jumlah_sertifikat" onkeyup="convertToRupiah(this)" required value="<?php echo ($konten['form_01'] ? $konten['form_01']->jumlah_sertifikat : ''); ?>">
                                                                <span class="input-group-text" id="basic-addon2" style="border: unset">
                                                                    Invoice
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Penerbit Sertifikat</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <input type="text" class="form-control form-control-lg form-control-solid" autocomplete="off" id="penerbit_sertifikat" name="penerbit_sertifikat" maxlength="200">
                                                        </div>
                                                    </div>

                                                    <div class="fw-bold fs-4 mb-3 pt-10">7. CATATAN</div>
                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Catatan</label>
                                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                                            <textarea class="form-control form-control-lg form-control-solid" autocomplete="off" id="catatan" name="catatan" required><?php echo ($konten['form_01'] ? $konten['form_01']->catatan : ''); ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="separator mb-10 mt-10"></div>
                                                    <button type="submit" id="simpan" class="btn btn-primary">
                                                        <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                                        <span class="indicator-progress">Loading...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>

                                                    <input type="hidden" id="action" name="action" value="<?php echo $konten['action']; ?>">
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
        $("#tgl_spk_po_iwo, #tgl_mulai_pelaksanaan, #tgl_akhir_pelaksanaan").flatpickr(datepicker_variable);

        var sub_unit_kerja = '';
        <?php
        if ($konten['form_01']) {
            $sub_unit_kerja = $konten['form_01']->sub_unit_kerja;
            echo 'sub_unit_kerja = \'' . $sub_unit_kerja . '\';';
        }
        ?>

        $("#sub_unit_kerja").val(sub_unit_kerja).trigger("change");
        isi_jenis_jasa();

        $("#sub_unit_kerja").change(function() {
            isi_jenis_jasa();
        });

        function isi_jenis_jasa() {
            var sub_unit_kerja = $("#sub_unit_kerja").val();
            if (sub_unit_kerja == 'B01 / LSI') {
                $("#jenis_jasa").val('KONSULTANSI, PERENCANAAN, PELAKSANAAN, MONITORING, dan EVALUASI');
                $("#kode_jasa").val('021');
            } else if (sub_unit_kerja == 'B01 / PIK') {
                $("#jenis_jasa").val('Layanan Verifikasi TKDN Berbayar Pelaku Usaha');
                $("#kode_jasa").val('014-240009');
            }
        }

        $("#input_form_form_01").on('submit', function(e) {
            e.preventDefault();

            var id_form_01 = $("#id_form_01").val();
            var id_surat_oc = $("#id_surat_oc").val();
            var sub_unit_kerja = $("#sub_unit_kerja").val();
            var nama_kontak_pelanggan = $("#nama_kontak_pelanggan").val();
            var jabatan_pelanggan = $("#jabatan_pelanggan").val();
            var nomor_telepon_pelanggan = $("#nomor_telepon_pelanggan").val();
            var nomor_spk_po_iwo = $("#nomor_spk_po_iwo").val();
            var nama_komoditas = $("#nama_komoditas").val();
            var deskripsi_komoditas = $("#deskripsi_komoditas").val();
            var kuantitas_komoditas = convertToAngka($("#kuantitas_komoditas").val());
            var nilai_komoditas = $("#nilai_komoditas").val();
            var informasi_tambahan = $("#informasi_tambahan").val();
            var jenis_jasa = $("#jenis_jasa").val();
            var kode_jasa = $("#kode_jasa").val();
            var kegiatan_kegiatan = $("#kegiatan_kegiatan").val();
            var tgl_mulai_pelaksanaan = $("#tgl_mulai_pelaksanaan").val();
            var tgl_akhir_pelaksanaan = $("#tgl_akhir_pelaksanaan").val();
            var nama_kontak_jasa = $("#nama_kontak_jasa").val();
            var nomor_telepon_kontak_jasa = $("#nomor_telepon_kontak_jasa").val();
            var dasar_penetapan_tarif = $("#dasar_penetapan_tarif").val();
            var tarif = convertToAngka($("#tarif").val());
            var perkiraan_fee = convertToAngka($("#perkiraan_fee").val());
            var biaya_transport = convertToAngka($("#biaya_transport").val());
            var akomodasi = convertToAngka($("#akomodasi").val());
            var biaya_kurir = convertToAngka($("#biaya_kurir").val());
            var biaya_tunggu = convertToAngka($("#biaya_tunggu").val());
            var biaya_lain_lain = convertToAngka($("#biaya_lain_lain").val());
            var penerbit_invoice = $("#penerbit_invoice").val();
            var bahasa_sertifikat = $("#bahasa_sertifikat").val();
            var jumlah_sertifikat = convertToAngka($("#jumlah_sertifikat").val());
            var penerbit_sertifikat = $("#penerbit_sertifikat").val();
            var catatan = $("#catatan").val();
            var action = $("#action").val();

            if (!action || !id_surat_oc || !sub_unit_kerja || !nama_kontak_pelanggan || !jabatan_pelanggan || !nomor_telepon_pelanggan || !nama_komoditas || !jenis_jasa || !kode_jasa || !tgl_mulai_pelaksanaan || !tgl_akhir_pelaksanaan || !tarif || !jumlah_sertifikat || !catatan) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else if (!moment(tgl_mulai_pelaksanaan).isValid()) {
                var response = JSON.parse('<?php echo alert('format_tgl_salah'); ?>');
                swalAlert(response);
            } else if (!moment(tgl_akhir_pelaksanaan).isValid()) {
                var response = JSON.parse('<?php echo alert('format_tgl_salah'); ?>');
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
                            var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                            response.callback_yes = after_save;
                            swalAlert(response);
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }
                });
            }
        });

        function after_save() {
            location.href = base_url + 'page/buat_form_01/';
        }
    </script>
</body>
<!-- end::Body -->

</html>