<style type="text/css">
    form input {
        margin-bottom: 5px;
    }
    
    .input-group {
        margin-bottom: 5px;
    }
</style>

<form action="index.php?action=addBook" method="post" enctype="multipart/form-data">
    <h2>Add book</h2>

    <label for="isbn" class="sr-only">ISBN: </label>
    <input name="isbn" type="text" class="form-control" placeholder="ISBN(13)" required autofocus />
    
    <label for="title" class="sr-only">Title: </label>
    <input name="title" type="text" class="form-control" placeholder="Book title" required />
    
    <label for="author" class="sr-only">Author: </label>
    <input name="author" type="text" class="form-control" placeholder="Author(s)" required />
    
    <div class="input-group">
        <div class="input-group-addon">£</div>
        <label for="price" class="sr-only">Price: </label>
        <input name="price" type="text" class="form-control" placeholder="Price" required />
    </div>
    
    
    
    <label for="quantity" class="sr-only">Quantity: </label>
    <input name="quantity" type="number" class="form-control" placeholder="Quantity" required />

    <br />
    <label for="categories">Category (ctrl + click to select multiple): </label>
    <select name="categories[]" class="form-control" multiple required><?php // [] by "categories" means that the php server side interprets it as an array  ?>
        <?php foreach ($_REQUEST["categories"] as $category) { ?>
            <option value="<?php echo $category->categoryId; ?>"><?php echo $category->categoryName; ?></option>
        <?php } ?>
    </select>

    <br />
    <div class="form-group">
        <label for="uploadedFile">Book cover image</label>
        <input type="file" name="uploadedFile" id="uploadedFile" />
        <p class="help-block">Permitted file types: PNG.</p>
    </div>
    <br />

    <div style="text-align: center;">
        <button class="btn btn-lg btn-primary" type="submit">Add book</button>
        <button class="btn btn-lg" type="reset">Clear</button>
    </div>
</form>