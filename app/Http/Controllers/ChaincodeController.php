<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChaincodeController extends Controller
{
    private $apiBaseUrl;

    private $chaincodeFunctions = [
        'IssueCard' => [
            'description' => 'Issue a new BPJS card',
            'args' => ['cardID', 'patientID', 'patientName', 'nik', 'dateOfBirth', 'gender', 'address', 'cardType', 'issueDate', 'expiryDate'],
            'example' => '["CARD001", "P001", "John Doe", "1234567890123456", "1990-01-01", "Male", "Jakarta", "PBI", "2024-01-01", "2025-01-01"]'
        ],
        'VerifyCard' => [
            'description' => 'Verify a BPJS card',
            'args' => ['cardID'],
            'example' => '["CARD001"]'
        ],
        'UpdateCardStatus' => [
            'description' => 'Update card status',
            'args' => ['cardID', 'newStatus', 'reason'],
            'example' => '["CARD001", "suspended", "Payment overdue"]'
        ],
        'RecordVisit' => [
            'description' => 'Record a patient visit',
            'args' => ['visitID', 'cardID', 'patientID', 'patientName', 'faskesCode', 'faskesName', 'faskesType', 'visitDate', 'visitType', 'diagnosis', 'treatment', 'doctorName', 'doctorID', 'notes'],
            'example' => '["VISIT001", "CARD001", "P001", "John Doe", "RS001", "RS Siloam", "rumahsakit", "2024-01-01", "outpatient", "Flu", "Medicine", "Dr. Smith", "DOC001", "Notes"]'
        ],
        'GetPatientVisits' => [
            'description' => 'Get all visits for a patient',
            'args' => ['patientID'],
            'example' => '["P001"]'
        ],
        'CreateReferral' => [
            'description' => 'Create a referral',
            'args' => ['referralID', 'patientID', 'patientName', 'cardID', 'fromFaskesCode', 'fromFaskesName', 'toFaskesCode', 'toFaskesName', 'referralReason', 'diagnosis', 'referringDoctor', 'referralDate', 'validUntil', 'notes'],
            'example' => '["REF001", "P001", "John Doe", "CARD001", "PKM001", "Puskesmas", "RS001", "RS Siloam", "Specialist needed", "Complex case", "Dr. Lee", "2024-01-01", "2024-01-31", "Urgent"]'
        ],
        'UpdateReferralStatus' => [
            'description' => 'Update referral status',
            'args' => ['referralID', 'newStatus', 'acceptedBy', 'notes'],
            'example' => '["REF001", "accepted", "Dr. Wong", "Patient scheduled"]'
        ],
        'SubmitClaim' => [
            'description' => 'Submit an insurance claim',
            'args' => ['claimID', 'patientID', 'patientName', 'cardID', 'visitID', 'faskesCode', 'faskesName', 'claimType', 'serviceDate', 'diagnosis', 'treatment', 'totalAmount', 'claimAmount'],
            'example' => '["CLAIM001", "P001", "John Doe", "CARD001", "VISIT001", "RS001", "RS Siloam", "rawat-jalan", "2024-01-01", "Flu", "Consultation", "500000", "450000"]'
        ],
        'ProcessClaim' => [
            'description' => 'Process a claim (approve/reject)',
            'args' => ['claimID', 'newStatus', 'reviewNotes'],
            'example' => '["CLAIM001", "approved", "All documentation complete"]'
        ],
        'GetPatientClaims' => [
            'description' => 'Get all claims for a patient',
            'args' => ['patientID'],
            'example' => '["P001"]'
        ],
        'QueryAuditLogs' => [
            'description' => 'Query audit logs',
            'args' => ['startKey', 'endKey'],
            'example' => '["AUDIT_0", "AUDIT_999999999999999"]'
        ]
    ];

    public function __construct()
    {
        $this->apiBaseUrl = env('BLOCKCHAIN_API_URL', 'http://localhost:3000');
    }

    public function index()
    {
        return view('components.dashboard_component.chaincode', [
            'title' => 'Chaincode',
            'appName' => 'Chaincode',
            'functions' => $this->chaincodeFunctions
        ]);
    }

    public function getFunctions()
    {
        return response()->json($this->chaincodeFunctions);
    }

    public function invoke(Request $request)
    {
        $validated = $request->validate([
            'function' => 'required|string',
            'args' => 'required|string',
        ]);

        try {
            $args = json_decode($validated['args'], true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid JSON format for arguments'
                ], 400);
            }

            // Simulate chaincode invocation
            $response = [
                'success' => true,
                'function' => $validated['function'],
                'args' => $args,
                'result' => [
                    'message' => $validated['function'] . ' executed successfully',
                    'transactionID' => 'TX' . time(),
                    'blockNumber' => rand(100, 1000),
                    'timestamp' => now()->toISOString(),
                    'data' => 'Simulated result for ' . $validated['function']
                ]
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Chaincode invocation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function query(Request $request)
    {
        $validated = $request->validate([
            'function' => 'required|string',
            'args' => 'required|string',
        ]);

        try {
            $args = json_decode($validated['args'], true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid JSON format for arguments'
                ], 400);
            }

            $response = [
                'success' => true,
                'function' => $validated['function'],
                'args' => $args,
                'result' => [
                    'message' => 'Query ' . $validated['function'] . ' successful',
                    'data' => [
                        'sampleData' => 'This would contain the actual query result',
                        'timestamp' => now()->toISOString()
                    ]
                ]
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Chaincode query failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function loadExample(Request $request)
    {
        $function = $request->input('function', 'IssueCard');

        if (isset($this->chaincodeFunctions[$function])) {
            return response()->json([
                'success' => true,
                'example' => $this->chaincodeFunctions[$function]['example']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Function not found'
        ], 404);
    }
}
