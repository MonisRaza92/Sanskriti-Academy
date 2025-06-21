<div class="container my-4 px-0">
    <h2 class="mb-4 py-1 ps-3 pb-2 rounded" style="background-color: var(--background-color);">Add Question to Test:</h2>
    <form method="post" action="adminAddQuestion" class="card p-4 shadow-sm mb-5">
        <div class="mb-3">
            <label class="form-label">Question</label>
            <select name="test_id" class="form-select mb-2" required>
                <option value="">Select Test</option>
                <?php foreach ($tests as $test): ?>
                    <option value="<?php echo $test['id']; ?>" <?php if (isset($test_id) && $test_id == $test['id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($test['id'] . ' - ' . $test['test_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="question_text" class="form-control" required placeholder="Enter question text">
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-2">
                <label class="form-label">Option 1</label>
                <input type="text" name="option1" class="form-control" required>
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label">Option 2</label>
                <input type="text" name="option2" class="form-control" required>
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label">Option 3</label>
                <input type="text" name="option3" class="form-control" required>
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label">Option 4</label>
                <input type="text" name="option4" class="form-control" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Correct Option (1-4)</label>
            <input type="number" name="correct_option" class="form-control" required min="1" max="4">
        </div>
        <div class="mb-3">
            <label class="form-label">Answer</label>
            <input type="text" name="answer" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Question</button>
    </form>



    <h3>Select Test to View Questions:</h3>

    <form method="get" action="">
        <input type="hidden" name="url" value="adminTests">
        <div class="mb-3">
            <label for="test_id" class="form-label">Choose Test:</label>
            <select name="test_id" id="test_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Select Test --</option>
                <?php foreach ($tests as $test): ?>
                    <option value="<?php echo $test['id']; ?>" <?php if (isset($_GET['test_id']) && $_GET['test_id'] == $test['id']) echo 'selected'; ?>>
                        Test ID: (<?php echo $test['id']; ?>) Test Name: <?php echo htmlspecialchars($test['test_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <?php if (!empty($test_id) && !empty($questions)): ?>
        <?php
        // Get the test name for the selected test_id
        $selected_test = array_filter($tests, function ($t) use ($test_id) {
            return $t['id'] == $test_id;
        });
        $selected_test = reset($selected_test); // Get first matched test
        ?>
        <h4 class="mb-3">
            Questions for Test ID: <?php echo $test_id; ?>,
            Test Name: <?php echo htmlspecialchars($selected_test['test_name']); ?>
        </h4>

        <div class="row">
            <?php foreach ($questions as $question): ?>
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($question['question_text']); ?></h5>
                            <ol class="mb-2">
                                <li><?php echo htmlspecialchars($question['option1']); ?></li>
                                <li><?php echo htmlspecialchars($question['option2']); ?></li>
                                <li><?php echo htmlspecialchars($question['option3']); ?></li>
                                <li><?php echo htmlspecialchars($question['option4']); ?></li>
                            </ol>
                            <span class="badge bg-success mb-2">Correct Option: <?php echo $question['correct_option']; ?></span>
                            <div class="d-flex mt-2">
                                <!-- Edit Button triggers modal -->
                                <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editQuestionModal<?php echo $question['id']; ?>">
                                    Edit
                                </button>

                                <!-- Edit Modal -->
                                <div class="modal mt-5 py-5 fade" id="editQuestionModal<?php echo $question['id']; ?>" tabindex="-1" aria-labelledby="editQuestionModalLabel<?php echo $question['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="post" action="updateQuestion">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editQuestionModalLabel<?php echo $question['id']; ?>">Edit Question</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
                                                    <input type="hidden" name="test_id" value="<?php echo $test['id']; ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label">Question Text</label>
                                                        <input type="text" name="question_text" class="form-control" required value="<?php echo htmlspecialchars($question['question_text']); ?>">
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label">Option 1</label>
                                                            <input type="text" name="option1" class="form-control" required value="<?php echo htmlspecialchars($question['option1']); ?>">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label">Option 2</label>
                                                            <input type="text" name="option2" class="form-control" required value="<?php echo htmlspecialchars($question['option2']); ?>">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label">Option 3</label>
                                                            <input type="text" name="option3" class="form-control" required value="<?php echo htmlspecialchars($question['option3']); ?>">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label">Option 4</label>
                                                            <input type="text" name="option4" class="form-control" required value="<?php echo htmlspecialchars($question['option4']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Correct Option (1-4)</label>
                                                        <input type="number" name="correct_option" class="form-control" required min="1" max="4" value="<?php echo $question['correct_option']; ?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update Question</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <form method="post" action="deleteQuestion" onsubmit="return confirm('Are you sure you want to delete this question?');">
                                    <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php elseif (!empty($test_id)): ?>
        <div class="alert alert-warning mt-4">No questions found for this test.</div>
    <?php endif; ?>




</div>