<?php
/**
 * Created by PhpStorm.
 * User: jefdc
 * Date: 2018-12-04
 * Time: 16:48
 */

namespace App\Service;


class Slugify
{
    public function generate(string $input) : string
    {
       $special = array('é', 'è', 'ç', 'à', 'ê', 'â', 'û', 'ù', 'ô', " ", "!", ":","'", ",", "?");
       $replace = array('e', 'e', 'c', 'a', 'e', 'a', 'u', 'u', 'o', "-", "","", "","","","");
       $input = trim(strip_tags($input));
       $input = str_replace($special, $replace, $input);

       return $input;
    }
}