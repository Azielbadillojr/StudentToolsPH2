<?php
require_once __DIR__.'/../config.php'; header('Content-Type: application/json; charset=utf-8');
if (!current_user()) { http_response_code(401); echo json_encode(['ok'=>false]); exit; }
try { db()->prepare('UPDATE users SET last_seen_at=NOW() WHERE id=? AND status=\'active\'')->execute([current_user()['id']]); echo json_encode(['ok'=>true]); } catch(Throwable $e) { http_response_code(500); echo json_encode(['ok'=>false]); }
