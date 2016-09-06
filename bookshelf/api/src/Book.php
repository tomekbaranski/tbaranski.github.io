<?php

class Book implements JsonSerializable{

    static public function GetAllBooks (mysqli $conn){
        $toReturn = [];
        $sql = "SELECT * FROM Books";
        $result = $conn->query($sql);

        if($result != FALSE){
            foreach ($result as $row){
                $book = new Book;
                $book->id = $row['id'];
                $book->name = $row['name'];
                $book->description = $row['description'];
                $book->author = $row['author'];

                $toReturn [] = $book;
            }
        }
        return $toReturn;
    }

    private $id;
    private $name;
    private $description;
    private $author;

    public function __construct(){
        $this->id = -1;
        $this->name = "";
        $this->description = "";
        $this->author ="";
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($newName){
        $this->name = $newName;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($newDescription){
        $this->description = $newDescription;
    }

    public function getAuthor (){
        return $this->author;
    }

    public function setAuthor($newAuthor){
        $this->author = $newAuthor;
    }

    public function loadFromDB(mysqli $conn, $id){
        $sql = "SELECT * FROM Books WHERE id = $id";
        $result = $conn->query($sql);
        if($result != FALSE && $result->num_rows === 1){
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->description = $row['description'];
                $this->author = $row['author'];
                return TRUE;
        }
        return FALSE;
    }

    public function saveToDB(mysqli $conn){
        if($this->id === -1){
            $sql = "INSERT INTO Books (name, description, author) VALUES
                    ('{$this->name}', '{$this->description}', '{$this->author}')";
            $result = $conn->query($sql);

            if($result === TRUE){
                $this->id = $conn->insert_id;
                return TRUE;
            }
        } else{
            $sql = "UPDATE Books SET name = {$this->name}, description = {$this->description}, author = {$this->author}
                    WHERE id = {$this->id}";
            $result = $conn->query($sql);
            return $result;
        }
        return FALSE;
    }

    public function deleteFromDB(mysqli $conn, $id){
        $sql = "DELETE FROM Books WHERE id = '{$id}'";
        $result = $conn->query($sql);
        return $result;
    }

    public function jsonSerialize(){
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "author" => $this->author
        ];
    }
}
?>