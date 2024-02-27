<?php


namespace app\core;


abstract class DbModel extends Model
{
    abstract public function table(): string;

    abstract public function attributes(): array;

    public function save()
    {
        $tableName = $this->table();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = Application::$app->db->pdo->prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") 
            VALUES (" . implode(",", $params) . ")
        ");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        return $statement->execute();
    }


}