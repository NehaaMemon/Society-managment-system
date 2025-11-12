
<?php
 include './partials/layouts/layoutTop.php';
$id = $_GET['id'];
   $q7="SELECT * FROM `blocks`  where `id` = '$id'";
   $row = mysqli_query($con,$q7);
   $data = mysqli_fetch_assoc($row);

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Edit Block</h6>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row gy-3">
                        <div class="col-6">
                            <label class="form-label">Block Name</label>
                            <input type="text" name="blname" class="form-control"
                                   value="<?php echo htmlspecialchars($data['block_name']); ?>"
                                   required>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Total Lift</label>
                            <input type="number" name="totlft" class="form-control"
                                   value="<?php echo htmlspecialchars($data['total_lift']); ?>"
                                   required min="0">
                        </div>

                        <div class="col-6">
                            <label class="form-label">Total Camera</label>
                            <input type="number" name="totcam" class="form-control"
                                   value="<?php echo htmlspecialchars($data['total_camera']); ?>"
                                   required min="0">
                        </div>

                        <div class="col-6">
                            <label class="form-label">Total Maintenance</label>
                            <input type="number" name="totmaintan" class="form-control"
                                   value="<?php echo htmlspecialchars($data['total_maintance']); ?>"
                                   required min="0">
                        </div>

                        <div class="col-6">
                            <label class="form-label">Total House</label>
                            <input type="number" name="totho" class="form-control"
                                   value="<?php echo htmlspecialchars($data['main_house']); ?>"
                                   required min="0">
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="updateblk" class="btn btn-info">Update Block</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<br><br><br>

<?php
include './partials/layouts/layoutBottom.php';


if (isset($_POST['updateblk'])) {
    $blname = mysqli_real_escape_string($con, $_POST['blname']);
    $totlft = intval($_POST['totlft']);
    $totcam = intval($_POST['totcam']);
    $totmaintan = intval($_POST['totmaintan']);
    $totho = intval($_POST['totho']);

    $q4 = "
        UPDATE `blocks`
        SET 
            `block_name` = '$blname',
            `Total_lift` = '$totlft',
            `Total_camera` = '$totcam',
            `total_maintance` = '$totmaintan',
            `main_house` = '$totho'
        WHERE `id` = $id
    ";

    if (mysqli_query($con, $q4)) {
        echo "<script>alert('Block updated successfully'); window.open('addblock.php', '_self');</script>";
    } else {
        echo "Error updating block: " . mysqli_error($con);
    }
}
?>

<?php 
include './partials/layouts/layoutBottom.php';

// if (isset($_POST['updatestaff'])) {
//     // Retrieve form data
//     $name = $_POST['name'];
//     $position = $_POST['position'];
//     $salary = $_POST['salary'];
//     $phone = $_POST['phone'];
//     $joining_date = $_POST['joining_date'];
//     $department = $_POST['department'];
//     $shift_timing = $_POST['shift_timing'];
//     $status = $_POST['status'];

//     // Update query for the "staff" table
//     $q4 = "
//         UPDATE `staff`
//         SET 
//             `Name` = '$name',
//             `Position` = '$position',
//             `Salary` = '$salary',
//             `PhoneNumber` = '$phone',
//             `JoiningDate` = '$joining_date',
//             `Department` = '$department',
//             `ShiftTiming` = '$shift_timing',
//             `Status` = '$status'
//         WHERE `id` = '$id'"; // Make sure to have $id set before using it

//     // Execute query
//     if (mysqli_query($con, $q4)) {
//         echo "<script>window.open('staff.php', '_self');</script>";
//     } else {
//         echo "Error updating record: " . mysqli_error($con);
//     }
// }
?>
