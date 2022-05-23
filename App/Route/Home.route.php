<?php

use SIS\App\{Router};

Router::route("/")->get("Home@Index");
Router::route("/deneme")->get(function () {
    return \SIS\App\Response::status(200)->json(['Message' => 'Hello Vue']);
});

Router::route("/get-details")
    ->middleware("Authentication@authenticate")
    ->get("Home@GetDetails");

Router::route("/test")
    ->middleware("Authentication@authenticate")
    ->middleware("Authentication@admin")
    ->get(function () {
        return \SIS\App\Response::send("OK");
    });