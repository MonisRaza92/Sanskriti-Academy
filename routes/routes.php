<?php
include_once __DIR__ . '/../app/controllers/HomeController.php';
include_once __DIR__ . '/../app/controllers/AuthController.php';
include_once __DIR__ . '/../app/controllers/AdminController.php';
include_once __DIR__ . '/../app/controllers/CoursesController.php';
include_once __DIR__ . '/../app/controllers/BlogController.php';
include_once __DIR__ . '/../core/Mailer.php';
$routes = [
    '' => 'HomeController@index',
    'courses' => 'HomeController@courses',
    'privacy-policy' => 'HomeController@privacyPolicy', 
    'terms-and-conditions' => 'HomeController@termsAndConditions',
    'login' => 'AuthController@showLoginForm',
    'signup' => 'AuthController@showSignupForm',
    'loginSubmit' => 'AuthController@handleLogin',
    'signupSubmit' => 'AuthController@handleSignup',
    'logout' => 'AuthController@logoutUser',
    'admin' => 'AuthController@adminDashboard',
    'account' => 'AuthController@accountdetails',
    'changePassword' => 'AuthController@changePassword',
    'deleteAccount' => 'AuthController@deleteAccount',
    'updateDetails' => 'AuthController@updateDetails',
    'forgotPassword' => 'AuthController@resetPassword',
    'resetPassword' => 'AuthController@handleResetPassword',
    'resources' => 'CourseController@resources',
    'admin/showUsers' => 'AuthController@showUsers',
    'deleteUser' => 'AuthController@deleteUser',
    'updateUser' => 'AuthController@updateUser',
    'adminUsers' => 'AdminController@adminUsers',
    'adminCourses' => 'AdminController@adminCourses',
    'admin/showCourses' => 'AuthController@showCourses',
    'addCourse' => 'CourseController@addCourse',
    'viewCourses' => 'CourseController@viewCourses',
    'viewCourse' => 'CourseController@viewCourse',
    'updateCourse' => 'CourseController@updateCourse',
    'deleteCourse' => 'CourseController@deleteCourse',  
    'adminBlogs' => 'BlogController@showAdminBlogs',
    'blogs' => 'BlogController@showAllBlogs',
    'blog' => 'BlogController@viewBlog',
    'handleBlogUpload' => 'BlogController@handleUpload',
    'deleteBlog' => 'BlogController@deleteBlog'
];

function handleRequest($routes) {
    $url = isset($_GET['url']) ? $_GET['url'] : '';
    if (array_key_exists($url, $routes)) {
        list($controller, $action) = explode('@', $routes[$url]);
        $controller = new $controller();
        
        // Special handling for blog viewing
        if ($url === 'blog' && isset($_GET['slug'])) {
            $controller->viewBlog($_GET['slug']);
        } else {
            $controller->$action();
        }
    } else {
        echo "Page not found!";
    }
}

handleRequest($routes);
?>