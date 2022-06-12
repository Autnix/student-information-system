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

    public function CreateLesson($body, $params, $mdData): Response
    {
        $user = $mdData[0]['user'];
        $body['lecturer_id'] = $user['lecturer_id'];

        $insertLesson = $this->LessonService->createLesson($body);

        if (!$insertLesson)
            return Response::static(Response::INTERNAL_SERVER_ERROR);
        return Response::status(200)->json(['status' => 200]);
    }

    public function GetLessonsOfLecturer($body, $params, $mdData): Response
    {
        $user = $mdData[0]['user'];
        $lessons = $this->LessonService->getAllByLecturer($user['lecturer_id']);

        if (!$lessons)
            return Response::static(Response::INTERNAL_SERVER_ERROR);
        return Response::status(200)->json($lessons);
    }

    public function GetLessonsOfStudent($body, $params, $mdData)
    {

        $user = $mdData[0]['user'];
        $lessons = $this->LessonService->getAllByNumber($user['student_number']);

        if (!$lessons) {
            return Response::static(Response::INTERNAL_SERVER_ERROR);
        }

        foreach ($lessons as $key => $val) {
            $lessons[$key]['exams'] = $this->ExamService->getExamsByLesson($val['lesson_id'], $user['student_number']) ?? [];
            $lessons[$key]['grades'] = $this->ExamService->getExamGradesByLesson($val['lesson_id'], $user['student_number']) ?? [];
        }

        return Response::status(200)->json($lessons);

    }

    public function GetOneLesson($body, $params, $mdData): Response
    {

        $user = $mdData[0]['user'];

        $lesson = $this->LessonService->getOne($params[0]);
        if (!$lesson)
            return Response::static(Response::INTERNAL_SERVER_ERROR);

        $lesson['absence'] = $this->LessonService->getAbsence($params[0], $user['student_number']);
        $lesson['exams'] = $this->ExamService->getExamsByLesson($params[0]) ?? [];
        $lesson['grades'] = $this->ExamService->getExamGradesByLesson($params[0], $user['student_number']);

        return Response::status(200)->json($lesson);

    }

    public function GetOneLessonLecturer($body, $params, $mdData): Response
    {

        $user = $mdData[0]['user'];

        $lesson = $this->LessonService->getOne($params[0]);
        if (!$lesson)
            return Response::static(Response::INTERNAL_SERVER_ERROR);

        $lesson['exams'] = $this->ExamService->getExamsByLessonLecturer($params[0]) ?? [];
        return Response::status(200)->json($lesson);

    }

    public function GetSemesters($body, $params): Response
    {
        $semesters = $this->LessonService->getSemesters();
        return Response::status(200)->json($semesters);
    }

    public function GetLessonsRegister($body, $params): Response
    {

        $lessons = $this->LessonService->getAllRegister();
        return Response::status(200)->json($lessons);
    }

    public function RegisterLesson($body, $params, $mdData): Response
    {
        $user = $mdData[0]['user'];

        $insert = $this->LessonService->registerLesson($body['lesson_id'], $user['student_number']);

        if (!$insert) {
            return Response::static(Response::INTERNAL_SERVER_ERROR);
        }

        return Response::status(200)->json(['inserted_id' => $body['lesson_id']]);
    }


}