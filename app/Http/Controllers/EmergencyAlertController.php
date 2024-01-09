<?php

namespace App\Http\Controllers;
use App\Models\EmergencyAlert;
use Illuminate\Http\Request;

class EmergencyAlertController extends Controller
{
    public function getAllEmergencyAlerts()
    {
        $emergencyAlerts = EmergencyAlert::all();

        return response(['emergencyAlerts' => $emergencyAlerts], 200);
    }

    public function getOneEmergencyAlert($id)
    {
        $emergencyAlert = EmergencyAlert::find($id);

        if (!$emergencyAlert) {
            return response(['message' => 'Emergency alert not found'], 404);
        }

        return response(['emergencyAlert' => $emergencyAlert], 200);
    }

    public function createEmergencyAlert(Request $request)
    {
        $fields = $request->validate([
            // 'pregnancy_id' => 'required|exists:pregnancies,id',
            'alert_date' => 'required|date',
            'alert_message' => 'required|string',
        ]);

        $emergencyAlert = EmergencyAlert::create($fields);

        $response = [
            'emergencyAlert' => $emergencyAlert,
        ];

        return response($response, 201);
    }

    public function updateEmergencyAlert(Request $request, $id)
    {
        $emergencyAlert = EmergencyAlert::find($id);

        if (!$emergencyAlert) {
            return response(['message' => 'Emergency alert not found'], 404);
        }

        $fields = $request->validate([
            // 'pregnancy_id' => 'required|exists:pregnancies,id',
            'alert_date' => 'required|date',
            'alert_message' => 'required|string',
        ]);

        $emergencyAlert->update($fields);

        return response(['emergencyAlert' => $emergencyAlert], 200);
    }

    public function deleteEmergencyAlert($id)
    {
        $emergencyAlert = EmergencyAlert::find($id);

        if (!$emergencyAlert) {
            return response(['message' => 'Emergency alert not found'], 404);
        }

        $emergencyAlert->delete();

        return response(['message' => 'Emergency alert deleted successfully'], 200);
    }
}
