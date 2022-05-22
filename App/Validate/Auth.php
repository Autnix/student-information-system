<?php

namespace SIS\App\Validate;

use SIS\App\Response;
use Valitron\Validator;

class Auth
{

    public function LoginStudent(array $body, array $params): Response
    {

        $v = new Validator($body);
        $v->rule("required", "number")->rule("integer", "number");
        $v->rule("required", "password");

        if (!$v->validate()) {
            return Response::status(400)->json([
                "error" => true,
                "http-message" => "Bad Request",
                "message" => $v->errors()
            ]);
        }
        return Response::next();

    }

}