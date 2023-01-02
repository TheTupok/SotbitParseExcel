<?php

namespace ParseExcelService;

require '../vendor/autoload.php';
require '../services/readFilterExcel.service.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use ReadFilterExcel\ReadFilter;

class ParseExcelService
{
    public function readExcel($fileName, $fileType = 'Xlsx'): array
    {
        $filterSubset = new ReadFilter();

        $reader = IOFactory::createReader($fileType);
        $reader->setReadFilter($filterSubset);
        $spreadsheet = $reader->load($fileName);
        $reader->setReadDataOnly(true);

        $data = $spreadsheet->getActiveSheet()->toArray();
        return $this->convertToAssociationArray($data);
    }

    public function convertToAssociationArray($data): array
    {
        $associationArray = [];
        foreach($data as $array) {
            if($array[0] == 'Артикул') {
                $associationArray[] = ['<tr><td>' . $array[0] . '</td>',
                    '<td>' . $array[1] . '</td>',
                    '<td>' . $array[2] . '</td>',
                    '<td>' . $array[3] . '</td></tr>'];
                continue;
            } else if(!$array[0]) {
                continue;
            }
            $associationArray[] = array_combine(['article', 'name', 'price', 'remainder'],
                [$array[0], $array[1], $array[2], $array[3]]);
        }

        return $associationArray;
    }
}

$readExcel = new ParseExcelService();
$data = $readExcel->readExcel('../excel.xlsx');
echo json_encode($data);
