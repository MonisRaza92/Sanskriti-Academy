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
    <title>Users Managment</title>
</head>

<body>
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="container-fluid mt-5 pt-4">
        <div class="container p-0">
            <div class="row">
                <div class="col-md-3">
                    <?php include __DIR__ . '/admin-partials/admin-sidebar.php'; ?>
                </div>
                <div class="col-lg-9">
                    <?php include __DIR__ . '/admin-partials/completed-test.php'; ?>
                </div>
            </div>
        </div>
    </div>



    <?php include __DIR__ . '/../partials/footer-links.php'; ?>
</body>

</html>