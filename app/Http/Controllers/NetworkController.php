<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NetworkController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('BLOCKCHAIN_API_URL', 'http://localhost:3000');
    }

    public function index()
    {
        return view('components.dashboard_component.network_status', [
            'title' => 'Network Status',
            'appName' => 'Network Status'
        ]);
    }

    public function checkStatus()
    {
        try {
            // Simulate checking actual blockchain network
            // $response = Http::get("{$this->apiBaseUrl}/api/network/status");

            $status = [
                'success' => true,
                'apiConnected' => true,
                'blockchainRunning' => true,
                'peers' => 6,
                'orderers' => 5,
                'channels' => 1,
                'organizations' => [
                    [
                        'name' => 'BPJS',
                        'msp' => 'BPJSMSP',
                        'peers' => 2,
                        'status' => 'active'
                    ],
                    [
                        'name' => 'Rumah Sakit',
                        'msp' => 'RumahSakitMSP',
                        'peers' => 2,
                        'status' => 'active'
                    ],
                    [
                        'name' => 'Puskesmas',
                        'msp' => 'PuskesmasMSP',
                        'peers' => 2,
                        'status' => 'active'
                    ]
                ],
                'systemInfo' => [
                    'environment' => 'Development',
                    'platform' => 'Windows',
                    'ram' => '8GB',
                    'consensus' => 'Raft',
                    'throughput' => '550 TPS',
                    'latency' => '<100ms',
                    'channel' => 'bpjs-main',
                    'chaincode' => 'bpjs v1.0'
                ]
            ];

            return response()->json($status);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'apiConnected' => false,
                'blockchainRunning' => false,
                'message' => 'Failed to check network status: ' . $e->getMessage()
            ], 500);
        }
    }
}
