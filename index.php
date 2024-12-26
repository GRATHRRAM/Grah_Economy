<?php 
	session_start();
	
	$_SESSION['SERVERNAME'] = "localhost";
	$_SESSION['USERNAME'] = "root";
	$_SESSION['PASSWORD'] = "";
	$_SESSION['DBNAME'] = "gigabank";
?>

<html>
    <head>
		<title>Grah Bank</title>
		<meta name="description" content="Grah Bank">
		<meta name="keywords" content="Cool AF Bank">
		
		<link rel="stylesheet" href="index.css">
    </head>
	<body>
	
		<div class="center">
			<h2 class="title">Grah Bank</h2>
			<button onclick="SiteLog()" class="SiteLog">Login</button>
			<button onclick="SiteReg()" class="SiteReg">Register</button>
			<p class="mainpg_msg"><?php if(!empty($_SESSION['mainpg_msg'])){echo $_SESSION['mainpg_msg'];}?></p>
		</div>
		
		<script src="index.js"></script>
	</body>
</html>