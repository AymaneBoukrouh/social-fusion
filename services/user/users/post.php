<?php
// POST /users
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Content-Type: application/json');
  http_response_code(405);
  echo json_encode(['error' => 'Method not allowed']);
  exit;
}

$pdo = require(__DIR__.'/../db.php');

// get request body
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];

// check if user exists
$stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?;');
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
  header('Content-Type: application/json');
  http_response_code(409);
  echo json_encode(['error' => 'User already exists.']);
  return;
}

// create user
$stmt = $pdo->prepare('INSERT INTO user (firstname, lastname, username) VALUES (?, ?, ?);');
$stmt->execute([$firstname, $lastname, $username]);

// get user
$stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?;');
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($user);

?>