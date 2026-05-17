<?php
// Include the database connection
include('database.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the project details from the form
    $project_name = htmlspecialchars($_POST['project_name'] ?? '');
    $description = htmlspecialchars($_POST['description'] ?? '');
    $image = $_FILES['image']['name'] ?? ''; // Get image name

    // Handle file upload if an image is selected
    if ($image) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_folder = 'uploads/';
        $image_path = $image_folder . uniqid() . '_' . basename($image);
        $image_path = $image_folder . basename($image);
        move_uploaded_file($image_tmp, $image_path);

    }

    // Insert the new project into the database
    $sql = 'INSERT INTO portinfo (project_name, description, image) VALUES (:project_name, :description, :image)';
    $stmt = $pdo->prepare($sql);
    $params = [
        'project_name' => $project_name,
        'description' => $description,
        'image' => $image
    ];
    $stmt->execute($params);

    // Redirect to the portfolio page after adding the new project
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Project</title>
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
        .back-btn {
            background-color: #444;
            margin-top: 10px;
            font-size: 16px;
        }
        .back-btn:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<h2>Add New Project</h2>

<form method="POST" enctype="multipart/form-data">
    <div class="input-wrapper">
        <label for="project_name">Project Name:</label>
        <input type="text" name="project_name" required>
    </div>

    <div class="input-wrapper">
        <label for="description">Project Description:</label>
        <textarea name="description" rows="4" required></textarea>
    </div>

    <div class="input-wrapper">
        <label for="image">Project Image:</label>
        <input type="file" name="image" accept="image/*" required>
    </div>

    <div class="form-btn-wrapper">
        <button class="btn btn-success" type="submit">Add Project</button>
        <button class="btn btn-danger"><a style="color:white;" href="index.php">Back</a></button>
    </div>
</form>

</body>
</html>