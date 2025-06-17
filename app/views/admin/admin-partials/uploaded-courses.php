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
                        <td><?= htmlspecialchars($course['file_type']) ?></td>
                        <td><?= htmlspecialchars($course['price']) ?></td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCourseModal<?= $course['id'] ?>">
                                Edit
                            </button>

                            <!-- Edit Course Modal -->
                            <div class="modal fade mt-5 pt-4 pt-lg-0 " id="editCourseModal<?= $course['id'] ?>" tabindex="-1" aria-labelledby="editCourseModalLabel<?= $course['id'] ?>" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <form action="?url=updateCourse" method="POST" enctype="multipart/form-data" class="row g-3 mt-0">
                                    <div class="modal-header py-0">
                                      <h5 class="modal-title pt-0 pb-3" id="editCourseModalLabel<?= $course['id'] ?>">Edit Course</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body row">
                                      <input type="hidden" name="id" value="<?= htmlspecialchars($course['id']) ?>">
                                      <div class="col-12 col-lg-6">
                                        <input type="text" name="course_name" class="form-control mb-3" placeholder="Course Name" value="<?= htmlspecialchars($course['course_name']) ?>">
                                      </div>
                                      <div class="col-12 col-lg-6">
                                        <input type="text" name="teacher_name" class="form-control mb-3" placeholder="Teacher Name" value="<?= htmlspecialchars($course['teacher_name']) ?>">
                                      </div>
                                      <div class="col-12 col-lg-6">
                                        <input type="text" name="category" class="form-control mb-3" placeholder="Category" value="<?= htmlspecialchars($course['category']) ?>">
                                      </div>
                                      <div class="col-12 col-lg-6">
                                        <input type="text" name="class" class="form-control mb-3" placeholder="Class" value="<?= htmlspecialchars($course['class']) ?>">
                                      </div>
                                      <div class="col-12">
                                        <textarea name="description" class="form-control mb-3" placeholder="Course Description" rows="3"><?= htmlspecialchars($course['description'] ?? '') ?></textarea>
                                      </div>
                                      <div class="col-12 col-lg-6">
                                        <input type="file" name="course_file" class="form-control mb-3">
                                      </div>
                                      <div class="col-12 col-lg-3">
                                        <select name="file_type" class="form-select mb-3">
                                          <option value="video" <?= (isset($course['file_type']) && $course['file_type'] == 'video') ? 'selected' : '' ?>>Video</option>
                                          <option value="pdf" <?= (isset($course['file_type']) && $course['file_type'] == 'pdf') ? 'selected' : '' ?>>PDF</option>
                                        </select>
                                      </div>
                                      <div class="col-12 col-lg-3">
                                        <input type="text" name="price" class="form-control mb-3" placeholder="Price" value="<?= htmlspecialchars($course['price']) ?>">
                                      </div>
                                      <div class="form-group col-12">
                                        <label for="thumbnail<?= $course['id'] ?>" class="p-2">Upload Thumbnail Of Video</label>
                                        <input type="file" name="thumbnail" class="form-control mb-3" id="thumbnail<?= $course['id'] ?>" placeholder="Upload Thumbnail Of Video">
                                      </div>
                                    </div>
                                    <div class="modal-footer col-12">
                                      <button type="submit" class="btn btn-success w-100">Update Course</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
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