<?php
$users = $_REQUEST['users'];

foreach ($users as $user) {
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <span style="font-size: 28px;">Student: <?php echo $user->username; ?></span>
            <div class="pull-right">
                <a href="?action=viewUserBasket&userId=<?php echo $user->userId; ?>"><button type="button" class="btn">View cart</button></a>
                <a href="?action=deleteUser&userId=<?php echo $user->userId; ?>"><button type="button" class="btn btn-danger">Delete user</button></a>
            </div>
        </div>
    </div>
<?php } ?>