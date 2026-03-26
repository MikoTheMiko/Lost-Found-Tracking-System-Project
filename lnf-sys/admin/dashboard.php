<?php

// Not admin? Redirects to login page to stop bypassing
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once "../db_connection.php";

/* Pending reports */
$queryPending = "SELECT COUNT(*) AS total_pending 
                 FROM lnf_itemlist 
                 WHERE lnf_approval = 'pending'";
$resultPending = mysqli_query($conn, $queryPending);
$dataPending = mysqli_fetch_assoc($resultPending);
$totalPending = $dataPending['total_pending'];

/* Approved reports */
$queryApproved = "SELECT COUNT(*) AS total_approved 
                  FROM lnf_itemlist 
                  WHERE lnf_approval = 'approved'";
$resultApproved = mysqli_query($conn, $queryApproved);
$dataApproved = mysqli_fetch_assoc($resultApproved);
$totalApproved = $dataApproved['total_approved'];

/* Rejected reports */
$queryRejected = "SELECT COUNT(*) AS total_rejected
                FROM lnf_itemlist
                WHERE lnf_approval = 'rejected'";
$resultRejected = mysqli_query($conn, $queryRejected);
$dataRejected = mysqli_fetch_assoc($resultRejected);
$totalRejected = $dataRejected['total_rejected'];
?>

<!DOCTYPE html>

<head>
    <title>Dashboard</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php require_once 'admin-nav.php'; ?>

    <div class="container pt-3">
        <h4 class="text-primary">Home</h4>
        <p class="text-secondary">Admin Dashboard</p>

        <hr class="text-muted">

        <div class="row mt-4">

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Pending Reports</h6>
                        <h2 class="text-warning fw-bold"><?= $totalPending ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Approved Items</h6>
                        <h2 class="text-success fw-bold"><?= $totalApproved ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Rejected Reports</h6>
                        <h2 class="text-danger fw-bold"><?= $totalRejected ?></h2>
                    </div>
                </div>
            </div>

            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        </div>
    </div>

    </main>
    </div>
    </div>

    </html>