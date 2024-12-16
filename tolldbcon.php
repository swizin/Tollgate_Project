<?php
$con = mysqli_connect("localhost", "root", "", "empregister", 3307);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>