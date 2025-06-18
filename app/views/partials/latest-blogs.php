<?php
require_once __DIR__ . '/../../controllers/BlogController.php';
$blogController = new BlogController();
$latestBlogs = $blogController->getLatestBlogs(3);
?>

<div class="container-fluid py-5 bg-light <?php echo empty($latestBlogs) ? 'd-none' : ''; ?>">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="fw-bold">Latest Blog Posts</h2>
                <p class="text-muted">Stay updated with our latest articles and insights</p>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($latestBlogs)): ?>
                <?php foreach ($latestBlogs as $blog): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php if (!empty($blog['featured_image'])): ?>
                                <img src="<?php echo htmlspecialchars($blog['featured_image']); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($blog['title']); ?>"
                                     style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-primary"><?php echo htmlspecialchars($blog['category']); ?></span>
                                    <small class="text-muted"><?php echo date('M d, Y', strtotime($blog['created_at'])); ?></small>
                                </div>
                                <h5 class="card-title"><?php echo htmlspecialchars($blog['title']); ?></h5>
                                <p class="card-text">
                                    <?php 
                                    $content = strip_tags($blog['content']);
                                    echo strlen($content) > 150 ? substr($content, 0, 150) . '...' : $content;
                                    ?>
                                </p>
                                <div class="mt-3">
                                    <a href="?url=blog&slug=<?php echo urlencode($blog['slug']); ?>" 
                                       class="btn btn-outline-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>No blog posts available yet.</p>
                </div>
            <?php endif; ?>
        </div>
        <?php if (!empty($latestBlogs)): ?>
            <div class="row">
                <div class="col-12 text-center mt-3">
                    <a href="?url=blogs" class="btn btn-primary">View All Blogs</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>