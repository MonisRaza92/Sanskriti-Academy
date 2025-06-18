<?php
require_once __DIR__ . '/../../core/database.php';
class CourseModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->connect();
    }

    public function getAllCourses()
    {
        $stmt = $this->conn->prepare("SELECT * FROM courses ORDER BY upload_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCourse($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO courses (course_name, description, file_path, file_type, price, teacher_name, category, class, thumbnail)
            VALUES (:course_name, :description, :file_path, :file_type, :price, :teacher_name, :category, :class, :thumbnail)");
        return $stmt->execute($data);
    }

    public function deleteCourse($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getCourseById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCourse($data)
    {
        $query = "UPDATE courses SET 
                    course_name = :course_name,
                    description = :description,
                    file_path = :file_path,
                    file_type = :file_type,
                    price = :price,
                    teacher_name = :teacher_name,
                    category = :category,
                    class = :class,
                    thumbnail = :thumbnail
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }
}
