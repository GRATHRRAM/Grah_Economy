<?php
	session_start();

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "gigabank";

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

				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

				$sql = "INSERT INTO users (login, password, balance) VALUES ('$login', '$hashedPassword', '$Balance')";

				if ($conn->query($sql) === TRUE) {
					echo "Registration successful!";
					$_SESSION['username'] = $login;
					header("location: ../index.php");
				} else {
					echo "Error: " . $conn->error;
				}
			} else {header("location: register_err_pass.html");}
		} else {header("location: register_err_empty.html");}
	}

	$conn->close();
?>