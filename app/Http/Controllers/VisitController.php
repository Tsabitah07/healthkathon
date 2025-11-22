<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VisitController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('BLOCKCHAIN_API_URL', 'http://localhost:3000');
    }

    public function index()
    {
        return view('components.dashboard_component.visit', [
            'title' => 'Visit',
            'appName' => 'Visit'
        ]);
    }

    public function recordVisit(Request $request)
    {
        $validated = $request->validate([
            'visit_id' => 'required|string',
            'card_id' => 'required|string',
            'patient_id' => 'required|string',
            'patient_name' => 'required|string',
            'facility_code' => 'required|string',
            'facility_name' => 'required|string',
            'facility_type' => 'required|in:1,2',
            'visit_date' => 'required|date',
            'visit_type' => 'required|in:1,2,3',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'doctor_id' => 'required|string',
            'doctor_name' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        try {
            // Map facility_type dan visit_type ke string
            $facilityTypes = ['1' => 'rumahsakit', '2' => 'puskesmas'];
            $visitTypes = ['1' => 'inpatient', '2' => 'outpatient', '3' => 'emergency'];

            // Simulate API call
            $response = [
                'success' => true,
                'visitID' => $validated['visit_id'],
                'message' => 'Visit recorded successfully',
                'transactionID' => 'TX' . time(),
                'timestamp' => now()->toISOString(),
                'blockNumber' => rand(100, 1000)
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to record visit: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPatientHistory(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|string',
        ]);

        try {
            // Simulated response
            $response = [
                'success' => true,
                'patientID' => $validated['patient_id'],
                'visits' => [
                    [
                        'visitID' => 'VISIT' . (time() - 86400),
                        'date' => now()->subDay()->format('Y-m-d'),
                        'faskes' => 'Puskesmas Menteng',
                        'diagnosis' => 'Flu',
                        'doctor' => 'Dr. Johnson'
                    ],
                    [
                        'visitID' => 'VISIT' . (time() - 172800),
                        'date' => now()->subDays(2)->format('Y-m-d'),
                        'faskes' => 'RS Cipto',
                        'diagnosis' => 'Checkup',
                        'doctor' => 'Dr. Lee'
                    ]
                ],
                'totalVisits' => 2
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get patient history: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateSampleData()
    {
        $timestamp = time();
        $diagnoses = ['Common Cold', 'Flu', 'Fever', 'Headache', 'Checkup', 'Diabetes Control'];
        $faskes = [
            ['code' => 'RS001', 'name' => 'RS Siloam', 'type' => '1'],
            ['code' => 'RS002', 'name' => 'RS Cipto', 'type' => '1'],
            ['code' => 'PKM001', 'name' => 'Puskesmas Menteng', 'type' => '2']
        ];
        $doctors = ['Smith', 'Johnson', 'Lee', 'Wong', 'Kumar'];
        $selectedFaskes = $faskes[array_rand($faskes)];

        return response()->json([
            'visit_id' => 'VISIT' . $timestamp,
            'card_id' => 'CARD' . rand(1, 1000),
            'patient_id' => 'P' . rand(1, 1000),
            'patient_name' => 'Patient ' . rand(1, 1000),
            'facility_code' => $selectedFaskes['code'],
            'facility_name' => $selectedFaskes['name'],
            'facility_type' => $selectedFaskes['type'],
            'visit_date' => now()->format('Y-m-d'),
            'visit_type' => (string) rand(1, 3),
            'diagnosis' => $diagnoses[array_rand($diagnoses)],
            'treatment' => 'Medication and rest prescribed',
            'doctor_name' => 'Dr. ' . $doctors[array_rand($doctors)],
            'doctor_id' => 'DOC' . rand(1, 100),
            'notes' => 'Patient condition stable'
        ]);
    }
}
