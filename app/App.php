<?php

namespace App;

require_once __DIR__ . '/Controllers/GenerateCsvController.php';
require_once __DIR__ . '/Controllers/CsvController.php';

use App\Controllers\GenerateCsvController;
use App\Controllers\CsvController;

class App
{
    public static function run()
    {
        $names = array("John", "Emma", "Michael", "Sophia", "William", "Olivia", "James", "Ava", "Benjamin", "Isabella", "Jacob", "Mia", "Ethan", "Charlotte", "Alexander", "Amelia", "Henry", "Harper", "Daniel", "Evelyn");
        $surnames = array("Smith", "Johnson", "Williams", "Jones", "Brown", "Davis", "Miller", "Wilson", "Moore", "Taylor", "Anderson", "Thomas", "Jackson", "White", "Harris", "Martin", "Thompson", "Garcia", "Martinez", "Robinson");
        $num_records = 0;

        if (isset($_POST['num_records'])) {
            $num_records = $_POST['num_records'];
        }

        $generateController = new GenerateCsvController();
        $generateController->generateCSV($num_records, $names, $surnames);

        $csvController = new CsvController();
        $csvController->upload();
    }
}
