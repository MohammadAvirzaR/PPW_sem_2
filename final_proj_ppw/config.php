<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "secondhand";


$conn = mysqli_connect($servername,$username,$password,$dbname);

if(!$conn){
    die("koneksi gagal : ".mysqli_connect_error());
}
