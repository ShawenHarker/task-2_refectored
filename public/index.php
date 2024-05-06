<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Generator</title>
</head>

<body>
    <?php
    require_once __DIR__ . '/../app/App.php';

    use App\App;

    $app = new App();
    $app->run();
