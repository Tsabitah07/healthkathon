<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\ChaincodeController;

// Landing Page
Route::get('/', function () {
    return view('home', ['title' => 'Home Page', 'appName' => 'HEALTHKATHON']);
})->name('home');

Route::get('/home', function () {
    return view('home_after', ['title' => 'Home Page', 'appName' => 'HEALTHKATHON']);
})->name('home-after');

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Network Status
Route::get('/network-status', [NetworkController::class, 'index'])->name('network-status');
Route::get('/api/network/status', [NetworkController::class, 'checkStatus'])->name('api.network.status');

// Card
Route::get('/card', [CardController::class, 'index'])->name('card');
Route::post('/api/card/issue', [CardController::class, 'issueCard'])->name('api.card.issue');
Route::post('/api/card/verify', [CardController::class, 'verifyCard'])->name('api.card.verify');
Route::get('/api/card/sample', [CardController::class, 'generateSampleData'])->name('api.card.sample');

// Visit
Route::get('/visit', [VisitController::class, 'index'])->name('visit');
Route::post('/api/visit/record', [VisitController::class, 'recordVisit'])->name('api.visit.record');
Route::post('/api/visit/history', [VisitController::class, 'getPatientHistory'])->name('api.visit.history');
Route::get('/api/visit/sample', [VisitController::class, 'generateSampleData'])->name('api.visit.sample');

// Claim
Route::get('/claim', [ClaimController::class, 'index'])->name('claim');
Route::post('/api/claim/submit', [ClaimController::class, 'submitClaim'])->name('api.claim.submit');
Route::post('/api/claim/process', [ClaimController::class, 'processClaim'])->name('api.claim.process');
Route::post('/api/claim/patient', [ClaimController::class, 'getPatientClaims'])->name('api.claim.patient');
Route::get('/api/claim/sample', [ClaimController::class, 'generateSampleData'])->name('api.claim.sample');

// Chaincode
Route::get('/chaincode', [ChaincodeController::class, 'index'])->name('chaincode');
Route::get('/api/chaincode/functions', [ChaincodeController::class, 'getFunctions'])->name('api.chaincode.functions');
Route::post('/api/chaincode/invoke', [ChaincodeController::class, 'invoke'])->name('api.chaincode.invoke');
Route::post('/api/chaincode/query', [ChaincodeController::class, 'query'])->name('api.chaincode.query');
Route::get('/api/chaincode/example', [ChaincodeController::class, 'loadExample'])->name('api.chaincode.example');

// Debug Console
Route::get('/debug-console', function () {
    return view('components.dashboard_component.debug_console', ['title' => 'Debug Console', 'appName' => 'Debug Console']);
})->name('debug-console');
