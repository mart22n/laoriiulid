<?php
	require './common.php';
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Laomaailm AS <info@laomaailm.ee>' . "\r\n";
	$headers .= 'Reply-To: info@laomaailm.ee' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
	
	$msg = "" . $_POST["eesnimi"] . " " . $_POST["perenimi"] . ", t&auml;name tellimuse eest. Tellimus on edastatud Laomaailm AS-le.<br><br>
	
	<b>Tellimuse detailid:</b><br>
	tellimuse esitamise aeg: " . date("j.m.Y G:i:s", time()) . "<br>
	riiuli nimi: " . $_POST["riiuli_nimi"] . "<br>
	augu suurus: " . $_POST["augu_suurus"] . "<br>
	augu intervall: " . $_POST["augu_intervall"] . "<br>
	saadavus: " . $_POST["saadavus"] . "<br>
	link: " . $_POST["link"] . "<br><br>
	
	<b>Tellija andmed:</b><br>
	nimi: " . $_POST["eesnimi"] . " " . $_POST["perenimi"] . "<br>
	e-mail: " . $_POST["email"] . "<br><br>
	
	=====================<br>
	Olete saanud selle e-kirja, sest Laoriiulid AS infos&uuml;steemis vormistati tellimus,
	mille kontaktiks m&auml;rgiti Teie e-posti aadress. K&uuml;simuste korral p&ouml;&ouml;rduge info@laomaailm.ee.";
	if(mail($_POST["email"], "Tellimuse kinnitus, Laomaailm AS", $msg, $headers) == true) {
		$conn = create_conn();
	
		$riiuli_nimi = $_POST["riiuli_nimi"]; 
		$riiuli_nimi = $conn->real_escape_string($riiuli_nimi);
		
		$eesnimi = $_POST["eesnimi"]; 
		$eesnimi = $conn->real_escape_string($eesnimi);
		
		$perenimi = $_POST["perenimi"]; 
		$perenimi = $conn->real_escape_string($perenimi);
		
		$email = $_POST["email"]; 
		$email = $conn->real_escape_string($email);
		
		$sql = "INSERT INTO Tellimused (riiuli_nimi, eesnimi, perenimi, email, timestamp)
		VALUES ('$riiuli_nimi', '$eesnimi', '$perenimi', '$email', 'time()')";
		
		exec_query($conn, $sql);
		if(strlen($conn->error) > 0) {
			echo '<script type="text/javascript">alert("Viga: tellimuse vormistamine eba&ouml;nnestus. (' . $conn->error . ')");</script>';
			$conn->close();
			exit_nicely($conn->error, 1);
			
		}
		else
		{
			$conn->close();
			echo "<h3><p align='center'>T&auml;name tellimuse eest!</p></h3>";
		}
	}
	else {
		echo '<script type="text/javascript">alert("Viga: tellimuse kinnitus-meili saatmine eba&ouml;nnestus. Palun saada tellimus meiliaadressile info@laomaailm.ee");</script>';
	}
?>