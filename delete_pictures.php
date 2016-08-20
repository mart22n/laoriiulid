<?php 
require './common.php';
$conn = create_conn();

$nimi = $_POST["nimi"]; 
$nimi = $conn->real_escape_string($nimi);


$sql = "DELETE FROM Items_pictures WHERE riiuli_nimi = '" . $nimi . "'";
$result = $conn->query($sql);
if (!$result) {
	echo '<script type="text/javascript">alert("Viga: riiuli piltide kustutamine eba&otilde;nnestus! (' . $conn->error . ')");</script>';
	header("HTTP/1.1 500 Internal Server Error");
}

$conn->close();
			
?>