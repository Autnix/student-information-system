<?php

require "vendor/autoload.php";

use SIS\App\{Router, Config};

ob_start();

Config::load();

Router::route("/")->get("Home@Index");
Router::route("/deneme")->get(function () {
    return \SIS\App\Response::status(200)->json(['Message' => 'Hello Vue']);
});

require __DIR__ . '/App/Route/route.php';

Router::dispatch();

ob_end_flush();