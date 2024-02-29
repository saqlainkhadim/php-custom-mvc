<?php


namespace app\core;


abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MAX = 'max';
    public const RULE_MIN = 'min';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public array $errors;

    abstract public function rules(): array;

    public function loadData(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute} ?? null;
            foreach ($rules as $rule) {
                $ruleName = $rule;

                if (is_array($rule)) {
                    $ruleName = $rule[0];
                    unset($rule[0]);
                }

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {

                    $this->addError($attribute, self::RULE_MIN, $rule);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }

                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }

                if ($ruleName === self::RULE_UNIQUE) {
                    $uniqueAttribute = $rule['attribute'] ?? $attribute;
                    $className = $rule['class'];
                    $tableName = $className::table();
                    $statement = Application::$app->db->prepare("Select EXISTS (Select * From $tableName where $uniqueAttribute = :attr )");
                    $statement->bindValue(':attr', $value);
                    $statement->execute();

                    if($statement->fetchColumn()){
                        $this->addError($attribute, self::RULE_UNIQUE, ['field' => $uniqueAttribute]);
                    }
                }

            }
        }

        return empty($this->errors);
    }

    private function addError(string $attribute, string $rule, ?array $params = []): void
    {
        $message = $this->errorMessages()[$rule] ?? '';

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    private function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email',
            self::RULE_MIN => 'Min length of this filed must be {min}',
            self::RULE_MAX => 'Max length of this filed must be {max}',
            self::RULE_MATCH => 'This filed must be same as {match}',
            self::RULE_UNIQUE => 'Record with this {field} already exists',
        ];
    }

    public function hasError($attribute): bool
    {
        return isset($this->errors[$attribute]) ? true : false;
    }

    public function getFirstError($attribute): string
    {
        return $this->errors[$attribute][0] ?? '';
    }

}