<?php
    $conn = mysqli_connect("localhost", "root", "", "test");
    $sql = "SELECT id, name FROM `images` ORDER BY `id` DESC";
    $result = mysqli_query($conn, $sql);
     
    while ($row = mysqli_fetch_object($result))
    {
?>
<p>
    <a href="download.php?id=<?php echo $row->id; ?>" target="_blank">
        <?php echo $row->name; ?>
    </a>
</p>
<?php } ?>