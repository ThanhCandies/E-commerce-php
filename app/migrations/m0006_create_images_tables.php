<?php


namespace App\migrations;


class m0006_create_images_tables extends \App\core\middlewares\Migration
{

    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS images( 
            id INT AUTO_INCREMENT NOT NULL,
            original_name varchar(255) NOT NULL UNIQUE,
            image varchar(255),
            published boolean default false,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id),
            CONSTRAINT FK_CategoryProduct FOREIGN KEY (category_id) REFERENCES categories(id)
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE products";
        $db->pdo->exec($SQL);
    }
}