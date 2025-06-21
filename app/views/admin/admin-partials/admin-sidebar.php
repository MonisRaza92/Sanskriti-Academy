<div class="admin-sidebar">
    <div class="sidebar-header">
        <img src="<?php echo htmlspecialchars($_SESSION['user']['profile_image'] ?? 'assets/images/Icons/user.webp'); ?>" alt="">
        <div class="admin-info">
            <h3><?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Admin'); ?></h3>
            <p><?php echo htmlspecialchars($_SESSION['user']['email'] ?? 'hello@admin.com'); ?></p>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul>
            <?php $currentPage = $_GET['url'] ?? 'admin'; ?>

            <li class="<?= $currentPage == 'admin' ? 'active-li' : '' ?>">
                <a href="?url=admin"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            </li>
            <li class="<?= $currentPage == 'adminUsers' ? 'active-li' : '' ?>">
                <a href="?url=adminUsers"><i class="fa-solid fa-users"></i> Users</a>
            </li>
            <li class="<?= $currentPage == 'adminCourses' ? 'active-li' : '' ?>">
                <a href="?url=adminCourses"><i class="fa-solid fa-book"></i> Courses</a>
            </li>
            <li class=" <?= $currentPage == 'adminBlogs' ? 'active-li' : '' ?>">
                <a href="?url=adminBlogs"><i class="fa-solid fa-blog"></i> Blogs</a>
            </li>
            <li class="<?= $currentPage == 'adminTests' ? 'active-li' : '' ?>">
                <a href="?url=adminTests"><i class="fa-solid fa-folder"></i> Tests</a>
            </li>
            <li class="<?= $currentPage == 'adminEvents' ? 'active-li' : '' ?>">
                <a href="?url=adminEvents"><i class="fa-regular fa-calendar-days"></i> Events</a>
            </li>
            <li class="<?= $currentPage == 'adminResults' ? 'active-li' : '' ?>">
                <a href="?url=adminResults"><i class="fa-solid fa-chart-line"></i> Results</a>
            </li>
            <li class="<?= $currentPage == 'adminDiscount' ? 'active-li' : '' ?>">
                <a href="?url=adminDiscount"><i class="fa-solid fa-percent"></i> Discount</a>
            </li>
            <li class="<?= $currentPage == 'adminSettings' ? 'active-li' : '' ?>">
                <a href="?url=adminSettings"><i class="fa-solid fa-gears"></i> Settings</a>
            </li>
            <li>
                <a href="?url=logout" style="color: red;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </li>

        </ul>
    </div>
</div>