<?php

namespace App\Http\Controllers\Tracking;
use App\Http\Controllers\MyBaseController;

use Auth;

use Illuminate\Http\JsonResponse;

class CompanyInteractionController extends MyBaseController
{
    public function getDataInteraction()
    {
      $data=  $this->getDataInteraction();
      dd($data);
    }

    public function getCompanyInteractionsByLocation(): JsonResponse
    {
        $results = DB::table('tracking_sessions as ts')
            ->join('tracking_events as te', 'ts.id', '=', 'te.session_id')
            ->join('business as b', 'ts.business_id', '=', 'b.id')
            ->select(
                'b.name as companyName',
                DB::raw("IFNULL(ts.country, 'Anonymous') as country"),
                DB::raw("IFNULL(ts.city, 'Anonymous') as city"),
                DB::raw('COUNT(te.id) as totalInteractions')
            )
            ->where('te.section', 'businessDetails')
            ->groupBy('companyName', 'country', 'city')
            ->orderByDesc('totalInteractions')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $results
        ]);
    }
}

