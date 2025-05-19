<div class="modal fade" id="folder_bom_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-xxl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title row" id="bom-informasi_bom" style="width: 100%;">

                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-sm table-row-bordered" id="bom-rincian">
                        <thead style="position: sticky; top: 0; background: #FFF">
                            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                <th style="width: 3%;">No</th>
                                <th style="width: 14%;">Uraian</th>
                                <th style="width: 14%;">Spesifikasi</th>
                                <th style="width: 7%;">Satuan Bahan Baku</th>
                                <th style="width: 12%;">Negara Asal</th>
                                <th style="width: 15%;">Vendor / Supplier</th>
                                <th style="width: 10%;">Jumlah Pemakaian <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" data-bs-placement="right" title="Jumlah pemakaian untuk 1 (satu) satuan produk"></i></th>
                                <th style="width: 10%;">Harga Satuan (Rp) <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" data-bs-placement="right" title="Harga satuan material (Rupiah)"></i></th>
                                <th style="width: 15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
                    </table>
                    <input type="hidden" id="bom-id_collecting_dokumen">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light btn-active-light-primary me-2" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i> Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpan_tabel_bom()">
                    <!--begin::Indicator label-->
                    <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                    <span class="indicator-progress">Tunggu Sebentar...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    var data_bom;
    var bom;
    var yakin_tutup = false;
    $('#myModal').on('shown.bs.modal', function() {
        yakin_tutup = false;
    });
    $('#folder_bom_modal').on('hide.bs.modal', function(event) {
        if (!yakin_tutup) {
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda ingin menyimpan perubahan?',
                icon: 'question',
                confirmButtonText: 'Simpan',
                showCancelButton: true,
                showDenyButton: true,
                denyButtonText: 'Jangan Simpan',
                denyButtonColor: '#dc3545',
                cancelButtonText: 'Batal',
                cancelButtonColor: '#707070',
                showCloseButton: true,
                closeButtonAriaLabel: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    yakin_tutup = true;
                    // Tombol Simpan diklik
                    $("#folder_bom_modal").modal('hide');
                    simpan_tabel_bom();
                } else if (result.isDenied) {
                    yakin_tutup = true;
                    $("#folder_bom_modal").modal('hide');
                } else {
                    //jangan tutup modal

                }
            });
        } else {
            yakin_tutup = false;
        }

    });

    function load_bom(id_collecting_dokumen) {
        $("#bom-id_collecting_dokumen").val(id_collecting_dokumen);
        var data = new Object;
        data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
        data['id_collecting_dokumen'] = id_collecting_dokumen;

        preloader('show');

        ajax_request = $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>pelanggan_area/bom/load_data',
            data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
            cache: false,
            dataType: "json",
            success: function(result) {
                preloader('hide');
                data_bom = result;

                var kolom_tambahan = safelyParseJSON(data_bom.collecting_dokumen.kolom_tambahan);
                var rangkai = '';
                if (kolom_tambahan.length > 0) {
                    for (var i = 0; i < kolom_tambahan.length; i++) {
                        rangkai += '<div class="col-sm-4 mb-2">' +
                            '<label class="fs-7 text-gray-400">' + kolom_tambahan[i].label + '</label>' +
                            '<input type="text" id="' + kolom_tambahan[i].field + '" data-label="' + kolom_tambahan[i].label + '" class="form-control form-control-solid" autocomplete="off" value="' + kolom_tambahan[i].value + '"/>' +
                            '</div>';
                    }
                }
                $("#bom-informasi_bom").html(rangkai);

                rangkai = '';
                if (data_bom.bom.length > 0) {
                    bom = data_bom.bom;
                    var total = 0;
                    for (var i = 0; i < bom.length; i++) {
                        total += parseFloat(bom[i].harga_satuan);
                        var btn_action = '';
                        var badge_status = '';
                        var alasan_tolak = '';
                        if (bom[i].tipe != 'GRUP') {
                            if (bom[i].status_verifikasi == 0) {
                                badge_status = render_badge('secondary btn-block p-2', 'Menunggu Dokumen');
                            } else if (bom[i].status_verifikasi == 1) {
                                badge_status = render_badge('success btn-block p-2', 'Dokumen Disetujui');
                            } else if (bom[i].status_verifikasi == 2) {
                                badge_status = render_badge('danger btn-block p-2', 'Dokumen Ditolak');
                                alasan_tolak = '<div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-2">' +
                                    '<?php echo getSvgIcon('general/gen040', 'svg-icon svg-icon-1 svg-icon-danger me-4'); ?>' +
                                    '<div class = "d-flex flex-stack flex-grow-1" >' +
                                    '<div class = "fw-semibold" >' +
                                    '<div class = "fs-7 text-gray-700" >' + bom[i].alasan_verifikasi + '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                            } else if (bom[i].status_verifikasi == 3) {
                                badge_status = render_badge('info btn-block p-2', 'Dokumen Diverifikasi');
                            }
                            badge_status = '<div class="separator mb-3 mt-3"></div><div class="mt-2 mb-3">' + badge_status + '</div>';

                            var invoice = '';
                            if (bom[i].invoice) {
                                var ext = bom[i].invoice.slice((bom[i].invoice.lastIndexOf('.') - 1 >>> 0) + 2);
                                //jika sudah ada filenya...
                                invoice = '<div class="mb-3 row">' +
                                    '<div class="col-12"><a href="' + base_url + bom[i].invoice + '" class="btn btn-sm btn-block btn-primary" download="invoice_' + bom[i].uraian + '.' + ext + '"><i class="fa fa-download"></i> Download File</a></div>' +
                                    '</div>';
                            } else {
                                //jika belum ada filenya...
                                invoice = '<div class="mb-3"><button class="btn btn-sm btn-block btn-light"><i class="fa fa-file"></i> Belum Ada File</button></div>';
                            }
                            var faktur_pajak = '';
                            if (bom[i].faktur_pajak) {
                                //jika sudah ada filenya...
                                var ext = bom[i].faktur_pajak.slice((bom[i].faktur_pajak.lastIndexOf('.') - 1 >>> 0) + 2);
                                //jika sudah ada filenya...
                                faktur_pajak = '<div class="mb-3 row">' +
                                    '<div class="col-12"><a href="' + base_url + bom[i].faktur_pajak + '" class="btn btn-sm btn-block btn-primary" download="faktur_pajak_' + bom[i].uraian + '.' + ext + '"><i class="fa fa-download"></i> Download File</a></div>' +
                                    '</div>';
                            } else {
                                //jika belum ada filenya...
                                faktur_pajak = '<div class="mb-3"><button class="btn btn-sm btn-block btn-light"><i class="fa fa-file"></i> Belum Ada File</button></div>';
                            }
                            btn_action = '<div>' +
                                '<label class="fw-bold">Invoice</label>' + invoice +
                                '<label class="fw-bold">Faktur Pajak</label>' + faktur_pajak +
                                '</div>';
                            if (bom[i].status_verifikasi != 1 && bom[i].status_verifikasi != 2) {
                                btn_action += '<div class="separator mb-3 mt-3"></div>' +
                                    '<div class="row">' +
                                    '<div class="col-sm-6"><button class="btn btn-block btn-sm btn-success" onclick="verifikasi_file_bom(\'setuju\', ' + i + ')"><i class="fa fa-check"></i> Setuju</button></div>' +
                                    '<div class="col-sm-6"><button class="btn btn-block btn-sm btn-danger" onclick="verifikasi_file_bom(\'tolak\', ' + i + ')"><i class="fa fa-times"></i> Tolak</button></div>' +
                                    '</div>';
                            }
                        }
                        if (bom[i].tipe == 'GRUP') {
                            rangkai += '<tr style="background: #eaeaea;">' +
                                '<td colspan="9" class="fw-bold p-3">' + bom[i].uraian + '</td>' +
                                '</tr>';

                        } else {
                            rangkai += '<tr>' +
                                '<td class="nomor pt-6"></td>' +
                                '<td>' +
                                '<div><input type="text" id="uraian_' + i + '" name="uraian[]" data-name="uraian" class="form-control form-control-solid" autocomplete="off" value="' + bom[i].uraian + '"/></div>' +
                                '<input type="hidden" id="id_bom_' + i + '" name="id_bom[]" data-name="id_bom" value="' + bom[i].id_bom + '"/>' +
                                '</td>' +
                                '<td><textarea id="spesifikasi_' + i + '" name="spesifikasi[]" data-name="spesifikasi" class="form-control form-control-solid" autocomplete="off">' + bom[i].spesifikasi + '</textarea></td>' +
                                '<td><input type="text" id="satuan_bahan_baku_' + i + '" name="satuan_bahan_baku[]" data-name="satuan_bahan_baku" class="form-control form-control-solid" autocomplete="off" value="' + bom[i].satuan_bahan_baku + '"/></td>' +
                                '<td><input type="text" id="negara_asal_' + i + '" name="negara_asal[]" data-name="negara_asal" class="form-control form-control-solid" autocomplete="off" value="' + bom[i].negara_asal + '"/></td>' +
                                '<td><input type="text" id="vendor_suplier_' + i + '" name="vendor_suplier[]" data-name="vendor_suplier" class="form-control form-control-solid" autocomplete="off" value="' + bom[i].vendor_suplier + '"/></td>' +
                                '<td><input type="text" id="jml_pemakaian_satuan_produk_' + i + '" name="jml_pemakaian_satuan_produk[]" data-name="jml_pemakaian_satuan_produk" class="form-control form-control-solid" autocomplete="off" onkeyup="calculator();" value="' + bom[i].jml_pemakaian_satuan_produk + '" style="text-align: right;"/></td>' +
                                '<td><input type="text" id="harga_satuan_' + i + '" name="harga_satuan[]" data-name="harga_satuan" class="form-control form-control-solid" autocomplete="off" onkeyup="convertToRupiah(this); calculator();" value="' + rupiah(bom[i].harga_satuan) + '" style="text-align: right;"/></td>' +
                                // '<td>' + input_file + badge_status + alasan_tolak + '<div class="separator mb-3  mt-3"></div><a href="javascript:;" class="btn btn-sm btn-block btn-light-danger mb-2" onclick="hapus_baris(this, ' + i + ')"><i class="fa fa-times"></i> Hapus Baris Ini</a><a href="javascript:;" class="btn btn-sm btn-block btn-light-primary mb-2" onclick="tambah_baris(this)"><i class="fa fa-plus"></i> Tambah Baris Baru</a></td>' +
                                '<td>' + btn_action + badge_status + alasan_tolak + '</td>' +

                                '</tr>';

                        }
                    }
                    $("#bom-rincian tbody").html(rangkai);
                    var footer = '<tr style="background: #eaeaea">' +
                        '<td colspan="7" class="fw-bold fs-5 p-3">TOTAL</td>' +
                        '<td class="fw-bold fs-5" id="total_bom" style="text-align: right;">Rp ' + rupiah(total) + '</td>' +
                        '<td></td>' +
                        '</tr>';
                    $("#bom-rincian tfoot").html(footer);

                    penomoran();
                    calculator();
                }
            }

        });
    }

    function penomoran() {
        var nomor = 1;
        $('.nomor').each(function() {
            $(this).text(nomor);
            nomor++;
        });

    }

    function calculator() {
        var grandTotal = 0;

        $("#bom-rincian > tbody > tr").each(function() {
            var jmlPemakaian = parseFloat(convertToAngka($(this).find("input[name='jml_pemakaian_satuan_produk[]']").val()));
            var hargaSatuan = parseFloat(convertToDesimal($(this).find("input[name='harga_satuan[]']").val()));

            $(this).find("input[name='jml_pemakaian_satuan_produk[]']").val(jmlPemakaian);

            if (!isNaN(jmlPemakaian) && !isNaN(hargaSatuan)) {
                var subtotal = jmlPemakaian * hargaSatuan;
                grandTotal += subtotal;
            }
        });

        if (!Number.isInteger(grandTotal)) {
            grandTotal = grandTotal.toFixed(2);
        }

        $("#total_bom").html('Rp ' + rupiah(grandTotal));
    }

    function simpan_tabel_bom() {
        //show loading animation...
        preloader('show');

        var header_bom = [];
        $('#bom-informasi_bom input[type="text"]').each(function() {
            header_bom.push({
                "field": $(this).attr('id'),
                "label": $(this).data('label'),
                "value": $(this).val()
            });
        });

        header_bom = JSON.stringify(header_bom);

        var items = [];
        $('#bom-rincian tbody tr').each(function() {
            var rowData = {};
            $(this).find('input[type="text"], input[type="hidden"], textarea').each(function() {
                var name = $(this).attr('data-name');
                var value = $(this).val();
                rowData[name] = value;
            });
            if (Object.keys(rowData).length !== 0) {
                items.push(rowData);
            }
        });

        items = JSON.stringify(items);

        var id_collecting_dokumen = $("#bom-id_collecting_dokumen").val();

        var data = new Object;
        data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
        data['id_collecting_dokumen'] = id_collecting_dokumen;
        data['header_bom'] = header_bom;
        data['items'] = items;

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>pelanggan_area/bom/simpan_bom',
            data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
            cache: false,
            dataType: "json",
            success: function(data) {
                //hide loading animation...
                preloader('hide');

                if (data.sts == 1) {
                    //load data..
                    var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                    toastrAlert(response);
                } else if (data.sts == 'tidak_berhak_ubah_data') {
                    var response = JSON.parse('<?php echo alert('tidak_berhak_ubah_data'); ?>');
                    swalAlert(response);
                } else {
                    var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                    swalAlert(response);
                }
            }

        });
    }

    function verifikasi_file_bom(verifikasi, i) {
        if (verifikasi == 'setuju') {
            var pertanyaan = "Apakah Anda yakin ingin <strong>menyetujui</strong> uraian <strong>" + bom[i].uraian + "</strong>?";

            konfirmasi(pertanyaan, function() {
                proses_verifikasi_bom(bom[i].id_bom, verifikasi);
            });
        } else {
            $("#folder_bom_modal").modal('hide');
            swal.fire({
                title: 'Tolak Dokumen',
                html: 'Apakah Anda yakin ingin <Strong>menolak</strong> uraian  <strong>' + bom[i].uraian + '</strong>?',
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
                    } else {
                        $("#folder_bom_modal").modal('show');
                    }
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    $("#tolak").attr({
                        "data-kt-indicator": "on",
                        'disabled': true
                    });

                    proses_verifikasi_bom(bom[i].id_bom, verifikasi, result.value);
                }
            });
        }
    }

    function proses_verifikasi_bom(id_bom, verifikasi, keterangan) {
        //show loading animation...
        preloader('show');

        var data = new Object;
        data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
        data['id_bom'] = id_bom;
        data['status'] = verifikasi;
        data['alasan_verifikasi'] = keterangan;

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>pelanggan_area/bom/verifikasi_dokumen',
            data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
            cache: false,
            dataType: "json",
            success: function(data) {
                preloader('hide');

                if (verifikasi == 'tolak') {
                    $("#folder_bom_modal").modal('show');
                }

                if (data.sts == 1) {
                    //load data..
                    var id_collecting_dokumen = $("#bom-id_collecting_dokumen").val();
                    load_bom(id_collecting_dokumen);
                    var response = JSON.parse('<?php echo alert('verifikasi_berhasil'); ?>');
                    toastrAlert(response);
                } else if (data.sts == 'tidak_berhak_akses_data') {
                    var response = JSON.parse('<?php echo alert('tidak_berhak_akses_data'); ?>');
                    swalAlert(response);

                } else {
                    var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                    swalAlert(response);
                }
            }

        });
    }
</script>