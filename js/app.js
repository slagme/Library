$(function () {

    var divBooks=$('div#books');

    $.ajax({
        url: 'api/books.php',
        dataType:'json'
    }).done(function (listOfBooks) {

        listOfBooks.forEach(function (singleBookJson){
            var singleBook=JSON.parse(singleBookJson);
             //creating new li element with book
            var newLi=$('<div data-id="' + singleBook.id + '"><li><span class="bookTitle"> '+ singleBook.title + '</span><div class="bookDescription"></div></li>');
            //adding new element to list
            divBooks.append(newLi);
        });
        
    }).fail(function () {
        console.log('Something went wrong');
    });

    divBooks.on('click', 'span.BookTitle', function () {
        //getting id from dataset
        var span=$(this);
        var bookId=span.parent().data('id');

        $.ajax({
            url:'api/books.php?id=' +bookId,
            dataType: 'json'
        }).done(function (listOfBooks) {
            //List of books 1 element array
            //because searching by id
            var singleBook = listOfBooks;
            span.next().text(singleBook.description);

            //adding delete button

            var deleteBtn = $('<br> <button id="delete"> Remove</button>');
            span.next().append(deleteBtn);

            //adding edit button

            var deleteBtn = $('<br> <button id="edit"> Edit</button>');
            span.next().append(deleteBtn);
        }).fail(function (){
            console.log ('Something went wrong');
        });
    });
    //addingBook

    var addBook=$('#add');


    addBook.on('click', function (e) {
        e.preventDefault();
        //getting data form fomula on index.php
        var formula=$(this).parent();

        var author=formula.find('input[name=author]').val();
        var title= formula.find('input[name=title]').val();
        var description=formula.find('textarea[name=description]').val();

        //creating object for ajax
        var data= {};

        data.author=author;
        data.title=title;
        data.description=description;

        $.ajax({
            url:'api/books.php',
            dataType:'json',//type
            data: data,//what
            type: 'POST'//method
        }).done(function (listOfBooks){

            //getting from list of Books last first element
            var singleBook=JSON.parse(listOfBooks[0]);

            var newLi=$('<div data-id=" '+ singleBook.id + '"> <li> <span class="bookTitle"> ' + singleBook.title + ' </span> <div class="bookDescription"></div></li>');

            //adding new book to id element book
            divBooks.append(newLi);

            alert("Book added");
        }).fail(function (){
            alert ("Book not added");
        });
    });

    //form for editing
    divBooks.on('click', 'button#edit', function (e)
    {
        e.preventDefault();
        var btn=$(this);
        var title=btn.parent().parent().find('span').text();
        var editForm=$('<form action="" method="POST" id="editForm"><input type="text" name="titleEdited" value=' + title + '><button id="confirm" type="submit"> Confirm </button></form>');
    });

    //book title update

    divBooks.on('click', 'buttion#confirm', function (e) {
        e.preventDefault();
        var form = $(this).parent();
        var title= form.find('input[name=titleEdited]').val();

        var btn=$(this);
        var id=btn.parent().parent().parent().data('id');
        var changedTitle= btn.parent().parent().parent().find('span');

        //sending book with put method

        $.ajax({
            url: api/books.php,
            data: {id:id, title:title},
            dataType: 'json',
            type: 'PUT'
        }).done(function (success){
            if (success){
                changedTitle.text(title);
            }
        }).fail(function () {
            alert ('Something went wrong')
            
        });
    });

    //deleting Book

    divBooks.on('click','button#delete', function (e)
    {
        e.preventDefault();
        var btn = $(this);
        var id=btn.parent().parent().data('id');

        $.ajax({
            url: 'api/books.php',
            dataType:'json',
            data: 'id=' + id,
            type: 'DELETE'
        }).done(function (success) {
            if (success){
                btn.parent().parent().remove();
            }
        }).fail(function(){
            console.log ('Error deleting book');
        });

    });
});
