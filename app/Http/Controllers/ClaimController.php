<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClaimController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('BLOCKCHAIN_API_URL', 'http://localhost:3000');
    }

    public function index()
    {
        return view('components.dashboard_component.claim', [
            'title' => 'Claim',
            'appName' => 'Claim'
        ]);
    }

    public function submitClaim(Request $request)
    {
        $validated = $request->validate([
            'claim_id' => 'required|string',
            'patient_id' => 'required|string',
            'patient_name' => 'required|string',
            'card_id' => 'required|string',
            'visit_id' => 'required|string',
            'facility_code' => 'required|string',
            'facility_name' => 'required|string',
            'claim_type' => 'required|in:1,2,3',
            'service_date' => 'required|date',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
            'claim_amount' => 'required|numeric|min:0',
        ]);

        try {
            $response = [
                'success' => true,
                'claimID' => $validated['claim_id'],
                'status' => 'submitted',
                'message' => 'Claim submitted successfully',
                'transactionID' => 'TX' . time(),
                'submitDate' => now()->toISOString(),
                'estimatedPaymentDate' => now()->addWeek()->format('Y-m-d')
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit claim: ' . $e->getMessage()
            ], 500);
        }
    }

    public function processClaim(Request $request)
    {
        $validated = $request->validate([
            'claim_id' => 'required|string',
            'claim_amount' => 'required|numeric',
        ]);

        try {
            $approved = rand(0, 10) > 3; // 70% approval rate

            $response = [
                'success' => true,
                'claimID' => $validated['claim_id'],
                'status' => $approved ? 'approved' : 'rejected',
                'message' => $approved ? 'Claim approved' : 'Claim rejected - documentation incomplete',
                'reviewedBy' => 'BPJS Reviewer ' . rand(1, 10),
                'reviewDate' => now()->toISOString(),
                'paymentAmount' => $approved ? $validated['claim_amount'] : 0,
                'paymentDate' => $approved ? now()->addWeek()->format('Y-m-d') : null
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process claim: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPatientClaims(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|string',
        ]);

        try {
            $response = [
                'success' => true,
                'patientID' => $validated['patient_id'],
                'claims' => [
                    [
                        'claimID' => 'CLAIM' . (time() - 86400),
                        'date' => now()->subDay()->format('Y-m-d'),
                        'faskes' => 'RS Siloam',
                        'amount' => 500000,
                        'status' => 'approved'
                    ],
                    [
                        'claimID' => 'CLAIM' . (time() - 172800),
                        'date' => now()->subDays(2)->format('Y-m-d'),
                        'faskes' => 'Puskesmas Menteng',
                        'amount' => 150000,
                        'status' => 'paid'
                    ],
                    [
                        'claimID' => 'CLAIM' . (time() - 259200),
                        'date' => now()->subDays(3)->format('Y-m-d'),
                        'faskes' => 'RS Cipto',
                        'amount' => 300000,
                        'status' => 'submitted'
                    ]
                ],
                'totalClaims' => 3,
                'totalAmount' => 950000
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get patient claims: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateSampleData()
    {
        $timestamp = time();
        $claimTypes = ['1', '2', '3'];
        $amounts = [150000, 300000, 500000, 750000, 1000000, 2000000];
        $faskesNames = ['RS Siloam', 'RS Cipto', 'RS Harapan Kita', 'Puskesmas Menteng'];
        $diagnoses = ['Flu', 'Diabetes', 'Hypertension', 'Checkup'];
        $selectedAmount = $amounts[array_rand($amounts)];

        return response()->json([
            'claim_id' => 'CLAIM' . $timestamp,
            'patient_id' => 'P' . rand(1, 1000),
            'patient_name' => 'Patient ' . rand(1, 1000),
            'card_id' => 'CARD' . rand(1, 1000),
            'visit_id' => 'VISIT' . $timestamp,
            'facility_code' => 'RS' . str_pad(rand(1, 100), 3, '0', STR_PAD_LEFT),
            'facility_name' => $faskesNames[array_rand($faskesNames)],
            'claim_type' => $claimTypes[array_rand($claimTypes)],
            'service_date' => now()->format('Y-m-d'),
            'diagnosis' => $diagnoses[array_rand($diagnoses)],
            'treatment' => 'Medical consultation and prescribed medication',
            'total_amount' => $selectedAmount,
            'claim_amount' => (int) ($selectedAmount * 0.9),
        ]);
    }
}
