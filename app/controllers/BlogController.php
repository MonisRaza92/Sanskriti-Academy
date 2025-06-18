<?php
require_once __DIR__ . '/../models/BlogModel.php';

class BlogController {
    private $blogModel;

    public function __construct() {
        $this->blogModel = new BlogModel();
    }

    public function showUploadForm() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?url=home');
            exit;
        }
        require_once __DIR__ . '/../views/admin/admin-blogs.php';
    }

    public function handleUpload() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?url=home');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'slug' => $_POST['slug'],
                'category' => $_POST['category'],
                'tags' => $_POST['tags'],
                'content' => $_POST['content'],
                'meta_title' => $_POST['meta_title'],
                'meta_desc' => $_POST['meta_desc'],
                'status' => $_POST['status']
            ];

            if ($this->blogModel->createBlog($data)) {
                $_SESSION['success_message'] = "Blog uploaded successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to upload blog. Please try again.";
            }
            header('Location: ?url=adminBlogs');
            exit;
        }
    }

    public function showAdminBlogs() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?url=home');
            exit;
        }

        $blogs = $this->blogModel->getAllBlogs();
        require_once __DIR__ . '/../views/admin/admin-blogs.php';
    }

    public function deleteBlog() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            header("Location: ?url=adminBlogs");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            header("Location: ?url=adminBlogs");
            exit;
        }
        
        if (!isset($_POST['blog_id']) || empty($_POST['blog_id'])) {
            echo json_encode(['success' => false, 'message' => 'Blog ID is required']);
            header("Location: ?url=adminBlogs");
            exit;
        }
        
        $blog_id = $_POST['blog_id'];
        
        // First check if blog exists
        $blog = $this->blogModel->getBlogById($blog_id);
        if (!$blog) {
            echo json_encode(['success' => false, 'message' => 'Blog not found']);
            header("Location: ?url=adminBlogs");
            exit;
        }
        
        try {
            if ($this->blogModel->deleteBlog($blog_id)) {
                echo json_encode(['success' => true, 'message' => 'Blog deleted successfully']);
                header("Location: ?url=adminBlogs");
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete blog']);
                header("Location: ?url=adminBlogs");
            }
        } catch (Exception $e) {
            error_log("Error deleting blog: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'An error occurred while deleting the blog']);
            header("Location: ?url=adminBlogs");
        }
        exit;
    }

    public function getLatestBlogs($limit = 3) {
        return $this->blogModel->getPublishedBlogs($limit);
    }

    public function showAllBlogs() {
        $blogs = $this->blogModel->getPublishedBlogs();
        require_once __DIR__ . '/../views/blogs.php';
    }

    public function viewBlog($slug = null) {
        // If no slug provided, try to get it from the URL
        if ($slug === null && isset($_GET['slug'])) {
            $slug = $_GET['slug'];
        }
        
        if (!$slug) {
            header("HTTP/1.0 404 Not Found");
            require_once __DIR__ . '/../views/404.php';
            return;
        }

        $blog = $this->blogModel->getBlogBySlug($slug);
        if ($blog) {
            require_once __DIR__ . '/../views/blog-single.php';
        } else {
            header("HTTP/1.0 404 Not Found");
            require_once __DIR__ . '/../views/404.php';
        }
    }
} 