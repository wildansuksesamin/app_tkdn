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
                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_ptt_project" action="<?php echo base_url(); ?>sppd_project/simpan" autocomplete="off">
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
                                                            <label class="fs-5 fw-semibold mb-2">Nomor SPPD</label>
                                                            <input type="text" class="form-control form-control-solid" name="nomor_sppd" id="nomor_sppd" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['sppd']->nomor_sppd : ''); ?>" required>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="fs-5 fw-semibold mb-2">Tanggal SPPD</label>
                                                            <div class="input-group input-group-solid mb-5">
                                                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                                                                <input type="text" class="form-control form-control-solid datepicker" name="tgl_sppd" id="tgl_sppd" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_project']->tgl_sppd : ''); ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="fs-5 fw-semibold mb-2">Tanggal Berangkat</label>
                                                            <div class="input-group input-group-solid mb-5">
                                                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                                                                <input type="text" class="form-control form-control-solid datepicker" name="tgl_berangkat" id="tgl_berangkat" autocomplete="off" onchange="hitung_hari()" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_project']->tgl_berangkat : ''); ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="fs-5 fw-semibold mb-2">Tanggal Tiba</label>
                                                            <div class="input-group input-group-solid mb-5">
                                                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                                                                <input type="text" class="form-control form-control-solid datepicker" name="tgl_tiba" id="tgl_tiba" autocomplete="off" onchange="hitung_hari()" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_project']->tgl_tiba : ''); ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="fs-5 fw-semibold mb-2">Jam Mulai</label>
                                                            <div class="input-group input-group-solid mb-5">
                                                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-clock"></i></span>
                                                                <input type="text" class="form-control form-control-solid timepicker" name="jam_mulai" id="jam_mulai" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_project']->jam_mulai : ''); ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="fs-5 fw-semibold mb-2">Jam Tiba</label>
                                                            <div class="input-group input-group-solid mb-5">
                                                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-clock"></i></span>
                                                                <input type="text" class="form-control form-control-solid timepicker" name="jam_tiba" id="jam_tiba" autocomplete="off" value="<?php echo ($konten['action'] == 'revisi' ? $konten['ptt_project']->jam_tiba : ''); ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2">Tempat Pelaksanaan</label>
                                                            <select id="tempat_pelaksanaan" name="tempat_pelaksanaan" class="form-select form-select-solid" data-control="select2" required>
                                                                <?php
                                                                if ($konten['kota']->num_rows() > 0) {
                                                                    foreach ($konten['kota']->result() as $row) {
                                                                        echo '<option value="' . $row->name . '">' . $row->name . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
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
                                                                    <td colspan="4" style="text-align: right;">Jumlah</td>
                                                                    <td>
                                                                        <div class="input-group input-group-solid">
                                                                            <span class="input-group-text" id="basic-addon2">Rp</span>
                                                                            <input type="text" id="grand_total" name="grand_total" class="form-control" autocomplete="off" readonly />
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style="text-align: right;">Uang Muka</td>
                                                                    <td>
                                                                        <div class="input-group input-group-solid">
                                                                            <span class="input-group-text" id="basic-addon2">Rp</span>
                                                                            <input type="text" id="uang_muka" name="uang_muka" class="form-control" autocomplete="off" onkeyup="convertToRupiah(this); calculator(); cek_uang_muka();" value="<?php echo (($konten['action'] == 'revisi' and $konten['ptt_project']->uang_muka > 0) ? convertToRupiah($konten['ptt_project']->uang_muka) : ''); ?>" />
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style="text-align: right;"><span class="kurang_lebih" id="kurang">Kekurangan</span><span class="kurang_lebih" id="lebih" style="display: none;">Kelebihan</span></td>
                                                                    <td>
                                                                        <div class="input-group input-group-solid">
                                                                            <span class="input-group-text" id="basic-addon2">Rp</span>
                                                                            <input type="text" id="kurang_lebih" name="kurang_lebih" class="form-control" autocomplete="off" readonly value="<?php echo (($konten['action'] == 'revisi' and $konten['ptt_project']->kurang_lebih > 0) ? convertToRupiah($konten['ptt_project']->kurang_lebih) : '') ?>" />
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
            var tempat_pelaksanaan = '';
            var rincian_sppd = '';
            var action = '<?php echo $konten['action']; ?>';
            <?php
            if ($konten['action'] == 'revisi') {
                echo 'tempat_pelaksanaan = \'' . $konten['ptt_project']->tempat_pelaksanaan . '\'; ';

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

            $("#tempat_pelaksanaan").val(tempat_pelaksanaan).trigger('change');
            $('#tgl_sppd, #tgl_berangkat, #tgl_tiba').flatpickr(datepicker_variable);

            $(".timepicker").flatpickr({
                noCalendar: true,
                enableTime: true,
                dateFormat: "H:i",
            });
        });

        function hitung_hari() {
            const tanggalAwal = moment($("#tgl_berangkat").val());
            const tanggalAkhir = moment($("#tgl_tiba").val());

            // Menghitung selisih dalam jumlah hari
            var selisihHari = tanggalAkhir.diff(tanggalAwal, 'days');

            if (!isNaN(selisihHari)) {
                selisihHari++;

                $('.baris').each(function() {
                    var komponen_sppd = $(this).find('[name="komponen_sppd"]').val();

                    switch (komponen_sppd) {
                        case 'Transport Terminal':
                            $(this).find('input[name="jml"]').val(1);
                            break;
                        case 'Transport Lokal':
                            $(this).find('input[name="jml"]').val(selisihHari--);
                            break;
                        case 'Penginapan':
                            $(this).find('input[name="jml"]').val(selisihHari--);
                            break;
                        case 'Uang Saku / Uang Makan':
                            $(this).find('input[name="jml"]').val(selisihHari);
                            break;
                    }
                });

                calculator();
            }

        }

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
                '<td><input type="number" class="form-control form-control-solid" id="jml_' + i + '" name="jml" onkeyup="calculator()"></td>' +
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
            $("#jml_" + i).val('');
            calculator();
            // $("#baris_" + i).remove();
            // numbering();
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

            var uang_muka = convertToAngka($("#uang_muka").val());
            if (uang_muka > 0) {
                var kurang_lebih = uang_muka - grand_total;
                //buat positif dulu...
                var negatif = false;
                $(".kurang_lebih").hide();
                if (kurang_lebih < 0) {
                    negatif = true;
                    kurang_lebih = kurang_lebih * -1;

                    $("#kurang").show();
                } else {
                    $("#lebih").show();

                }
                $("#kurang_lebih").val(rupiah(kurang_lebih));
            }
        }

        function cek_uang_muka() {
            var uang_muka = $("#uang_muka").val();
            if (uang_muka == 0) {
                $("#uang_muka").val('');
                $("#kurang_lebih").val('');
            }
        }

        function pilih_komponen_sppd(i) {
            var selectedOption = $('#komponen_sppd_' + i).find(':selected');
            var value = selectedOption.val();
            var nilai = selectedOption.data('nilai');

            var cek_kembar = false;
            $('#form_rincian tbody tr').each(function() {

                $(this).find('input, select').each(function() {
                    var inputValue = $(this).val();
                    var inputId = $(this).attr('id');
                    var index = inputId.replace('komponen_sppd_', '');
                    if (inputValue == value && i != index) {
                        cek_kembar = true;

                        hapus_baris(i);
                    }
                });
            });

            if (cek_kembar) {
                var response = JSON.parse('<?php echo alert('data_kembar'); ?>');
                swalAlert(response);
            } else {
                $("#nilai_" + i).val(rupiah(nilai));
                calculator();
            }
        }

        $("#simpan").click(function() {
            var id_sppd = $("#id_sppd").val();
            var nomor_sppd = $("#nomor_sppd").val();
            var tgl_berangkat = $("#tgl_berangkat").val();
            var tgl_tiba = $("#tgl_tiba").val();
            var jam_mulai = $("#jam_mulai").val();
            var jam_tiba = $("#jam_tiba").val();
            var tempat_pelaksanaan = $("#tempat_pelaksanaan").val();
            var uang_muka = $("#uang_muka").val();
            var kurang_lebih = $("#kurang_lebih").val();
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

            if (!nomor_sppd || !tgl_berangkat || !tgl_tiba || !jam_mulai || !jam_tiba || !tempat_pelaksanaan || isEmpty) {
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
                    'tgl_berangkat': tgl_berangkat,
                    'tgl_tiba': tgl_tiba,
                    'jam_mulai': jam_mulai,
                    'jam_tiba': jam_tiba,
                    'tempat_pelaksanaan': tempat_pelaksanaan,
                    'uang_muka': uang_muka,
                    'kurang_lebih': kurang_lebih,
                    'action': action,
                    'rincian': rincian
                };

                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>sppd_project/simpan',
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