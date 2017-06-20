<?php
	
	if(isset($_POST['get-xml']))
		header('Location: xml-feed.php');

	if(isset($_POST['get-json']))
		header('Location: json-feed.php');

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
		<div class="logo"><a href="index.php"><img src="images/logo.png" alt="Logo"></a></div>
	</header>

	<main>
        <form class="form home" method="post" action="">
              <button type="submit" name="get-xml">GET XML</button>
              <button type="submit" name="get-json">GET JSON</button>
        </form>
	</main>

	<?php require_once('footer.php'); ?>