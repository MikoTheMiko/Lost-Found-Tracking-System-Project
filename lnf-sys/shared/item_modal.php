<?php
require_once "../db_connection.php";
require_once "../shared/helper.php";

date_default_timezone_set('Asia/Manila');

$item_id = isset($_GET['lnf_id']) ? intval($_GET['lnf_id']) : 0;
if ($item_id <= 0) exit("Invalid ID");

$query = "SELECT * FROM lnf_itemlist WHERE lnf_id = $item_id LIMIT 1";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 0) exit("Item not found");

$item = mysqli_fetch_assoc($result);
$badge = getStatusBadge($item['lnf_status']);
?>

<div class="modal-header">
    <h5 class="modal-title"><?php echo htmlspecialchars($item['lnf_item']); ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <?php if (!empty($item['lnf_image'])): ?>
        <img src="uploads/<?php echo $item['lnf_image']; ?>" class="img-fluid rounded mb-3 w-100" style="max-height:350px; object-fit:cover;">
    <?php endif; ?>

    <span class="badge <?php echo $badge['color']; ?> mb-2"><?php echo $badge['text']; ?></span>
    <p class="text-muted"><i class="bi bi-clock"></i> <?php echo timeAgo($item['lnf_timestamp']); ?></p>
    <hr>

    <p><strong>Category:</strong> <?php echo htmlspecialchars($item['lnf_category']); ?></p>

    <?php
    // Determine label for location
    $locationLabel = (strtolower($item['lnf_status']) === 'lost') ? 'Last Seen' : 'Location Found';
    ?>
    <p><strong><?php echo $locationLabel; ?>:</strong> <?php echo htmlspecialchars($item['lnf_location']); ?></p>

    <?php if (!empty($item['lnf_contact'])): ?>
        <p><strong>Contact:</strong> <?php echo htmlspecialchars($item['lnf_contact']); ?></p>
    <?php endif; ?>

    <?php if (strtolower($item['lnf_status']) === 'claimed' && !empty($item['lnf_claimed_at'])): ?>
        <div class="alert alert-success">Claimed on <?php echo date("F j, Y g:i A", strtotime($item['lnf_claimed_at'])); ?></div>
    <?php endif; ?>

    <p><?php echo nl2br(htmlspecialchars($item['lnf_description'])); ?></p>
</div>