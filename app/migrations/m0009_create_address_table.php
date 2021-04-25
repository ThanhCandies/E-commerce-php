<?php

use App\core\Application;

class m0009_create_address_table extends \App\core\middlewares\Migration
{

    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS address(
			id INT AUTO_INCREMENT PRIMARY KEY,
			user_id int NOT NULL,
			address text NOT NULL,
			CONSTRAINT FK_AddressUser FOREIGN KEY (user_id) REFERENCES users(id)
		) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE address;";
        $db->pdo->exec($SQL);
    }
}
