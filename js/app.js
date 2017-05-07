$(function () {

    var divBooks=$('div#books');

    $.ajax({
        url: 'api/books.php',
        dataType:'json'
    }).done(function (listOfBooks) {

        listOfBooks.forEach(function (singleBookJson){
            var singleBook=JSON.parse(singleBookJson);
             //creating new li element with book
            var newLi=$('<div data-id="' + singleBook.id + '"> '+ singleBook.title );
            //adding new element to list
            divBooks.append(newLi);
        });
        
    }).fail(function () {
        console.log('Something went wrong');
    });

    divBooks.on('click', 'span.BookTitle', function () {
        //getting id from dataset
        var span=$(this);
        var id=span.parent().data('id');

        $.ajax({
            url:'api/books.php?id=' +id,
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
            var singleBook=JSON.parse(listOfBooks[0]);

            var newLi=$('<div data-id=" '+ singleBook.id + singleBook.title + singleBook.description +' "</div>');
            divBooks.append(newLi);

            alert("Book added");
        }).fail(function (){
            alert ("Book not added");
        });
    });

    

    //deleting Book

    divBooks.on('click','button#delete', function (e) {
        e.preventDefault();
        var btn = $(this);
        var id=btn.parent().parent().data('id');

        $.ajax({
            url: 'api/books.php',
            dataType:'json',
            data: 'id=' + id,
            type: 'DLEETE'
        }).done(function (success) {
            if (success){
                btn.parent().parent().remove();
            }
        }).fail(function(){
            console.log ('Error deleting book');
        });

    });
});
