<?php
require_once __DIR__ . '/../models/CoursesModel.php';

class CourseController
{
    private $model;

    public function __construct()
    {
        $this->model = new CourseModel();
    }

    public function addCourse()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filePath = '';
            $thumbnailPath = '';

            //file upload handling
            if (isset($_FILES['course_file']) && $_FILES['course_file']['error'] === 0) {

                $uploadDir = __DIR__ . '/../../public/uploads/courses/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $fileName = time() . '_' . basename($_FILES['course_file']['name']);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['course_file']['tmp_name'], $targetPath)) {
                    $filePath = 'public/uploads/courses/'. $fileName;
                } else {
                    // Optional: error handling if move fails
                    die("File upload failed.");
                }
            }
            // Thumbnail upload handling
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {

                $uploadDir = __DIR__ . '/../../public/uploads/courses/thumbnails/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $fileName = time() . '_' . basename($_FILES['thumbnail']['name']);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetPath)) {
                    $thumbnailPath ='public/uploads/courses/thumbnails/' . $fileName;
                } else {
                    // Optional: error handling if move fails
                    die("File upload failed.");
                }
            }
    

            $data = [                  
                'course_name' => $_POST['course_name'],
                'description' => $_POST['description'],
                'file_path' => $filePath,
                'file_type' => $_POST['file_type'],
                'price' => $_POST['price'],
                'teacher_name' => $_POST['teacher_name'],
                'category' => $_POST['category'],
                'class' => $_POST['class'],
                'thumbnail' => $thumbnailPath
            ];

            $this->model->addCourse($data);
            header("Location: ?url=adminCourses");
            exit;
        }
    }


    public function deleteCourse()
    {
        if (isset($_GET['id'])) {
            $this->model->deleteCourse($_GET['id']);
            header("Location: ?url=adminCourses");
            exit;
        }
    }

    // Optional: For editing course
    public function updateCourse()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filePath = $_POST['existing_file']; // If no new file uploaded
            if (isset($_FILES['course_file']) && $_FILES['course_file']['error'] === 0) {
                $uploadDir =__DIR__. '/../../public/uploads/courses/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $fileName = time() . '_' . basename($_FILES['course_file']['name']);
                $targetPath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['course_file']['tmp_name'], $targetPath)) {
                    $filePath = 'public/uploads/courses/' . $fileName;
                }
            }
            // Thumbnail upload handling
            $thumbnailPath = $_POST['existing_thumbnail']; // If no new thumbnail uploaded  
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {
                $uploadDir = __DIR__ . '/../../public/uploads/courses/thumbnails/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $fileName = time() . '_' . basename($_FILES['thumbnail']['name']);
                $targetPath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetPath)) {
                    $thumbnailPath = 'public/uploads/courses/thumbnails/' . $fileName;
                }
            }

            $data = [
                'id' => $_POST['id'],
                'course_name' => $_POST['course_name'],
                'description' => $_POST['description'],
                'file_path' => $filePath,
                'file_type' => $_POST['file_type'],
                'price' => $_POST['price'],
                'teacher_name' => $_POST['teacher_name'],
                'category' => $_POST['category'],
                'class' => $_POST['class'],
                'thumbnail' => $thumbnailPath
            ];

            $this->model->updateCourse($data);
            header("Location: ?url=updateCourses");
            exit;
        } else {
            $course = $this->model->getCourseById($_GET['id']);
            require_once 'app/views/admin/update_course.php';
        }
    }
}
