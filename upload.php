<?php
// assume you have a database named 'test'
//CREATE TABLE `test`.`images` (`id` TINYINT NOT NULL AUTO_INCREMENT , `name` TEXT NOT NULL , `type` TEXT NOT NULL , `image` LONGBLOB NOT NULL , `video` LONGBLOB NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
$conn = mysqli_connect("localhost", "root", "", "test");
$image = $_FILES["image"];
$video = $_FILES["video"];


// $info = getimagesize($image["tmp_name"]);
// if (!$info) {
//     die("File is not an image");
// }
$blob = addslashes(file_get_contents($image["tmp_name"]));
// $blob = addslashes(file_get_contents($image["tmp_name"]));
$videoBlob = addslashes(file_get_contents($video["tmp_name"]));
$sql = "INSERT INTO `mod_kyc` (`image_blob`, `video_blob`) VALUES ('" . $blob . "' , '".$videoBlob. "')";
mysqli_query($conn, $sql) or die(mysqli_error($conn));

echo "File has been uploaded.";
?>