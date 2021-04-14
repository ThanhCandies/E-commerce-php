<?php

use App\core\Application;

class m0003_alter_role_user
{
	public function up()
	{
		$db = Application::$app->db;
		$SQL = "ALTER TABLE users ADD role INT NOT NULL DEFAULT 2;
							ALTER TABLE users
							ADD CONSTRAINT FK_UsersRoles
							FOREIGN KEY (role) REFERENCES roles(id);";
		$db->pdo->exec($SQL);
	}
	public function down()
	{
		$db = Application::$app->db;
		$SQL = "ALTER TABLE users
							DROP FOREIGN KEY FK_UsersRoles,
							DROP KEY role_id;";
		$db->pdo->exec($SQL);
	}
}
