

    <!DOCTYPE html>
    <html>
    <head>
    <title></title>
    </head>
    <body>
    <h2>Login Here</h2>
    <form method="POST" action="loin.php">
     Username: <input type="text" name="username">
     Password: <input type="password" name="password"> <br><br>
     <input type="submit" value="Login">
    </form><br>
    <?php
    	session_start();
    	if (isset($_SESSION['message'])){
    	echo $_SESSION['message'];
    	unset ($_SESSION['message']);
    	}
    ?>
    </body>
    </html>