<?php
require_once __DIR__ . '/../models/TestModel.php';
require_once __DIR__ . '/../models/AuthModel.php';

class TestController
{
    private $model;
    private $authModel;

    public function __construct()
    {
        $this->model = new TestModel;
        $this->authModel = new AuthModel();
    }
    public function addTest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $class = $_POST['class'];
            $subject = $_POST['subject'];
            $test_name = $_POST['test_name'];
            $chapter = $_POST['chapter'];

            if ($this->model->insertTest($class, $subject, $test_name , $chapter)) {
                header("Location: adminTests");
            } else {
                $error = "Failed to create test. Please try again.";
            }
        }
    }
    public function updateTestStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $test_id = $_POST['test_id'];
            $status = $_POST['status'];

            if ($this->model->updateTestStatus($test_id, $status)) {
                header("Location: adminTests");
            } else {
                $error = "Failed to delete test. Please try again.";
            }
        }
    }
    public function updateTest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $test_id = $_POST['test_id'];
            $class = $_POST['class'];
            $test_name = $_POST['test_name'];
            $chapter = $_POST['chapter'];

            if ($this->model->updateTest($test_id, $class, $test_name, $chapter)) {
                header("Location: adminTests");
            } else {
                $error = "Failed to update test. Please try again.";
            }
        }
    }
    public function addQuestion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $test_id = $_POST['test_id'];
            $question_text = $_POST['question_text'];
            $options = [
                $_POST['option1'],
                $_POST['option2'],
                $_POST['option3'],
                $_POST['option4']
            ];
            $correct_option = $_POST['correct_option'];
            $answer = $_POST['answer'] ?? null;

            if ($this->model->insertQuestion($test_id, $question_text, $options, $correct_option, $answer)) {
                header("Location: adminTests&test_id=" . $test_id);
            } else {
                $error = "Failed to add question. Please try again.";
            }
        }
    }
    public function deleteQuestion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $question_id = $_POST['question_id'];

            if ($this->model->deleteQuestion($question_id)) {
                header("Location: adminTests");
            } else {
                $error = "Failed to delete question. Please try again.";
            }
        }
    }
    public function updateQuestion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['question_id'];
            $question_text = $_POST['question_text'];
            $option1 = $_POST['option1'];
            $option2 = $_POST['option2'];
            $option3 = $_POST['option3'];
            $option4 = $_POST['option4'];
            $correct_option = $_POST['correct_option'];
            $test_id = $_POST['test_id'];

            $testModel = new TestModel();
            $testModel->updateQuestion($id, $question_text, $option1, $option2, $option3, $option4, $correct_option);

            if ($testModel->updateQuestion($id, $question_text, $option1, $option2, $option3, $option4, $correct_option)) {
                header("Location: adminTests&test_id=" . $test_id);
            } else {
                echo "Error updating question.";
            }
        }

        require_once __DIR__ . '/../views/admin/edit-question.php';
    }
    public function submitAnswer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user_id = $_SESSION['user_id'];
            $test_id = $_POST['test_id'] ?? 0;
            $question_id = $_POST['question_id'] ?? 0;
            $selected_option = $_POST['option'] ?? null;
            $chapter = $_SESSION['chapter'] ?? null;
            $class = $_SESSION['class'] ?? null;
            $subject = $_SESSION['subject'] ?? null;
            $test_name = $_SESSION['test_name'] ?? null;

            // Validate test_id and question_id
            if (empty($test_id) || $test_id == 0 || !is_numeric($test_id)) {
                die("Error: Invalid test ID.");
            }

            if (empty($question_id) || $question_id == 0 || !is_numeric($question_id)) {
                die("Error: Invalid question ID.");
            }

            if ($selected_option === null) {
                die("Error: No option selected.");
            }

            // Get question & check correct option
            $questionModel = new TestModel();
            $question = $questionModel->getQuestionById($question_id);

            if (!$question) {
                die("Error: Question not found.");
            }

            $correct_option = $question['correct_option'];

            $is_correct = ($selected_option == $correct_option) ? 1 : 0;

            // Check if answer already given
            $answerModel = new TestModel();
            $existingAnswer = $answerModel->getAnswer($user_id, $test_id, $question_id);

            if (!$existingAnswer) {
                // Insert only if not answered before
                $answerModel->insertAnswer($user_id, $test_id, $question_id, $selected_option, $is_correct);
            }

            // Get next question
            $nextQuestion = $questionModel->getNextQuestion($user_id, $test_id, $class, $subject, $chapter ?? null);

            if ($nextQuestion) {
                // Next question available — show next
                header('Location: startTest?class=' . $class . '&subject=' . $subject . '&chapter=' . $chapter . '&test_name=' . $test_name . '&question_id=' . $nextQuestion['id'] . '&test_id=' . $test_id);
                exit;
            } else {
                // All done — show result
                header('Location: result&test_id=' . $test_id);
                exit;
            }
        }
    }

    public function result()
    {
        $user_id = $_SESSION['user_id'];
        $test_id = $_GET['test_id'];

        $authModel = new AuthModel();
        $user = $authModel->getUserById($user_id);
        
        $model = new TestModel();
        $result = $model->getResult($user_id, $test_id);

        include_once __DIR__ . '/../views/test/result.php';
    }
}
