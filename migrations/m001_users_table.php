<?php

use app\core\interfaces\Migration;

class m001_users_table implements Migration
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