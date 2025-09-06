<div class="header-advance-area">
    <div class="header-top-area">
        <div class="header-top-wraper">

            <!-- Navigacioni linkovi -->
            <div class="header-top-menu">
                <ul class="mai-top-nav">
                    <li class="nav-item"><a href="select_exam.php" class="nav-link header-link">Select Exam</a></li>
                    <li class="nav-item"><a href="old_exam_result.php" class="nav-link header-link">Last Results</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link header-link">Logout</a></li>
                </ul>
            </div>

            <!-- Avatar desno -->
            <div class="header-right-info">
                <a href="#" data-toggle="dropdown" class="header-link dropdown-toggle">
                    <img src="img/avatar-mini2.jpg" alt="" />
                    <span class="admin-name"><?php echo $_SESSION["username"]; ?></span>
                    <i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
                </a>
                <ul class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                    <li><a href="logout.php"><span class="edu-icon edu-locked author-log-ic"></span>Log Out</a></li>
                </ul>
            </div>

        </div>
    </div>
</div>
