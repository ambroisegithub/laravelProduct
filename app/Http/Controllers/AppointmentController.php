<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{

    public function Appointment(Request $request)
    {
        $fields = $request->validate([
            'appointmentdate' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string',
            'location' => 'required|string',
            'notes' => 'required|string'
        ]);

        $Appointment = Appointment::create([
            'appointmentdate' => $fields['appointmentdate'],
            'description' => $fields['description'],
            'status' => $fields['status'],
            'location' => $fields['location'],
            'notes' => $fields['notes'],
        ]);

        $response = [
            'Appointment' => $Appointment,
        ];

        return response($response, 201);
    }

    public function getAllAppointments()
    {
        $appointments = Appointment::all();

        $response = [
            'appointments' => $appointments,
        ];

        return response($response, 200);
    }

    public function getOneAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);

        $response = [
            'appointment' => $appointment,
        ];

        return response($response, 200);
    }

    public function updateAppointment(Request $request, $id)
    {
        $fields = $request->validate([
            'appointmentdate' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string',
            'location' => 'required|string',
            'notes' => 'required|string',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($fields);

        $response = [
            'appointment' => $appointment,
        ];

        return response($response, 200);
    }

    public function deleteAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        $response = [
            'message' => 'Appointment deleted successfully',
        ];

        return response($response, 200);
    }
}
