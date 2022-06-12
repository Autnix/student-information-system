<?php

namespace SIS\App\Validate;

use SIS\App\Response;
use Valitron\Validator;

class Attendances
{

    public function saveAttendances(array $body, array $params): Response
    {

        $v = new Validator($body);

        $v->rule("required", ['attendances.*.student_number', 'attendances.*.absence']);

        $v->rule("integer", 'attendances.*.absence')
            ->rule("min", "attendances.*.absence", 0);

        $v->rule("integer", 'attendances.*.student_number');

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