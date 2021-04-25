<?php

use App\core\Application;

class m0007_create_orders_table extends \App\core\middlewares\Migration
{

    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS orders(
			id INT AUTO_INCREMENT PRIMARY KEY,
			user_id int NOT NULL,
			status TINYINT NOT NULL DEFAULT 1,
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			CONSTRAINT FK_OrderUser FOREIGN KEY (user_id) REFERENCES users(id)
		) ENGINE=INNODB;
        CREATE TABLE IF NOT EXISTS orderHistories(
			id INT AUTO_INCREMENT PRIMARY KEY,
			order_id int NOT NULL,
			status TINYINT NOT NULL DEFAULT 1,
			message TEXT,
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			CONSTRAINT FK_HistoryOrder FOREIGN KEY (order_id) REFERENCES orders(id)
		) ENGINE=INNODB;
        DROP TRIGGER IF EXISTS trg_order;
        CREATE TRIGGER trg_order  AFTER UPDATE on orders FOR EACH ROW
        BEGIN
            INSERT INTO orderhistories
            (order_id,status,message) values (NEW.id,NEW.status,NEW.message);
            END;
        DROP TRIGGER IF EXISTS trg_order_update;
        CREATE TRIGGER trg_order_update  AFTER UPDATE on orders FOR EACH ROW
                BEGIN
                    INSERT INTO orderhistories
                    (order_id,status,message) values (NEW.id,NEW.status,NEW.message);
                    END;
		";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE orders;
                DROP TABLE orderHistories;
                DROP TRIGGER trg_order;
                DROP TRIGGER trg_order_update;
                ";
        $db->pdo->exec($SQL);
    }
}
