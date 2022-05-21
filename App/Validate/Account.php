<?php

namespace SIS\App\Validate;

use SIS\App\Input;
use SIS\App\Response;
use SIS\App\Validator;
use Respect\Validation\Validator as v;

class Account
{

    public function Login(array $input): Response
    {

        $validation = v::email()->validate($input['email']);

        if (!$validation)
            return Response::send('false');
        return Response::next();
    }

}