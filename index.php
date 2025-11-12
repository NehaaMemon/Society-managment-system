<?php
$title = 'Dashboard';
$subTitle = 'Investment';
include './partials/layouts/layoutTop.php';

// Database connection
$con = new mysqli("localhost", "root", "", "society");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch data from the blockexp table
$sql = "SELECT b_id, lift_expense, security_expense, parking_expense, water_expense, clean_expense, block_electri_bill, staff_expense, camera_exp, total_amount FROM blockexp";
$result = $con->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Encode data for JavaScript
echo '<script>let chartData = ' . json_encode($data) . ';</script>';

// Fetch summary data
$totalBudget = 0;
$todayEntries = 0;
$todayExpenses = 0;

$sql = "SELECT SUM(total_amount) as total_budget FROM blockexp";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalBudget = $row['total_budget'];
}

$sql = "SELECT SUM(total_maintance) as total_maintan FROM blocks";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalmain = $row['total_maintan'];
}

// Fetch category data
$categories = [];
$sql = "SELECT b_id, lift_expense, security_expense, parking_expense, water_expense, clean_expense, block_electri_bill FROM blockexp";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Additional CSS for enhanced UI -->
    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease-in-out;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        .text-primary, .text-success, .text-warning, .text-dark {
            font-weight: bold;
        }

        .card-title {
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .card-text {
            font-size: 1rem;
            color: #333;
        }

        .row {
            margin-left: -15px;
            margin-right: -15px;
        }

        .col-md-4, .col-md-3 {
            padding-left: 15px;
            padding-right: 15px;
        }

        h5 {
            font-size: 1.5rem;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-light">
<div class="container my-4">
    <!-- Summary Cards -->
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card shadow-lg border-primary hover-shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary fw-bold">Total Expense</h5>
                    <h3 class="text-primary">₨ <?= number_format($totalBudget) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg border-success hover-shadow">
                <div class="card-body">
                    <h5 class="card-title text-success fw-bold">Total Saving</h5>
                    <h3 class="text-success">₨ <?= number_format($todayEntries) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg border-primary hover-shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary fw-bold">Total Maintenance</h5>
                    <h3 class="text-primary">₨ <?= number_format($todayExpenses) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Expense Chart -->
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Blocks Expense</h5>
                </div>
                <div>
                    <canvas id="expenseChart" width="600" height="300"></canvas>
                    <script>
                        // Get data from PHP
                        const data = chartData;

                        // Extract labels and datasets
                        const labels = data.map(row => `Block ${row.b_id}`);
                        const datasets = [
                            {
                                label: 'Lift Expense',
                                data: data.map(row => row.lift_expense),
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Security Expense',
                                data: data.map(row => row.security_expense),
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Parking Expense',
                                data: data.map(row => row.parking_expense),
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Water Expense',
                                data: data.map(row => row.water_expense),
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Total Amount',
                                data: data.map(row => row.total_amount),
                                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1
                            }
                        ];

                        // Chart configuration
                        const config = {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        };

                        // Render the chart
                        const ctx = document.getElementById('expenseChart').getContext('2d');
                        new Chart(ctx, config);
                    </script>
                </div>
            </div>
        </div>
    </div>
  <br><br>
    <!-- Category Tiles -->
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Overview All Blocks</h5>
                </div>
                <br>
                <div class="row">
                    <?php foreach ($categories as $category): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card shadow-lg hover-shadow">
                                <div class="card-body">
                                    <h6 class="card-title text-dark fw-bold">Block <?= $category['b_id'] ?></h6>
                                    <p class="card-text">Lift Expense: ₨ <?= number_format($category['lift_expense']) ?></p>
                                    <p class="card-text">Security Expense: ₨ <?= number_format($category['security_expense']) ?></p>
                                    <p class="card-text">Parking Expense: ₨ <?= number_format($category['parking_expense']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php $script = '<script src="assets/js/homeFiveChart.js"></script>'; ?>
<?php include './partials/layouts/layoutBottom.php'; ?>
</body>
</html>
