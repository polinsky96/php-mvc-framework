<?php

namespace app\core\form;

use \app\core\Model;

/**
 * Class Form
 * 
 * @package app\core\form
 */
class Form
{   
    public static function begin(string $action, string $method): Form
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end(): void
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute): Field
    {
        return new Field($model, $attribute);
    }
}

