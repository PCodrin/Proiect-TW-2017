<?php
	require_once('connection.php');
	
	session_start();
	
	if(!isset($_SESSION['id']))
	{
		header('location:../index.php');
    	exit;
    }

    $stid = oci_parse($conn,'SELECT locked FROM DRAWERS WHERE ID='.$_SESSION['drawer-id']);
    oci_execute($stid);
	while (oci_fetch($stid))
    	$locked = oci_result($stid, 'LOCKED');

    if(isset($_POST['back']))
	    header('Location:drawers.php?drawer-name='.$_SESSION['drawer-name']);
    

    if (isset($_POST['change-name'])) {
    	if(isset($_POST['drawer-name']))
    	{
    		$sql = 'BEGIN drawers_package.edit_drawer_name(:v_drawer_id, :v_drawer_name, :v_output); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_drawer_id",$_SESSION['drawer-id'],32);
		    oci_bind_by_name($stmt,":v_drawer_name",$_POST['drawer-name'],32);
		    oci_bind_by_name($stmt,":v_output",$drawer_success,32);
		    oci_execute($stmt);
    	}
		
	    if ($drawer_success==0)
	    {
	    	$_SESSION['drawer-name']=$_POST['drawer-name'];
	        header('Location:edit-drawer.php?drawer-name='.$_POST['drawer-name']);
	    }
	    else
	        header('LOCATION:home.php?msg=failed-name');
    }

    if (isset($_POST['change-password'])) {
    	if(isset($_POST['password']) && isset($_POST['re-password']))
    	{
    		$sql = 'BEGIN drawers_package.edit_drawer_password(:v_drawer_id, :v_new_password, :v_old_password, :v_output); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_drawer_id",$_SESSION['drawer-id'],32);
		    oci_bind_by_name($stmt,":v_new_password",$_POST['password'],32);
		    oci_bind_by_name($stmt,":v_old_password",$_POST['old-password'],32);
		    oci_bind_by_name($stmt,":v_output",$drawer_success,32);
		    oci_execute($stmt);
    	}
    }

    if (isset($_POST['make-locked'])) {
    	if(isset($_POST['password']) && isset($_POST['re-password']))
    	{
    		$sql = 'BEGIN drawers_package.make_drawer_locked(:v_drawer_id, :v_password); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_drawer_id",$_SESSION['drawer-id'],32);
		    oci_bind_by_name($stmt,":v_password",$_POST['password'],32);
		    oci_execute($stmt);
		    header("Refresh:0");
    	} 
    }

    if (isset($_POST['make-unlocked'])) {
    	if(isset($_POST['password']))
    	{
    		$sql = 'BEGIN drawers_package.make_drawer_unlocked(:v_drawer_id, :v_password, :v_output); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_drawer_id",$_SESSION['drawer-id'],32);
		    oci_bind_by_name($stmt,":v_password",$_POST['password'],32);
		    oci_bind_by_name($stmt,":v_output",$drawer_success,32);
		    oci_execute($stmt);
    	}

	    if ($drawer_success==0)
	        header("Refresh:0");
	    else
	        header('LOCATION:home.php?msg=failed-name');
    }

    if (isset($_POST['delete-drawer'])) {
    		$sql = 'BEGIN drawers_package.delete_drawer(:v_drawer_id); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_drawer_id",$_SESSION['drawer-id'],32);
		    oci_execute($stmt);
		    header('LOCATION:home.php?page='.$_SESSION['page']);
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
		<form>
			<input type="text" name="search" placeholder="Search..">
			<button type="submit" name="submit"><a href="advanced-search.php">Advanced Search</a></button>
		</form>
		</div>

		<form class="form-drawers" action="" method="post">
			<button type="submit" name="back">Go Back</button>
		</form>

		<form class="form home" action="" method="post">
			
			<button type="submit" name="change-name">Change Name</button>
			<input type="text" name="drawer-name" placeholder="Drawer Name">
			
		</form>

		<?php
		if(!$locked)
				echo '
				<form class="form home" action="" method="post">
					
					<button type="submit" name="make-locked">Make Locked</button>
					<input type="password" name="password" placeholder="Password">
					<input type="password" name="re-password" placeholder="Re-Password">
					
					
				</form>
				';
		else
			echo '
			<form class="form home" action="" method="post">
				
				<button type="submit" name="make-unlocked">Make Unlocked</button>
				<input type="password" name="password" placeholder="Password">
				
			</form>

			<form class="form home" action="" method="post">
				
				<button type="submit" name="change-password">Change Password</button>
				<input type="password" name="old-password" placeholder="Old Password">
				<input type="password" name="password" placeholder="New Password">
				<input type="password" name="re-password" placeholder="Re-Password">
				
			</form>';
		?>
		
		<form class="form home" action="" method="post">	
				<button type="submit" name="delete-drawer">Delete Drawer</button>	
		</form>

		<!-- echo '<form class="form home" ';
			        	 if($page==1) 
			        	 	echo 'action="home.php"'; 
			        	 else echo 'action="home.php?page='.$page.'"'; 
			        	 echo 'method="post">
						<button type="submit" name="create-drawer">Create</button>';
						
						echo '<select name="drawers" form="drawer-form">';
						$stid = oci_parse($conn, 'SELECT name FROM drawers where closet_id='.$closet_id);
						  oci_execute($stid);
						$i=1;
						while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
							echo '<option value="drawer'.$i.'">'.$row[0].'</option>';
							$i++;
						}
					echo '</select>';
					echo '
						<input type="text" name="drawer-name" placeholder="Drawer Name">
						
						<label for="checkbox">Locked?</label>
						<input type="checkbox" placeholder="PIN" class="chkpass" name="chkpass"/>
						<div class="passwords">
							<input type="text" placeholder="Password" class="password" name="password"/>
					   		<input type="text" placeholder="Re-Password" class="re-password" name="re-password"/>
					   	</div>
		
				   		<button type="submit" name="edit-drawer">Edit</button>
						<button type="submit" name="delete-drawer">Delete</button>
					</form>'; -->
	</main>

	<footer>
		<ul>
			<li><a href="">Contact</a></li>
			<li><a href="">About</a></li>
		</ul>
	</footer>
</body>
</html>