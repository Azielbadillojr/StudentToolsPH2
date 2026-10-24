<?php
// Local XAMPP defaults. Change these if your MySQL credentials differ.
const DB_HOST = '127.0.0.1';
const DB_NAME = 'student_tools_ph';
const DB_USER = 'root';
const DB_PASS = '';
const ONLINE_WINDOW_SECONDS = 120; // User is considered online if their heartbeat was within 2 minutes.

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS'])]);
    session_start();
}

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
    return $pdo;
}
function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function current_user(): ?array { return $_SESSION['user'] ?? null; }
function require_login(): void {
    if (!current_user()) { header('Location: login.php'); exit; }
}
function require_admin(): void {
    require_login();
    if ((current_user()['role'] ?? '') !== 'admin') { http_response_code(403); exit('Access denied. Admin account required.'); }
}
function log_event(?int $userId, string $type, ?string $details = null): void {
    $stmt = db()->prepare('INSERT INTO activity_logs (user_id,event_type,details) VALUES (?,?,?)');
    $stmt->execute([$userId, $type, $details]);
}
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}
function verify_csrf(): void {
    $sent = $_POST['csrf_token'] ?? '';
    if (!is_string($sent) || !hash_equals(csrf_token(), $sent)) { http_response_code(419); exit('Session token expired. Refresh and try again.'); }
}
