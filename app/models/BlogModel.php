<?php
require_once __DIR__ . '/../../core/database.php';

class BlogModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->connect();
    }

    public function createBlog($data) {
        try {
            // Handle file upload
            $featured_image = '';
            if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] == 0) {
                $upload_dir = 'uploads/blogs/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $file_extension = pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_extension;
                $target_path = $upload_dir . $file_name;

                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $target_path)) {
                    $featured_image = $target_path;
                }
            }

            $query = "INSERT INTO blogs (title, slug, category, tags, featured_image, content, meta_title, meta_desc, status) 
                     VALUES (:title, :slug, :category, :tags, :featured_image, :content, :meta_title, :meta_desc, :status)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':slug', $data['slug']);
            $stmt->bindParam(':category', $data['category']);
            $stmt->bindParam(':tags', $data['tags']);
            $stmt->bindParam(':featured_image', $featured_image);
            $stmt->bindParam(':content', $data['content']);
            $stmt->bindParam(':meta_title', $data['meta_title']);
            $stmt->bindParam(':meta_desc', $data['meta_desc']);
            $stmt->bindParam(':status', $data['status']);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAllBlogs() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM blogs ORDER BY created_at DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getPublishedBlogs($limit = null) {
        try {
            $query = "SELECT * FROM blogs WHERE status = 'published' ORDER BY created_at DESC";
            if ($limit) {
                $query .= " LIMIT :limit";
            }

            $stmt = $this->conn->prepare($query);
            if ($limit) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getBlogById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM blogs WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getBlogBySlug($slug) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM blogs WHERE slug = :slug AND status = 'published'");
            $stmt->bindParam(':slug', $slug);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteBlog($id) {
        try {
            // First get the blog to delete its image if exists
            $blog = $this->getBlogById($id);
            if ($blog && !empty($blog['featured_image']) && file_exists($blog['featured_image'])) {
                unlink($blog['featured_image']);
            }

            $stmt = $this->conn->prepare("DELETE FROM blogs WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
} 