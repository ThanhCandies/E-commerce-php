<?php

use App\core\Application;

class m0008_create_orderdetails_table extends \App\core\middlewares\Migration
{

    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS orderDetails(
			id INT AUTO_INCREMENT PRIMARY KEY,
			order_id int NOT NULL,
			product_id int NOT NULL,
            count tinyint NOT NULL,
            price int NOT NULL,
			CONSTRAINT FK_DetailOrder FOREIGN KEY (order_id) REFERENCES orders(id),
			CONSTRAINT FK_DetailProduct FOREIGN KEY (product_id) REFERENCES products(id)
		) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE orderDetials;";
        $db->pdo->exec($SQL);
    }
}
