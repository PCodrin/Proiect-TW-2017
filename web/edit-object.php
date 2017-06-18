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

    $stid = oci_parse($conn, 'SELECT u.id FROM users u JOIN closets c on u.id=c.user_id JOIN drawers d on c.id=d.closet_id JOIN objects o on d.id=o.drawer_id WHERE o.id='.$_GET['object-id']);
	oci_execute($stid);
	while (oci_fetch($stid))
    	$user_id = oci_result($stid, 'ID');

    if(!($user_id==$_SESSION['id']))
   	{
		header('location:../home.php');
    	exit;
    }
    
    if(isset($_POST['back']))
	    header('Location:drawers.php?drawer-name='.$_SESSION['drawer-name']);

	if (isset($_POST['add-property'])) {
    	if(isset($_POST['property-name']) && isset($_POST['property-value']))
    	{
    		$sql = 'BEGIN properties_package.add_property(:v_object_id, :v_property_name, :v_property_value); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_object_id",$_GET['object-id'],32);
		    oci_bind_by_name($stmt,":v_property_name",$_POST['property-name'],32);
		    oci_bind_by_name($stmt,":v_property_value",$_POST['property-value'],32);
		    oci_execute($stmt);
    	}
   	}

    if (isset($_POST['edit-object-name'])) {
    	if(isset($_POST['object-name']))
    	{
    		$sql = 'BEGIN objects_package.edit_object_name(:v_object_id, :v_object_name); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_object_id",$_GET['object-id'],32);
		    oci_bind_by_name($stmt,":v_object_name",$_POST['object-name'],32);
		    oci_execute($stmt);
    	}
   	}

   	if (isset($_POST['edit-property-name'])) {
    	if(isset($_POST['property-name']))
    	{	
    		$sql = 'BEGIN properties_package.edit_property_name(:v_property_id, :v_property_name); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_property_id",$_POST['property'],32);
		    oci_bind_by_name($stmt,":v_property_name",$_POST['property-name'],32);
		    oci_execute($stmt);
    	}
   	}
   	
   	if (isset($_POST['edit-property-value'])) {
    	if(isset($_POST['property-value']))
    	{	
    		$sql = 'BEGIN properties_package.edit_property_value(:v_property_id, :v_property_value); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_property_id",$_POST['property2'],32);
		    oci_bind_by_name($stmt,":v_property_value",$_POST['property-value'],32);
		    oci_execute($stmt);
    	}
   	}

   	if (isset($_POST['delete-property'])){	
    	$sql = 'BEGIN properties_package.delete_property(:v_property_id); END;';
    	$stmt = oci_parse($conn,$sql);
		oci_bind_by_name($stmt,":v_property_id",$_POST['property3'],32);
		oci_execute($stmt);
    }

    if (isset($_POST['move-object'])){	
    	$sql = 'BEGIN objects_package.move_object(:v_object_id, :v_drawer_id); END;';
    	$stmt = oci_parse($conn,$sql);
		oci_bind_by_name($stmt,":v_object_id",$_GET['object-id'],32);
		oci_bind_by_name($stmt,":v_drawer_id",$_POST['property4'],32);
		oci_execute($stmt);
    }

    if (isset($_POST['delete-object'])){	
    	$sql = 'BEGIN objects_package.delete_object(:v_object_id); END;';
    	$stmt = oci_parse($conn,$sql);
		oci_bind_by_name($stmt,":v_object_id",$_GET['object-id'],32);
		oci_execute($stmt);
		header('Location: drawers.php?drawer-name='.$_SESSION['drawer-name']);
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
			<form method="post" action="">
				<input type="text" name="search-text" placeholder="Search.." required>
				<button type="submit" name="search">Search</button>
			</form>
		</div>
		
		<form class="form-drawers" action="" method="post">
			<button type="submit" name="back">Go Back</button>
		</form>

			<form class="form home" action="" method="post">
				
				<button type="submit" name="add-property">Add Property</button>
				<input type="text" name="property-name" placeholder="Property Name" required />
				<input type="text" name="property-value" placeholder="Property Value" required />
				
			</form>

			<form class="form home" action="" method="post">
				
				<button type="submit" name="edit-object-name">Edit Object Name</button>
				<input type="text" name="object-name" placeholder="New Object Name" required>
				
			</form>

			<form class="form home" action="" method="post">
				
				<button type="submit" name="edit-property-name">Edit Property Name</button>
				<input type="text" name="property-name" placeholder="New Property Name" required>
				
				<?php

					
					$stid = oci_parse($conn, 'SELECT property_name, property_value, id FROM properties WHERE object_id='.$_GET['object-id']);
					oci_execute($stid);

					echo '<select name="property" >';
					while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
						echo '<option value="'.$row[2].'">'.$row[0].': '.$row[1].'</option>';
					}
					echo '</select>';
				
				?>
			</form>

			<form class="form home" action="" method="post">
				
				<button type="submit" name="edit-property-value">Edit Property Value</button>
				<input type="text" name="property-value" placeholder="New Property Value" required>
				<?php

					
					$stid = oci_parse($conn, 'SELECT property_name, property_value, id FROM properties WHERE object_id='.$_GET['object-id']);
					oci_execute($stid);

					echo '<select name="property2">';
					while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
						echo '<option value="'.$row[2].'">'.$row[0].': '.$row[1].'</option>';
					}
					echo '</select>';
				
				?>
			</form>


			<form class="form home" action="" method="post">
				<button type="submit" name="delete-property">Delete Property</button>

				<?php

					$stid = oci_parse($conn, 'SELECT property_name, property_value, id FROM properties WHERE object_id='.$_GET['object-id']);
					oci_execute($stid);

					echo '<select name="property3" class="delete-object-select">';
					while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
						echo '<option value="'.$row[2].'">'.$row[0].': '.$row[1].'</option>';
					}
					echo '</select>';
				
				?>
			</form>

			<form class="form home" action="" method="post">
				<button type="submit" name="move-object">Move Object</button>
				<?php

					$stid = oci_parse($conn, 'SELECT c.name, d.name, d.id FROM closets c JOIN drawers d on c.id=d.closet_id WHERE c.user_id='.$_SESSION['id'].' AND d.id NOT LIKE '.$_SESSION['drawer-id']);
					oci_execute($stid);

					echo '<select name="property4" class="delete-object-select">';
					while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
						echo '<option value="'.$row[2].'">'.$row[0].': '.$row[1].'</option>';
					}
					echo '</select>';
				
				?>
			</form>

			<form class="form home" action="" method="post">
				<button type="submit" name="delete-object">Delete Object</button>
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