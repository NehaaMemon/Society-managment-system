<?php
include './partials/layouts/layoutTop.php';

if (isset($_POST['addstaff'])) {
    // Retrieve values from the form
    $name = $_POST['name'];
    $blk_id = $_POST['blk'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $contact_no = $_POST['contact'];
    $shift_time = $_POST['time'];
    $department = $_POST['dep'];
    $joining_date = $_POST['date'];
    $status = $_POST['status'];

    // Validate Contact No (11 digits)
    if (!preg_match('/^[0-9]{11}$/', $contact_no)) {
        echo '<div class="alert alert-danger">Contact number must be exactly 11 digits.</div>';
    } else {
        // Fetch main_house value from blocks table for the given blk_id
        $q1 = "SELECT main_house FROM blocks WHERE id = '$blk_id'";
        $result = mysqli_query($con, $q1);

        if ($result && mysqli_num_rows($result) > 0) {
            $block_data = mysqli_fetch_assoc($result);
            $maintenance_rate = $block_data['main_house'];

            // Insert data into staff table with correct column alignment
            $q2 = "INSERT INTO `staff`(`Name`, `Block`, `Position`, `Salary`, `PhoneNumber`, `JoiningDate`, `Department`, `ShiftTiming`, `Status`) VALUES
             ('$name', '$blk_id', '$position', '$salary', '$contact_no', '$joining_date', '$department', '$shift_time', '$status')";

            // Execute insert query
            if (mysqli_query($con, $q2)) {
                echo '<div class="alert alert-success">Record successfully added!</div>';
            } else {
                echo 'Error: ' . mysqli_error($con);  // Output SQL error
            }
        }
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
                        <!-- Form Fields -->
                        <div class="col-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Block</label>
                            <select class="form-select" name="blk" required>
                                <?php
                                $q4 = "SELECT * FROM blocks";
                                $row = mysqli_query($con, $q4);
                                while ($data = mysqli_fetch_assoc($row)) {
                                    echo "<option value='" . $data['id'] . "'>" . $data['block_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Position</label>
                            <input type="text" name="position" class="form-control" placeholder="Enter Position" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Salary</label>
                            <input type="text" name="salary" class="form-control" placeholder="Enter Salary" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Contact no</label>
                            <input type="text" name="contact" class="form-control" placeholder="Enter Contact No" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Shift Timing</label>
                            <input type="text" name="time" class="form-control" placeholder="Enter Shift Timing" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Department</label>
                            <input type="text" name="dep" class="form-control" placeholder="Enter Department" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Joining Date</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Status</label>
                            <input type="text" name="status" class="form-control" placeholder="Enter Status" required>
                        </div>
                        <div class="col-6">
                            <button type="submit" name="addstaff" class="btn btn-primary-600">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Query to fetch staff details and display them
$q2 = "
SELECT Name, Block, Position, Salary, PhoneNumber, JoiningDate, Department, ShiftTiming, Status
FROM staff";

$row = mysqli_query($con, $q2);
?>

<!-- Table Displaying Staff Details -->
<div class="card mt-5">
    <div class="card-header">
        <h5 class="card-title mb-0">Staff Detail</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table basic-border-table mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Block</th>
                        <th>Position</th>
                        <th>Salary</th>
                        <th>Phone Number</th>
                        <th>Joining Date</th>
                        <th>Department</th>
                        <th>Shift Timing</th>
                        <th>Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($data = mysqli_fetch_assoc($row)) { ?>
                    <tr>
                        <td><?php echo ucfirst($data['Name']); ?></td>
                        
                        <td>
                            <a href="addblock.php?block=<?php echo urlencode($data['Block']); ?>">
                                <?php echo ucfirst($data['Block']); ?>
                            </a>
                        </td>
                        
                        <td><?php echo ucfirst($data['Position']); ?></td>
                        <td><?php echo $data['Salary']; ?></td>
                        <td><?php echo $data['PhoneNumber']; ?></td>
                        <td><?php echo $data['JoiningDate']; ?></td>
                        <td><?php echo ucfirst($data['Department']); ?></td>
                        <td><?php echo $data['ShiftTiming']; ?></td>
                        <td><?php echo ucfirst($data['Status']); ?></td>
                        <td>
                            <!-- Edit and Delete actions, using PhoneNumber as the unique identifier -->
                            <a href="editstaff.php?phone=<?php echo urlencode($data['PhoneNumber']); ?>" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                <iconify-icon icon="lucide:edit"></iconify-icon>
                            </a>
                            <a href="deletestaff.php?id = $id" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

ChatGPT said:
ChatGPT