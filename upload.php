<?php
include './includes/db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_project'])) {
    $userId = $_SESSION['user_id'];
    $projectTitle = mysqli_real_escape_string($conn, $_POST['project_title']);
    $projectDescription = mysqli_real_escape_string($conn, $_POST['project_description']); // New field

    // Set the target directory for uploads
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["project_file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file is a valid type
    if (!in_array($fileType, ['pdf', 'doc', 'docx'])) {
        echo "<p class='text-danger'>Only PDF, DOC, and DOCX files are allowed.</p>";
        $uploadOk = 0;
    }

    // Check file size (e.g., limit to 5MB)
    if ($_FILES["project_file"]["size"] > 5000000) {
        echo "<p class='text-danger'>Sorry, your file is too large.</p>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "<p class='text-danger'>Sorry, file already exists.</p>";
        $uploadOk = 0;
    }

    // Attempt to upload the file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["project_file"]["tmp_name"], $targetFile)) {
            // Insert project details into the database
            $sql = "INSERT INTO projects (user_id, project_title, project_file, project_description, submitted_by) 
                    VALUES ('$userId', '$projectTitle', '" . mysqli_real_escape_string($conn, basename($_FILES["project_file"]["name"])) . "', '$projectDescription', '$userId')";
            if (mysqli_query($conn, $sql)) {
                echo "<p class='text-success'>The file has been uploaded successfully.</p>";
            } else {
                echo "<p class='text-danger'>Error: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p class='text-danger'>Sorry, there was an error uploading your file.</p>";
        }
    }
}
?>

<?php include './includes/header.php'; ?>

<h2>Upload Your Project</h2>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="project_title">Project Title:</label>
        <input type="text" class="form-control" name="project_title" required>
    </div>
    <div class="form-group">
        <label for="project_description">Project Description:</label>
        <textarea class="form-control" name="project_description" required></textarea>
    </div>
    <div class="form-group">
        <label for="project_file">Select file:</label>
        <input type="file" class="form-control" name="project_file" required>
    </div>
    <button type="submit" name="upload_project" class="btn btn-primary">Upload Project</button>
</form>

<?php include './includes/footer.php'; ?>