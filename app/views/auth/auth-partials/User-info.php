<div class="container-fluid user-tabs-background">
     <div class="container">
          <div class="row">
               <div class="user-tabs col-lg-3 py-5">
                    <div class="profile-overview">
                         <div class="profil-img">
                              <img src="<?php echo htmlspecialchars($_SESSION['user']['profile_image'] ?? 'assets/images/Icons/user.webp'); ?>" alt="Profile Image" class="img-fluid">
                         </div>
                         <div class="profile-text">
                              <h3><?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Guest'); ?></h3>
                              <h6><?php echo htmlspecialchars($_SESSION['user']['email'] ?? 'Guest'); ?></h6>

                              <button id="updateProfile">Update Profile</button>
                         </div>
                    </div>
                    <div class="tab-list">
                         <ul>
                              <li id="Favorite" onclick="alert('This feature is coming soon')"><i class="fa-solid fa-heart"></i> Favorite</li>
                              <li id="Downloads" onclick="alert('This feature is coming soon')"><i class="fa-solid fa-file-arrow-down"></i> Downloads</li>
                              <li id="Subscription" onclick="alert('This feature is coming soon')"><i class="fa-solid fa-bell"></i> Subscription</li>
                              <li id="Language" onclick="alert('This feature is coming soon')"><i class="fa-solid fa-globe"></i> Language</li>
                              <li id="change"><i class="fa-solid fa-key"></i> Change Password</li>
                              <li id="delete" style="color: red; cursor:pointer;"><i class="fa-solid fa-trash"></i> Delete Account</li>
                         </ul>
                    </div>
               </div>
               <div class="ps-lg-3 pe-lg-0 col-lg-9 d-none d-lg-block" id="userInfoPage">
                    <div class="user-info-update">
                         <div class="info-update-heading">
                              <h2>Update Details</h2>
                              <button id="closeInfoUpdateForm" class="d-lg-none"><i class="fa-solid fa-xmark"></i></button>
                         </div>
                         <div class="user-content">
                              <form action="?url=updateDetails" method="post" class="container mt-4">
                                   <div class="row g-3">

                                        <div class="col-sm-12 col-lg-6">
                                             <label for="full_name" class="form-label">Full Name</label>
                                             <input type="text" id="full_name" name="name" class="form-control" required value="<?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Guest'); ?>">
                                        </div>

                                        <div class="col-sm-12 col-lg-6">
                                             <label for="email" class="form-label">Email</label>
                                             <input type="email" id="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($_SESSION['user']['email'] ?? 'Guest@example.com'); ?>">
                                        </div>

                                        <div class="col-sm-12 col-lg-6">
                                             <label for="mobile" class="form-label">Mobile Number</label>
                                             <input type="tel" id="mobile" name="number" class="form-control" pattern="[0-9]{10}" required value="<?php echo htmlspecialchars($_SESSION['user']['number'] ?? '1234567890'); ?>">
                                        </div>

                                        <div class="col-sm-12 col-lg-6">
                                             <label for="class" class="form-label">Class</label>
                                             <input type="text" id="class" name="class" class="form-control" required value="<?php echo htmlspecialchars($_SESSION['user']['class'] ?? '00'); ?>">
                                        </div>

                                        <div class="col-sm-12 col-lg-6">
                                             <label for="course" class="form-label">Course</label>
                                             <input type="text" id="course" name="course" class="form-control" required value="<?php echo htmlspecialchars($_SESSION['user']['course'] ?? '....'); ?>">
                                        </div>

                                        <div class="col-sm-12 col-lg-6">
                                             <label for="city" class="form-label">City</label>
                                             <input type="text" id="city" name="city" class="form-control" required value="<?php echo htmlspecialchars($_SESSION['user']['city'] ?? 'New Delhi'); ?>">
                                        </div>

                                        <div class="col-sm-12 col-lg-6">
                                             <label for="dob" class="form-label">Date of Birth</label>
                                             <input type="date" id="dob" name="dob" class="form-control" required value="<?php echo htmlspecialchars($_SESSION['user']['dob'] ?? 'dd/mm/yyyy'); ?>">
                                        </div>

                                        <div class="col-12">
                                             <button type="submit">Submit</button>
                                        </div>
                                   </div>
                              </form>
                         </div>
                    </div>