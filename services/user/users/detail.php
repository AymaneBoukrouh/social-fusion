<?php
// URL: /users/{id}
// Methods: GET, PUT, DELETE
if (
  $_SERVER['REQUEST_METHOD'] != 'GET' &&
  $_SERVER['REQUEST_METHOD'] != 'PUT' &&
  $_SERVER['REQUEST_METHOD'] != 'DELETE'
) {
  header('Content-Type: application/json');
  http_response_code(405);
  echo json_encode(['error' => 'Method not allowed']);
  exit;
}

// Database connection
$pdo = require(__DIR__.'/../db.php');

// get id from url
$id = $_GET['id'];

// GET /users/{id}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $stmt = $pdo->prepare('SELECT * FROM user WHERE id = ?;');
  $stmt->execute([$id]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  header('Content-Type: application/json');
  echo json_encode($user);
  exit;
}

// PUT /users/{id}
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
  // get request body
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

  // update user
  $stmt = $pdo->prepare('UPDATE user SET firstname = ?, lastname = ?, username = ? WHERE id = ?;');
  $stmt->execute([$firstname, $lastname, $username, $id]);

  // get user
  $stmt = $pdo->prepare('SELECT * FROM user WHERE id = ?;');
  $stmt->execute([$id]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  header('Content-Type: application/json');
  echo json_encode($user);
  exit;
}

// DELETE /users/{id}
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  // delete user
  $stmt = $pdo->prepare('DELETE FROM user WHERE id = ?;');
  $stmt->execute([$id]);

  header('Content-Type: application/json');
  echo json_encode(['success' => 'User deleted.']);
  exit;
}

?>