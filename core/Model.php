<?php

namespace app\core;

/**
 * Class Model
 * 
 * @package app\core
 */
abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    
    public array $errors = [];
    
    protected Database $db;
    
    public function __construct() {
        $this->db = Application::$app->db;
    }

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
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = !is_string($rule) ? $rule[0] : $rule;

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
            }
        }

        return empty($this->errors);
    }

    public function hasError(string $attribute): bool
    {
        return array_key_exists($attribute, $this->errors);
    }

    public function getFirstError(string $attribute): string
    {
        return $this->errors[$attribute][0] ?? '';
    }

    protected function addError(string $attribute, string $rule, array $params = []): void
    {
        $message = $this->errorMessages()[$rule] ?? '';

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        
        $this->errors[$attribute][] = $message;
    }

    protected function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This fiels is required',
            self::RULE_EMAIL => 'This field must be valid email adress',
            self::RULE_MIN => 'Min length of this fiels must be {min}',
            self::RULE_MAX => 'Max length of this fiels must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}'
        ];
    }

    abstract public function rules(): array;
}
