<?php
	require './common.php';
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Laomaailm AS <info@laomaailm.ee>' . "\r\n";
	$headers .= 'Reply-To: info@laomaailm.ee' . "\r\n";
	$headers .= 'Cc:' . laomaailm_email_addr . "\r\n";
	$headers .= 'Cc:' . admin_email_addr . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();
	
	$phonePartOfMsg = (strlen($_POST["phone"]) > 0 ? "telefon: " . $_POST["phone"] . "<br><br>" : "<br>");
	
	$msg = "" . $_POST["nimi"] . ", t&auml;name tellimuse eest. Tellimus on edastatud Laomaailm AS-le.<br><br>
	
	<b>Tellimuse detailid:</b><br>
	tellimuse esitamise aeg: " . date("j.m.Y G:i:s", time()) . "<br>
	riiuli nimi: " . $_POST["riiuli_nimi"] . "<br>
	augu suurus: " . $_POST["augu_suurus"] . "<br>
	augu intervall: " . $_POST["augu_intervall"] . "<br>
	saadavus: " . $_POST["saadavus"] . "<br>
	link: " . $_POST["link"] . "<br><br>
	
	<b>Tellija andmed:</b><br>
	nimi: " . $_POST["nimi"] . "<br>
	e-mail: " . $_POST["email"] . "<br>
	" . $phonePartOfMsg . "
	=====================<br>
	Olete saanud selle e-kirja, sest Laomaailm AS infos&uuml;steemis vormistati tellimus,
	mille kontaktiks m&auml;rgiti Teie e-posti aadress. K&uuml;simuste korral p&ouml;&ouml;rduge info@laomaailm.ee.";
	if(mail($_POST["email"], "Tellimuse kinnitus, Laomaailm AS", $msg, $headers) == true) {
		$conn = create_conn();
	
		$riiuli_nimi = $_POST["riiuli_nimi"]; 
		$riiuli_nimi = $conn->real_escape_string($riiuli_nimi);
		
		$nimi = $_POST["nimi"]; 
		$nimi = $conn->real_escape_string($nimi);
		
		$email = $_POST["email"]; 
		$email = $conn->real_escape_string($email);
		
		$phone = $_POST["phone"]; 
		$phone = $conn->real_escape_string($phone);
		
		$sql = "INSERT INTO Tellimused (riiuli_nimi, nimi, email, telefon, timestamp)
		VALUES ('$riiuli_nimi', '$nimi', '$email', '$phone', 'time()')";
		
		exec_query($conn, $sql);
		if(strlen($conn->error) > 0) {
			echo '<script type="text/javascript">alert("Viga: tellimuse vormistamine eba&otilde;nnestus. (' . $conn->error . ')");</script>';
			$conn->close();
			exit_nicely($conn->error, 1);
			
		}
		else
		{
			$conn->close();
			echo "<h3><p align='center'>Tere, t&auml;name, et olete esitanud Laomaailmale p&auml;ringu toote " . $_POST["riiuli_nimi"] . " kohta. </p><br><br>
			<p>Edastatud on j&auml;rgnev:</p>";
			echo "<p>Soovin infot toote " . $_POST["riiuli_nimi"] . " kohta. <br><br>Nimi: " . $_POST["nimi"] . "<br><br>E-mail: " .
			$_POST["email"] . "<br><br>" . $phonePartOfMsg . "Lisainfo: " . $_POST["lisainfo"] . "</p></h3>";
            echo '<button class="pure-button pure-button-primary" style="margin-left: 30px;" onclick="history.go(-1);">Tagasi</button>';
		}
	}
	else {
		echo '<script type="text/javascript">alert("Viga: tellimuse kinnitus-meili saatmine eba&otilde;nnestus. Palun saada tellimus meiliaadressile info@laomaailm.ee");</script>';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Tellimuse kinnitus - Laomaailm AS</title>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
<link rel="stylesheet" href="style.css" type="text/css">