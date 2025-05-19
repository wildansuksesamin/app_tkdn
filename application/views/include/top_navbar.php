<!--begin::Header-->
<div id="kt_app_header" class="app-header">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container" style="background: #FFF">
        <!--begin::sidebar mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                <?php echo getSvgIcon('abstract/abs015', 'svg-icon svg-icon-1'); ?>
                <!--end::Svg Icon-->
            </div>
        </div>
        <!--end::sidebar mobile toggle-->
        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="#" class="d-lg-none">
                <img alt="Logo" src="<?php echo base_url(); ?>assets/images/sucofindo.png" class="h-45px" />
            </a>
        </div>
        <!--end::Mobile logo-->
        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <!--begin::Menu wrapper-->
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                <div style="display: flex; align-items: center;">
                    <img src="<?php echo base_url(); ?>assets/images/logo_logo.png" style="height: 20px;">
                </div>
            </div>
            <!--end::Menu wrapper-->
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">

                <!--begin::User menu-->
                <div class="app-navbar-item ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-35px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <img src="<?php echo base_url() . $this->session->userdata('foto_admin'); ?>" style="object-fit: cover" alt="user" <?php echo $no_avatar; ?> />
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo" src="<?php echo base_url() . $this->session->userdata('foto_admin'); ?>" style="object-fit: cover;" <?php echo $no_avatar; ?> />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        <?php echo $this->session->userdata('nama_admin'); ?>
                                    </div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7"><?php echo $this->session->userdata('jns_admin'); ?></a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="<?php echo base_url(); ?>page/profil_saya" class="menu-link px-5">Profil Saya</a>
                        </div>
                        <div class="menu-item px-5">
                            <a href="<?php echo base_url(); ?>page/ruang_kerja" class="menu-link px-5">Pindah Ruang Kerja</a>
                        </div>
                        <div class="menu-item px-5">
                            <a href="<?php echo base_url(); ?>page/ganti_password" class="menu-link px-5">Ganti Password</a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="<?php echo base_url(); ?>gateway/keluar" class="menu-link px-5">Keluar</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->

            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
<!--end::Header-->