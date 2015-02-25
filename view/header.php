<?php
session_start();

function showContentForPermission() {   
    $permission = getPermission();
    
    switch ($permission) {
        case 1:
            include('admin.php'); // redirect to admin page
            break;
        
        case 2:
            include('student.php'); // redirect to member page
            break;
        
        case 0:
            include ('login.php');
            break;
    }
    
    return false;
}

function getPermission() {
    $permission = 0;
    
    if(isset($_SESSION['permission'])) {
        $permission = $_SESSION['permission'];
    }  
    
    return $permission;
}

function isLoggedIn() {
    return isset($_SESSION['username']) && isset($_SESSION['permission']);
}

function sexyVarDump($object) {
    echo '<pre>';
    var_dump($object);
    echo '</pre>';
}

?>

<div id='header'>
    <?php if(isLoggedIn()) { ?>
        <div id="welcome">
            Hello <?php echo $_SESSION['username'] ?>! Your user account is type: <?php echo $_SESSION['permissionString'] ?>.
        </div>
    <?php } ?>
    
    <div id='nav'>
        <ul>
            <?php if(isLoggedIn()) { ?>
            <li><a href="?action=logout">Logout</a></li>
            <?php } ?>
        </ul>
    </div>
</div>