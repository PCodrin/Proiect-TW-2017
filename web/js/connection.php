<?php
	
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

?>