<?php
include './partials/layouts/layoutTop.php';

if (isset($_GET['id'])) {
    $id = $_GET['id']; // Retrieve the id from the URL

    // Delete query to remove the staff entry based on the PhoneNumber
    $q1 = "DELETE FROM `staff` WHERE `PhoneNumber` = '$id'";

    if (mysqli_query($con, $q1)) {
        // Success message if deletion is successful
        echo "<script>alert('Selected staff is Deleted');</script>";
    } else {
        // Error message if there's an issue with deletion
        echo "<script>alert('Error deleting staff: " . mysqli_error($con) . "');</script>";
    }

    echo "<script>window.open('staff1.php','_self');</script>";
} else {
    echo "<script>alert('No ID provided.');</script>";
    echo "<script>window.open('staff1.php','_self');</script>";
}
?>
