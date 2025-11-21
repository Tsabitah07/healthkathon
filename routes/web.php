<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['title' => 'Home Page', 'appName' => 'HEALTHKATHON']);
})->name('home');

Route::get('/network-status', function () {
    return view('components.dashboard_component.network_status', ['title' => 'Network Status', 'appName' => 'Network Status']);
})->name('network-status');

Route::get('/card', function () {
    return view('components.dashboard_component.card', ['title' => 'Card Information', 'appName' => 'Card']);
})->name('card');

Route::get('/visit', function () {
    return view('components.dashboard_component.visit', ['title' => 'Visit', 'appName' => 'Visit']);
})->name('visit');

Route::get('/claim', function () {
    return view('components.dashboard_component.claim', ['title' => 'Claim', 'appName' => 'Claim']);
})->name('claim');

Route::get('/chaincode', function () {
    return view('components.dashboard_component.chaincode', ['title' => 'Chaincode', 'appName' => 'Chaincode']);
})->name('chaincode');

Route::get('/debug-console', function () {
    return view('components.dashboard_component.debug_console', ['title' => 'Debug Console', 'appName' => 'Debug Console']);
})->name('debug-console');

