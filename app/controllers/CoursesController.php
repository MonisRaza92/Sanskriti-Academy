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
            $id = $_POST['id'];

            // Fetch existing course data
            $existing = $this->model->getCourseById($id);

            // Only update fields present in POST, otherwise keep old value
            $data = [
                'id' => $id,
                'course_name' => isset($_POST['course_name']) ? $_POST['course_name'] : $existing['course_name'],
                'description' => isset($_POST['description']) ? $_POST['description'] : $existing['description'],
                'file_path' => $existing['file_path'],
                'file_type' => isset($_POST['file_type']) ? $_POST['file_type'] : $existing['file_type'],
                'price' => isset($_POST['price']) ? $_POST['price'] : $existing['price'],
                'teacher_name' => isset($_POST['teacher_name']) ? $_POST['teacher_name'] : $existing['teacher_name'],
                'category' => isset($_POST['category']) ? $_POST['category'] : $existing['category'],
                'class' => isset($_POST['class']) ? $_POST['class'] : $existing['class'],
                'thumbnail' => $existing['thumbnail']
            ];

            // Handle file upload if new file is uploaded
            if (isset($_FILES['course_file']) && $_FILES['course_file']['error'] === 0) {
                $uploadDir = __DIR__ . '/../../public/uploads/courses/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $fileName = time() . '_' . basename($_FILES['course_file']['name']);
                $targetPath = "{$uploadDir}{$fileName}";
                if (move_uploaded_file($_FILES['course_file']['tmp_name'], $targetPath)) {
                    $data['file_path'] = "public/uploads/courses/{$fileName}";
                }
            }

            // Handle thumbnail upload if new thumbnail is uploaded
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {
                $uploadDir = __DIR__ . '/../../public/uploads/courses/thumbnails/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $fileName = time() . '_' . basename($_FILES['thumbnail']['name']);
                $targetPath = "{$uploadDir}{$fileName}";
                if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetPath)) {
                    $data['thumbnail'] = "public/uploads/courses/thumbnails/{$fileName}";
                }
            }

            $this->model->updateCourse($data);
            header("Location: ?url=adminCourses");
            exit;
        } else {
            require_once 'app/views/admin/update_course.php';
        }
    }
}
