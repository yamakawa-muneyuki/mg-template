<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Reports\ReportFactory;

class ReportForList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $report = ReportFactory::create($this->type, $this);
        // logger($report->construction->name);
        return [
            'id' => $this->id,
            'created_at' => $this->created_at->format('Y/m/d'),
            'name' => $report->construction->name,
            'from_period' => $report->construction->from_period,
            'to_period' => $report->construction->to_period,
        ];
    }
}
