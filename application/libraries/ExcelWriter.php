<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/PHPExcel/Writer/Excel2007.php";
	 
class ExcelWriter extends PHPExcel_Writer_Excel2007 {
	    public function __construct() {
	        parent::__construct();
	    }
            
            
	}

?>