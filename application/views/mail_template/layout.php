<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic | Bootstrap HTML, VueJS, React, Angular, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel Admin Dashboard Theme
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->
<head><base href="../../"/>
    <title>Metronic - the world's #1 selling Bootstrap Admin Theme Ecosystem for HTML, Vue, React, Angular & Laravel by Keenthemes</title>
    <meta charset="utf-8" />
    <meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Metronic | Bootstrap HTML, VueJS, React, Angular, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel Admin Dashboard Theme" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/media/logos/favicon.ico" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="<?php echo base_url(); ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="app-blank app-blank">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Body-->
        <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
            <!--begin::Email template-->
            <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
            <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
                <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                        <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <!--begin:Email content-->
                                <div style="text-align:left; margin-bottom:54px">
                                    <!--begin:Logo-->
                                    <div style="margin:0 60px 55px 60px">
                                        <a href="<?php echo base_url(); ?>" rel="noopener" target="_blank">
                                            <img alt="Logo" src="<?php echo base_url(); ?>assets/images/logo_sambung.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <!--end:Logo-->
                                    <!--begin:Text-->
                                    <div style="font-size: 14px; font-weight: 500; margin:0 60px 30px 60px; font-family:Arial,Helvetica,sans-serif">
                                        <p style="color:#181C32; font-size: 20px; font-weight:700; line-height:1.4; margin-bottom:24px">Hi, {{nama_pengaju}},</p>
                                        <p style="text-align: justify; margin-bottom:2px; color:#3F4254; line-height:1.6">{{isi_pesan}}</p>
                                    </div>
                                    <!--end:Text-->
                                    <!--begin:Action-->
                                    <a href="{{button_link}}" target="_blank" style="background-color:#50cd89;border-radius:6px;display: block;margin: 20px 60px;padding:11px 19px;color: #FFFFFF;font-size: 14px;font-weight:500;font-family:Arial,Helvetica,sans-serif;text-align: center;">{{button_label}}</a>
                                    <!--end:Action-->

                                    <!--begin:Text-->
                                    <div style="font-size: 14px; font-weight: 500; margin:0 60px 33px 60px; font-family:Arial,Helvetica,sans-serif">
                                        <p style="text-align: justify; margin-bottom:24px; color:#3F4254; line-height:1.6">{{isi_pesan_2}}</p>
                                    </div>
                                    <!--end:Text-->
                                </div>
                                <!--end:Email content-->
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                                <img src="<?php echo base_url(); ?>assets/images/sucofindo.png" style="width: 100px;">
                                <p style="margin-bottom:4px">© <?php echo $aplikasi; ?>. <?php echo $nama_instansi; ?>, <?php echo $alamat; ?></p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end::Email template-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Root-->
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="<?php echo base_url(); ?>assets/plugins/global/plugins.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
