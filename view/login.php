<style type="text/css">
    #container {
        margin: 0 auto;
        margin-top: 5%;
        width: 20%;
    }
    
    /* the below styling is based on the bootstrap
     * example at http://getbootstrap.com/examples/signin/signin.css 
     */
    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>

<div class="page-header" style="text-align: center;">
  <h1>Aston University: Book Store</h1>
</div>

<div id="container">
    <form action="index.php?action=login" method="post" class="form-signin">
        
        <?php
        $errorTitle = "";
        $errorMessage = "";
        
        if(isset($_REQUEST["errorTitle"])) { $errorTitle = "<b>".$_REQUEST["errorTitle"].". </b>"; }
        if(isset($_REQUEST["errorMessage"])) { $errorMessage = $_REQUEST["errorMessage"]; }
        
        $printout = $errorTitle.$errorMessage;
        
        if(strlen($printout) != 0) {  ?>
            <div class="alert alert-danger">
            <?php echo $printout; ?>
            </div>
        <?php } ?>
        
        <h2 class="form-signin-heading">Please log in</h2>
        <label for="username" class="sr-only">Username: </label>
            <input name="username" type="text" class="form-control" placeholder="Username" required autofocus />
        <label for="password" class="sr-only">Password: </label>
            <input name="password" type="password" class="form-control" placeholder="Password" required />
        <br />
        
        <div style="text-align: center;">
            <button class="btn btn-lg btn-primary" style="width: 49%;" type="submit">Login</button>
            <button class="btn btn-lg" style="width: 49%;" ttype="reset">Clear form</button>
        </div>
    </form>
</div>