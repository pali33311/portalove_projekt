<?php
namespace knihovna;

class DB
{
    private $host;
    private $dbname;
    private $username;
    private $password;

    private $connection;

    public function __construct($host, $dbname, $username, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;

        try {
            $this->connection = new \PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->username, $this->password);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function getAllBooks()
    {
        $books = [];
        $sql = "SELECT * FROM book";

        $query = $this->connection->query($sql);

        while ($row = $query->fetch()) {
            $books[] = [
                'id' => $row['id'],
                'views' => $row['views'],
                'rating' => $row['rating'],
                'name' => $row['name'],
                'about' => $row['about'],
                'image' => $row['image']
            ];
        }

        return $books;
    }



    public function getBookDetails($id)
    {
        $sql = "SELECT * FROM book WHERE id = " . $id;
        $result = [];

        try {
            $query = $this->connection->query($sql);
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return $result;
        }
    }

    public function insertEmail($name, $email, $message)
    {
        $dateTime = date('Y-m-d H:i:s', time());
        $sql = "INSERT INTO mail(name, email, message, date) 
                VALUE ('".$name."', '".$email."', '".$message."', '".$dateTime."')";
        try {
            $this->connection->exec($sql);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function deleteBook($id)
    {
        $sql = "DELETE FROM book WHERE id = ".$id;

        try {
            $this->connection->exec($sql);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function updateBook($id, $name, $image, $about, $rating)
    {
        $sql = "UPDATE book 
                SET name = '".$name."', image = '".$image."', about = '".$about."', rating = '".$rating."' 
                WHERE id = ".$id;

        try {
            $this->connection->exec($sql);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getAllMails()
    {
        $mails = [];
        $sql = "SELECT * FROM mail";

        $query = $this->connection->query($sql);

        while ($row = $query->fetch()) {
            $mails[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'message' => $row['message'],
                'date' => $row['date']
            ];
        }

        return $mails;
    }

    public function deleteMail($id)
    {
        $sql = "DELETE FROM mail WHERE id = ".$id;

        try {
            $this->connection->exec($sql);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function insertBookItem($name, $image, $about, $rating)
    {
        $sql = "INSERT INTO book(name, about, views, rating, image)
                VALUE ('".$name."', 
                '".$about."', 
                0, 
                ".$rating.", 
                '".$image."')";

        try {
            $this->connection->exec($sql);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}