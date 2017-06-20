<?php

	require_once('connection.php');
	
	session_start();

	header('Content-type: application/json');

	$stid = oci_parse($conn, 'SELECT id, name FROM closets');
  	oci_execute($stid);
  	$closets=array();
  	while (($closet = oci_fetch_array($stid, OCI_BOTH)) != false) {
  				
					
				$stid4 = oci_parse($conn,  "SELECT  name,id FROM  drawers   WHERE closet_id=".$closet[0]);
				oci_execute($stid4);
  				$drawers = array();
  				while (($drawer = oci_fetch_array($stid4, OCI_BOTH)) != false){ 
  						$stid5 = oci_parse($conn,  "SELECT  name FROM  objects   WHERE drawer_id=".$drawer[1]);
						oci_execute($stid5);
						$objects=array();
						while (($object = oci_fetch_array($stid5, OCI_BOTH)) != false) {
								$objects[]=$object[0];
						}
						$drawers[]=array('name' => $drawer[0],"objects"=>  $objects);

				}
				$closets[]=array('name' => $closet[1],'drawers'=> $drawers);
	}
			echo json_encode($closets);

?>



