<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function addLog($type, $message, $details = null)
    {
        $logEntry = [
            'id' => uniqid(),
            'type' => $type,
            'message' => $message,
            'details' => $details,
            'timestamp' => now(),
        ];

        // Here you would typically save the log entry to a database or a file.
        // For demonstration purposes, we'll just return the log entry.
        return $logEntry;
    }
}
