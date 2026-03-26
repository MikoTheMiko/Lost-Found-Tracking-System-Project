<?php

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once "../db_connection.php";

// Handle Mark as Claimed action
if (isset($_POST['action']) && isset($_POST['lnf_id'])) {
    $reportId = intval($_POST['lnf_id']);
    $action = $_POST['action'];

    if ($action === 'claim') {

        $stmt = $conn->prepare("
            UPDATE lnf_itemlist 
            SET lnf_status = 'claimed',
                lnf_claimed_at = NOW()
            WHERE lnf_id = ?
        ");

        $stmt->bind_param("i", $reportId);
        $stmt->execute();
        $stmt->close();

        // Redirect to refresh page
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Fetch approved reports that are not yet claimed
$query = "SELECT * FROM lnf_itemlist WHERE lnf_approval = 'approved' ORDER BY lnf_timestamp DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Approved Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .report-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php require_once 'admin-nav.php'; ?>

    <div class="container pt-3">
        <h4 class="text-primary">Approved Reports</h4>
        <p class="text-secondary">List of approved reports. You can mark items as claimed.</p>
        <hr class="text-muted">

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Date Approved</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['lnf_id'] ?></td>
                            <td><?= htmlspecialchars($row['lnf_item']) ?></td>
                            <td><?= htmlspecialchars($row['lnf_category']) ?></td>
                            <td><?= htmlspecialchars($row['lnf_location']) ?></td>
                            <td><?= $row['lnf_timestamp'] ?></td>
                            <td><?= htmlspecialchars($row['lnf_status']) ?></td>
                            <td>
                                <!-- View Detail Button -->
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row['lnf_id'] ?>">
                                    View
                                </button>

                                <!-- Mark as Claimed Button (only if not already claimed) -->
                                <?php if ($row['lnf_status'] !== 'claimed'): ?>
                                    <form method="POST" style="display:inline-block;">
                                        <input type="hidden" name="lnf_id" value="<?= $row['lnf_id'] ?>">
                                        <button type="submit" name="action" value="claim" class="btn btn-success btn-sm">Mark as Claimed</button>
                                    </form>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Claimed</span>
                                <?php endif; ?>

                                <!-- Modal for Full Detail -->
                                <div class="modal fade" id="detailModal<?= $row['lnf_id'] ?>" tabindex="-1" aria-labelledby="detailModalLabel<?= $row['lnf_id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel<?= $row['lnf_id'] ?>">Report Details: <?= htmlspecialchars($row['lnf_item']) ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <!-- Basic information -->

                                                <p><strong>Category:</strong> <?= htmlspecialchars($row['lnf_category']) ?></p>
                                                <p><strong>Location:</strong> <?= htmlspecialchars($row['lnf_location']) ?></p>
                                                <p><strong>Description:</strong> <?= htmlspecialchars($row['lnf_description']) ?></p>
                                                <p><strong>Contact:</strong> <?= htmlspecialchars($row['lnf_contact']) ?></p>
                                                <p><strong>Status:</strong> <?= htmlspecialchars($row['lnf_status']) ?></p>

                                                <!-- Item image display -->

                                                <?php if (!empty($row['lnf_image'])): ?>
                                                    <img src="../uploads/<?= htmlspecialchars($row['lnf_image']) ?>" alt="Item Image" class="img-fluid">
                                                <?php else: ?>
                                                    <p>No image available.</p>
                                                <?php endif; ?>

                                                <!-- Date claimed -->

                                                <?php
                                                $status = strtolower(trim($row['lnf_status']));
                                                $claimedAt = $row['lnf_claimed_at'];

                                                if ($status === 'claimed' && !empty($claimedAt)): ?>
                                                    <div class="alert alert-success w-50 mt-2">
                                                        Claimed on <?= date("F j, Y g:i A", strtotime($claimedAt)); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">No approved reports found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>