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
        <div class="row">
            <div class="col-md-6 mb-4">

                <div class="card border-2 rounded-2 p-4">
                    <div class="card-body text-center">

                        <h3 class="card-title mb-4 " style="color: var(--accent-color);">
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
                                    <circle cx="75" cy="75" r="70" stroke="#eee" stroke-width="10" fill="none" />
                                    <circle cx="75" cy="75" r="70"
                                        stroke="#920000"
                                        stroke-width="10"
                                        fill="none"
                                        stroke-dasharray="<?php echo $score * 4.4; ?> 999"
                                        stroke-linecap="round"
                                        transform="rotate(-90 75 75)" />
                                </svg>
                                <div class="position-absolute top-50 start-50 translate-middle fs-4 fw-bold " style="color: var(--accent-color);">
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
            <div class="col-md-6">

                <div class="card border-2 rounded-2 p-4">
                    <div class="card-body">
                        <h4 class="card-title mb-4" style="color: var(--accent-color);">
                            <i class="fas fa-list-alt me-2"></i> Test Details
                        </h4>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Student Name:</strong> <?= htmlspecialchars($testResults[0]['name']) ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Class:</strong> <?= htmlspecialchars($_SESSION['class']) ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Test Name:</strong> <?= htmlspecialchars($_SESSION['test_name']) ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Subject:</strong> <?= htmlspecialchars($_SESSION['subject']) ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Chapter:</strong> <?= htmlspecialchars($_SESSION['chapter']) ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Total Questions:</strong> <?= htmlspecialchars($testResults[0]['total_questions']) ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Total Correct Answers:</strong> <?= htmlspecialchars($testResults[0]['total_correct']) ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Score:</strong> <?= htmlspecialchars($score) ?>%
                            </li>
                            <li class="list-group-item mb-1">
                                <strong>Status:</strong>
                                <?php if ($score >= 50): ?>
                                    <span class="badge bg-success">Passed</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Failed</span>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .correct-option {
            background-color: #007BFF !important;
            /* Blue (correct option) */
            color: white !important;
        }

        .selected-correct {
            background-color: #28a745 !important;
            /* Green (user correct selection) */
            color: white !important;
        }

        .selected-wrong {
            background-color: #dc3545 !important;
            /* Red (user wrong selection) */
            color: white !important;
        }
    </style>

    <div class="container mt-5">
        <h4 class="text-uppercase rounded bg-secondary-subtle py-1 pb-2 ps-3">Your Test Result</h4>
        <div class="mt-4">
            <ul class="list-unstyled position-relative" style="display: flex; gap:20px;">
                <li>
                    <span class="position-absolute" style="top:3px; display: inline-block; width: 20px; height: 20px; background-color: #28a745; border-radius: 4px; margin-right: 10px;"></span>
                    <strong class="ms-4">Green:</strong> If your selected option is <span style="color: #28a745;">correct</span>.
                </li>
                <li>
                    <span class="position-absolute" style="top:3px; display: inline-block; width: 20px; height: 20px; background-color: #dc3545; border-radius: 4px; margin-right: 10px;"></span>
                    <strong class="ms-4">Red:</strong> If your selected option is <span style="color: #dc3545;">wrong</span>.
                </li>
                <li>
                    <span class="position-absolute" style="top:3px; display: inline-block; width: 20px; height: 20px; background-color: #007BFF; border-radius: 4px; margin-right: 10px;"></span>
                    <strong class="ms-4">Blue:</strong> This is the <span style="color: #007BFF;">correct option</span>.
                </li>
            </ul>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Options</th>
                    <th>Answer Explanation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allQuestions as $question):
                    // Find matching student answer for this question
                    $studentAnswer = null;
                    foreach ($studentAnswers as $answer) {
                        if ($answer['question_id'] == $question['id']) {
                            $studentAnswer = $answer;
                            break;
                        }
                    }
                ?>
                    <tr>
                        <td><?= htmlspecialchars($question['question_text']) ?></td>
                        <td>
                            <ul class="list-unstyled list-group">
                                <?php for ($i = 1; $i <= 4; $i++):
                                    $optionKey = 'option' . $i;
                                    $optionValue = $question[$optionKey];
                                    $classes = [];

                                    if ($studentAnswer) {
                                        // Check if this is the correct option
                                        if ($i == $question['correct_option']) {
                                            $classes[] = 'correct-option'; // Blue
                                        }

                                        // Check if user selected this option
                                        if ($i == $studentAnswer['selected_option']) {
                                            if ($studentAnswer['is_correct']) {
                                                $classes[] = 'selected-correct'; // Green
                                            } else {
                                                $classes[] = 'selected-wrong'; // Red
                                            }
                                        }
                                    }

                                    $classString = implode(' ', $classes);
                                ?>
                                    <li class="list-group-item <?= $classString ?>">
                                        <?= $i . '. ' . htmlspecialchars($optionValue) ?>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </td>
                        <td>
                            <?php
                            // answer field null hai, to correct option ka text dikhayenge:
                            $correctOptionNumber = $question['correct_option'];
                            $correctOptionText = $question['option' . $correctOptionNumber];
                            echo htmlspecialchars($correctOptionText);
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>



    <?php include __DIR__ . '/../partials/footer.php'; ?>

    <?php include __DIR__ . '/../partials/footer-links.php'; ?>
</body>

</html>