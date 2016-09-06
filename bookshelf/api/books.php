<?php
require_once './src/conn.php';
require_once './src/Book.php';

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $newBook = new Book();
    $newBook->setAuthor($_POST['author']);
    $newBook->setDescription($_POST['description']);
    $newBook->setName($_POST['name']);

    $newBook->saveToDB($conn);
}

if($_SERVER["REQUEST_METHOD"] === "GET"){
        $allBooks = Book::GetAllBooks($conn);
        echo(json_encode($allBooks));
}

if($_SERVER["REQUEST_METHOD"] === "DELETE"){
    parse_str(file_get_contents("php://input"),$del_vars);
    if(isset($del_vars['deleteid'])){
        $newBook = new Book();
        $newBook->deleteFromDB($conn, $del_vars['deleteid']);
        $result = $newBook->loadFromDB($conn, $del_vars['deleteid']);
        echo(json_encode($result));
    }
}

?>



