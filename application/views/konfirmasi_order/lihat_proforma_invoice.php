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
                            <?php
                            if(isset($konten['display_only']) and $konten['display_only'] == true){
                            ?>

                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <!--begin::Secondary button-->
                                    <button type="button" class="btn btn-sm btn-light btn-active-light-primary" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Kembali</button>
                                    <!--end::Secondary button-->
                                </div>
                            <?php
                            }
                            else{
                            ?>
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <!--begin::Secondary button-->
                                    <button type="button" id="setuju" class="btn btn-sm btn-success"><i class="fa fa-check-circle"></i> Setuju</button>
                                    <!--end::Secondary button-->
                                    <!--begin::Primary button-->
                                    <button type="button" id="tolak" class="btn btn-sm btn-danger"><i class="fa fa-times-circle"></i> Tolak</button>
                                    <!--end::Primary button-->
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
                                    <input type="hidden" id="id_proforma_invoice" name="id_proforma_invoice" value="<?php echo $konten['proforma_invoice']->id_proforma_invoice; ?>">
                                    <input type="hidden" id="id_dokumen_permohonan" name="id_dokumen_permohonan" value="<?php echo $konten['proforma_invoice']->id_dokumen_permohonan; ?>">
                                    <iframe src="<?php echo base_url().'proforma_invoice/dokumen_pdf/'.$konten['proforma_invoice']->id_proforma_invoice; ?>" style="width: 100%; border: unset; height: 500px;"></iframe>
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
<?php
if(isset($konten['display_only']) and $konten['display_only'] == true){
    //doing nothing...
}
else{
?>
    <script>
        $("#setuju").click(function(){
            var pertanyaan_tambahan = '';
            <?php
            if($this->session->userdata('id_jns_admin') == 7){
            ?>
                pertanyaan_tambahan = ' Jika Anda menyetujuinya, maka proforma invoice ini akan dikirim ke pelanggan.';
            <?php
            }    
            ?>
            
            var pertanyaan = "Apakah Anda yakin menyetujui proforma invoice ini?"+pertanyaan_tambahan;

            konfirmasi(pertanyaan, function(){
                $("#setuju").attr({"data-kt-indicator": "on", 'disabled': true});
                proses_verifikasi_proforma_invoice('setuju');
            });

        });
        $("#tolak").click(function(){
            var pertanyaan = "Apakah Anda yakin menolak proforma invoice ini?";

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
            }).then(function(result){
                if (result.isConfirmed) {
                    $("#tolak").attr({"data-kt-indicator": "on", 'disabled': true});
                    proses_verifikasi_proforma_invoice('ditolak', result.value);
                }

            });
        });

        function proses_verifikasi_proforma_invoice(status_verifikasi, alasan_verifikasi){
            //show loading animation...
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_dokumen_permohonan'] = $("#id_dokumen_permohonan").val();
            data['id_proforma_invoice'] = $("#id_proforma_invoice").val();
            data['status_verifikasi'] = status_verifikasi;
            data['alasan_verifikasi'] = alasan_verifikasi;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>proforma_invoice/verifikasi_proforma_invoice',
                data: 'data_send='+encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data){
                    preloader('hide');

                    if(data.sts == 1){
                        var response = JSON.parse('<?php echo alert('verifikasi_berhasil'); ?>');
                        response.callback_yes = after_verifikasi;
                        swalAlert(response);
                    }
                    else{
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }

            });
        }
        function after_verifikasi(){
            location.href=base_url+"page/verifikasi_proforma_invoice";
        }
    </script>
<?php
}
?>

</body>
<!-- end::Body -->
</html>
