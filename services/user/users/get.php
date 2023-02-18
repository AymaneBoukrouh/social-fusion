<?php
// GET /users/{id}
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  header('Content-Type: application/json');
  http_response_code(405);
  echo json_encode(['error' => 'Method not allowed']);
  exit;
}

$pdo = require(__DIR__.'/../db.php');
$stmt = $pdo->prepare('SELECT * FROM user WHERE id = ?;');
$stmt->execute([$_GET['id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    header('Content-Type: application/json');
    echo json_encode($user);
} else {
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode(['error' => 'User not found']);
}

?>