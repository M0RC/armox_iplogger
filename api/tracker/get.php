<?php
    require '../../includes/php/tracker.php';

    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method) {
        case 'GET':
            if(isset($_GET['tracker'])) {    
                $trackerCode = $_GET['tracker'];
        
                if(trackerExist($db, $trackerCode)) {
                    if(trackerLogsExist($db, $trackerCode)) {
                        $request = getTrackerLogs($db, $trackerCode);
                        while($data = $request->fetch()) {
                            $log['id'] = $data['id'];
                            $log['ip'] = htmlspecialchars($data['ip']);
                            $log['userAgent'] = htmlspecialchars($data['user_agent']);
                            $log['clickedAt'] = htmlspecialchars($data['clicked_at']);
                            $response[] = $log;
                        }
    
                        $request->closeCursor();

                        http_response_code(200);
            
                        header('content-type:application/json');
                        echo json_encode(
                            array(
                                "message" => "Success",
                                "response" => $response
                            )
                        );
                    } else {
                        http_response_code(200);
            
                        header('content-type:application/json');
                        echo json_encode(
                            array(
                                "message" => "No logs found"
                            )
                        );
                    }
                } else {
                    http_response_code(404);
        
                    header('content-type:application/json');
                    echo json_encode(
                        array(
                            "message" => "Invalid tracker"
                        )
                    );
                }
            } else {
                http_response_code(404);
        
                header('content-type:application/json');
                echo json_encode(
                    array(
                        "message" => "Invalid tracker"
                    )
                );
            }

            break;
        default:
            http_response_code(405);
            
            header('content-type:application/json');
            echo json_encode(
                array(
                    "message" => "Method Not Allowed"
                )
            );

            break;
    }
    