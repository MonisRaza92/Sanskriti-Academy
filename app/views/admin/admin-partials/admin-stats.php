<div class="admin-content mb-4">
    <div class="dashboard-cards row gy-2">
        <div class="col-md-3 col-6">
            <a href="?url=adminUsers">
                <div class="card">
                    <h3>Users</h3>
                    <p><?php echo htmlspecialchars($totalUsers ?? 0); ?>+</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="?url=adminCourses">
                <div class="card">
                    <h3>Courses</h3>
                    <p><?php echo htmlspecialchars($totalCourses ?? 0); ?>+</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="#">
                <div class="card">
                    <h3>Resources</h3>
                    <p><?php echo htmlspecialchars($totalResources ?? 0); ?>+</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="?url=adminBlogs">
                <div class="card">
                    <h3>Blogs</h3>
                    <p><?php echo htmlspecialchars($totalBlogs ?? 0); ?>+</p>
                </div>
            </a>
        </div>
    </div>
    <!-- Additional admin content can go here -->
</div>