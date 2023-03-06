<?php

namespace App\Utils;

class Censurator
{
    const CENSURED_WORDS = ['prout', 'zut', 'bordel'];

    public function purify($string)
    {
            return str_ireplace(self::CENSURED_WORDS, '*****', $string);
    }
}
