<?php

namespace App\Service;

class ValidatorService
{
    public static function validateLength(string $value, int $min, int $max): array
    {
        $length = strlen($value);
        if ($length >= $max || $length <= $min) {
            return [
                'is_valid' => false,
                'message' => "Length can be maximum $max and minimum $min"
            ];
        } else {
            return [
                'is_valid' => true
            ];
        }
    }
}