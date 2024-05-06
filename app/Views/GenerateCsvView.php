<h1>CSV Generator</h1>
<form method="POST">
    <label for="num_records">Number of Records:</label>
    <input type="number" id="num_records" name="num_records" min="1" required>
    <button type="submit">Generate CSV</button>
</form>

<div>
    <?php
    if (isset($_POST['num_records'])) {
        echo 'Generated ' . $num_records . ' records. ';
        echo "<a href='output/output.csv'>Download</a>";
    }
    ?>
</div>