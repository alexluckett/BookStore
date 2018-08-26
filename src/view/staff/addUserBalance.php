<?php if (isset($_REQUEST['userToEdit'])) {
    $userToEdit = $_REQUEST['userToEdit'];
    ?>
    <div class="panel panel-default">
        <div class="panel-heading"><?php echo $userToEdit->username; ?>'s account balance: £<?php echo $userToEdit->accountBalance; ?></div>
        <div class="panel-body">
            <p>Please enter an amount to increase account balance by.</p>
            
            <form class="form-inline" method="post" action="index.php?action=addBalanceAmount&userId=<?php echo $userToEdit->userId; ?>">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">£</div>
                        <input type="text" class="form-control" name="amountToAdd" placeholder="Amount">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Add to balance</button>
            </form>
        </div>
    </div>
<?php } ?>