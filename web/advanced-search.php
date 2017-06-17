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
	<title>DulApp Homepage</title>
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
				<li><a href="advanced-search.php">Search</a></div></li>
				<li><a href="profile.php">Profile</a></div></li>
				<li><a href="index.php">Logout</a></div></li>
			</ul>
        </nav>

	</header>

	<main>
		
		<form class="form advanced">
		
		
			<h1>Filter:</h1>	
			<p>Closets</p>
			<select name="drawers" form="drawer-form">
				  <option value="drawer1">Drawer 1</option>
				  <option value="drawer2">Drawer 2</option>
				  <option value="drawer3">Drawer 3</option>
				  <option value="drawer4">Drawer 4</option>
				  <option value="drawer5">Drawer 5</option>
				  <option value="drawer6">Drawer 6</option>
				  <option value="drawer7">Drawer 7</option>
				  <option value="drawer8">Drawer 8</option>
				  <option value="drawer9">Drawer 9</option>
				  <option value="drawer10">Drawer 10</option>
			</select>

		
			<p>Drawers</p>

			<select name="drawers" form="drawer-form">
				  <option value="drawer1">Drawer 1</option>
				  <option value="drawer2">Drawer 2</option>
				  <option value="drawer3">Drawer 3</option>
				  <option value="drawer4">Drawer 4</option>
				  <option value="drawer5">Drawer 5</option>
				  <option value="drawer6">Drawer 6</option>
				  <option value="drawer7">Drawer 7</option>
				  <option value="drawer8">Drawer 8</option>
				  <option value="drawer9">Drawer 9</option>
				  <option value="drawer10">Drawer 10</option>
			</select>

			<p>Creation date</p>
			

			<input id="date" type="date" value="2017-06-01">

			<button type="submit" name="submit">Search</button>
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