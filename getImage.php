<?php
$conn = mysqli_connect("localhost", "root", "", "test"); 
if (isset($_GET['id'])) {
    $sql = "SELECT image FROM images WHERE id=?";
    $statement = $conn->prepare($sql);
    $statement->bind_param("i", $_GET['id']);
    $statement->execute() or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysqli_connect_error());
    $result = $statement->get_result();

    $row = $result->fetch_assoc();
    header("Content-type: " . 'image/jpeg');
    echo $row["image"];
}
?>