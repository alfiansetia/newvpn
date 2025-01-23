<?php

namespace App\Services\Mikapi;

class GenerateRandom
{

    private static bool $number = false;
    private static bool $upper = false;
    private static bool $lower = false;

    private static string $char_number = "23456789";
    private static string $char_upper = "ABCDEFGHJKLMNPRSTUVWXYZ";
    private static string $char_lower = "abcdefghijkmnprstuvwxyz";

    public static function withNumber()
    {
        static::$number = true;
        return new self;
    }

    public static function withUpper()
    {
        static::$upper = true;
        return new self;
    }

    public static function withLower()
    {
        static::$lower = true;
        return new self;
    }

    // public static function get(int $length)
    // {
    //     $chars = '';
    //     if (static::$number) {
    //         $chars .= static::$char_number;
    //     }
    //     if (static::$upper) {
    //         $chars .= static::$char_upper;
    //     }
    //     if (static::$lower) {
    //         $chars .= static::$char_lower;
    //     }
    //     if (!static::$number && !static::$upper && static::$lower) {
    //         $chars = static::$char_number . static::$char_upper . static::$char_lower;
    //     }
    //     $charArray = str_split($chars);
    //     $charCount = strlen($chars);
    //     $result = "";
    //     for ($i = 1; $i <= $length; $i++) {
    //         $randChar = rand(0, $charCount - 1);
    //         $result .= $charArray[$randChar];
    //     }
    //     return $result;
    // }

    public static function get(int $length)
    {
        $chars = '';
        $charPool = [];

        if (static::$number) {
            $chars .= static::$char_number;
            $charPool['number'] = str_split(static::$char_number);
        }
        if (static::$upper) {
            $chars .= static::$char_upper;
            $charPool['upper'] = str_split(static::$char_upper);
        }
        if (static::$lower) {
            $chars .= static::$char_lower;
            $charPool['lower'] = str_split(static::$char_lower);
        }

        if (empty($charPool)) {
            $chars = static::$char_number . static::$char_upper . static::$char_lower;
            $charPool = [
                'number' => str_split(static::$char_number),
                'upper' => str_split(static::$char_upper),
                'lower' => str_split(static::$char_lower),
            ];
        }

        $result = [];
        $categories = array_keys($charPool);
        $categoryCount = count($categories);

        $charsPerCategory = intdiv($length, $categoryCount);
        $remaining = $length % $categoryCount;

        foreach ($categories as $index => $category) {
            $count = $charsPerCategory + ($index < $remaining ? 1 : 0);
            for ($i = 0; $i < $count; $i++) {
                $result[] = $charPool[$category][array_rand($charPool[$category])];
            }
        }

        // Acak hasil
        shuffle($result);

        return implode('', $result);
    }
}
