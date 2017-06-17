<?php
	require_once('connection.php');
	
	session_start();
	if(!isset($_SESSION['id']))
	{
		header('location:../index.php');
    	exit;
    }    

    if(isset($_POST['search']))
    	if(isset($_POST['search-text']))
    	{
    		$_SESSION['search']=$_POST['search-text'];
    		header('Location: search.php');
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
				<li><a href="advanced-search.php">Advanced Search</a></div></li>
				<li><a href="profile.php">Profile</a></div></li>
				<li><a href="logout.php">Logout</a></div></li>
			</ul>
        </nav>

	</header>

	<main>

		<div class="search">
			<form method="post" action="">
				<input type="text" name="search-text" placeholder="Search.." required>
				<button type="submit" name="search">Search</button>
			</form>
		</div>
		
		<?php

			$stid = oci_parse($conn, "SELECT o.id, o.name, c.name, d.name, d.locked FROM users u 
			JOIN closets c on u.id=c.user_id 
			JOIN drawers d on c.id=d.closet_id 
			JOIN objects o on d.id=o.drawer_id WHERE u.id=".$_SESSION['id']." AND (o.name like '%".$_SESSION['search']."%' or o.id in (select object_id from properties WHERE property_name like '%".$_SESSION['search']."%' or property_value like '%".$_SESSION['search']."%'))");
		    oci_execute($stid);

		 	$count=0;

				while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
					$stid2 = oci_parse($conn, 'SELECT property_name, property_value FROM properties WHERE object_id='.$row[0]);
					oci_execute($stid2);	 
					echo '
					<form action="';

					if($row[4]==0)
						echo 'drawers.php?drawer-name='.$row[3];
					else
						echo 'drawer-locked.php?drawer-name='.$row[3];

					echo '" class="form object" method="post">
						<h1>Object Name: '.$row[1].'</h1>
						<p>Closet Name: '.$row[2].'</p> <p>Drawer Name: '.$row[3].'</p>
						<div class="property">';
						while (($row2 = oci_fetch_array($stid2, OCI_BOTH)) != false) {
							echo  '<p>'.$row2[0].': '.$row2[1].'</p>';
						}

					echo '</div>
							<button name="edit-object">Go to Drawer</button>
						</form>';
					$count++;
				}

			if($count==0)
				echo '<img class="box" src="images/box.png" alt="Empty Box">';

		?>

	</main>

	<footer>
		<ul>
			<li><a href="">Contact</a></li>
			<li><a href="">About</a></li>
		</ul>
	</footer>
</body>
</html>