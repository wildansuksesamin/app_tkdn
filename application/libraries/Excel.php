<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "/third_party/Excel/PHPExcel.php";

class excel extends PHPExcel
{
    public function __construct()
    {
        parent::__construct();
    }
}
