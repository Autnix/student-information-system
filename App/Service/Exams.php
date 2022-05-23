<?php

namespace SIS\App\Service;

use SIS\App\Database;
use SIS\App\Service;

class Exams extends Service
{

    public function getExamsByLesson($lesson_id, $number)
    {
        $query = Database::$db->prepare(
            "SELECT * FROM exams
            INNER JOIN exam_notes ON exams.id = exam_notes.exam_id
            WHERE exams.lesson_id = ? && exam_notes.student_number = ?"
        );
        $query->execute([$lesson_id, $number]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

}