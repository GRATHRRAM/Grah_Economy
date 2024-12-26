<?php 
	session_start();
	
	/*
	function Check_If_Exist($login, &$conn) {
		$sql = "SELECT * FROM users WHERE login = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $login);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
					
		$row = $result->fetch_row();
		$result->free_result();
		
		if ($row[0] > 0) { return true; }
		else { return false; } 
	}*/
	
	function SendMoney() {
		$conn = new mysqli($_SESSION['SERVERNAME'], $_SESSION['USERNAME'], $_SESSION['PASSWORD'], $_SESSION['DBNAME']);

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		if(!empty($_POST['usr2send'])) {
			if(!empty($_POST['money2send'])) {
				if(ctype_digit($_POST['money2send'])) { 
					if($_SESSION['balance'] <= intval($_POST['money2send'])) {
						$username = $conn->real_escape_string($_POST['usr2send']);
						$sql = "SELECT * FROM users WHERE login = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param("s", $username);
						$stmt->execute();
						$result = $stmt->get_result();
						$stmt->close();
									
						$row = $result->fetch_row();
						$result->free_result();
						
						if ($row != null) { //user exist
							$newBalanceReciver = $row['balance'] + intval($_POST['money2send']);
							$newBalanceSender  = $_SESSION['balance'] - intval($_POST['money2send']);
							
							$sql = "UPDATE users SET balance=? WHERE Id=?";
							
							$stmt = $conn->prepare($sql);
							$stmt->bind_param("ii", $newBalanceReciver, $row['Id']);
							
							if ($stmt->execute()) {
								echo "Operation 1 ok;";
							} else {
								echo "Error updating record: " . $conn->error;
							}
							
							$stmt->close();
							
							$stmt = $conn->prepare($sql);
							$stmt->bind_param("ii", $newBalanceSender, $_SESSION['Id']);
							
							if ($stmt->execute()) {
								echo "Operation 2 ok;";
								$_SESSION['balance'] = $newBalanceSender;
							} else {
								echo "Error updating record: " . $conn->error;
							}
							
							$stmt->close();
						} 
						else { echo "not exist!"; }
					} else {echo "U Not That Rich Bozo";}
				} else {echo "Only numbers in money";}
			} else {echo "money empty";}
		} else {echo "User empty";}
		
		$conn->close();
	}
?>

<html>
    <head>
		<title>Grah Bank</title>
		<meta name="description" content="Grah Bank">
		<meta name="keywords" content="Cool AF Bank">
		
		<link rel="stylesheet" href="index.css">
    </head>
	<body>
		<section class="layout">
			<div class="header">Grah Bank</div>
			
			<div class="body">
				<div class="Money1"><img src="images/money1.jpg" width="255" height="255" alt="Cash$$$"></div>
			</div>
			
			<div class="rightSide">
				<div id="Balance">Balance: <?php echo $_SESSION['balance']; ?>$</div>
				
				<?php
					if(array_key_exists('sendbutton', $_POST)) {
						SendMoney();
					}
				?>
				
				<form method="Post" class="SendMoneyFrom">
					<input class="usr2send" name="usr2send" placeholder="Username To Recive Monay"></input> <br>
					<input class="money2send" name="money2send" placeholder="Amount Of Monay To Send"></input> <br>
					<button class="sendbutton" name="sendbutton" >Send</button>
				</form>
			</div>
			
			<div class="leftSide">
				<p class="username">Username -> <?php echo $_SESSION['login'];?></p>
			</div>
			
			<!--<div class="footer">Logs</div>-->
		</section>
		
	</body>
</html>
