<?php
    if(!isset($_GET['id'])) {
        header('Location: 404.php');
        exit();
    } else {
        require 'includes/php/tracker.php';

        $trackerCode = $_GET['id'];
        
        if(trackerExist($db, $trackerCode)) {
            $request = getTracker($db, $trackerCode);
            $data = $request->fetch();
            $request->closeCursor();
        } else {
            header('Location: 404.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking #<?= $data['code']; ?> | Armox IP Logger</title>
    <link rel="stylesheet" href="includes/css/style.css">
</head>
<body>
    <div class="website-container">
        <div class="content">
            <h1>Tracking #<?= $data['code']; ?></h1>
            <div id="result">
                <h3>No Logs found</h3>
            </div>
        </div>
    </div>
    <script src="includes/js/track.js"></script>
</body>
</html>
