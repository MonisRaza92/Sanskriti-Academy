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
        <h3 class="mb-3 py-1 pb-2 ps-3 text-uppercase fw-bold rounded border border-2"><?php echo $question['question_text'] ?? 'Question not found'; ?></h3>

        <form method="post" action="submitAnswer" class="p-3 border border-2 rounded-2 bg-light">
            <div class="list-group">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <?php
                    $option = $question['option' . $i] ?? 'Option ' . $i . ' missing';
                    $isChecked = (isset($answer) && $answer == $i) ? 'checked' : '';
                    $optionId = "option{$i}";
                    ?>
                    <label class="list-group-item d-flex align-items-center rounded-2 mb-2" style="cursor:pointer;">
                        <input
                            type="radio"
                            name="option"
                            value="<?php echo $i; ?>"
                            id="<?php echo $optionId; ?>"
                            class="form-check-input me-3"
                            <?php echo $isChecked; ?>
                            required>
                        <span class="fw-semibold"><?php echo htmlspecialchars($option); ?></span>
                    </label>
                <?php endfor; ?>
            </div>

            <input type="hidden" name="question_id" value="<?php echo $question['id'] ?? 0; ?>">
            <input type="hidden" name="test_id" value="<?php echo $test_id ?? 0; ?>">
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary btn-lg rounded-2">Submit Answer</button>
            </div>
        </form>

    </div>



    <?php include __DIR__ . '/../partials/footer.php'; ?>

    <?php include __DIR__ . '/../partials/footer-links.php'; ?>
</body>

</html>