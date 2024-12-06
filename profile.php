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

$userId = $_SESSION['user_id'];

// Fetch user details
$userSql = "SELECT * FROM users WHERE user_id = $userId";
$userResult = mysqli_query($conn, $userSql);
$user = mysqli_fetch_assoc($userResult);

// Handle profile update
if (isset($_POST['update_profile'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    $updateSql = "UPDATE users SET username = '$username', email = '$email' WHERE user_id = $userId";
    if (mysqli_query($conn, $updateSql)) {
        header("Location: profile.php?success=Profile updated successfully.");
        exit;
    } else {
        echo "<p class='text-danger'>Error updating profile: " . mysqli_error($conn) . "</p>";
    }
}

// Handle password change
if (isset($_POST['change_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Fetch current password hash from database
    $passwordSql = "SELECT password FROM users WHERE user_id = $userId";
    $passwordResult = mysqli_query($conn, $passwordSql);
    $passwordRow = mysqli_fetch_assoc($passwordResult);

    // Verify current password
    if (password_verify($currentPassword, $passwordRow['password'])) {
        if ($newPassword === $confirmPassword) {
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePasswordSql = "UPDATE users SET password = '$newPasswordHash' WHERE user_id = $userId";
            if (mysqli_query($conn, $updatePasswordSql)) {
                header("Location: profile.php?success=Password changed successfully.");
                exit;
            } else {
                echo "<p class='text-danger'>Error changing password: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p class='text-danger'>New passwords do not match.</p>";
        }
    } else {
        echo "<p class='text-danger'>Current password is incorrect.</p>";
    }
}

?>

<?php include './includes/header.php'; ?>

<h2>User Profile</h2>

<!-- Profile Update Form -->
<form method="POST" action="">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    </div>
    <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
</form>

<!-- Password Change Form -->
<h3>Change Password</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="current_password">Current Password</label>
        <input type="password" name="current_password" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="new_password">New Password</label>
        <input type="password" name="new_password" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="confirm_password">Confirm New Password</label>
        <input type="password" name="confirm_password" class="form-control" required>
    </div>
    <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
</form>

<?php
if (isset($_GET['success'])) {
    echo "<p class='text-success'>" . htmlspecialchars($_GET['success']) . "</p>";
}
?>

<?php include './includes/footer.php'; ?>