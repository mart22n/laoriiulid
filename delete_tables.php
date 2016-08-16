<?php
require './common.php';

$conn = create_conn();

$sql = "DROP TABLE Items";

$result = $conn->query($sql);
if (!$result) {
	echo "Error: " . $conn->error;
} else {
    echo "OK: tabel \"Items\" kustutatud <br>";
}

$sql = "DROP TABLE Items_pictures";

$result = $conn->query($sql);
if (!$result) {
	echo "Error: " . $conn->error;
} else {
    echo "OK: tabel \"Items_pictures\" kustutatud <br>";
}

$sql = "DROP TABLE Tellimused";

$result = $conn->query($sql);
if (!$result) {
	echo "Error: " . $conn->error;
} else {
    echo "OK: tabel \"Tellimused\" kustutatud <br>";
}

$conn->close();
?>