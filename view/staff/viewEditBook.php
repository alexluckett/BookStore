<?php if (isset($_REQUEST['book'])) {
    $book = $_REQUEST['book'];
    ?>
<?php if(isset($_REQUEST['messageType'])) { ?>
    <div class="alert alert-<?php echo $_REQUEST['messageType']; ?>">
    <?php if($_REQUEST['messageType'] === "success") { ?>
        The book quantity was successfully increased.
    <?php } else { ?>
        The book quantity was unuccessfully increased.
    <?php } ?>
    </div>
<?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">Add quantity to <?php echo $book->title; ?></div>
        <div class="panel-body">
            <p>Please enter an amount to increase book quantity by.</p>
            
            <form class="form-inline" method="post" action="?action=addQuantity">
                <div class="form-group">
                    <input type="hidden" value="<?php echo $book->isbn; ?>" name="isbn" />
                    <input type="number" class="form-control" name="amountToAdd" placeholder="Amount">
                </div>
                <button type="submit" class="btn btn-primary">Add quantity</button>
            </form>
        </div>
    </div>
<?php } ?>