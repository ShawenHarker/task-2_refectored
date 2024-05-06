<h3>Upload your CSV file here</h3>

<form method="POST" enctype="multipart/form-data">
    <label for="uploadFile">Upload CSV file:</label>
    <input type="file" id="uploadFile" name="csvFile" required>
    <input type="submit" name="submit" value="Upload">
</form>

<div>
    <?php echo isset($_GET['status']) ? urldecode($_GET['status']) : ''; ?>
</div>