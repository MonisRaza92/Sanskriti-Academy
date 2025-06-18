<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ?url=home');
    exit;
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Blogs</h1>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION['success_message'];
            unset($_SESSION['success_message']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php 
            echo $_SESSION['error_message'];
            unset($_SESSION['error_message']);
            ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            All Blogs
            <a href="?url=uploadBlog" class="btn btn-primary float-end">Add New Blog</a>
        </div>
        <div class="card-body">
            <table id="blogsTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($blogs)): ?>
                        <?php foreach ($blogs as $blog): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($blog['title']); ?></td>
                                <td><?php echo htmlspecialchars($blog['category']); ?></td>
                                <td>
                                    <span class="badge <?php echo $blog['status'] === 'published' ? 'bg-success' : 'bg-warning'; ?>">
                                        <?php echo ucfirst(htmlspecialchars($blog['status'])); ?>
                                    </span>
                                </td>
                                <td><?php echo date('Y-m-d H:i', strtotime($blog['created_at'])); ?></td>
                                <td>
                                    <a href="?url=blog&slug=<?php echo urlencode($blog['slug']); ?>" class="btn btn-sm btn-info" target="_blank">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <button class="btn btn-sm btn-danger delete-blog" data-blog-id="<?php echo $blog['id']; ?>">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No blogs found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this blog?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let blogIdToDelete = null;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

    // Initialize DataTable
    $('#blogsTable').DataTable({
        order: [[3, 'desc']] // Sort by created_at column by default
    });

    // Handle delete button clicks
    document.querySelectorAll('.delete-blog').forEach(button => {
        button.addEventListener('click', function() {
            blogIdToDelete = this.dataset.blogId;
            deleteModal.show();
        });
    });

    // Handle delete confirmation
    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (blogIdToDelete) {
            const formData = new FormData();
            formData.append('blog_id', blogIdToDelete);

            fetch('?url=deleteBlog', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the row from the table
                    const row = document.querySelector(`[data-blog-id="${blogIdToDelete}"]`).closest('tr');
                    row.remove();
                    
                    // Show success message
                    alert('Blog deleted successfully');
                } else {
                    alert('Failed to delete blog: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the blog');
            })
            .finally(() => {
                deleteModal.hide();
                blogIdToDelete = null;
            });
        }
    });
});
</script> 