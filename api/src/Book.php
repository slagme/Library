<?php

class Book {
    private $id;
    private $title;
    private $author;
    private $description;
    
    
    public function __construct () {
        $this->id = -1;
        $this->setAuthor('');
        $this->setTitle('');
        $this->setDescription('');
    }
    
    public function create(PDO $conn, $author, $title, $description) {
        
    }
    
    public function update(PDO $conn, $author, $title, $description) {
        
    }
    
    public function delete(PDO $conn) {
        
    }
    
    
    //funkcja ładująca pojedynczy wiersz
    static public function loadFromDb(PDO $conn, $id){
        $stmt=$conn->prepare('SELECT * FROM books WHERE id=:id');
        $result=$stmt->execute(['id' => $id]);
        
        if ($result && $stmt->rowCount() > 0){
            $row=$stmt->fetch();
            //przypisanie własności do nowej książki
            $book= new Book();
            $book->id = $row ['id'];
            $book->author = $row['author'];
            $book->title=$row['title'];
            $book->description=$row['description'];
                //implementujemy interfejs bo nie można zrobić json z obiektu
            return [json_encode($book)];
            
        } else {
            return [];
        }
    }
    
    //funkcja pobierająca wszystkie wiersze
    static public function loadAllFromDb(PDO $conn){
        
    }
    
    public function jsonSerialize(){
        //metoda interfejsu
        //ta tablica będzie zwrócona przy przekazaniu obiektu do json_encode(
        return [
            'id' => $this-> id,
            'author' => $this -> author,
            'title' =>$this -> title,
            'description' => $this->description
        ];
            
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function setDescription($description) {
        $this->description = $description;
    }




}