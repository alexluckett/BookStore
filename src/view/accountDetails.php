<?php

if(isset($_REQUEST['user'])) {
    $user = $_REQUEST['user']; ?>
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">View account details</h3></div>
        <div class="panel-body">
            <b>Username: </b><?php echo $user->username; ?></p>
            <b>Account type: </b><?php echo $user->permissionString; ?></p>
            <?php if ($_SESSION['permission'] == 2 || $user->permission == 2) { ?>
                <b>Balance: </b>£<?php echo $user->accountBalance; ?></b>
            <?php } ?>
        </div>
    </div>
<?php } ?>