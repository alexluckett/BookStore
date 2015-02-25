<!DOCTYPE html>
<html>
    <head>
        <title>Login to BookStore</title>
        
        <style type="text/css">
            body {
                font-family: sans-serif;
                font-size: 12px;
                text-align: center;
            }
            
            #container {
                margin: 0 auto;
                margin-top: 10%;
                width: 700px;
            }
            
            #errorBox {
                height: 200px;
                width: 700px;
                
                margin-top: 5%;
                display: table-cell;
                vertical-align: middle;
                text-align: center;
                
                border: 2px solid #9b0238;
                background: #fea9c7;
                font-weight: bold;
                font-size: 16px;
            }
        </style>
    </head>
    
    <body>
        <div id="container">
            <div id="errorBox">
                <h1><?php echo $_REQUEST["errorTitle"]; ?></h1>
                <?php echo $_REQUEST["errorMessage"]; ?>
            </div>
        </div>
    </body>
</html>