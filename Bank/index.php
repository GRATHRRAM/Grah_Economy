<?php 
	session_start();
	$_SESSION['BANK_$_ERR_MSG'] = null;
	$_SESSION['BANK_$_OK_MSG'] = null;
	
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
			if(!($_POST['usr2send'] === $_SESSION['login'])) {
				if(!empty($_POST['money2send'])) {
					if(ctype_digit($_POST['money2send'])) { 
						if(!($_SESSION['balance'] <= intval($_POST['money2send']))) {
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
								$newBalanceReciver = $row[3] + intval($_POST['money2send']);
								$newBalanceSender  = $_SESSION['balance'] - intval($_POST['money2send']);
								
								$sql = "UPDATE users SET balance=? WHERE Id=?";
								
								$stmt = $conn->prepare($sql);
								$stmt->bind_param("ii", $newBalanceReciver, $row[0]);
								
								if (!$stmt->execute()) {
									$_SESSION['BANK_$_ERR_MSG'] = "Error updating record: " . $conn->error;
								}
								
								$stmt->close();
								
								$stmt = $conn->prepare($sql);
								$stmt->bind_param("ii", $newBalanceSender, $_SESSION['id']);
								
								if ($stmt->execute()) {
									$_SESSION['balance'] = $newBalanceSender;
									$_SESSION['BANK_$_ERR_MSG'] = null;
									$_SESSION['BANK_$_OK_MSG'] = "Operation Successful<br>Money Recived<br>By " . $row[1];
									header("Refresh:3");
								} else {
									$_SESSION['BANK_$_ERR_MSG'] = "Error updating record: " . $conn->error;
								}
								
								$stmt->close();
							} 
							else {$_SESSION['BANK_$_ERR_MSG'] = "User Don't Exist!";}
						} else {$_SESSION['BANK_$_ERR_MSG'] = "You Don't Have Enough Money";}
					} else {$_SESSION['BANK_$_ERR_MSG'] = "Only Numbers Can Be Typed<br>In Money Field";}
				} else {$_SESSION['BANK_$_ERR_MSG'] = "Money Field Is Empty";}
			} else {$_SESSION['BANK_$_ERR_MSG'] = "You Can't Send Money To You're Self";}
		} else {$_SESSION['BANK_$_ERR_MSG'] = "User Field Is Empty";}
		
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
					<h2 class="mtitle">Send Money</h2>
					<input class="if" name="usr2send" placeholder="Username To Recive Money"></input> <br> <br>
					<input class="if" name="money2send" placeholder="Amount Of Money To Send"></input> <br>
					<p class="merror"><?php if($_SESSION['BANK_$_ERR_MSG'] != null) {echo $_SESSION['BANK_$_ERR_MSG'];}?></p>
					<p class="mok"><?php if($_SESSION['BANK_$_OK_MSG'] != null) {echo $_SESSION['BANK_$_OK_MSG'];}?></p>
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
