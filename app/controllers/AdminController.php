<?php
include_once __DIR__ . '/../models/AuthModel.php';
include_once __DIR__ . '/../models/CoursesModel.php';
include_once __DIR__ . '/../models/BlogModel.php';
include_once __DIR__ . '/../models/TestModel.php';
include_once __DIR__ . '/../models/EventModel.php';

class AdminController
{
    public function adminUsers()
    {
        $model = new AuthModel();
        $users = $model->getAllUsers();
        $totalUsers = count($users);
        include_once __DIR__ . '/../views/admin/admin-users.php';
    }

    public function adminCourses()
    {
        $coursesModel = new CourseModel();
        $courses = $coursesModel->getAllCourses();
        $totalCourses = count($courses);
        $categories = ['Programming', 'Design', 'Marketing', 'Business', 'Science'];
        require_once __DIR__ . '/../views/admin/admin-courses.php';
    }


    public function adminTests()
    {

        $testModel = new TestModel();
        $tests = $testModel->getAllLiveTests();
        $totalTests = count($tests);

        $test_id = isset($_GET['test_id']) ? $_GET['test_id'] : null;
        $questions = [];

        if ($test_id !== null) {
            $questions = $testModel->getAllQuestions($test_id);
        }
        
        require_once __DIR__ . '/../views/admin/admin-tests.php';
    }

    public function adminResults()
    {
        $testModel = new TestModel();
        $completedTests = $testModel->getAllCompletedTest();
        $totalCompletedTests = count($completedTests);
        require_once __DIR__ . '/../views/admin/admin-results.php';
    }
    public function adminEvents()
    {
        $eventModel = new EventModel();
        $events = $eventModel->getAllEvents();
        require_once __DIR__ . '/../views/admin/admin-events.php';
    }
    public function addEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['event_name'];
            $link = $_POST['event_link'];

            // Image upload
            $imagePath = '';
            if (!empty($_FILES['event_image']['name'])) {
                $imagePath = 'uploads/events/' . basename($_FILES['event_image']['name']);
                move_uploaded_file($_FILES['event_image']['tmp_name'], __DIR__ . '/../../public/' . $imagePath);
            }

            $eventModel = new EventModel();
            $eventModel->insertEvent($name, $link, $imagePath);

            header("Location: ?url=adminEvents");
            exit;
        }

        require_once __DIR__ . '/../views/event/add-event.php';
    }

    public function updateEvent()
    {
        $eventModel = new EventModel();
        $id = $_GET['id'];
        $data['event'] = $eventModel->getEventById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['event_name'];
            $link = $_POST['event_link'];

            // Image upload (if new image selected)
            $imagePath = $data['event']['event_image'];
            if (!empty($_FILES['event_image']['name'])) {
                $imagePath = 'uploads/events/' . basename($_FILES['event_image']['name']);
                move_uploaded_file($_FILES['event_image']['tmp_name'], __DIR__ . '/../../public/' . $imagePath);
            }

            $eventModel->updateEvent($id, $name, $link, $imagePath);

            header("Location: ?url=adminEvents");
            exit;
        }

        require_once __DIR__ . '/../views/event/edit-event.php';
    }

    public function deleteEvent()
    {
        $id = $_GET['id'];
        $eventModel = new EventModel();
        $eventModel->deleteEvent($id);

        header("Location: ?url=adminEvents");
        exit;
    }
}
