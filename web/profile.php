<?php
	require_once('connection.php');
	
	session_start();
	if(!isset($_SESSION['id']))
	{
		header('location:../index.php');
    	exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>DulApp Profile</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/reset.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/jquery-3.2.1.min.js"></script>
</head>
<body>
	
	<header>
		<div class="logo"><a href="home.php"><img src="images/logo.png" alt="Logo"></a></div>
		<nav>
			<ul>
				<li><a href="home.php">Home</a></div></li>
				<li><a href="objects.php">Objects</a></div></li>
				<li><a href="profile.php">Profile</a></div></li>
				<li><a href="logout.php">Logout</a></div></li>
			</ul>
        </nav>

	</header>

	<main>
		<div class="profile">
			<p>Username: PCodrin </p>
			<p>Firstname: Codrin</p>
			<p>Lastname: Popa </p>
			<p>Email: pcodrin96@gmail.com</p>
		</div>

		<form class="form home" action="#" id="drawer-form">
			<h1>Edit Profile</h1>
			<input type="text" name="fname" placeholder="username" required>
			<input type="text" name="fname" placeholder="firstname" required>
			<input type="text" name="fname" placeholder="lastname" required>
			<input type="text" name="fname" placeholder="email" required>

			<button type="submit" name="submit">Submit changes!</button>
			

		</form>
	</main>

	<footer>
		<ul>
			<li><a href="">Contact</a></li>
			<li><a href="">About</a></li>
		</ul>
	</footer>
</body>
</html>