<?php
// PUT /users/{id}
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
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
    $input = json_decode(file_get_contents('php://input'), true);
    $sql = "UPDATE user SET name = :name, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $input['name'], 'email' => $input['email'], 'id' => $_GET['id']]);
    header('Content-Type: application/json');
    echo json_encode($input);
} else {
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode(['error' => 'User not found']);
}

?>