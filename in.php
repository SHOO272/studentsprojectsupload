<?php
session_start(); // Start the session
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
                    <?php elseif ($_SESSION['user_role'] === 'student'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="student_resources.php"><i class="fas fa-book"></i> Student Resources</a>
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

<div class="container mt-5" style="margin-top: 80px;"> <!-- Space for fixed navbar -->
    <h2>Welcome to the Student Projects Portal</h2>
    <!-- Your main content goes here -->
</div>

<!-- JavaScript includes for Bootstrap functionality -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>