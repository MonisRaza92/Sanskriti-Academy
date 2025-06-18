<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/partials/header-links.php'; ?>
    <title>SANSKRITI ACADEMY - Blog</title>
</head>

<body>
    <?php include __DIR__ . '/partials/navbar.php'; ?>


    <div class="container py-5 mt-5">
        <div class="row g-4">
            <?php if (!empty($blogs)): ?>
                <?php foreach ($blogs as $blog): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card blog-card h-100 shadow-sm">
                            <?php if (!empty($blog['featured_image'])): ?>
                                <img src="<?php echo htmlspecialchars($blog['featured_image']); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($blog['title']); ?>">
                            <?php else: ?>
                                <img src="assets/images/default-blog.jpg" class="card-img-top" alt="Default Blog Image">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($blog['title']); ?></h5>
                                <div class="blog-meta mb-3">
                                    <span><i class="fas fa-folder me-2"></i><?php echo htmlspecialchars($blog['category']); ?></span>
                                    <span class="ms-3"><i class="fas fa-calendar me-2"></i><?php echo date('M d, Y', strtotime($blog['created_at'])); ?></span>
                                </div>
                                <p class="card-text"><?php echo substr(strip_tags($blog['content']), 0, 150) . '...'; ?></p>
                            </div>
                            <?php if (!empty($blog['tags'])): ?>
                                <div class="card-footer bg-transparent blog-tags">
                                    <?php 
                                    $tags = explode(',', $blog['tags']);
                                    foreach ($tags as $tag): ?>
                                        <span class="badge bg-light"><?php echo trim(htmlspecialchars($tag)); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <a href="?url=blog&slug=<?php echo urlencode($blog['slug']); ?>" 
                                   class="btn btn-theme">
                                    Read More <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        No blogs available at the moment.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include __DIR__ . '/partials/footer.php'; ?>
    <?php include __DIR__ . '/partials/footer-links.php'; ?>

</body>

</html> 