<?php
if (!isset($_SESSION['user'])) {
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
  <title>Account</title>
</head>

<body>
  <?php include __DIR__ . '/../partials/navbar.php' ?>
  <div class="d-lg-none">
    <?php include __DIR__ . '/../admin/admin-partials/admin-sidebar.php'; ?>
  </div>
  <?php include __DIR__ . '/auth-partials/User-info.php' ?>




  <?php include __DIR__ . '/../partials/footer-links.php'; ?>
  <script>
    const profileMenu = document.querySelectorAll(".tab-list ul li");

    profileMenu.forEach(button => {
      button.addEventListener("click", () => {
        profileMenu.forEach(btn => btn.classList.remove('active-li'));
        button.classList.add('active-li');
      });
    });

    document.addEventListener("DOMContentLoaded", function() {
      const updateBtn = document.getElementById('updateProfile');
      const userInfoPage = document.getElementById('userInfoPage');
      const closeBtnUpdateInfo = document.getElementById('closeInfoUpdateForm');

      updateBtn.addEventListener('click', function() {
        userInfoPage.classList.remove('d-none');
      });
      closeBtnUpdateInfo.addEventListener('click', function() {
        userInfoPage.classList.add('d-none');
      });
    });

    document.getElementById('delete').onclick = function() {
      if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
        let password = prompt('Please enter your password to confirm:');
        if (password !== null && password !== '') {
          fetch('?url=deleteAccount', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: 'password=' + encodeURIComponent(password)
            })
            .then(response => response.text())
            .then(result => {
              if (result.trim() === 'account_deleted') {
                alert('Your account has been deleted.');
                window.location.href = '?url=login';
              } else if (result.trim() === 'invalid_password') {
                alert('Invalid password. Account not deleted.');
              } else if (result.trim() === 'delete_failed') {
                alert('Failed to delete account. Please try again.');
              } else {
                alert('Unauthorized or unknown error.');
              }
            });
        }
      }
    };

    document.getElementById('change').onclick = function() {
      let current = prompt("Enter your current password:");
      if (!current) return;
      let newPass = prompt("Enter your new password:");
      if (!newPass) return;
      let confirm = prompt("Confirm your new password:");
      if (!confirm) return;

      let formData = new FormData();
      formData.append('current_password', current);
      formData.append('new_password', newPass);
      formData.append('confirm_password', confirm);

      fetch('?url=changePassword', {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(result => {
          if (result === 'password_changed') {
            alert('Password changed successfully!');
          } else if (result === 'password_mismatch') {
            alert('New passwords do not match.');
          } else if (result === 'invalid_current_password') {
            alert('Current password is incorrect.');
          } else if (result === 'change_failed') {
            alert('Failed to change password. Try again.');
          } else {
            alert('Unauthorized or unknown error.');
          }
          window.location.href = '?url=account';
        })
        .catch(() => {
          alert('An error occurred.');
          window.location.href = '?url=account';
        });
    };
  </script>
  
</body>

</html>