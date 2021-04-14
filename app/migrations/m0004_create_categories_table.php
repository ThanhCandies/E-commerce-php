<?php
use App\core\Application;

class m0004_create_categories_table extends \App\core\middlewares\Migration
{

    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS categories( 
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            name varchar(255) NOT NULL UNIQUE,
            published boolean default false,
            image varchar(255),
            description varchar(510),
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db=Application::$app->db;
        $SQL = "DROP TABLE categories";
        $db->pdo->exec($SQL);
    }
}