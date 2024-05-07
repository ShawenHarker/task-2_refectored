<?php

namespace App\Controllers;

class GenerateCsvController
{
    public static function generateCSV($num_records)
    {
        $names = array("John", "Emma", "Michael", "Sophia", "William", "Olivia", "James", "Ava", "Benjamin", "Isabella", "Jacob", "Mia", "Ethan", "Charlotte", "Alexander", "Amelia", "Henry", "Harper", "Daniel", "Evelyn");
        $surnames = array("Smith", "Johnson", "Williams", "Jones", "Brown", "Davis", "Miller", "Wilson", "Moore", "Taylor", "Anderson", "Thomas", "Jackson", "White", "Harris", "Martin", "Thompson", "Garcia", "Martinez", "Robinson");

        set_time_limit(0);

        $outputFolder = __DIR__ . '/../../public/output/';

        if (!file_exists($outputFolder)) {
            mkdir($outputFolder, 755, true);
        }

        $fileName = 'output.csv';
        $outputPath = $outputFolder . $fileName;
        $output = fopen($outputPath, 'w');

        if (!$output) {
            echo "Failed to open output file: $outputPath";
            return;
        }

        $header = array("ID", "Name", "Surname", "Initials", "Age", "DateOfBirth");
        fputcsv($output, $header);

        function isRecordGenerated($record)
        {
            static $generatedRecords = [];

            if (in_array($record, $generatedRecords)) {
                return true;
            }

            $generatedRecords[] = $record;
            return false;
        }

        function getRandomDOB($age)
        {
            $currentYear = date('Y');

            $randomDay = mt_rand(1, 28);
            $randomMonth = mt_rand(1, 12);

            $randomDOB = date("d/m/Y", mktime(0, 0, 0, $randomMonth, $randomDay, $currentYear - $age));

            return $randomDOB;
        }

        for ($i = 0; $i < $num_records; $i++) {
            $id = $i + 1;

            do {
                $name = $names[array_rand($names)];
                $surname = $surnames[array_rand($surnames)];
                $initials = $name[0];
                $age = rand(1, 100);
                $dob = getRandomDOB($age);
                $record = "$name,$surname,$age,$dob";
            } while (isRecordGenerated($record));

            $data = array($id, $name, $surname, $initials, $age, $dob);
            fputcsv($output, $data);
        }

        fclose($output);
    }
}
