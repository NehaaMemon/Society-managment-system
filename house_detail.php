
<?php
include './partials/layouts/layoutTop.php';

if (isset($_POST['addflorblk'])) {

    $blk_id = (int)$_POST['blk'];       // blk_id (foreign key from the form, cast to int)
    $honour_name = $_POST['hono'];      // Honour Name from the form
    $flat_count = $_POST['flco'];       // Flat Count from the form
    $house_status = $_POST['house_status'];  // House Status from the form
    $nic_no = $_POST['nic'];            // NIC No from the form
    $contact_no = $_POST['contact'];    // Contact No from the form

    // Validate NIC (13 digits)
    if (!preg_match('/^[0-9]{13}$/', $nic_no)) {
        echo '<div class="alert alert-danger">NIC must be exactly 13 digits.</div>';
    }
    // Validate Contact No (11 digits)
    elseif (!preg_match('/^[0-9]{11}$/', $contact_no)) {
        echo '<div class="alert alert-danger">Contact number must be exactly 11 digits.</div>';
    } else {
        // Step 1: Fetch `main_house` value from the `blocks` table for the given blk_id
        $q1 = "SELECT main_house FROM `blocks` WHERE id = '$blk_id'";
        $result = mysqli_query($con, $q1);

        if ($result && mysqli_num_rows($result) > 0) {
            $block_data = mysqli_fetch_assoc($result);
            $main_house = $block_data['main_house'];  // Get main_house value from blocks

            // Step 2: Calculate the `maintenance_rate`
            $maintenance_rate = $flat_count * $main_house;

            // Step 3: Insert the data into `blk_flor_detail`, including `maintenance_rate`
            $q2 = "INSERT INTO `blk_flor_detail` (`honour_name`, `flat_count`, `house_status`, `nic_no`, `contact_no`, `maintenance_rate`, `blk_id`)
                   VALUES ('$honour_name', '$flat_count', '$house_status', '$nic_no', '$contact_no', '$maintenance_rate', '$blk_id')";


            echo $q2;

            // Execute the insert query
            if (mysqli_query($con, $q2)) {
                echo '<div class="alert alert-success">Record successfully added with Maintenance Rate!</div>';
            } else {
                echo 'Error: ' . mysqli_error($con);  // Output SQL error
            }

        } else {
            echo '<div class="alert alert-danger">Error: Block ID not found or main_house not set!</div>';
        }
    }
}


?>



<div class="row gy-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add House Details</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row gy-3">
                        <div class="col-6">
                            <label class="form-label">Honour Name</label>
                            <input type="text" name="hono" class="form-control" placeholder="Enter Honour Name" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Total Flat (Honour flat quantity)</label>
                            <input type="number" name="flco" class="form-control" placeholder="Enter Flat Count" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">House Status</label>
                            <div class="row">
                                <div class="card-body">
                                    <div class="d-flex align-items-center flex-wrap gap-28">
                                        <!-- Radio button for Rent -->
                                        <div class="form-check checked-primary d-flex align-items-center gap-2">
                                            <input class="form-check-input" type="radio" name="house_status" value="rent" required>
                                            <label class="form-check-label" for="radio11">Rent</label>
                                        </div>
                                        <!-- Radio button for Owner -->
                                        <div class="form-check checked-secondary d-flex align-items-center gap-2">
                                            <input class="form-check-input" type="radio" name="house_status" value="owner">
                                            <label class="form-check-label" for="radio22">Owner</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">NIC no</label>
                            <input type="text" name="nic" class="form-control" placeholder="Enter NIC no" maxlength="13" minlength="13" pattern="[0-9]{13}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Contact no</label>
                            <input type="text" name="contact" class="form-control" placeholder="Enter Contact no" maxlength="11" minlength="11" pattern="[0-9]{11}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Block</label>
                            <select class="form-select" name="blk" required>
                                    <?php
                                    // Fetch blocks to display in the dropdown
                                    $q4 = "SELECT * FROM `blocks`";
                                    $row = mysqli_query($con, $q4);

                                    while ($data = mysqli_fetch_assoc($row)) {
                                        // Set the value as the `id` (primary key of blocks) and display block name
                                        echo "<option value='" . $data['id'] . "'>" . $data['block_name'] . "</option>";
                                    }
                                    ?>
                                </select>

                        </div>
                    </div>
                    <br>
                    <div class="col-12">
                        <button type="submit" name="addflorblk" class="btn btn-primary-600">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

            <?php $script = '
<script>
    (() => {
        "use strict";
        const forms = document.querySelectorAll(".needs-validation");

        Array.from(forms).forEach(form => {
            form.addEventListener("submit", event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add("was-validated");
            }, false);
        });
    })();
</script>
'; ?>

<?php
// Query to fetch block expenses and display them
$q2 = "
SELECT
    blk_flor_detail.id,
    blk_flor_detail.honour_name,
    blk_flor_detail.flat_count,
    blocks.main_house,
    (blk_flor_detail.flat_count * blocks.main_house) AS maintenance_rate,
    blk_flor_detail.house_status,
    blk_flor_detail.nic_no,
    blk_flor_detail.contact_no,
    blocks.block_name

FROM
    blk_flor_detail
INNER JOIN
    blocks
ON
    blk_flor_detail.blk_id = blocks.id";

// print_r($q2);
// die();

$row = mysqli_query($con, $q2);
?>

<div class="card mt-5">
    <div class="card-header">
        <h5 class="card-title mb-0">Honour House Detail</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table basic-border-table mb-0">
                <thead>
                    <tr>
                        <th>Society ID</th>
                        <th>Honour Name</th>
                        <th>Flat Count</th>
                        <th>Maintenance Rate</th>
                        <th>House Status</th>
                        <th>NIC</th>
                        <th>Contact</th>
                        <th>Block</th>
                        <th >Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($data = mysqli_fetch_assoc($row)) { ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo ucfirst($data['honour_name']); ?></td>
                        <td><?php echo $data['flat_count']; ?></td>
                        <td><?php echo $data['maintenance_rate']; ?></td>

                        <td><?php echo ucfirst($data['house_status']); ?></td>
                        <td><?php echo $data['nic_no']; ?></td>
                        <td><?php echo $data['contact_no']; ?></td>
                        <td><?php echo ucfirst($data['block_name']); ?></td>
                        <td>
                         <a href="edit_huse.php?id=<?php echo $data['id']; ?>" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                           <iconify-icon icon="lucide:edit"></iconify-icon>
                        </a>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
