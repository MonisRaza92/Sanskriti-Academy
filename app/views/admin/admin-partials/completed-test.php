<?php
if (isset($completedTests) && count($completedTests) > 0): ?>
    <div class="added-tests-table">
        <h4 class="mb-3">Completed Tests</h4>
        <ul class="list-group p-3">
            <?php foreach ($completedTests as $i => $test): ?>
                <li class="list-group-item d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="ms-2 me-auto">
                        <div><strong>Test ID: <?= htmlspecialchars($test['id']) ?></strong></div>
                        <div>Class: <?= htmlspecialchars($test['class']) ?></div>
                        <div>Test Name: <?= htmlspecialchars($test['test_name']) ?></div>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-success btn-sm fw-bold"><?= htmlspecialchars($test['status']) ?></button>

                        <form action="?url=adminResultsByTest" method="GET">
                            <input type="hidden" name="url" value="adminResultsByTest">
                            <input type="hidden" name="test_id" value="<?= htmlspecialchars($test['id']) ?>">
                            <button type="submit" class="btn btn-dark btn-sm">Results</button>
                        </form>
                    </div>
                </li>
            <?php endforeach ?>
            </tbody>
            </table>
    </div>
<?php endif; ?>
<style>
    .added-tests-table {
        max-height: 876px;
        overflow: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
        border: 1px solid var(--background-color);
        border-radius: 5px;

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