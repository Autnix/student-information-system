<?php

namespace SIS\App;

class Input
{

    /**
     * @return array
     */
    public static function getJson(): array
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return $data ?? [];
    }

}

