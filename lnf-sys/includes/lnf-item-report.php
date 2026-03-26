<?php
require '../db_connection.php';

$showToast = false;
$toastMessage = '';
$toastType = 'success'; // 'success' = green, 'danger' = red

if (isset($_POST["submit"])) {

    $lnf_item = $_POST["name"];
    $lnf_category = $_POST["category"];
    $lnf_status = $_POST["status"];
    $lnf_location = $_POST["location"];
    $lnf_description = $_POST["description"];
    $lnf_contact = $_POST["contact"];

    // Handle image
    $imageName = $_FILES["image"]["name"];
    $tmpName = $_FILES["image"]["tmp_name"];
    $uploadFolder = "../uploads/";

    // Allowed extensions
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    if ($imageName && !in_array($imageExt, $allowedExtensions)) {
        $showToast = true;
        $toastMessage = 'Only JPG, JPEG, PNG or GIF images are allowed.';
        $toastType = 'danger';
    } else {
        // Make upload folder if not exists
        if (!is_dir($uploadFolder)) mkdir($uploadFolder);

        if ($imageName) move_uploaded_file($tmpName, $uploadFolder . $imageName);

        // Insert into database
        $query = "INSERT INTO lnf_itemlist 
                  (lnf_item, lnf_category, lnf_status, lnf_location, lnf_description, lnf_image, lnf_contact, lnf_approval) 
                  VALUES 
                  ('$lnf_item', '$lnf_category', '$lnf_status', '$lnf_location', '$lnf_description', '$imageName', '$lnf_contact', 'pending')";

        if (mysqli_query($conn, $query)) {
            $showToast = true;
            $toastMessage = 'Thank you! Your report is now pending admin approval.';
            $toastType = 'success';
        } else {
            $showToast = true;
            $toastMessage = 'Failed to submit item. Please try again.';
            $toastType = 'danger';
        }
    }
}
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>Report Submission</title>
    <base href="../">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <?php
            require_once "../shared/user-nav.php";
            ?>

            <main class="col-md-9 col-lg-10 p-4 overflow-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Report an Item</h4>
                        <p class="text-muted">Found an item in OLLC Campus? Help return it to the owner.</p>

                        <form action="" method="post" autocomplete="off" enctype="multipart/form-data">

                            <!-- Item Name -->
                            <div class="mb-3">
                                <label class="form-label">Item Name</label>
                                <input type="text" name="name" class="form-control" required
                                    placeholder="Example: Black Wallet">
                            </div>

                            <!-- Category -->
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="" selected disabled>Select category</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="ID / Documents">ID / Documents</option>
                                    <option value="Bags">Bags</option>
                                    <option value="Accessories">Accessories</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>

                            <!-- Item Status -->
                            <div class="mb-3">
                                <label class="form-label">Report Type</label>
                                <select name="status" id="statusSelect" class="form-select" required>
                                    <option value="" selected disabled>Select Report Type</option>
                                    <option value="lost">I Lost an Item</option>
                                    <option value="found">I Found an Item</option>
                                </select>
                            </div>

                            <!-- Location -->
                            <div class="mb-3">
                                <label class="form-label" id="locationLabel">Item Location</label>
                                <input type="text" name="location" class="form-control"
                                    placeholder="Example: Library 2nd Floor" required>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"
                                    placeholder="Describe the item..."></textarea>
                            </div>

                            <!-- Upload Image -->
                            <div class="mb-3">
                                <label class="form-label">Upload Item Photo</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>

                            <!-- Contact -->
                            <div class="mb-3">
                                <label class="form-label">Your Contact</label>
                                <input type="text" name="contact" class="form-control"
                                    placeholder="Email or phone number" required>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button id="submit" type="submit" name="submit" class="btn btn-primary">
                                    Submit Report
                                </button>
                                <button type="reset" class="btn btn-outline-secondary" onclick="return confirm('Are you sure you want to clear your inputs?')">
                                    Clear
                                </button>
                            </div>

                            <div class="toast-container position-fixed top-0 end-0 p-3">
                                <div id="toast" class="toast align-items-center border-0 <?php echo $toastType == 'success' ? 'text-bg-success' : 'text-bg-danger'; ?>" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="d-flex">
                                        <div class="toast-body">
                                            <?php echo $toastMessage; ?>
                                        </div>
                                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    <?php if ($showToast): ?>
                                        var toastEl = document.getElementById('toast');
                                        var toast = new bootstrap.Toast(toastEl, {
                                            delay: 4000
                                        });
                                        toast.show();
                                    <?php endif; ?>
                                });

                                const statusSelect = document.getElementById("statusSelect");
                                const locationLabel = document.getElementById("locationLabel");

                                statusSelect.addEventListener("change", function() {
                                    if (this.value === "lost") {
                                        locationLabel.textContent = "Last Seen Location";
                                    } else if (this.value === "found") {
                                        locationLabel.textContent = "Location Found";
                                    }
                                });
                            </script>

                        </form>
                    </div>
                </div>
            </main>

        </div>
    </div>

    </div>
    </div>
</body>

</html>