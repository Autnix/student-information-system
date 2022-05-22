<?php

namespace SIS\App\Service;

use SIS\App\Database;
use SIS\App\Service;

class Students extends Service
{

    public function getOneByNumber($number)
    {

        $query = Database::$db->prepare("SELECT * FROM students WHERE number = ?");
        $query->execute([$number]);
        return $query->fetch(\PDO::FETCH_ASSOC);

    }

}