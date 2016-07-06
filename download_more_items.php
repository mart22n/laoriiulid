<?php
require './common.php';

$conn = create_conn();

$sql = "SELECT * FROM Items LIMIT ".$_GET['offsetInTable'].", ".$_GET['incrementInTable']."";

$result = exec_query($conn, $sql);

if ($result->num_rows >= 1) {
	while($row = $result->fetch_assoc()) {
        echo json_encode($row);
        echo '<br>';
    }
}
$conn->close();
?>