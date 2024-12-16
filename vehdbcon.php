<?php
$con = mysqli_connect("localhost", "root", "", "vehicle_ownerdb", 3307);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
