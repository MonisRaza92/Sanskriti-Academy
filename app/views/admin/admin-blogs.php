<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ?url=");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/../partials/header-links.php'; ?>
    <title>Blog Management</title>
</head>

<body>
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="container-fluid mt-5 pt-4">
        <div class="container p-0">
            <div class="row">
                <div class="col-md-3">
                    <?php include __DIR__ . '/admin-partials/admin-sidebar.php'; ?>
                </div>
                <div class="col-lg-9">
                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php 
                            echo $_SESSION['success_message'];
                            unset($_SESSION['success_message']);
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php 
                            echo $_SESSION['error_message'];
                            unset($_SESSION['error_message']);
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php 
                    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';
                    if ($action === 'upload'): 
                    ?>
                        <!-- Upload Form -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                                <h5 class="mb-0">
                                    <i class="fas fa-edit me-2"></i>Add New Blog
                                </h5>
                                <a href="?url=adminBlogs" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-list me-2"></i>Back to Blogs
                                </a>
                            </div>
                            <div class="card-body">
                                <form action="?url=handleBlogUpload" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="title" name="title" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="slug" class="form-label">Slug</label>
                                                <input type="text" class="form-control" id="slug" name="slug" required>
                                                <small class="text-muted">URL-friendly version of the title (e.g., my-blog-post)</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="content" class="form-label">Content</label>
                                                <textarea class="form-control" id="content" name="content" rows="12" required></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select class="form-select" id="status" name="status" required>
                                                            <option value="draft">Draft</option>
                                                            <option value="published">Published</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="category" class="form-label">Category</label>
                                                        <input type="text" class="form-control" id="category" name="category" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="tags" class="form-label">Tags</label>
                                                        <input type="text" class="form-control" id="tags" name="tags" required>
                                                        <small class="text-muted">Separate tags with commas</small>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="featured_image" class="form-label">Featured Image</label>
                                                        <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="meta_title" class="form-label">Meta Title</label>
                                                        <input type="text" class="form-control" id="meta_title" name="meta_title" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="meta_desc" class="form-label">Meta Description</label>
                                                        <textarea class="form-control" id="meta_desc" name="meta_desc" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 text-end">
                                        <a href="?url=adminBlogs" class="btn btn-outline-secondary me-2">Cancel</a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Upload Blog
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Blog Management Table -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                                <h5 class="mb-0">
                                    <i class="fas fa-blog me-2"></i>Manage Blogs
                                </h5>
                                <a href="?url=adminBlogs&action=upload" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-2"></i>Add New Blog
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="blogsTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($blogs)): ?>
                                                <?php foreach ($blogs as $blog): ?>
                                                    <tr>
                                                        <td>
                                                            <div class="fw-bold"><?php echo htmlspecialchars($blog['title']); ?></div>
                                                            <small class="text-muted"><?php echo htmlspecialchars($blog['slug']); ?></small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-info">
                                                                <?php echo htmlspecialchars($blog['category']); ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge <?php echo $blog['status'] === 'published' ? 'bg-success' : 'bg-warning'; ?>">
                                                                <?php echo ucfirst(htmlspecialchars($blog['status'])); ?>
                                                            </span>
                                                        </td>
                                                        <td><?php echo date('Y-m-d H:i', strtotime($blog['created_at'])); ?></td>
                                                        <td class="text-end">
                                                            <a href="?url=blog&slug=<?php echo urlencode($blog['slug']); ?>" 
                                                               class="btn btn-info btn-sm" 
                                                               target="_blank">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <form action="?url=deleteBlog" method="POST" class="d-inline delete-blog-form">
                                                                <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
                                                                <button onclick="return confirm('Are you sure you want to delete this blog?');" type="submit" class="btn btn-danger btn-sm delete-blog">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="fas fa-info-circle me-2"></i>No blogs found
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade mt-5" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-trash-alt me-2"></i>
                        Confirm Delete
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Are you sure you want to delete this blog? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">
                        <i class="fas fa-trash me-2"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer-links.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-generate slug from title
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        if (titleInput && slugInput) {
            titleInput.addEventListener('input', function() {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)/g, '');
                slugInput.value = slug;
            });
        }

        // Initialize TinyMCE
        if (typeof tinymce !== 'undefined' && document.getElementById('content')) {
            tinymce.init({
                selector: '#content',
                height: 500,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
            });
        }

        // Initialize DataTable
        const blogsTable = document.getElementById('blogsTable');
        if (blogsTable) {
            const dataTable = $('#blogsTable').DataTable({
                order: [[3, 'desc']],
                pageLength: 10,
                language: {
                    search: '<i class="fas fa-search"></i>',
                    searchPlaceholder: 'Search blogs...'
                }
            });

            // Delete functionality
            let blogIdToDelete = null;
            const deleteModal = document.getElementById('deleteConfirmModal');
            if (!deleteModal) {
                console.error('Delete modal not found');
                return;
            }
            const modal = new bootstrap.Modal(deleteModal);

            // Add click handlers to delete buttons
            function addDeleteHandlers() {
                document.querySelectorAll('.delete-blog').forEach(button => {
                    button.onclick = function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        blogIdToDelete = this.dataset.blogId;
                        if (!blogIdToDelete) {
                            console.error('No blog ID found');
                            return;
                        }
                        modal.show();
                    };
                });
            }

            // Initial setup of delete handlers
            addDeleteHandlers();

            // Re-add handlers after DataTable operations
            $('#blogsTable').on('draw.dt', function() {
                console.log('DataTable redrawn, updating delete handlers');
                addDeleteHandlers();
            });

            // Handle delete confirmation
            const confirmDeleteBtn = document.getElementById('confirmDelete');
            if (!confirmDeleteBtn) {
                console.error('Confirm delete button not found');
                return;
            }

            confirmDeleteBtn.onclick = function() {
                if (!blogIdToDelete) {
                    console.error('No blog ID to delete');
                    return;
                }

                // Show loading state
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deleting...';
                this.disabled = true;

                const formData = new FormData();
                formData.append('blog_id', blogIdToDelete);

                fetch('?url=deleteBlog', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Find and remove the row
                        const deleteButton = document.querySelector(`.delete-blog[data-blog-id="${blogIdToDelete}"]`);
                        if (deleteButton) {
                            const row = deleteButton.closest('tr');
                            if (row) {
                                dataTable.row(row).remove().draw(false);
                            }
                        }

                        // Show success message
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            <i class="fas fa-check-circle me-2"></i>${data.message || 'Blog deleted successfully'}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        document.querySelector('.col-lg-9').insertAdjacentElement('afterbegin', alertDiv);
                        setTimeout(() => alertDiv.remove(), 3000);
                    } else {
                        throw new Error(data.message || 'Failed to delete blog');
                    }
                })
                .catch(error => {
                    console.error('Delete error:', error);
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                    alertDiv.innerHTML = `
                        <i class="fas fa-exclamation-circle me-2"></i>${error.message || 'An error occurred while deleting the blog'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    document.querySelector('.col-lg-9').insertAdjacentElement('afterbegin', alertDiv);
                })
                .finally(() => {
                    // Reset button state
                    this.innerHTML = '<i class="fas fa-trash me-2"></i>Delete';
                    this.disabled = false;
                    modal.hide();
                    blogIdToDelete = null;
                });
            };
        }
    });
    </script>
</body>
</html>