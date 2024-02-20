<?php

use app\core\interfaces\Migration;

class m002_add_password_column_to_users_table implements Migration
{
    public function up(): void
    {
        \app\core\Application::$app->db->pdo->exec("Alter TABLE users add column password varchar(225) Not null;");
    }

    public function down(): void
    {
        \app\core\Application::$app->db->pdo->exec("Alter TABLE users Drop column password;");
    }
}