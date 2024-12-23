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
				<div id="Balance">Balance: <?php echo $_SESSION['balance']; ?>$</div>
			</div>
			
			<div class="leftSide">
				<?php
					echo "<p>Username: " . $_SESSION['login'] . "</p>";
				?>
			</div>
			
			<!--<div class="footer">Logs</div>-->
		</section>
		
	</body>
</html>
