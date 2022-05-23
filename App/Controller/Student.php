<?php

namespace SIS\App\Controller;

use SIS\App\Controller;
use SIS\App\Response;
use SIS\App\Service;

class Student extends Controller
{

    private Service $studentService;

    public function __construct()
    {
        $this->studentService = $this->service("Students");
    }

    public function GetAll($body, $params): Response
    {
        $students = $this->studentService->getAll();
        return Response::status(301)->json($students);
    }

    public function GetOne($body, $params): Response
    {
        $student = $this->studentService->getOneByNumber($params[0]);
        if (!$student) {
            return Response::status(500)->json([
                "error" => true,
                "message" => "Student not found!"
            ]);
        }
        return Response::status(200)->json($student);
    }

}