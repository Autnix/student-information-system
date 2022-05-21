<?php

namespace SIS\App\Service;

use SIS\App\Database;
use SIS\App\Service;

class Logs extends Service
{

    public function getAll(): array
    {

        $logsQr = Database::$db->prepare("SELECT * FROM logs");
        $logsQr->execute();
        return $logsQr->fetchAll(\PDO::FETCH_ASSOC);

    }

}