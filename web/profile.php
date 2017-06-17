<?php
	require_once('connection.php');
	
	session_start();
	if(!isset($_SESSION['id']))
	{
		header('location:../index.php');
    	exit;
    }

    $user_id=$_SESSION['id'];
    
    $sql = 'SELECT username , firstname, lastname, e_mail  FROM users WHERE id = '.$user_id;
	$stid = oci_parse($conn, $sql);
	oci_execute($stid);

	while (oci_fetch($stid)){
    	$v_username = oci_result($stid, 'USERNAME');
    	$v_firstname = oci_result($stid, 'FIRSTNAME');
    	$v_lastname = oci_result($stid, 'LASTNAME');
    	$v_e_mail = oci_result($stid, 'E_MAIL');
    }

    
    if (isset($_POST['change-firstname'])) {
    
    	if(isset($_POST['new-firstname']))
    	{
    		$sql = 'BEGIN users_tw.change_user_firstname(:v_id, :v_firstname); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_id",$_SESSION['id'],32);
		    oci_bind_by_name($stmt,":v_firstname",$_POST['new-firstname'],32);
		    oci_execute($stmt);
		    
    	}
    	header('LOCATION:profile.php');
	}

	 if (isset($_POST['change-lastname'])) {
    
    	if(isset($_POST['new-lastname']))
    	{
    		$sql = 'BEGIN users_tw.change_user_lastname(:v_id, :v_lastname); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_id",$_SESSION['id'],32);
		    oci_bind_by_name($stmt,":v_lastname",$_POST['new-lastname'],32);
		    oci_execute($stmt);
		    
    	}
    	header('LOCATION: profile.php');
	}

	if (isset($_POST['change-e-mail'])){
    
    	if(isset($_POST['new-e_mail']))
    	{
    		$sql = 'BEGIN users_tw.change_user_e_mail(:v_id, :v_e_mail); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_id",$_SESSION['id'],32);
		    oci_bind_by_name($stmt,":v_e_mail",$_POST['new-e_mail'],32);
		    oci_execute($stmt);
		}
    	header('LOCATION:profile.php');
	}


    if (isset($_POST['change-password'])) 
    {
    	if(isset($_POST['password']) && isset($_POST['re-password']))
    	{
    			$password=$_POST['password'];
	    		$re_password=$_POST['re-password'];
	    		if($password==$re_password)
	    		{	
	    			$password=md5($_POST['password']);
	    			$old_password=md5($_POST['old-password']);
	    			
	    			$sql = 'BEGIN users_tw.change_user_password(:v_id, :v_new_password, :v_old_password, :v_output); END;';
    				$stmt = oci_parse($conn,$sql);
		   			oci_bind_by_name($stmt,":v_id",$_SESSION['id'],32);
		   			oci_bind_by_name($stmt,":v_new_password",$password,64);
		   			oci_bind_by_name($stmt,":v_old_password",$old_password,64);
		   			oci_bind_by_name($stmt,":v_output",$user_success,64);
		   			oci_execute($stmt);

		   			if ($user_success==0)
		       			header('Location:profile.php');
		    		else
		        		header('LOCATION:profile.php?msg=wrong-old-password');
		   		}
	    		else
	    			header('Location:profile.php?msg=wrong-repassword');	
	    			
    	}

    }

    if (isset($_POST['delete-account']))
	{
		
		$sql = 'BEGIN users_tw.delete_user(:v_id); END;';
    	$stmt = oci_parse($conn,$sql);
		oci_bind_by_name($stmt,":v_id",$_SESSION['id']);
		oci_execute($stmt);
		header("Location: logout.php");
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
				<li><a href="advanced-search.php">Advanced Search</a></div></li>
				<li><a href="profile.php">Profile</a></div></li>
				<li><a href="logout.php">Logout</a></div></li>
			</ul>
        </nav>

	</header>

	<main>
		<div class="search">
		<form>
			<input type="text" name="search" placeholder="Search..">
			<button type="submit" name="submit"><a href="advanced-search.php">Search</a></button>
		</form>
		</div>
		<div class="profile">
			<?php echo ' <p>Username: '.$v_username.' </p>
			<p>Firstname: '.$v_firstname.' </p>
			<p>Lastname: '.$v_lastname.'  </p>
			<p>Email: '.$v_e_mail.' </p>'
			?>
		</div>

			<form class="form home" action="" method="post">
				
				<button type="submit" name="change-firstname">Change Firstname</button>
				<input type="text" name="new-firstname" placeholder="New Firstname" required>
				
			</form>

			<form class="form home" action="" method="post">
				
				<button type="submit" name="change-lastname">Change Lastname</button>
				<input type="text" name="new-lastname" placeholder="New Lastname" required>
				
			</form>

			<form class="form home" action="" method="post">
				
				<button type="submit" name="change-e-mail">Change E_mail</button>
				<input type="email" name="new-e_mail" placeholder="New E_mail" required>
				
			</form>

			<form class="form home" action="" method="post">
				
				<button type="submit" name="change-password">Change Password</button>
				<input type="password" name="old-password" placeholder="Old Password" required>
				<input type="password" name="password" placeholder="New Password" required>
				<input type="password" name="re-password" placeholder="Re-Password" required>
				
			</form>

			<form class="form home" action="" method="post">
				
				<button type="submit" name="delete-account">Delete Account</button>
				
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