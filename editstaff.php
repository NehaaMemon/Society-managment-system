<?php include './partials/layouts/layoutTop.php';?>

<?php


// Check if the "phone" parameter is set in the URL
if (isset($_GET['phone'])) {
    $phone = $_GET['phone'];

    // Fetch the staff record based on PhoneNumber
    $q = "SELECT * FROM `staff` WHERE `PhoneNumber` = '$phone'";
    $result = mysqli_query($con, $q);

    if ($result && mysqli_num_rows($result) > 0) {
        $staff = mysqli_fetch_assoc($result);
    } else {
        echo '<div class="alert alert-danger">Staff member not found.</div>';
        exit;
    }
} else {
    echo '<div class="alert alert-danger">No staff member selected for editing.</div>';
    exit;
}

// Update staff information after form submission
if (isset($_POST['updateStaff'])) {
    $name = $_POST['name'];
    $blk_id = $_POST['blk'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $contact_no = $_POST['contact'];
    $shift_time = $_POST['time'];
    $department = $_POST['dep'];
    $joining_date = $_POST['date'];
    $status = $_POST['status'];

    $updateQuery = "
        UPDATE `staff` SET 
        `Name` = '$name', 
        `Block` = '$blk_id', 
        `Position` = '$position', 
        `Salary` = '$salary', 
        `PhoneNumber` = '$contact_no', 
        `JoiningDate` = '$joining_date', 
        `Department` = '$department', 
        `ShiftTiming` = '$shift_time', 
        `Status` = '$status'
        WHERE `PhoneNumber` = '$phone'";

    if (mysqli_query($con, $updateQuery)) {
        echo '<div class="alert alert-success">Staff details updated successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Error updating record: ' . mysqli_error($con) . '</div>';
    }
}
?>

<div class="row gy-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add Staff</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row gy-3">
        <div class="col-6">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $staff['Name']; ?>" required>
        </div>
        <div class="col-6">
            <label for="blk" class="form-label">Block</label>
            <select class="form-select" id="blk" name="blk" required>
                <?php
                $q4 = "SELECT * FROM `blocks`";
                $row = mysqli_query($con, $q4);
                while ($data = mysqli_fetch_assoc($row)) {
                    $selected = $data['id'] == $staff['Block'] ? 'selected' : '';
                    echo "<option value='" . $data['id'] . "' $selected>" . $data['block_name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-6">
            <label for="position" class="form-label">Position</label>
            <input type="text" class="form-control" id="position" name="position" value="<?php echo $staff['Position']; ?>" required>
        </div>
        <div class="col-6">
            <label for="salary" class="form-label">Salary</label>
            <input type="text" class="form-control" id="salary" name="salary" value="<?php echo $staff['Salary']; ?>" required>
        </div>
        <div class="col-6">
            <label for="contact" class="form-label">Contact No</label>
            <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $staff['PhoneNumber']; ?>" required>
        </div>
        <div class="col-6">
            <label for="time" class="form-label">Shift Timing</label>
            <input type="text" class="form-control" id="time" name="time" value="<?php echo $staff['ShiftTiming']; ?>" required>
        </div>
        <div class="col-6">
            <label for="dep" class="form-label">Department</label>
            <input type="text" class="form-control" id="dep" name="dep" value="<?php echo $staff['Department']; ?>" required>
        </div>
        <div class="col-6">
            <label for="date" class="form-label">Joining Date</label>
            <input type="date" class="form-control" id="date" name="date" value="<?php echo $staff['JoiningDate']; ?>" required>
        </div>
        <div class="col-6">
            <label for="status" class="form-label">Status</label>
            <input type="text" class="form-control" id="status" name="status" value="<?php echo $staff['Status']; ?>" required>
        </div>
        <button type="submit" name="updateStaff" class="btn btn-primary">Update</button>
    </form>
</div>
</div>
                </form>
            </div>
        </div>
    </div>
</div>
