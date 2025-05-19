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
                                        Detail Dokumen Permohonan
                                    </h1>
                                    <!--end::Title-->
                                </div>
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <!--begin::Secondary button-->
                                    <button type="button" class="btn btn-sm btn-light btn-active-light-primary" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Kembali</button>
                                    <!--end::Secondary button-->
                                </div>
                                <!--end::Page title-->
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <div class="card card-flush">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>
                                                Dokumen Permohonan
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
                                                <div class="row mb-7">
                                                    <label class="col-lg-4 fw-semibold text-muted">Nama Perusahaan</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo $konten['dokumen_permohonan']->nama_badan_usaha . ' ' . $konten['dokumen_permohonan']->nama_perusahaan; ?></span>
                                                    </div>
                                                </div>
                                                <div class="row mb-7">
                                                    <label class="col-lg-4 fw-semibold text-muted">Tipe Permohonan</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bold fs-6 text-gray-800"><?php echo $konten['dokumen_permohonan']->nama_tipe_permohonan; ?></span>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($konten['dokumen_permohonan']->dokumen_tambahan == 1) {
                                                ?>
                                                    <div class="row mb-7">
                                                        <label class="col-lg-4 fw-semibold text-muted">Nilai Tagihan Kontrak</label>
                                                        <div class="col-lg-8">
                                                            <span class="fw-bold fs-6 text-gray-800">Rp <?php echo convertToRupiah($konten['dokumen_permohonan']->nilai_tagihan_kontrak); ?></span>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else if ($konten['dokumen_permohonan']->dokumen_tambahan == 2) {
                                                ?>
                                                    <div class="row mb-7">
                                                        <label class="col-lg-4 fw-semibold text-muted">Kriteria Yang Diajukan</label>
                                                        <div class="col-lg-8">
                                                            <span class="fw-bold fs-6 text-gray-800"><?php echo $konten['dokumen_permohonan']->kriteria_bpm; ?></span>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <div class="row mb-7">
                                                    <label class="col-lg-4 fw-semibold text-muted">Verifikator</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bold fs-6 text-gray-800" id="nama_assesor"><?php ($konten['assesor'] ? render_assesor($konten['assesor']->nama_admin) : render_assesor('Belum Ada Verifikator')); ?></span>
                                                    </div>
                                                </div>
                                                <div class="row mb-7">
                                                    <label class="col-lg-4 fw-semibold text-muted">Status</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bold fs-6 text-gray-800" id="status_pengajuan"><?php echo $konten['dokumen_permohonan']->status_pengajuan; ?></span>
                                                    </div>
                                                </div>
                                                <div class="py-2">
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <div class="d-flex">
                                                            <img src="<?php echo base_url(); ?>assets/media/svg/files/pdf.svg" class="w-30px me-6" alt="">
                                                            <div class="d-flex flex-column">
                                                                <div class="fs-5 text-dark fw-bold">Dokumen Permohonan</div>
                                                                <?php
                                                                if ($konten['dokumen_permohonan']->dokumen_permohonan) {
                                                                    echo '<a href="' . base_url() . $konten['dokumen_permohonan']->dokumen_permohonan . '" target="_blank" class="fs-6 fw-semibold text-gray-400" style="max-width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">' . str_replace('assets/uploads/dokumen/' . $konten['dokumen_permohonan']->id_pelanggan . '/', '', $konten['dokumen_permohonan']->dokumen_permohonan) . '</a>';
                                                                } else {
                                                                    echo '<span class="fs-6 fw-semibold text-gray-400">Tidak ada dokumen</span>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($konten['dokumen_permohonan']->dokumen_permohonan) {
                                                            echo '<div class="d-flex justify-content-end"><a href="' . base_url() . $konten['dokumen_permohonan']->dokumen_permohonan . '" target="_blank" class="btn btn-primary"><i class="fa fa-file-download"></i> Download</a></div>';
                                                        }
                                                        ?>
                                                    </div>
                                                    <!--end::Item-->
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <div class="d-flex">
                                                            <img src="<?php echo base_url(); ?>assets/media/svg/files/pdf.svg" class="w-30px me-6" alt="">
                                                            <div class="d-flex flex-column">
                                                                <div class="fs-5 text-dark fw-bold">Kartu NPWP</div>

                                                                <div class="text-gray-400 fw-semibold d-block fs-7">Nomor NPWP: </div>
                                                                <div class="text-gray-800 fw-bold fs-6 mb-3"><?php echo $konten['dokumen_permohonan']->nomor_npwp; ?></div>

                                                                <div class="text-gray-400 fw-semibold d-block fs-7">Alamat NPWP: </div>
                                                                <div class="text-gray-800 fw-bold fs-6 mb-3" style="max-width: 500px;"><?php echo $konten['dokumen_permohonan']->alamat_npwp; ?></div>

                                                                <?php
                                                                if ($konten['dokumen_permohonan']->kartu_npwp) {
                                                                    echo '<a href="' . base_url() . $konten['dokumen_permohonan']->kartu_npwp . '" target="_blank" class="fs-6 fw-semibold text-gray-400" style="max-width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">' . str_replace('assets/uploads/dokumen/' . $konten['dokumen_permohonan']->id_pelanggan . '/', '', $konten['dokumen_permohonan']->kartu_npwp) . '</a>';
                                                                } else {
                                                                    echo '<span class="fs-6 fw-semibold text-gray-400">Tidak ada dokumen</span>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($konten['dokumen_permohonan']->kartu_npwp) {
                                                            echo '<div class="d-flex justify-content-end"><a href="' . base_url() . $konten['dokumen_permohonan']->kartu_npwp . '" target="_blank" class="btn btn-primary"><i class="fa fa-file-download"></i> Download</a></div>';
                                                        }
                                                        ?>
                                                    </div>
                                                    <!--end::Item-->
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <div class="d-flex">
                                                            <img src="<?php echo base_url(); ?>assets/media/svg/files/pdf.svg" class="w-30px me-6" alt="">
                                                            <div class="d-flex flex-column">
                                                                <div class="fs-5 text-dark fw-bold">Surat Keterangan Terdaftar</div>
                                                                <?php
                                                                if ($konten['dokumen_permohonan']->dokumen_skt) {
                                                                    echo '<a href="' . base_url() . $konten['dokumen_permohonan']->dokumen_skt . '" target="_blank" class="fs-6 fw-semibold text-gray-400" style="max-width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">' . str_replace('assets/uploads/dokumen/' . $konten['dokumen_permohonan']->id_pelanggan . '/', '', $konten['dokumen_permohonan']->dokumen_skt) . '</a>';
                                                                } else {
                                                                    echo '<span class="fs-6 fw-semibold text-gray-400">Tidak ada dokumen</span>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($konten['dokumen_permohonan']->dokumen_skt) {
                                                            echo '<div class="d-flex justify-content-end"><a href="' . base_url() . $konten['dokumen_permohonan']->dokumen_skt . '" target="_blank" class="btn btn-primary"><i class="fa fa-file-download"></i> Download</a></div>';
                                                        }
                                                        ?>
                                                    </div>
                                                    <!--end::Item-->
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <div class="d-flex">
                                                            <img src="<?php echo base_url(); ?>assets/media/svg/files/pdf.svg" class="w-30px me-6" alt="">
                                                            <div class="d-flex flex-column">
                                                                <div class="fs-5 text-dark fw-bold">Surat Pernyataan Alamat Antar Invoice</div>
                                                                <?php
                                                                if ($konten['dokumen_permohonan']->dokumen_alamat_antar_invoice) {
                                                                    echo '<a href="' . base_url() . $konten['dokumen_permohonan']->dokumen_alamat_antar_invoice . '" target="_blank" class="fs-6 fw-semibold text-gray-400" style="max-width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">' . str_replace('assets/uploads/dokumen/' . $konten['dokumen_permohonan']->id_pelanggan . '/', '', $konten['dokumen_permohonan']->dokumen_alamat_antar_invoice) . '</a>';
                                                                } else {
                                                                    echo '<span class="fs-6 fw-semibold text-gray-400">Tidak ada dokumen</span>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($konten['dokumen_permohonan']->dokumen_alamat_antar_invoice) {
                                                            echo '<div class="d-flex justify-content-end"><a href="' . base_url() . $konten['dokumen_permohonan']->dokumen_alamat_antar_invoice . '" target="_blank" class="btn btn-primary"><i class="fa fa-file-download"></i> Download</a></div>';
                                                        }
                                                        ?>
                                                    </div>
                                                    <!--end::Item-->
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <div class="d-flex">
                                                            <img src="<?php echo base_url(); ?>assets/media/svg/files/pdf.svg" class="w-30px me-6" alt="">
                                                            <div class="d-flex flex-column">
                                                                <div class="fs-5 text-dark fw-bold">Dokumen Izin Usaha Industri (IUI) / Nomor Induk Berusaha (NIB)</div>
                                                                <?php
                                                                if ($konten['dokumen_permohonan']->dokumen_uiu_nib) {
                                                                    echo '<a href="' . base_url() . $konten['dokumen_permohonan']->dokumen_uiu_nib . '" target="_blank" class="fs-6 fw-semibold text-gray-400" style="max-width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">' . str_replace('assets/uploads/dokumen/' . $konten['dokumen_permohonan']->id_pelanggan . '/', '', $konten['dokumen_permohonan']->dokumen_uiu_nib) . '</a>';
                                                                } else {
                                                                    echo '<span class="fs-6 fw-semibold text-gray-400">Tidak ada dokumen</span>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($konten['dokumen_permohonan']->dokumen_uiu_nib) {
                                                            echo '<div class="d-flex justify-content-end"><a href="' . base_url() . $konten['dokumen_permohonan']->dokumen_uiu_nib . '" target="_blank" class="btn btn-primary"><i class="fa fa-file-download"></i> Download</a></div>';
                                                        }
                                                        ?>
                                                    </div>
                                                    <!--end::Item-->
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <div class="d-flex">
                                                            <img src="<?php echo base_url(); ?>assets/media/svg/files/pdf.svg" class="w-30px me-6" alt="">
                                                            <div class="d-flex flex-column">
                                                                <div class="fs-5 text-dark fw-bold">Dokumen Nomor Izin Edar</div>
                                                                <?php
                                                                if ($konten['dokumen_permohonan']->dokumen_nomor_izin_edar) {
                                                                    echo '<a href="' . base_url() . $konten['dokumen_permohonan']->dokumen_nomor_izin_edar . '" target="_blank" class="fs-6 fw-semibold text-gray-400" style="max-width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">' . str_replace('assets/uploads/dokumen/' . $konten['dokumen_permohonan']->id_pelanggan . '/', '', $konten['dokumen_permohonan']->dokumen_nomor_izin_edar) . '</a>';
                                                                } else {
                                                                    echo '<span class="fs-6 fw-semibold text-gray-400">Tidak ada dokumen</span>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($konten['dokumen_permohonan']->dokumen_nomor_izin_edar) {
                                                            echo '<div class="d-flex justify-content-end"><a href="' . base_url() . $konten['dokumen_permohonan']->dokumen_nomor_izin_edar . '" target="_blank" class="btn btn-primary"><i class="fa fa-file-download"></i> Download</a></div>';
                                                        }
                                                        ?>
                                                    </div>
                                                    <!--end::Item-->
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <?php
                                                    if ($konten['dokumen_permohonan']->dokumen_tambahan == 1) {
                                                    ?>
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-stack">
                                                            <div class="d-flex">
                                                                <img src="<?php echo base_url(); ?>assets/media/svg/files/pdf.svg" class="w-30px me-6" alt="">
                                                                <div class="d-flex flex-column">
                                                                    <div class="fs-5 text-dark fw-bold">Dokumen Kontrak Lengkap Dengan Amandemen</div>
                                                                    <?php
                                                                    if ($konten['dokumen_permohonan']->dokumen_kontrak_amandemen) {
                                                                        echo '<a href="' . base_url() . $konten['dokumen_permohonan']->dokumen_kontrak_amandemen . '" target="_blank" class="fs-6 fw-semibold text-gray-400" style="max-width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">' . str_replace('assets/uploads/dokumen/' . $konten['dokumen_permohonan']->id_pelanggan . '/', '', $konten['dokumen_permohonan']->dokumen_kontrak_amandemen) . '</a>';
                                                                    } else {
                                                                        echo '<span class="fs-6 fw-semibold text-gray-400">Tidak ada dokumen</span>';
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            if ($konten['dokumen_permohonan']->dokumen_kontrak_amandemen) {
                                                                echo '<div class="d-flex justify-content-end"><a href="' . base_url() . $konten['dokumen_permohonan']->dokumen_kontrak_amandemen . '" target="_blank" class="btn btn-primary"><i class="fa fa-file-download"></i> Download</a></div>';
                                                            }
                                                            ?>
                                                        </div>
                                                        <!--end::Item-->
                                                        <div class="separator separator-dashed my-5"></div>
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-stack">
                                                            <div class="d-flex">
                                                                <img src="<?php echo base_url(); ?>assets/media/svg/files/pdf.svg" class="w-30px me-6" alt="">
                                                                <div class="d-flex flex-column">
                                                                    <div class="fs-5 text-dark fw-bold">Form Komitmen TKDN</div>
                                                                    <?php
                                                                    if ($konten['dokumen_permohonan']->dokumen_komitmen_tkdn) {
                                                                        echo '<a href="' . base_url() . $konten['dokumen_permohonan']->dokumen_komitmen_tkdn . '" target="_blank" class="fs-6 fw-semibold text-gray-400" style="max-width: 500px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">' . str_replace('assets/uploads/dokumen/' . $konten['dokumen_permohonan']->id_pelanggan . '/', '', $konten['dokumen_permohonan']->dokumen_komitmen_tkdn) . '</a>';
                                                                    } else {
                                                                        echo '<span class="fs-6 fw-semibold text-gray-400">Tidak ada dokumen</span>';
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            if ($konten['dokumen_permohonan']->dokumen_komitmen_tkdn) {
                                                                echo '<div class="d-flex justify-content-end"><a href="' . base_url() . $konten['dokumen_permohonan']->dokumen_komitmen_tkdn . '" target="_blank" class="btn btn-primary"><i class="fa fa-file-download"></i> Download</a></div>';
                                                            }
                                                            ?>
                                                        </div>
                                                        <!--end::Item-->
                                                        <div class="separator separator-dashed my-5"></div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <input type="hidden" id="id_dokumen_permohonan" name="id_dokumen_permohonan" value="<?php echo $konten['dokumen_permohonan']->id_dokumen_permohonan; ?>">
                                                <?php
                                                if (isset($konten['proses_verifikasi'])) {
                                                ?>

                                                    <div class="row mt-10 mb-7">
                                                        <div class="col-sm-6">
                                                            <button type="button" id="ditolak" class="btn btn-danger">
                                                                <span class="indicator-label">Tolak Dokumen Ini</span>
                                                                <span class="indicator-progress">Loading...
                                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                            </button>
                                                        </div>
                                                        <div class="col-sm-6" style="text-align: right">
                                                            <button type="button" id="setujui" class="btn btn-success">
                                                                <span class="indicator-label">Setujui Dokumen Ini</span>
                                                                <span class="indicator-progress">Loading...
                                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
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
        $("#status_pengajuan").html(status_pengajuan_badge($("#status_pengajuan").html()));

        $("#setujui").click(function() {
            var pertanyaan = "Apakah Anda yakin menyetujui dokumen permohonan penawaran ini?";

            konfirmasi(pertanyaan, function() {
                $("#setujui").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });
                proses_verifikasi_dokumen('setuju');
            });
        })
        $("#ditolak").click(function() {
            var pertanyaan = "Apakah Anda yakin menolak dokumen permohonan penawaran ini?";

            swal.fire({
                title: konfirmasi_title,
                html: pertanyaan,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan!',
                cancelButtonText: 'Tidak, batalkan',
                confirmButtonColor: '#0abb87',
                cancelButtonColor: '#d33',
                allowOutsideClick: false,
                reverseButtons: true,
                input: 'textarea',
                inputLabel: 'Alasan Penolakan',
                inputPlaceholder: 'Tuliskan alasan penolakan Anda disini',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Anda harus menuliskan alasan penolakan dengan jelas!'
                    }
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    $("#ditolak").attr({
                        "data-kt-indicator": "on",
                        'disabled': true
                    });
                    proses_verifikasi_dokumen('ditolak', result.value);
                }

            });
        })

        function proses_verifikasi_dokumen(status_pengajuan, alasan_verifikasi) {
            //show loading animation...
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_dokumen_permohonan'] = $("#id_dokumen_permohonan").val();
            data['status_pengajuan'] = status_pengajuan;
            data['alasan_verifikasi'] = alasan_verifikasi;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>dokumen_permohonan/verifikasi_dokumen',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    //hide loading animation...
                    $("#setujui, #ditolak").removeAttr('disabled data-kt-indicator');

                    if (data.sts == 1) {
                        var response = JSON.parse('<?php echo alert('verifikasi_berhasil'); ?>');
                        response.callback_yes = after_verifikasi;
                        swalAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }

            });
        }

        function after_verifikasi() {
            location.href = base_url + "page/verifikasi_dokumen";
        }
    </script>
</body>
<!-- end::Body -->

</html>