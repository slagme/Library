<?php

require_once (__DIR__ . '/src/db.php');
require_once (__DIR__ . '/src/Book.php');

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $books = [];

    if(isset($_GET['id'])){
        $id=intval($_GET['id']);
        $books=Book::loadFromDb($conn, $id);
    }else{
        $books=Book::loadAllFromDb($conn);
    }

    echo json_decode($books);

}

