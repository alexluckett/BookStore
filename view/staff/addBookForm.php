<form action="index.php?action=addBook" method="post" class="form-signin" enctype="multipart/form-data">
    <h2 class="form-signin-heading">Add book</h2>

    <label for="isbn" class="sr-only">ISBN: </label>
    <input name="isbn" type="text" class="form-control" placeholder="ISBN(13)" required autofocus />
    <label for="title" class="sr-only">Title: </label>
    <input name="title" type="text" class="form-control" placeholder="Book title" required />
    <label for="author" class="sr-only">Author: </label>
    <input name="author" type="text" class="form-control" placeholder="Author(s)" required />
    <label for="price" class="sr-only">Price: </label>
    <input name="price" type="text" class="form-control" placeholder="Price" required />
    <label for="quantity" class="sr-only">Quantity: </label>
    <input name="quantity" type="number" class="form-control" placeholder="Quantity" required />

    <br />
    <label for="categories">Category (ctrl + click to select multiple): </label>
    <select name="categories[]" class="form-control" multiple required>
        <?php foreach ($_REQUEST["categories"] as $category) { ?>
            <option value="<?php echo $category->categoryId; ?>"><?php echo $category->categoryName; ?></option>
        <?php } ?>
    </select>

    <br />
    <div class="form-group">
        <label for="uploadedFile">Book cover image</label>
        <input type="file" name="uploadedFile" id="uploadedFile" />
        <p class="help-block">Permitted file types: PNG, JPEG.</p>
    </div>
    <br />

    <div style="text-align: center;">
        <button class="btn btn-lg btn-primary" style="width: 49%;" type="submit">Add book</button>
        <button class="btn btn-lg" style="width: 49%;" ttype="reset">Clear</button>
    </div>
</form>