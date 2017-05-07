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
}
