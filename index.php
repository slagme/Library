
<!Doctype HTML>
<html>
    <head>
        <title> Library</title>
    </head>
</html>

<body>
    <p>Add Book:</p>

    <form>
        Autor: <br>
        <input type="text" name="author">
        <br>
        Title:
        <input type="text" name="title">
        <br>
        Description:
        <textarea name="description"></textarea>
        <br>
        <button id="add">Add book</button>
    </form>


    <p> List of books:</p>
    <div id="books">

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>