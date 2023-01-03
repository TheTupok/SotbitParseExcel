<?php

require '../services/filterData.service.php';

use FilterData\FilterDataService;

class FilterData
{
    public function filterDataByParams($data, $params): array
    {
        $filterDataService = new FilterDataService();

        if($params) {
            foreach($params as $key => $value) {
                if($key == 'price' || ($key == 'article' && $params['articleType'] == 'number')) {
                    $data = $filterDataService->filterRangeData($data, $value, $key);
                }
                if($key == 'name') {
                    $data = $filterDataService->filterContainsData($data, $value, $key);
                }
                if($key == 'article' && $params['articleType'] == 'mixed') {
                    $data = $filterDataService->filterRangeMixedArticle($data, $value);
                }
            }
        }
        if(!empty($params['countRow'])) {
            $data = array_slice($data, 0, (int)$params['countRow']);
        }

        return $data;
    }

    public function transformDataInHTMLTable($data): string
    {
        $htmlTable = '';
        foreach($data as $row) {
            $htmlTable .= '<tr>';
            foreach($row as $col) {
                if($col == $row['articleType']) {
                    continue;
                }
                $htmlTable .= '<td>' . $col . '</td>';
            }
            $htmlTable .= '</tr>';
        }

        return $htmlTable;
    }
}

$filterData = new FilterData();
$data = $filterData->filterDataByParams($_POST['data'], $_POST['filter']);
echo $filterData->transformDataInHTMLTable($data);
