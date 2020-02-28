<?php

namespace App\Reports;

abstract class Report
{
    /**
     * インスタンス
     *
     * @var Json
     */
    protected $report;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($report)
    {
        $this->report = json_decode($report->body);
    }

    public function __get($name)
    {
        return $this->report->$name;
    }
}