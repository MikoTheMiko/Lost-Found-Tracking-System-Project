<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

include("../db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['admin_username'];
    $password = $_POST['admin_password'];

    $query = "SELECT * FROM lnf_admins WHERE admin_username='$username'";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && $password === $admin['admin_password']) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid login";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column justify-content-center align-items-center vh-100 bg-light">

    <form class="form p-4 shadow-sm border rounded bg-white w-25" method="POST">
        <h3 class="mb-3">Admin Login</h3>

        <input class="form-control mb-2" type="text" name="admin_username" placeholder="Username" required>

        <input class="form-control mb-5" type="password" name="admin_password" placeholder="Password" required>

        <button class="btn btn-primary w-100" type="submit">Login</button>

        <?php if (!empty($error)): ?>
            <div class="text-danger mt-2"><?= $error ?></div>
        <?php endif; ?>
    </form>

    <!-- Centered below the form -->
    <div class="w-25 text-center mt-3">
        <a href="../index.php" onclick="return confirm('Proceed to go to the Dashboard?')">
            Go to Dashboard
        </a>
    </div>

</body>

</html>