<style type="text/css">
    .signup-form input {
        margin-bottom: 10px;
    }
</style>

<div class="page-header" style="text-align: center;">
    <h1>Create an account</h1>
</div>

<div id="container">
    <form action="index.php?action=register" method="post" class="signup-form">
        
        <?php
        $messageTitle = "";
        $messageText = "";
        
        if(isset($_REQUEST["messageTitle"])) { $messageTitle = "<b>".$_REQUEST["messageTitle"].". </b>"; }
        if(isset($_REQUEST["messageText"])) { $messageText = $_REQUEST["messageText"]; }
        
        $printout = $messageTitle.$messageText;
        
        if(isset($_REQUEST['messageType'])) {
            if($_REQUEST['messageType'] === "error") {  ?>
                <div class="alert alert-danger">
                <?php echo $printout; ?>
                </div>
            <?php } else { ?>
                <div class="alert alert-success">
                <?php echo $printout; ?>
                </div>
        <?php } } ?>
        
        <label for="username" class="sr-only">Username: </label>
            <input name="username" type="text" class="form-control" placeholder="Username" required autofocus />
        <label for="password" class="sr-only">Password: </label>
            <input name="password" type="password" class="form-control" placeholder="Password" required />
        <label for="password" class="sr-only">Confirm password: </label>
            <input name="passwordConfirm" type="password" class="form-control" placeholder="Confirm password" required />
        <br />
        
        <div style="text-align: center;">
            <button class="btn btn-lg btn-primary" style="width: 49%;" type="submit">Register</button>
            <button class="btn btn-lg" style="width: 49%;" type="reset">Clear form</button>
        </div>
    </form>
</div>