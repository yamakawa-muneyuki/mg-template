<?php

namespace App\Reports;

class ReportFactory
{
    public static function create($type, $model)
    {
        switch ($type) {
            case 1:
                return new NoFire($model);
                break;
            default:
                throw new Exception('予期せぬレポートタイプ');
        }
    }
}