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
$categories = $_REQUEST["categories"];
?>
    <script type="text/javascript">
        function changeCategory(categoryId) {
            window.location = "?action=viewBooks&categoryId=" + categoryId;
        }
    </script>

    <div style="display: inline-block; width: 100%;">
        <div class="pull-right">
            <div class="pull-left">
                <select name="bookCategories" onchange="changeCategory(this.value);" class="form-control">
                    <option value="0">All categories</option>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?php echo $category->categoryId; ?>"
                        <?php if (isset($_REQUEST['categoryId']) && ($_REQUEST['categoryId'] == $category->categoryId)) { ?>
                                    selected="true" 
                                <?php } ?>
                                ><?php echo $category->categoryName; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
<?php if ($_SESSION['permission'] == 1) { ?>
            <a href="?action=viewAddBook">
                <button type="button" style="margin-left: 5px;" class="btn btn-success">Add new book</button>
            </a>
<?php } ?>
        </div>
    </div>
<?php foreach ($books as $book) {
    ?>
    <div class="panel panel-default" id="book<?php echo $book->isbn; ?>">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $book->title; ?></h3>
        </div>
        <div class="panel-body">
            <p>ISBN(13): <?php echo $book->isbn; ?></p>
            <p>Author(s): <?php echo $book->author; ?></p>
            <p>Price: £<?php echo $book->price; ?></p>
            <p>Quantity in stock: <?php echo $book->quantity; ?></p>

            <?php if ($_SESSION['permission'] == 1) { ?>
                <div>
                    <p><a href="?action=viewEditBook&isbn=<?php echo $book->isbn; ?>">Edit book</a></p>
                    <p><a href="?action=deleteBook&isbn=<?php echo $book->isbn; ?>">Delete book</a></p>
                </div>
            <?php } else { ?>
                <div>
                    <p><a href="?action=addToBasket&isbn=<?php echo $book->isbn; ?>">Add to basket</a></p>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>