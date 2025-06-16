<?php
require_once __DIR__ . '/../models/CoursesModel.php';

class HomeController
{
    public function view($view, $data = [])
    {
        extract($data); // $courses etc. directly usable
        require_once __DIR__ . "/../views/{$view}.php";
    }

    public function index()
    {
        $coursesModel = new CourseModel();
        $courses = $coursesModel->getAllCourses();

        $this->view('index', ['courses' => $courses]);
    }

    public function courses()
    {
        $coursesModel = new CourseModel();
        $courses = $coursesModel->getAllCourses();

        $this->view('courses', ['courses' => $courses]);
        exit();   
    }

    public function about()
    {
        require_once __DIR__ . '/../views/about.php';
        exit();
    }
}
