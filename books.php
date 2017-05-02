<?php

//ładujemy niezbędne pliki
require_once(__DIR__.'/src/db.php');
require_once(__DIR__.'/src/Book.php');

//sprawdzamy jakim rodzajem (HTTP) wysłano żądanie

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //tablicę tworzymy po to by sobie to ujednolicić
    $books=[];
    //sprawdzamy czy przekazano ID
    if (isset($_GET['id'])){
        //pobieramy id książki
        $id = intval($_GET['id']);
        $books=Book::loadAllFromDb($conn, $id);
    } else {
        //pobieramy wszystkie książki
        $books=Book::loadAllFromDb($conn);
    }
    
    //zwracamy tablicę jsona
    echo json_encode($books);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){    
    
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //pobranie magiczne danych
    parse_str(file_get_contents("php://input"), $put_vars);
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    
    parse_str(file_get_contents("php://input"), $del_vars);
}
