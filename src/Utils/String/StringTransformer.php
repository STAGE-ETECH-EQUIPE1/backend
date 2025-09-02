<?php

namespace App\Utils\String;

class StringTransformer
{
    public static function snakeToCamel(string $snakeCase): string
    {
        return lcfirst(str_replace('_', '', ucwords($snakeCase, '_')));
    }

    public static function camelToSnake(string $camelCase): string
    {
        return strtolower((string) preg_replace('/(?<!^)[A-Z]/', '_$0', $camelCase));
    }
}
