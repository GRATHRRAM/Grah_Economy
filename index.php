<?php 
	session_start();
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
				<p>lmao</p>
				<div class="Money1"><img src="images/money1.jpg" width="255" height="255" alt="Cash$$$"></div>
			</div>
			
			<div class="rightSide">
				<div id="Balance">Balance: 1000$</div>
				<button onclick="GetCash()" class="GetMoney">Get Money!</button>
			</div>
			
			<div class="leftSide">
				<?php
					echo "<p>Username: " . $_SESSION['username'] . "</p>";
				?>
				<button onclick="SiteReg()" class="SiteReg">Register</button>
			</div>
			
			<!--<div class="footer">Logs</div>-->
		</section>
		
		<script src="main.js"></script>
	</body>
</html>