<?php
$categories = $_REQUEST['categories'];
?>

<style type="text/css">
    .verticalCenter {
        min-height: 50px;
        
        display: flex;
        align-items: center;
        
        /* Safari */
        display: -webkit-flex;
        -webkit-align-items: center;
    }
</style>

<div style="height: 70px;">
    <div style="width: 88%;" class="pull-left">
        <p class="alert alert-danger" role="alert">Deleting a category will delete all books associated with it.</p>
    </div>

    <div style="width: 10.5%;" class="pull-right verticalCenter">
        <a href="?action=viewAddCategory" class="btn btn-success pull-right" role="button">Add new book</a>
    </div>
</div>


<?php foreach ($categories as $category) { ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <span style="font-size: 28px;"><?php echo $category->categoryName; ?></span>
            
            <div class="pull-right">
                <a href="?action=deleteCategory&catId=<?php echo $category->categoryId; ?>"><button type="button" class="btn btn-danger">Delete</button></a>
            </div>
        </div>
    </div>
<?php } ?>