<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST)&&$_POST!=null){
        $logFile = 'leads.txt';
        $logData = date("Y-m-d H:i:s")."$".json_encode($_POST, JSON_UNESCAPED_UNICODE).PHP_EOL;
        file_put_contents($logFile, $logData, FILE_APPEND);

        if (file_exists($logFile)) {
            $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $lineCount = count($lines);
        } else {
            error_log($logFile." не найден.");
        }
        $response = [
            "status" => "new",
            "lead_id" => $lineCount,
        ];

        echo json_encode($response);
    }
