<?php

require "vendor/autoload.php";

use SIS\App\{Response, Router, Config, Validator};

ob_start();
Config::load();

Router::route("/home")->get("Home@index");

Router::route('/users')->get(function () {
    return Response::status(200)->send("Users Page");
});

Router::route('/system')
    ->middleware('Control@login')
    ->middleware('Control@register')
    ->middleware('Control@logout')
    ->get('Home@mdtest');

Router::route('/login')
    ->middleware(Validator::validate('Account@Login'))
    ->post(function () {
        return Response::send("OK BITTI");
    });

//Router::route("/users")->get("Home@users");
//Router::route("/users/:number/:id")->get("Home@index");
//
//Router::route("/")->post(function () {
//    echo "POST ATTIN";
//});
//
//Router::route("/users/:id")->post("Home@user");
//
Router::prefix("/admin")->group(function () {

    Router::route("/")->get(function () {
        return Response::send("Admin Index");
    });
    Router::route("/run")->get(function () {
        return Response::send("Admin Run");
    });

});

Router::dispatch();
ob_end_flush();