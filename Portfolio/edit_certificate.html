<?php
// Include your database connection
include('database.php');

// Get the certificate ID from the URL parameter
$id = $_GET['id'];

// Fetch the certificate details from the database
$stmt = $pdo->prepare('SELECT * FROM certificates WHERE id = :id');
$stmt->execute(['id' => $id]);
$certificate = $stmt->fetch();

// Check if the certificate exists
if (!$certificate) {
    die("Certificate not found.");
}

// Handle form submission for updating the certificate
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $issuer = $_POST['issuer'];
    $issue_date = $_POST['issue_date'];

    // Handling the image upload
    if ($_FILES['image']['name']) {
        $image = $_FILES['image'];

        // Ensure the upload directory exists
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create the directory if it doesn't exist
        }

        // Validate file type (e.g., allow only images)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($image['type'], $allowed_types)) {
            // Sanitize file name to prevent issues with special characters
            $image_path = $upload_dir . basename($image['name']);
            
            // Check if the file was successfully uploaded
            if (move_uploaded_file($image['tmp_name'], $image_path)) {
                // Update the certificate in the database with a new image
                $stmt_update = $pdo->prepare('UPDATE certificates SET title = ?, description = ?, issuer = ?, issue_date = ?, image = ? WHERE id = ?');
                $stmt_update->execute([$title, $description, $issuer, $issue_date, $image_path, $id]);
            } else {
                die("Error uploading the image.");
            }
        } else {
            die("Invalid file type. Only JPEG, PNG, and GIF files are allowed.");
        }
    } else {
        // Update the certificate without changing the image
        $stmt_update = $pdo->prepare('UPDATE certificates SET title = ?, description = ?, issuer = ?, issue_date = ? WHERE id = ?');
        $stmt_update->execute([$title, $description, $issuer, $issue_date, $id]);
    }

    // Redirect back to the certificates page after update
    header('Location: index.php#certificates');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Certificate</title>
</head>
<body>
    <h1>Edit Certificate</h1>
    <form action="edit_certificate.php?id=<?= $certificate['id'] ?>" method="POST" enctype="multipart/form-data">
        <label for="title">Certificate Title:</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($certificate['title']) ?>" required><br><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?= htmlspecialchars($certificate['description']) ?></textarea><br><br>

        <label for="issuer">Issuer:</label>
        <input type="text" name="issuer" id="issuer" value="<?= htmlspecialchars($certificate['issuer']) ?>" required><br><br>

        <label for="issue_date">Issue Date:</label>
        <input type="date" name="issue_date" id="issue_date" value="<?= $certificate['issue_date'] ?>" required><br><br>

        <label for="image">Certificate Image:</label>
        <input type="file" name="image" id="image"><br><br>

        <button type="submit">Update Certificate</button>
    </form>
</body>
</html>
