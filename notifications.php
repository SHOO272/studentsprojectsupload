<?php
include './includes/db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Mark notification as read
if (isset($_GET['mark_read'])) {
    $notificationId = (int)$_GET['mark_read'];
    $updateSql = "UPDATE notifications SET is_read = 1 WHERE notification_id = $notificationId AND user_id = $userId";
    mysqli_query($conn, $updateSql);
    header("Location: notifications.php");
    exit;
}

// Query to fetch user notifications
$notificationsSql = "SELECT * FROM notifications WHERE user_id = $userId ORDER BY created_at DESC";
$notificationsResult = mysqli_query($conn, $notificationsSql);
?>

<?php include './includes/header.php'; ?>

<h2>Your Notifications</h2>
<table class="table">
    <thead>
        <tr>
            <th>Message</th>
            <th>Received At</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($notificationRow = mysqli_fetch_assoc($notificationsResult)): ?>
        <tr>
            <td><?php echo htmlspecialchars($notificationRow['message']); ?></td>
            <td><?php echo htmlspecialchars($notificationRow['created_at']); ?></td>
            <td><?php echo $notificationRow['is_read'] ? 'Read' : 'Unread'; ?></td>
            <td>
                <?php if (!$notificationRow['is_read']): ?>
                    <a href="?mark_read=<?php echo $notificationRow['notification_id']; ?>" class="btn btn-primary btn-sm">Mark as Read</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include './includes/footer.php'; ?>