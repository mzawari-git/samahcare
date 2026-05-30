<?php
$content = file_get_contents('C:\Users\Home\Downloads\article12_formatted.txt');
echo json_encode(['content' => $content]);
