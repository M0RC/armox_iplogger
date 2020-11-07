<?php
    require '../../includes/php/tracker.php';
    require '../../includes/php/short-url.php';

    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method) {
        case 'POST':
            if(isset($_POST['url'])) { 
                if(!empty($_POST['url'])) {   
                    if(filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
                        $url = $_POST['url'];
                        $shortUrlCode = substr(md5(uniqid(rand(), true)), 0, 8);
                        $trackerCode = substr(md5(uniqid(rand(), true)), 0, 8);
        
                        while(shortUrlExist($db, $shortUrlCode)) {
                            $shortUrlCode = substr(md5(uniqid(rand(), true)), 0, 8);
                        }
        
                        while(trackerExist($db, $trackerCode) || $trackerCode === $shortUrlCode) {
                            $trackerCode = substr(md5(uniqid(rand(), true)), 0, 8);
                        }
        
                        if(createTracker($db, $trackerCode)) {
                            if(trackerExist($db, $trackerCode)) {
                                $request = getTracker($db, $trackerCode);
                                $data = $request->fetch();
                                $request->closeCursor();

                                if(createShortUrl($db, $url, $shortUrlCode, $data['id'])) {
                                    $response = array(
                                        "shortUrlCode" => $shortUrlCode,
                                        "trackerCode" => $trackerCode
                                    );

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
                                            "message" => "Unable to create short url"
                                        )
                                    );
                                }
                            } else {
                                http_response_code(200);
        
                                header('content-type:application/json');
                                echo json_encode(
                                    array(
                                        "message" => "Unable to create short url"
                                    )
                                );
                            }
                        } else {
                            http_response_code(200);
        
                            header('content-type:application/json');
                            echo json_encode(
                                array(
                                    "message" => "Unable to create tracker"
                                )
                            );
                        }
                    } else {
                        http_response_code(200);
        
                        header('content-type:application/json');
                        echo json_encode(
                            array(
                                "message" => "Invalid URL"
                            )
                        );
                    }
                } else {
                    http_response_code(200);
        
                    header('content-type:application/json');
                    echo json_encode(
                        array(
                            "message" => "Please complete all fields"
                        )
                    );
                }
            } else {
                http_response_code(200);
        
                header('content-type:application/json');
                echo json_encode(
                    array(
                        "message" => "Please complete all fields"
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
