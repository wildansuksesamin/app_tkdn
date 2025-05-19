<div class="modal" id="folder_bom_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xxl" role="document">
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
                                <th style="width: 15%;">File</th>
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
<div class="modal fade" id="upload_file_bom_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <h2 id="upload_file_bom-judul" style="text-transform: capitalize;"></h2>
                </div>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <span class="fw-semibold text-gray-400 d-block fs-8">Uraian</span>
                        <div id="upload_file_bom-uraian" class="fw-bold text-gray-800 text-hover-primary"></div>
                    </div>
                    <div class="col-sm-6">
                        <span class="fw-semibold text-gray-400 d-block fs-8">Spesifikasi</span>
                        <div id="upload_file_bom-spesifikasi" class="fw-bold text-gray-800 text-hover-primary"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <span class="fw-semibold text-gray-400 d-block fs-8">Satuan Bahan Baku</span>
                        <div id="upload_file_bom-satuan_bahan_baku" class="fw-bold text-gray-800 text-hover-primary"></div>
                    </div>
                    <div class="col-sm-6">
                        <span class="fw-semibold text-gray-400 d-block fs-8">Negara Asal</span>
                        <div id="upload_file_bom-negara_asal" class="fw-bold text-gray-800 text-hover-primary"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <span class="fw-semibold text-gray-400 d-block fs-8">Vendor / Supplier</span>
                        <div id="upload_file_bom-vendor_suplier" class="fw-bold text-gray-800 text-hover-primary"></div>
                    </div>
                    <div class="col-sm-6">
                        <span class="fw-semibold text-gray-400 d-block fs-8">Jumlah Pemakaian Untuk 1 (satu) Satuan Produk</span>
                        <div id="upload_file_bom-jml_pemakaian_satuan_produk" class="fw-bold text-gray-800 text-hover-primary"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <span class="fw-semibold text-gray-400 d-block fs-8">Harga Satuan (Rupiah)</span>
                        <div id="upload_file_bom-harga_satuan" class="fw-bold text-gray-800 text-hover-primary"></div>
                    </div>
                </div>

                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_upload_file_bom" action="<?php echo base_url(); ?>pelanggan_area/bom/simpan_file" autocomplete="off">
                    <div class="separator mb-10 mt-10"></div>
                    <input type="hidden" id="upload_file_bom-id_bom" name="id_bom" value="">
                    <input type="hidden" id="upload_file_bom-field" name="field" value="">
                    <input type="hidden" id="upload_file_bom-token" name="token" value="<?php echo genToken('SEND_DATA'); ?>">
                    <div class="fv-row fv-plugins-icon-container">
                        <label class="required fs-5 fw-semibold mb-2">File</label>
                        <input type="file" class="form-control form-control-solid" autocomplete="off" id="upload_file_bom-file_bom" name="file_bom" required accept=".pdf, .jpg, .jpeg">
                    </div>
                    <div class="separator mb-10 mt-10"></div>
                    <button type="submit" id="upload_file_bom-simpan" class="btn btn-primary">
                        <!--begin::Indicator label-->
                        <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                        <span class="indicator-progress">Tunggu Sebentar...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>

                </form>
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
                console.log(kolom_tambahan);
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
                        var input_file = '';
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
                            badge_status = '<div class="separator mb-3  mt-3"></div><div class="mt-2 mb-3">' + badge_status + '</div>';

                            var invoice = '';
                            if (bom[i].invoice) {
                                var ext = bom[i].invoice.slice((bom[i].invoice.lastIndexOf('.') - 1 >>> 0) + 2);
                                //jika sudah ada filenya...
                                invoice = '<div class="mb-3 row">' +
                                    '<div class="col-9"><a href="' + base_url + bom[i].invoice + '" class="btn btn-sm btn-block btn-light-primary" download="invoice_' + bom[i].uraian + '.' + ext + '">Download File</a></div>' +
                                    '<div class="col-3"><a href="javascript:;" class="btn btn-sm btn-icon btn-light-danger" onclick="hapus_file_bom(' + i + ', \'invoice\')"><i class="fa fa-trash"></i></a></div>' +
                                    '</div>';
                            } else {
                                //jika belum ada filenya...
                                invoice = '<div class="mb-3"><button class="btn btn-sm btn-block btn-primary" onclick="upload_file_bom(' + i + ', \'invoice\')"><i class="fa fa-upload"></i> Upload File</button></div>';
                            }
                            var faktur_pajak = '';
                            if (bom[i].faktur_pajak) {
                                //jika sudah ada filenya...
                                var ext = bom[i].faktur_pajak.slice((bom[i].faktur_pajak.lastIndexOf('.') - 1 >>> 0) + 2);
                                //jika sudah ada filenya...
                                faktur_pajak = '<div class="mb-3 row">' +
                                    '<div class="col-9"><a href="' + base_url + bom[i].faktur_pajak + '" class="btn btn-sm btn-block btn-light-primary" download="faktur_pajak_' + bom[i].uraian + '.' + ext + '">Download File</a></div>' +
                                    '<div class="col-3"><a href="javascript:;" class="btn btn-sm btn-icon btn-light-danger" onclick="hapus_file_bom(' + i + ', \'faktur_pajak\')"><i class="fa fa-trash"></i></a></div>' +
                                    '</div>';
                            } else {
                                //jika belum ada filenya...
                                faktur_pajak = '<div class="mb-3"><button class="btn btn-sm btn-block btn-primary" onclick="upload_file_bom(' + i + ', \'faktur_pajak\')"><i class="fa fa-upload"></i> Upload File</button></div>';
                            }
                            input_file = '<div>' +
                                '<label class="fw-bold">Invoice</label>' + invoice +
                                '<label class="fw-bold">Faktur Pajak</label>' + faktur_pajak +
                                '<input type="hidden" name="id_bom[]" value="' + bom[i].id_bom + '">' +
                                '</div>';
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
                                '<td>' + input_file + badge_status + alasan_tolak + '<div class="separator mb-3  mt-3"></div><a href="javascript:;" class="btn btn-sm btn-block btn-light-danger mb-2" onclick="hapus_baris(this, ' + i + ')"><i class="fa fa-times"></i> Hapus Baris Ini</a><a href="javascript:;" class="btn btn-sm btn-block btn-light-primary mb-2" onclick="tambah_baris(this)"><i class="fa fa-plus"></i> Tambah Baris Baru</a></td>' +
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

    function tambah_baris(button) {
        var row = $(button).closest("tr");
        rangkai = '<tr>' +
            '<td class="nomor"></td>' +
            '<td>' +
            '<div><input type="text" name="uraian[]" data-name="uraian" class="form-control form-control-solid" autocomplete="off"/></div>' +
            '<input type="hidden" name="id_bom[]" data-name="id_bom" />' +
            '</td>' +
            '<td><textarea name="spesifikasi[]" data-name="spesifikasi" class="form-control form-control-solid" autocomplete="off"></textarea></td>' +
            '<td><input type="text" name="satuan_bahan_baku[]"  data-name="satuan_bahan_baku" class="form-control form-control-solid" autocomplete="off" /></td>' +
            '<td><input type="text" name="negara_asal[]"  data-name="negara_asal" class="form-control form-control-solid" autocomplete="off" /></td>' +
            '<td><input type="text" name="vendor_suplier[]"  data-name="vendor_suplier" class="form-control form-control-solid" autocomplete="off" /></td>' +
            '<td><input type="text" name="jml_pemakaian_satuan_produk[]"  data-name="jml_pemakaian_satuan_produk" class="form-control form-control-solid" autocomplete="off" onkeyup="calculator();" /></td>' +
            '<td><input type="text" name="harga_satuan[]"  data-name="harga_satuan" class="form-control form-control-solid" autocomplete="off" onkeyup="convertToRupiah(this); calculator();" style="text-align: right;"/></td>' +
            '<td><div class="separator mb-3  mt-3"></div><a href="javascript:;" class="btn btn-sm btn-block btn-light-danger mb-2" onclick="hapus_baris(this)"><i class="fa fa-times"></i> Hapus Baris Ini</a><a href="javascript:;" class="btn btn-sm btn-block btn-light-primary mb-2" onclick="tambah_baris(this)"><i class="fa fa-plus"></i> Tambah Baris Baru</a></td>' +
            '</tr>';

        var tambahan = $(rangkai);
        row.after(tambahan);
        penomoran();
    }

    function hapus_baris(button, i) {
        if (i) {
            var uraian = bom[i].uraian;
        } else {
            var uraian = 'ini';
        }
        var pertanyaan = "Apakah Anda yakin ingin menghapus item " + uraian + "?";

        konfirmasi(pertanyaan, function() {
            var row = $(button).closest("tr");
            row.remove();
            penomoran();
            calculator();

            //proses hapus data di server...
            preloader('show');
            var id_collecting_dokumen = $("#bom-id_collecting_dokumen").val();

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_bom'] = bom[i].id_bom;
            data['id_collecting_dokumen'] = id_collecting_dokumen;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>pelanggan_area/bom/hapus_item_bom',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    //hide loading animation...
                    preloader('hide');

                    if (data.sts == 1) {
                        //load data..
                        var response = JSON.parse('<?php echo alert('hapus_berhasil'); ?>');
                        toastrAlert(response);
                    } else if (data.sts == 'tidak_berhak_hapus_data') {
                        var response = JSON.parse('<?php echo alert('tidak_berhak_hapus_data'); ?>');
                        swalAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }

            });
        });
    }

    function penomoran() {
        var nomor = 1;
        $('.nomor').each(function() {
            $(this).text(nomor);
            nomor++;
        });

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
                    var response = JSON.parse('<?php echo alert('hapus_berhasil'); ?>');
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

    function upload_file_bom(i, field) {
        var id_collecting_dokumen = $("#bom-id_collecting_dokumen").val();
        var judul = field.replace(/_/g, ' ');

        $("#upload_file_bom-id_bom").val(bom[i].id_bom);
        $("#upload_file_bom-field").val(field);
        $("#upload_file_bom-file_bom").val('');

        $("#upload_file_bom-judul").html(judul);
        $("#upload_file_bom-uraian").html(bom[i].uraian);
        $("#upload_file_bom-spesifikasi").html(coverMe(bom[i].spesifikasi));
        $("#upload_file_bom-satuan_bahan_baku").html(coverMe(bom[i].satuan_bahan_baku));
        $("#upload_file_bom-negara_asal").html(coverMe(bom[i].negara_asal));
        $("#upload_file_bom-vendor_suplier").html(coverMe(bom[i].vendor_suplier));
        $("#upload_file_bom-jml_pemakaian_satuan_produk").html(coverMe(bom[i].jml_pemakaian_satuan_produk));
        $("#upload_file_bom-harga_satuan").html(rupiah(coverMe(bom[i].harga_satuan, 0)));

        yakin_tutup = true;
        $("#folder_bom_modal").modal('hide');
        $("#upload_file_bom_modal").modal('show');
    }

    $('#upload_file_bom_modal').on('hidden.bs.modal', function() {
        var id_collecting_dokumen = $("#bom-id_collecting_dokumen").val();
        load_bom(id_collecting_dokumen);
        $("#folder_bom_modal").modal('show');
    });
    $("#input_form_upload_file_bom").on('submit', function(e) {
        e.preventDefault();

        var id_bom = $("#upload_file_bom-id_bom").val();
        var field = $("#upload_file_bom-field").val();
        var file_bom = $("#upload_file_bom-file_bom").val();

        if (id_bom == '' || field == '' || file_bom == '') {
            var response = JSON.parse('<?php echo alert('kosong'); ?>');
            swalAlert(response);
        } else {
            $("#upload_file_bom-simpan").attr({
                "data-kt-indicator": "on",
                'disabled': true
            });

            jQuery(this).ajaxSubmit({
                dataType: 'json',
                success: function(data) {
                    $("#upload_file_bom-simpan").removeAttr('disabled data-kt-indicator');

                    if (data.sts == 1) {
                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        toastrAlert(response);
                        $("#upload_file_bom_modal").modal('hide');
                    } else if (data.sts == 'tidak_berhak_ubah_data') {
                        var response = JSON.parse('<?php echo alert('tidak_berhak_ubah_data'); ?>');
                        swalAlert(response);
                    } else if (data.sts == 'upload_error') {
                        var response = JSON.parse('<?php echo alert('upload_error'); ?>');
                        response.message = response.message.replace('{{upload_error_msg}}', data.error_msg);
                        swalAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }

                }
            });
        }

    });

    function hapus_file_bom(i, field) {
        var pertanyaan = "Apakah Anda yakin ingin menghapus file " + field + " dari " + bom[i].uraian + "?";

        konfirmasi(pertanyaan, function() {
            proses_hapus_file_bom(bom[i].id_bom, field);
        });
    }

    function proses_hapus_file_bom(id_bom, field) {
        //show loading animation...
        preloader('show');

        var data = new Object;
        data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
        data['id_bom'] = id_bom;
        data['field'] = field;

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>pelanggan_area/bom/hapus_file',
            data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
            cache: false,
            dataType: "json",
            success: function(data) {
                //hide loading animation...
                preloader('hide');

                if (data.sts == 1) {
                    //load data..
                    var id_collecting_dokumen = $("#bom-id_collecting_dokumen").val();
                    load_bom(id_collecting_dokumen);
                    var response = JSON.parse('<?php echo alert('hapus_berhasil'); ?>');
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
</script>