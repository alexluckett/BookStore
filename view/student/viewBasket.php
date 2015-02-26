<h3>Books in your basket</h3>
<?php

$bookList = $_REQUEST['bookList'];

if(sizeof($bookList) == 0) { ?>
    <div class="alert alert-danger">
        No books currently in basket.
    </div>
<?php } else {

foreach ($bookList as $book) {
    ?>
    <div class="panel panel-default" id="book<?php echo $book->isbn; ?>">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $book->title; ?></h3>
        </div>
        <div class="panel-body">
            <p>ISBN(13): <?php echo $book->isbn; ?></p>
            <p>Author(s): <?php echo $book->author; ?></p>
            <p>Price: <?php echo $book->price; ?></p>
            <p>Quantity in stock: <?php echo $book->quantity; ?></p>
        </div>
    </div>
    <?php
}

}
?>