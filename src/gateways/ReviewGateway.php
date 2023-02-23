<?php

class ReviewGateway
{
    private $connection = null;

    public function __construct($database)
    {
        $this->connection = $database->getDatabase();
    }

    public function index()
    {
        $query = "select * from reviews";
        $result = $this->connection->query($query);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
        // return $result->fetch_assoc();
    }

    public function show($id)
    {
        $query = "select * from reviews where id=$id";
        $result = $this->connection->query($query);
        $data = $result->fetch_assoc();
        return $data;
    }

    public function create($review)
    {
        $mid = $review['mid'];
        $message = $review['review'];
        $email = $review['email'];
        $rating = $review['rating'];

        $query = "insert into reviews(mid,review,email,rating) values($mid,'$message','$email',$rating)";

        if ($this->connection->query($query)) {
            return true;
        }
        // echo $this->connection->error();
        return false;

    }

    public function update($review, $id)
    {
        $message = $review['review'];
        $rating = $review['rating'];
        $query = "UPDATE `reviews` SET `review` = '$message', `rating` = $rating WHERE `reviews`.`id` = $id";
        if ($this->connection->query($query)) {
            return true;
        }
        return false;

    }

    public function delete($id)
    {
        $query = "delete from reviews where id=$id";

        if ($this->connection->query($query)) {
            return true;
        }
        return false;
    }
}