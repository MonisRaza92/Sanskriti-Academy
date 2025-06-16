<h3 class="uploaded-course-heading mt-3">Uploaded Courses</h3>
<?php
// Assuming $courses is an array of courses fetched from the database
if (isset($courses) && is_array($courses) && count($courses) > 0): ?>
    <div class="table-responsive w-100 overflow-x-auto">
        <table class="table table-bordered table-striped align-middle" style="min-width: 1100px ;">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Course Name</th>
                    <th>Teacher</th>
                    <th>Category</th>
                    <th>Class</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $index => $course): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($course['course_name']) ?></td>
                        <td><?= htmlspecialchars($course['teacher_name']) ?></td>
                        <td><?= htmlspecialchars($course['category']) ?></td>
                        <td><?= htmlspecialchars($course['class']) ?></td>
                        <td><?= htmlspecialchars($course['description']) ?></td>
                        <td><?= htmlspecialchars($course['file_type']) ?></td>
                        <td><?= htmlspecialchars($course['price']) ?></td>
                        <td>
                            <a href="?url=editCourse&id=<?= urlencode($course['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="?url=deleteCourse&id=<?= urlencode($course['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p class="mt-4 text-muted">No courses uploaded yet.</p>
<?php endif; ?>