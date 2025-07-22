<?php
$conn = mysqli_connect("localhost", "root", "", "financesku");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>