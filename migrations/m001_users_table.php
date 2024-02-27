<?php

use app\core\interfaces\Migration;

class m001_users_table implements Migration
{
    public function up(): void
    {
        \app\core\Application::$app->db->pdo->exec(" CREATE TABLE users(
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(225) NOT NULL,
            first_name VARCHAR(225) NOT NULL,
            last_name VARCHAR(225) NOT NULL,
            status TINYINT NOT NULL DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ) engine=INNODB;");
    }

    public function down(): void
    {
        \app\core\Application::$app->db->pdo->exec("Drop TABLE users If EXISTS;");
    }
}