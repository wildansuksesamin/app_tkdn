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
            <?php $this->view((isset($konten['include_path']) ? $konten['include_path'] : '') . 'include/top_navbar'); ?>
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <?php $this->view((isset($konten['include_path']) ? $konten['include_path'] : '') . 'include/left_side_navbar'); ?>
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
                                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Ruang Negosiasi</h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                            </div>
                        </div>

                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-xxl">
                                <!--begin::Layout-->
                                <div class="d-flex flex-column flex-lg-row">
                                    <!--begin::Sidebar-->
                                    <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
                                        <!--begin::Contacts-->
                                        <div class="card card-flush">
                                            <!--begin::Card header-->
                                            <div class="card-header pt-7" id="kt_chat_contacts_header">
                                                <!--begin::Form-->
                                                <form class="w-100 position-relative" autocomplete="off">
                                                    <!--begin::Icon-->
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                    <?php echo getSvgIcon('general/gen021', 'svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y'); ?>
                                                    <!--end::Svg Icon-->
                                                    <!--end::Icon-->
                                                    <!--begin::Input-->
                                                    <input type="text" class="form-control form-control-solid px-15" name="filter" id="filter" value="" placeholder="Cari berdasarkan nama Verifikator...">
                                                    <!--end::Input-->
                                                </form>
                                                <!--end::Form-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-5" id="kt_chat_contacts_body" style="min-height: 300px;">
                                                <!--begin::List-->
                                                <div id="teman_bicara" class="scroll-y me-n5 pe-5 h-200px h-lg-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_toolbar, #kt_app_toolbar, #kt_footer, #kt_app_footer, #kt_chat_contacts_header" data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_contacts_body" data-kt-scroll-offset="5px" style="max-height: 40px;">

                                                </div>
                                                <!--end::List-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Contacts-->
                                    </div>
                                    <!--end::Sidebar-->
                                    <!--begin::Content-->
                                    <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
                                        <div class="card" id="kt_chat_welcome">
                                            <div class="card-body" style="height: 400px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
                                                <div class="text-center">
                                                    <img src="<?php echo base_url(); ?>assets/media/illustrations/sigma-1/16.png" style="height: 200px;">
                                                    <div class="fs-4 fw-semibold">Ruang Negosiasi</div>
                                                    <div class="mt-3">Silahkan bernegosiasi dengan Verifikator Anda melalui halaman ini. Negosisasi hanya dapat dimulai jika Surat Penawaran telah terbit.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--begin::Messenger-->
                                        <div class="card" id="kt_chat_messenger">
                                            <!--begin::Card header-->
                                            <div class="card-header" id="kt_chat_messenger_header">
                                                <!--begin::Title-->
                                                <div class="card-title">
                                                    <!--begin::User-->
                                                    <div class="d-flex justify-content-center flex-column me-3">
                                                        <a href="javascript:;" id="nama_teman_bicara" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1"></a>

                                                        <!--begin::Info-->
                                                        <div class="mb-0 lh-1">
                                                            <span class="fs-7 fw-semibold text-muted" id="sub_teman_bicara"></span>
                                                        </div>
                                                        <!--end::Info-->
                                                    </div>
                                                    <!--end::User-->
                                                </div>
                                                <div class="card-toolbar">
                                                    <!--begin::Menu-->
                                                    <div class="me-n3">
                                                        <button class="btn btn-sm btn-icon btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                            <i class="bi bi-three-dots fs-2"></i>
                                                        </button>
                                                        <!--begin::Menu 3-->
                                                        <?php
                                                        if ($this->session->userdata('login_as') == 'administrator') {
                                                        ?>
                                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                                                <div class="menu-item px-3">
                                                                    <a href="javascript:;" onclick="lihat_rab()" class="menu-link px-3">Lihat RAB</a>
                                                                </div>
                                                                <div class="menu-item px-3">
                                                                    <a href="javascript:;" onclick="lihat_surat_penawaran('<?php echo $this->session->userdata('login_as'); ?>')" class="menu-link px-3">Lihat Surat Penawaran</a>
                                                                </div>
                                                                <div class="dropdown-divider deleteWhenClose"></div>
                                                                <div class="menu-item px-3">
                                                                    <a href="javascript:;" onclick="revisi_rab()" class="menu-link px-3 deleteWhenClose">Revisi RAB</a>
                                                                </div>
                                                                <div class="menu-item px-3">
                                                                    <a href="javascript:;" onclick="revisi_penawaran()" class="menu-link px-3 deleteWhenClose">Revisi Penawaran</a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        } else { #pelanggan area...
                                                        ?>
                                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                                                <div class="menu-item px-3">
                                                                    <a href="javascript:;" onclick="lihat_surat_penawaran()" class="menu-link px-3">Lihat Surat Penawaran</a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>

                                                        <!--end::Menu 3-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Card header-->

                                            <!--begin::Card body-->
                                            <div class="card-body" id="kt_chat_messenger_body">
                                                <!--begin::Messages-->
                                                <div id="tempat_berbicara" class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px">

                                                </div>
                                                <!--end::Messages-->
                                            </div>
                                            <!--end::Card body-->
                                            <!--begin::Card footer-->
                                            <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                                                <div id="kirim_chat_tutup"></div>
                                                <form method="post" id="kirim_chat_form" action="<?php echo base_url(); ?>chat_room_conversation/simpan" autocomplete="off">
                                                    <div class="d-flex flex-stack">
                                                        <div class="input-group input-group-solid mb-5">
                                                            <textarea class="form-control" rows="1" id="pesan" name="pesan" placeholder="Ketik sebuah pesan"></textarea>
                                                            <span class="input-group-text" id="basic-addon2" style="padding: unset; border: unset">
                                                                <button class="btn btn-primary btn-sm" type="submit" id="kirim_chat" style="height: 100%"><i class="fa fa-paper-plane"></i></button>
                                                            </span>
                                                        </div>

                                                        <input type="hidden" id="id_chat_room" name="id_chat_room">
                                                        <input type="hidden" id="id_rab" name="id_rab">
                                                        <input type="hidden" id="id_dokumen_permohonan" name="id_dokumen_permohonan">
                                                        <input type="hidden" id="token" name="token" value="<?php echo genToken('SEND_DATA'); ?>">
                                                    </div>
                                                </form>
                                            </div>
                                            <!--end::Card footer-->
                                        </div>
                                        <!--end::Messenger-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Layout-->
                            </div>
                            <!--end::Content container-->
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
        $("#kt_chat_messenger").hide();
        $("#kt_chat_welcome").show();

        var container_height = $("#kt_app_toolbar").parent().outerHeight();
        var kt_app_toolbar_height = $("#kt_app_toolbar").outerHeight();
        var height = container_height - kt_app_toolbar_height;
        $("#kt_chat_messenger").css('height', (height + 25) + 'px');

        var id_room = '<?php echo (isset($konten['id_room']) ? $konten['id_room'] : '') ?>';
        var list_data;

        function load_room_chat() {
            var filter = $("#filter").val();

            preloader('show');
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['filter'] = filter;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>chat_room/load_data',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(result) {
                    preloader('hide');
                    var rangkai = '';

                    if (result.length > 0) {
                        list_data = result;
                        var width = $("#kt_chat_contacts_body").width();
                        for (var i = 0; i < result.length; i++) {
                            if (result[i].id_chat_room == id_room) {
                                open_chat(i, '<?php echo $this->session->userdata('login_as'); ?>');
                            }
                            var last_chat = '';

                            if (result[i].last_chat) {
                                var now = moment().format('DD-MM-YYYY');
                                var last_chat_date = moment(result[i].last_chat).format('DD-MM-YYYY');
                                if (now == last_chat_date) {
                                    last_chat = moment(result[i].last_chat).format('LT');
                                } else {
                                    last_chat = moment(result[i].last_chat).format('DD/MM');
                                }
                            }

                            if ('<?php echo $this->session->userdata('login_as'); ?>' == 'administrator') {
                                var inisial = result[i].nama_pejabat_penghubung_proses_tkdn.charAt(0).toUpperCase();
                                rangkai += '<div class="d-flex flex-stack py-4" onclick="open_chat(' + i + ', \'<?php echo $this->session->userdata('login_as'); ?>\')" style="cursor: pointer">' +
                                    '<div class="d-flex align-items-center">' +
                                    '<div class="symbol symbol-45px symbol-circle">' +
                                    '<span class="symbol-label bg-light-success text-success fs-6 fw-bolder">' + inisial + '</span>' +
                                    '</div>' +
                                    '<div class="ms-5">' +
                                    '<a href="javascript:;" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">' + result[i].nama_pejabat_penghubung_proses_tkdn + '</a>' +
                                    '<div class="fw-semibold text-muted text-truncate" style="width: ' + (width - 130) + 'px">' + result[i].nama_badan_usaha + ' ' + result[i].nama_perusahaan + '</div>' +
                                    (last_chat ? '<span class="text-muted fs-7 mb-1">' + last_chat + '</span>' : '') +
                                    (result[i].status == 0 ? ' <span class="badge badge-secondary">Closed</span>' : '') +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="d-flex flex-column align-items-end ms-2">' +
                                    (result[i].unread > 0 ? '<span class="badge badge-sm badge-circle badge-success" id="notif-' + result[i].id_chat_room + '">' + (result[i].unread > 9 ? '9+' : result[i].unread) + '</span>' : '') +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="separator separator-dashed d-none"></div>';
                            } else {
                                var inisial = result[i].nama_admin.charAt(0).toUpperCase();
                                rangkai += '<div class="d-flex flex-stack py-4" onclick="open_chat(' + i + ', \'<?php echo $this->session->userdata('login_as'); ?>\')" style="cursor: pointer">' +
                                    '<div class="d-flex align-items-center">' +
                                    '<div class="symbol symbol-45px symbol-circle">' +
                                    '<span class="symbol-label bg-light-success text-success fs-6 fw-bolder">' + inisial + '</span>' +
                                    '</div>' +
                                    '<div class="ms-5">' +
                                    '<a href="javascript:;" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">' + result[i].nama_admin + '</a>' +
                                    '<div class="fw-semibold text-muted text-truncate" style="width: ' + (width - 130) + 'px">' + result[i].jns_admin + '</div>' +
                                    (last_chat ? '<span class="text-muted fs-7 mb-1">' + last_chat + '</span>' : '') +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="d-flex flex-column align-items-end ms-2">' +
                                    (result[i].unread > 0 ? '<span class="badge badge-sm badge-circle badge-success" id="notif-' + result[i].id_chat_room + '">' + (result[i].unread > 9 ? '9+' : result[i].unread) + '</span>' : '') +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="separator separator-dashed d-none"></div>';

                            }
                        }

                    } else {
                        rangkai = '<div class="text-center">' +
                            '<div class="fw-bold fs-4 mt-10">Belum Ada Percakapan Negosiasi</div>' +
                            '<div>Silahkan mulai percakapan negosaisi dari surat penawaran yang sudah terbit di halaman Dokumen Permohonan TKDN.</div>' +
                            '</div>';
                    }

                    $("#teman_bicara").html(rangkai);
                }
            })
        }
        load_room_chat();

        function open_chat(i, login_as) {
            var data = list_data[i];
            $("#notif-" + data.id_chat_room).remove();
            $("#id_chat_room").val(data.id_chat_room);
            $("#id_rab").val(data.id_rab);
            $("#id_dokumen_permohonan").val(data.id_dokumen_permohonan);

            if (login_as == 'administrator') {
                var nama_teman_bicara = data.nama_pejabat_penghubung_proses_tkdn;
                var sub_teman_bicara = 'Nomor Surat Penawaran: ' + data.nomor_surat_penawaran;
                // var sub_teman_bicara = data.nama_badan_usaha+' '+data.nama_perusahaan;

            } else {
                var nama_teman_bicara = data.nama_admin;
                var sub_teman_bicara = 'Nomor Surat Penawaran: ' + data.nomor_surat_penawaran;
                // var sub_teman_bicara = data.jns_admin;
            }
            $("#nama_teman_bicara").html(nama_teman_bicara);
            $("#sub_teman_bicara").html(sub_teman_bicara);

            $("#kt_chat_messenger").show();
            $("#kt_chat_welcome").hide();

            var kt_chat_messenger_header = $("#kt_chat_messenger_header").outerHeight();
            var kt_chat_messenger_footer = $("#kt_chat_messenger_footer").outerHeight();
            var tempat_bicara_height = height - kt_chat_messenger_header - kt_chat_messenger_footer;
            $("#tempat_berbicara").attr('style', 'height:' + tempat_bicara_height + 'px!important;');

            $("#kirim_chat_tutup").hide();
            $("#kirim_chat_form, .deleteWhenClose").show();
            <?php
            if ($this->session->userdata('login_as') == 'administrator') {
                echo "var id_admin = '" . $this->session->userdata('id_admin') . "';";
            ?>
                if (id_admin != data.id_assesor) {
                    var tutup_box = '<div class="text-center">Anda hanya berhak untuk melihat data percakapan saja. Hanya Verifikator yang bersangkutan yang boleh membalas pesan ini.</div>';
                    $("#kirim_chat_tutup").html(tutup_box);
                    $("#kirim_chat_tutup").show();
                    $("#kirim_chat_form").hide();

                    $(".deleteWhenClose").hide();
                }
            <?php
            }
            ?>

            if (data.status == 0) {
                //chat sudah ditutup...
                var tutup_box = '<div class="text-center">Room negosiasi ini telah ditutup pada tanggal ' + reformatDate(data.time_update) + '.</div>';
                $("#kirim_chat_tutup").html(tutup_box);
                $("#kirim_chat_tutup").show();
                $("#kirim_chat_form").hide();

                $(".deleteWhenClose").hide();
            }

            load_conversation(data.id_chat_room);

        }

        function load_conversation(id_chat_room) {
            var data = new Object;
            data['token'] = '<?php echo genToken('LOAD_DATA'); ?>';
            data['id_chat_room'] = id_chat_room;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>chat_room_conversation/load_data',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    var rangkai = '';
                    if (data.length > 0) {
                        moment.locale(default_lang);
                        var last_pengirim = '';
                        for (var i = 0; i < data.length; i++) {
                            var waktu_kirim = '';

                            var now = moment().format('DD-MM-YYYY');
                            var last_waktu_kirim = moment(data[i].waktu_kirim).format('DD-MM-YYYY');
                            if (now == last_waktu_kirim) {
                                waktu_kirim = moment(data[i].waktu_kirim).format('LT') + ' WIB';
                            } else {
                                waktu_kirim = reformatDate(data[i].waktu_kirim);
                            }

                            <?php
                            if ($this->session->userdata('login_as') == 'pelanggan') {
                                echo "var tabel_pengirim = 'pelanggan';";
                                echo "var id_pengirim = '" . $this->session->userdata('id_pelanggan') . "';";
                            } else {
                                echo "var tabel_pengirim = 'mst_admin';";
                                echo "var id_pengirim = '" . $this->session->userdata('id_admin') . "';";
                            }
                            ?>

                            //BAGIAN ANDA...
                            if (data[i].tabel_pengirim == tabel_pengirim && data[i].id_pengirim == id_pengirim) {
                                var header = '';
                                if (last_pengirim != data[i].nama) {
                                    header = '<div class="d-flex align-items-center mb-2">' +
                                        '<div class="me-3">' +
                                        '<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">Anda</a>' +
                                        '</div>' +
                                        '<div class="symbol symbol-35px symbol-circle">' +
                                        '<img src="' + base_url + 'assets/images/avatar.jpg">' +
                                        '</div>' +
                                        '</div>';
                                    last_pengirim = data[i].nama;
                                }

                                rangkai += '<div class="d-flex justify-content-end mb-3">' +
                                    '<div class="d-flex flex-column align-items-end">' +
                                    header +
                                    '<div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end" data-kt-element="message-text">' +
                                    data[i].pesan +
                                    '<div class="text-muted fs-7 mb-1">' + waktu_kirim + '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                            } else {
                                var header = '';
                                if (last_pengirim != data[i].nama) {
                                    header = '<div class="d-flex align-items-center mb-2">' +
                                        '<div class="me-3">' +
                                        '<div class="symbol symbol-35px symbol-circle">' +
                                        '<img src="' + base_url + 'assets/images/avatar.jpg">' +
                                        '</div>' +
                                        '<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">' + data[i].nama + '</a>' +
                                        '</div>' +
                                        '</div>';
                                    last_pengirim = data[i].nama;
                                }
                                rangkai += '<div class="d-flex justify-content-start mb-3">' +
                                    '<div class="d-flex flex-column align-items-start">' +
                                    header +
                                    '<div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start" data-kt-element="message-text">' +
                                    data[i].pesan +
                                    '<div class="text-muted fs-7 mb-1">' + waktu_kirim + '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                            }
                        }
                    }
                    $("#tempat_berbicara").html(rangkai);
                    $('#tempat_berbicara').scrollTop($('#tempat_berbicara')[0].scrollHeight);
                }
            })
        }

        $("#kirim_chat_form").on('submit', function(e) {
            e.preventDefault();

            var id_chat_room = $("#id_chat_room").val();
            var pesan = $("#pesan").val();
            if (pesan) {
                $("#kirim_chat").attr({
                    "data-kt-indicator": "on",
                    'disabled': true
                });

                jQuery(this).ajaxSubmit({
                    dataType: 'json',
                    success: function(data) {
                        $("#kirim_chat").removeAttr('disabled data-kt-indicator');

                        if (data.sts == 1) {
                            $("#pesan").val('');
                            load_conversation(id_chat_room);
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
        });

        function lihat_rab() {
            var id_rab = $("#id_rab").val();
            if (id_rab) {
                window.open(base_url + 'page/lihat_detail_rab/' + id_rab, '_blank');
            }
        }

        function lihat_surat_penawaran(action_for) {
            if (action_for == 'administrator') {
                var id_rab = $("#id_rab").val();
                if (id_rab) {
                    window.open(base_url + 'page/lihat_surat_penawaran/' + id_rab, '_blank');
                }
            } else {
                var id_dokumen_permohonan = $("#id_dokumen_permohonan").val();
                if (id_dokumen_permohonan) {
                    window.open(base_url + 'pelanggan/lihat_penawaran/' + id_dokumen_permohonan, '_blank');
                }

            }
        }

        function revisi_rab() {
            var pertanyaan = "Apakah Anda yakin untuk merevisi RAB?";

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
                inputLabel: 'Alasan Revisi',
                inputPlaceholder: 'Tuliskan alasan revisi Anda disini',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Anda harus menuliskan alasan revisi dengan jelas!'
                    }
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    proses_revisi('rab', result.value);
                }

            });
        }

        function revisi_penawaran() {
            var pertanyaan = "Apakah Anda yakin untuk merevisi surat penawaran?";

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
                inputLabel: 'Alasan Revisi',
                inputPlaceholder: 'Tuliskan alasan revisi Anda disini',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Anda harus menuliskan alasan revisi dengan jelas!'
                    }
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    proses_revisi('surat_penawaran', result.value);
                }

            });
        }

        function proses_revisi(tipe_revisi, alasan_revisi) {
            //show loading animation...
            preloader('show');

            var data = new Object;
            data['token'] = '<?php echo genToken('SEND_DATA'); ?>';
            data['id_rab'] = $("#id_rab").val();
            data['tipe_revisi'] = tipe_revisi;
            data['alasan_revisi'] = alasan_revisi;

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>chat_room/proses_revisi',
                data: 'data_send=' + encodeURIComponent(JSON.stringify(data)),
                cache: false,
                dataType: "json",
                success: function(data) {
                    preloader('hide');

                    if (data.sts == 1) {
                        var response = JSON.parse('<?php echo alert('simpan_berhasil'); ?>');
                        response.callback_yes = after_proses_revisi;
                        swalAlert(response);
                    } else {
                        var response = JSON.parse('<?php echo alert('proses_gagal'); ?>');
                        swalAlert(response);
                    }
                }

            });
        }

        function after_proses_revisi() {
            window.location.reload(false);
        }
    </script>
</body>
<!-- end::Body -->

</html>