<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/partials/header-links.php'; ?>
    <title>SANSKRITI ACADEMY - <?php echo htmlspecialchars($blog['title']); ?></title>
</head>

<body>
    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <div class="blog-single-header py-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="?url=">Home</a></li>
                    <li class="breadcrumb-item"><a href="?url=blogs">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($blog['title']); ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <article class="blog-post bg-white p-4 rounded shadow-sm">
                    <header class="blog-post-header mb-4">
                        <h1 class="blog-post-title"><?php echo htmlspecialchars($blog['title']); ?></h1>
                        <div class="blog-post-meta text-muted mb-4 pb-3 border-bottom">
                            <span><i class="fas fa-calendar me-2"></i><?php echo date('F d, Y', strtotime($blog['created_at'])); ?></span>
                            <span class="ms-3"><i class="fas fa-folder me-2"></i><?php echo htmlspecialchars($blog['category']); ?></span>
                        </div>
                    </header>

                    <?php if (!empty($blog['featured_image'])): ?>
                        <div class="blog-post-image mb-4">
                            <img src="<?php echo htmlspecialchars($blog['featured_image']); ?>" 
                                 class="img-fluid rounded" 
                                 alt="<?php echo htmlspecialchars($blog['title']); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="blog-post-content mb-4">
                        <?php echo $blog['content']; ?>
                    </div>

                    <?php if (!empty($blog['tags'])): ?>
                        <div class="blog-post-tags mb-4 p-3 bg-light rounded">
                            <h5 class="mb-3"><i class="fas fa-tags me-2"></i>Tags</h5>
                            <?php 
                            $tags = explode(',', $blog['tags']);
                            foreach ($tags as $tag): ?>
                                <span class="badge bg-white me-2 mb-2"><?php echo trim(htmlspecialchars($tag)); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="blog-post-navigation text-center pt-4 mt-4 border-top">
                        <a href="?url=blogs" class="btn btn-theme">
                            <i class="fas fa-arrow-left me-2"></i>Back to Blogs
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/partials/footer.php'; ?>
    <?php include __DIR__ . '/partials/footer-links.php'; ?>

    <style>
    :root {
        --theme-color: #920000;
        --theme-color-hover: #7a0000;
    }

    .blog-single-header {
        background: var(--theme-color);
        color: white;
    }

    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-item a:hover {
        color: white;
    }

    .breadcrumb-item.active {
        color: white;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.8);
    }

    .blog-post {
        border: none;
    }

    .blog-post-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--theme-color);
        margin-bottom: 1rem;
    }

    .blog-post-meta {
        font-size: 1rem;
        color: #6c757d;
    }

    .blog-post-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #444;
    }

    .blog-post-content p {
        margin-bottom: 1.5rem;
    }

    .blog-post-content h2, 
    .blog-post-content h3 {
        color: var(--theme-color);
        margin: 2rem 0 1rem;
    }

    .blog-post-content a {
        color: var(--theme-color);
        text-decoration: none;
    }

    .blog-post-content a:hover {
        color: var(--theme-color-hover);
        text-decoration: underline;
    }

    .blog-post-tags .badge {
        padding: 0.5em 1em;
        color: var(--theme-color);
        border: 1px solid var(--theme-color);
        font-weight: normal;
    }

    .btn-theme {
        background-color: var(--theme-color);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-theme:hover {
        background-color: var(--theme-color-hover);
        color: white;
        transform: translateX(-5px);
    }

    /* Override any bootstrap theme colors */
    .text-primary {
        color: var(--theme-color) !important;
    }

    .bg-primary {
        background-color: var(--theme-color) !important;
    }

    .btn-primary {
        background-color: var(--theme-color) !important;
        border-color: var(--theme-color) !important;
    }

    .btn-primary:hover {
        background-color: var(--theme-color-hover) !important;
        border-color: var(--theme-color-hover) !important;
    }

    .btn-outline-primary {
        color: var(--theme-color) !important;
        border-color: var(--theme-color) !important;
    }

    .btn-outline-primary:hover {
        background-color: var(--theme-color) !important;
        color: white !important;
    }
    </style>
</body>

</html> 