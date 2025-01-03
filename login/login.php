<?php 
	session_start();
	
	$error_msg = "";

	$conn = new mysqli($_SESSION['SERVERNAME'], $_SESSION['USERNAME'], $_SESSION['PASSWORD'], $_SESSION['DBNAME']);


	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}


	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
		$login = $_POST['username'];
		$pass = $_POST['password'];
		if(!empty($login)) {	
			if(!empty($pass)) {
				$login = $conn->real_escape_string($login);

				$sql = "SELECT * FROM users WHERE login = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $login);
				$stmt->execute();
				$result = $stmt->get_result();


				if ($row = $result->fetch_assoc()) {
					$password = $row['password'];
					
					if(password_verify($pass, $password)){
						$result->free_result();
						$stmt->close();
						$conn->close();
						
						$_SESSION['id'] = $row['Id'];
						$_SESSION['login'] = $row['login'];
						$_SESSION['balance'] = $row['balance'];
						
						header("location: ../Bank/index.php");
					} else {
						$error_msg = "Wrong Password!";
					}
				} else {
					$error_msg = "User Don't Exist!";
				}
				
				$result->free_result();
				$stmt->close();
			} else {$error_msg = "Password Can't Be Empty!";}
		} else {$error_msg = "Login Can't Be Empty!";}
	}
	
	$conn->close();
	
?>


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
			
			<form method="POST">
				<h2>Login</h2>
				<input type="text" id="username" name="username" class="input-field" placeholder="Enter your email">

				<h2>Password</h2>
				<input type="password" id="password" name="password" class="input-field" placeholder="Enter your password">
				
				
				<div class="error"><?php echo $error_msg;?></div>
				<br>

				<button type="submit" class="Login">Login</button>
			</form>

            <div id="loginResponse"></div>

            <br>

            <h5 class="made-by">Made By Grah</h5>
        </div>
    </body>
</html>