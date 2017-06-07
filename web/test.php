<?php
require_once('connection.php');

session_start();

$sql = 'SELECT count(id) FROM closets WHERE user_id = '.$_SESSION['id']-1;
	$stid = oci_parse($conn, $sql);
	oci_execute($stid);

	while (oci_fetch($stid))
    	echo oci_result($stid, 'COUNT(ID)');
	



?>