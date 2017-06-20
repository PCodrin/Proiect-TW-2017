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

    if(isset($_POST['edit-drawer']))
		header('Location: edit-drawer.php?drawer-name='.$_SESSION['drawer-name']);

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
   	
	$sql = 'SELECT count(id) FROM objects WHERE drawer_id = '.$_SESSION['drawer-id'];
	$stid = oci_parse($conn, $sql);
	oci_execute($stid);

	while (oci_fetch($stid))
    	$count_id_objects = oci_result($stid, 'COUNT(ID)');

    
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
		
		<form class="form-drawers" action="home.php" method="post">
			<button type="submit" name="back">Go Back</button>
		</form>

		<form class="form home" action="" method="post">

			<button name="edit-drawer">Edit Drawer</button>
			
		</form>
		
		<form class="form home" action="" method="post">
			
			<button type="submit" name="create-object">Create Object</button>
			<input type="text" name="object-name" placeholder="Object Name" required />
			<input type="text" name="property-name" placeholder="Property Name" required />
			<input type="text" name="property-value" placeholder="Property Value" required />
		</form>

		<?php
			
			if($count_id_objects>0)
			{
				$stid = oci_parse($conn, 'SELECT id, name FROM objects WHERE drawer_id='.$_SESSION['drawer-id']);
				oci_execute($stid);	 
				while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
					$stid2 = oci_parse($conn, 'SELECT property_name, property_value FROM properties WHERE object_id='.$row[0]);
					oci_execute($stid2);	 
					echo '
					<form action="edit-object.php?object-id='.$row[0].'" class="form object" method="post">
						<h1>Object Name: '.$row[1].'</h1>
						<div class="property">';
						while (($row2 = oci_fetch_array($stid2, OCI_BOTH)) != false) {
							echo  '<p>'.$row2[0].': '.$row2[1].'</p>';
						}

					echo '</div>
							<button name="edit-object">Edit Object</button>
						</form>';
				}
			}
			else
				echo '<img class="box" src="images/box.png" alt="Empty Box">';

		?>
	</main>

	<?php require_once('footer.php'); ?>