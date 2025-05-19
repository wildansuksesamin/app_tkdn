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
                                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"><?php _lang('Hak akses menu'); ?></h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                        </div>
                    </div>

                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <div id="kt_app_content_container" class="app-container container-fluid">
                            <div class="card card-flush mb-10">
                                <div class="card-header pt-7">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2><?php _lang('Form hak akses menu'); ?></h2>
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
                                            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="post" id="input_form_jns_admin" action="<?php echo base_url(); ?>jns_admin/simpan" autocomplete="off">
                                                <input type="hidden" class="form-control" id="id_jns_admin" name="id_jns_admin" maxlength="11" placeholder="">

                                                <div class="row mb-5">
                                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                        <label class="required fs-5 fw-semibold mb-2 required"><?php _lang('Tipe Administrator'); ?></label>
                                                        <select class="form-select form-select-solid" data-control="select2" id="tipe_admin" name="tipe_admin">
                                                            <option selected disabled>Pilih tipe admin</option>
                                                            <?php
                                                            $jns_admin = $konten['jns_admin'];
                                                            if($jns_admin->num_rows() > 0){
                                                                foreach($jns_admin->result() as $data_jns_admin){
                                                                    echo '<option value="'.$data_jns_admin->id_jns_admin.'">'.$data_jns_admin->jns_admin.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="separator mb-10 mt-10"></div>
                                                <button type="button" class="btn btn-primary" id="simpan">
                                                    <i class="fa-solid fa-floppy-disk me-2 fs-3"></i>
                                                    <?php _lang('simpan'); ?>
                                                </button>

                                                <input type="hidden" id="action" name="action" value="save">
                                                <input type="hidden" id="index" name="index" value="0">
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

                            <div class="card card-flush h-lg-100 hidden" id="menu_box">

                                <!--begin::Body-->
                                <div class="card-body p-lg-17">
                                    <!--begin::Layout-->
                                    <div class="d-flex flex-column flex-lg-row">
                                        <!--begin::Content-->
                                        <div class="flex-lg-row-fluid me-0">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-striped gy-5" id="data_menu">
                                                    <thead>
                                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                        <th>#</th>
                                                        <th><?php _lang('Menu'); ?></th>
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
    $("#simpan").click(function(){

        var id_jns_admin = $("#tipe_admin").val();
        var rangkai = '';
        var datajson = [];
        var jml_menu = $("#index").val();

        for(var i=0; i<jml_menu; i++){
            if($("#cb"+i).is(':checked')){
                var id_menu = $("#cb"+i).val();
                datajson.push({'id_menu': id_menu});
            }
        }

        var data = new Object;
        data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
        data['id_jns_admin'] = id_jns_admin;
        data['datajson'] = datajson;

        //show loading animation...
        var blockUI = generate_blockUI("#kt_app_body");
        blockUI.block();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>hak_akses_menu/simpan',
            cache: false,
            data: 'data_send='+encodeURIComponent(JSON.stringify(data)),
            dataType: "json",
            success: function(data){
                //hide loading animation...
                blockUI.release(); blockUI.destroy();

                if(data.sts == 1){
                    //hapus seluruh field...
                    $("#tipe_admin").val('');

                    //reset tabel
                    $("#data_menu tbody").html('');

                    var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                    toastrAlert(response);

                    $("#simpan").hide();
                    $("#menu_box").hide();
                }
                else{
                    var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                    swalAlert(response);
                }
            }
        });
    });

    $("#tipe_admin").change(function(){
        var id_jns_admin = $(this).val();
        if(id_jns_admin != '')
            load_data(id_jns_admin);
    });
    function load_data(id_jns_admin){
        $("#menu_box").show();
        $("#simpan").hide();
        var data = new Object;
        data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
        data['id_jns_admin'] = id_jns_admin;

        var blockUI = generate_blockUI("#kt_app_body");
        blockUI.block();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>hak_akses_menu/load_akses_menu',
            data: 'data_send='+encodeURIComponent(JSON.stringify(data)),
            cache: false,
            dataType: "json",
            success: function(data){
                blockUI.release(); blockUI.destroy();

                var rangkai = '';
                var index = 0;
                if(data.length > 0){
                    for(var i=0; i < data.length; i++){
                        rangkai += '<tr>' +
                            '<td>' +
                                '<div class="form-check form-check-custom form-check-solid">' +
                                    '<input class="form-check-input" id="cb'+index+'" type="checkbox" value="'+data[i].id_menu+'" '+data[i].checked+' />' +
                                '</div>' +
                            '</td>' +
                            '<td>'+data[i].nama_menu+'</td>' +
                            '</tr>';

                        index = parseInt($("#index").val()) + 1;
                        $("#index").val(index);

                        //check child..
                        var submenu = safelyParseJSON(JSON.stringify(data[i].sub_menu));
                        if(submenu.length > 0){
                            for(var j=0; j< submenu.length; j++){
                                var readonly = '';
                                if(id_jns_admin == 1 && submenu[j].id_menu == '50.2'){
                                    submenu[j].checked = 'checked';
                                    readonly = 'disabled';
                                }
                                rangkai += '<tr>' +
                                    '<td>' +
                                        '<div class="form-check form-check-custom form-check-solid">' +
                                            '<input class="form-check-input" id="cb'+index+'" type="checkbox" value="'+submenu[j].id_menu+'" '+submenu[j].checked+' '+readonly+' />' +
                                        '</div>' +
                                    '</td>' +
                                    '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+submenu[j].nama_menu+'</td>' +
                                    '</tr>';
                                index = parseInt($("#index").val()) + 1;
                                $("#index").val(index);
                            }
                        }
                    }

                    console.log(index);
                    $("#index").val(index);
                }

                $("#simpan").fadeIn(200);

                $("#data_menu tbody").html(rangkai);


            }

        });
    }
</script>
</body>
<!-- end::Body -->
</html>
