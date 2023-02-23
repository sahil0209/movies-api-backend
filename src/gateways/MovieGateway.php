<?php

class MovieGateway
{
    private $connection = null;

    public function __construct($database)
    {
        $this->connection = $database->getDatabase();
    }

    public function index()
    {
        $query = "select * from movies";
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
        $query = "select * from movies where id=$id";
        $result = $this->connection->query($query);
        $movie = $result->fetch_assoc();

        $reviews = [];

        $rquery = "select * from reviews where mid=$id order by created_at desc";
        $res = $this->connection->query($rquery);
        while ($row = $res->fetch_assoc()) {
            $reviews[] = $row;
        }

        $data = array("movie" => $movie, "reviews" => $reviews);
        return $data;
    }

    public function create($movie)
    {
        $name = $movie['name'];
        $release_date = $movie['release_date'];
        $rating = $movie['rating'];
        $description = $movie['description'];
        $genre = $movie['genre'];
        $cast = $movie['cast'];
        $runtime = $movie['runtime'];
        $poster = $movie['poster'];
        $query = "INSERT INTO `movies` (`id`, `name`, `release_date`, `rating`, `description`, `genre`, `cast`, `runtime`,`poster`, `created_at`, `updated_at`) VALUES (NULL, '$name', '$release_date', '$rating', '$description', '$genre', '$cast', '$runtime',`$poster`, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

        if ($this->connection->query($query)) {
            return true;
        }
        return false;

    }

    public function update($movie, $id)
    {
        $name = $movie['name'];
        $release_date = $movie['release_date'];
        $rating = $movie['rating'];
        $description = $movie['description'];
        $genre = $movie['genre'];
        $cast = $movie['cast'];
        $runtime = $movie['runtime'];
        $poster = $movie['poster'];
        $query = "update movies set name='$name',rating=$rating, release_date='$release_date', description='$description', genre = '$genre', cast = '$cast', runtime = '$runtime', poster='$poster' WHERE id=$id";
        if ($this->connection->query($query)) {
            return true;
        }
        return false;

    }

    public function delete($id)
    {
        $query = "delete from movies where id=$id";

        if ($this->connection->query($query)) {
            return true;
        }
        return false;
    }
}