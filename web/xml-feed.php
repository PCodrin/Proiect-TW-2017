<?PHP
require_once('connection.php');
    $stid = oci_parse($conn, 'SELECT id, name FROM closets');
      oci_execute($stid);

$xml = new XMLWriter();

$xml->openURI("php://output");
$xml->startDocument();
$xml->setIndent(true);

  $xml->startElement("feed");
  $xml->writeAttribute('xmlns', 'http://www.w3.org/2005/Atom');
  $xml->startElement("title");
  $xml->writeRaw("DulApp");
  $xml->endElement();
  $xml->startElement("updated");
  $xml->writeRaw(date("Y-m-d\TH:i:sP"));
  $xml->endElement();
  $xml->startElement("id");
  $xml->writeRaw("http://localhost:2227/home.php");
  $xml->endElement();

while ($closet = oci_fetch_row($stid)) {

  $xml->startElement("entry");
  $xml->startElement("title");
    $xml->writeRaw($closet[1]);
    $xml->endElement();
    $xml->startElement("id");
    $xml->writeRaw($closet[0]);
    $xml->endElement();
    $xml->startElement("updated");
    $xml->writeRaw(date("Y-m-d\TH:i:sP"));
    $xml->endElement();
   	$xml->startElement('content');
  	$stid2 = oci_parse($conn,  "SELECT  name,id FROM  drawers   WHERE closet_id=".$closet[0]);
    oci_execute($stid2);
    $drawers = "";
          while (($drawer = oci_fetch_array($stid2, OCI_BOTH)) != false){ 
              $stid3 = oci_parse($conn,  "SELECT  name FROM  objects   WHERE drawer_id=".$drawer[1]);
              oci_execute($stid3);
              $objects="";
              while (($object = oci_fetch_array($stid3, OCI_BOTH)) != false) {
                  $objects=$objects.$object[0].', ';
              }
              //$drawers=array('name' => $drawer[0],"objects"=>  $objects);
              $drawers=$drawers."Drawer Name: ".$drawer[0]."  Objects: ".$objects;
          }
    $xml->writeRaw($drawers);
    $xml->endElement();
   	$xml->endElement();
 }

$xml->endElement();

header('Content-Type: application/atom+xml');
$xml->flush();
?>