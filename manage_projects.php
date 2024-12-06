<?php
include './includes/db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session only if it has not been started yet
}

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'instructor') {
    header("Location: index.php");
    exit;
}

// Handle project deletions
if (isset($_GET['delete'])) {
    $projectId = (int)$_GET['delete'];
    $deleteSql = "DELETE FROM projects WHERE project_id = $projectId";
    if (mysqli_query($conn, $deleteSql)) {
        header("Location: manage_projects.php");
        exit;
    } else {
        echo "<p class='text-danger'>Error deleting project: " . mysqli_error($conn) . "</p>";
    }
}

// Handle project approval
if (isset($_GET['approve'])) {
    $projectId = (int)$_GET['approve'];
    $updateSql = "UPDATE projects SET status = 'approved' WHERE project_id = $projectId";
    if (mysqli_query($conn, $updateSql)) {
        $userSql = "SELECT user_id FROM projects WHERE project_id = $projectId";
        $userResult = mysqli_query($conn, $userSql);
        $userRow = mysqli_fetch_assoc($userResult);
        
        $message = "Your project has been approved.";
        $notificationSql = "INSERT INTO notifications (user_id, message) VALUES ('" . $userRow['user_id'] . "', '$message')";
        mysqli_query($conn, $notificationSql);
    }
    header("Location: manage_projects.php");
    exit;
}

// Handle project rejection
if (isset($_GET['reject'])) {
    $projectId = (int)$_GET['reject'];
    $updateSql = "UPDATE projects SET status = 'rejected' WHERE project_id = $projectId";
    if (mysqli_query($conn, $updateSql)) {
        $userSql = "SELECT user_id FROM projects WHERE project_id = $projectId";
        $userResult = mysqli_query($conn, $userSql);
        $userRow = mysqli_fetch_assoc($userResult);
        
        $message = "Your project has been rejected.";
        $notificationSql = "INSERT INTO notifications (user_id, message) VALUES ('" . $userRow['user_id'] . "', '$message')";
        mysqli_query($conn, $notificationSql);
    }
    header("Location: manage_projects.php");
    exit;
}

// Handle adding comments
if (isset($_POST['add_comment'])) {
    $projectId = (int)$_POST['project_id'];
    $commentAuthor = mysqli_real_escape_string($conn, $_POST['comment_author']);
    $commentEmail = mysqli_real_escape_string($conn, $_POST['comment_email']);
    $commentContent = mysqli_real_escape_string($conn, $_POST['comment_content']);

    $commentSql = "INSERT INTO comments (project_id, comment_author, comment_email, comment_content) VALUES ('$projectId', '$commentAuthor', '$commentEmail', '$commentContent')";
    if (mysqli_query($conn, $commentSql)) {
        header("Location: manage_projects.php");
        exit;
    } else {
        echo "<p class='text-danger'>Error adding comment: " . mysqli_error($conn) . "</p>";
    }
}

// Handle comment editing
if (isset($_POST['edit_comment'])) {
    $commentId = (int)$_POST['comment_id'];
    $commentContent = mysqli_real_escape_string($conn, $_POST['comment_content']);
    
    $updateCommentSql = "UPDATE comments SET comment_content = '$commentContent' WHERE comment_id = $commentId";
    if (mysqli_query($conn, $updateCommentSql)) {
        header("Location: manage_projects.php");
        exit;
    } else {
        echo "<p class='text-danger'>Error updating comment: " . mysqli_error($conn) . "</p>";
    }
}

// Handle comment deletion
if (isset($_GET['delete_comment'])) {
    $commentId = (int)$_GET['delete_comment'];
    $deleteCommentSql = "DELETE FROM comments WHERE comment_id = $commentId";
    if (mysqli_query($conn, $deleteCommentSql)) {
        header("Location: manage_projects.php");
        exit;
    } else {
        echo "<p class='text-danger'>Error deleting comment: " . mysqli_error($conn) . "</p>";
    }
}

// Handle comment approval/rejection
if (isset($_GET['comment_action']) && isset($_GET['comment_id'])) {
    $commentId = (int)$_GET['comment_id'];
    $action = $_GET['comment_action']; // 'approve' or 'reject'
    
    $commentUserSql = "SELECT user_id FROM comments WHERE comment_id = $commentId";
    $commentUserResult = mysqli_query($conn, $commentUserSql);
    $commentUserRow = mysqli_fetch_assoc($commentUserResult);
    $userId = $commentUserRow['user_id'];

    if ($action === 'approve') {
        $updateCommentSql = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $commentId";
        $message = "Your comment has been approved.";
    } elseif ($action === 'reject') {
        $updateCommentSql = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $commentId";
        $message = "Your comment has been rejected.";
    }
    
    if (mysqli_query($conn, $updateCommentSql)) {
        $notificationSql = "INSERT INTO notifications (user_id, message) VALUES ('$userId', '$message')";
        mysqli_query($conn, $notificationSql);
        
        header("Location: manage_projects.php");
        exit;
    } else {
        echo "<p class='text-danger'>Error updating comment status: " . mysqli_error($conn) . "</p>";
    }
}

// Query to fetch all projects
$sql = "SELECT p.project_id, p.project_title, p.project_file, p.upload_date, u.username, p.status 
        FROM projects p 
        JOIN users u ON p.user_id = u.user_id 
        ORDER BY p.upload_date DESC";
$result = mysqli_query($conn, $sql);
?>

<?php include './includes/header.php'; ?>

<h2>Manage Projects</h2>
<table class="table">
    <thead>
        <tr>
            <th>Project Title</th>
            <th>Submitted By</th>
            <th>Upload Date</th>
            <th>Status</th>
            <th>File</th>
            <th>Actions</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['project_title']); ?></td>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['upload_date']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td>
                <a href="uploads/<?php echo htmlspecialchars($row['project_file']); ?>" class="btn btn-info" target="_blank">View File</a>
            </td>
            <td>
                <?php if ($row['status'] === 'pending'): ?>
                    <a href="?approve=<?php echo $row['project_id']; ?>" class="btn btn-success">Approve</a>
                    <a href="?reject=<?php echo $row['project_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this project?');">Reject</a>
                <?php else: ?>
                    <span class="badge <?php echo $row['status'] === 'approved' ? 'bg-success' : 'bg-danger'; ?>">
                        <?php echo ucfirst($row['status']); ?>
                    </span>
                <?php endif; ?>
                <a href="?delete=<?php echo $row['project_id']; ?>" class="btn btn-warning" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
            </td>
            <td>
                <button class="btn btn-secondary" data-toggle="collapse" data-target="#comments-<?php echo $row['project_id']; ?>">View Comments</button>
                <div id="comments-<?php echo $row['project_id']; ?>" class="collapse">
                    <ul class="list-group">
                        <?php
                        $commentsSql = "SELECT c.comment_id, c.comment_author, c.comment_content, c.comment_date, c.comment_status 
                                        FROM comments c 
                                        WHERE c.project_id = " . $row['project_id'] . " 
                                        ORDER BY c.comment_date DESC";
                        $commentsResult = mysqli_query($conn, $commentsSql);
                        while ($commentRow = mysqli_fetch_assoc($commentsResult)): ?>
                            <li class="list-group-item">
                                <strong><?php echo htmlspecialchars($commentRow['comment_author']); ?></strong>: 
                                <?php echo htmlspecialchars($commentRow['comment_content']); ?> 
                                <small class="text-muted"><?php echo htmlspecialchars($commentRow['comment_date']); ?></small>
                                <span class="badge <?php echo $commentRow['comment_status'] === 'approved' ? 'bg-success' : 'bg-danger'; ?>">
                                    <?php echo ucfirst($commentRow['comment_status']); ?>
                                </span>
                                <?php if ($commentRow['comment_status'] === 'unapproved'): ?>
                                    <a href="?comment_action=approve&comment_id=<?php echo $commentRow['comment_id']; ?>" class="btn btn-success btn-sm">Approve</a>
                                    <a href="?comment_action=reject&comment_id=<?php echo $commentRow['comment_id']; ?>" class="btn btn-danger btn-sm">Reject</a>
                                <?php endif; ?>
                                <a href="?delete_comment=<?php echo $commentRow['comment_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this comment?');">Delete</a>
                                
                                <button class="btn btn-warning btn-sm" data-toggle="collapse" data-target="#edit-comment-<?php echo $commentRow['comment_id']; ?>">Edit</button>
                                <div id="edit-comment-<?php echo $commentRow['comment_id']; ?>" class="collapse">
                                    <form method="POST" action="">
                                        <input type="hidden" name="comment_id" value="<?php echo $commentRow['comment_id']; ?>">
                                        <textarea name="comment_content" class="form-control mt-2" required><?php echo htmlspecialchars($commentRow['comment_content']); ?></textarea>
                                        <button type="submit" name="edit_comment" class="btn btn-primary mt-2">Update Comment</button>
                                    </form>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>

                    <form method="POST" action=""> 
                        <input type="hidden" name="project_id" value="<?php echo $row['project_id']; ?>">
                        <div class="form-group mt-2">  
                            <input type="text" name="comment_author" class="form-control" value="<?php echo $row['username']; ?>" >
                            <input type="hidden" name="comment_email" class="form-control mt-2" value="<?php echo $row['user_email']; ?>" >
                            <textarea name="comment_content" class="form-control mt-2" placeholder="Add a comment..." required></textarea>
                        </div>
                        <button type="submit" name="add_comment" class="btn btn-primary mt-2">Submit Comment</button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include './includes/footer.php'; ?>