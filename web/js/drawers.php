<?php
	require_once('connection.php');
	
	session_start();
	if(!isset($_SESSION['id']))
	{
		header('location:../index.php');
    	exit;
    }
    
    $_SESSION['drawer-name']=$_GET['drawer-name'];

    $stid = oci_parse($conn, "SELECT ID FROM DRAWERS WHERE CLOSET_ID=".$_SESSION['closet-id']." AND NAME='".$_SESSION['drawer-name']."'");
	oci_execute($stid);
	while (oci_fetch($stid))
    	$drawer_id = oci_result($stid, 'ID');
    $_SESSION['drawer-id']=$drawer_id;

    if(isset($_POST['edit-drawer']))
		header('Location: edit-drawer.php?drawer-name='.$_SESSION['drawer-name']);

	if(isset($_POST['create-object']))
		header('Location: create-object.php?drawer-name='.$_SESSION['drawer-name']);
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
		
		<form class="form-drawers" action="home.php" method="post">
			<button type="submit" name="back">Go Back</button>
		</form>

		<form class="form home" action="" method="post">

			<button name="edit-drawer">Edit Drawer</button>
			<button name="create-object">Create Object</button>
			
		</form>

		<img class="box" src="images/box.png" alt="Empty Box">
		
		<form class="form object">
			<h1>Masina</h1>
			<p>Test</p><p>Test2</p>
			<div class="property">
				<p>Culoare: Albastra</p>
				<p>Material: Frumos</p>
			</div>

			<button name="edit-object">Edit Object</button>
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