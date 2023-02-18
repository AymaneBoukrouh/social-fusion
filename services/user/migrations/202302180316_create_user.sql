-- migrations/202302180316_create_user.sql

CREATE TABLE user (
  id INT PRIMARY KEY AUTO_INCREMENT,
  firstname VARCHAR(32) NOT NULL,
  lastname VARCHAR(32) NOT NULL,
  username VARCHAR(32) NOT NULL UNIQUE
) ENGINE=InnoDB;
