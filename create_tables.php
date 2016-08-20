<?php
require './common.php';

$conn = create_conn();

$sql = "CREATE TABLE Items (
nimi VARCHAR(30) NOT NULL PRIMARY KEY,
augu_suurus INT NOT NULL,
augu_intervall INT NOT NULL,
saadavus ENUM('Tellimisel', 'Laos olemas'),
link TEXT,
link_vaata_saadavust TEXT,
hashtag ENUM('#kaubariiul', '#moodulriiul', '#konsoolriiul'),
soovitused TEXT,
alternatiivid TEXT,
pildi_nimi VARCHAR(30)
)";

$result = $conn->query($sql);

if (!$result) {
	echo "Error: " . $conn->error;
} else {
    echo "OK: Tabel \"Items\" loodud <br>";
}

$sql = "CREATE TABLE Items_pictures (
id INT(6) PRIMARY KEY AUTO_INCREMENT,
riiuli_nimi VARCHAR(30) NOT NULL,
pildi_nimi VARCHAR(30) NOT NULL
)";

$result = $conn->query($sql);

if (!$result) {
	echo "Error: " . $conn->error;
} else {
    echo "OK: Tabel \"Items_pictures\" loodud <br>";
}

$sql = "CREATE TABLE Tellimused (
id INT(6) PRIMARY KEY AUTO_INCREMENT,
riiuli_nimi VARCHAR(30) NOT NULL,
nimi VARCHAR(30) NOT NULL,
email VARCHAR(30) NOT NULL,
telefon VARCHAR(15),
timestamp TIMESTAMP NOT NULL,
lisainfo TEXT,
FOREIGN KEY (riiuli_nimi) REFERENCES Items(riiuli_nimi)
)";

$result = $conn->query($sql);
if (!$result) {
	echo "Error: " . $conn->error;
} else {
        echo "OK: Tabel \"Tellimused\" loodud <br>";
}
$conn->close();

?>