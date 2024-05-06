<?php

namespace App\Models;

use PDO;
use PDOException;

class CsvModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('sqlite:../app/task-2_refactored.db');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->createTable();
    }

    private function createTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS csv_import (
            id INTEGER PRIMARY KEY,
            name TEXT NOT NULL, 
            surname TEXT NOT NULL,
            initials TEXT NOT NULL, 
            age INTEGER NOT NULL,
            date_of_birth TEXT NOT NULL
        )");
    }

    public function importCsv($csvFile)
    {
        try {
            $csvFileHandle = fopen($csvFile['tmp_name'], 'r');
            if ($csvFileHandle !== false) {
                fgetcsv($csvFileHandle);

                $insertData = $this->pdo->prepare("INSERT INTO csv_import (id, name, surname, initials, age, date_of_birth) VALUES (?, ?, ?, ?, ?, ?)");

                $this->pdo->beginTransaction();
                $batchSize = 100000;
                $num_rows = 0;

                while (($data = fgetcsv($csvFileHandle)) !== false) {
                    $insertData->execute($data);
                    $num_rows++;

                    if ($num_rows % $batchSize === 0) {
                        $this->pdo->commit();
                        $this->pdo->beginTransaction();
                    }
                }

                $this->pdo->commit();

                fclose($csvFileHandle);
                return $num_rows . ' row(s) imported successfully.';
            } else {
                return "Failed to open CSV file.";
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
