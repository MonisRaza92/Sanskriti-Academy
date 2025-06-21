<?php

require_once __DIR__ . '/../models/AuthModel.php';
require_once __DIR__ . '/../models/CoursesModel.php';
require_once __DIR__ . '/../models/BlogModel.php';
require_once __DIR__ . '/../models/TestModel.php';

class AuthController
{
     public function showLoginForm()
     {
          include __DIR__ . '/../views/auth/auth.php';
     }

     public function showSignupForm()
     {
          include __DIR__ . '/../views/auth/auth.php';
     }

     public function handleLogin()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $identifier = $_POST['email']; // can be email or number
               $password = $_POST['password'];

               include_once __DIR__ . '/../../core/database.php';
               $db = new Database();
               $conn = $db->conn;

               $query = "SELECT * FROM users WHERE email = :identifier OR number = :identifier LIMIT 1";
               $stmt = $conn->prepare($query);
               $stmt->bindParam(":identifier", $identifier);
               $stmt->execute();
               $user = $stmt->fetch(PDO::FETCH_ASSOC);

               if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['fname'] = $user['name'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['user'] = $user;

                    if ($user['role'] == 'admin') {
                         echo "admin";
                         exit;
                    } else {
                         echo "success";
                         exit;
                    }
               } else {
                    echo "Invalid username or password";
               }
          } else {
               echo "Invalid request method.";
          }
     }

     public function handleSignup()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $firstName = $_POST['fname'];
               $lastName = $_POST['lname'];
               $name = $firstName . ' ' . $lastName;

               $email = $_POST['email'];
               $number = isset($_POST['number']) ? $_POST['number'] : '';
               $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
               $city = $_POST['city'];
               $class = $_POST['class'];
               $course = $_POST['course'];
               $dob = $_POST['dob'];
               $role = 'user';


               // ---------------- OTP CHECK START --------------------

               $userOtp = isset($_POST['otp']) ? $_POST['otp'] : '';
               $sessionOtp = isset($_SESSION['signup_otp']) ? $_SESSION['signup_otp'] : '';
               $sessionNumber = isset($_SESSION['signup_number']) ? $_SESSION['signup_number'] : '';

               if ($userOtp != $sessionOtp) {
                    echo "Invalid OTP!";
                    return;
               }

               if ($number != $sessionNumber) {
                    echo "Phone number mismatch!";
                    return;
               }
               // ---------------- OTP CHECK END --------------------

               if (empty($number)) {
                    echo "Please provide a phone number.";
                    return;
               }

               $date = DateTime::createFromFormat('d/m/Y', $dob);
               if ($date) {
                    $dob = $date->format('Y-m-d');
               } else {
                    echo "Invalid date format. Please use DD/MM/YYYY.";
                    return;
               }

               include_once __DIR__ . '/../../core/database.php';
               $db = new Database();
               $conn = $db->conn;

               $check = $conn->prepare("SELECT * FROM users WHERE email = :email");
               $check->bindParam(':email', $email);
               $check->execute();

               if ($check->rowCount() > 0) {
                    echo "Email already registered.";
                    return;
               }

               $query = "INSERT INTO users (name, email, number, password, city, class, course, dob, role)
                  VALUES (:name, :email, :number, :password, :city, :class, :course, :dob, :role)";

               $stmt = $conn->prepare($query);
               $stmt->bindParam(':name', $name);
               $stmt->bindParam(':email', $email);
               $stmt->bindParam(':number', $number);
               $stmt->bindParam(':password', $password);
               $stmt->bindParam(':city', $city);
               $stmt->bindParam(':class', $class);
               $stmt->bindParam(':course', $course);
               $stmt->bindParam(':dob', $dob);
               $stmt->bindParam(':role', $role);

               if ($stmt->execute()) {
                    $userId = $conn->lastInsertId();

                    // 🔐 Auto login after signup
                    $fetchUser = $conn->prepare("SELECT * FROM users WHERE id = :id");
                    $fetchUser->bindParam(":id", $userId);
                    $fetchUser->execute();
                    $user = $fetchUser->fetch(PDO::FETCH_ASSOC);

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['fname'] = $firstName;
                    $_SESSION['lname'] = $lastName;
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['user'] = $user;

                    echo "success";
                    exit();
               } else {
                    echo "Something went wrong. Try again later.";
               }
          } else {
               echo "Invalid request method.";
          }
     }
     public function sendOtp()
     {
          $number = $_POST['number'] ?? '';

          if (strlen($number) != 10) {
               echo "Invalid Number";
               return;
          }

          $authModel = new AuthModel();
          $otp = $authModel->generateOTP();

          $_SESSION['signup_otp'] = $otp;
          $_SESSION['signup_number'] = $number;

          $message = "Welcome to Sunskriti Academy, Your OTP for signup is $otp. Do not share it with anyone.";

          $smsResponse = $authModel->sendSms($number, $message);

          // Debugging SMS API Response
          error_log("SMS Response: " . $smsResponse);

          echo "success";
     }
     public function updateDetails()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
               include_once __DIR__ . '/../../core/database.php';
               $db = new Database();
               $conn = $db->conn;

               $id = $_SESSION['user_id'];
               $name = $_POST['name'] ?? '';
               $email = $_POST['email'] ?? '';
               $number = $_POST['number'] ?? '';
               $city = $_POST['city'] ?? '';
               $class = $_POST['class'] ?? '';
               $course = $_POST['course'] ?? '';

               $query = "UPDATE users SET name = :name, email = :email, number = :number, city = :city, class = :class, course = :course WHERE id = :id";
               $stmt = $conn->prepare($query);
               $stmt->bindParam(':name', $name);
               $stmt->bindParam(':email', $email);
               $stmt->bindParam(':number', $number);
               $stmt->bindParam(':city', $city);
               $stmt->bindParam(':class', $class);
               $stmt->bindParam(':course', $course);
               $stmt->bindParam(':id', $id);

               if ($stmt->execute()) {
                    // Refresh session user
                    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['user'] = $user;

                    echo "<script>alert('details_updated');window.location.href='?url=account';</script>";
               } else {
                    echo "<script>alert('update_failed');window.location.href='?url=account';</script>";
               }
          } else {
               echo "<script>alert('unauthorized');window.location.href='?url=account';</script>";
          }
     }

     
     public function deleteAccount()
     {
          if (isset($_SESSION['user_id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
               $password = $_POST['password'] ?? '';

               include_once __DIR__ . '/../../core/database.php';
               $db = new Database();
               $conn = $db->conn;

               $email = $_SESSION['user']['email'];
               // Fetch user to verify password
               $query = "SELECT password FROM users WHERE email = :email";
               $stmt = $conn->prepare($query);
               $stmt->bindParam(':email', $email);
               $stmt->execute();
               $user = $stmt->fetch(PDO::FETCH_ASSOC);

               if ($user && password_verify($password, $user['password'])) {
                    // Delete account
                    $delQuery = "DELETE FROM users WHERE email = :email";
                    $delStmt = $conn->prepare($delQuery);
                    $delStmt->bindParam(':email', $email);

                    if ($delStmt->execute()) {
                         session_unset();
                         session_destroy();
                         echo "account_deleted";
                    } else {
                         echo "delete_failed";
                    }
               } else {
                    echo "invalid_password";
               }
          } else {
               echo "unauthorized";
          }
     }

     public function adminDashboard()
     {
          $userModel = new AuthModel();
          $users = $userModel->getAllUsers();
          $totalUsers = count($users);
          $blogsModel = new BlogModel();
          $blogs = $blogsModel->getAllBlogs();
          $totalBlogs = count($blogs);

          $courseModel = new CourseModel();
          $courses = $courseModel->getAllCourses();
          $totalCourses = count($courses);
          $categories = ['Programming', 'Design', 'Marketing', 'Business', 'Science'];

          $testModel = new TestModel();
          $tests = $testModel->getAllTests();
          $totalTests = count($tests);


          // Single view file me sab pass karo
          require __DIR__ . '/../views/admin/index.php';
          exit;
     }

     public function accountdetails()
     {
          include __DIR__ . '/../views/auth/account.php';
          exit;
     }

     public function logoutUser()
     {
          session_unset();
          session_destroy();
          header("Location: ?url=");
          exit;
     }

     public function deleteUser()
     {
          if (isset($_POST['id'])) {
               $id = $_POST['id'];
               $model = new AuthModel();
               if ($model->deleteUser($id)) {
                    echo "User deleted successfully.";
                    header("Location: ?url=adminUsers");
               } else {
                    echo "Failed to delete user.";
                    header("Location: ?url=adminUsers");
               }
          } else {
               echo "Invalid request.";
               header("Location: ?url=adminUsers");
          }
     }
     public function updateUser()
     {
          if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
               $id = $_POST['id'];
               $data = [
                    'fname' => $_POST['fname'],
                    'lname' => $_POST['lname'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'dob' => $_POST['dob'],
                    'city' => $_POST['city'],
                    'course' => $_POST['course'],
                    'class' => $_POST['class']
               ];

               $model = new AuthModel();
               if ($model->updateUser($id, $data)) {
                    echo "User updated successfully.";
               } else {
                    echo "Failed to update user.";
               }
          } else {
               echo "Invalid request.";
          }
     }
}
