<?php


namespace app\core\form;


class Form
{
    public static function begin(array $attributes): Form
    {
        $attrs_string = '';
        foreach ($attributes as $key => $value) {
            $attrs_string .= " {$key}=\"{$value}\"";
        }

        echo "<form $attrs_string>";

        return new Form();
    }

    public static function end()
    {
        echo "</form>";
    }

    public function field($model, $attribute)
    {
        return new Field($model, $attribute);
    }

}