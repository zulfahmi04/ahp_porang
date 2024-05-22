<?php
//koneksi.php
$dbhost="localhost";
$dbname="db_sc_spk_ahp";
$dbuser="root";
$dbpassword="";

// create connection 
$koneksi = new mysqli($dbhost, $dbuser, $dbpassword, $dbname); 
 
// check connection 
if($koneksi->connect_error) {
    die("Koneksi Gagal : " . $koneksi->connect_error);
}

if(mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}
?>