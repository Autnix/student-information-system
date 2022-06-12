<?php

namespace SIS\App\Service;

use SIS\App\Database;
use SIS\App\Service;

class Lessons extends Service
{

    public function createLesson($lesson)
    {
        $insert = Database::$db->prepare(
            "INSERT INTO lessons SET
            lecturer_id=:lecturer_id,
            lesson_akts=:lesson_akts,
            lesson_code=:lesson_code,
            lesson_mandatory_attendance=:lesson_mandatory_attendance,
            lesson_name=:lesson_name,
            lesson_total_attendance=:lesson_total_attendance,
            lesson_allow_registration=:lesson_allow_registration,
            semester_id=:lesson_semester_id"
        );
        $insert->execute($lesson);
        return $insert;
    }

    public function getAllByLecturer($lecturer_id)
    {
        $query = Database::$db->prepare(
            "SELECT * FROM lessons 
            INNER JOIN lecturers l on lessons.lecturer_id = l.lecturer_id 
            INNER JOIN department d on l.department_id = d.department_id
            INNER JOIN faculties f on d.faculty_id = f.faculty_id
            INNER JOIN semesters s on lessons.semester_id = s.semester_id
            WHERE lessons.lecturer_id = ?");
        $query->execute([$lecturer_id]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllByNumber($number)
    {
        $query = Database::$db->prepare("
            SELECT * FROM student_lessons sl
            INNER JOIN lessons l on sl.lesson_id = l.lesson_id
            INNER JOIN semesters s on l.semester_id = s.semester_id
            WHERE sl.student_number = ?"
        );
        $query->execute([$number]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOne($id)
    {
        $query = Database::$db->prepare("
            SELECT * FROM lessons l
            INNER JOIN lecturers l2 on l.lecturer_id = l2.lecturer_id
            WHERE l.lesson_id = ?
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

    public function getAllRegister()
    {
        $query = Database::$db->query("SELECT * FROM lessons INNER JOIN semesters s ON lessons.semester_id = s.semester_id WHERE lesson_allow_registration = 1");
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function registerLesson($id, $number)
    {
        $insert = Database::$db->prepare("INSERT INTO student_lessons SET lesson_id = ?, student_number = ?");
        $insert->execute([$id, $number]);
        return $insert;
    }

}