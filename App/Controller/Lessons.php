<?php

namespace SIS\App\Controller;

use SIS\App\Controller;
use SIS\App\Response;
use SIS\App\Service;

class Lessons extends Controller
{

    private Service $LessonService;
    private Service $ExamService;

    public function __construct()
    {
        $this->LessonService = $this->service("Lessons");
        $this->ExamService = $this->service("Exams");
    }

    public function GetLessonsOfStudent($body, $params, $mdData)
    {

        $user = $mdData[0]['user'];
        $lessons = $this->LessonService->getAllByNumber($user['number']);

        if (!$lessons) {
            return Response::static(Response::INTERNAL_SERVER_ERROR);
        }

        foreach ($lessons as $key => $val) {
            $exams = $this->ExamService->getExamsByLesson($val['lesson_id'], $user['number']);
            $lessons[$key]['exams'] = $exams ?? [];
        }

        return Response::status(200)->json($lessons);

    }

    public function GetOneLesson($body, $params, $mdData): Response
    {

        $user = $mdData[0]['user'];

        $lesson = $this->LessonService->getOne($params[0]);
        if (!$lesson)
            return Response::static(Response::INTERNAL_SERVER_ERROR);

        $lesson['absence'] = $this->LessonService->getAbsence($params[0], $user['number']);
        $lesson['exams'] = $this->ExamService->getExamsByLesson($params[0], $user['number']) ?? [];

        return Response::status(200)->json($lesson);

    }

    public function GetSemesters($body, $params): Response
    {
        $semesters = $this->LessonService->getSemesters();
        return Response::status(200)->json($semesters);
    }

}