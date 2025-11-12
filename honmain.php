<style>
.btn-secondary {
    background-color: #1d87e2 !important;
    border-color: #1d87e2 !important;
}
</style>
<?php
include './partials/layouts/layoutTop.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $block_id = $_POST['block'];
    $month = date('F'); // Current month
    $year = date('Y'); // Current year

    if (isset($_POST['members']) && is_array($_POST['members'])) {
        $success_count = 0;
        $error_count = 0;

        foreach ($_POST['members'] as $member_id => $status) {
            $status_value = ($status == 'Paid') ? 1 : 0;

            // Insert or update query for the maintenance table
            $q = "INSERT INTO `maintenance` (`block_id`, `flid`, `status`, `month`, `year`)
                  VALUES ('$block_id', '$member_id', '$status_value', '$month', '$year')
                  ON DUPLICATE KEY UPDATE `status` = '$status_value'"; // Update if the record exists

            // Execute the query and track success or error
            if (mysqli_query($con, $q)) {
                $success_count++;
            } else {
                $error_count++;
            }
        }

        // Display a single alert after the loop
        if ($success_count > 0 && $error_count == 0) {
            // All updates were successful
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Maintenance data has been updated for ' . $success_count . ' members.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        } elseif ($success_count > 0 && $error_count > 0) {
            // Some updates were successful, but some failed
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Partial Success!</strong> Maintenance data has been updated for ' . $success_count . ' members, but ' . $error_count . ' updates failed.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        } else {
            // All updates failed
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Maintenance data update failed for all members.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
    } else {
        echo '<div class="alert alert-warning">No members selected for maintenance update.</div>';
    }
}

// Fetch all blocks for dropdown
$q_blocks = "SELECT * FROM blocks";
$row_blocks = mysqli_query($con, $q_blocks);

// Fetch members based on selected block
if (isset($_POST['block'])) {
    $block_id = $_POST['block'];
    $month = date('F'); // Current month
    $year = date('Y'); // Current year

    $q_members = "SELECT blk_flor_detail.id AS member_id, blk_flor_detail.honour_name,
                         IFNULL(maintenance.status, 0) AS status
                  FROM blk_flor_detail
                  LEFT JOIN maintenance ON blk_flor_detail.id = maintenance.flid
                  AND maintenance.month = '$month' AND maintenance.year = '$year'
                  WHERE blk_flor_detail.blk_id = '$block_id'";

    $row_members = mysqli_query($con, $q_members);

    // Check if the query was successful
    if (!$row_members) {
        die('Query Failed: ' . mysqli_error($con)); // This will output the SQL error
    }
}
?>


<div class="container">
    <!-- Block Selection Form -->
    <form method="POST" id="block-form">
        <div class="row mb-4">
            <div class="col-sm-4">
                <label class="form-label">Select Block</label>
                <select class="form-select" name="block" onchange="document.getElementById('block-form').submit();">
                    <option>Select Block</option>
                    <?php while ($block = mysqli_fetch_assoc($row_blocks)) { ?>
                        <option value="<?php echo $block['id']; ?>" <?php if (isset($block_id) && $block_id == $block['id']) echo 'selected'; ?>>
                            <?php echo $block['block_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </form>

    <!-- Display Members of the Selected Block -->
    <?php if (isset($row_members) && mysqli_num_rows($row_members) > 0) { ?>
        <form method="POST">
            <input type="hidden" name="block" value="<?php echo $block_id; ?>">

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Honour Name</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Maintenance Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($member = mysqli_fetch_assoc($row_members)) { ?>
                            <tr>
                                <td><?php echo $member['honour_name']; ?></td>
                                <td><?php echo $month; ?></td>
                                <td><?php echo $year; ?></td>
                                <td>
                                    <!-- Maintenance Status Radio Buttons -->
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                               name="members[<?php echo $member['member_id']; ?>]"
                                               value="Paid" <?php if ($member['status'] == 1) echo 'checked'; ?>>
                                        <label class="form-check-label">Paid</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                               name="members[<?php echo $member['member_id']; ?>]"
                                               value="Unpaid" <?php if ($member['status'] != 1) echo 'checked'; ?>>
                                        <label class="form-check-label">Unpaid</label>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3 text-center">
                <button type="submit" class="btn btn-primary">Save Maintenance Status</button>
            </div>
        </form>
    <?php } else { ?>
        <div class="alert alert-info">No members found for the selected block.</div>
    <?php } ?>
</div>

<?php include './partials/layouts/layoutBottom.php'; ?>
