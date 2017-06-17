<?php
	require_once('connection.php');

	session_start();
	if(!isset($_SESSION['id']))
	{
		header('location:../index.php');
    	exit;
    }

    if(isset($_GET["page"]))
    	$page=$_GET["page"];
    else
    	$page=1;

     // SELECT

    $sql = 'SELECT count(id) FROM closets WHERE user_id = '.$_SESSION['id'];
	$stid = oci_parse($conn, $sql);
	oci_execute($stid);

	while (oci_fetch($stid))
    	$count_id_closets = oci_result($stid, 'COUNT(ID)');

    // CREATE CLOSET

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
    	$sql = 'SELECT count(id) FROM closets WHERE user_id = '.$_SESSION['id'];
	    $stid = oci_parse($conn, $sql);
		oci_execute($stid);

	    while (oci_fetch($stid))
    	    $count_id_closets = oci_result($stid, 'COUNT(ID)');

		
	    if ($closet_success>0)
	    	if($count_id_closets==1)
				header('Location:home.php');
	    	else
	        	header('Location:home.php?page='.$count_id_closets);
	    else
	        header('LOCATION:home.php?msg=failed-name');
    }

    // EDIT CLOSET
    
    if (isset($_POST['edit-closet']))
    {
    	if(isset($_POST['closet-name']))
    	{	
    		$sql = 'SELECT * FROM (SELECT ID, ROWNUM AS ROW_NUMBER FROM CLOSETS WHERE USER_ID='.$_SESSION['id'].'ORDER BY ID) WHERE ROW_NUMBER = '.$page;
			$stid = oci_parse($conn, $sql);
			oci_execute($stid);
			while (oci_fetch($stid))
    			$id = oci_result($stid, 'ID');
    			 
    		$closet_name=$_POST['closet-name'];
    		$sql = 'BEGIN closets_package.edit_closet(:v_id, :v_closet_name, :v_output); END;';
    		$stmt = oci_parse($conn,$sql);
		    oci_bind_by_name($stmt,":v_id",$id,32);
		    oci_bind_by_name($stmt,":v_closet_name",$closet_name,32);
		    oci_bind_by_name($stmt,":v_output",$closet_success,32);
		    oci_execute($stmt);
    	}

    	
	    if ($closet_success==0)
	        header('Location:home.php?page='.$page);
	    else
	        header('LOCATION:home.php?msg=failed-name');
    }

    // DELETE CLOSET
    
	if (isset($_POST['delete-closet']))
	{
		if(isset($_POST['closet-name']))
    	{	
    		$sql = 'SELECT * FROM (SELECT ID, ROWNUM AS ROW_NUMBER FROM CLOSETS WHERE USER_ID='.$_SESSION['id'].'ORDER BY ID) WHERE ROW_NUMBER = '.$page;
			$stid = oci_parse($conn, $sql);
			oci_execute($stid);

				while (oci_fetch($stid))
    			  	$id = oci_result($stid, 'ID');
    	$sql = 'BEGIN closets_package.delete_closet(:v_id); END;';
    	$stmt = oci_parse($conn,$sql);
		oci_bind_by_name($stmt,":v_id",$id,32);
		oci_execute($stmt);
		}

		$sql = 'SELECT count(id) FROM closets WHERE user_id = '.$_SESSION['id'];
		$stid = oci_parse($conn, $sql);
		oci_execute($stid);

		while (oci_fetch($stid))
	    	$count_id_closets = oci_result($stid, 'COUNT(ID)');
	}

	// CREATE DRAWER
	
    if (isset($_POST['create-drawer'])) {
    	if(isset($_POST['drawer-name']))
    	{	
    		$page=$page-1;
    		$sql = 'SELECT * FROM (SELECT ID, ROWNUM AS ROW_NUMBER FROM CLOSETS WHERE USER_ID='.$_SESSION['id'].'ORDER BY ID) WHERE ROW_NUMBER = '.$page;
			$stid = oci_parse($conn, $sql);
			oci_execute($stid);
			while (oci_fetch($stid))
    			$closet_id = oci_result($stid, 'ID');

    		$drawer_name=$_POST['drawer-name'];
    		$sql = 'BEGIN drawers_package.create_drawer(:v_closet_id, :v_drawer_name, :v_locked, :v_password, :v_output); END;';
    		$stmt = oci_parse($conn,$sql);
		   	oci_bind_by_name($stmt,":v_closet_id",$closet_id,32);
		    oci_bind_by_name($stmt,":v_drawer_name",$drawer_name,32);
    		if(isset($_POST['chkpass']))
    		{
    			$locked=1;
    			if(isset($_POST['password']) && isset($_POST['re-password']))
	    		{
	    			$password=$_POST['password'];
	    			$re_password=$_POST['re-password'];
	    			if($password==$re_password)
	    				oci_bind_by_name($stmt,":v_password",$password,32);
	    			else
	    				header('Location:home.php?msg=wrong-repassword');
	    		}
    		}
    		else
    		{	
    			$locked=0;
    			oci_bind_by_name($stmt,":v_password",$password,32);
    		}

    		
    		oci_bind_by_name($stmt,":v_locked",$locked,32);
    		
    		oci_bind_by_name($stmt,":v_output",$drawer_success,32);
    		oci_execute($stmt);

		    if ($drawer_success>=0)
		        header('Location:home.php?page='.$page);
		    else
		        header('LOCATION:home.php?msg=failed-name');
		}
    }
    
    $_SESSION['page']=$page;
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
	<script type="text/javascript">
		$(document).ready(function(){
        $('.chkpass').click(function(){
        	
        	$('.passwords').animate({height: "toggle", opacity: "toggle"}, "slow");
        	
      	});
    });
	</script>
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
			<input type="text" name="search" placeholder="Search..">
			<button type="submit" name="submit"><a href="advanced-search.php">Search</a></button>
		</div>

		<form class="form home" <?php if($page==1) echo 'action="home.php"'; else echo 'action="home.php?page='.$page.'"'; ?> method="post">
		
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
		 <?php 
		 	if($count_id_closets>0)
		 	{
			 	if(isset($_GET['page'])) 
			 	{
			 		$page_closet=$page;
			 		if($_GET['page']<2)
		        		header('Location:home.php');
			 		if($page==2) 
			 		{	
			 			$page=$_GET["page"]-1;
			 			echo '<a href="home.php">';
			 		}
			 		else 
			 		{	
			 			$page=$_GET["page"]-1; 
			 			echo '<a href="home.php?page='.$page.'">'; 
			 		}
			 	}
			 	else
			 	{
			 		$page_closet=1;
			 		echo '<a href="home.php">';
			 	}
			 	echo '<img class="arrow-left" src="images/arrow-left.png" alt="Arrow left"></a>';
			
			
		 

		 		
		 	
		 		$sql = 'SELECT * FROM (SELECT ID, ROWNUM AS ROW_NUMBER FROM CLOSETS WHERE USER_ID='.$_SESSION['id'].'ORDER BY ID) WHERE ROW_NUMBER = '.$page_closet;
				$stid = oci_parse($conn, $sql);
				oci_execute($stid);
				while (oci_fetch($stid))
	    			$closet_id = oci_result($stid, 'ID');

	    		$sql = 'SELECT name FROM CLOSETS WHERE ID='.$closet_id;
	    		$stid = oci_parse($conn, $sql);
	    		oci_execute($stid);
	    		while (oci_fetch($stid))
	    			$closet_name = oci_result($stid, 'NAME');
		        echo '<table>
				  <tr>
				    <th colspan="4">'.$closet_name.'</th>
				  </tr>';
				  $stid = oci_parse($conn, 'SELECT name, locked FROM drawers where closet_id='.$closet_id);
				  oci_execute($stid);
				  $i=1;
				  $_SESSION['closet-id']=$closet_id;
				  while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
					  if($i%2==1)
					  	if($row[1]==1)
					  		echo '<tr><td><a href="drawer-locked.php?drawer-name='.$row[0].'">'.$row[0].'</a><img src="images/locked.png" alt="Locked"></td>';
					  	else
					  		echo '<tr><td><a href="drawers.php?drawer-name='.$row[0].'">'.$row[0].'</a></td>';
					  else
					  	if($row[1]==1)
					  		echo '<td><a href="drawer-locked.php?drawer-name='.$row[0].'">'.$row[0].'</a><img src="images/locked.png" alt="Locked"></td></tr>';
					  	else
					  		echo '<td><a href="drawers.php?drawer-name='.$row[0].'">'.$row[0].'</a></td></tr>';

					  $i++;
				  }

				  for($k=$i; $k<=10; $k++)
				  {
				  	if($k%2==1)
					  	echo '<tr><td></td>';
					  else
					  echo '<td></td></tr>';
				  }

				echo '</table>';
			
		
        
	        	if(isset($_GET['page'])) 
	        	{	
	        		if($_GET['page']>$count_id_closets)
	        			header('Location:home.php?page='.$count_id_closets);

	        		if($page<$count_id_closets) 
	        			{
	        				$page=$_GET["page"]+1; 
	        				echo '<a href="home.php?page='.$page.'">';
	        			} 
	        			else 
	        				echo '<a href="home.php?page='.$page.'">';
	        	} 
	        	else 
	        			if($count_id_closets==0)
							echo '<a href="home.php">';
						else
						{
		        			$page=2;
		        			echo '<a href="home.php?page='.$page.'">';
	        			}
	        	echo '<img class="arrow-right" src="images/arrow-right.png" alt="Arrow right"></a>';
	        	echo '<form class="form home" ';
	        	 if($page==1) 
	        	 	echo 'action="home.php"'; 
	        	 else echo 'action="home.php?page='.$page.'"'; 
	        	 echo 'method="post">
						<button type="submit" name="create-drawer">Create</button>
						<input type="text" name="drawer-name" placeholder="Drawer Name">
						
						<label for="checkbox">Locked?</label>
						<input type="checkbox" placeholder="PIN" class="chkpass" name="chkpass"/>
						<div class="passwords">
							<input type="text" placeholder="Password" class="password" name="password"/>
					   		<input type="text" placeholder="Re-Password" class="re-password" name="re-password"/>
					   	</div>

					</form>';
	        }
        ?>

        <div class="home form pass">
        	<input type="text" class="text" placeholder="Drawer Password">
			<button name="drawer-pass">Submit</button>
        </div>
		
		

	</main>

	<footer>
		<ul>
			<li><a href="">Contact</a></li>
			<li><a href="">About</a></li>
		</ul>
	</footer>
</body>
</html>