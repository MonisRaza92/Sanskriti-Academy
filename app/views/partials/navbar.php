<div class="ccontainer-fluid navbar-container">
    <div class="container navbar">

        <div class="img-container">
            <?php if (isset($_SESSION['user']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <button id="adminMenuOpenBtn" class="btn d-lg-none"><i style="font-size: 30px;" class="fa-solid fa-bars"></i></button>
            <?php endif; ?>
            <a href="?url=">
                <img style="height:45px;" src="assets/images/Logos/header-logo.jpg" alt="Brand Logo" />
            </a>
        </div>

        <div class="menu-container">
            <div class="nav-links">
                <?php if (isset($_SESSION['user']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a class="nav-link d-none d-lg-block" href="?url=admin"><i class="fa-solid fa-chart-simple"></i></a>
                <?php else: ?>
                    <a class="nav-link d-none" href="?url=student"><i class="fa-solid fa-chart-line"></i></a>
                <?php endif; ?>
            </div>
            <div class="login-btn">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_GET['url']) && $_GET['url'] === 'account'): ?>
                        <a class="btn" href="?url=logout">
                            Logout <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                    <?php else: ?>
                        <a class="btn me-2 <?php echo empty($courses) ? 'd-none' : ''; ?> <?php if (isset($_GET['url']) && $_GET['url'] === 'courses'): ?>d-none<?php endif; ?>" href="?url=courses">COURSES</a>
                        <a class="btn me-2 <?php if (isset($_GET['url']) && $_GET['url'] === ''): ?>d-none<?php endif; ?>" href="?url=">HOME</a>
                        <a class="btn accountBtn" href="?url=account">
                            <img src="<?php echo htmlspecialchars($_SESSION['user']['profile_image'] ?? 'assets/images/Icons/user.webp'); ?>" alt="Profile Image" class="img-fluid">
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a class="btn" href="?url=login">
                        Login <i class="fa-solid fa-right-to-bracket"></i>
                    </a>
                <?php endif; ?>
            </div>

        </div>

    </div>
</div>
<div class="mobile-menu">
    <div class="userInfoAndLogin">
        <div class="user-info">
            <?php if (isset($_SESSION['user_id'])): ?>
                <img src="<?php echo htmlspecialchars($_SESSION['user']['profile_image'] ?? 'assets/images/Icons/user.webp'); ?>" alt="Profile Image" class="img-fluid">
                <div class="user-info-container">
                    <h2><?php echo htmlspecialchars($_SESSION['user']['name']); ?></h2>
                    <p><?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
                    <a class="btn" href="?url=account">Account</a>
                </div>
            <?php else: ?>
                <div class="if-not-login">
                    <i class="fa-solid fa-user"></i>
                    <div class="not-login-text">
                        <h2>Welcome Guest</h2>
                        <p>Please login account</p>
                        <a class="btn" href="?url=login">Login <i class="fa-solid fa-right-to-bracket"></i></a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
    <div class="mobile-links">
        <?php include __DIR__ . '/classes-card.php'; ?>
    </div>
</div>