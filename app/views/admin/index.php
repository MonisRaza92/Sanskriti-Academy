<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ?url=");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/../partials/header-links.php'; ?>
    <title>Admin Dashboard</title>
</head>
<body>
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <?php include __DIR__ . '/admin-partials/dashboard.php'; ?>
    
    
    <?php include __DIR__ . '/../partials/footer-links.php'; ?>
</body>

</html>