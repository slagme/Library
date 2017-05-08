<?php

class Book implements JsonSerializable{
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
    
    public function create(PDO $conn) {
        $stmt=$conn->prepare('INSERT INTO books SET author=:author, title=:title, description=:description');

        $stmt->execute([
            'author' => $this->getAuthor(),
            'title' => $this->getTitle(),
            'description'=>$this->getDescription()
        ]);
        $insertedId=$conn->lastInsertId();

        if ($insertedId > 0){
            $this->id =$insertedId;
            return [json_encode($this)];
        }
        else{
            return [];
        }

    }
    
    public function update(PDO $conn, $title) {
        $id=$this->getId();
        $stmt=$conn->prepare('UPDATE books SET title=:title WHERE id=:id');
        $result=$stmt->execute([
            'id' => $id,
            'title' => $title
        ]);

        if($result === true){
            return json_encode($this);
        }else{
            return [];
        }
        
    }
    
    public function delete(PDO $conn) {
        $id=$this->getId();
        $sql='DELETE FROM books WHERE id=:id';
        $stmt=$conn->prepare($sql);
        $result=$stmt->execute(['id'=>$id]);
        if ($result === true){
            $this->id = -1;
            return [json_encode($this)];
        }else{
            return[];
        }
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
            return $book;
            
        } else {
            return [];
        }
    }
    
    //funkcja pobierająca wszystkie wiersze
    static public function loadAllFromDb(PDO $conn){
        $result = $conn->query('SELECT * FROM books');
        $books = [];

        //iterumey po rekordach z bazy
        foreach ($result as $row) {
            //tworzymy do kazdego rekordu obiekt ksiązki
            $book = new Book();
            $book->id = $row['id'];
            $book->author = $row['author'];
            $book->title = $row['title'];
            $book->description = $row['description'];

            //i wrzucamy go do tablicy
            $books[] =json_encode($book);
        }

        return $books;
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