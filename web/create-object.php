<?php
	require_once('connection.php');
	
	session_start();
	
	if(!isset($_SESSION['id']))
	{
		header('location:../index.php');
    	exit;
    }

    if(isset($_POST['back']))
	    header('Location:drawers.php?drawer-name='.$_SESSION['drawer-name']);

	if (isset($_POST['create-object'])) {
    	if(isset($_POST['object-name']) && isset($_POST['property-name']) && isset($_POST['property-value']))
    	{
    		$sql = 'BEGIN objects_package.create_object(:v_drawer_id, :v_object_name, :v_property_name, :v_property_value); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_drawer_id",$_SESSION['drawer-id'],32);
		    oci_bind_by_name($stmt,":v_object_name",$_POST['object-name'],32);
		    oci_bind_by_name($stmt,":v_property_name",$_POST['property-name'],32);
		    oci_bind_by_name($stmt,":v_property_value",$_POST['property-value'],32);
		    oci_execute($stmt);
    	}
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

		<form class="form-drawers" action="" method="post">
			<button type="submit" name="back">Go Back</button>
		</form>

		<form class="form home" action="" method="post">
			
			<button type="submit" name="create-object">Create Object</button>
			<input type="text" name="object-name" placeholder="Object Name" required />
			<input type="text" name="property-name" placeholder="Property" required />
			<input type="text" name="property-value" placeholder="Property Value"required />
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