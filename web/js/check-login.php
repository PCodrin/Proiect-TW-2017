<?php
	require_once('connection.php');

	session_start();
    $_SESSION['id']=$id;

	// OCI Connection
	$host = "//localhost/xe";
	$user = "tw";
	$password = "tw";

	$conn = oci_connect($user, $password, $host);
	if (!$conn) {
	   $m = oci_error();
	   echo $m['message'], "\n";
	   exit;
	}

	// Login Verify

   	$login_user = $_POST['login-user'];
   	$login_pass = md5($_POST['login-pass']);
	
	$sql = 'BEGIN users_tw.login(:v_username, :v_password, :v_output); END;';

	$stmt = oci_parse($conn,$sql);

	oci_bind_by_name($stmt,':v_username',$login_user,32);
	oci_bind_by_name($stmt,":v_password",$login_pass,32);
	oci_bind_by_name($stmt,":v_output",$login_success,32);

	oci_execute($stmt);

	if ($login_success>0)
		{
			header('LOCATION:home.php');
			$_SESSION['id']=$login_success;
		}
	else
		header('LOCATION:index.php?msg=failed');

	oci_close($conn);
?>