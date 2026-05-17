<?php
// Include the database connection
include('database.php');

// Get the portfolio project ID from the URL (GET parameter)
$id = $_GET['id'] ?? null;

// Redirect if no project ID is provided
if (!$id) {
    header('Location: index.php'); // Redirect to the main portfolio page
    exit;
}

// Fetch the project details from the database
$sql = 'SELECT * FROM portinfo WHERE id = :id';
$stmt = $pdo->prepare($sql);
$params = ['id' => $id];
$stmt->execute($params);

// Fetch the project data
$post = $stmt->fetch();

// Handle the form submission to update the portfolio
$isPutRequest = ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_method'] ?? '') === 'put');

if ($isPutRequest) {
    // Get the updated project details from the form
    $project_name = htmlspecialchars($_POST['project_name'] ?? '');
    $description = htmlspecialchars($_POST['description'] ?? '');
    $image = $_FILES['image']['name'] ?? $post['image']; // Keep the old image if no new image is uploaded

    // Handle file upload if a new image is selected
    if ($_FILES['image']['name']) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_folder = 'uploads/';
        $image_path = $image_folder . basename($image);
        move_uploaded_file($image_tmp, $image_path);
    }

    // Update the portfolio project in the database
    $sql = 'UPDATE portinfo SET project_name = :project_name, description = :description, image = :image WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $params = [
        'project_name' => $project_name,
        'description' => $description,
        'image' => $image,
        'id' => $id
    ];
    $stmt->execute($params);

    // Redirect to the portfolio page after updating
    header('Location: index.php');
    exit;
}

// Handle deletion of the project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    // Delete the image file from the uploads folder
    $image_path = 'uploads/' . $post['image'];
    if (file_exists($image_path)) {
        unlink($image_path); // Delete the image file
    }

    // Delete the project from the database
    $sql = 'DELETE FROM portinfo WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    // Redirect to the main portfolio page after deletion
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Portfolio</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #181818;
            color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            color: #f0f0f0;
            margin-top: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #242424;
            border: 1px solid #444;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #f0f0f0;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #555;
            border-radius: 4px;
            background-color: #333;
            color: #f0f0f0;
        }
        textarea {
            resize: vertical;
        }
        input[type="file"] {
            margin-top: 10px;
        }
        button {
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .edit-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50; /* Green background */
            color: white;
            text-align: center;
            text-decoration: none; /* Remove underline */
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .edit-btn:hover {
            background-color: #45a049; /* Darker green when hovering */
        }

        .back-btn {
            background-color: #444;
            margin-top: 10px;
            font-size: 16px;
        }
        .back-btn:hover {
            background-color: #555;
        }

        .delete-btn-wrapper {
            text-align: right;  /* Align the button to the right */
            margin-top: 10px;   /* Add space above the button */
        }

        .delete-btn {
            background-color: red;
            color: white;
            font-size: 16px;
            padding: 12px 25px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
        }

        .delete-btn a {
            color: white; /* Ensure the link text inside the button is white */
            text-decoration: none; /* Remove underline */
        }

    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<h2>Edit Portfolio</h2>

<form method="POST" enctype="multipart/form-data">
    <!-- Hidden input to simulate PUT request -->
    <input type="hidden" name="_method" value="put">
    <input type="hidden" name="id" value="<?= $post['id']?>">

    <div class="input-wrapper">
        <label for="project_name">Project Name:</label>
        <input type="text" name="project_name" value="<?= $post['project_name']?>" required>
    </div>

    <div class="input-wrapper">
        <label for="description">Project Description:</label>
        <textarea name="description" rows="4" required><?= $post['description']?></textarea>
    </div>

    <div class="input-wrapper">
        <label for="image">Project Image:</label>
        <input type="file" name="image" accept="image/*">
        <p>Current Image: <img src="uploads/<?= $post['image']?>" alt="Project Image" class="img-thumbnail" style="width: 100px;"></p>
    </div>

    <div class="form-btn-wrapper">
        <button class="btn btn-success" type="submit">Save Changes</button>
        <button class="btn btn-info"><a style="color:white;" href="index.php">Back</a></button>
    </div>
</form>

<!-- Delete Project Form -->
<div class="delete-btn-wrapper">
<form method="POST" onsubmit="return confirm('Are you sure you want to delete this project?');">
    <input type="hidden" name="id" value="<?= $post['id']?>">
    <button type="submit" name="delete" class="delete-btn">Delete Project</button>
</form>

</body>
</html>