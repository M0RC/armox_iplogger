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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking #<?= $data['code']; ?></title>
    <link rel="stylesheet" href="includes/css/style.css">
</head>
<body>
    <h1>Tracking #<?= $data['code']; ?></h1>
    <table id="logs">
        <tr>
            <th>Date</th>
            <th>IP</th> 
            <th>User Agent</th>
        </tr>
    </table>
    <script src="includes/js/track.js"></script>
</body>
</html>
