<h3>Books in your basket</h3>
<?php
$bookList = $_REQUEST['bookList'];

if (isset($_REQUEST["message"])) { ?>
    <div class="alert alert-success">
        <?php echo $_REQUEST["message"]; ?>
    </div>
<?php }

if (sizeof($bookList) == 0) {
    ?>
    <div class="alert alert-danger">
        No books currently in basket.
    </div>
<?php
} else {

    foreach ($bookList as $book) {
        ?>
        <div class="col-md-4">
            <div class="panel panel-default" id="book<?php echo $book->isbn; ?>">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $book->title; ?></h3>
                </div>
                <div class="panel-body">                    
                    <p><b>ISBN(13): </b><?php echo $book->isbn; ?></p>
                    <p><b>Author(s): </b><?php echo $book->author; ?></p>
                    <p><b>Price: </b>£<?php echo $book->price; ?></p>
                    <p><b>Quantity in stock: </b><?php echo $book->quantity; ?></p>

                    <?php if ($_SESSION['permission'] !== 1) { ?>
                        <div>
                            <p style="text-align: center;">
                                <a href="?action=deleteBasketItem&isbn=<?php echo $book->isbn; ?>" class="btn btn-danger" role="button">Remove</a>
                            </p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>