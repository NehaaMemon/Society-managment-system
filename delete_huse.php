<?php
include './partials/layouts/layoutTop.php';


$id=$_GET['id'];
$q1 = "DELETE FROM `blk_flor_detail` WHERE `bid` = '$id'";


mysqli_query($con,$q1);




echo "<script>window.open('house_detail.php','_self')</script>";
?>
