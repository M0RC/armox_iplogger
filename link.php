<?php
    if(isset($_GET['id'])) {
        require 'includes/php/url-shortener.php';
        require 'includes/php/tracker.php';

        $shortUrlCode = $_GET['id'];

        if(shortUrlExist($db, $shortUrlCode)) {
            $request = getShortUrl($db, $shortUrlCode);
            $data = $request->fetch();
            $request->closeCursor();

            if(trackerExistById($db, $data['tracker_id'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
                $userAgent = $_SERVER['HTTP_USER_AGENT'];

                if(addTrackerLog($db, $ip, $userAgent, $data['tracker_id'])) {
                    header('Location: ' . htmlspecialchars($data['url']));
                    exit();
                } else {
                    header('Location: 404.php');
                }
            } else {
                header('Location: 404.php');
                exit();
            }
        } else {
            header('Location: 404.php');
            exit();
        }
    } else {
        header('Location: 404.php');
        exit();
    }
