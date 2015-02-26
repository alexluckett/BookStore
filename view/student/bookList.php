<?php
$message = "";

if (!isset($_REQUEST["books"])) {
    $message = "<b>There are no books currently within the system.</b>";
} else if (isset($_REQUEST["message"])) {
    $message = $_REQUEST["message"];
}

$alertType = "danger";
if (isset($_REQUEST["alertType"])) {
    $alertType = $_REQUEST["alertType"];
}

if (strlen($message) != 0) {
    ?>
    <div class="alert alert-<?php echo $alertType; ?>">
        <?php echo $message; ?>
    </div>
    <?php
}
$books = $_REQUEST["books"];
foreach ($books as $book) {
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

            <?php if ($_SESSION['permission'] == 1) { ?>
                <div>
                    <p><a href="?action=editBookForm&isbn=<?php echo $book->isbn; ?>">Edit book</a></p>
                    <p><a href="?action=deleteBook&isbn=<?php echo $book->isbn; ?>">Delete book</a></p>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
}
?>