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
			$servername = "localhost"; 
			$username = "root";        
			$password = "";             
			$dbname = "gigabank"; 


			$conn = new mysqli($servername, $username, $password, $dbname);


			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}


			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				$login = $_POST['username'];
				$pass = $_POST['password'];

				$sql = "SELECT * FROM users WHERE login = ? AND password = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("ss", $login, $pass);  // 'ss' oznacza dwa parametry typu string
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows > 0) {
					
					echo "Login successful!";
					$_SESSION['login'] = $login;
					
				} else {
					
					echo "Invalid username or password.";
				}

				$result->free_result();
				$stmt->close();
				$conn->close();
			}
		?>
    </body>
</html>