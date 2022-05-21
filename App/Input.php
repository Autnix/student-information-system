<?php

namespace SIS\App;

class Input
{

    public static function getJson()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return $data;
    }

}