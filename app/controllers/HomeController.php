<?php
require_once __DIR__ . '/../models/CoursesModel.php';
require_once __DIR__ . '/../models/EventModel.php';

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
        $eventModel = new EventModel();
        $courses = $coursesModel->getAllCourses();
        $events = $eventModel->getAllEvents();

        $this->view('index', ['courses' => $courses , 'events' => $events]);
    }
    public function tests()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?url=login");
            exit();
        }
        $testModel = new TestModel();
        $classes = $testModel->getAllClasses();


        include_once __DIR__ . '/../views/test/select-class.php';
    }
    public function selectTest()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?url=login");
            exit();
        }

        $class = $_GET['class'] ?? null;
        if (!$class) {
            echo "<p>Please select a class first.</p>";
            return;
        }

        $testModel = new TestModel();
        $tests = $testModel->getTestNameByClass($class);
        if (empty($tests)) {
            echo "<p>No tests available for this class.</p>";
            return;
        }
        require_once __DIR__ . '/../views/test/select-testname.php';
    }
    public function showSubjectSelect() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?url=login");
            exit();
        }
        $class = $_GET['class'] ?? null;
        $test_name = $_GET['test_name'] ?? null;
        if (!$class || !$test_name) {
            echo "<p>Please select a class and test first.</p>";
            return;
        }
        $testModel = new TestModel();
        $subjects = $testModel->getSubjectsByTestName($class, $test_name);
        if (empty($subjects)) {
            echo "<p>No subjects available for this class and test.</p>";
            return;
        }
        require_once __DIR__ . '/../views/test/select-subject.php';
    }
    public function showChapterSelect() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?url=login");
            exit();
        }
        $class = $_GET['class'] ?? null;
        $subject = $_GET['subject'] ?? null;
        $test_name = $_GET['test_name'] ?? null;
        if (!$class || !$subject || !$test_name) {
            echo "<p>Please select a class, subject, and test first.</p>";
            return;
        }
        $testModel = new TestModel();
        $chapters = $testModel->getChapterBySubjectAndTestName($class, $subject, $test_name);
        if (!$chapters) {
            echo "<p>No chapter available for this class, subject, and test.</p>";
            return;
        }
        require_once __DIR__ . '/../views/test/select-chapter.php';
    }
    public function startTest()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?url=login");
            exit();
        }

        // USE SESSION INSTEAD OF GET
        if (!isset($_SESSION['class']) || !isset($_SESSION['subject'])) {
            $_SESSION['class'] = $_GET['class'];
            $_SESSION['subject'] = $_GET['subject'];
            $_SESSION['test_name'] = $_GET['test_name'];
            $_SESSION['chapter'] = $_GET['chapter'];
        }

        $user_id = $_SESSION['user_id'];
        $class = $_SESSION['class'];
        $subject = $_SESSION['subject'];
        $test_name = $_SESSION['test_name'];
        $chapter = $_SESSION['chapter'];
        
        
        if (!$class || !$subject || !$test_name || !$chapter) {
            echo "<p>Please select a class, subject, test, and chapter first.</p>";
            return;
        }


        $testModel = new TestModel();
        $test_idRow = $testModel->getTestIdByClassTestNameSubjectAndChapter($class, $test_name, $subject, $chapter);
        $test_id = $test_idRow['id'] ?? 0;

        if (!$test_id) {
            echo "<p>Test not found for the selected class and subject.</p>";
            return;
        }

        $question = $testModel->getQuestionByChapterSubjectTestNameAndClass($user_id, $test_id, $class, $subject, $chapter);

        if ($question) {
            $data['question'] = $question;
            $data['test_id'] = $test_id;
            require_once __DIR__ . '/../views/test/start-test.php';
        } else {
            $result = $testModel->getResult($user_id, $test_id);
            $data['result'] = $result;
            require_once __DIR__ . '/../views/test/result.php';
        }
    }





    public function courses()
    {
        $coursesModel = new CourseModel();
        $courses = $coursesModel->getAllCourses();

        $this->view('courses', ['courses' => $courses]);
        exit();
    }
    public function privacyPolicy()
    {
        $this->view('privacy-policy');
    }
    public function termsAndConditions()
    {
        $this->view('term-and-conditions');
    }
}
