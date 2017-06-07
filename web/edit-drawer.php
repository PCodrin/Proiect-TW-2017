<?php
			/*if (isset($_POST['edit-drawer']))
		    {
		    	if(isset($_POST['drawer-name']))
		    	{
		    		$id=$_SESSION['id'];
		    		$drawer_name=$_POST['drawer-name'];
		    		$sql = 'BEGIN drawers_package.edit_closet(:v_id, :v_drawer_name, :v_output); END;';
		    		$stmt = oci_parse($conn,$sql);
				    oci_bind_by_name($stmt,":v_id",$id,32);
				    oci_bind_by_name($stmt,":v_drawer_name",$drawer_name,32);
				    oci_bind_by_name($stmt,":v_output",$drawer_success,32);
				    oci_execute($stmt);
		    	}
		    	
			    if ($drawer_success>0)
			        header('Location:home.php?page='.$page);
			    else
			        header('LOCATION:home.php?msg=failed-name');
		    }	    */
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
		

		<form class="form home" action="#">

			<button type="submit" name="submit">Edit Drawer</button>
			
			
		</form>
		<img class="box" src="images/box.png" alt="Empty Box">
		

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