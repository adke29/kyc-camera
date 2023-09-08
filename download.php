<?php
    $conn = mysqli_connect("localhost", "root", "", "test");
    $sql = "SELECT * FROM `images` WHERE `id` = " . $_GET["id"];
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0)
    {
        die("File does not exists.");
    }
    $row = mysqli_fetch_object($result);
    header("Content-type: " . $row->type);
    echo $row->image;
?>