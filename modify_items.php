<?php require './common.php';
$conn = create_conn();

if (isset($_POST["change_item"])) {
	$action = "change_item";
}
else if (isset($_POST["delete_item"])) {
	$action = "delete_item";
}
else if (isset($_POST["delete_all"])) {
	$action = "delete_all";
}

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

switch($action) {
	case "delete_all":
		$sql = "DROP TABLE Items, Items_pictures";
		$result = $conn->query($sql);

		if (!$result) {
			echo '<script type="text/javascript">alert("Viga: k&otilde;igi riiulite kustutamine eba&otilde;nnestus! (' . $conn->error . ')");</script>';
		} else {
			echo "<script type='text/javascript'>alert('Riiulite andmed edukalt kustutatud.');</script>";
		}
		break;
	case "delete_item":
		$sql = "DELETE FROM Items WHERE nimi = '" . $nimi . "'";
		$result = $conn->query($sql);

		if (!$result) {
			echo '<script type="text/javascript">alert("Viga: riiuli kustutamine eba&otilde;nnestus! (' . $conn->error . ')");</script>';
		} else {
			echo "<script type='text/javascript'>alert('Riiuli andmed edukalt kustutatud.');</script>";
		}
		break;
	case "change_item":
		if(isset($_SESSION["filenames"]) && count($_SESSION["filenames"] > 0)) {
			$filename = $_SESSION["filenames"][0];
			$sql = "UPDATE Items SET
				augu_suurus='" . $augu_suurus . "',
				augu_intervall='" . $augu_intervall . "',
				saadavus='" . $saadavus . "',
				link='" . $link . "',
				link_vaata_saadavust='" . $link_vt . "',
				hashtag='" . $hashtag . "',
				soovitused='" . $soovitused . "',
				alternatiivid='" . $alternatiivid . "',
				pildi_nimi='" . $filename . "' WHERE nimi = '" . $nimi . "'";
		}
		else
		{
			$sql = "UPDATE Items SET
				augu_suurus='" . $augu_suurus . "',
				augu_intervall='" . $augu_intervall . "',
				saadavus='" . $saadavus . "',
				link='" . $link . "',
				link_vaata_saadavust='" . $link_vt . "',
				hashtag='" . $hashtag . "',
				soovitused='" . $soovitused . "',
				alternatiivid='" . "' WHERE nimi = '" . $nimi . "'";	
		}
		$result = $conn->query($sql);

		$error = false;
		if (!$result) {
			echo '<script type="text/javascript">alert(\'Viga: riiuli info uuendamine eba&otilde;nnestus! (' . $conn->error . '\');</script>';
			$error = true;
		}
		
		if(isset($_SESSION["filenames"]) && count($_SESSION["filenames"] > 0)) {
			foreach($_SESSION["filenames"] as $filename) {
				$sql = "INSERT INTO Items_pictures (riiuli_nimi, pildi_nimi) VALUES ('$nimi', '$filename')";
				$result = $conn->query($sql);
				if (!$result) {
					$error = true;
					echo '<script type="text/javascript">alert("' . $conn->error . '");</script>';
				}
			}
		}
		else
		{
			$sql = "DELETE FROM Items_pictures WHERE riiuli_nimi = '" . $nimi . "'";
			$result = $conn->query($sql);
			if (!$result) {
				$error = true;
				echo '<script type="text/javascript">alert("Viga: riiuli piltide kustutamine eba&otilde;nnestus! (' . $conn->error . ')");</script>';
			}
		}
		if(!$error) {
			echo "<script type='text/javascript'>alert('Riiuli andmed edukalt uuendatud.');</script>";
		}
		break;
		//case "add":
}

$conn->close();
session_unset();
?>