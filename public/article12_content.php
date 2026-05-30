<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
$content = file_get_contents(__DIR__ . '/../uploads/blog/../../storage/app/article12_content.html');
if (!$content) {
    $content = file_get_contents(__DIR__ . '/../article12_content.txt');
}
if ($content) {
    echo json_encode(['content' => $content], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(['error' => 'content not found']);
}
