<?php

require_once __DIR__ . '/../../core/database.php';

class AuthModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->connect(); // PDO Connection
    }

    // Login user using email & password
    public function loginUser($email, $password)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    // Register user
    public function registerUser($data)
    {
        $query = "INSERT INTO users (fname, lname, email, phone, dob, city, course, class, password)
                  VALUES (:fname, :lname, :email, :phone, :dob, :city, :course, :class, :password)";
        $stmt = $this->conn->prepare($query);

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bindParam(":fname", $data['fname']);
        $stmt->bindParam(":lname", $data['lname']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":phone", $data['phone']);
        $stmt->bindParam(":dob", $data['dob']);
        $stmt->bindParam(":city", $data['city']);
        $stmt->bindParam(":course", $data['course']);
        $stmt->bindParam(":class", $data['class']);
        $stmt->bindParam(":password", $hashedPassword);

        return $stmt->execute();
    }
    public function generateOTP()
    {
        return rand(100000, 999999);
    }

    // Real Fast2SMS Integration
    public function sendSms($number, $otp)
    {
        $apiKey = 'YOUR_FAST2SMS_API_KEY'; // ✅ Apni real API key yahan lagao
        $template_id = 'YOUR_TEMPLATE_ID'; // ✅ Fast2SMS me approved template ID
        $url = "https://www.fast2sms.com/dev/bulkV2";

        $fields = array(
            "variables_values" => $otp,
            "route" => "otp",
            "numbers" => $number,
            "sender_id" => "YOUR_SENDER_ID", // Optional but recommended
            "message" => $template_id
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => array(
                "authorization: $apiKey",
                "accept: */*",
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }


    // Find user by email
    public function findByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function findByNumber($number)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE number = :number");
        $stmt->bindParam(":number", $number);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update password
    public function updatePassword($email, $newHashedPassword)
    {
        $stmt = $this->conn->prepare("UPDATE users SET password = :password WHERE email = :email");
        $stmt->bindParam(":password", $newHashedPassword);
        $stmt->bindParam(":email", $email);
        return $stmt->execute();
    }
    // Update user details (excluding password)
    public function updateDetails($email, $data)
    {
        $query = "UPDATE users SET fname = :fname, lname = :lname, phone = :phone, dob = :dob, city = :city, course = :course, class = :class WHERE email = :email";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":fname", $data['fname']);
        $stmt->bindParam(":lname", $data['lname']);
        $stmt->bindParam(":phone", $data['phone']);
        $stmt->bindParam(":dob", $data['dob']);
        $stmt->bindParam(":city", $data['city']);
        $stmt->bindParam(":course", $data['course']);
        $stmt->bindParam(":class", $data['class']);
        $stmt->bindParam(":email", $email);

        return $stmt->execute();
    }
    public function deleteAccount($email)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        return $stmt->execute();
    }

    public function getAllUsers()
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE role != 'admin' ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUserById($user_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
    public function updateUser($id, $data)
    {
        $query = "UPDATE users SET fname = :fname, lname = :lname, email = :email, phone = :phone, dob = :dob, city = :city, course = :course, class = :class WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":fname", $data['fname']);
        $stmt->bindParam(":lname", $data['lname']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":phone", $data['phone']);
        $stmt->bindParam(":dob", $data['dob']);
        $stmt->bindParam(":city", $data['city']);
        $stmt->bindParam(":course", $data['course']);
        $stmt->bindParam(":class", $data['class']);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
    public function changeRole($id, $role)
    {
        $stmt = $this->conn->prepare("UPDATE users SET role = :role WHERE id = :id");
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
    public function getUserRole($id)
    {
        $stmt = $this->conn->prepare("SELECT role FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function getUserByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
