<?php
require __DIR__.'/vendor/autoload.php';

$pusher = new Pusher\Pusher(
    '5cc2fc15fb480e5b7d1e', // key
    '5435ee41cf914bdf28e6', // secret
    '2058895', // app_id
    [
        'cluster' => 'ap1',
        'useTLS' => true
    ]
);

$data = ['message' => 'Test from PHP script'];
$result = $pusher->trigger('live-chat', 'test-event', $data);

echo "Pusher trigger result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";
echo json_encode($result, JSON_PRETTY_PRINT) . "\n";
