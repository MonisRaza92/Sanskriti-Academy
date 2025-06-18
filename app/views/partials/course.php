<div class="container-fluid pb-5 <?php echo empty($courses) ? 'd-none' : ''; ?> <?php if (isset($_GET['url']) && $_GET['url'] === 'courses'): ?>mt-5 py-4<?php endif; ?>">
    <div class="container">
        <div class="courses-header d-flex justify-content-between align-items-start ">
            <div class="courses-heading">
                <p class="heading p-0 m-0">our Courses</p>
                <p class="sub-heading p-0 m-0 mb-5">Explore our wide range of courses designed to help you learn and grow.</p>
            </div>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="?url=adminCourses" class="btn btn-primary rounded-full mt-3">Add Course</a>
            <?php endif; ?>
        </div>
        <div class="row">
            <?php
            $counter = 0;
            foreach ($courses as $course):
                // Skip after 3 cards if not on courses page
                if (!isset($_GET['url']) || $_GET['url'] !== 'courses') {
                    if ($counter >= 3) continue;
                }
                $counter++;
            ?>
                <div class="px-2 col-lg-4 col-md-6 col-sm-12">
                    <div class="course-card mb-3" style="cursor:pointer;" data-course-id="<?= $course['id'] ?>">
                        <?php if (!empty($course['thumbnail'])): ?>
                            <img src="<?php echo base_url(htmlspecialchars($course['thumbnail'])); ?>" alt="Course Thumbnail" class="img-fluid course-thumbnail">
                        <?php else: ?>
                            <p>N/A</p>
                        <?php endif; ?>
                        <div class="course-card-content">
                            <span class="badge1">Course: <?= htmlspecialchars($course['category']) ?></span>
                            <span class="badge2">Class: <?= htmlspecialchars($course['class']) ?></span>
                            <div class="course-heading">
                                <h3><?= htmlspecialchars($course['course_name']) ?></h3>
                                <h6 class="py-3 text-muted">From : <?= htmlspecialchars($course['teacher_name']) ?></h6>
                            </div>
                            <div class="card-bottom">
                                <h2>₹ <?= htmlspecialchars($course['price']) ?></h2>
                                <button class="btn btn-primary">BUY NOW</button>
                            </div>
                        </div>
                    </div>

                    <!-- Popup Modal -->
                    <div class="modal fade mt-5 mb-5 pb-5 py-4" id="courseModal<?= $course['id'] ?>" tabindex="-1" aria-labelledby="courseModalLabel<?= $course['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="courseModalLabel<?= $course['id'] ?>"><?= htmlspecialchars($course['course_name']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <?php if (!empty($course['thumbnail']) && (isset($course['file_type']) && $course['file_type'] === 'pdf')): ?>
                                                <img src="<?php echo base_url(htmlspecialchars($course['thumbnail'])); ?>" alt="Course Thumbnail" class="img-fluid mb-3">
                                            <?php endif; ?>
                                            <?php if (!empty($course['file_path'])): ?>
                                                <?php if ($course['file_type'] === 'pdf'): ?>
                                                    <button href="<?= base_url(htmlspecialchars($course['file_path'])) ?>" class="mb-3 btn btn-primary w-100" download>BUY NOW</button>
                                                <?php elseif ($course['file_type'] === 'video'): ?>
                                                    <video controls width="100%">
                                                        <source src="<?= base_url(htmlspecialchars($course['file_path'])) ?>" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                    <button class="btn btn-primary w-100">BUY NOW</button>
                                                    <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-7">
                                            <p><strong>Category:</strong> <?= htmlspecialchars($course['category']) ?></p>
                                            <p><strong>Class:</strong> <?= htmlspecialchars($course['class']) ?></p>
                                            <p><strong>Teacher:</strong> <?= htmlspecialchars($course['teacher_name']) ?></p>
                                            <p><strong>Price:</strong> ₹ <?= htmlspecialchars($course['price']) ?></p>
                                            <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($course['description'])) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var card = document.querySelector('[data-course-id="<?= $course['id'] ?>"]');
                            if (card) {
                                card.addEventListener('click', function() {
                                    var modal = new bootstrap.Modal(document.getElementById('courseModal<?= $course['id'] ?>'));
                                    modal.show();
                                });
                            }
                        });
                    </script>
                </div>
            <?php endforeach; ?>

            <?php if ((!isset($_GET['url']) || $_GET['url'] !== 'courses') && count($courses) > 3): ?>
                <div class="col-12 text-center mt-4">
                    <a href="?url=courses" class="btn">View All Courses</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>