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
else if(isset($_POST["add_item"])) {
	$action = "add_item";
}

$nimi = $_POST["nimi"]; 
$nimi = $conn->real_escape_string($nimi);

$augu_suurus = $_POST["augu_suurus"]; 

$augu_intervall = $_POST["augu_intervall"]; 

$saadavus = $_POST["saadavus"]; 

$link = $_POST["link"]; 
$link = (substr($link, 0, 4) == "http" ? $link : "http://" . $link);
$link = $conn->real_escape_string($link);

$link_vt = $_POST["link_vaata_saadavust"]; 
$link_vt = (substr($link_vt, 0, 4) == "http" ? $link_vt : "http://" . $link_vt);
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
			echo "Viga: kõigi riiulite kustutamine ebaõnnestus! (' . $conn->error . ')";
		} else {
			echo "Riiulite andmed edukalt kustutatud.";
		}
		break;
	case "delete_item":
		$sql = "DELETE FROM Items WHERE nimi = '" . $nimi . "'";
		$result = $conn->query($sql);

		if (!$result) {
			echo "Viga: riiuli kustutamine ebaõnnestus! (' . $conn->error . ')";
		} else {
			echo "Riiuli andmed edukalt kustutatud.";
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
			echo "Viga: riiuli info uuendamine ebaõnnestus! (' . $conn->error . ')";
			$error = true;
		}
		
		if(isset($_SESSION["filenames"]) && count($_SESSION["filenames"] > 0)) {
			foreach($_SESSION["filenames"] as $filename) {
				$sql = "INSERT INTO Items_pictures (riiuli_nimi, pildi_nimi) VALUES ('$nimi', '$filename')";
				$result = $conn->query($sql);
				if (!$result) {
					$error = true;
					echo "Viga: riiuli info uuendamine ebaõnnestus! (' . $conn->error . ')";
				}
			}
		}
		else
		{
			$sql = "DELETE FROM Items_pictures WHERE riiuli_nimi = '" . $nimi . "'";
			$result = $conn->query($sql);
			if (!$result) {
				$error = true;
				echo "Viga: riiuli piltide kustutamine andmebaasist ebaõnnestus! (' . $conn->error . ')";
			}
		}
		if(!$error) {
			echo "Riiuli andmed edukalt uuendatud.";
		}
		break;
	case "add_item":
		$nimi_input = $_POST["nimi_input"]; 
		$nimi_input = $conn->real_escape_string($nimi_input);
		if(isset($_SESSION["filenames"]) && count($_SESSION["filenames"] > 0)) {
			$filename = $_SESSION["filenames"][0];
			$sql = "INSERT INTO Items (
				nimi,
				augu_suurus,
				augu_intervall,
				saadavus, link,
				link_vaata_saadavust,
				hashtag, soovitused,
				alternatiivid,
				pildi_nimi) VALUES ('	$nimi_input', '$augu_suurus', '$augu_intervall',
				'$saadavus', '$link', '$link_vt', '$hashtag', '$soovitused', '$alternatiivid', '$filename')";
		}
		else {
			$sql = "INSERT INTO Items (
				nimi,
				augu_suurus,
				augu_intervall,
				saadavus,
				link,
				link_vaata_saadavust,
				hashtag,
				soovitused,
				alternatiivid) VALUES ('$nimi_input', '	$augu_suurus', '$augu_intervall',
				'$saadavus', '$link', '$link_vt', '$hashtag', '$soovitused', '$alternatiivid')";
		}
	
		exec_query($conn, $sql);
		if(strlen($conn->error) > 0) {
			echo "Viga: riiuli lisamine andmebaasi ebaõnnestus, kontrolli, ega samanimelist riiulit varem lisatud pole. (' . $conn->error . ')";
			$conn->close();
			exit_nicely($conn->error, 1);
		}
		
		if(isset($_SESSION["filenames"]) && count($_SESSION["filenames"] > 0)) {
			foreach($_SESSION["filenames"] as $filename) {
		
				$sql = "INSERT INTO Items_pictures (riiuli_nimi, pildi_nimi) VALUES ('$nimi_input', '$filename')";
				exec_query($conn, $sql);
			}
		}
		echo "Riiul edukalt lisatud.";
		break;
}

$conn->close();
session_unset();
?>