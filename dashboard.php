<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session only if it has not been started yet
}

include './includes/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user details
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = $userId";
$userResult = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($userResult);

// Fetch user projects (example query)
$projectsSql = "SELECT * FROM projects WHERE user_id = $userId";
$projectsResult = mysqli_query($conn, $projectsSql);

// Fetch notifications (example query)
$notificationsSql = "SELECT * FROM notifications WHERE user_id = $userId ORDER BY created_at DESC";
$notificationsResult = mysqli_query($conn, $notificationsSql);
?>

<?php include './includes/header.php'; ?>

<h2>Dashboard</h2>

<div class="card mb-4">
    <div class="card-header">
        <h5>User Profile</h5>
    </div>
    <div class="card-body">
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['user_firstname']); ?></p>
        <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['user_lastname']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['user_email']); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($user['user_role']); ?></p>
        <!-- <img src="uploads/<?php echo htmlspecialchars($user['user_image']); ?>" alt="Profile Image" class="img-fluid" style="max-width: 150px;"> -->
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5>Your Projects</h5>
    </div>
    <div class="card-body">
        <?php if (mysqli_num_rows($projectsResult) > 0): ?>
            <ul class="list-group">
                <?php while ($project = mysqli_fetch_assoc($projectsResult)): ?>
                    <li class="list-group-item">
                        <strong><?php echo htmlspecialchars($project['project_title']); ?></strong>
                        <p>Status: <?php echo htmlspecialchars($project['status']); ?></p>
                        <a href="view_project.php?id=<?php echo $project['project_id']; ?>" class="btn btn-info btn-sm">View Project</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>You have no projects assigned.</p>
        <?php endif; ?>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5>Notifications</h5>
    </div>
    <div class="card-body">
        <?php if (mysqli_num_rows($notificationsResult) > 0): ?>
            <ul class="list-group">
                <?php while ($notification = mysqli_fetch_assoc($notificationsResult)): ?>
                    <li class="list-group-item">
                        <?php echo htmlspecialchars($notification['message']); ?>
                        <small class="text-muted"><?php echo htmlspecialchars($notification['created_at']); ?></small>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No new notifications.</p>
        <?php endif; ?>
    </div>
</div>

<?php include './includes/footer.php'; ?>