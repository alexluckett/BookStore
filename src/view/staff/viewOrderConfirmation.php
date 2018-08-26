<?php

?>
<h2>An order has been processed for <?php echo $_REQUEST['user']->username; ?>.</h2>

<div class="alert alert-<?php echo $_REQUEST['messageType']; ?>">
<?php if($_REQUEST['messageType'] === "success") { ?>
    The order was successfully processed.
<?php } else { ?>
    The order was unsuccessful.
<?php } ?>
</div>

<p><?php 

foreach ($_REQUEST['messages'] as $value) {
    echo $value."<br />";
}?></p>