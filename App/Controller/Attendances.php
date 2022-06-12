<?php

namespace SIS\App\Controller;

use SIS\App\Controller;
use SIS\App\Response;

class Attendances extends Controller
{

    public \SIS\App\Service\Attendances $AttendancesService;

    public function __construct()
    {
        $this->AttendancesService = $this->service("Attendances");
    }

    function getAttendancesByLesson(array $body, array $params, array $mdData)
    {

        $lesson_id = $params[0];

        $attendances = $this->AttendancesService->getAllAttendancesByLesson($lesson_id);

        return Response::status(200)->json($attendances);

    }

    public function saveAttendances($body, $params, $mdData): Response
    {

        $attendances = $body['attendances'];
        $updatedStudents = [];

        foreach ($attendances as $attendance) {
            $number = (int)$this->AttendancesService->setAttendance($params[0], $attendance['student_number'], $attendance['absence']);
            array_push($updatedStudents, $number);
        }

        return Response::status(200)->json($updatedStudents);
    }

}