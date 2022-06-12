<?php

namespace SIS\App\Service;

use SIS\App\Database;
use SIS\App\Service;

class Attendances extends Service
{

    public function getAllAttendancesByLesson($lesson_id)
    {

        $query = Database::$db->prepare("SELECT * FROM attendances WHERE lesson_id = ?");
        $query->execute([$lesson_id]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function setAttendance($lesson, $number, $absence)
    {
        $query = Database::$db->prepare("INSERT INTO attendances 
            SET lesson_id = :lesson, student_number = :stnumber, absence = :absence 
            ON DUPLICATE KEY UPDATE absence = :absence");
        $query->execute([
            'lesson' => $lesson,
            'stnumber' => $number,
            'absence' => $absence
        ]);
        return $number;
    }

}