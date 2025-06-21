<?php
include_once __DIR__ . '/../app/controllers/HomeController.php';
include_once __DIR__ . '/../app/controllers/AuthController.php';
include_once __DIR__ . '/../app/controllers/AdminController.php';
include_once __DIR__ . '/../app/controllers/CoursesController.php';
include_once __DIR__ . '/../app/controllers/BlogController.php';
include_once __DIR__ . '/../app/controllers/TestController.php';
include_once __DIR__ . '/../core/Mailer.php';
$routes = [
    '' => 'HomeController@index',
    'tests' => 'HomeController@tests',
    'startTest' => 'HomeController@startTest',
    'testSelect' => 'HomeController@selectTest',
    'subjectSelect' => 'HomeController@showSubjectSelect',
    'chapterSelect' => 'HomeController@showChapterSelect',
    'result' => 'TestController@result',
    'courses' => 'HomeController@courses',
    'privacy-policy' => 'HomeController@privacyPolicy', 
    'terms-and-conditions' => 'HomeController@termsAndConditions',
    'login' => 'AuthController@showLoginForm',
    'signup' => 'AuthController@showSignupForm',
    'sendOtp' => 'AuthController@sendOtp',
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
    'adminTests' => 'AdminController@adminTests',
    'adminResults' => 'AdminController@adminResults',
    'adminEvents' => 'AdminController@adminEvents',
    'adminAddEvent' => 'AdminController@addEvent',
    'adminDeleteEvent' => 'AdminController@deleteEvent',
    'adminUpdateEvent' => 'AdminController@updateEvent',
    'updateTestStatus' => 'TestController@updateTestStatus',
    'updateTest' => 'TestController@updateTest',
    'adminAddTest' => 'TestController@addTest',
    'adminAddQuestion' => 'TestController@addQuestion',
    'deleteQuestion' => 'TestController@deleteQuestion',
    'updateQuestion' => 'TestController@updateQuestion',
    'selectTest' => 'TestController@selectTest',
    'submitAnswer' => 'TestController@submitAnswer',
    'viewTestResults' => 'TestController@viewTestResults',
    'addCourse' => 'CourseController@addCourse',
    'viewCourses' => 'CourseController@viewCourses',
    'viewCourse' => 'CourseController@viewCourse',
    'updateCourse' => 'CourseController@updateCourse',
    'deleteCourse' => 'CourseController@deleteCourse',  
    'adminBlogs' => 'BlogController@showAdminBlogs',
    'blogs' => 'BlogController@showAllBlogs',
    'blog' => 'BlogController@viewBlog',
    'handleBlogUpload' => 'BlogController@handleUpload',
    'deleteBlog' => 'BlogController@deleteBlog',
    'payment' => 'PaymentController@pyment',
    'phonepe-callback' => 'PaymentController@phonepeCallback',
    'payment/initiate' => 'PaymentController@initiatePayment',
    'payment-success' => 'PaymentController@paymentSuccess',
    'payment-fail' => 'PaymentController@paymentFail',
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