<?php
include('database.php');

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$sql = 'SELECT * FROM about WHERE id = :id';

$stmt_about = $pdo->prepare($sql);
$params = ['id' => $id];
$stmt_about->execute($params);

$post = $stmt_about->fetch();

$isPutRequest = ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_method'] ?? '') === 'put');

if ($isPutRequest) {
    $about = htmlspecialchars($_POST['about_me'] ?? '');

    $sql = 'UPDATE about SET about_me = :about_me WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $params = [
        'about_me' => $about,
        'id' => $id
    ];
    $stmt->execute($params);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        a {
            text-decoration: none;
        }
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
        .input-wrapper {
            display: flex;
            flex-direction: column;
        }
        .form-btn-wrapper {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<h2>Edit Your Profile</h2>

<form method="POST">
    <input type="hidden" name="_method" value="put">
    <input type="hidden" name="id" value="<?= $post['id']?>">

    <div class="input-wrapper">
        <label for="name">About Me:</label>
        <textarea name="about_me"><?= $post['about_me']?></textarea>
    </div>
    <div class="form-btn-wrapper">
        <button class="btn btn-success" type="submit" name="submit">Save</button>
        <button class="btn btn-danger"><a style="color:white;" href="index.php">Back</a></button>
    </div>

</form>

</body>
</html>
