<?php

namespace SIS\App;

class Controller
{

    protected function service($name): Service
    {
        $name = "\\SIS\\App\\Service\\" . $name;
        return new $name();
    }

}