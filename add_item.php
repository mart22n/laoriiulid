<?php 
require './common.php';
$conn = create_conn();

$nimi = $_POST["nimi"]; 
$nimi = $conn->real_escape_string($nimi);

$augu_suurus = $_POST["augu_suurus"]; 

$augu_intervall = $_POST["augu_intervall"]; 

$saadavus = $_POST["saadavus"]; 

$link = $_POST["link"]; 
$link = "http://" . $link;
$link = $conn->real_escape_string($link);

$link_vt = $_POST["link_vaata_saadavust"]; 
$link_vt = "http://" . $link_vt;
$link_vt = $conn->real_escape_string($link_vt);

$hashtag = $_POST["hashtag"];

$soovitused = $_POST["soovitused"]; 
$soovitused = $conn->real_escape_string($soovitused);

$alternatiivid = $_POST["alternatiivid"]; 
$alternatiivid = $conn->real_escape_string($alternatiivid);

if(isset($_SESSION["filenames"]) && count($_SESSION["filenames"] > 0)) {
	$filename = $_SESSION["filenames"][0];
	$sql = "INSERT INTO Items (nimi, augu_suurus, augu_intervall, saadavus, link, link_vaata_saadavust, hashtag, soovitused, alternatiivid, pildi_nimi) VALUES ('$nimi', '$augu_suurus', '$augu_intervall',
	'$saadavus', '$link', '$link_vt', '$hashtag', '$soovitused', '$alternatiivid', '$filename')";
}
else {
	$sql = "INSERT INTO Items (nimi, augu_suurus, augu_intervall, saadavus, link, link_vaata_saadavust, hashtag, soovitused, alternatiivid) VALUES ('$nimi', '$augu_suurus', '$augu_intervall',
	'$saadavus', '$link', '$link_vt', '$hashtag', '$soovitused', '$alternatiivid')";
}

exec_query($conn, $sql);
if(strlen($conn->error) > 0) {
	echo '<script type="text/javascript">alert("Viga: riiuli lisamine andmebaasi eba&ouml;nnestus, kontrolli, ega samanimelist riiulit varem lisatud pole. (' . $conn->error . ')");</script>';
	$conn->close();
	exit_nicely($conn->error, 1);
	
}

 //do not allow to add same picture to multiple shelves
 //$sql = "SELECT nimi FROM Pildid WHERE riiuli_id = '$riiuli_id'";

// $result = $conn->query($sql);

// if (!$result) {
	// echo "Error: " . $conn->error;
// }

// if ($result->num_rows == 1) {
	// echo "<script type='text/javascript'>alert('Sama nimega pilt on juba andmebaasis, muuda pildi nime.');</script>";
// }
if(isset($_SESSION["filenames"]) && count($_SESSION["filenames"] > 0)) {
	foreach($_SESSION["filenames"] as $filename) {

		$sql = "INSERT INTO Items_pictures (riiuli_nimi, pildi_nimi) VALUES ('$nimi', '$filename')";
		exec_query($conn, $sql);
	}
}
$conn->close();
session_unset();
echo "<script type='text/javascript'>alert('Riiul edukalt lisatud.');</script>";
?>
