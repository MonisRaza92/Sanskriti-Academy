<?php
require_once __DIR__ . '/../../core/database.php';

class TestModel
{

    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->connect();
    }
    public function getTestsByClass($class)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tests WHERE class=?");
        $stmt->execute([$class]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllTests()
    {
        $stmt = $this->conn->query("SELECT * FROM tests ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllLiveTests()
    {
        $stmt = $this->conn->query("SELECT * FROM tests WHERE status='Live' ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllCompletedTest()
    {
        $stmt = $this->conn->query("SELECT * FROM tests WHERE status='Completed' ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllClasses()
    {
        $stmt = $this->conn->prepare("SELECT DISTINCT class FROM tests");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTestNameById($test_id)
    {
        $stmt = $this->conn->prepare("SELECT test_name FROM tests WHERE id = ?");
        $stmt->execute([$test_id]);
        return $stmt->fetchColumn();
    }
    public function getTestNameByClass($class)
    {
        $stmt = $this->conn->prepare("SELECT DISTINCT test_name FROM tests WHERE class = ?");
        $stmt->execute([$class]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getSubjectsByTestName($class, $test_name)
    {
        $stmt = $this->conn->prepare("SELECT DISTINCT subject FROM tests WHERE class = ? AND test_name = ?");
        $stmt->execute([$class, $test_name]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getSubjectAndChapterByTestId($test_id)
    {
        $stmt = $this->conn->prepare("SELECT subject, chapter FROM tests WHERE id = ?");
        $stmt->execute([$test_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getChapterBySubjectAndTestName($class, $subject, $test_name)
    {
        $stmt = $this->conn->prepare("SELECT chapter FROM tests WHERE class = ? AND subject = ? AND test_name = ?");
        $stmt->execute([$class, $subject, $test_name]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTestIdByClassTestNameSubjectAndChapter($class, $test_name, $subject, $chapter)
    {
        $stmt = $this->conn->prepare("SELECT id FROM tests WHERE class = ? AND test_name = ? AND subject = ? AND chapter = ?");
        $stmt->execute([$class, $test_name, $subject, $chapter]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getQuestionByChapterSubjectTestNameAndClass($user_id, $test_id, $class, $subject, $chapter)
    {
        if (is_array($chapter)) {
            $chapter = implode(',', $chapter); // Now it's string
        }
        $stmt = $this->conn->prepare("
            SELECT q.* 
            FROM questions q
            JOIN tests t ON q.test_id = t.id
            WHERE t.class = ? AND t.subject = ? AND t.chapter = ?
                AND q.id NOT IN (
                    SELECT question_id FROM student_answers 
                    WHERE user_id = ? AND test_id = ?
                )
            ORDER BY q.id ASC
            LIMIT 1
        ");
        $stmt->execute([$class, $subject, $chapter, $user_id, $test_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getNextQuestion($user_id, $test_id, $class, $subject, $chapter)
    {
        $stmt = $this->conn->prepare("
            SELECT q.* 
            FROM questions q
            JOIN tests t ON q.test_id = t.id
            WHERE t.class = ? AND t.subject = ? AND t.chapter = ?
              AND q.id NOT IN (
                  SELECT question_id FROM student_answers 
                  WHERE user_id = ? AND test_id = ?
              )
            ORDER BY q.id ASC
            LIMIT 1
        ");
        $stmt->execute([$class, $subject, $chapter, $user_id, $test_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllQuestions($test_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM questions WHERE test_id=?");
        $stmt->execute([$test_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuestion($test_id, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM questions WHERE test_id=? LIMIT 1 OFFSET ?");
        $stmt->execute([$test_id, $offset]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getAllQuestionsByTestId($test_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM questions WHERE test_id=?");
        $stmt->execute([$test_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getQuestionByQuestionId($question_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM questions WHERE id=?");
        $stmt->execute([$question_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAnswer($user_id, $test_id, $question_id)
    {
        $stmt = $this->conn->prepare("SELECT selected_option FROM student_answers WHERE user_id=? AND test_id=? AND question_id=?");
        $stmt->execute([$user_id, $test_id, $question_id]);
        return $stmt->fetchColumn();
    }
        public function getStudentAnswers($user_id, $test_id)
        {
            $stmt = $this->conn->prepare("SELECT sa.*, q.question_text 
            FROM student_answers sa
            JOIN questions q ON sa.question_id = q.id
            WHERE sa.user_id = ? AND sa.test_id = ?
            ");
            $stmt->execute([$user_id, $test_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    public function insertAnswer($user_id, $test_id, $question_id, $selected_option, $is_correct)
    {
        $stmt = $this->conn->prepare("SELECT id FROM student_answers WHERE user_id=? AND test_id=? AND question_id=?");
        $stmt->execute([$user_id, $test_id, $question_id]);

        if ($stmt->fetchColumn()) {
            // Already answered — no update
            return false;
        } else {
            // Insert new answer
            $stmt = $this->conn->prepare("INSERT INTO student_answers (user_id, test_id, question_id, selected_option, is_correct) VALUES (?,?,?,?,?)");
            return $stmt->execute([$user_id, $test_id, $question_id, $selected_option, $is_correct]);
        }
    }
    public function getResult($user_id, $test_id)
    {
        $stmt = $this->conn->prepare("SELECT SUM(is_correct) AS total_correct, COUNT(*) AS total_questions FROM student_answers WHERE user_id = ? AND test_id = ?");
        $stmt->execute([$user_id, $test_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getResultsByTestId($test_id)
    {
        $stmt = $this->conn->prepare("SELECT sa.user_id, u.name, sa.test_id, SUM(sa.is_correct) AS total_correct, COUNT(*) AS total_questions
                                      FROM student_answers sa
                                      JOIN users u ON sa.user_id = u.id
                                      WHERE sa.test_id = ?
                                      GROUP BY sa.user_id");
        $stmt->execute([$test_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertTest($class, $subject, $test_name, $chapter)
    {
        $stmt = $this->conn->prepare("INSERT INTO tests (class, subject, test_name, chapter) VALUES (?,?,?,?)");
        return $stmt->execute([$class, $subject, $test_name, $chapter]);
    }
    public function updateTestStatus($test_id, $status)
    {
        $stmt = $this->conn->prepare("UPDATE tests SET status=? WHERE id=?");
        return $stmt->execute([$status, $test_id]);
    }
    public function updateTest($test_id, $class, $test_name, $chapter)
    {
        $stmt = $this->conn->prepare("UPDATE tests SET class=?, test_name=?, chapter=? WHERE id=?");
        return $stmt->execute([$class, $test_name, $chapter, $test_id]);
    }
    public function insertQuestion($test_id, $question_text, $options, $correct_option, $answer)
    {
        $stmt = $this->conn->prepare("INSERT INTO questions (test_id, question_text, option1, option2, option3, option4, correct_option, answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute(array_merge([$test_id, $question_text], $options, [$correct_option], [$answer]));
    }
    public function deleteQuestion($question_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM questions WHERE id = ?");
        return $stmt->execute([$question_id]);
    }

    public function getQuestionById($question_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM questions WHERE id = ?");
        $stmt->execute([$question_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateQuestion($question_id, $question_text, $option1, $option2, $option3, $option4, $correct_option)
    {
        $stmt = $this->conn->prepare("UPDATE questions SET question_text=?, option1=?, option2=?, option3=?, option4=?, correct_option=? WHERE id=?");
        return $stmt->execute([$question_text, $option1, $option2, $option3, $option4, $correct_option, $question_id]);
    }
}
