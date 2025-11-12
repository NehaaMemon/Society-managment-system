<?php
include './partials/layouts/layoutTop.php';


$id=$_GET['id'];
$q1 = "DELETE FROM `blocks` WHERE `id` = '$id'";
$q2 = "DELETE FROM `blockexp` WHERE `bl_id` = '$id'";




mysqli_query($con,$q1);
mysqli_query($con,$q2);



echo "<script>alert('Selected Block is Deleted')</script>";
echo "<script>window.open('addblock.php','_self')</script>";
?>
