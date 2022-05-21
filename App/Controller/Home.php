<?php

namespace SIS\App\Controller;

class Home
{

    public function index($number, $id)
    {
        echo $number . PHP_EOL;
        echo $id . PHP_EOL;
        echo "sa";

    }

    public function users()
    {
        echo "users";
    }

    public function user($body, $params)
    {
        print_r($body);
    }

}