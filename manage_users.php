<?php
include './includes/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session only if it has not been started yet
}

// Check if the user is logged in and is an instructor
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'instructor') {
    header("Location: index.php");
    exit;
}

// Handle user deletion
if (isset($_GET['delete'])) {
    $userId = (int)$_GET['delete'];
    $deleteSql = "DELETE FROM users WHERE user_id = $userId";
    if (mysqli_query($conn, $deleteSql)) {
        header("Location: manage_users.php");
        exit;
    } else {
        echo "<p class='text-danger'>Error deleting user: " . mysqli_error($conn) . "</p>";
    }
}

// Handle user role update
if (isset($_POST['update_role'])) {
    $userId = (int)$_POST['user_id'];
    $newRole = mysqli_real_escape_string($conn, $_POST['user_role']);
    
    $updateRoleSql = "UPDATE users SET user_role = '$newRole' WHERE user_id = $userId";
    if (mysqli_query($conn, $updateRoleSql)) {
        header("Location: manage_users.php");
        exit;
    } else {
        echo "<p class='text-danger'>Error updating user role: " . mysqli_error($conn) . "</p>";
    }
}

// Query to fetch all users
$sql = "SELECT * FROM users ORDER BY user_id DESC";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "<p class='text-danger'>Error fetching users: " . mysqli_error($conn) . "</p>";
    exit;
}
?>

<?php include './includes/header.php'; ?>

<h2>Manage Users</h2>
<table class="table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['user_email']); // Make sure this matches your database column name ?></td>
            <td>
                <form method="POST" action="" class="form-inline">
                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                    <select name="user_role" class="form-control" onchange="this.form.submit()">
                        <option value="student" <?php echo $row['user_role'] === 'student' ? 'selected' : ''; ?>>Student</option>
                        <option value="instructor" <?php echo $row['user_role'] === 'instructor' ? 'selected' : ''; ?>>Instructor</option>
                    </select>
                    <button type="submit" name="update_role" class="btn btn-primary btn-sm ml-2">Update</button>
                </form>
            </td>
            <td>
                <a href="?delete=<?php echo $row['user_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include './includes/footer.php'; ?>