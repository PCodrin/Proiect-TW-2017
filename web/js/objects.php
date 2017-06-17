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
	<title>DulApp Objects</title>
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
		<div class="search">
		<form>
			<input type="text" name="search" placeholder="Search..">
			<button type="submit" name="submit"><a href="advanced-search.php">Advanced Search</a></button>
		</form>
		</div>
		<div class="objects">
			<h1>Object:</h1>
			<ol>
				<li>Propriety:</li>
				<li>Propriety:</li>
				<li>Propriety:</li>
			</ol>
			<h1>Object:</h1>
			<ol>
				<li>Propriety:</li>
				<li>Propriety:</li>
				<li>Propriety:</li>
			</ol>
			<h1>Object:</h1>
			<ol>
				<li>Propriety:</li>
				<li>Propriety:</li>
				<li>Propriety:</li>
			</ol>
			<h1>Object:</h1>
			<ol>
				<li>Propriety:</li>
				<li>Propriety:</li>
				<li>Propriety:</li>
			</ol>
			<h1>Object:</h1>
			<ol>
				<li>Propriety:</li>
				<li>Propriety:</li>
				<li>Propriety:</li>
			</ol>
			<h1>Object:</h1>
			<ol>
				<li>Propriety:</li>
				<li>Propriety:</li>
				<li>Propriety:</li>
			</ol>
			<h1>Object:</h1>
			<ol>
				<li>Propriety:</li>
				<li>Propriety:</li>
				<li>Propriety:</li>
			</ol>
			<h1>Object:</h1>
			<ol>
				<li>Propriety:</li>
				<li>Propriety:</li>
				<li>Propriety:</li>
			</ol>
		</div>

		<form class="form home" action="#">
		
			<button type="submit" name="submit">Create</button>
			<input type="text" name="#" placeholder="Object Name">

			<button type="submit" name="submit">Edit</button>
			<button type="submit" name="submit">Delete</button>

		</form>

		<form class="form home" action="#">
			 <select name="drawers" form="drawer-form">
				  <option value="drawer1">Object 1</option>
				  <option value="drawer2">Object 2</option>
				  <option value="drawer3">Object 3</option>
			</select>
			<input type="text" name="#" placeholder="Propriety Name">

			<button type="submit" name="submit">Add propriety</button>

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