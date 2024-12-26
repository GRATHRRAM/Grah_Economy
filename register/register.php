<?php
	session_start();

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "gigabank";
	$error_msg = "";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$login = $_POST['username'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$Balance = 1000;

		if (!empty($login) && !empty($password)) { 
			if ($password === $password2) {
				if(!(strlen($login) > 30 || strlen($password) > 30)) {
					$username = $conn->real_escape_string($login);

					$sql = "SELECT * FROM users WHERE login = ?";
					$stmt = $conn->prepare($sql);
					$stmt->bind_param("s", $login);
					$stmt->execute();
					$result = $stmt->get_result();
					$stmt->close();
					
					$row = $result->fetch_row();
					if ($row[0] > 0) {
						$error_msg = "Account With This Login Already Exist";
					} else {
						$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

						$sql = "INSERT INTO users (login, password, balance) VALUES ('$login', '$hashedPassword', '$Balance')";

						if ($conn->query($sql) === TRUE) {
							echo "Registration successful!";
							
							$_SESSION['mainpg_msg'] = "Registration successful! <br> Login -> " . $login;
							
							$result->free_result();
							header("location: ../index.php");
						} else {
							echo "Error: " . $conn->error;
						}
					}
					
					$result->free_result();
				} else {$error_msg = "Password Or Login Need To Be Smaller Than 30 Characters";}
			} else {$error_msg = "Correctly Retype The Password! Bozo";}
		} else {$error_msg = "All Fields Must Be Filled! Bozo";}
	}
	
	$conn->close();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Register Grah Bank</title>
        <link rel="stylesheet" href="register.css">
    </head>

    <body>
        <div class="container">
            <div class="blue-container">
                <h1 class="login_form">Register Form</h1>
            </div>

            <div class="line"></div>

			<form method="POST">
				<h2>Login</h2>
				<input type="text" id="username" name="username" class="input-field" placeholder="Enter your Login">

				<h2>Password</h2>
				<input type="password" id="password" name="password" class="input-field" placeholder="Enter your password">
				
				<h2>Retype Password</h2>
				<input type="password" id="password2" name="password2" class="input-field" placeholder="Retype your password">
				
				<br>
				
				<p id="ERROR"><?php echo $error_msg;?></p>

				<button type="submit" class="Login">Register</button>

				<div id="loginResponse"></div>

				<br>

				<h5 class="made-by">Made By Grah</h5>
			</form>

        </div>
    </body>
</html>