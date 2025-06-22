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
                    <div class="card">
                        <div class="card-header">
                            <h4>Results by Test : <?= htmlspecialchars($testName) ?></h4>
                        </div>
                        <div class="card-body">
                            <?php if (isset($testResults) && count($testResults) > 0): ?>
                                <ul class="list-group">
                                    <?php foreach ($testResults as $result): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="d-flex" style="justify-content: space-between; width: 100%;">
                                                <strong><?= htmlspecialchars($result['name']) ?></strong>
                                                <span class="ms-3"><?= htmlspecialchars($subjectAndChapter['subject']) ?> <i class="fa-solid fa-right-long"></i> <?= htmlspecialchars($subjectAndChapter['chapter']) ?></span>
                                                <span class="ms-2">Score: <?= htmlspecialchars($result['total_correct']) ?> / <?= htmlspecialchars($result['total_questions']) ?></span>
                                                <?php if ($result['total_correct'] >= 0.5 * $result['total_questions']): ?>
                                                    <span class="badge bg-success">Passed</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Failed</span>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-center">No results found for this test.</p>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php include __DIR__ . '/../partials/footer-links.php'; ?>
</body>

</html>