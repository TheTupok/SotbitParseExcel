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

        $spreadsheet->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#');

        $data = $spreadsheet->getActiveSheet()->toArray();
        return $this->convertToAssociationArray($data);
    }

    private function convertToAssociationArray($data): array
    {
        $associationArray = [];
        foreach($data as $array) {
            if($array == $data[0]) {
                $associationArray[] = ['<tr><td>' . $array[0] . '</td>',
                    '<td>' . $array[1] . '</td>',
                    '<td>' . $array[2] . '</td>',
                    '<td>' . $array[3] . '</td></tr>'];
                continue;
            } else if(!$array[0]) {
                continue;
            }

            if(ctype_digit($array[0])) {
                $array[4] = 'number';
            } else if(count(explode('-', $array[0])) == 2 && ctype_digit(explode('-', $array[0])[0])) {
                $array[4] = 'number';
            } else {
                $array[4] = 'mixed';
            }

            $associationArray[] = array_combine(['article', 'name', 'price', 'remainder', 'articleType'],
                array_slice($array, 0, 5));
        }

        return $associationArray;
    }
}

$readExcel = new ParseExcelService();
$data = $readExcel->readExcel('../excel.xlsx');
echo json_encode($data);
