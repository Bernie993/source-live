<?php
require __DIR__.'/vendor/autoload.php';

// Enable all error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $options = [
        'cluster' => 'ap1',
        'useTLS' => true,
        'curl_options' => [
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_VERBOSE => true,
        ],
        'debug' => true,
    ];
    
    $pusher = new Pusher\Pusher(
        '5cc2fc15fb480e5b7d1e',
        '5435ee41cf914bdf28e6',
        '2058895',
        $options
    );

    echo "=== Pusher Config ===\n";
    echo "Cluster: ap1\n";
    echo "App ID: 2058895\n";
    echo "TLS: enabled\n\n";

    echo "=== Attempting to trigger event ===\n";
    $data = ['message' => 'Test from debug script', 'timestamp' => time()];
    
    $result = $pusher->trigger('live-chat', 'test-event', $data);
    
    echo "\n=== Result ===\n";
    var_dump($result);
    echo "\nJSON: " . json_encode($result, JSON_PRETTY_PRINT) . "\n";
    
    if (empty($result)) {
        echo "\nWARNING: Empty result returned!\n";
    }
    
} catch (Pusher\PusherException $e) {
    echo "\n=== PUSHER EXCEPTION ===\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n";
} catch (Exception $e) {
    echo "\n=== GENERAL EXCEPTION ===\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
