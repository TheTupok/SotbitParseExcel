<?php

namespace ReadFilterExcel;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class ReadFilter implements IReadFilter
{
    public function readCell($columnAddress, $row, $worksheetName = ''): bool
    {
        if(in_array($columnAddress, range('A', 'D'))) {
            return true;
        }
        return false;
    }
}