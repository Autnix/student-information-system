<?php

namespace SIS\App;

class Controller
{

    /**
     * @param string $name
     * @return Service
     */
    protected function service(string $name): Service
    {
        $name = "\\SIS\\App\\Service\\" . $name;
        return new $name();
    }

}