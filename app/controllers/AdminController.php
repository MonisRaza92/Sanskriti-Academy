<?php
include_once __DIR__ . '/../models/AuthModel.php';
include_once __DIR__ . '/../models/CoursesModel.php';
include_once __DIR__ . '/../models/BlogModel.php';

class AdminController {
    public function adminUsers() {
        $model = new AuthModel();
        $users = $model->getAllUsers();
        $totalUsers = count($users);
        include_once __DIR__ . '/../views/admin/admin-users.php';
    }

    public function adminCourses() {
        $coursesModel = new CourseModel();
        $courses = $coursesModel->getAllCourses();
        $totalCourses = count($courses);
        $categories = ['Programming', 'Design', 'Marketing', 'Business', 'Science'];
        require_once __DIR__ . '/../views/admin/admin-courses.php';
    }

    public function adminDashboard() {
        // Get user stats
        $userModel = new AuthModel();
        $users = $userModel->getAllUsers();
        $totalUsers = count($users);

        // Get course stats
        $courseModel = new CourseModel();
        $courses = $courseModel->getAllCourses();
        $totalCourses = count($courses);

        // Get blog stats
        $blogModel = new BlogModel();
        $blogs = $blogModel->getAllBlogs();
        $totalBlogs = count($blogs);

        // Get total resources (you can implement this later)
        $totalResources = 0;

        // Pass all stats to the dashboard view
        require __DIR__ . '/../views/admin/index.php';
    }
}
?>