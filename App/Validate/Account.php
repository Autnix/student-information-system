<?php

namespace SIS\App\Validate;

use SIS\App\Input;
use SIS\App\Response;
use SIS\App\Validator;

class Account
{

    public function Login(array $body, array $params): Response
    {

        $v = new \Valitron\Validator($body);
        $v->rule('required', 'email')->rule('email', 'email');
        $v->rule('required', 'number')->rule('integer', 'number');

        if (!$v->validate())
            return Response::status(400)->json([
                'error' => true,
                'message' => $v->errors()
            ]);
        return Response::next();
    }

}