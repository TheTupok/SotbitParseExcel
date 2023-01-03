<?php

namespace FilterData;

class FilterDataService
{
    public function filterRangeData($data, $param, $keyFilter): array
    {
        $startRange = floatval($param['start']);
        $endRange = floatval($param['end']);

        if($startRange) {
            $data = array_filter($data, function($item) use ($data, $startRange, $keyFilter) {
                return floatval($item[$keyFilter]) >= $startRange;
            });
        }
        if($endRange) {
            $data = array_filter($data, function($item) use ($data, $endRange, $keyFilter) {
                return floatval($item[$keyFilter]) <= $endRange;
            });
        }

        return $data;
    }

    public function filterRangeMixedArticle($data, $param): array
    {
        $data = array_filter($data, function($item) {
            return $item['articleType'] == 'mixed';
        });

        $startRange = preg_replace('/[^0-9]+/', '', $param['start']);
        $endRange = preg_replace('/[^0-9]+/', '', $param['end']);

        $prefixArticle = preg_replace("/[0-9]/", '', $param['start']);

        $newData = [];
        foreach(range($startRange, $endRange) as $number) {
            foreach($data as $item) {
                if(str_contains($item['article'], $prefixArticle . $number)) {
                    $newData[] = $item;
                }
            }
        }
        return $newData;
    }

    public function filterContainsData($data, $param, $key): array
    {
        if($param) {
            $data = array_filter($data, function($item) use ($data, $param, $key) {
                return str_contains(mb_strtolower($item[$key]), mb_strtolower($param));
            });
        }

        return $data;
    }
}