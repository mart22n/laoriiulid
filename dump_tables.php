<?php
require './common.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM Items";

$result = $conn->query($sql);
if (!$result) {
	echo "Error: " . $conn->error;
}

if ($result->num_rows > 0) {
    // output data of each row
		echo "Items: <br>";
    while($row = $result->fetch_assoc()) {
        echo "nimi: " . $row["nimi"] ."<br>";
		echo "augu_suurus: " . $row["augu_suurus"] ."<br>";
		echo "augu_intervall: " . $row["augu_intervall"] ."<br>";
		echo "saadavus: " . $row["saadavus"] ."<br>";
		echo "link: " . $row["link"] ."<br>";
		echo "hashtag: " . $row["hashtag"] ."<br>";
		echo "soovitused: " . $row["soovitused"] ."<br>";
		echo "alternatiivid: " . $row["alternatiivid"] ."<br>";
		echo "===<br>";
    }
} else {
    echo "Items: 0 results";
}

$sql = "SELECT * FROM Items_pictures";

$result = $conn->query($sql);
if (!$result) {
	echo "Error: " . $conn->error;
}

if ($result->num_rows > 0) {
    // output data of each row
	echo "Items_pictures: <br>";
    while($row = $result->fetch_assoc()) {
		echo "riiuli_nimi: " . $row["riiuli_nimi"]. "<br>";
        echo "pildi_nimi: " . $row["pildi_nimi"]. "<br>";
		echo "===<br>";
    }
} else {
    echo "Items_pictures: 0 results";
}

$sql = "SELECT * FROM Tellimused";

$result = $conn->query($sql);
if (!$result) {
	echo "Error: " . $conn->error;
}

if ($result->num_rows > 0) {
    // output data of each row
	echo "Tellimused: <br>";
    while($row = $result->fetch_assoc()) {
		echo "riiuli_nimi: " . $row["riiuli_nimi"]. "<br>";
        echo "eesnimi: " . $row["eesnimi"]. "<br>";
		echo "===<br>";
    }
} else {
    echo "Riiulid_pildid: 0 results";
}



$conn->close();
?>