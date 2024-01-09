<?php

namespace App\Http\Controllers;

use App\Models\ClinicalData;
use Illuminate\Http\Request;

class ClinicalDataController extends Controller
{
    public function clinicalData(Request $request)
    {
        $fields = $request->validate([
            'datadate' => 'required|string',
            'weight' => 'required|string',
            'bloodpressure' => 'required|string',
            'bloodsugar' => 'required|string',
            'UltrasoundScan' => 'required|string'
        ]);

        $clinicalData = ClinicalData::create([
            'datadate' => $fields['datadate'],
            'weight' => $fields['weight'],
            'bloodpressure' => $fields['bloodpressure'],
            'bloodsugar' => $fields['bloodsugar'],
            'UltrasoundScan' => $fields['UltrasoundScan'],
        ]);

        $response = [
            'clinicalData' => $clinicalData,
        ];

        return response($response, 201);
    }
}
