<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CardController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('BLOCKCHAIN_API_URL', 'http://localhost:3000');
    }

    public function index()
    {
        return view('components.dashboard_component.card', [
            'title' => 'Card Information',
            'appName' => 'Card'
        ]);
    }

    public function issueCard(Request $request)
    {
        $validated = $request->validate([
            'card_id' => 'required|string',
            'patient_id' => 'required|string',
            'patient_name' => 'required|string',
            'nik' => 'required|string|size:16',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F',
            'address' => 'required|string',
            'card_type' => 'required|in:1,2',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after:issue_date',
        ]);

        try {
            // Simulate API call ke blockchain (ganti dengan actual API call)
            // $response = Http::post("{$this->apiBaseUrl}/api/card/issue", $validated);

            // Simulated response
            $response = [
                'success' => true,
                'cardID' => $validated['card_id'],
                'status' => 'active',
                'message' => 'Card issued successfully',
                'transactionID' => 'TX' . time(),
                'timestamp' => now()->toISOString()
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to issue card: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verifyCard(Request $request)
    {
        $validated = $request->validate([
            'card_id' => 'required|string',
        ]);

        try {
            // Simulate API call ke blockchain
            // $response = Http::get("{$this->apiBaseUrl}/api/card/verify/{$validated['card_id']}");

            // Simulated response
            $response = [
                'success' => true,
                'card' => [
                    'cardID' => $validated['card_id'],
                    'status' => 'active',
                    'qrCode' => 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . $validated['card_id']
                ],
                'message' => 'Card is valid and active'
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify card: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateSampleData()
    {
        $timestamp = time();
        $cardTypes = ['1', '2'];
        $genders = ['M', 'F'];
        $cities = ['Jakarta', 'Surabaya', 'Bandung', 'Medan'];

        return response()->json([
            'card_id' => 'CARD' . $timestamp,
            'patient_id' => 'P' . $timestamp,
            'patient_name' => 'Sample Patient ' . rand(1, 1000),
            'nik' => '32' . str_pad(rand(0, 99999999999999), 14, '0', STR_PAD_LEFT),
            'birth_date' => '1990-01-01',
            'gender' => $genders[array_rand($genders)],
            'address' => $cities[array_rand($cities)] . ', Indonesia',
            'card_type' => $cardTypes[array_rand($cardTypes)],
            'issue_date' => now()->format('Y-m-d'),
            'expiry_date' => now()->addYear()->format('Y-m-d'),
        ]);
    }
}
