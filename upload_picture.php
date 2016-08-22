<?php
session_start();
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Fail ei ole pilt.";
        $uploadOk = 0;
    }
}
// Check if file already exists
//if (file_exists($target_file)) {
//    echo "Sama nimega fail on juba serveris.";
//    $uploadOk = 0;
//}
// Check file size
if ($_FILES["file"]["size"] > 5000000) {
    echo "Fail on liiga suur.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Ainult JPG, JPEG, PNG ja GIF failid on lubatud.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo " Üleslaadimine ebaõnnestus.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
		
		if($_SESSION["filenames"] == null) {
			$_SESSION["filenames"] = array($target_file);
		}
		else
		{
			if(!in_array($target_file, $_SESSION["filenames"])) {
				array_push($_SESSION["filenames"],$target_file);
			}
		}
    } else {
        echo " Üleslaadimine ebaõnnestus.";
    }
	echo "success";
}
?> 