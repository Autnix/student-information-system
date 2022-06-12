<?php

namespace SIS\App\Validate;

use SIS\App\Response;
use Valitron\Validator;

class Exams
{

    public function saveExams(array $body, array $params): Response
    {

        $v = new Validator($body);

        $v->rule("required", ["exams.*.exam_ratio", "exams.*.exam_name"]);

        $v->rule("integer", "exams.*.exam_ratio")
            ->rule("max", "exams.*.exam_ratio", 100)
            ->rule("min", "exams.*.exam_ratio", 0);

        if (!$v->validate()) {
            return Response::status(400)->json([
                "error" => true,
                "http-message" => "Bad Request",
                "message" => $v->errors()
            ]);
        }
        return Response::next();

    }

    public function saveGrades(array $body, array $params): Response
    {

        $v = new Validator($body);

        $v->rule("required", ['grades.*.student_number', 'grades.*.grade']);

        $v->rule("integer", 'grades.*.grade')
            ->rule("min", "grades.*.grade", 0)
            ->rule("max", "grades.*.grade", 100);

        $v->rule("integer", 'grades.*.student_number');

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