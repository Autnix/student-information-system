<?php

namespace SIS\App\Controller;

use SIS\App\Controller;
use SIS\App\Response;
use SIS\App\Service;

class Exams extends Controller
{

    private Service $ExamsService;

    public function __construct()
    {
        $this->ExamsService = $this->service("Exams");
    }

    public function saveExams($body, $params, $mdData): Response
    {
        $user = $mdData[0]['user'];
        $lesson_id = $params[0];
        $exams = $body['exams'];
        $updatedExams = [];

        $this->ExamsService->clearExams($lesson_id);


        foreach ($exams as $exam) {
            $id = (int)$this->ExamsService->createExam($lesson_id, $exam);
            array_push($updatedExams, $id);
        }

        return Response::status(200)->json($updatedExams);

    }

    public function getExamGrades($body, $params, $mdData): Response
    {

        $grades = $this->ExamsService->getAllGradesByExamLecturer($params[0]);

        return Response::status(200)->json($grades);

    }

    public function saveGrades($body, $params, $mdData): Response
    {

        $grades = $body['grades'];
        $updatedStudents = [];

        foreach ($grades as $grade) {
            $number = (int)$this->ExamsService->saveGrade($params[0], $grade);
            array_push($updatedStudents, $number);
        }

        return Response::status(200)->json($updatedStudents);
    }

}