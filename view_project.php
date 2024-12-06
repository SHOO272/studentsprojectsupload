<?php
include './includes/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session only if it has not been started yet
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Check if a project ID is provided
if (isset($_GET['id'])) {
    $projectId = (int)$_GET['id'];

    // Query to fetch the project details
    $sql = "SELECT * FROM projects WHERE project_id = $projectId";
    $result = mysqli_query($conn, $sql);

    if (!$result || mysqli_num_rows($result) === 0) {
        echo "<p class='text-danger'>Project not found.</p>";
        exit;
    }

    $project = mysqli_fetch_assoc($result);
} else {
    echo "<p class='text-danger'>No project ID provided.</p>";
    exit;
}
?>

<?php include './includes/header.php'; ?>

<h2><?php echo htmlspecialchars($project['project_title']); ?></h2>
<p><strong>Description:</strong> <?php echo htmlspecialchars($project['project_description']); ?></p>
<p><strong>Submitted By:</strong> <?php echo htmlspecialchars($project['submitted_by']); ?></p>
<p><strong>Upload Date:</strong> <?php echo htmlspecialchars($project['upload_date']); ?></p>
<p><strong>Status:</strong> <?php echo htmlspecialchars($project['status']); ?></p>
<p><strong>File:</strong> <a href="uploads/<?php echo htmlspecialchars($project['project_file']); ?>" target="_blank">Download</a></p>

<!-- Optionally, add a back button -->
<!-- <a href="manage_projects.php" class="btn btn-secondary">Back to Projects</a> -->
<a href="dashboard.php" class="btn btn-secondary">Back to Projects</a>

<?php include './includes/footer.php'; ?>