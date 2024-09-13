<?php
$conn = mysqli_connect('localhost', 'root', '', 'oshimpodb');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>