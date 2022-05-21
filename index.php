<?php

require "vendor/autoload.php";

use SIS\App\{Router};

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

Router::route("/")->get(function () {
});
Router::route("/users")->get("Home@users");
Router::route("/users/:number/:id")->get("Home@index");

Router::route("/")->post(function () {
    echo "POST ATTIN";
});

Router::route("/users/:id")->post("Home@user");

Router::prefix("/admin")->group(function () {

    Router::route("/?")->get(function () {
        echo "Admin Index";
    });
    Router::route("/run")->get(function () {
        echo "Admin Run";
    });

});

Router::dispatch();