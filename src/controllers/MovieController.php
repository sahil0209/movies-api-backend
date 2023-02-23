<?php

class MovieController
{
    private $movieGateway = null;
    public function __construct($movieGateway)
    {
        $this->movieGateway = $movieGateway;
    }

    public function handleRequest($method, $id)
    {
        if ($id !== null) {
            $this->procressResourceRequest($method, $id);
        } else {
            $this->processRequest($method);
        }
    }

    public function processRequest($method)
    {
        // echo $method;
        switch ($method) {
            case 'GET': {
                    $response = $this->movieGateway->index();

                    echo json_encode($response);
                    break;
                }
            case 'POST': {
                    $movie = (array) json_decode(file_get_contents('php://input'), true); // true to convert into associative array

                    $response = $this->movieGateway->create($movie);
                    if ($response) {
                        http_response_code(201);
                        echo json_encode(array("success" => true, "message" => "movie created"));
                    } else {
                        http_response_code(400);
                        echo json_encode(array("success" => false, "message" => "some problem happened"));
                    }
                    break;
                }
        }
    }

    public function procressResourceRequest($method, $id)
    {
        switch ($method) {
            case 'GET': {
                    $response = $this->movieGateway->show($id);
                    echo json_encode($response);
                    break;
                }

            case 'PUT': {
                    $movie = (array) json_decode(file_get_contents('php://input'), true); // true to convert into associative array
                    $response = $this->movieGateway->update($movie, $id);
                    if ($response) {
                        http_response_code(200);
                        echo json_encode(array("success" => true, "message" => "movie updated"));
                    } else {
                        http_response_code(400);
                        echo json_encode(array("success" => false, "message" => "some problem happened"));
                    }
                    break;
                }
            case 'DELETE': {

                    $response = $this->movieGateway->delete($id);
                    if ($response) {
                        http_response_code(204);
                        echo json_encode(array("success" => true, "message" => "movie deleted"));
                    } else {
                        http_response_code(400);
                        echo json_encode(array("success" => false, "message" => "some problem happened"));
                    }
                    break;

                }
        }
    }


}