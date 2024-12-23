<?php session_start();?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Login Grah Bank</title>
        <link rel="stylesheet" href="login.css">
    </head>

    <body>
        <div class="container">
            <div class="blue-container">
                <h1 class="login_form">Login Form</h1>
            </div>

            <div class="line"></div>

            <h2>Login</h2>
            <input type="text" id="username" class="input-field" placeholder="Enter your email">

            <h2>Password</h2>
            <input type="password" id="password" class="input-field" placeholder="Enter your password">

            <br>

            <button type="submit" class="Login">Login</button>

            <div id="loginResponse"></div>

            <br>

            <h5 class="made-by">Made By Grah</h5>
        </div>
		
		<?php
			
		?>
    </body>
</html>