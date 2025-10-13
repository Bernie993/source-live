<?php
require __DIR__.'/vendor/autoload.php';

$pusher = new Pusher\Pusher(
    '870a8ef118e6726e65c7',
    'c0ab9e884ca90884ed87',
    '2059701',
    [
        'cluster' => 'mt1',
        'useTLS' => true,
    ]
);

echo "Testing MT1 cluster with NEW credentials...\n";
$result = $pusher->trigger('live-chat', 'test-event', [
    'message' => 'Hello from NEW MT1 app!',
    'timestamp' => time()
]);

echo "Result: " . json_encode($result, JSON_PRETTY_PRINT) . "\n";

if (!empty($result)) {
    echo "\n✅ SUCCESS! MT1 cluster is working!\n";
} else {
    echo "\n⚠️  Warning: Empty result\n";
}
