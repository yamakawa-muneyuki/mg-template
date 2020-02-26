<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportForList as ReportForListResource;
use App\Http\Resources\ReportForShow as ReportForShowResource;
use App\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payload = $request->all();
        $query = Report::query();
        if ($payload['started_from']) {
            $query->where('created_at', '>=', $payload['started_from']);
        }
        if ($payload['started_to']) {
            $to = Carbon::parse($payload['started_to']);
            $query->where('created_at', '<', $to->addDay());
        }
        $reports = $query->orderBy('created_at', 'desc')->get();
        return ReportForListResource::collection($reports);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payload = $request->all();
        $model = DB::transaction(function () use ($payload) {
            $model = new Report;
            $model->type = 1;
            $model->body = json_encode($payload['report']);
            $model->save();
        });

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        return new ReportForShowResource($report);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        $payload = $request->all();
        DB::transaction(function () use ($payload, $report) {
            $report->body = json_encode($payload['report']);
            $report->save();
        });

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        $work_permission->delete();

        return response()->json([
            'result' => true,
        ]);
    }
}
