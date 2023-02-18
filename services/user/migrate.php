<?php

// connect to the database
$pdo = require(__DIR__.'/db.php');

// create migration table if not exists
$check = $pdo->query("SHOW TABLES LIKE 'migration'");
if ($check->rowCount() == 0) {
  // create migration table
  $pdo->query("CREATE TABLE migration (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB;");
}

// get applied migrations
$applied = $pdo->query("SELECT name FROM migration")->fetchAll(PDO::FETCH_COLUMN);

// get migration files
$migrations = scandir(__DIR__.'/migrations');
foreach ($migrations as $migration) {
  // skip . and .. directories
  if ($migration == '.' || $migration == '..')
    continue;

  // skip if already applied
  if (in_array($migration, $applied))
    continue;
  
  // apply migration
  $pdo->query(file_get_contents(__DIR__.'/migrations/'.$migration));
  $pdo->query("INSERT INTO migration (name) VALUES ('$migration')");
}

?>