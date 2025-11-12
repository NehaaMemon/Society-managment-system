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

// Fetch blocks for the block dropdown
$q4 = "SELECT * FROM `blocks`";
$row_blocks = mysqli_query($con, $q4);

// Get selected block, status, month, year from form submission
$block_id = isset($_POST['blocks']) ? mysqli_real_escape_string($con, $_POST['blocks']) : null;
$month = isset($_POST['months']) ? mysqli_real_escape_string($con, $_POST['months']) : null;
$year = isset($_POST['years']) ? mysqli_real_escape_string($con, $_POST['years']) : null;
$status_filter = isset($_POST['status']) ? mysqli_real_escape_string($con, $_POST['status']) : null;

// Fetch data based on block and status, only if both are selected
$members = [];
if ($block_id && $status_filter !== null && $month && $year) {
    $q1 = "SELECT blk_flor_detail.id AS member_id, blk_flor_detail.honour_name,
                  IFNULL(maintenance.status, 0) AS status
           FROM blk_flor_detail
           LEFT JOIN maintenance
           ON blk_flor_detail.id = maintenance.flid
           AND maintenance.month = '$month'
           AND maintenance.year = '$year'
           WHERE blk_flor_detail.blk_id = '$block_id'
           AND IFNULL(maintenance.status, 0) = '$status_filter'";

    $result = mysqli_query($con, $q1);
    if (!$result) {
        echo "SQL Error: " . mysqli_error($con);
    } else {
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            while ($member = mysqli_fetch_assoc($result)) {
                $members[] = $member;
            }
        } else {
            echo "<div class='alert alert-warning'>No records found for the selected month, year, block, and status.</div>";
        }
    }
}
?>

<div class="row gy-4">
    <div class="card">
        <div class="card-header">
            <h6 class="card-title mb-0">All Blocks Maintenance Report</h6>
        </div>
        <div class="card-body">
            <fieldset class="wizard-fieldset show">
                <form method="POST" id="block-form">
                    <div class="row gy-3">
                        <!-- Month Dropdown -->
                        <div class="col-sm-3">
                            <label class="form-label">Month Name</label>
                            <div class="position-relative">
                                <select class="form-select" name="months" required>
                                    <option>Select Month</option>
                                    <?php
                                    $q4 = "SELECT DISTINCT month FROM `maintenance`";
                                    $row_months = mysqli_query($con, $q4);
                                    while ($data = mysqli_fetch_assoc($row_months)) {
                                        $selected = ($month == $data['month']) ? 'selected' : '';
                                        echo "<option value='{$data['month']}' $selected>{$data['month']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Year Dropdown -->
                        <div class="col-sm-3">
                            <label class="form-label">Year</label>
                            <div class="position-relative">
                                <select class="form-select" name="years" required>
                                    <option>Select Year</option>
                                    <?php
                                    $q4 = "SELECT DISTINCT year FROM `maintenance`";
                                    $row_years = mysqli_query($con, $q4);
                                    while ($data = mysqli_fetch_assoc($row_years)) {
                                        $selected = ($year == $data['year']) ? 'selected' : '';
                                        echo "<option value='{$data['year']}' $selected>{$data['year']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Status Dropdown -->
                        <div class="col-sm-3">
                            <label class="form-label">Status</label>
                            <div class="position-relative">
                                <select class="form-select" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="1" <?php echo ($status_filter == '1') ? 'selected' : ''; ?>>Paid</option>
                                    <option value="0" <?php echo ($status_filter == '0') ? 'selected' : ''; ?>>Unpaid</option>
                                </select>
                            </div>
                        </div>
                        <!-- Block Dropdown -->
                        <div class="col-sm-3">
                            <label class="form-label">Block Name</label>
                            <select class="form-select" name="blocks" onchange="document.getElementById('block-form').submit();" required>
                                <option>Select Block</option>
                                <?php
                                while ($data = mysqli_fetch_assoc($row_blocks)) {
                                    $selected = ($block_id == $data['id']) ? 'selected' : '';
                                    echo "<option value='{$data['id']}' $selected>{$data['block_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <!-- <div class="mb-3">
                        <button type="submit" name="main_report" class="btn btn-primary">Submit</button>
                    </div> -->
                </form>
            </fieldset>
        </div>
    </div>
</div>

<!-- Display Data if available -->
<?php if (!empty($members)) { ?>
    <div class="card">
        <div class="card-header">
            <center><h5 class="card-title mb-0">Block Maintenance Details</h5></center>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>Honour Name</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Maintenance Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $member) { ?>
                            <tr>
                                <td><?php echo $member['honour_name']; ?></td>
                                <td><?php echo $month; ?></td>
                                <td><?php echo $year; ?></td>
                                <td><?php echo ($member['status'] == 1) ? 'Paid' : 'Unpaid'; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>

<?php
// Footer and layout bottom
include './partials/layouts/layoutBottom.php';
?>
