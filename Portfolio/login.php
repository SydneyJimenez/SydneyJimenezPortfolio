<?php 
session_start();
include('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check for admin login
    if ($email === 'admin@gmail.com' && $password === '123') {
        $_SESSION['admin'] = true;
        $_SESSION['user'] = 'Admin';
        echo "<script>alert('Welcome Admin!'); window.location.href='admin.php';</script>";
        exit;
    }

    // Check for regular user login
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->conn->prepare($query);
    $params = ['email' => $email];

    $stmt->execute($params);
    $user = $stmt->fetch();

    if ($user) {
        if ($password === $user['password']) {
            $_SESSION['user'] = $user['username'];
            header("Location: index.php"); // Redirect to portfolio page
            exit;
        } else { 
            echo "<script>alert('Invalid username or password!');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="styles2.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <div class="wrapper">
        <form action="">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" placeholder="username">
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password">
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn">Log in</button>
        </form>
    </div>
    
</body>
</html>


