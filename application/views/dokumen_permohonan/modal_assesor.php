<div class="modal fade" id="modal_assesor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal_assesor-nama_perusahaan">
                </h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </div>
            </div>
            <div class="modal-body">
                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_assesor" action="<?php echo base_url(); ?>dokumen_permohonan_pic/simpan" autocomplete="off">
                    <div class="row mb-5">
                        <div class="fv-row fv-plugins-icon-container">
                            <label class="required fs-5 fw-semibold mb-2">Verifikator</label>
                            <div class="row">
                                <div class="col-sm-8">
                                    <select class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#modal_assesor" data-placeholder="Pilih data" id="id_admin" name="id_admin" required>
                                        <?php
                                        if ($konten['assesor']->num_rows() > 0) {
                                            foreach ($konten['assesor']->result() as $list) {
                                                echo '<option value="' . $list->id_admin . '">' . $list->nama_admin . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <input type="hidden" name="token" value="<?php echo genToken('SEND_DATA'); ?>">
                                    <input type="hidden" id="modal_assesor-id_dokumen_permohonan" name="id_dokumen_permohonan">
                                    <button type="submit" id="modal_assesor-simpan" class="btn btn-primary">
                                        <span class="indicator-label"><i class="fa-solid fa-floppy-disk me-2 fs-3"></i> Simpan</span>
                                        <span class="indicator-progress">Loading...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="data_zona_assesor_modal" class="table-responsive">
                    <table id="modal_assesor-list_assesor" class="table table-sm table-striped gy-5">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama Verifikator</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function tambah_assesor(id_dokumen_permohonan, nama_perusahaan) {
        $("#id_admin").val('').trigger('change');
        $("#modal_assesor-id_dokumen_permohonan").val(id_dokumen_permohonan);
        $("#modal_assesor-nama_perusahaan").html(nama_perusahaan);
        load_data_assesor(id_dokumen_permohonan);
    }

    function load_data_assesor(id_dokumen_permohonan) {
        preloader('show');
        $("#data_zona_assesor_modal").show();
        $("#empty_state").remove();

        var data = new Object;
        data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
        data['id_dokumen_permohonan'] = id_dokumen_permohonan;
        data['id_jns_admin'] = 3; //ini adalah ID untuk assesor
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>dokumen_permohonan_pic/load_data',
            data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
            cache: false,
            dataType: "json",
            success: function(result) {
                var list = result.result;

                preloader('hide');
                if (list.length > 0) {
                    var rangkai = '';
                    for (var i = 0; i < list.length; i++) {
                        rangkai += '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + list[i].nama_admin + '</td>' +
                            '<td>' +
                            '<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-danger" onClick="hapus_assesor(' + list[i].id_pic + ', \'' + list[i].nama_admin + '\')" title="Hapus assesor bertugas"><span class="svg-icon svg-icon-muted svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"/><path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"/><path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"/></svg></span></button>' +
                            '</td>' +
                            '</tr>';
                    }
                    $("#modal_assesor-list_assesor tbody").html(rangkai);
                } else {
                    create_empty_state("#data_zona_assesor_modal");
                }

                $("#modal_assesor").modal('show');
            }
        })
    }

    function hapus_assesor(id_pic, nama_assesor) {
        var pertanyaan = "Apakah Anda yakin ingin menghapus <b>" + nama_assesor + "</b> dari assesor di perusahaan ini?";

        konfirmasi(pertanyaan, function() {
            proses_hapus_assesor(id_pic);
        });
    }

    function proses_hapus_assesor(id_pic) {
        var id_dokumen_permohonan = $("#modal_assesor-id_dokumen_permohonan").val();
        //show loading animation...
        preloader('show');

        var data = new Object;
        data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
        data['id_pic'] = id_pic;
        data['id_dokumen_permohonan'] = id_dokumen_permohonan;

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>dokumen_permohonan_pic/hapus',
            data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
            cache: false,
            dataType: "json",
            success: function(data) {
                //hide loading animation...
                preloader('hide');

                if (data.sts == 1) {
                    //load data..
                    load_data();
                    load_data_assesor(id_dokumen_permohonan);

                    var response = JSON.parse('<?php echo alert('hapus_berhasil'); ?>');
                    toastrAlert(response);
                } else {
                    var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                    swalAlert(response);
                }
            }

        });
    }
    $("#input_form_assesor").on('submit', function(e) {
        e.preventDefault();

        var id_dokumen_permohonan = $("#modal_assesor-id_dokumen_permohonan").val();
        var id_admin = $("#id_admin").val();

        if (!id_dokumen_permohonan || !id_admin) {
            var response = JSON.parse('<?php echo alert('kosong'); ?>');
            swalAlert(response);
        } else {
            $("#modal_assesor-simpan").attr({
                "data-kt-indicator": "on",
                'disabled': true
            });
            jQuery(this).ajaxSubmit({
                dataType: 'json',
                success: function(data) {
                    $("#modal_assesor-simpan").removeAttr('disabled data-kt-indicator');

                    if (data.sts == 1) {
                        load_data();
                        load_data_assesor(id_dokumen_permohonan);
                        $("#id_admin").val('').trigger('change');

                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        toastrAlert(response);
                    } else if (data.sts == 'data_available') {
                        var response = JSON.parse('<?php echo alert('data_available'); ?>');
                        swalAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }
            });
        }
    });
</script>