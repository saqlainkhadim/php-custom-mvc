<?php


namespace app\core\interfaces;


interface Migration
{
    public function up(): void;

    public function down(): void;

}