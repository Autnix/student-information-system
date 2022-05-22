<?php

namespace SIS\App\Controller;

use SIS\App\Controller;
use SIS\App\Response;
use SIS\App\Service;
use SIS\App\Utils\Helpers;

class Auth extends Controller
{

    /**
     * @param array $body
     * @param array $params
     * @return Response
     */
    public function LoginStudent(array $body, array $params): Response
    {

        $StudentService = $this->service("Students");
        $student = $StudentService->getOneByNumber($body['number']);

        if (!$student) {
            return Response::status(500)->json([
                "error" => true,
                "message" => "Student not found!"
            ]);
        }

        $hash = Helpers::passwordToHash($body['password']);

        if ($hash !== $student['password']) {
            return Response::status(403)->json([
                'error' => true,
                'http-message' => "Forbidden",
                'message' => "Password is wrong!"
            ]);
        }

        unset($student['password']);
        $token = Helpers::generateAccessToken($student);

        return Response::status(200)->json([
            'user' => $student,
            'token' => $token
        ]);

    }


}