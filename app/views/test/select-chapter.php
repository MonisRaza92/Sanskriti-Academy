<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/../partials/header-links.php'; ?>
    <title>SANSKRITI ACADEMY - Delhi's Best Coaching Academy</title>
</head>

<body>
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="d-lg-none">
        <?php include __DIR__ . '/../admin/admin-partials/admin-sidebar.php'; ?>
    </div>
    <div class="container mt-5 py-5">
        <h3 class="fw-bold text-uppercase">Select Chapter For <?php echo htmlspecialchars($subject); ?></h3>
        <div class="row">
            <?php foreach ($chapters as $chapter): ?>
                <div class="col-md-4 mb-1 mt-4">
                    <a href="?url=startTest&class=<?php echo $class; ?>&test_name=<?php echo $test_name; ?>&subject=<?php echo $subject; ?>&chapter=<?php echo $chapter['chapter']; ?>" style="text-decoration: none;">
                        <div class="card border-2 rounded-2 h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-certificate fa-3x mb-3" style="color:#920000;"></i>
                                <h5 class="card-title text-dark fw-bold"><?php echo htmlspecialchars($chapter['chapter']); ?></h5>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>

        </div>
    </div>


    <?php include __DIR__ . '/../partials/footer.php'; ?>

    <?php include __DIR__ . '/../partials/footer-links.php'; ?>
</body>

</html>