<?php
include('database.php');

$stmt = $pdo->prepare('SELECT * FROM info');
$stmt->execute();
$info = $stmt->fetchAll();

$stmt_about = $pdo->prepare('SELECT * FROM about');
$stmt_about->execute();
$about = $stmt_about->fetchAll();

$stmt = $pdo->prepare('SELECT * FROM portinfo');
$stmt->execute();
$projects = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php foreach ($info as $post): ?>
    <title><?= $post['name']?> | Portfolio</title>
    <?php endforeach; ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top navbar-custom" style="color: white;">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php foreach ($info as $post): ?>
                <a class="navbar-brand text-white" href="#"><?= $post['name']?></a>
                <?php endforeach; ?>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#about" class="text-white">About Me</a></li>
                    <li><a href="#education" class="text-white">Education</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle text-white" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Background <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#portfolio">Portfolio</a></li>
                            <li><a href="#skills">Skills</a></li>
                            <li><a href="#certificates">Certificates</a></li>
                        </ul>
                    </li>
                    <li><a href="#contact" class="text-white">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero text-center">
        <div class="container">
            <h1>Welcome to My Portfolio</h1>
            <h3>Creative Developer, passionate about building amazing user experiences.</h3>
        </div>
    </header>

    <section id="profile" class="container" style="margin-top: 80px;">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="images/lawrence.jpg" alt="Profile Picture" class="img-circle img-responsive">
            </div>
            <div class="col-md-8">
                <?php foreach ($info as $post): ?>
                <h1 class="profile-name"><?= $post['name']?></h1>
                <h4><strong>Contact Number:</strong> <?= $post['contact_num']?></h4>
                <h4><strong>Email:</strong> <?= $post['email']?></h4>
                <h4><strong>Address:</strong> <?= $post['address']?></h4>
                <a href="edit.php?id=<?= $post['id']?>"><button class="btn btn-primary">EDIT</button></a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="about" class="container section">
        <h2>About Me</h2>
        <?php foreach ($about as $post): ?>
        <p><?= $post['about_me']?></p>
        <a href="editAbout.php?id=<?= $post['id']?>"><button class="btn btn-primary">EDIT</button></a>
        <?php endforeach; ?>
    </section>

    <!-- Skills Section (Table Structure) -->
    <section id="skills" class="container section">
        <h2>Skills</h2>
        <table border="0" class="table table-dark">
            <thead>
                <tr>
                    <th><h4>Skill</h4></th>
                    <th><h4>Proficiency Level</h4></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>HTML, CSS, JavaScript</td>
                    <td>Advanced</td>
                </tr>
                <tr>
                    <td>PHP, MySQL</td>
                    <td>Intermediate</td>
                </tr>
                <tr>
                    <td>React, Node.js</td>
                    <td>Intermediate</td>
                </tr>
                <tr>
                    <td>Version Control (Git)</td>
                    <td>Advanced</td>
                </tr>
            </tbody>
        </table>
    </section>

    <!-- Education Section -->
    <section id="education" class="container section">
        <h2>Education</h2>
        <ul>
            <li>BS in Information Technology - University of XYZ (2020 - 2024)</li>
            <li>Web Development Bootcamp - ABC Academy (2023)</li>
        </ul>
    </section>

    <!-- Certificates Section -->
<section id="certificates" class="container section">
    <h2>Certificates</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="thumbnail">
                <img src="images/certificate.png" alt="Certificate 1" class="img-responsive" style="width: 100%; height: auto; border-radius: 8px;">
                <div class="caption text-center">
                    <h4>Web Development Certificate</h4>
                    <p>Certificate in Web Development from ABC Academy, awarded in 2023.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="thumbnail">
                <img src="certificate2.jpg" alt="Certificate 2" class="img-responsive" style="width: 100%; height: auto; border-radius: 8px;">
                <div class="caption text-center">
                    <h4>UI/UX Design Certification</h4>
                    <p>Certified UI/UX Designer from XYZ Institute, awarded in 2022.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="thumbnail">
                <img src="certificate3.jpg" alt="Certificate 3" class="img-responsive" style="width: 100%; height: auto; border-radius: 8px;">
                <div class="caption text-center">
                    <h4>Advanced JavaScript Certification</h4>
                    <p>Advanced JavaScript Certification from Tech Academy, awarded in 2023.</p>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Portfolio Section (Table Structure) -->
    <section id="edit_portfolio" class="container section">
    <h2>Portfolio</h2>
    <table border="0" class="table table-bordered">
        <thead>
            <tr>
                <th>Project</th>
                <th>Description</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= htmlspecialchars($project['project_name']) ?></td>
                    <td><?= htmlspecialchars($project['description']) ?></td>
                    <td><img src="uploads/<?= htmlspecialchars($project['image']) ?>" alt="<?= htmlspecialchars($project['project_name']) ?>" class="img-thumbnail" style="width: 100px;"></td>
                    <td><a href="edit_portfolio.php?id=<?= $project['id'] ?>" class="btn btn-primary">Edit</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Add New Project Button (Positioned Below the Table) -->
    <a href="add_project.php" class="btn btn-primary" style="margin: 20px 0;">Add New Project</a>
</section>


    <!-- Contact Section -->
<section id="contact" class="container section">
    <h2>Contact</h2>
    <p>Connect with me on social media!</p>
    <div class="row text-center">
        <div class="col-md-4">
        <?php foreach ($info as $post):?>
            <a href="<?= $post['fb_link']?>" target="_blank" class="social-icon">
                <i class="fa fa-facebook-square" aria-hidden="true" style="font-size: 50px;"></i>
            </a>
            <?php endforeach; ?>
            <p>Facebook</p>
        </div>
        <div class="col-md-4">
        <?php foreach ($info as $post):?>
            <a href="<?= $post['linkedin_link']?>" target="_blank" class="social-icon">
                <i class="fa fa-linkedin-square" aria-hidden="true" style="font-size: 50px;"></i>
            </a>
            <p>LinkedIn</p>
            <?php endforeach; ?>
        </div>
        <div class="col-md-4">
            <a href="<?= $post['ig_link']?>" target="_blank" class="social-icon">
                <i class="fa fa-instagram" aria-hidden="true" style="font-size: 50px;"></i>
            </a>
            <p>Instagram</p>
        </div>
    </div>
</section>


    <!-- Footer -->
    <footer class="footer text-center navbar-custom">
        <p>&copy; 2024 John Doe. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
<script>
$(document).ready(function () {
    // Add smooth scrolling to all navbar links
    $('a[href*="#"]').on('click', function (e) {
        // Prevent default anchor click behavior
        e.preventDefault();

        // Animate scroll to the target section
        $('html, body').animate(
            {
                scrollTop: $($(this).attr('href')).offset().top - 50, // Adjust -50 for navbar height
            },
            800 // Duration in milliseconds
        );
    });
});
</script>
</html>