<?php
    require_once "connect-db.php";

    /* Retrieve all trackers */
    function getAllTrackers($db) {
        $request = $db->prepare(
            'SELECT *
            FROM tracker'
        );
        $request->execute();
        
        return $request;
    }

    /* Retrieve a Tracker by tracker code */
    function getTracker($db, $code) {
        $request = $db->prepare(
            'SELECT *
            FROM tracker
            WHERE code = :code'
        );
        $request->bindParam(":code", $code);
        $request->execute();
        
        return $request;
    }

    /* Return boolean if tracker exist or not */
    function trackerExist($db, $code) {
        $request = $db->prepare(
            'SELECT count(*) AS result
            FROM tracker
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

    /* Return boolean if tracker exist or not */
    function trackerExistById($db, $id) {
        $request = $db->prepare(
            'SELECT count(*) AS result
            FROM tracker
            WHERE id = :id'
        );
        $request->bindParam(":id", $id);
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

    /* Insert tracker in DB and return boolean if is successfull or not */
    function createTracker($db, $code) {
        $request = $db->prepare(
            'INSERT INTO tracker(code)
            VALUES(:code)'
        );
        $request->bindParam(":code", $code);
        $request->execute();
        $request->closeCursor();
        
        return $request->rowCount();
    }

    /* Retrieve all logs of a tracker */
    function getTrackerLogs($db, $code) {
        $request = $db->prepare(
            'SELECT tracker.code, log.id, log.clicked_at, log.ip, log.user_agent
            FROM log
            INNER JOIN tracker
            ON log.tracker_id = tracker.id
            WHERE tracker.code = :code
            ORDER BY clicked_at DESC'
        );
        $request->bindParam(":code", $code);
        $request->execute();

        return $request;
    }

    /* Return boolean if tracker logs exist or not */
    function trackerLogsExist($db, $code) {
        $request = $db->prepare(
            'SELECT count(*) AS result
            FROM log
            INNER JOIN tracker
            ON log.tracker_id = tracker.id
            WHERE tracker.code = :code'
        );
        $request->bindParam(":code", $code);
        $request->execute();

        $response = $request->fetch();
        $request->closeCursor();

        $result = (int)$response['result'];
        if($result > 0) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    /* Insert tracker log in DB and return boolean if is successfull or not */
    function addTrackerLog($db, $ip, $userAgent, $code) {
        $request = $db->prepare(
            'INSERT INTO log(ip, user_agent, clicked_at, tracker_id)
            VALUES(:ip, :userAgent, NOW(), :trackerId)'
        );
        $request->bindParam(":ip", $ip);
        $request->bindParam(":userAgent", $userAgent);
        $request->bindParam(":trackerId", $code);
        $request->execute();
        $request->closeCursor();
        
        return $request->rowCount();
    }
