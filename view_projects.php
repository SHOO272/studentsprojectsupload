<?php
include './includes/db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Get the logged-in user's ID
$userId = $_SESSION['user_id'];

// Handle project approval
if (isset($_GET['approve'])) {
    $projectId = (int)$_GET['approve'];
    $updateSql = "UPDATE projects SET status = 'approved' WHERE project_id = $projectId";
    
    if (mysqli_query($conn, $updateSql)) {
        // Get user ID for notification
        $userSql = "SELECT user_id FROM projects WHERE project_id = $projectId";
        $userResult = mysqli_query($conn, $userSql);
        
        if ($userRow = mysqli_fetch_assoc($userResult)) {
            // Insert notification
            $message = "Your project has been approved.";
            $notificationSql = "INSERT INTO notifications (user_id, project_id, message) VALUES ('" . $userRow['user_id'] . "', '$projectId', '$message')";
            mysqli_query($conn, $notificationSql);
        }
        
        header("Location: manage_projects.php");
        exit;
    } else {
        echo "<p class='text-danger'>Error approving project: " . mysqli_error($conn) . "</p>";
    }
}

// Handle project rejection
if (isset($_GET['reject'])) {
    $projectId = (int)$_GET['reject'];
    $updateSql = "UPDATE projects SET status = 'rejected' WHERE project_id = $projectId";
    
    if (mysqli_query($conn, $updateSql)) {
        // Get user ID for notification
        $userSql = "SELECT user_id FROM projects WHERE project_id = $projectId";
        $userResult = mysqli_query($conn, $userSql);
        
        if ($userRow = mysqli_fetch_assoc($userResult)) {
            // Insert notification
            $message = "Your project has been rejected.";
            $notificationSql = "INSERT INTO notifications (user_id, project_id, message) VALUES ('" . $userRow['user_id'] . "', '$projectId', '$message')";
            mysqli_query($conn, $notificationSql);
        }
        
        header("Location: manage_projects.php");
        exit;
    } else {
        echo "<p class='text-danger'>Error rejecting project: " . mysqli_error($conn) . "</p>";
    }
}

// Query to fetch projects submitted by the user
$sql = "SELECT p.project_id, p.project_title, p.project_file, p.upload_date, p.project_description 
        FROM projects p 
        WHERE p.user_id = '$userId' 
        ORDER BY p.upload_date DESC";

$result = mysqli_query($conn, $sql);
?>

<?php include './includes/header.php'; ?>

<h2>Your Submitted Projects</h2>

<?php if (mysqli_num_rows($result) > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Project Title</th>
                <th>Upload Date</th>
                <th>File</th>
                <th>Description</th> <!-- Added Description column -->
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['project_title']); ?></td>
                <td><?php echo htmlspecialchars($row['upload_date']); ?></td>
                <td>
                    <a href="uploads/<?php echo htmlspecialchars($row['project_file']); ?>" class="btn btn-info" target="_blank">View File</a>
                </td>
                <td><?php echo htmlspecialchars($row['project_description']); ?></td> <!-- Display project description -->
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>You have not submitted any projects yet.</p>
<?php endif; ?>

<?php include './includes/footer.php'; ?>