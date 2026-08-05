<?php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    $data = $_POST;
}

$log = [
    'time' => date('c'),
    'remote_addr' => $_SERVER['REMOTE_ADDR'] ?? null,
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
    'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
    'payload' => $data,
];

file_put_contents(__DIR__ . '/../verify_human.log', json_encode($log, JSON_PRETTY_PRINT) . "\n", FILE_APPEND | LOCK_EX);

echo json_encode(['ok' => true, 'message' => 'verify_human received']);
exit;
