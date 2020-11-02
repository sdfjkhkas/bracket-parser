<?php

namespace App;

use InvalidArgumentException;

class Parser
{
    private string $str;

    function __construct(string $str)
    {
        $this->str = $str;
        $this->clean();
        $this->checkValid();
    }

    private function clean(): void
    {
        $this->str = trim($this->str);
    }

    private function checkValid()
    {
        preg_match("/[^)(]+/", $this->str, $matches);
        if (count($matches) != 0)
            throw new InvalidArgumentException("Incorrect symbols!");
    }

    public static function parse(): bool
    {
        $strLength = strlen(self::$str);
        if ((substr_count(self::$str, ')') != substr_count(self::$str, '(')) || ($strLength % 2 === 1)) {
            return false;
        } else {
            if (self::$str[0] === ')' || self::$str[$strLength - 1] === '(') {
                return false;
            }
        }

        $changeCheck = true;
        $lastStrLength = strlen(self::$str);
        while ($changeCheck === true) {
            $strLength = strlen(self::$str);
            self::$str = str_replace('()', '', self::$str);
            $lastStrLength = strlen(self::$str);
            if ($strLength === $lastStrLength || $lastStrLength === 0) {
                $changeCheck = false;
            }
        }

        if (strlen(self::$str) === 0) {
            return true;
        } else {
            return false;
        }
    }
}
