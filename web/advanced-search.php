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
    		$_SESSION['case']=0;
    		$_SESSION['search']=$_POST['search-text'];
    		header('Location: search.php');
    	}

    if(isset($_POST['search-submit']))
    	if($_POST['advanced-search']=="" && $_POST['date']=="")
    	{
    		$_SESSION['case']=1;
    		$_SESSION['property']=$_POST['property'];
    		header('Location: search.php');
    	}
    	elseif($_POST['date']=="")
    	{
    		$_SESSION['case']=2;
    		$_SESSION['property']=$_POST['property'];
    		$_SESSION['advanced-search']=$_POST['advanced-search'];
    		header('Location: search.php');
    	}
		elseif ($_POST['advanced-search']=="") {
		    $_SESSION['case']=3;
    		$_SESSION['property']=$_POST['property'];
    		$_SESSION['date']=$_POST['date'];
    		header('Location: search.php');
		}
		else{
			$_SESSION['case']=4;
    		$_SESSION['property']=$_POST['property'];
    		$_SESSION['advanced-search']=$_POST['advanced-search'];
    		$_SESSION['date']=$_POST['date'];
    		header('Location: search.php');
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
				<li><a href="advanced-search.php">Advanced Search</a></div></li>
				<li><a href="profile.php">Profile</a></div></li>
				<li><a href="index.php">Logout</a></div></li>
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
		
		<form class="form object" method="post" action="">
		
			<h1>Filter:</h1>	

				<h2>Select Closet and Drawer: </h2>
				<?php

					$stid = oci_parse($conn, 'SELECT c.name, d.name, d.id FROM closets c JOIN drawers d on c.id=d.closet_id WHERE c.user_id='.$_SESSION['id']);
					oci_execute($stid);

					echo '<select name="property" class="delete-object-select">';
					while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
						echo '<option value="'.$row[2].'">'.$row[0].': '.$row[1].'</option>';
					}
					echo '</select>';
				
				?>
		
			<input type="text" name="advanced-search" placeholder="Search..">
			
			<h2>Select Creation Date:</h2>
			<input name="date" type="date">

			<button type="submit" name="search-submit">Search</button>
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