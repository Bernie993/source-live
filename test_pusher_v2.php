<?php
require __DIR__.'/vendor/autoload.php';

try {
    $options = [
        'cluster' => 'ap1',
        'useTLS' => true,
        'curl_options' => [
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 10,
        ]
    ];
    
    $pusher = new Pusher\Pusher(
        '5cc2fc15fb480e5b7d1e',
        '5435ee41cf914bdf28e6',
        '2058895',
        $options
    );

    echo "Attempting to trigger event...\n";
    $result = $pusher->trigger('live-chat', 'test-event', ['message' => 'Test']);
    
    echo "Result: " . json_encode($result, JSON_PRETTY_PRINT) . "\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
