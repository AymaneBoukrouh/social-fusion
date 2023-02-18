<?php
// GET /users
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  header('Content-Type: application/json');
  http_response_code(405);
  echo json_encode(['error' => 'Method not allowed']);
  exit;
}

$pdo = require(__DIR__.'/../db.php');
$stmt = $pdo->query('SELECT * FROM user;');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($users);

?>