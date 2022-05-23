<?php

namespace SIS\App\Controller;

use SIS\App\Controller;
use SIS\App\Response;
use SIS\App\Service;
use SIS\App\Utils\Helpers;

class Auth extends Controller
{

    private Service $StudentService;

    private Service $LecturerService;

    public function __construct()
    {
        $this->StudentService = $this->service("Students");
        $this->LecturerService = $this->service("Lecturers");
    }

    public function changePasswordStudent($body, $params, $mdData): Response
    {

        $user = $mdData[0]['user'];

        $student = $this->StudentService->getOneByNumberWithDetails($user['number']);

        if (!$student) {
            return Response::status(500)->json([
                "error" => true,
                'message' => [
                    'error' => ["Student not found!"]
                ]
            ]);
        }

        $hash = Helpers::passwordToHash($body['old_password']);

        if ($hash !== $student['student_password']) {
            return Response::status(403)->json([
                'error' => true,
                'http-message' => "Forbidden",
                'message' => [
                    'error' => ["Current Password is wrong!"]
                ]
            ]);
        }

        $pwHash = Helpers::passwordToHash($body['new_password']);
        $newStudent = $this->StudentService->changePassword($user['number'], $pwHash);

        if (!$newStudent) {
            return Response::status(500)->json([
                "error" => true,
                'message' => [
                    'error' => ["Internal Server Error"]
                ]
            ]);
        }

        return Response::status(200)->json([
            'message' => "OK!"
        ]);

    }

    public function LoginLecturer(array $body, array $params): Response
    {
        $lec = $this->LecturerService->getOneByEmail($body['email']);

        if (!$lec) {
            return Response::status(500)->json([
                "error" => true,
                "message" => "Lecturer not found!"
            ]);
        }

        $hash = Helpers::passwordToHash($body['password']);

        if ($hash !== $lec['lecturer_password']) {
            return Response::status(403)->json([
                'error' => true,
                'http-message' => "Forbidden",
                'message' => [
                    'error' => ["Password is wrong!"]
                ]
            ]);
        }

        unset($lec['lecturer_password']);
        $token = Helpers::generateAccessToken($lec, 1);

        return Response::status(200)->json([
            'user' => $lec,
            'token' => $token,
            'rank' => 1
        ]);
    }

    /**
     * @param array $body
     * @param array $params
     * @return Response
     */
    public function LoginStudent(array $body, array $params): Response
    {

        $student = $this->StudentService->getOneByNumberWithDetails($body['number']);

        if (!$student) {
            return Response::status(500)->json([
                "error" => true,
                'message' => [
                    'error' => ["Student not found!"]
                ]
            ]);
        }

        $hash = Helpers::passwordToHash($body['password']);

        if ($hash !== $student['student_password']) {
            return Response::status(403)->json([
                'error' => true,
                'http-message' => "Forbidden",
                'message' => [
                    'error' => ["Password is wrong!"]
                ]
            ]);
        }

        unset($student['student_password']);
        $token = Helpers::generateAccessToken($student, 0);

        return Response::status(200)->json([
            'user' => $student,
            'token' => $token,
            'rank' => 0
        ]);

    }


}