<?php
session_start();
require './common.php';
$conn = create_conn();

$nimi = $_POST["nimi"]; 
$nimi = $conn->real_escape_string($nimi);


$sql = "DELETE FROM Items_pictures WHERE riiuli_nimi = '" . $nimi . "'";
$result = $conn->query($sql);
if (!$result) {
	echo "Viga: riiuli piltide kustutamine ebaõnnestus! (' . $conn->error . ')";
}

unset($_SESSION["filenames"]);
$conn->close();
			
?>