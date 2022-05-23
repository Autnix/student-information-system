<?php

namespace SIS\App\Service;

use SIS\App\Database;
use SIS\App\Service;

class Lessons extends Service
{

    public function getAllByNumber($number)
    {
        $query = Database::$db->prepare("
            SELECT * FROM student_lessons sl
            INNER JOIN lessons l on sl.lesson_id = l.id
            INNER JOIN semesters s on sl.semester_id = s.id
            WHERE sl.student_number = ?"
        );
        $query->execute([$number]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOne($id)
    {
        $query = Database::$db->prepare("
            SELECT * FROM lessons l
            INNER JOIN lecturer l2 on l.lecturer = l2.id
            WHERE l.id = ?
        ");
        $query->execute([$id]);
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAbsence($id, $number)
    {
        $query = Database::$db->prepare(
            "SELECT absence FROM attendances
            WHERE lesson_id = ? && student_number = ?");
        $query->execute([$id, $number]);
        $absence = $query->fetch(\PDO::FETCH_ASSOC);
        return $absence['absence'] ?? "0";
    }

    public function getSemesters()
    {
        $query = Database::$db->query("SELECT * FROM semesters");
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

}