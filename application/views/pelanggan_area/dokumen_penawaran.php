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
            <?php $this->view('pelanggan_area/include/top_navbar'); ?>
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <?php $this->view('pelanggan_area/include/left_side_navbar'); ?>
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
                                <?php
                                if ($konten['surat_penawaran']->status_pengajuan >= 12) {
                                ?>

                                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                                        <button type="button" id="kembali" class="btn btn-light btn-active-light-primary me-2" onclick="history.back();"><i class="fa fa-arrow-alt-circle-left"></i> Kembali</button>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                                        <button type="button" id="setuju" class="btn btn-sm btn-success"><i class="fa fa-check-circle"></i> Deal</button>
                                        <button type="button" id="<?php echo ($konten['surat_penawaran']->status_pengajuan == 10 ? 'negosiasi_tolak' : 'tolak'); ?>" class="btn btn-sm btn-danger"><i class="fa fa-times-circle"></i> Tolak</button>
                                    </div>
                                <?php
                                }
                                ?>
                                <!--end::Page title-->
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">

                                <div class="card card-flush h-lg-100 tabel_zone" id="tabel_dokumen_penawaran">

                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <input type="hidden" id="id_dokumen_permohonan" name="id_dokumen_permohonan" value="<?php echo $konten['surat_penawaran']->id_dokumen_permohonan; ?>">
                                        <input type="hidden" id="id_surat_penawaran" name="id_surat_penawaran" value="<?php echo $konten['surat_penawaran']->id_surat_penawaran; ?>">
                                        <iframe src="<?php echo base_url() . 'rab/surat_penawaran/' . $konten['surat_penawaran']->id_rab; ?>" style="width: 100%; border: unset; height: 500px;"></iframe>
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
        <?php
        if ($konten['surat_penawaran']->status_pengajuan < 12) {
        ?>
            $("#setuju").click(function() {
                var pertanyaan = "Apakah Anda yakin menyetujui surat penawaran ini? Jika Anda setujui, maka kami akan melanjutkan ke proses berikutnya.";

                konfirmasi(pertanyaan, function() {
                    $("#setuju").attr({
                        "data-kt-indicator": "on",
                        'disabled': true
                    });
                    proses_verifikasi_surat_penawaran('setuju');
                });

            });
            $("#tolak").click(function() {
                var pertanyaan = "Apakah Anda yakin menolak surat penawaran ini? Jika Anda menolak, admin akan merevisi surat penawaran ini.";

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
                        $("#tolak").attr({
                            "data-kt-indicator": "on",
                            'disabled': true
                        });
                        proses_verifikasi_surat_penawaran('ditolak', result.value);
                    }

                });
            });
            $("#negosiasi_tolak").click(function() {
                var pertanyaan = "<div class='notice d-flex bg-light-primary rounded border-primary border border-dashed p-6'>Jika Anda tidak setujui dengan penawaran yang ada, kami memberikan opsi untuk negosiasi.</div><div class='mt-5 fw-bold'>Apakah Anda yakin ingin menolak surat penawaran ini?</div>";

                swal.fire({
                    title: konfirmasi_title,
                    html: pertanyaan,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-times-circle" style="color: #FFF"></i> Tolak & Selesai!',
                    cancelButtonText: '<i class="fa fa-handshake" style="color: #FFF"></i> Saya Mau Negosiasi',
                    confirmButtonColor: '#f1416c',
                    cancelButtonColor: '#50cd89',
                    allowOutsideClick: false,
                    reverseButtons: false,
                }).then(function(result) {
                    console.log(result);
                    if (result.isConfirmed) {
                        $("#tolak").attr({
                            "data-kt-indicator": "on",
                            'disabled': true
                        });
                        proses_verifikasi_surat_penawaran('ditolak', result.value);
                    }
                    if (result.isDismissed) {
                        $("#tolak").attr({
                            "data-kt-indicator": "on",
                            'disabled': true
                        });
                        proses_verifikasi_surat_penawaran('negosiasi');
                    }

                });
            });
        <?php
        }
        ?>



        var id_chat_room;

        function proses_verifikasi_surat_penawaran(status_verifikasi, alasan_verifikasi) {
            //show loading animation...
            preloader('show');
            $("#setuju, #tolak").attr({
                "data-kt-indicator": "on",
                'disabled': true
            });

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_dokumen_permohonan'] = $("#id_dokumen_permohonan").val();
            data['id_surat_penawaran'] = $("#id_surat_penawaran").val();
            data['status_verifikasi'] = status_verifikasi;
            data['alasan_verifikasi'] = alasan_verifikasi;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/dokumen_permohonan/verifikasi_surat_penawaran',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    preloader('hide');
                    //hide loading animation...
                    preloader('hide');
                    $("#setuju, #tolak").removeAttr('disabled data-kt-indicator');

                    if (data.sts == 1) {
                        var response = JSON.parse('<?php echo alert('verifikasi_berhasil'); ?>');
                        if (data.id_chat_room) {
                            id_chat_room = data.id_chat_room;
                            response.callback_yes = ke_room_nego;
                        } else {
                            response.callback_yes = after_verifikasi;
                        }
                        swalAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }

            });
        }

        function after_verifikasi() {
            location.href = base_url + "pelanggan/riwayat_permohonan_tkdn";
        }

        function ke_room_nego() {
            location.href = base_url + "pelanggan/room_negosiasi?room=" + id_chat_room;
        }
    </script>
</body>
<!-- end::Body -->

</html>