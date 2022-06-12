<?php

namespace SIS\App\Service;

use SIS\App\Database;
use SIS\App\Service;

class Students extends Service
{

    public function getAll()
    {
        $query = Database::$db->query("SELECT * FROM students");
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOneByNumber($number)
    {

        $query = Database::$db->prepare("SELECT * FROM students WHERE student_number = ?");
        $query->execute([$number]);
        return $query->fetch(\PDO::FETCH_ASSOC);

    }

    public function getOneByNumberWithDetails($number)
    {
        $query = Database::$db->prepare(
            "SELECT * FROM students s
            INNER JOIN faculties f ON s.faculty_id = f.faculty_id
            INNER JOIN department d ON s.department_id = d.department_id
            INNER JOIN lecturers l ON s.student_advisor = l.lecturer_id
            WHERE s.student_number = ?"
        );

        $query->execute([$number]);
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function changePassword($number, $password)
    {
        $query = Database::$db->prepare("UPDATE students SET student_password = ? WHERE student_number = ?");
        $query->execute([$password, $number]);
        return $query;
    }

    public function getAllByLesson($lessonId)
    {
        $query = Database::$db->prepare("SELECT * FROM student_lessons SL INNER JOIN students S ON SL.student_number = S.student_number WHERE SL.lesson_id = ?");
        $query->execute([$lessonId]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

}