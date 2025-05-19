<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class excelreaderfilter_helper implements PHPExcel_Reader_IReadFilter
{
    //put your code here
    private $_startRow  = 0;
    private $_endRow    = 0;
    private $_columns   = array();

    public function __construct($startRow, $endRow, $columns)
    {
        $this->_startRow    = $startRow;
        $this->_endRow      = $endRow;
        $this->_columns     = $columns;
    }

    public function readCell($column, $row, $worksheetName = '')
    {
        if ($row >= $this->_startRow && $row <= $this->_endRow) {
            if (in_array($column, $this->_columns)) {
                return true;
            }
        }

        return false;
    }
}
