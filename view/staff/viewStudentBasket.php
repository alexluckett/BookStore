<h3>Books in <?php echo $_REQUEST['user']->username; ?>'s basket</h3>
<?php

$bookList = $_REQUEST['bookList'];

if(sizeof($bookList) == 0) { ?>
    <div class="alert alert-danger">
        No books currently in basket.
    </div>
<?php } else {
$totalPrice = 0;
foreach ($bookList as $book) {
    $totalPrice += $book->price;
    
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
<?php } ?>
    <div class="pull-right">
        Total cost: £<?php echo $totalPrice; ?>
        <a href="?action=processBasket&userId=<?php echo $_REQUEST['user']->userId; ?>">
            <button type="button" style="margin-left: 5px;" class="btn btn-success">Process order</button>
        </a>
    </div>
<?php } ?>