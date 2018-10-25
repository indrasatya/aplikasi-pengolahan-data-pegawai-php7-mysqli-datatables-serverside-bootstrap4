<?php
// set default timezone
date_default_timezone_set("ASIA/JAKARTA");

// panggil file parameter koneksi database
require_once "database.php";

// koneksi database
$mysqli = new mysqli($con['host'], $con['user'], $con['pass'], $con['db']);

// cek koneksi
if ($mysqli->connect_error) {
    die('Koneksi Database Gagal : '.$mysqli->connect_error);
}
?>