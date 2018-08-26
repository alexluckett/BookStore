<?php if(isset($_REQUEST['messageType'])) { ?>
    <div class="alert alert-<?php echo $_REQUEST['messageType']; ?>">
    <?php if($_REQUEST['messageType'] === "success") { ?>
        The book category was successfully created.
    <?php } else { ?>
        The book category was unsuccessfully created.
    <?php } ?>
    </div>
<?php } ?>

<div class="panel panel-default">
    <div class="panel-heading">Add book category</div>
    <div class="panel-body">
        <p>Please enter a category name.</p>

        <form class="form-inline" action="index.php?action=addCategory" method="post">
            <label for="categoryName" class="sr-only">Category name: </label>
            <input name="categoryName" type="text" class="form-control" placeholder="Category name" required autofocus />

            <button type="submit" class="btn btn-primary">Add category</button>
        </form>
    </div>
</div>