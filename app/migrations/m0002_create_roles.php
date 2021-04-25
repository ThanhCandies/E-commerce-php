<?php

use App\core\Application;

class m0002_create_roles
{
	public function up()
	{
		$db = Application::$app->db;
		$SQL = "CREATE TABLE IF NOT EXISTS roles(
			id INT AUTO_INCREMENT PRIMARY KEY,
			`role` VARCHAR(255) NOT NULL UNIQUE,
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		) ENGINE=INNODB;";
		$db->pdo->exec($SQL);
	}
	public function down()
	{
		$db = Application::$app->db;
		$SQL = "DROP TABLE roles;";
		$db->pdo->exec($SQL);
	}
}
