<?php

namespace App\Controllers;

require_once __DIR__ . '/../Models/CsvModel.php';

use App\Models\CsvModel;
use PDOException;

class CsvController
{
    public function upload()
    {
        require_once __DIR__ . '/../Views/UploadFileView.php';

        $status = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (isset($_FILES['csvFile']) && !empty($_FILES['csvFile']['name'])) {
                    $csvModel = new CsvModel();
                    $status = $csvModel->importCsv($_FILES['csvFile']);
                } else {
                    $status = "No file uploaded.";
                }
            } catch (PDOException $e) {
                $status = "Error: " . $e->getMessage();
            }

            header("Location: /?status=" . urlencode($status));
            exit();
        }
    }
}
