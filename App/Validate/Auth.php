<?php

namespace SIS\App\Validate;

use SIS\App\Response;
use Valitron\Validator;

class Auth
{

    public function ChangePasswordStudents(array $body, array $params): Response
    {

        $v = new Validator($body);
        $v->rule("required", "old_password");
        $v->rule("required", "new_password");
        $v->rule("required", "new_password_again");
        $v->rule("equals", "new_password", "new_password_again");
        $v->rule("different", "old_password", "new_password");

        if (!$v->validate()) {
            return Response::status(400)->json([
                "error" => true,
                "http-message" => "Bad Request",
                "message" => $v->errors()
            ]);
        }
        return Response::next();

    }

    public function LoginLecturer(array $body, array $params): Response
    {

        $v = new Validator($body);
        $v->rule("required", "email")->rule("email", "email");
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