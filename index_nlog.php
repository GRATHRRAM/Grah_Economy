<?php 
	session_start();
	
	$_SESSION['SERVERNAME'] = "localhost";
	$_SESSION['USERNAME'] = "root";
	$_SESSION['PASSWORD'] = "";
	$_SESSION['DBNAME'] = "gigabank";
	
	$_SESSION['id'] = null;
	$_SESSION['login'] = null;
	$_SESSION['balance'] = null;
	$_SESSION['mainpg_msg'] = null;
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
			<p class="err">YOU ARE NOT LOGGED IN!!!</p>
		</div>
		
		<script src="index.js"></script>
	</body>
</html>