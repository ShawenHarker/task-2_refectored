<?php
require_once __DIR__ . '/../Controllers/CsvController.php';

use App\Controllers\CsvController;

$num_records = 0;

if (isset($_POST['num_records'])) {
    $num_records = $_POST['num_records'];
}

CsvController::generateCSV($num_records);
?>

<h1>CSV Generator</h1>
<form method="POST">
    <label for="num_records">Number of Records:</label>
    <input type="number" id="num_records" name="num_records" min="1" required>
    <button type="submit">Generate CSV</button>
</form>

<div>

    <?php
    if (isset($_POST['num_records'])) {
        echo 'Generated ' . $num_records . ' records. You may ';
        echo "<a href='output/output.csv'>download</a>";
        echo ' the file, it will be named output.csv';
    }
    ?>
</div>