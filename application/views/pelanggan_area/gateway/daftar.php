<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->

<head>

    <?php $this->view('include/head'); ?>
    <?php $this->view('include/css'); ?>

</head>
<!-- end::Head -->

<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-theme-mode");
            } else {
                if (localStorage.getItem("data-theme") !== null) {
                    themeMode = localStorage.getItem("data-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-attachment: fixed;
                background-image: url('<?php echo base_url(); ?>assets/media/auth/bg10.jpeg');
            }

            [data-theme="dark"] body {
                background-image: url('<?php echo base_url(); ?>assets/media/auth/bg10-dark.jpeg');
            }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Sign-in -->
        <div class="mx-auto d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <!--begin::Wrapper-->
                <div class="bg-body d-flex flex-center rounded-4 w-md-500px p-10">
                    <!--begin::Content-->
                    <div class="w-md-400px">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="#">
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <img src="<?php echo base_url(); ?>assets/images/logo_sambung.png" style="height: 50px; margin-bottom: 40px;">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">Daftar</h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">Buat akun untuk menjadi pelanggan TKDN</div>
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Heading-->

                            <!--begin::Input group=-->
                            <div id="step1">
                                <div class="fv-row mb-8">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <label class="required fs-5 fw-semibold mb-2">Nama Perusahaan</label>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih data" id="id_tipe_badan_usaha" name="id_tipe_badan_usaha" required>
                                                    <?php
                                                    if ($konten['tipe_badan_usaha']->num_rows() > 0) {
                                                        foreach ($konten['tipe_badan_usaha']->result() as $data) {
                                                            echo '<option value="' . $data->id_tipe_badan_usaha . '">' . $data->nama_badan_usaha . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_perusahaan" name="nama_perusahaan" required placeholder="Contoh: Pertamina">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row mb-8">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <label class="required fs-5 fw-semibold mb-2">Alamat Perusahaan</label>
                                        <input type="text" class="form-control form-control-solid" autocomplete="off" id="alamat_perusahaan" name="alamat_perusahaan" required>
                                    </div>
                                </div>
                                <div class="fv-row mb-8">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <label class="required fs-5 fw-semibold mb-2">Email</label>
                                        <input type="email" class="form-control form-control-solid" autocomplete="off" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="fv-row mb-8">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <label class="required fs-5 fw-semibold mb-2">Password</label>
                                        <input type="password" class="form-control form-control-solid" autocomplete="off" id="password_perusahaan" name="password_perusahaan" required>
                                    </div>
                                </div>
                                <div class="fv-row mb-8">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <label class="required fs-5 fw-semibold mb-2">Ulangi Password</label>
                                        <input type="password" class="form-control form-control-solid" autocomplete="off" id="ulangi_password_perusahaan" name="ulangi_password_perusahaan" required>
                                    </div>
                                </div>
                            </div>
                            <div id="step2" style="display: none">
                                <div style="font-weight: bold; font-size: 17px;">Pejabat Penghubung Proses TKDN</div>
                                <div class="fv-row mb-8">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <label class="required fs-5 fw-semibold mb-2">Nama Lengkap</label>
                                        <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_pejabat_penghubung_proses_tkdn" name="nama_pejabat_penghubung_proses_tkdn" required>
                                    </div>
                                </div>
                                <div class="fv-row mb-8">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <label class="required fs-5 fw-semibold mb-2">Jabatan</label>
                                        <input type="text" class="form-control form-control-solid" autocomplete="off" id="jabatan_pejabat_penghubung_proses_tkdn" name="jabatan_pejabat_penghubung_proses_tkdn" required>
                                    </div>
                                </div>
                                <div class="fv-row mb-8">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <label class="required fs-5 fw-semibold mb-2">Nomor Telepon</label>
                                        <input type="text" class="form-control form-control-solid" autocomplete="off" id="telepon_pejabat_penghubung_proses_tkdn" name="telepon_pejabat_penghubung_proses_tkdn" required>
                                    </div>
                                </div>
                            </div>
                            <div id="step3" style="display: none">
                                <div style="font-weight: bold; font-size: 17px;">Pejabat Penghubung Invoice</div>
                                <div class="fv-row mb-8">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <label class="required fs-5 fw-semibold mb-2">Nama Lengkap</label>
                                        <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_pejabat_penghubung_invoice" name="nama_pejabat_penghubung_invoice" required>
                                    </div>
                                </div>
                                <div class="fv-row mb-8">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <label class="required fs-5 fw-semibold mb-2">Nomor Telepon</label>
                                        <input type="text" class="form-control form-control-solid" autocomplete="off" id="telepon_pejabat_penghubung_invoice" name="telepon_pejabat_penghubung_invoice" required>
                                    </div>
                                </div>
                            </div>
                            <div id="step4" style="display: none">
                                <div style="font-weight: bold; font-size: 17px;">Pejabat Penghubung Pajak</div>
                                <div class="fv-row mb-8">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <label class="required fs-5 fw-semibold mb-2">Nama Lengkap</label>
                                        <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_pejabat_penghubung_pajak" name="nama_pejabat_penghubung_pajak" required>
                                    </div>
                                </div>
                                <div class="fv-row mb-8">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <label class="required fs-5 fw-semibold mb-2">Nomor Telepon</label>
                                        <input type="text" class="form-control form-control-solid" autocomplete="off" id="telepon_pejabat_penghubung_pajak" name="telepon_pejabat_penghubung_pajak" required>
                                    </div>
                                </div>
                            </div>


                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="button" id="daftar" class="btn btn-primary">Lanjutkan</button>
                            </div>
                            <!--end::Submit button-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>

    <?php $this->view('include/js'); ?>
    <script>
        var step = 1;
        $("#daftar").click(function() {
            step++;
            $("#step" + step).show();

            if (step == 4) {
                $("#daftar").html('Daftar Sekarang');
            } else if (step == 5) {
                step = 4;
                proses_daftar();
            }
            var getMeTo = document.getElementById("step" + step);
            getMeTo.scrollIntoView({
                behavior: 'smooth'
            }, true);
        })

        function proses_daftar() {
            var id_tipe_badan_usaha = $("#id_tipe_badan_usaha").val();
            var nama_perusahaan = $("#nama_perusahaan").val();
            var alamat_perusahaan = $("#alamat_perusahaan").val();
            var email = $("#email").val();
            var password_perusahaan = $("#password_perusahaan").val();
            var ulangi_password_perusahaan = $("#ulangi_password_perusahaan").val();
            var nama_pejabat_penghubung_proses_tkdn = $("#nama_pejabat_penghubung_proses_tkdn").val();
            var jabatan_pejabat_penghubung_proses_tkdn = $("#jabatan_pejabat_penghubung_proses_tkdn").val();
            var telepon_pejabat_penghubung_proses_tkdn = $("#telepon_pejabat_penghubung_proses_tkdn").val();
            var nama_pejabat_penghubung_invoice = $("#nama_pejabat_penghubung_invoice").val();
            var telepon_pejabat_penghubung_invoice = $("#telepon_pejabat_penghubung_invoice").val();
            var nama_pejabat_penghubung_pajak = $("#nama_pejabat_penghubung_pajak").val();
            var telepon_pejabat_penghubung_pajak = $("#telepon_pejabat_penghubung_pajak").val();
            if (!id_tipe_badan_usaha || !nama_perusahaan || !alamat_perusahaan || !email || !password_perusahaan || !nama_pejabat_penghubung_proses_tkdn || !jabatan_pejabat_penghubung_proses_tkdn || !telepon_pejabat_penghubung_proses_tkdn || !nama_pejabat_penghubung_invoice || !telepon_pejabat_penghubung_invoice || !nama_pejabat_penghubung_pajak || !telepon_pejabat_penghubung_pajak) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else if (!isEmailValid(email)) {
                var response = JSON.parse('<?php echo alert('email_salah'); ?>');
                swalAlert(response);
            } else if (password_perusahaan != ulangi_password_perusahaan) {
                var response = JSON.parse('<?php echo alert('password_tidak_sama'); ?>');
                swalAlert(response);
            } else {
                $("#daftar").html('Loading...');
                $("#daftar").attr('disabled', 'disabled');

                var data = new Object;
                data['id_tipe_badan_usaha'] = id_tipe_badan_usaha;
                data['nama_perusahaan'] = nama_perusahaan;
                data['alamat_perusahaan'] = alamat_perusahaan;
                data['email'] = email;
                data['password_perusahaan'] = password_perusahaan;

                data['nama_pejabat_penghubung_proses_tkdn'] = nama_pejabat_penghubung_proses_tkdn;
                data['jabatan_pejabat_penghubung_proses_tkdn'] = jabatan_pejabat_penghubung_proses_tkdn;
                data['telepon_pejabat_penghubung_proses_tkdn'] = telepon_pejabat_penghubung_proses_tkdn;

                data['nama_pejabat_penghubung_invoice'] = nama_pejabat_penghubung_invoice;
                data['telepon_pejabat_penghubung_invoice'] = telepon_pejabat_penghubung_invoice;

                data['nama_pejabat_penghubung_pajak'] = nama_pejabat_penghubung_pajak;
                data['telepon_pejabat_penghubung_pajak'] = telepon_pejabat_penghubung_pajak;

                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>data_pelanggan/daftar',
                    data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                    cache: false,
                    dataType: "json",
                    success: function(data) {
                        $("#daftar").html('Daftar Sekarang');
                        $("#daftar").removeAttr('disabled');

                        if (data.sts == 1) {
                            location.href = '<?php echo base_url(); ?>pelanggan/daftar/berhasil?email=' + data.email;
                        } else if (data.sts == 'email_available') {
                            var response = JSON.parse('<?php echo alert('email_available'); ?>');
                            swalAlert(response);
                        } else if (data.sts == 'perusahaan_available') {
                            var response = JSON.parse('<?php echo alert('perusahaan_available'); ?>');
                            swalAlert(response);
                        } else {
                            var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                            swalAlert(response);
                        }
                    }
                })
            }
        }
    </script>
</body>

</html>