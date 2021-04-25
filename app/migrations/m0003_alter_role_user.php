<?php

use App\core\Application;

class m0003_alter_role_user
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "ALTER TABLE users
							ADD CONSTRAINT FK_UserRole
							FOREIGN KEY (role_id) REFERENCES roles(id);";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "ALTER TABLE users
							DROP FOREIGN KEY FK_UserRole";
        $db->pdo->exec($SQL);
    }
}
