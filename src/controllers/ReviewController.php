<?php

class ReviewController
{
    private $reviewGateway = null;
    public function __construct($reviewGateway)
    {
        $this->reviewGateway = $reviewGateway;
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
                    $response = $this->reviewGateway->index();

                    echo json_encode($response);
                    break;
                }
            case 'POST': {
                    $review = (array) json_decode(file_get_contents('php://input'), true); // true to convert into associative array

                    $response = $this->reviewGateway->create($review);
                    if ($response) {
                        echo json_encode(array("success" => true, "message" => "Review created"));
                    } else {
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
                    $response = $this->reviewGateway->show($id);
                    echo json_encode($response);
                    break;
                }

            case 'PUT': {
                    $review = (array) json_decode(file_get_contents('php://input'), true); // true to convert into associative array
                    $response = $this->reviewGateway->update($review, $id);
                    if ($response) {
                        echo json_encode(array("success" => true, "message" => "review updated"));
                    } else {
                        echo json_encode(array("success" => false, "message" => "some problem happened"));
                    }
                    break;
                }
            case 'DELETE': {

                    $response = $this->reviewGateway->delete($id);
                    if ($response) {
                        echo json_encode(array("success" => true, "message" => "review deleted"));
                    } else {
                        echo json_encode(array("success" => false, "message" => "some problem happened"));
                    }
                    break;

                }
        }
    }


}