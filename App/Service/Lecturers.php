<?php

namespace SIS\App\Service;

use SIS\App\Database;
use SIS\App\Service;

class Lecturers extends Service
{

    public function getOneByEmail($email)
    {
        $query = Database::$db->prepare(
            "SELECT * FROM lecturers s
            INNER JOIN faculties f ON s.faculty_id = f.faculty_id
            INNER JOIN department d on s.department_id = d.department_id
            WHERE s.lecturer_email = ?"
        );
        $query->execute([$email]);
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

}