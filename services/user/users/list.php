<?php
// URL: /users
// Methods: GET, POST
if ($_SERVER['REQUEST_METHOD'] != 'GET' && $_SERVER['REQUEST_METHOD'] != 'POST') {
  header('Content-Type: application/json');
  http_response_code(405);
  echo json_encode(['error' => 'Method not allowed']);
  exit;
}

// Database connection
$pdo = require(__DIR__.'/../db.php');

// GET /users
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $stmt = $pdo->query('SELECT * FROM user;');
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

  header('Content-Type: application/json');
  echo json_encode($users);
  exit;
}

// POST /users
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $input = file_get_contents('php://input');
  $data = json_decode($input, true);
  $firstname = $data['firstname'];
  $lastname = $data['lastname'];
  $username = $data['username'];

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
  exit;
}

?>