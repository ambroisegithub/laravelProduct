<?php

namespace App\Http\Controllers;

use App\Models\ClinicalData;
use Illuminate\Http\Request;

class ClinicalDataController extends Controller
{
    public function getAllClinicalData()
    {
        $clinicalData = ClinicalData::all();

        return response(['clinicalData' => $clinicalData], 200);
    }

    public function getOneClinicalData($id)
    {
        $clinicalData = ClinicalData::find($id);

        if (!$clinicalData) {
            return response(['message' => 'Clinical data not found'], 404);
        }

        return response(['clinicalData' => $clinicalData], 200);
    }

    public function updateClinicalData(Request $request, $id)
    {
        $clinicalData = ClinicalData::find($id);

        if (!$clinicalData) {
            return response(['message' => 'Clinical data not found'], 404);
        }

        $fields = $request->validate([
            'datadate' => 'required|string',
            'weight' => 'required|string',
            'bloodpressure' => 'required|string',
            'bloodsugar' => 'required|string',
            'UltrasoundScan' => 'required|string'
        ]);

        $clinicalData->update([
            'datadate' => $fields['datadate'],
            'weight' => $fields['weight'],
            'bloodpressure' => $fields['bloodpressure'],
            'bloodsugar' => $fields['bloodsugar'],
            'UltrasoundScan' => $fields['UltrasoundScan'],
        ]);

        return response(['clinicalData' => $clinicalData], 200);
    }

    public function deleteClinicalData($id)
    {
        $clinicalData = ClinicalData::find($id);

        if (!$clinicalData) {
            return response(['message' => 'Clinical data not found'], 404);
        }

        $clinicalData->delete();

        return response(['message' => 'Clinical data deleted successfully'], 200);
    }

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
