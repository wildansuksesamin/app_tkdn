<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('maxlength')) {
    function maxlength($string, $num)
    {
        if (strlen($string) > $num)
            $string = substr($string, 0, $num) . '...';
        return $string;
    }
}
if (!function_exists('reformat_date')) {
    function reformat_date($date, $option = array())
    {
        $CI = &get_instance();
        return $CI->reformat_date($date, $option);
    }
}
if (!function_exists('genToken')) {
    function genToken($type_token)
    {
        $CI = &get_instance();
        return $CI->getToken($type_token);
    }
}
if (!function_exists('alert')) {
    function alert($i)
    {
        $CI = &get_instance();
        return $CI->alert($i);
    }
}
if (!function_exists('convertToRupiah')) {
    function convertToRupiah($angka)
    {
        $CI = &get_instance();
        return $CI->convertToRupiah($angka);
    }
}
if (!function_exists('bulan')) {
    function bulan($i)
    {
        $CI = &get_instance();
        return $CI->bulan($i);
    }
}
if (!function_exists('balik_tanggal')) {
    function balik_tanggal($date)
    {
        $time = explode(' ', $date);
        $jam = '';
        if (array_key_exists("1", $time)) {
            $pecah = explode(":", $time[1]);
            $jam = ' ' . $pecah[0] . ':' . $pecah[1];
        }


        $tanggal = explode('-', $time[0]);
        $tanggal = $tanggal[2] . '-' . $tanggal[1] . '-' . $tanggal[0] . $jam;

        return $tanggal;
    }
}

if (!function_exists('_lang')) {
    function _lang($data)
    {
        $CI = &get_instance();
        $hasil = $CI->lang->line($data);
        echo ($hasil ? $hasil : '{{ ' . $data . ' }}');
    }
}
if (!function_exists('lang')) {
    function lang($data)
    {
        $CI = &get_instance();
        $hasil = $CI->lang->line($data);
        return ($hasil ? $hasil : '{{ ' . $data . ' }}');
    }
}
if (!function_exists('getSvgIcon')) {
    function getSvgIcon($path, $class = '')
    {
        $full_path = FCPATH . 'assets/media/icons/duotune/' . $path . '.svg';

        if (!file_exists($full_path)) {
            return "<!--SVG file not found: $path-->";
        }

        $cls = array("svg-icon");

        if (!empty($class)) {
            $cls = array_merge($cls, explode(" ", $class));
        }

        $svg_content = file_get_contents($full_path);

        $svg_content = "<span class=\"" . implode(" ", $cls) . "\">" . $svg_content . "</span>";

        $svg_content = str_replace(PHP_EOL, '', $svg_content);
        $svg_content = str_replace(array("\n", "\r"), '', $svg_content);

        return $svg_content;
    }
}
if (!function_exists('coverMe')) {
    function coverMe($string, $mask = '')
    {
        return ($string ?? $mask);
    }
}

if (!function_exists('render_assesor')) {
    function render_assesor($nama_assesor)
    {
        echo '<span class="badge badge-light-primary fs-7">' . $nama_assesor . '</span>';
    }
}
