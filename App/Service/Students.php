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

        $query = Database::$db->prepare("SELECT * FROM students WHERE number = ?");
        $query->execute([$number]);
        return $query->fetch(\PDO::FETCH_ASSOC);

    }

    public function getOneByNumberWithDetails($number)
    {
        $query = Database::$db->prepare(
            "SELECT * FROM students s
            INNER JOIN faculty f ON s.faculty_id = f.id
            INNER JOIN department d on s.department_id = d.faculty
            INNER JOIN lecturer l on s.advisor = l.id
            WHERE number = ?"
        );
        $query->execute([$number]);
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function changePassword($number, $password)
    {
        $query = Database::$db->prepare("UPDATE students SET student_password = ? WHERE number = ?");
        $query->execute([$password, $number]);
        return $query;
    }

}