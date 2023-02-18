<?php

$host = $_ENV['DB_HOST'];
$name = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

$dsn = "mysql:host=$host;dbname=$name";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false
];

$attempts = 10;
$delay = 1; // seconds

// wait for the database to be ready, which may take a few seconds
while (true) {
  try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    return $pdo;
    break;
  } catch (PDOException $e) {
    if ($attempts-- > 0) {
      sleep($delay);
      continue;
    }
    throw new PDOException($e->getMessage(), (int) $e->getCode());
  }
}

?>