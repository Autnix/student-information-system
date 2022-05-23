<?php

namespace SIS\App\Service;

use SIS\App\Database;
use SIS\App\Service;

class Lecturers extends Service
{

    public function getOneByEmail($email)
    {
        $query = Database::$db->prepare(
            "SELECT * FROM lecturer s
            INNER JOIN faculty f ON s.faculty_id = f.id
            INNER JOIN department d on s.department_id = d.faculty
            WHERE s.email = ?"
        );
        $query->execute([$email]);
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

}