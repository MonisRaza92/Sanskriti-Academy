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
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card border-2 rounded-2 p-4">
                <div class="card-body text-center">

                    <h3 class="card-title mb-4 text-primary">
                        <i class="fas fa-chart-line me-2"></i> Test Result
                    </h3>

                    <!-- Circular Graph (Score) -->
                    <div class="d-flex justify-content-center mb-4">
                        <div class="position-relative" style="width:150px; height:150px;">
                            <?php 
                                $score = ($result['total_correct'] / $result['total_questions']) * 100; 
                                $score = round($score);
                            ?>
                            <svg width="150" height="150">
                                <circle cx="75" cy="75" r="70" stroke="#eee" stroke-width="10" fill="none"/>
                                <circle cx="75" cy="75" r="70" 
                                    stroke="#007bff" 
                                    stroke-width="10" 
                                    fill="none"
                                    stroke-dasharray="<?php echo $score * 4.4; ?> 999"
                                    stroke-linecap="round"
                                    transform="rotate(-90 75 75)"
                                />
                            </svg>
                            <div class="position-absolute top-50 start-50 translate-middle fs-4 fw-bold text-primary">
                                <?php echo $score; ?>%
                            </div>
                        </div>
                    </div>

                    <!-- Score Summary -->
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <div class="border rounded-3 py-3 bg-light">
                                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                <h6 class="mb-0">Correct Answers</h6>
                                <p class="fw-bold mb-0"><?php echo $result['total_correct']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="border rounded-3 py-3 bg-light">
                                <i class="fas fa-list-ol fa-2x text-warning mb-2"></i>
                                <h6 class="mb-0">Total Questions</h6>
                                <p class="fw-bold mb-0"><?php echo $result['total_questions']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="border rounded-3 py-3 bg-light">
                                <i class="fas fa-percentage fa-2x text-primary mb-2"></i>
                                <h6 class="mb-0">Score</h6>
                                <p class="fw-bold mb-0"><?php echo $score; ?>%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Back or Retake Button -->
                    <div class="mt-4">
                        <a href="?url=" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i> Go Back To Home
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>



    <?php include __DIR__ . '/../partials/footer.php'; ?>

    <?php include __DIR__ . '/../partials/footer-links.php'; ?>
</body>

</html>