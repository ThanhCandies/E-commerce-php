<?php
use App\core\Application;
use App\core\middlewares\Migration;

class m0005_create_products_table extends Migration
{

    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS products( 
            id INT AUTO_INCREMENT NOT NULL,
            name varchar(255) NOT NULL UNIQUE,
            price int NOT NULL DEFAULT 0,
            sold int Default 0,
            category_id int,
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