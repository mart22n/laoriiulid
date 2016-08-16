<?php
require './common.php';

$conn = create_conn();

$sql = (strlen($_GET['hashtag']) > 0 ? "SELECT * FROM Items WHERE hashtag = '".$_GET['hashtag']."' LIMIT ".$_GET['offsetInTable'].", ".$_GET['incrementInTable']."" : "SELECT * FROM Items LIMIT ".$_GET['offsetInTable'].", ".$_GET['incrementInTable']."");

$result = exec_query($conn, $sql);

if ($result->num_rows >= 1) {
	while($row = $result->fetch_assoc()) {
        echo json_encode($row);
        echo '<br>';
    }
}
$conn->close();
?>