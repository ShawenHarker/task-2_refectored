<?php

namespace App\Models;

require_once __DIR__ . '/../../vendor/autoload.php';

use PDO;
use PDOException;
use Dotenv\Dotenv;

class CsvModel
{
    private $pdo;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $host = $_ENV['DB_HOST'];

        $this->pdo = new PDO($host);
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
                    $data[5] = date('Y-m-d', strtotime($data[5]));
                    $insertData->execute($data);
                    $num_rows++;

                    if ($num_rows % $batchSize === 0) { // checking if the remainder of num_rows divided by batch_size is 0
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
