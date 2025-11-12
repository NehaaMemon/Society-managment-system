<?php
include './partials/layouts/layoutTop.php';

// Get the ID from the GET request
$id = $_GET['id'];

// SQL query to fetch data
$q7 = "SELECT * FROM `blk_flor_detail`
       INNER JOIN blocks ON blk_flor_detail.blk_id = blocks.id
       WHERE blk_flor_detail.id = '$id'"; // Ensure we specify the table for id

// Print the SQL query for debugging
// print_r($q7);

// Execute the query
$row = mysqli_query($con, $q7);

// Check if the query was successful
if (!$row) {
    die("Query failed: " . mysqli_error($con));
}

$data = mysqli_fetch_assoc($row);

?>

<div class="row">
    <!-- Form Section -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Update Honour Detail</h6>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row gy-3">
                        <div class="col-6">
                            <label class="form-label">Honour Name</label>
                            <input type="text" name="hon" value="<?php echo ucfirst($data['honour_name']); ?>" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Flat Count</label>
                            <input type="number" name="fc" value="<?php echo $data['flat_count']; ?>" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">House Status</label>
                            <input type="text" name="huse" class="form-control" value="<?php echo $data['house_status']; ?>" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">NIC No</label>
                            <input type="text" name="nicno" class="form-control" value="<?php echo $data['nic_no']; ?>" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Contact No</label>
                            <input type="text" name="con" class="form-control" value="<?php echo $data['contact_no']; ?>" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Blocks</label>
                            <input type="text" name="block_name" class="form-control" value="<?php echo $data['block_name']; ?>" disabled>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="updatehuse" class="btn btn-info">Update Detail</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Section -->

</div>

<br><br><br>
<?php include './partials/layouts/layoutBottom.php';

if (isset($_POST['updatehuse'])) {
    // Collect form data
    $ho = $_POST['hon'];
    $fc = $_POST['fc'];
    $hu = $_POST['huse'];
    $ni = $_POST['nicno'];
    $co = $_POST['con'];

    // Update query
    $q4 = "UPDATE `blk_flor_detail`
           SET `honour_name`='$ho', `flat_count`='$fc', `house_status`='$hu', `nic_no`='$ni', `contact_no`='$co'
           WHERE `id` = '$id'"; // Use the correct id field here

    // Execute the update query
    if (mysqli_query($con, $q4)) {
        echo "<script>window.open('house_detail.php','_self')</script>";
    } else {
        die("Update query failed: " . mysqli_error($con));
    }
}
?>
