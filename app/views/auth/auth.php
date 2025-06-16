<?php
if (isset($_SESSION['user_id'])) {
  header("Location: ?url=");
  exit;
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include __DIR__ . '/../partials/header-links.php'; ?>
  <title></title>
</head>

<body>
  <?php include __DIR__ . '/../partials/navbar.php' ?>
  <div class="container-fluid mt-5">
    <div class="container">
      <div class="auth-container">
        <div class="tabs">
          <button onclick="showForm('login')" class=" active">Login</button>
          <button onclick="showForm('signup')" class="">Signup</button>
        </div>
        <form id="loginForm" method="POST" action="?url=loginSubmit" class="auth-form">
          <h2>LOGIN NOW</h2>
          <p>Connect with Sanskriti Academy</p>
          <input type="email" name="email" placeholder="Email" required>
          <input type="password" name="password" placeholder="Password" required>
          <p>Forget Password <a href="#" onclick="forgotPassword()">Click here!</a></p>
          <div id="errorMsg" class="py-2"></div>
          <button id="submitBtn" type="submit" >Login</button>
      </form>



      <form id="signupForm" method="POST" action="?url=signupSubmit" class="auth-form hidden">
        <input type="text" name="fname" placeholder="First Name" required>
        <input type="text" name="lname" placeholder="Last Name" required>
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="text" id="number" name="number" placeholder="Phone Number" required>
        <input type="text" name="dob" id="dob" placeholder="Date of Birth (DD/MM/YYYY)" required oninput="formatDOB(this)">
        <input type="text" name="city" placeholder="City">
        <input type="text" name="course" placeholder="Course">
        <input type="text" name="class" placeholder="Class">
        <input type="password" id="password" name="password" placeholder="Password" required>
        <div id="signupError" class="py-2"></div>
        <button id="submitBtn" type="submit">Signup</button>
      </form>
    </div>
  </div>
  </div>
  <script>
     function formatDOB(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length > 2) value = value.slice(0,2) + '/' + value.slice(2);
            if (value.length > 5) value = value.slice(0,5) + '/' + value.slice(5,9);
            input.value = value;
          }
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const form = e.target;
      const formData = new FormData(form);

      fetch('?url=loginSubmit', {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(data => {
          if (data.trim() === "admin") {
            window.location.href = "?url=admin";
          } else if (data.trim() === "success") {
            window.location.href = "?url=";
          } else {
            document.getElementById('errorMsg').innerHTML = data;
          }
        })
        .catch(error => {
          document.getElementById('errorMsg').innerHTML = 'Error: ' + error;
        });
    });
 
    document.getElementById('signupForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const form = e.target;
      const formData = new FormData(form);

      fetch('?url=signupSubmit', {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(data => {
          if (data.trim() === "success") {
            window.location.href = "?url=";
          } else {
            document.getElementById('signupError').innerHTML = data;
          }
        })
        .catch(error => {
          document.getElementById('signupError').innerHTML = 'Error: ' + error;
        });
    });

    function showForm(formType) {
      const loginForm = document.getElementById('loginForm');
      const signupForm = document.getElementById('signupForm');
      const loginBtn = document.querySelector('.tabs button:nth-child(1)');
      const signupBtn = document.querySelector('.tabs button:nth-child(2)');

      if (formType === 'login') {
        loginForm.classList.remove('hidden');
        signupForm.classList.add('hidden');
        loginBtn.classList.add('active');
        signupBtn.classList.remove('active');
      } else {
        signupForm.classList.remove('hidden');
        loginForm.classList.add('hidden');
        signupBtn.classList.add('active');
        loginBtn.classList.remove('active');
      }
    }

    function forgotPassword() {
      alert("Please contact support for password recovery.");
      return false; // Prevent default link behavior
    }
  </script>

  <?php include __DIR__ . '/../partials/footer-links.php'; ?>
</body>

</html>