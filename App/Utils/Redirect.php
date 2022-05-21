<?php

namespace SIS\App\Utils;

use SIS\App\Config;

class Redirect
{

    public static function to(string $to, int $status = 301)
    {
        header('location: ' . Config::getenv('BASE_PATH') . $to, true, $status);
        exit();
    }

}