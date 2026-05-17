<?php
include('database.php');

$id = $_GET['id'] ?? null;

if (!$id){
    header('Location: index.php');
    exit;
}

$sql ='SELECT * FROM info WHERE id = :id';

$stmt = $pdo->prepare($sql);

$params = ['id'=>$id];

$stmt->execute($params);

$post = $stmt->fetch();

$isPutRequest = ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_method'] ?? '') === 'put');

if($isPutRequest){
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $contact_num = htmlspecialchars($_POST['contact_num'] ?? '');
    $address = htmlspecialchars($_POST['address'] ?? '');
    $fb_link = htmlspecialchars($_POST['fb_link'] ?? '');
    $linkedin_link = htmlspecialchars($_POST['linkedin_link'] ?? '');
    $ig_link = htmlspecialchars($_POST['ig_link'] ?? '');

    $sql = 'UPDATE info SET name = :name,email = :email,contact_num = :contact_num,address = :address,fb_link = :fb_link,linkedin_link = :linkedin_link,ig_link = :ig_link WHERE id = :id';

    $stmt = $pdo->prepare($sql);

    $params =[ 
        'name' => $name,
        'email' => $email,
        'contact_num' => $contact_num,
        'address' => $address,
        'fb_link' => $fb_link,
        'linkedin_link' => $linkedin_link,
        'ig_link' => $ig_link,
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
        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #555;
            border-radius: 4px;
            background-color: #333;
            color: #f0f0f0;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus {
            outline: none;
            border-color: #007bff;
            background-color: #444;
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
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?= $post['name']?>">
    </div>

    <div class="input-wrapper">
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= $post['email']?>">
    </div>

    <div class="input-wrapper">
        <label for="contact">Contact Number:</label>
        <input type="tel" name="contact_num" value="<?= $post['contact_num']?>">
    </div>

    <div class="input-wrapper">
        <label for="address">Address:</label>
        <input type="text" name="address" value="<?= $post['address']?>">
    </div>

    <div class="input-wrapper">
        <label for="facebook">Facebook Link:</label>
        <input type="text" name="fb_link" value="<?= $post['fb_link']?>">
    </div>

    <div class="input-wrapper">
        <label for="linkedin">LinkedIn Link:</label>
        <input type="text" name="linkedin_link" value="<?= $post['linkedin_link']?>">
    </div>

    <div class="input-wrapper">
        <label for="instagram">Instagram Link:</label>
        <input type="text" name="ig_link" value="<?= $post['ig_link']?>">
    </div>

    <div class="form-btn-wrapper">
        <button class="btn btn-success" type="submit" name="submit">Save</button>
        <button class="btn btn-danger"><a style="color:white;" href="index.php">Back</a></button>
    </div>
</form>

</body>
</html>
