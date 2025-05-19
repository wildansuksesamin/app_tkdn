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
                                <div class="card card-flush mb-5">
                                    <div class="card-body p-lg-17">
                                        <div class="flex-grow-1">
                                            <!--begin::Title-->
                                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                                <!--begin::User-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Name-->
                                                    <div class="d-flex align-items-center mb-2">
                                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?php echo $konten['surat_penawaran']->nama_badan_usaha . ' ' . $konten['surat_penawaran']->nama_perusahaan; ?></a>
                                                        <a href="#">
                                                            <?php echo getSvgIcon('general/gen026', 'svg-icon svg-icon-1 svg-icon-primary'); ?>
                                                        </a>
                                                    </div>
                                                    <!--end::Name-->
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-wrap fw-semibold fs-6 pe-2">
                                                        <a href="#" class="text-gray-400 text-hover-primary me-10">
                                                            <div class="text-gray-400 fw-semibold d-block fs-7">Tgl Surat Penawaran</div>
                                                            <div class="fw-bold text-gray-800"><?php echo reformat_date($konten['surat_penawaran']->tgl_surat_penawaran, array('new_delimiter' => ' ', 'month_type' => 'full')); ?></div>
                                                        </a>
                                                        <a href="#" class="text-gray-400 text-hover-primary me-10">
                                                            <div class="text-gray-400 fw-semibold d-block fs-7">Nomor Surat Penawaran</div>
                                                            <div class="fw-bold text-gray-800"><?php echo $konten['surat_penawaran']->nomor_surat_penawaran; ?></div>
                                                        </a>
                                                        <a href="#" class="text-gray-400 text-hover-primary">
                                                            <div class="text-gray-400 fw-semibold d-block fs-7">Jenis</div>
                                                            <div class="fw-bold text-gray-800"><?php echo $konten['surat_penawaran']->jns_surat_penawaran; ?></div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="d-flex my-4">
                                                    <a href="<?php echo base_url() . 'page/profil_pelanggan/' . $konten['surat_penawaran']->id_pelanggan; ?>" class="btn btn-sm btn-light-success me-2" target="_blank">
                                                        <?php echo getSvgIcon('general/gen049', 'svg-icon svg-icon-3'); ?>
                                                        Pelanggan
                                                    </a>
                                                    <a href="<?php echo base_url() . 'page/detail_dokumen_permohonan/' . $konten['surat_penawaran']->id_dokumen_permohonan; ?>" class="btn btn-sm btn-light-success me-2" target="_blank">
                                                        <?php echo getSvgIcon('files/fil008', 'svg-icon svg-icon-3'); ?>
                                                        Dok. Permohonan
                                                    </a>
                                                    <a href="<?php echo base_url() . 'page/lihat_surat_penawaran/' . $konten['surat_penawaran']->id_surat_penawaran; ?>" class="btn btn-sm btn-light-success me-2" target="_blank">
                                                        <?php echo getSvgIcon('files/fil008', 'svg-icon svg-icon-3'); ?>
                                                        Penawaran
                                                    </a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="card card-flush">
                                    <div class="card-header pt-7">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>
                                                Form Surat Konfirmasi Order
                                            </h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>

                                    <div class="<?php echo ($konten['surat_penawaran']->status_pengajuan == 14 ? '' : 'hidden'); ?>">
                                        <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mx-6 p-6 hidden">
                                            <!--begin::Icon-->
                                            <?php echo getSvgIcon('general/gen040', 'svg-icon svg-icon-2tx svg-icon-danger me-4'); ?>
                                            <!--end::Icon-->
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <!--begin::Content-->
                                                <div class="fw-semibold">
                                                    <h4 class="text-gray-900 fw-bold">Alasan Penolakan</h4>
                                                    <div class="fs-6 text-gray-700" id="alasan_penolakan"><?php echo ($konten['surat_penawaran']->status_pengajuan == 14 ? $konten['surat_penawaran']->alasan_verifikasi : ''); ?></div>
                                                </div>
                                                <!--end::Content-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                    </div>

                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17">
                                        <!--begin::Layout-->
                                        <div class="d-flex flex-column flex-lg-row">
                                            <!--begin::Content-->
                                            <div class="flex-lg-row-fluid me-0">
                                                <!--begin::Form-->
                                                
                                                
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_surat_oc" action="<?php echo base_url(); ?>Surat_oc/simpan" autocomplete="off">

                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nomor Konfirmasi Order</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nomor_oc" name="nomor_oc" maxlength="100" placeholder="" required value="<?php echo (!is_null($konten['surat_oc']) ? $konten['surat_oc']->nomor_oc : ''); ?>">
                                                        </div>

                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tanggal Konfirmasi Order</label>
                                                            <input type="text" class="form-control form-control-solid datepicker" autocomplete="off" id="tgl_oc" name="tgl_oc" placeholder="" required value="<?php echo (!is_null($konten['surat_oc']) ? $konten['surat_oc']->tgl_oc : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nama U.P</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" id="nama_up" name="nama_up" maxlength="100" placeholder="" required value="<?php echo $konten['surat_penawaran']->nama_pejabat_penghubung_proses_tkdn; ?>">
                                                <!-- (!is_null($konten['surat_oc']) ? $konten['surat_oc']->nama_up : -->
                                                        </div>

                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Batas Waktu Pembayaran</label>
                                                            <div class="input-group input-group-solid mb-5">
                                                                <input type="text" class="form-control form-control-solid" autocomplete="off" id="batas_waktu_pembayaran" name="batas_waktu_pembayaran" placeholder="" required value="<?php echo (!is_null($konten['surat_oc']) ? $konten['surat_oc']->batas_waktu_pembayaran : ''); ?>">
                                                                <span class="input-group-text" id="basic-addon1">Hari Kalender</span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($konten['surat_penawaran']->jns_surat_penawaran == 'bmp') {
                                                        ?>
                                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                                <label class="required fs-5 fw-semibold mb-2">Kriteria Penilaian BMP</label>
                                                                <div class="input-group input-group-solid mb-5">
                                                                    <select id="kriteria_penilaian_bmp" name="kriteria_penilaian_bmp" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih data" required>
                                                                        <?php
                                                                        if ($konten['kriteria_verifikasi_bmp']->num_rows() > 0) {
                                                                            foreach ($konten['kriteria_verifikasi_bmp']->result() as $row) {
                                                                                echo '<option value="' . $row->id_kriteria_verifikasi_bmp . '">' . $row->jml_kriteria_penilaian . ' Kriteria penilaian BMP Rp ' . convertToRupiah($row->biaya) . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container row">
                                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                                <label class="required fs-5 fw-semibold mb-2">Termin I</label>
                                                                <div class="input-group input-group-solid mb-5">
                                                                    <input type="text" class="form-control form-control-solid" autocomplete="off" value="<?php echo $konten['surat_penawaran']->termin_1; ?>" disabled>
                                                                    <span class="input-group-text" id="basic-addon1">%</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                                <label class="required fs-5 fw-semibold mb-2">Setara Dengan</label>
                                                                <div class="input-group input-group-solid mb-5">
                                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                                    <input type="text" class="form-control form-control-solid" autocomplete="off" value="<?php echo convertToRupiah($konten['nilai_kontrak_1']); ?>" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container row">
                                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                                <label class="required fs-5 fw-semibold mb-2">Termin II</label>
                                                                <div class="input-group input-group-solid mb-5">
                                                                    <input type="text" class="form-control form-control-solid" autocomplete="off" value="<?php echo $konten['surat_penawaran']->termin_2; ?>" disabled>
                                                                    <span class="input-group-text" id="basic-addon1">%</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                                <label class="required fs-5 fw-semibold mb-2">Setara Dengan</label>
                                                                <div class="input-group input-group-solid mb-5">
                                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                                    <input type="text" class="form-control form-control-solid" autocomplete="off" value="<?php echo convertToRupiah($konten['nilai_kontrak_2']); ?>" disabled>
                                                                    <input type="hidden" id="nilai_kontrak_termin_2" autocomplete="off" value="<?php echo $konten['nilai_kontrak_2']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($konten['surat_penawaran']->jns_surat_penawaran != 'bmp') {
                                                    ?>
                                                        <table id="rincian_pembayaran" class="table table-sm table-striped gy-5 blockui">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <td class="required" style="width: 50%">Keterangan</td>
                                                                    <td class="required" style="width: 40%">Nilai Pembayaran</td>
                                                                    <td style="width: 10%">Action</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td class="fw-bold text-gray-800 fs-3" style="text-align: right;">TOTAL PEMBAYARAN</td>
                                                                    <td>
                                                                        <div class="input-group input-group-solid">
                                                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                                                            <input type="text" id="total_pembayaran" readonly class="form-control form-control-solid" autocomplete="off" value="0">
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-bold text-danger fs-3" style="text-align: right;">KEKURANGAN</td>
                                                                    <td>
                                                                        <div class="input-group input-group-solid">
                                                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                                                            <input type="text" id="kekurangan" readonly class="form-control form-control-solid" autocomplete="off" value="0">
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                        <input type="hidden" id="index" name="index" value="0">
                                                        <button type="button" id="tambah_baris" class="btn btn-sm btn-light-success"><i class="fa fa-plus"></i> Tambah Baris Pembayaran</button>
                                                    <?php } ?>
                                                    <div class="separator mb-10 mt-10"></div>
                                                    <button type="submit" id="simpan" class="btn btn-primary">
                                                        <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i>Simpan</span>
                                                        <span class="indicator-progress">Loading...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>

                                                    <input type="hidden" id="id_surat_oc" name="id_surat_oc" value="<?php echo (!is_null($konten['surat_oc']) ? $konten['surat_oc']->id_surat_oc : ''); ?>">
                                                    <input type="hidden" id="id_surat_penawaran" name="id_surat_penawaran" value="<?php echo $konten['surat_penawaran']->id_surat_penawaran; ?>">
                                                    <input type="hidden" id="id_dokumen_permohonan" name="id_dokumen_permohonan" value="<?php echo $konten['surat_penawaran']->id_dokumen_permohonan; ?>">
                                                    <input type="hidden" id="jns_surat_penawaran" name="jns_surat_penawaran" value="<?php echo $konten['surat_penawaran']->jns_surat_penawaran; ?>">
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
        function element(i) {
            i = parseInt(i);
            var rangkai = '<tr id="baris_' + i + '">' +
                '<td>' +
                '<textarea id="keterangan_' + i + '" name="keterangan[]" class="form-control form-control-solid" required placeholder="Contoh: 1 Produk Bak / Derek Crane"></textarea>' +
                '</td>' +
                '<td>' +
                '<div class="input-group input-group-solid">' +
                '<span class="input-group-text" id="basic-addon2">Rp</span>' +
                '<input type="text" id="nilai_pembayaran_' + i + '" name="nilai_pembayaran[]" class="form-control" autocomplete="off" required onkeyup="convertToRupiah(this); calculator();" />' +
                '</div>' +
                '<span>Belum termasuk PPN 11%</span>' +
                '</td>' +
                '<td><button type="button" onclick="hapus_baris(' + i + ')" class="btn btn-sm btn-icon btn-danger"><i class="fa fa-trash"></i></button></td>' +
                '</tr>';

            $("#rincian_pembayaran tbody").append(rangkai);
            i += 1;
            $("#index").val(i);
        }

        function hapus_baris(i) {
            $("#baris_" + i).remove();
            var loop = 0;
            $("#rincian_pembayaran tbody tr").each(function() {
                loop++;
            });
            calculator();

            if (loop == 0) {
                $("#rincian_pembayaran").hide();
                $("#index").val(0);
            }
        }
        $("#tambah_baris").click(function() {
            $("#rincian_pembayaran").show();
            var i = $("#index").val();
            element(i);
        });
        element(0);

        function calculator() {
            var nilai_kontrak_termin_2 = $("#nilai_kontrak_termin_2").val();
            var total_nilai_pembayaran = 0;
            var loop = 0;
            $("#rincian_pembayaran tbody tr").each(function() {
                var nilai_pembayaran = convertToAngka($(this).find('input[name ="nilai_pembayaran[]"]').val());
                if (isNaN(nilai_pembayaran))
                    nilai_pembayaran = 0;

                total_nilai_pembayaran = total_nilai_pembayaran + nilai_pembayaran;
                loop++;
            });

            if (loop > 0)
                var kekurangan = nilai_kontrak_termin_2 - total_nilai_pembayaran;
            else
                var kekurangan = 0;

            $("#total_pembayaran").val(rupiah(total_nilai_pembayaran));
            $("#kekurangan").val(rupiah(kekurangan));
        }
        $("#input_form_surat_oc").on('submit', function(e) {
            e.preventDefault();

            var id_surat_oc = $("#id_surat_oc").val();
            var id_surat_penawaran = $("#id_surat_penawaran").val();
            var nomor_oc = $("#nomor_oc").val();
            var tgl_oc = $("#tgl_oc").val();
            var action = $("#action").val();
            var jns_surat_penawaran = $("#jns_surat_penawaran").val();
            if (jns_surat_penawaran != 'bmp') {
                var index = $("#index").val();
                var kekurangan = convertToAngka($("#kekurangan").val());
            }
            var nilai_kontrak_termin_2 = $("#nilai_kontrak_termin_2").val();

            if (!action || !nomor_oc || !id_surat_penawaran || !tgl_oc) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else if (jns_surat_penawaran != 'bmp' && index > 0 && kekurangan != 0) {
                var response = JSON.parse('<?php echo alert('total_pembayaran_kurang'); ?>');
                response.message += '<div class="fw-bold fs-3">Rp ' + rupiah(nilai_kontrak_termin_2) + '</div>';
                swalAlert(response);

            } else if (!moment(tgl_oc).isValid()) {
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
                            //hapus seluruh field...
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
            var url = base_url + 'page/buat_konfirmasi_order';
            location.href = url;
        }
    </script>
</body>
<!-- end::Body -->

</html>