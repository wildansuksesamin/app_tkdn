<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

#[\AllowDynamicProperties]

class ExcelReader
{
    function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('excel');
        $this->CI->load->helper('excelreaderfilter_helper');
    }


    public function read($filePath, $sheetIndex, $startRow, $endRow, $startColumn, $endColumn)
    {
        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
        $cacheSettings = array(' memoryCacheSize ' => '50MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        $inputFileType  = PHPExcel_IOFactory::identify($filePath);
        $objReader      = PHPExcel_IOFactory::createReader($inputFileType);

        $filterSubset   = new ExcelReaderFilter_helper($startRow, $endRow, range($startColumn, $endColumn));
        $objReader->setReadDataOnly(true);
        $objReader->setReadFilter($filterSubset);
        $objExcel       = $objReader->load($filePath);

        $objExcel->setActiveSheetIndex($sheetIndex);
        $sheetData = $objExcel->getActiveSheet()->toArray(null, true, true, true);
        return $sheetData;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/upload.php */