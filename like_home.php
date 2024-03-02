<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['userid'])) {
    // Redirect to login page if user is not logged in
    header("location:index.php");
    exit(); // Add exit to stop further execution
} else {
    $fotoid = $_GET['fotoid'];
    $userid = $_SESSION['userid'];
    // Check if the user has already liked the photo

    $ceksuka = mysqli_query($conn, "select * from likefoto where fotoid='$fotoid' and userid='$userid'");

    if (mysqli_num_rows($ceksuka) == 1) {
        // Unlike the photo
        while ($row = mysqli_fetch_array($ceksuka)) {
            $likeid = $row['likeid'];
            mysqli_query($conn, "delete from likefoto where likeid='$likeid'");
        }
    } else {
        // Like the photo
        $tanggallike = date("Y-m-d");
        mysqli_query($conn, "insert into likefoto values('','$fotoid','$userid','$tanggallike')");
    }
    
    // Redirect back to home.php with a message
    header("location:home.php?liked=true");
    exit(); // Add exit to stop further execution
}
?>
