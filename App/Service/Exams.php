<?php

namespace SIS\App\Service;

use SIS\App\Database;
use SIS\App\Service;

class Exams extends Service
{

    public function getExamGradesByLesson($lesson_id, $number)
    {
        $query = Database::$db->prepare(
            "SELECT * FROM exams
            INNER JOIN exam_notes ON exams.exam_id = exam_notes.exam_id
            WHERE exams.lesson_id = ? && exam_notes.student_number = ?"
        );
        $query->execute([$lesson_id, $number]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getExamsByLesson($lesson_id)
    {
        $query = Database::$db->prepare(
            "SELECT * FROM exams
            WHERE exams.lesson_id = ?"
        );
        $query->execute([$lesson_id]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getExamsByLessonLecturer($lesson_id)
    {
        $query = Database::$db->prepare(
            "SELECT * FROM exams
            WHERE exams.lesson_id = ?"
        );
        $query->execute([$lesson_id]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function clearExams($lesson_id)
    {
        $query = Database::$db->prepare("DELETE FROM exams WHERE lesson_id = ?");
        $query->execute([$lesson_id]);
        return $query;
    }

    public function createExam(int $lesson_id, array $exam)
    {
        $exam['lesson_id'] = $lesson_id;

        $query = Database::$db->prepare("INSERT INTO exams SET 
                      exam_name = :exam_name,
                      exam_ratio = :exam_ratio,
                      lesson_id = :lesson_id");
        $query->execute($exam);
        return Database::$db->lastInsertId();
    }

    public function getAllGradesByExamLecturer($exam_id)
    {
        $query = Database::$db->prepare("SELECT * FROM exam_notes WHERE exam_id = ?");
        $query->execute([$exam_id]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function saveGrade($exam_id, $grade)
    {
        $query = Database::$db->prepare("INSERT INTO exam_notes SET student_number = :stnumber, exam_id = :exam, note = :note ON DUPLICATE KEY UPDATE note = :note");
        $query->execute([
            'stnumber' => $grade['student_number'],
            'note' => $grade['grade'],
            'exam' => $exam_id
        ]);
        return $grade['student_number'];
    }

}