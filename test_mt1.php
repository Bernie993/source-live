<?php
require __DIR__.'/vendor/autoload.php';

$pusher = new Pusher\Pusher(
    '5cc2fc15fb480e5b7d1e',
    '5435ee41cf914bdf28e6',
    '2058895',
    [
        'cluster' => 'mt1',
        'useTLS' => true,
    ]
);

echo "Testing MT1 cluster...\n";
$result = $pusher->trigger('live-chat', 'test-event', [
    'message' => 'Hello from MT1!',
    'timestamp' => time()
]);

echo "Result: " . json_encode($result, JSON_PRETTY_PRINT) . "\n";
echo "\nIf result is not empty, MT1 is working!\n";
