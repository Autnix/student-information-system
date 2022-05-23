<?php

require "vendor/autoload.php";

use SIS\App\{Router, Config};

ob_start();

Config::load();

require __DIR__ . '/App/Route/route.php';

Router::dispatch();

ob_end_flush();