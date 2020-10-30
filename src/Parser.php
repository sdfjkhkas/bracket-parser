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
        preg_match_all("/[^()]+/", $this->str, $matches);
        if (count($matches) != 0)
            throw new InvalidArgumentException("Incorrect symbols!");
    }

    public function parse(): bool
    {
        $strLength = strlen($this->str);
        if ((substr_count($this->str, ')') != substr_count($this->str, '(')) || ($strLength % 2 === 1)) {
            return false;
        } else {
            if ($this->str[0] === ')' || $this->str[$strLength - 1] === '(') {
                return false;
            }
        }

        $changeCheck = true;
        $lastStrLength = strlen($this->str);
        while ($changeCheck === true) {
            $strLength = strlen($this->str);
            $this->str = str_replace('()', '', $this->str);
            $lastStrLength = strlen($this->str);
            if ($strLength === $lastStrLength || $lastStrLength === 0) {
                $changeCheck = false;
            }
        }

        if (strlen($this->str) === 0) {
            return true;
        } else {
            return false;
        }
    }
}