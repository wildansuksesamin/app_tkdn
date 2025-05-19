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

                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <!--begin::Secondary button-->
                                    <a href="<?php echo base_url('page/pekerjaan'); ?>" class="btn btn-sm btn-light btn-active-light-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                                    <!--end::Secondary button-->
                                </div>
                                <!--end::Page title-->
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <div class="card card-flush">

                                    <!--begin::Body-->
                                    <div class="card-body p-lg-17">
                                        <div class="d-flex flex-column flex-lg-row">
                                            <!--begin::Content-->
                                            <div class="flex-lg-row-fluid me-0">
                                                <!--begin::Form-->
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_ptt_reguler" action="<?php echo base_url(); ?>sppd_project/simpan" autocomplete="off">
                                                    <input type="hidden" name="id_sppd" id="id_sppd" value="<?php echo ($konten['action'] == 'revisi' ? $konten['id_sppd'] : ''); ?>">
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="fs-5 fw-semibold mb-2">Nomor Order</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" value="<?php echo $konten['dokumen_permohonan']->nomor_order_payment; ?>" disabled>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="fs-5 fw-semibold mb-2">Nama Perusahaan</label>
                                                            <input type="text" class="form-control form-control-solid" autocomplete="off" value="<?php echo $konten['dokumen_permohonan']->nama_badan_usaha . ' ' . $konten['dokumen_permohonan']->nama_perusahaan; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nomor SPPD</label>
                                                            <input type="text" class="form-control form-control-solid" name="nomor_sppd" id="nomor_sppd" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['sppd']->nomor_sppd : ''); ?>" required>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tanggal SPPD</label>
                                                            <div class="input-group input-group-solid mb-5">
                                                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                                                                <input type="text" class="form-control form-control-solid datepicker" name="tgl_sppd" id="tgl_sppd" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_reguler']->tgl_sppd : ''); ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Nama</label>
                                                            <input type="text" class="form-control form-control-solid" name="nama" id="nama" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_reguler']->nama : $konten['koordinator']->nama_admin); ?>" maxlength="200" required>

                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tingkat Jabatan</label>
                                                            <input type="text" class="form-control form-control-solid" name="tingkat_jabatan" id="tingkat_jabatan" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_reguler']->tingkat_jabatan : '3C'); ?>" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">NPP</label>
                                                            <input type="text" class="form-control form-control-solid" name="npp" id="npp" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_reguler']->npp : '15060'); ?>" maxlength="10" required>

                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tingkat Pangkat</label>
                                                            <input type="text" class="form-control form-control-solid" name="tingkat_pangkat" id="tingkat_pangkat" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_reguler']->tingkat_pangkat : '3D'); ?>" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Jabatan</label>
                                                            <input type="text" class="form-control form-control-solid" name="jabatan" id="jabatan" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_reguler']->jabatan : 'Inspector 3-Bid. IG Cab. Surabaya'); ?>" maxlength="100" required>

                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Currency</label>
                                                            <input type="text" class="form-control form-control-solid" name="mata_uang" id="mata_uang" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_reguler']->mata_uang : 'IDR'); ?>" maxlength="3" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Unit Kerja</label>
                                                            <input type="text" class="form-control form-control-solid" name="unit_kerja" id="unit_kerja" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_reguler']->unit_kerja : 'Cabang Surabaya'); ?>" maxlength="100" required>

                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">No Rekening</label>
                                                            <input type="text" class="form-control form-control-solid" name="no_rekening" id="no_rekening" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_reguler']->no_rekening : '1410010341873'); ?>" maxlength="20" required>
                                                        </div>
                                                    </div>

                                                    <div class="separator mb-10 mt-10"></div>

                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class=" fs-5 fw-semibold mb-2">Tanggal Payment</label>
                                                            <div class="input-group input-group-solid mb-5">
                                                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                                                                <input type="text" class="form-control form-control-solid datepicker" name="tgl_payment" id="tgl_payment" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_reguler']->tgl_payment : ''); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class=" fs-5 fw-semibold mb-2">Umur Biaya</label>
                                                            <div class="input-group input-group-solid mb-5">
                                                                <input type="text" class="form-control form-control-solid" name="umur_biaya" id="umur_biaya" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_reguler']->umur_biaya : ''); ?>">
                                                                <span class="input-group-text" id="basic-addon2">Hari</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="separator mb-10 mt-10"></div>

                                                    <div class="mb-10" style="font-weight: bold; font-size: 17px">Rincian Realisasi</div>
                                                    <div class="table-responsive">
                                                        <table id="form_rincian" class="table table-sm">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                    <th style="width: 5%">No</th>
                                                                    <th class="required" style="width: 30%">Uraian Kegiatan</th>
                                                                    <th class="required" style="width: 15%">Jumlah</th>
                                                                    <th style="width: 20%">Biaya (Rp)</th>
                                                                    <th class="required" style="width: 25%">Total Biaya</th>
                                                                    <th style="width: 5%"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="6">
                                                                        <button type="button" class="btn btn-primary btn-block btn-sm" onclick="tambah_baris()"><i class="fa fa-plus"></i> Tambah Baris</button>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style="text-align: right;">Jumlah Pengeluaran</td>
                                                                    <td>
                                                                        <div class="input-group input-group-solid">
                                                                            <span class="input-group-text" id="basic-addon2">Rp</span>
                                                                            <input type="text" id="grand_total" name="grand_total" class="form-control" autocomplete="off" readonly />
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style="text-align: right;">Jumlah Biaya Perjalanan Dinas Masih Harus Dipertanggungjawabkan</td>
                                                                    <td>
                                                                        <div class="input-group input-group-solid">
                                                                            <span class="input-group-text" id="basic-addon2">Rp</span>
                                                                            <input type="text" id="biaya_perjalanan_dinas" name="biaya_perjalanan_dinas" class="form-control" autocomplete="off" onkeyup="convertToRupiah(this); calculator();" value="<?php echo (($konten['action'] == 'revisi' and $konten['ptt_reguler']->biaya_perjalanan_dinas > 0) ? convertToRupiah($konten['ptt_reguler']->biaya_perjalanan_dinas) : '') ?>" />
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3" style="text-align: right;">No BPUK Biaya Perjalanan Dinas Masih Harus Dipertanggungjawabkan</td>
                                                                    <td>
                                                                        <div class="fv-plugins-icon-container">
                                                                            <div class="input-group input-group-solid">
                                                                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                                                                                <input type="text" class="form-control form-control-solid datepicker" name="tgl_bpuk" id="tgl_bpuk" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_reguler']->tgl_bpuk : ''); ?>">
                                                                            </div>
                                                                        </div>

                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-solid">
                                                                            <span class="input-group-text" id="basic-addon2">Rp</span>
                                                                            <input type="text" id="biaya_bpuk" name="biaya_bpuk" class="form-control" autocomplete="off" onkeyup="convertToRupiah(this); calculator();" value="<?php echo (($konten['action'] == 'revisi' and $konten['ptt_reguler']->biaya_bpuk > 0) ? convertToRupiah($konten['ptt_reguler']->biaya_bpuk) : '') ?>" />
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style="text-align: right;">Jumlah yang harus <span class="status_kembali_terima" id="kembali">dikembalikan</span><span class="status_kembali_terima" id="terima" style="display: none;">diterima</span></td>
                                                                    <td>
                                                                        <div class="input-group input-group-solid">
                                                                            <span class="input-group-text" id="basic-addon2">Rp</span>
                                                                            <input type="text" id="kurang_lebih" name="kurang_lebih" class="form-control" autocomplete="off" readonly value="<?php echo (($konten['action'] == 'revisi' and $konten['ptt_reguler']->kurang_lebih > 0) ? convertToRupiah($konten['ptt_reguler']->kurang_lebih) : '') ?>" />
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                            </tfoot>
                                                        </table>
                                                        <input type="hidden" name="index" id="index" value="0">
                                                        <div class="separator mb-10 mt-10"></div>
                                                        <button type="button" id="simpan" class="btn btn-primary">
                                                            <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                                            <span class="indicator-progress">Loading...
                                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
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

    <script>
        $(document).ready(function() {
            var rincian_sppd = '';
            var action = '<?php echo $konten['action']; ?>';
            <?php
            if ($konten['action'] == 'revisi') {
                echo 'rincian_sppd = safelyParseJSON(\'' . json_encode($konten['rincian_sppd']) . '\');';
            }
            ?>
            if (rincian_sppd.length > 0) {
                hapus_baris(0);
                for (var a = 0; a < rincian_sppd.length; a++) {
                    tambah_baris();

                    //dikurangi 1 karena di dalam function tambah_baris sudah ditambah 1...
                    //fungsi dikurangi 1 adalah untuk mengarahkan ke index baris yang baru ditambah...
                    var i = $("#index").val() - 1;


                    $("#komponen_sppd_" + i).val(rincian_sppd[a].komponen_sppd).trigger('change');
                    $("#jml_" + i).val(rincian_sppd[a].jml);
                    $("#nilai_" + i).val(rupiah(rincian_sppd[a].nilai));
                    $("#total_" + i).val(rupiah(rincian_sppd[a].total));
                }
                calculator();
            } else {
                //jika tidak sedang dalam mode revisi, maka tampilkan semua komponen sppd yang memiliki status default = true...

                var komponen_sppd = '';
                <?php
                if ($konten['komponen_sppd']->num_rows() > 0) {
                    echo 'komponen_sppd = safelyParseJSON(\'' . json_encode($konten['komponen_sppd']->result()) . '\'); ';
                }
                ?>
                if (komponen_sppd.length > 0) {
                    for (var i = 0; i < komponen_sppd.length; i++) {
                        if (komponen_sppd[i].default == 1) {
                            tambah_baris();
                            $("#komponen_sppd_" + i).val(komponen_sppd[i].nama_komponen).trigger('change');
                        }
                    }
                    hapus_baris(komponen_sppd.length);
                }
            }

            $('#tgl_sppd, #tgl_payment, #tgl_bpuk').flatpickr(datepicker_variable);

            $(".timepicker").flatpickr({
                noCalendar: true,
                enableTime: true,
                dateFormat: "H:i",
            });
        });

        function baris_item(i) {
            var element = '<tr class="baris" id="baris_' + i + '">' +
                '<td class="nomor"></td>' +
                '<td>' +
                '<select id="komponen_sppd_' + i + '" name="komponen_sppd" onchange="pilih_komponen_sppd(' + i + ')" class="form-select form-select-solid" data-control="select2" data-minimum-results-for-search="Infinity" required>' +
                <?php
                echo '\'<option value=""></option>\'+';
                if ($konten['komponen_sppd']->num_rows() > 0) {
                    foreach ($konten['komponen_sppd']->result() as $row) {
                        echo '\'<option value="' . $row->nama_komponen . '" data-nilai="' . $row->nilai . '">' . $row->nama_komponen . '</option>\'+';
                    }
                }
                ?> '</select>' +
                '</td>' +
                '<td><input type="number" class="form-control form-control-solid" id="jml_' + i + '" name="jml" required onkeyup="calculator()"></td>' +
                '<td>' +
                '<div class="input-group input-group-solid mb-5">' +
                '<span class="input-group-text" id="basic-addon2">Rp</span>' +
                '<input type="text" id="nilai_' + i + '" name="nilai" class="form-control" autocomplete="off" onkeyup="convertToRupiah(this); calculator();" required />' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<div class="input-group input-group-solid mb-5">' +
                '<span class="input-group-text" id="basic-addon2">Rp</span>' +
                '<input type="text" id="total_' + i + '" name="total" class="form-control" autocomplete="off" readonly />' +
                '</div>' +
                '</td>' +
                '<td><button type="button" class="btn btn-danger btn-icon" onclick="hapus_baris(' + i + ')"><i class="fa fa-trash"></i></button></td>' +
                '</tr>';
            return element;
        }
        tambah_baris();

        function numbering() {
            var no = 1;
            $(".nomor").each(function(index) {
                var nomorUrut = index + 1;
                $(this).text(nomorUrut);
            });
        }

        function tambah_baris() {
            var i = $("#index").val();
            var element = baris_item(i);
            $("#form_rincian tbody").append(element);
            $('[data-control="select2"]').select2();
            numbering();

            i++;
            $("#index").val(i);
        }

        function hapus_baris(i) {
            $("#baris_" + i).remove();
            numbering();
        }

        function calculator() {
            var grand_total = 0;
            $('.baris').each(function() {
                var jml = convertToAngka($(this).find('input[name="jml"]').val());
                var nilai = convertToAngka($(this).find('input[name="nilai"]').val());

                var total = jml * nilai;
                $(this).find('input[name="total"]').val(rupiah(total));

                grand_total += total;
            });
            $("#grand_total").val(rupiah(grand_total));

            var biaya_perjalanan_dinas = convertToAngka($("#biaya_perjalanan_dinas").val());
            if (biaya_perjalanan_dinas > 0) {
                var kurang_lebih = biaya_perjalanan_dinas - grand_total;
                //buat positif dulu...
                var negatif = false;
                $(".status_kembali_terima").hide();
                if (kurang_lebih < 0) {
                    negatif = true;
                    kurang_lebih = kurang_lebih * -1;
                    $("#kembali").show();
                } else {
                    $("#terima").show();
                }
                $("#kurang_lebih").val(rupiah(kurang_lebih));
            }


        }

        function pilih_komponen_sppd(i) {
            var selectedOption = $('#komponen_sppd_' + i).find(':selected');
            var nilai = selectedOption.data('nilai');
            $("#nilai_" + i).val(rupiah(nilai));
            calculator();
        }

        $("#simpan").click(function() {
            var id_sppd = $("#id_sppd").val();
            var nomor_sppd = $("#nomor_sppd").val();
            var tgl_sppd = $("#tgl_sppd").val();
            var nama = $("#nama").val();
            var tingkat_jabatan = $("#tingkat_jabatan").val();
            var npp = $("#npp").val();
            var tingkat_pangkat = $("#tingkat_pangkat").val();
            var jabatan = $("#jabatan").val();
            var mata_uang = $("#mata_uang").val();
            var unit_kerja = $("#unit_kerja").val();
            var no_rekening = $("#no_rekening").val();
            var biaya_perjalanan_dinas = $("#biaya_perjalanan_dinas").val();
            var tgl_bpuk = $("#tgl_bpuk").val();
            var biaya_bpuk = $("#biaya_bpuk").val();
            var tgl_payment = $("#tgl_payment").val();
            var umur_biaya = $("#umur_biaya").val();
            var action = '<?php echo $konten['action']; ?>';;

            var rincian = [];
            var isEmpty = false; // variabel pengecekan nilai kosong
            $('#form_rincian tbody tr').each(function() {
                var rowRincian = {};

                $(this).find('input, select').each(function() {
                    var inputName = $(this).attr('name');
                    var inputValue = $(this).val();

                    rowRincian[inputName] = inputValue;

                    // pengecekan nilai kosong pada element required
                    if ($(this).prop('required') && inputValue === '') {
                        isEmpty = true;
                        return false; // keluar dari loop jika ada nilai kosong
                    }
                });

                rincian.push(rowRincian);
            });

            if (!nomor_sppd || !tgl_sppd || !nama || !tingkat_jabatan || !npp || !tingkat_pangkat || !jabatan || !mata_uang || !unit_kerja || !no_rekening || isEmpty) {
                var response = JSON.parse('<?php echo alert('kosong'); ?>');
                swalAlert(response);
            } else {
                $("#simpan").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });
                var data = {
                    'token': '<?php echo genToken('SEND_DATA'); ?>',
                    'id_opening_meeting': '<?php echo $konten['id_opening_meeting']; ?>',
                    'id_sppd': id_sppd,
                    'nomor_sppd': nomor_sppd,
                    'tgl_sppd': tgl_sppd,
                    'nama': nama,
                    'tingkat_jabatan': tingkat_jabatan,
                    'npp': npp,
                    'tingkat_pangkat': tingkat_pangkat,
                    'jabatan': jabatan,
                    'mata_uang': mata_uang,
                    'unit_kerja': unit_kerja,
                    'no_rekening': no_rekening,
                    'biaya_perjalanan_dinas': biaya_perjalanan_dinas,
                    'tgl_bpuk': tgl_bpuk,
                    'biaya_bpuk': biaya_bpuk,
                    'tgl_payment': tgl_payment,
                    'umur_biaya': umur_biaya,
                    'action': action,
                    'rincian': rincian
                };

                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>sppd_reguler/simpan',
                    data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                    cache: false,
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
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
        })

        function after_save() {
            location.href = base_url + 'page/pekerjaan';
        }
    </script>
</body>
<!-- end::Body -->

</html>