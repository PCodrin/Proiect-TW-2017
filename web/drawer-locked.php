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

  	$_SESSION['drawer-name']=$_GET['drawer-name'];
  	
    $stid = oci_parse($conn, "SELECT ID FROM DRAWERS WHERE CLOSET_ID=".$_SESSION['closet-id']." AND NAME='".$_SESSION['drawer-name']."'");
	oci_execute($stid);
	while (oci_fetch($stid))
    	$drawer_id = oci_result($stid, 'ID');
    $_SESSION['drawer-id']=$drawer_id;

  if (isset($_POST['unlock'])) {
    if(isset($_POST['password']))
    {	
    	$sql = 'SELECT PASSWORD FROM DRAWERS WHERE ID='.$drawer_id;
	    $stid = oci_parse($conn, $sql);
	    oci_execute($stid);
	    while (oci_fetch($stid))
	    $drawer_password = oci_result($stid, 'PASSWORD');
		if($_POST['password']==$drawer_password)
			header('Location: drawers.php?drawer-name='.$_SESSION['drawer-name']);
		else
			header('Location: drawer-locked.php?drawer-name='.$_SESSION['drawer-name'].'&msg=wrong-password');
    }
  }

  if(isset($_POST['back']))
	header('Location:home.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>DulApp Codrin Popa, Lupu Teodor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/reset.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/form-effect.js"></script>
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
		
        <div class="form">
            <form class="drawer-locked" method="post" action="">
              <input type="password" name="password" placeholder="Drawer Password" required/>
              <button type="submit" name="unlock">Unlock</button>
            </form>
        </div>
	</main>

	<?php require_once('footer.php'); ?>