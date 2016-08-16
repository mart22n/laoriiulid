<?php
require './common.php';

$conn = create_conn();

$sql = "SELECT nimi, augu_suurus, augu_intervall, saadavus, link, link_vaata_saadavust, hashtag, soovitused, alternatiivid FROM Items WHERE nimi= '".$_POST['nimi']."'";

$result = exec_query($conn, $sql);

if ($result->num_rows == 1) {
	$row = $result->fetch_assoc();
    echo json_encode($row);
    echo '<br>';
}

$sql = "SELECT pildi_nimi FROM Items_pictures WHERE riiuli_nimi = '".$_POST['nimi']."'";

$result = exec_query($conn, $sql);

if ($result->num_rows >= 1) {
	while($row = $result->fetch_assoc()) {
        echo json_encode($row);
        echo '<br>';
    }
}

$conn->close();
?>