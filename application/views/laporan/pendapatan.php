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
                                    Laporan Pendapatan
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <div class="d-flex align-items-center gap-2 gap-lg-3">
                                <button type="button" class="btn btn-sm fw-bold btn-primary tabel_zone" onclick="form_action('show')">
                                    <i class="fa fa-filter fs-1 me-2"></i>
                                    Filter Laporan
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <div id="kt_app_content_container" class="app-container container-fluid">
                            <div class="card card-flush form_zone hidden" id="form_payment_detail">
                                <div class="card-header pt-7">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>
                                            Filter Laporan
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
                                            <!--begin::Form-->
                                            
                                                <input type="hidden" class="form-control" id="id_payment_detail" name="id_payment_detail" maxlength="11" placeholder="">
							
                                                
							                    <div class="row mb-5">
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2">Tanggal Awal</label>
                                                        <div class="input-group input-group-solid mb-5">
                                                            <span class="input-group-text" id="basic-addon2"><?php echo getSvgIcon('general/gen014', 'svg-icon svg-icon-2') ?></span>
                                                            <input type="text" id="tgl_awal" name="tgl_awal" class="form-control monthpicker" autocomplete="off" required/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2">Tanggal Akhir</label>
                                                        <div class="input-group input-group-solid mb-5">
                                                            <span class="input-group-text" id="basic-addon2"><?php echo getSvgIcon('general/gen014', 'svg-icon svg-icon-2') ?></span>
                                                            <input type="text" id="tgl_akhir" name="tgl_akhir" class="form-control monthpicker" autocomplete="off" required/>
                                                        </div>
                                                    </div>
                                                </div>
							                    <div class="row mb-5">
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="fs-5 fw-semibold mb-2">Kode Sub Unit</label>
                                                        <select id="kode_jasa" name="kode_jasa" class="form-select form-select-solid" data-control="select2">
                                                            <option value="">Semuanya</option>
                                                            <option value="014">014</option>
                                                            <option value="021">021</option>
                                                        </select>
                                                    </div>
                                                </div>
							                    <div class="row mb-5">
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="fs-5 fw-semibold mb-2">Jenis Permohonan</label>
                                                        <select id="jenis_permohonan" name="jenis_permohonan" class="form-select form-select-solid" data-control="select2">
                                                            <option value="">Semuanya</option>
                                                            <option value="PELAKU USAHA">Berbayar Pelaku Usaha</option>
                                                            <option value="PEMERINTAH">Berbayar Pemerintah</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="separator mb-10 mt-10"></div>
                                                <button type="button" id="tampilkan" class="btn btn-primary">
                                                    <span class="indicator-label"><i class="fa-solid fa-eye me-2 fs-3"></i> Tampilkan</span>
                                                    <span class="indicator-progress">Loading...
										            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>

                                                <button class="btn btn-light btn-active-light-primary me-2" type="button" onclick="form_action('hide')">
                                                    <i class="fa-solid fa-times me-2 fs-3"></i>
                                                    Batal
                                                </button>
                                        </div>
                                        <!--end::Content-->

                                    </div>
                                    <!--end::Layout-->
                                </div>
                                <!--end::Body-->
                            </div>

                            <div class="card card-flush h-lg-100 tabel_zone" id="tabel_payment_detail">
                                <div class="card-header">
                                    <div class="card-title"></div>
                                    
                                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                        <!--begin::Export dropdown-->
                                        <button type="button" class="btn btn-sm fw-bold btn-light-info" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <?php echo getSvgIcon('files/fil021', 'svg-icon svg-icon-1 ms-4'); ?>
                                            Export Laporan
                                        </button>
                                        <!--begin::Menu-->
                                        <div id="kt_datatable_example_export_menu" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" onclick="exportTable('excel')">
                                                <img src="<?php echo base_url(); ?>assets/images/files/xls.png" class="me-3" style="width: 20px;"> Export as Excel
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" onclick="exportTable('pdf')">
                                                <img src="<?php echo base_url(); ?>assets/images/files/pdf.png" class="me-3" style="width: 20px;"> Export as Pdf
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                        <!--end::Export dropdown-->

                                        <!--begin::Hide default export buttons-->
                                        <div id="kt_datatable_example_buttons" class="d-none"></div>
                                        <!--end::Hide default export buttons-->
                                    </div>

                                </div>
                                <!--begin::Body-->
                                <div class="card-body p-lg-17" style="padding-top: unset!important;">
                                    <!--begin::Layout-->
                                    <div id="data_zona_payment_detail">
                                        <div class="d-flex flex-column flex-lg-row">
                                            <!--begin::Content-->
                                            <div class="flex-lg-row-fluid me-0">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-striped gy-5" id="data_payment_detail">
                                                        <thead>
                                                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                            <th style="width: 7%;">No.</th>
                                                            <th style="width: 20%;">Tgl Nomor Order</th>
                                                            <th style="width: 42%;">Pelanggan</th>
                                                            <th style="width: 10%;">Kode</th>
                                                            <th style="width: 20%;">Pendapatan</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!--end::Content-->

                                        </div>
                                        <!--end::Layout-->
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
    function exportTable(type, element){
        var token = '<?php echo genToken('LOAD_DATA'); ?>';
        var tgl_awal = $("#tgl_awal").val();
        var tgl_akhir = $("#tgl_akhir").val();
        var kode_jasa = $("#kode_jasa").val();
        var jenis_permohonan = $("#jenis_permohonan").val();

        if(!tgl_awal || !tgl_akhir){
            var response = JSON.parse('<?php echo alert('kosong'); ?>');
            swalAlert(response);
        }
        else{
            window.open(base_url+'laporan/Payment_detail/download_file/?token='+token+'&type='+type+'&tgl_awal='+tgl_awal+'&tgl_akhir='+tgl_akhir+'&kode_jasa='+kode_jasa+'&jenis_permohonan='+jenis_permohonan, '_blank');
        }

    }
    
    function form_action(action){
        if(action == 'show'){
            $(".form_zone").fadeIn(300);
            $(".tabel_zone").hide();
        }
        else{
            $(".form_zone").hide();
            $(".tabel_zone").fadeIn(300);
        }
    }
    form_action('show');

    $("#tampilkan").click(function(){
        var tgl_awal = $("#tgl_awal").val();
        var tgl_akhir = $("#tgl_akhir").val();
        var kode_jasa = $("#kode_jasa").val();
        var jenis_permohonan = $("#jenis_permohonan").val();

        if(!tgl_awal || !tgl_akhir){
            var response = JSON.parse('<?php echo alert('kosong'); ?>');
            swalAlert(response);
        }
        else{
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['tgl_awal'] = tgl_awal;
            data['tgl_akhir'] = tgl_akhir;
            data['kode_jasa'] = kode_jasa;
            data['jenis_permohonan'] = jenis_permohonan;
            load_data(data);
        }
    })
    
    var ajax_request;
    function load_data(data){
        $("#tampilkan").attr({"data-kt-indicator": "on", 'disabled': true});
        
        ajax_request = $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>laporan/Payment_detail/ajax_request',
            data: 'data_send='+encodeURIComponent(JSON.stringify(data)),
            cache: false,
            dataType: "json",
            success: function(result){
                $("#tampilkan").removeAttr('disabled data-kt-indicator');
                form_action('hide');
                list_data = result;
                
                var rangkai = '';
                if(list_data.length > 0){
                    
                    var grand_total = 0;
                    var total_pendapatan = 0;
                    var bulan_ini = '';
                    for(var i=0; i < list_data.length; i++){
                        var pendapatan = (list_data[i].termin_1 / 100) * list_data[i].nilai_kontrak;

                        if(bulan_ini != reformatDate(list_data[i].tgl_nomor_order, 'MMMM YYYY')){
                            bulan_ini = reformatDate(list_data[i].tgl_nomor_order, 'MMMM YYYY');
                            if(i != 0){
                                rangkai += '<tr class="fw-bold" style="text-align: right">' +
                                    '<td colspan="4">TOTAL '+bulan_ini.toUpperCase()+'</td>' +
                                    '<td>Rp '+rupiah(total_pendapatan)+'</td>' +
                                '</tr>';
                                total_pendapatan = 0;
                            }
                        }
                        total_pendapatan += pendapatan;
                        grand_total += pendapatan;

                        rangkai += '<tr>' +
                                        '<td>'+(i+1)+'.</td>' +
                                        '<td>'+reformatDate(list_data[i].tgl_nomor_order, 'DD MMMM YYYY')+'</td>' +
                                        '<td>'+list_data[i].nama_badan_usaha+' '+list_data[i].nama_perusahaan+'</td>' +
                                        '<td>'+list_data[i].kode_jasa+'</td>' +
                                        '<td style="text-align: right">Rp '+rupiah(pendapatan)+'</td>' +
                                    '</tr>';
                    }
                    rangkai += '<tr class="fw-bold" style="text-align: right">' +
                        '<td colspan="4">TOTAL '+bulan_ini.toUpperCase()+'</td>' +
                        '<td>Rp '+rupiah(total_pendapatan)+'</td>' +
                    '</tr>';
                    rangkai += '<tr class="fw-bold" style="text-align: right">' +
                        '<td colspan="4">GRAND TOTAL</td>' +
                        '<td>Rp '+rupiah(grand_total)+'</td>' +
                    '</tr>';
                }

                if(rangkai){
                    $("#empty_state").remove();
                    $("#data_zona_payment_detail").show();

                    $("#data_payment_detail tbody").html(rangkai);
                }
                else{
                    create_empty_state("#data_zona_payment_detail");
                }

            }

        });
    }
    
</script>
</body>
<!-- end::Body -->
</html>
