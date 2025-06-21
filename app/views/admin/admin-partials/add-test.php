<style>
    .add-test-form {
        h2 {
            padding: 10px;
            background-color: var(--background-color);
            text-transform: uppercase;
            border-radius: 5px;
        }

        form {
            padding: 20px;
            border-radius: 5px;
            border: 1px solid var(--background-color);
        }
    }

    .added-tests-table {
        max-height: 460px;
        overflow: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
        border: 1px solid var(--background-color);
        border-radius: 5px;
        margin-top: 20px;

        h4 {
            padding: 10px;
            background-color: var(--background-color);
            text-transform: uppercase;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .list-group-item {
            border-radius: 5px;
            border: 1px solid var(--background-color);
            position: relative;
        }

        .btn-group {
            top: 50%;
            transform: translateY(-50%);
            position: absolute;
            right: 10px;
            display: flex;
            flex-direction: column;
            gap: 5px;

            button {
                width: 100px;
            }
        }
    }
</style>
<div class="add-test-form">
    <h2 class="mb-4">Create New Test</h2>
    <form method="post" action="adminAddTest">
        <div class="row">
            <div class="mb-2 col-lg-6 col-md-6 col-12">
                <label for="class" class="form-label">Class</label>
                <input type="number" class="form-control" id="class" name="class" required>
            </div>
            <div class="mb-2 col-lg-6 col-md-6 col-12">
                <label for="test_name" class="form-label">Test Name</label>
                <input type="text" class="form-control" id="test_name" name="test_name" required>
            </div>
        </div>
        <div class="mb-2">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="mb-2">
            <label for="chapter" class="form-label">Chapter</label>
            <input type="text" class="form-control" id="chapter" name="chapter" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">CREATE TEST</button>
    </form>
</div>

<?php
// Example: $tests = [['id'=>1, 'class'=>10, 'test_name'=>'Maths Test'], ...];
// Make sure each test has a unique 'id' key for deletion
if (isset($tests) && count($tests) > 0): ?>
    <div class="added-tests-table">
        <h4 class="mb-3">Added Tests</h4>
        <ul class="list-group p-3">
            <?php foreach ($tests as $i => $test): ?>
                <li class="list-group-item d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="ms-2 me-auto">
                        <div><strong>Test ID: <?= htmlspecialchars($test['id']) ?></strong></div>
                        <div>Class: <?= htmlspecialchars($test['class']) ?></div>
                        <div>Test Name: <?= htmlspecialchars($test['test_name']) ?></div>
                    </div>
                    <div class="btn-group" role="group">
                        <form method="post" action="updateTestStatus" class="d-inline" onsubmit="return confirmUpdate();">
                            <input type="hidden" name="test_id" value="<?= htmlspecialchars($test['id']) ?>">
                            <input type="hidden" name="status" value="Completed">
                            <button type="submit" class="btn btn-success btn-sm fw-bold"><?= htmlspecialchars($test['status']) ?></button>
                        </form>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateTestModal<?= $test['id'] ?>">
                            Edit
                        </button>
                    </div>
                    <!-- Update Modal -->
                    <div class="modal fade mt-5 py-5" id="updateTestModal<?= $test['id'] ?>" tabindex="-1" aria-labelledby="updateTestModalLabel<?= $test['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" action="updateTest">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateTestModalLabel<?= $test['id'] ?>">Update Test</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="test_id" value="<?= htmlspecialchars($test['id']) ?>">
                                        <div class="mb-3">
                                            <label for="update_class_<?= $test['id'] ?>" class="form-label">Class</label>
                                            <input type="number" class="form-control" id="update_class_<?= $test['id'] ?>" name="class" value="<?= htmlspecialchars($test['class']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="update_test_name_<?= $test['id'] ?>" class="form-label">Test Name</label>
                                            <input type="text" class="form-control" id="update_test_name_<?= $test['id'] ?>" name="test_name" value="<?= htmlspecialchars($test['test_name']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="update_chapter_<?= $test['id'] ?>" class="form-label">Chapter</label>
                                            <input type="text" class="form-control" id="update_chapter_<?= $test['id'] ?>" name="chapter" value="<?= htmlspecialchars($test['chapter']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach ?>
            </tbody>
            </table>
    </div>
<?php endif; ?>

<script>
    function confirmUpdate() {
        return confirm('Are you sure you want to mark completed the status of this test?');
    }
</script>