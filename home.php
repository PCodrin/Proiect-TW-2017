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
				<li><a href="index.php">Logout</a></div></li>
			</ul>
        </nav>

	</header>

	<main>
		<div class="search">
			<input type="text" name="search" placeholder="Search..">
			<button type="submit" name="submit"><a href="advanced-search.php">Advanced Search</a></button>
		</div>
		<form class="form home" action="#">
		
			<button type="submit" name="submit">Create</button>
			<input type="text" name="#" placeholder="Closet Name">

			<button type="submit" name="submit">Edit</button>
			<button type="submit" name="submit">Delete</button>

		</form>
		
        <a href="#"><img class="arrow-left" src="images/arrow-left.png" alt="Arrow left"></a>
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
        <a href="#"><img class="arrow-right" src="images/arrow-right.png" alt="Arrow right"></a>
		
		<form class="form home" action="#">
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
		<input type="text" name="fname" placeholder="Drawer Name">

		<button type="submit" name="submit">Edit</button>
		<button type="submit" name="submit">Delete</button>
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