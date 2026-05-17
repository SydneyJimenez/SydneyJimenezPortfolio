<?php
// Include the database connection
include('database.php');

// Fetch all certificates from the database
$sql = "SELECT * FROM certificates ORDER BY id DESC";
$stmt = $pdo->query($sql);
$certificates = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificates</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #2c3e50;
            color: #fff;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            text-decoration: none;
            color: #fff;
            background-color: #3498db;
            border-radius: 5px;
        }
        .btn-warning {
            background-color: #f39c12;
        }
        .certificates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .certificate-card {
            background-color: #34495e;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
        }
        .certificate-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .certificate-card h3 {
            margin: 10px 0;
            color: #9b59b6;
            font-size: 1.2rem;
        }
        .certificate-card p {
            color: #ecf0f1;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Certificates</h1>

        <!-- Add Certificate Button -->
        <a href="add_certificate.php" class="btn">Add Certificate</a>

        <!-- Certificates Grid -->
        <div class="certificates-grid">
            <?php if (count($certificates) > 0): ?>
                <?php foreach ($certificates as $certificate): ?>
                    <div class="certificate-card">
                        <!-- Placeholder Image for Certificate -->
                        <img src="images/placeholder.png" alt="Certificate Image">

                        <!-- Certificate Name -->
                        <h3><?= htmlspecialchars($certificate['name']) ?></h3>

                        <!-- Certificate Description -->
                        <p><?= htmlspecialchars($certificate['description']) ?></p>

                        <!-- Edit Button -->
                        <a href="edit_certificate.php?id=<?= $certificate['id'] ?>" class="btn btn-warning">Edit</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No certificates found.</p>
            <?php endif; ?>
        </div>

        <a href="index.php" class="btn">Back to Home</a>
    </div>
</body>
</html>
