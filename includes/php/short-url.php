<?php
    require_once "connect-db.php";

    /* Retrieve all short urls */
    function getAllShortUrls($db) {
        $request = $db->prepare(
            'SELECT *
            FROM short_url'
        );
        $request->execute();
        
        return $request;
    }

    /* Retrieve a short url by short url code */
    function getShortUrl($db, $code) {
        $request = $db->prepare(
            'SELECT *
            FROM short_url
            WHERE code = :code'
        );
        $request->bindParam(":code", $code);
        $request->execute();
        
        return $request;
    }

    /* Return boolean if short url exist or not exist */
    function shortUrlExist($db, $code) {
        $request = $db->prepare(
            'SELECT count(*) AS result
            FROM short_url
            WHERE code = :code'
        );
        $request->bindParam(":code", $code);
        $request->execute();

        $response = $request->fetch();
        $request->closeCursor();

        $result = (int)$response['result'];
        if($result === 1) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    /* Insert short URL in DB and return boolean if is successfull or not */
    function createShortUrl($db, $url, $code, $trackerId) {
        $request = $db->prepare(
            'INSERT INTO short_url(url, code, tracker_id)
            VALUES(:url, :code, :trackerId)'
        );
        $request->bindParam(":url", $url);
        $request->bindParam(":code", $code);
        $request->bindParam(":trackerId", $trackerId);
        $request->execute();
        $request->closeCursor();
        
        return $request->rowCount();
    }
