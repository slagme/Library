<?php

//ładujemy niezbędne pliki
require_once(__DIR__ . '/src/db.php');
require_once(__DIR__ . '/src/Book.php');


//sprawdzamy jakim rodzajem (HTTP) wysłano żądanie

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //tablicę tworzymy po to by sobie to ujednolicić
    $books=[];
    //sprawdzamy czy przekazano ID
    if (isset($_GET['id'])){
        //pobieramy id książki
        $id = intval($_GET['id']);
        $books=Book::loadFromDb($conn, $id);
    } else {
        //pobieramy wszystkie książki
        $books=Book::loadAllFromDb($conn);
    }
    
    //zwracamy tablicę jsona
    echo json_encode($books);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $newBook= new Book();
    $newBook->setAuthor($_POST['author']);
    $newBook->setTitle($_POST['title']);
    $newBook->setDescription($_POST['description']);

    $booksArray=$newBook->create($conn);

    echo json_encode($booksArray);
    
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //pobranie magiczne danych
    parse_str(file_get_contents("php://input"), $put_vars);

    $id=$put_vars['id'];
    $bookTitle=$put_vars['title'];

    $bookUpdate= Book::loadFromDb($conn, $id);
    $result=$bookUpdate->update($conn, $bookTitle);

    echo json_encode($result);


} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    
    parse_str(file_get_contents("php://input"), $del_vars);

    $id=intval($del_vars['$id']);
    $deleteBook=Book::loadFromDb($conn, $id);
    $result=$deleteBook->delete($conn);

    echo json_encode($result);

}
