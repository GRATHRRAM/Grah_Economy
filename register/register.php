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
						$result->free_result();
						header("location: register_err_acexist.html");
					}
					
					$result->free_result();
					
					$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

					$sql = "INSERT INTO users (login, password, balance) VALUES ('$login', '$hashedPassword', '$Balance')";

					if ($conn->query($sql) === TRUE) {
						echo "Registration successful!";
						header("location: ../index.html");
					} else {
						echo "Error: " . $conn->error;
					}
				} else {$conn->close();header("location: register_err_passtb.html");}
			} else {$conn->close();header("location: register_err_pass.html");}
		} else {$conn->close();header("location: register_err_empty.html");}
	}
?>