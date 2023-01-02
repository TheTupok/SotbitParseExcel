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
                $item[$keyFilter] = str_replace(',', '.', $item[$keyFilter]);
                return floatval($item[$keyFilter]) >= $startRange;
            });
        }
        if($endRange) {
            $data = array_filter($data, function($item) use ($data, $endRange, $keyFilter) {
                $item[$keyFilter] = str_replace(',', '.', $item[$keyFilter]);
                return floatval($item[$keyFilter]) <= $endRange;
            });
        }

        return $data;
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