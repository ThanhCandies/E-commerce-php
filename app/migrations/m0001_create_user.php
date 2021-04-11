<?php

use App\core\Application;

class m0001_create_user
{
	public function up()
	{
		$db = Application::$app->db;
		$SQL = "CREATE TABLE IF NOT EXISTS users(
			id INT AUTO_INCREMENT PRIMARY KEY,
			email VARCHAR(255) NOT NULL UNIQUE,
			firstname VARCHAR(255) NOT NULL,
			lastname VARCHAR(255) NOT NULL,
			username VARCHAR(255) NOT NULL UNIQUE,
			password VARCHAR(255) NOT NULL,
			status TINYINT NOT NULL,
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		) ENGINE=INNODB;";
		$db->pdo->exec($SQL);
	}
	public function down()
	{
		$db = Application::$app->db;
		$SQL = "DROP TABLE users;";
		$db->pdo->exec($SQL);
	}
}
