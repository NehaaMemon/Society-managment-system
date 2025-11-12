<style>
    .card .card-header {
  background-color: #33c539 !important;
  color: white !important;
}
.card .card-title {
  color: white !important;
}

.bordered-table thead tr th {
  background-color: #6985f5 !important;
  border-bottom: 1px solid var(--neutral-200) !important;
  color: white !important;

}
</style>

<?php
 include './partials/layouts/layoutTop.php';

if (isset($_POST['addblk'])) {

    // Get form input values
    $a = mysqli_real_escape_string($con, $_POST['blname']);
    $totlft = mysqli_real_escape_string($con, $_POST['totlft']);
    $totcam = mysqli_real_escape_string($con, $_POST['totcam']);
    $tothu = mysqli_real_escape_string($con, $_POST['totho']);
    $totmain = mysqli_real_escape_string($con, $_POST['totmaintan']);

    // Calculate maintenance per house
    $main = $totmain / $tothu;

    // Insert into database
    $q = "INSERT INTO `blocks`(`block_name`, `total_lift`, `total_camera`, `total_house`, `total_maintance`, `main_house`)
          VALUES ('$a', '$totlft', '$totcam', '$tothu', '$totmain', '$main')";

    // Execute query
    if (mysqli_query($con, $q)) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Block added successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Failed to add block.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}
?>

<!-- Form Section -->
<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Add Block Form</h6>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row gy-3">
                        <div class="col-6">
                            <label class="form-label">Block Name</label>
                            <input type="text" name="blname" class="form-control" placeholder="Enter Block Name" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Total Lift</label>
                            <input type="number" name="totlft" class="form-control" placeholder="Enter Total Lifts" required min="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Total Camera</label>
                            <input type="number" name="totcam" class="form-control" placeholder="Enter Total Cameras" required min="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Total Maintenance</label>
                            <input type="number" name="totmaintan" class="form-control" placeholder="Enter Total Maintenance" required min="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Total House</label>
                            <input type="number" name="totho" class="form-control" placeholder="Enter Total Houses" required min="0">
                        </div>
                        <div class="form-actions">
                            <button type="submit" name="addblk" class="btn btn-info">Insert Block</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Section -->
    <!-- <div class="col-md-6 d-flex justify-content-center align-items-center">
        <img src="assets/images/floor2.jpg" alt="Floor Image" class="img-fluid">
    </div> -->
</div>

<br><br><br>

<!-- Display Blocks in a Table -->
<?php
$q1 = "SELECT * FROM `blocks`";
$row = mysqli_query($con, $q1);
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Block Details</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead class="th">
                        <tr class="th">
                            <th class="th" scope="col">Block Name</th>
                            <th class="th" scope="col">Total Lifts</th>
                            <th scope="col">Total Cameras</th>
                            <th scope="col">Total Houses</th>
                            <th scope="col">Total Maintenance</th>
                            <th scope="col">Maintenance per House</th> <!-- New column -->
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($data = mysqli_fetch_assoc($row)) {
                        ?>
                            <tr>
                                <td><?php echo ucfirst($data['block_name']); ?></td>
                                <td><?php echo $data['total_lift']; ?></td>
                                <td><?php echo $data['total_camera']; ?></td>
                                <td><?php echo $data['total_house']; ?></td>
                                <td><?php echo $data['total_maintance']; ?></td>
                                <td><?php echo $data['main_house']; ?></td> <!-- Display maintenance per house -->
                                <td>
                                    <a href="edit_blk.php?id=<?php echo $data['id']; ?>" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>
                                    <a href="delete_blk.php?id=<?php echo $data['id']; ?>" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
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
</div>

<?php include './partials/layouts/layoutBottom.php' ?>
