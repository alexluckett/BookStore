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
            
            #loginBox {
                height: 200px;
                width: 700px;
                
                margin-top: 5%;
                display: table-cell;
                vertical-align: middle;
                text-align: center;
                
                border: 2px solid #2c92ad;
                background: #94e2f6;
                font-weight: bold;
                font-size: 16px;
            }
        </style>
    </head>
    
    <body>
        <div id="container">
            <div id="loginBox">
                <form action="index.php?action=login" method="post">
                    Username: <input type="text" name="username" /><br /><br />
                    Password: <input type="password" name="password" /><br />
                    <br />
                    <button type="submit">Login</button>
                    <button type="reset">Clear form</button>
                </form>
            </div>
        </div>
    </body>
</html>