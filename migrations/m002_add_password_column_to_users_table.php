<?php

use app\core\interfaces\Migration;

class m002_add_password_column_to_users_table implements Migration
{
    public function up(): void
    {
        echo "migration code" . PHP_EOL;
    }

    public function down(): void
    {
        echo "migration down code" . PHP_EOL;
    }
}