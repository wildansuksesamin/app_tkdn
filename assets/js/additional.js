var defaultThemeMode = "light";
var mimeTypes = {
    'pdf': 'application/pdf',
    'xls': 'application/vnd.ms-excel',
    'xlsx': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'jpg': 'image/jpeg',
    'jpeg': 'image/jpeg'
};
var themeMode;
if (document.documentElement) {
    if (document.documentElement.hasAttribute("data-theme-mode")) {
        themeMode = document.documentElement.getAttribute("data-theme-mode");
    }
    else {
        if (localStorage.getItem("data-theme") !== null) {
            themeMode = localStorage.getItem("data-theme");
        }
        else {
            themeMode = defaultThemeMode;
        }
    }

    if (themeMode === "system") {
        themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
    }

    document.documentElement.setAttribute("data-theme", themeMode);
    changeLogo(themeMode);
}
KTThemeMode.on("kt.thememode.change", (function () {
    var mode = KTThemeMode.getMode();
    changeLogo(mode);
}));

function changeLogo(mode) {
    $(".logo").removeClass('app-sidebar-logo-default app-sidebar-logo-minimize');
    if (mode == 'dark') {
        $(".dark_logo").addClass('app-sidebar-logo-default');
        $(".light_logo").addClass('app-sidebar-logo-minimize');
    }
    else {
        $(".light_logo").addClass('app-sidebar-logo-default');
        $(".dark_logo").addClass('app-sidebar-logo-minimize');
    }
}

window.generate_blockUI = function (element) {
    var target = document.querySelector(element);
    return new KTBlockUI(target, {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
    });
}

window.konfirmasi = function (pertanyaan, callback_yes, callback_no = null, btn_ya, btn_tidak) {
    swal.fire({
        title: konfirmasi_title,
        html: pertanyaan,
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: (btn_ya ? btn_ya : '<i class="fa fa-check-circle text-white"></i> ' + btn_ya_public),
        cancelButtonText: (btn_tidak ? btn_tidak : '<i class="fa fa-times-circle text-white"></i> ' + btn_tidak_public),
        confirmButtonColor: '#0abb87',
        cancelButtonColor: '#d33',
        allowOutsideClick: false,
        reverseButtons: true
    }).then(function (result) {
        if (result.value) {
            callback_yes();
        } else if (result.dismiss === 'cancel') {
            callback_no;
        }
    });
}
window.swalAlert = function (response, btn_ok_mengerti) {
    Swal.fire({
        title: response.title,
        html: response.message,
        icon: response.type,
        buttonsStyling: !1,
        confirmButtonText: (btn_ok_mengerti ? btn_ok_mengerti : btn_ok_mengerti_public),
        customClass: {
            confirmButton: "btn btn-primary"
        }
    }).then(function (result) {
        if (result.isConfirmed) {
            (response.callback_yes ? response.callback_yes() : null);
        }
    });
}
window.toastrAlert = function (response) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toastr-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    if (response.type == 'success')
        toastr.success(response.message, response.title);
    else if (response.type == 'warning')
        toastr.warning(response.message, response.title);
    else
        toastr.error(response.message, response.title);
}
window.create_empty_state = function (element, pesan_tambah = '') {
    $("#empty_state").remove();
    var html = '<div style="text-align: center" id="empty_state"><img src="' + base_url + 'assets/images/empty.png" width="200px">' +
        '<h5>' + tidak_ada_data + '</h5>' + pesan_tambah + '</div>';
    $(element).hide();
    $(element).after(html);
}

window.validateEmail = function (email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
};
window.reformatDate = function (date, format) {
    moment.locale(default_lang);
    if (format) {
        return moment(date).format(format);
    }
    else {
        var time = moment(date, "YYYY-MM-DD HH:mm:ss", true).isValid();
        if (time) {
            return moment(date).format('DD MMMM YYYY HH:mm') + ' WIB';
        }
        else
            return moment(date).format('DD MMMM YYYY');
    }
}
window.isDate = function (tanggal, time = false) {
    if (time) {
        var pisah = tanggal.split(' ');
        var pecah = pisah[0].split('-');
        tanggal = pecah[2] + '-' + pecah[1] + '-' + pecah[0] + ' ' + pisah[1];
    }
    else {
        var pecah = tanggal.split('-');
        tanggal = pecah[2] + '-' + pecah[1] + '-' + pecah[0];
    }
    console.log(tanggal)
    return moment(tanggal).isValid();
}

$(".numeric").keydown(function (event) {
    if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 190 || event.keyCode == 8 || event.keyCode == 9) {
        // Allow. let it happen, don't do anything
    }
    else {
        //reject..
        event.preventDefault();
    }
});
window.render_status_label = function (v_status, v_status_text) {
    var status = '';
    if (v_status == 'A') {
        if (!v_status_text)
            v_status_text = aktif;
        status = render_badge('info', v_status_text);
    }
    else if (v_status == 'N') {
        if (!v_status_text)
            v_status_text = tidak_aktif;
        status = render_badge('danger', v_status_text);
    }
    else {
        if (!v_status_text)
            v_status_text = tidak_diketahui;
        status = render_badge('dark', v_status_text);
    }
    return status;
};
window.render_badge = function (style, text) {
    var badge = '<span class="badge badge-' + style + '">' + text + '</span>';
    return badge;
};
window.render_assesor = function (nama_assesor) {
    return '<div class="text-gray-400 fw-semibold d-block mt-2 fs-7"><span class="badge badge-light-primary">' + coverMe(nama_assesor, 'Belum Ada Verifikator') + '</span></div>';
}
var default_table = {
    "bLengthChange": false,
    "bFilter": false,
    "bInfo": false,
    "bPaginate": false,
    "bOrderable": false,
    "bSort": false
};
window.render_badge_tipe_pengajuan = function (tipe_pengajuan) {
    if (tipe_pengajuan == 'PEMERINTAH')
        tipe_pengajuan = '<span class="badge badge-light-success">Berbayar Pemerintah</span>'; //render_badge('success', 'Berbayar Pemerintah');
    else
        tipe_pengajuan = '<span class="badge badge-light-info">Berbayar Pelaku Usaha</span>'; //render_badge('info', 'Berbayar Pelaku Usaha');

    return tipe_pengajuan;
}

//mencegah submit saat tekan tombol enter...
$('form').bind("keydown", function (e) {
    if ((e.keyCode == 13) && ($(e.target)[0] != $("textarea")[0])) {
        e.preventDefault();
        return false;
    }
});
window.hideBr = function (str) {
    str.replace(/<br\s*[\/]?>/gi, "\n");
};
window.decodeHtml = function (html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
};
window.rupiah = function (nilai) {
    if (nilai > 0) {
        var rupiah = '';
        var desimal = '';

        var nilai_pecah = nilai.toString().split('.');
        var angka = nilai_pecah[0];
        if (nilai_pecah[1]) {
            desimal = ',' + nilai_pecah[1];
        }

        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++) if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return rupiah.split('', rupiah.length - 1).reverse().join('') + desimal;
    }
    else {
        return 0;
    }
};
window.convertToAngka = function (rupiah) {
    if (rupiah)
        return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
    else
        return 0;
};
window.convertToDesimal = function (rupiah) {
    if (rupiah !== undefined) {
        var pecah = rupiah.toString().split(',');
        var hasil = parseInt(pecah[0].replace(/,.*|[^0-9]/g, ''), 10) + (pecah[1] !== undefined ? '.' + pecah[1] : '');
        if (pecah[1] !== undefined){
            return parseFloat(parseFloat(hasil).toFixed(2));
        }
        else{
            return parseInt(hasil);
        }
    }
};

window.convertToRupiah = function (element) {
    var angka = $(element).val();
    var pecah = angka.toString().split(',');
    var depan = 0;
    if (pecah[0] !== undefined) {
        depan = (pecah[0] == '' ? 0 : pecah[0]);
        // if (depan > 0) {
            depan = rupiah(convertToAngka(depan));
        // }
    }

    $(element).val(depan + (pecah[1] !== undefined ? ',' + pecah[1].slice(0, 2) : ''));
};
window.safelyParseJSON = function (json) {
    try {
        return JSON.parse(json);
    } catch (ex) {
        console.log(ex);
        console.log(json);
        var data = new Object;
        data['sts'] = 'x';
        return JSON.stringify(data);
    }
};
window.coverMe = function (value, cover) {
    if (!value) {
        if (!cover)
            return '-';
        else
            return cover;
    }
    else
        return value;
};
window.imageCompressor = function (element) {
    const file = $(element)[0].files[0];

    if (!file) {
        return;
    }
    new ImageCompressor(file, {
        quality: 1,
        maxWidth: 1000,
        maxHeight: 1000,
        convertSize: 5000000,
        success(blob) {
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                base64data = reader.result;
                $(element + '_blob').val(base64data);
            }
        }
    });
}
window.generate_img = function (element, buffer, action_success, action_failed) {
    const file = $(element)[0].files[0];

    if (!file) {
        return;
    }

    $(element).parent().append('<div id="temp_loading"><i class="fa fa-spinner fa-spin"></i> ' + loading + '...</div>');
    new ImageCompressor(file, {
        quality: 1,
        maxWidth: 1000,
        maxHeight: 1000,
        convertSize: 5000000,
        success(blob) {
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                base64data = reader.result;
                $(buffer).attr('src', base64data);
                $("#temp_loading").remove();

                if (action_success)
                    action_success(base64data);
            }
        },
        error(e) {
            if (action_failed)
                action_failed(e.message);
            $("#temp_loading").remove();
        },
    });
};
var datepicker_variable = {
    enableTime: false,
    altInput: true,
    altFormat: "d-m-Y",
    dateFormat: "Y-m-d",
}
function setDatePicker(el, value) {
    if ($(el).length > 0) {
        datepicker_variable.value = value;
        let calendar = flatpickr(el);
        calendar.destroy();
        $(el).flatpickr(datepicker_variable);

    }
}
setDatePicker('.datepicker');

$(".datetimepicker").flatpickr({
    enableTime: true,
    altInput: true,
    altFormat: "d-m-Y H:i",
    dateFormat: "Y-m-d H:i:s",
});
$(".daterangepicker").flatpickr({
    mode: "range",
    enableTime: false,
    altInput: true,
    altFormat: "d-m-Y",
    dateFormat: "Y-m-d",
});
$(".timepicker").flatpickr({
    noCalendar: true,
    enableTime: true,
    dateFormat: "H:i",
});

$(".monthpicker").flatpickr({
    shorthand: true,
    static: true,
    altInput: true,
    plugins: [new monthSelectPlugin({ shorthand: false, dateFormat: "Y-m", altFormat: "M Y" })]
});

function display_gambar(element) {
    var id = $(element).attr('id');
    $("#simpan").attr('disabled', 'disabled');
    generate_img('#' + id, '#' + id + '_img_viewer', function (result) {
        $("#" + id + "_blob").val(result);
        $("#" + id + "_img_viewer").show(200);
        $("#simpan").removeAttr('disabled');
    });
}
window.copyToClipboard = function (content_element, btn_element) {
    const target = document.getElementById(content_element);
    const button = document.getElementById(btn_element);
    var clipboard = new ClipboardJS(button, {
        target: target,
        text: function () {
            return target.value;
        }
    });

    // Success action handler
    clipboard.on('success', function (e) {
        const currentLabel = button.innerHTML;

        // Exit label update when already in progress
        if (button.innerHTML === 'Copied!') {
            return;
        }

        // Update button label
        button.innerHTML = 'Copied!';

        // Revert button label after 3 seconds
        setTimeout(function () {
            button.innerHTML = currentLabel;
        }, 3000)
    });
}
window.status_permohonan = function (index) {
    if (index == 99 || index == 0)
        index = '0';

    var status = [
        {
            'admin': ['danger', 'Dibatalkan & Selesai'],
            'pelanggan': ['danger', 'Dibatalkan & Selesai'],
            'pic': ''
        },
        { //status = 1
            'admin': ['info', 'Menunggu Penugasan Verifikator'],
            'pelanggan': ['info', 'Dalam Pengecekan'],
            'pic': 'Koordinator'
        },
        { //status = 2
            'admin': ['warning', 'Dalam Pengecekan'],
            'pelanggan': ['info', 'Dalam Pengecekan'],
            'pic': 'Verifikator'
        },
        { //status = 3
            'admin': ['danger', 'Dokumen Ditolak'],
            'pelanggan': ['danger', 'Dokumen Ditolak'],
            'pic': 'Pelanggan'
        },
        { //status = 4
            'admin': ['info', 'Perancangan RAB'],
            'pelanggan': ['info', 'Menunggu Surat Penawaran'],
            'pic': 'Verifikator'
        },
        { //status = 5
            'admin': ['warning', 'Verifikasi RAB'],
            'pelanggan': ['info', 'Menunggu Surat Penawaran'],
            'pic': 'Koordinator'
        },
        { //status = 6
            'admin': ['danger', 'RAB Ditolak'],
            'pelanggan': ['info', 'Menunggu Surat Penawaran'],
            'pic': 'Verifikator'
        },
        { //status = 7
            'admin': ['info', 'Pembuatan Surat Penawaran'],
            'pelanggan': ['info', 'Menunggu Surat Penawaran'],
            'pic': 'Admin'
        },
        { //status = 8
            'admin': ['warning', 'Verifikasi Surat Penawaran'],
            'pelanggan': ['info', 'Menunggu Surat Penawaran'],
            'pic': 'Kabid'
        },
        { //status = 9
            'admin': ['danger', 'Surat Penawaran Ditolak'],
            'pelanggan': ['info', 'Menunggu Surat Penawaran'],
            'pic': 'Admin'
        },
        { //status = 10
            'admin': ['success', 'Surat Penawaran Terkirim'],
            'pelanggan': ['warning', 'Periksa Surat Penawaran'],
            'pic': 'Pelanggan'
        },
        { //status = 11
            'admin': ['warning', 'Negosiasi'],
            'pelanggan': ['warning', 'Negosiasi'],
            'pic': 'Verifikator'
        },
        { //status = 12
            'admin': ['info', 'Input Masa Collecting Dokumen'],
            'pelanggan': ['info', 'Menunggu Surat OC'],
            'pic': 'Verifikator'
        },
        { //status = 13
            'admin': ['info', 'Buat OC'],
            'pelanggan': ['info', 'Menunggu Surat OC'],
            'pic': 'Admin'
        },
        { //status = 14
            'admin': ['danger', 'OC Ditolak'],
            'pelanggan': ['info', 'Menunggu Surat OC'],
            'pic': 'Admin'
        },
        { //status = 15
            'admin': ['warning', 'Koordinator Verifikasi OC'],
            'pelanggan': ['info', 'Menunggu Surat OC'],
            'pic': 'Koordinator'
        },
        { //status = 16
            'admin': ['warning', 'Kabid Verifikasi OC'],
            'pelanggan': ['info', 'Menunggu Surat OC'],
            'pic': 'Kabid'
        },
        { //status = 17
            'admin': ['info', 'Membuat Proforma Invoice'],
            'pelanggan': ['info', 'Request Proforma Invoice'],
            'pic': 'Admin'
        },
        { //status = 18
            'admin': ['danger', 'Proforma Invoice Ditolak'],
            'pelanggan': ['info', 'Membuat Proforma Invoice'],
            'pic': 'Admin'
        },
        { //status = 19
            'admin': ['warning', 'Kabid Verifikasi Proforma Invoice'],
            'pelanggan': ['info', 'Membuat Proforma Invoice'],
            'pic': 'Kabid'
        },
        { //status = 20
            'admin': ['warning', 'Kepala Keuangan Verifikasi Proforma Invoice'],
            'pelanggan': ['info', 'Membuat Proforma Invoice'],
            'pic': 'Kepala Keuangan'
        },
        { //status = 21
            'admin': ['success', 'Proforma Invoice Telah Terbit'],
            'pelanggan': ['success', 'Proforma Invoice Telah Terbit'],
            'pic': 'Pelanggan'
        },

        //===============
        { //status = 22
            'admin': ['success', 'Menunggu Konfirmasi Order Pelanggan'],
            'pelanggan': ['warning', 'Menunggu Konfirmasi Order Pelanggan'],
            'pic': 'Pelanggan'
        },
        { //status = 23
            'admin': ['warning', 'Verifikasi Konfirmasi Order Pelanggan'],
            'pelanggan': ['warning', 'Verifikasi Konfirmasi Order Pelanggan'],
            'pic': 'Keuangan'
        },
        { //status = 24
            'admin': ['danger', 'Bukti Bayar Ditolak'],
            'pelanggan': ['danger', 'Bukti Bayar Ditolak'],
            'pic': 'Pelanggan'
        },
        { //status = 25
            'admin': ['info', 'Penentuan Waktu Pelaksanaan'],
            'pelanggan': ['info', 'Menunggu Form 01'],
            'pic': 'Verifikator'
        },
        { //status = 26
            'admin': ['info', 'Pembuatan Form 01'],
            'pelanggan': ['info', 'Menunggu Form 01'],
            'pic': 'Admin'
        },
        { //status = 27
            'admin': ['danger', 'Form 01 Ditolak'],
            'pelanggan': ['info', 'Menunggu Form 01'],
            'pic': 'Admin'
        },
        { //status = 28
            'admin': ['warning', 'Koordinator Verifikasi Form 01'],
            'pelanggan': ['info', 'Menunggu Form 01'],
            'pic': 'Koordinator'
        },
        { //status = 29
            'admin': ['warning', 'Kabid Verifikasi Form 01'],
            'pelanggan': ['info', 'Menunggu Form 01'],
            'pic': 'Kabid'
        },
        { //status = 30
            'admin': ['info', 'Pembuatan Payment Detail'],
            'pelanggan': ['info', 'Menunggu Invoice & Faktur Pajak'],
            'pic': 'Admin'
        },
        { //status = 31
            'admin': ['danger', 'Payment Detail Ditolak'],
            'pelanggan': ['info', 'Menunggu Invoice & Faktur Pajak'],
            'pic': 'Admin'
        },
        { //status = 32
            'admin': ['warning', 'Kabid Verifikasi Payment Detail'],
            'pelanggan': ['info', 'Menunggu Invoice & Faktur Pajak'],
            'pic': 'Kabid'
        },
        { //status = 33
            'admin': ['info', 'Upload Invoice & Faktur Pajak'],
            'pelanggan': ['info', 'Menunggu Invoice & Faktur Pajak'],
            'pic': 'Keuangan'
        },
        { //status = 34
            'admin': ['success', 'Invoice & Faktur Pajak Telah Terbit'],
            'pelanggan': ['success', 'Invoice & Faktur Pajak Telah Terbit'],
            'pic': 'Pelanggan'
        },
        { //status = 35
            'admin': ['success', 'Menunggu Opening Meeting'],
            'pelanggan': ['success', 'Menunggu Opening Meeting'],
            'pic': 'Pelanggan'
        },
    ];

    if (index)
        return status[index];
    else
        return status;
}
window.status_pengajuan_badge = function(status, manual_pic){
    var hasil = status_permohonan(status);
    var style = hasil['admin'][0];
    var text = hasil['admin'][1];
    return '<div>'+render_badge(style, text)+'</div><div class="fw-bold text-gray-800 fs-7 mt-2">' + (status != 99 ? '<i class="fa fa-user-circle text-primary me-3"></i>'+(manual_pic ? manual_pic : hasil['pic']) : '') +'</div>';

}
window.status_pengajuan_pelanggan_badge = function (status) {
    var hasil = status_permohonan(status);
    var style = hasil['pelanggan'][0];
    var text = hasil['pelanggan'][1];
    return render_badge(style, text);
}
window.status_verifikasi_tkdn = function (index) {
    index = (index ? index : '0');
    var status = [
        {   //status = 0...
            'admin': ['warning', 'Penugasan Verifikator'],
            'pelanggan': ['success', 'Opening Meeting'],
            'pic': 'Koordinator'
        },
        {   //status = 1...
            'admin': ['warning', 'Buat Surat Tugas'],
            'pelanggan': ['success', 'Persiapan Surat Tugas'],
            'pic': 'Verifikator'
        },
        {   //status = 2...
            'admin': ['warning', 'Revisi Surat Tugas'],
            'pelanggan': ['info', 'Revisi Surat Tugas'],
            'pic': 'Verifikator'
        },
        {   //status = 3...
            'admin': ['warning', 'Upload Dokumen Meeting'],
            'pelanggan': ['success', 'Persiapan Surat Tugas'],
            'pic': 'Verifikator'
        },
        {   //status = 4...
            'admin': ['success', 'Menunggu Dokumen Meeting Pelanggan'],
            'pelanggan': ['warning', 'Upload Dokumen Meeting'],
            'pic': 'Pelanggan'
        },
        {   //status = 5...
            'admin': ['warning', 'Verifikasi Dokumen Meeting'],
            'pelanggan': ['success', 'Peninjauan Dokumen Meeting'],
            'pic': 'Verifikator'
        },
        {   //status = 6...
            'admin': ['success', 'Menunggu Dokumen Meeting Pelanggan'],
            'pelanggan': ['warning', 'Upload Ulang Dokumen Meeting'],
            'pic': 'pelanggan'
        },
        {   //status = 7...
            'admin': ['success', 'Pengumpulan Dokumen'],
            'pelanggan': ['warning', 'Pengumpulan Dokumen'],
            'pic': 'pelanggan'
        },
        {   //status = 8...
            'admin': ['success', 'Verifikasi Dokumen Pemberitahuan'],
            'pelanggan': ['warning', 'Pengumpulan Dokumen'],
            'pic': 'Koordinator'
        },
        {   //status = 9...
            'admin': ['success', 'Verifikasi Dokumen Pemberitahuan'],
            'pelanggan': ['warning', 'Pengumpulan Dokumen'],
            'pic': 'Kabag'
        },
        {   //status = 10...
            'admin': ['danger', 'Dokumen Pemberitahuan Ditolak'],
            'pelanggan': ['warning', 'Pengumpulan Dokumen'],
            'pic': 'Verifikator'
        },
        {   //status = 11...
            'admin': ['success', 'Pemberitahuan Terkirim'],
            'pelanggan': ['danger', 'Pemberitahuan Pemenuhan Dokumen'],
            'pic': 'Pelanggan'
        },
        {   //status = 12...
            'admin': ['warning', 'Verifikasi Permohonan Perpanjangan Waktu'],
            'pelanggan': ['warning', 'Verifikasi Permohonan Perpanjangan Waktu'],
            'pic': 'Verifikator'
        },
        {   //status = 13...
            'admin': ['danger', 'Perpanjangan Waktu Ditolak'],
            'pelanggan': ['danger', 'Perpanjangan Waktu Ditolak'],
            'pic': 'Pelanggan'
        },
        {   //status = 14...
            'admin': ['success', 'Perpanjangan Waktu Disetujui'],
            'pelanggan': ['success', 'Perpanjangan Waktu Disetujui'],
            'pic': 'Pelanggan'
        },
        {   //status = 15...
            'admin': ['success', 'Penugasan Verifikator'],
            'pelanggan': ['success', 'Survey Lapangan'],
            'pic': 'Koordinator'
        },
        {   //status = 16...
            'admin': ['success', 'Collecting Document 2'],
            'pelanggan': ['warning', 'Collecting Document 2'],
            'pic': 'Pelanggan'
        },
        {   //status = 17...
            'admin': ['success', 'Verifikasi Teknis'],
            'pelanggan': ['success', 'Verifikasi Teknis'],
            'pic': 'Verifikator'
        },
        {   //status = 18...
            'admin': ['success', 'Revisi Verifikasi Teknis'],
            'pelanggan': ['success', 'Verifikasi Teknis'],
            'pic': 'Verifikator'
        },
        {   //status = 19...
            'admin': ['success', 'Review Assessment'],
            'pelanggan': ['success', 'Verifikasi Teknis'],
            'pic': 'Koordinator'
        },
        {   //status = 20...
            'admin': ['success', 'Penugasan ETC'],
            'pelanggan': ['success', 'Verifikasi Teknis'],
            'pic': 'Koordinator'
        },
        {   //status = 21...
            'admin': ['success', 'Approval Assessment'],
            'pelanggan': ['success', 'Verifikasi Teknis'],
            'pic': 'ETC'
        },
        {   //status = 22...
            'admin': ['success', 'Menunggu Draft Tanda Sah Pelanggan'],
            'pelanggan': ['warning', 'Upload Draft Tanda Sah'],
            'pic': 'Pelanggan'
        },
        {   //status = 23...
            'admin': ['success', 'Menunggu Draft Tanda Sah Pelanggan'],
            'pelanggan': ['danger', 'Revisi Draft Tanda Sah'],
            'pic': 'Pelanggan'
        },
        {   //status = 24...
            'admin': ['success', 'Verifikasi Draft Tanda Sah'],
            'pelanggan': ['success', 'Verifikasi Draft Tanda Sah'],
            'pic': 'Verifikator'
        },
        {   //status = 25...
            'admin': ['success', 'Panel Kemenperin'],
            'pelanggan': ['success', 'Panel Kemenperin'],
            'pic': 'Verifikator'
        },
        {   //status = 26...
            'admin': ['success', 'Closing Meeting'],
            'pelanggan': ['success', 'Closing Meeting'],
            'pic': 'Verifikator'
        },
        
        {   //status = 99...
            'admin': ['danger', 'Dibatalkan & Selesai'],
            'pelanggan': ['danger', 'Dibatalkan & Selesai'],
            'pic': ''
        },
    ];

    if (index) {
        if (index == 99) {
            var max = status.length - 1;
            return status[max];
        }
        else {
            return status[index];
        }
    }
    else
        return status;
}
window.status_verifikasi_tkdn_badge = function (status) {
    var hasil = status_verifikasi_tkdn(status);
    var style = hasil['admin'][0];
    var text = hasil['admin'][1];
    return '<div>' + render_badge(style, text) + '</div><div class="fw-bold text-gray-800 fs-7 mt-2"><i class="fa fa-user-circle text-primary me-3"></i>' + hasil['pic'] + '</div>';

}
window.status_verifikasi_tkdn_pelanggan_badge = function (status) {
    var hasil = status_verifikasi_tkdn(status);
    var style = hasil['pelanggan'][0];
    var text = hasil['pelanggan'][1];
    return render_badge(style, text);
}

window.status_closing_meeting = function(index){
    index = (index ? index : '0');
    var status = [
        {   //status = 0...
            'admin': ['success', 'Closing Meeting'],
            'pelanggan': ['success', 'Closing Meeting'],
            'pic': 'Verifikator'
        },
        {   //status = 1...
            'admin': ['danger', 'Closing Meeting Ditolak'],
            'pelanggan': ['success', 'Closing Meeting'],
            'pic': 'Verifikator'
        },
        {   //status = 2...
            'admin': ['success', 'Verifikasi Dokumen Kontrol'],
            'pelanggan': ['success', 'Closing Meeting'],
            'pic': 'Dokumen Kontrol'
        },
        {   //status = 3...
            'admin': ['success', 'Verifikasi Koordinator'],
            'pelanggan': ['success', 'Closing Meeting'],
            'pic': 'Koordinator'
        },
        {   //status = 4...
            'admin': ['danger', 'Menunggu Closing Meeting Pelanggan'],
            'pelanggan': ['success', 'Upload Closing Meeting'],
            'pic': 'Pelanggan'
        },

        // {   //status = 2...
        //     'admin': ['success', 'Approval Closing Meeting'],
        //     'pelanggan': ['success', 'Closing Meeting'],
        //     'pic': 'Koordinator'
        // },
        // {   //status = 3...
        //     'admin': ['success', 'Menunggu Dokumen Closing Meeting'],
        //     'pelanggan': ['warning', 'Upload Closing Meeting'],
        //     'pic': 'Pelanggan'
        // },
        // { //status = 4...
        //     'admin': ['info', 'Pembuatan Payment Detail'],
        //     'pelanggan': ['info', 'Menunggu Invoice & Faktur Pajak'],
        //     'pic': 'Admin'
        // },
        // { //status = 5...
        //     'admin': ['danger', 'Payment Detail Ditolak'],
        //     'pelanggan': ['info', 'Menunggu Invoice & Faktur Pajak'],
        //     'pic': 'Admin'
        // },
        // { //status = 6...
        //     'admin': ['warning', 'Kabid Verifikasi Payment Detail'],
        //     'pelanggan': ['info', 'Menunggu Invoice & Faktur Pajak'],
        //     'pic': 'Kabid'
        // },
        // { //status = 7...
        //     'admin': ['warning', 'Upload Surat Tugas (Sistem)'],
        //     'pelanggan': ['info', 'Menunggu Invoice & Faktur Pajak'],
        //     'pic': 'Admin'
        // },
        // { //status = 8...
        //     'admin': ['info', 'Upload Invoice & Faktur Pajak'],
        //     'pelanggan': ['info', 'Menunggu Invoice & Faktur Pajak'],
        //     'pic': 'Keuangan'
        // },
        // { //status = 9...
        //     'admin': ['success', 'Invoice & Faktur Pajak Telah Terbit'],
        //     'pelanggan': ['success', 'Invoice & Faktur Pajak Telah Terbit'],
        //     'pic': 'Pelanggan'
        // },
        
    ];
    if (index) {
        return status[index];
    }
    else
        return status;
}

window.status_closing_meeting_badge = function (status) {
    var hasil = status_closing_meeting(status);
    var style = hasil['admin'][0];
    var text = hasil['admin'][1];
    return '<div>' + render_badge(style, text) + '</div><div class="fw-bold text-gray-800 fs-7 mt-2"><i class="fa fa-user-circle text-primary me-3"></i>' + hasil['pic'] + '</div>';

}
window.status_closing_meeting_pelanggan_badge = function (status) {
    var hasil = status_closing_meeting(status);
    var style = hasil['pelanggan'][0];
    var text = hasil['pelanggan'][1];
    return render_badge(style, text);
}

function preloader(action) {
    if (action == 'show') {
        $(".page-loader").addClass('page_loading_show');
    }
    else {
        $(".page-loader").removeClass('page_loading_show');
    }
}
function printDiv(elem) {

    var divToPrint = document.getElementById(elem);

    var newWin = window.open('', 'Print-Window');

    newWin.document.open();

    newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

    newWin.document.close();

    setTimeout(function () { newWin.close(); }, 10);

}
// Fungsi untuk membuat daftar halaman yang akan ditampilkan
window.generatePages = function (element, currentPage, totalPages) {
    var maxPages = 4;
    // Reset array
    pageList = [];

    // Jika jumlah halaman kurang dari atau sama dengan maksimum halaman yang ditampilkan, tampilkan semua halaman
    if (totalPages <= maxPages) {
        for (var i = 1; i <= totalPages; i++) {
            pageList.push(i);
        }
    }
    // Jika halaman saat ini dekat dengan awal, tampilkan halaman awal dan beberapa halaman di akhir
    else if (currentPage <= Math.floor(maxPages / 2)) {
        console.log('awal');
        for (var i = 1; i <= Math.floor(maxPages / 2) + 1; i++) {
            pageList.push(i);
        }
        pageList.push("...");
        for (var i = totalPages - Math.floor(maxPages / 2) + 1; i <= totalPages; i++) {
            pageList.push(i);
        }
    }
    // Jika halaman saat ini dekat dengan akhir, tampilkan halaman akhir dan beberapa halaman di awal
    else if (currentPage > totalPages - Math.floor(maxPages / 2)) {
        console.log('akhir');
        for (var i = 1; i <= Math.floor(maxPages / 2); i++) {
            pageList.push(i);
        }
        pageList.push("...");
        for (var i = totalPages - Math.floor(maxPages / 2); i <= totalPages; i++) {
            pageList.push(i);
        }
    }
    // Jika halaman saat ini berada di tengah, tampilkan halaman di awal, tengah, dan akhir
    else {
        console.log('tengah');
        var start = parseInt(currentPage) - Math.floor(maxPages / 2);
        var end = parseInt(currentPage) + Math.floor(maxPages / 2);

        if (start > 1) {
            pageList.push(1);
            if (start > 2) {
                pageList.push("...");
            }
        }
        for (var i = start; i <= end; i++) {
            if (i != totalPages) {
                pageList.push(i);
            }
        }

        if (end < totalPages - 1) {
            pageList.push("...");
        }
        pageList.push(totalPages);
    }

    // Membuat HTML untuk menampilkan daftar halaman
    var paginationHTML = '<ul class="pagination">';
    for (var i = 0; i < pageList.length; i++) {
        if (pageList[i] == "...") {
            paginationHTML += '<li class="page-item "><a href="javascript:;" class="page-link">...</a></li>';
        } else if (pageList[i] == currentPage) {
            paginationHTML += '<li class="page-item "><a href="javascript:;" data-page="' + pageList[i] + '" class="page-link  text-hover-white active">' + pageList[i] + '</a></li>';
        } else {
            paginationHTML += '<li class="page-item "><a href="javascript:;" data-page="' + pageList[i] + '" class="page-link">' + pageList[i] + '</a></li>';
        }
    }

    paginationHTML += '</ul>';

    // Menampilkan daftar halaman
    $(element).html(paginationHTML);
}

window.redDot = function (tipe, css) {
    tipe = (tipe ? tipe : 'danger');

    return '<span class="bullet bullet-dot bg-' + tipe + ' h-6px w-6px position-absolute translate-middle animation-blink mt-1" ' + css + '></span>';
}
window.isEmailValid = function (email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}