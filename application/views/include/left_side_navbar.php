<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="#">
            <img alt="Logo" src="<?php echo base_url(); ?>assets/images/logo_text_white.png" class="h-35px app-sidebar-logo-default">
            <img alt="Logo" src="<?php echo base_url(); ?>assets/images/sucofindo.png" class="h-30px app-sidebar-logo-minimize">
        </a>
        <!--end::Logo image-->
        <!--Sidebar toggle-->
        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <?php echo getSvgIcon('arrows/arr079', 'svg-icon svg-icon-2 rotate-180'); ?>
            <!--end::Svg Icon-->
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <div class="menu-item pb-5">
                    <!--begin:Menu link-->
                    <a class="menu-link" href="<?php echo base_url() . 'page/profil_saya'; ?>">
                        <span class="menu-icon">
                            <img alt="Logo" src="<?php echo base_url() . $this->session->userdata('foto_admin'); ?>" style="width: 26px; height: 26px; border-radius: 50%; border:1px solid #eaeaea; object-fit: cover" <?php echo $no_avatar; ?> />
                        </span>
                        <span class="menu-title fw-bold"><?php echo $this->session->userdata('nama_admin'); ?></span>


                    </a><!--end:Menu link-->
                </div>
                <?php
                $url = $this->uri->segment(1) . '/' . $this->uri->segment(2);
                $sub_module = $this->session->userdata('ruang_kerja');

                $CI = &get_instance();
                $CI->load->model('menu_model', 'menu');
                $where_menu = array(
                    'parent_menu' => null,
                    'module' => 'ADMIN',
                    'sub_module IN (\'ALL\', \'' . $sub_module . '\')' => null,
                    "(select count(-1) jml from hak_akses_menu a where a.id_menu=menu.id_menu and a.id_jns_admin='" . $this->session->userdata('id_jns_admin') . "') > 0" => null
                );
                $order_menu = 'urutan_menu asc';
                $send_data = array('where' => $where_menu, 'order' => $order_menu);
                $menu_data = $CI->menu->load_data($send_data);
                if ($menu_data->num_rows() > 0) {
                    foreach ($menu_data->result() as $menu) {
                        $have_submenu = $panah = $active = '';
                        if ($menu->jml_child > 0) {
                            $have_submenu = 'menu-accordion';
                            $panah = '<span class="menu-arrow"></span>';

                            #cek apakah url dimiliki oleh sub menu...
                            $str = "select count(-1) jml from menu where parent_menu = '" . $menu->id_menu . "' and module = 'ADMIN' and url_menu = '" . $url . "'";
                            $jml = $CI->menu->query($str)->row()->jml;
                            if ($jml > 0) {
                                $active = ' active hover show';
                            }
                        } else {
                            if ($url == $menu->url_menu)
                                $active = ' active hover show';
                        }

                        $notif_sign = '';
                        if ((isset($konten['notif'][$menu->nama_menu]) and $konten['notif'][$menu->nama_menu] != '')) {
                            if (!is_array($konten['notif'][$menu->nama_menu])) {
                                if ($konten['notif'][$menu->nama_menu] > 0) {
                                    $notif_sign = '<span class="menu-badge"><span class="badge badge-success">' . $konten['notif'][$menu->nama_menu] . '</span></span>';
                                }
                            } else {
                                $notif_sign = '<span class="menu-badge"><span class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle animation-blink" style="margin-top: 5px;right: 40px;"></span></span>';
                            }
                        }

                        echo '<div ' . ($have_submenu ? 'data-kt-menu-trigger="click"' : '') . ' class="menu-item ' . $have_submenu . ' ' . $active . '">
                                <!--begin:Menu link-->
                                    <a class="menu-link" href="' . ($menu->url_menu == '#' ? 'javascript:;' : base_url() . $menu->url_menu) . '">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <i class="' . $menu->icon_menu . '"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title">' . $menu->nama_menu . '</span>
                                        ' . $notif_sign . '
                                        ' . $panah . '
                                    </a>';
                        if ($menu->jml_child > 0) {
                            echo '<div class="menu-sub menu-sub-accordion">';

                            $where_sub_menu = array(
                                'parent_menu' => $menu->id_menu,
                                'module' => 'ADMIN',
                                'sub_module IN (\'ALL\', \'' . $sub_module . '\')' => null,
                                "(select count(-1) jml from hak_akses_menu a where a.id_menu=menu.id_menu and a.id_jns_admin='" . $this->session->userdata('id_jns_admin') . "') > 0" => null
                            );
                            $order_sub_menu = 'urutan_menu asc';
                            $send_sub_data = array('where' => $where_sub_menu, 'order' => $order_sub_menu);
                            $sub_menu_data = $CI->menu->load_data($send_sub_data);
                            if ($sub_menu_data->num_rows() > 0) {
                                foreach ($sub_menu_data->result() as $sub_menu) {
                                    $active = '';
                                    if ($url == $sub_menu->url_menu)
                                        $active = 'active';

                                    echo '<div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link ' . $active . '" href="' . ($sub_menu->url_menu == '#' ? 'javascript:;' : base_url() . $sub_menu->url_menu) . '">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">' . $sub_menu->nama_menu . '</span>
                                                    ' . ((isset($konten['notif'][$menu->nama_menu][$sub_menu->nama_menu]) and $konten['notif'][$menu->nama_menu][$sub_menu->nama_menu] > 0) ? '<span class="menu-badge"><span class="badge badge-success">' . $konten['notif'][$menu->nama_menu][$sub_menu->nama_menu] . '</span></span>' : '') . '
                                                </a>
                                                <!--end:Menu link-->
                                            </div>';
                                }
                            }

                            echo '</div>';
                        }
                        echo '<!--end:Menu link-->
                            </div>';
                    }
                }
                ?>

            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
</div>
<!--end::Sidebar-->