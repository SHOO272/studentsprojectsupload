<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session only if it has not been started yet
}
?><?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome Icons -->
    <title><?php echo isset($title) ? $title : 'Student Projects Portal'; ?></title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">Student Projects Portal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="upload.php"><i class="fas fa-upload"></i> Upload Project</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_projects.php"><i class="fas fa-eye"></i> View Projects</a>
                </li>
                <?php if (isset($_SESSION['user_role'])): ?>
                    <?php if ($_SESSION['user_role'] === 'instructor'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="instructorDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i> Instructor Actions
                            </a>
                            <div class="dropdown-menu" aria-labelledby="instructorDropdown">
                                <a class="dropdown-item" href="manage_projects.php">Manage Projects</a>
                                <a class="dropdown-item" href="manage_users.php">Manage Users</a>
                            </div>
                        </li>

                        <li class="nav-item">
                        <a class="dropdown-item" href="manage_projects.php">  <i class="fas fa-book"></i>  Manage Projects</a>
                        </li>   <li class="nav-item">
                        <a class="dropdown-item" href="manage_users.php">  <i class="fas fa-book"></i>  Manage Users</a>
                        </li>
                    <?php elseif ($_SESSION['user_role'] === 'student'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php"><i class="fas fa-book"></i> Student Resources</a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- JavaScript includes for Bootstrap functionality -->

 <div class="container mt-4">
<!--    <div class="row">
        <div class="col-lg-8"> -->
            <!-- Main content goes here -->
        <!-- </div>
        <div class="col-md-4"> -->
            <!-- Sidebar or additional links can go here -->
        <!-- </div>
    </div>
</div>
 -->
