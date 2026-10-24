<?php
require_once __DIR__.'/../config.php'; header('Content-Type: application/json; charset=utf-8');
if (!current_user()) { http_response_code(401); echo json_encode(['ok'=>false]); exit; }
$input=json_decode(file_get_contents('php://input'),true) ?: []; $key=$input['tool']??''; $allowed=['grade','gwa','target','pomodoro','planner','schedule','budget','notes','flashcards','countdown'];
if (!in_array($key,$allowed,true)) { http_response_code(400); echo json_encode(['ok'=>false]); exit; }
$stmt=db()->prepare('INSERT INTO tool_usage(user_id,tool_key) VALUES(?,?)'); $stmt->execute([current_user()['id'],$key]); echo json_encode(['ok'=>true]);
