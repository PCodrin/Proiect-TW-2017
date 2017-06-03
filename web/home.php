<?php
	require_once('connection.php');

	session_start();
	if(!isset($_SESSION['id']))
	{
		header('location:../index.php');
    	exit;
    }
    if(isset($_GET["page"]))
    	$_SESSION['page']=$_GET["page"];
    else
    	$_SESSION['page']=0;

    echo $_SESSION['page'];

    if (isset($_POST['create-closet'])) {
    	if(isset($_POST['closet-name']))
    	{
    		$id=$_SESSION['id'];
    		$closet_name=$_POST['closet-name'];
    		$sql = 'BEGIN closets_package.create_closet(:v_user_id, :v_closet_name, :v_output); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_user_id",$id,32);
		    oci_bind_by_name($stmt,":v_closet_name",$closet_name,32);
		    oci_bind_by_name($stmt,":v_output",$closet_success,32);
		    oci_execute($stmt);
    	}
    	
	    if ($closet_success>0)
	        header('Location:home.php?page='.$closet_success);
	    else
	        header('LOCATION:home.php?msg=failed-name');
    }

    elseif (isset($_POST['edit-closet']))
    {
    	if(isset($_POST['closet-name']))
    	{
    		$id=$_SESSION['page']+1;
    		$closet_name=$_POST['closet-name'];
    		$sql = 'BEGIN closets_package.edit_closet(:v_id, :v_closet_name, :v_output); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_id",$id,32);
		    oci_bind_by_name($stmt,":v_closet_name",$closet_name,32);
		    oci_bind_by_name($stmt,":v_output",$closet_success,32);
		    oci_execute($stmt);
    	}
    	
	    if ($closet_success==0)
	        header('Location:home.php?page='.$id);
	    else
	        header('LOCATION:home.php?msg=failed-name');
    }
	elseif (isset($_POST['delete-closet']))
	{
		$id=$_SESSION['page']+1;
    	$closet_name=$_POST['closet-name'];
    	$sql = 'BEGIN closets_package.delete_closet(:v_id); END;';
    	$stmt = oci_parse($conn,$sql);
		oci_bind_by_name($stmt,":v_id",$id,32);
		oci_execute($stmt);
	}

    if (isset($_POST['create-drawer'])) {
    	if(isset($_POST['drawer-name']))
    	{

    		$id=1;
    		$drawer_name=$_POST['drawer-name'];
    		$sql = 'BEGIN drawers_package.create_drawer(:v_closet_id, :v_drawer_name, :v_locked, :v_password, :v_output); END;';
    		$stmt = oci_parse($conn,$sql);
		   	oci_bind_by_name($stmt,":v_closet_id",$id,32);
		    oci_bind_by_name($stmt,":v_drawer_name",$drawer_name,32);
    		if(isset($_POST['chkpass']))
    			$locked=1;
    		else
    			$locked=0;

    		oci_bind_by_name($stmt,":v_locked",$locked,32);

    		if(isset($_POST['password']))
    			{
    				$password=$_POST['password'];
    				oci_bind_by_name($stmt,":v_password",$password,32);
    			}
    		else
    			$password="das";
    		
    		oci_bind_by_name($stmt,":v_output",$drawer_success,32);
    		oci_execute($stmt);

		    if ($drawer_success>0)
		        header('Location:home.php?page='.$drawer_success);
		    else
		        header('LOCATION:home.php?msg=failed-name');
		}
    }
    

    elseif (isset($_POST['edit-drawer']))
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
	        header('Location:home.php?page='.$drawer_success);
	    else
	        header('LOCATION:home.php?msg=failed-name');
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
		<div class="logo"><a href="index.php"><img src="images/logo.png" alt="Logo"></a></div>
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
			<input type="text" name="search" placeholder="Search..">
			<button type="submit" name="submit"><a href="advanced-search.php">Advanced Search</a></button>
		</div>

		<form class="form home" action="home.php" method="post">
		
			<button type="submit" name="create-closet">Create</button>
			<input type="text" name="closet-name" placeholder="Closet Name">

			<button type="submit" name="edit-closet">Edit</button>
			<button type="submit" name="delete-closet">Delete</button>
			
			<?php
                if (isset($_GET["page"]) && $_GET["page"] > '0') {
                echo '<p class="message success">Closet created or edited!</p>';
                }

                if (isset($_GET["msg"]) && $_GET["msg"] == 'failed-name') {
                echo '<p class="message wrong">Closet name already exist!';
                }
            ?>
		</form>
		<?php $_SESSION['page']=$_GET["page"]-1; echo '<a href="home.php?page='.$_SESSION['page'].'">'; ?> <img class="arrow-left" src="images/arrow-left.png" alt="Arrow left"></a>
	        <table>
			  <tr>
			    <th colspan="4"></th>
			  </tr>
			  <tr>
			    <td></td>
			    <td></td>
			    
			  </tr>
			  <tr>
			    <td></td>
			    <td></td>
			  </tr>
			  <tr>
			    <td></td>
			    <td></td>  
			  </tr>
			  <tr>
			    <td></td>
			    <td></td>
			  </tr>
			   <tr>
			    <td></td>
			    <td></td>
			  </tr>
			</table>
        <?php $_SESSION['page']=$_GET["page"]+1; echo '<a href="home.php?page='.$_SESSION['page'].'">';  ?><img class="arrow-right" src="images/arrow-right.png" alt="Arrow right"></a>
		
		<form class="form home" action="home.php" method="post">
		<button type="submit" name="create-drawer">Create</button>
			 <select name="drawers" form="drawer-form">
				  <option value="drawer1">Drawer 1</option>
				  <option value="drawer2">Drawer 2</option>
				  <option value="drawer3">Drawer 3</option>
				  <option value="drawer4">Drawer 4</option>
				  <option value="drawer5">Drawer 5</option>
				  <option value="drawer6">Drawer 6</option>
				  <option value="drawer7">Drawer 7</option>
				  <option value="drawer8">Drawer 8</option>
				  <option value="drawer9">Drawer 9</option>
				  <option value="drawer10">Drawer 10</option>
			</select>
		<input type="text" name="drawer-name" placeholder="Drawer Name">

		<button type="submit" name="edit-drawer">Edit</button>
		<button type="submit" name="delete-drawer">Delete</button>

		<input type="checkbox" placeholder="PIN" class="pin" name="chkpass"/>
   		<input type="text" placeholder="PIN Code" class="pincode" name="password"/>

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