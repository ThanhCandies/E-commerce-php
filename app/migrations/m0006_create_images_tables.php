<?php

use App\core\Application;

class m0006_create_images_tables extends \App\core\middlewares\Migration
{

    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS images( 
            id INT AUTO_INCREMENT NOT NULL,
            original_name varchar(255) NOT NULL,
           	url varchar(255),
            size int default 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id)
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE images";
        $db->pdo->exec($SQL);
    }
}