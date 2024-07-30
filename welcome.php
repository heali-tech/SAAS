<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Assuming you have set up a connection to your database
$host = 'localhost';
$db = 'growth';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$stmt = $pdo->prepare('SELECT * FROM mygrowth WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Growth App</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/index.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
</head>
<body>
    <nav class="navbar"> 
        <div class="container">
            <div class="logo">
                <a href="index.html">
                    <img src="images/logo.png" alt="logo">
                </a>
            </div>
            <div class="main-menu">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about_us.html">About us</a></li>
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="our_process.html">Our process</a></li>
                    <li><a href="meet_team.html">Join our team</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a class="btn btn-dark" href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
                </ul>
            </div>
            <button class="hamburger-button">
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
            </button>
            <div class="mobile-menu">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about_us.html">About Us</a></li>
                    <li><a href="blog.html">Blog</a></li>
                    <li><a class="btn" href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="welcome">
        <div class="container">
            <div class="welcome-content">
                <h2 class="text-xxl">Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
                <p>Your email: <?php echo htmlspecialchars($user['email']); ?></p>
                <div class="welcome-buttons">
                    <a href="#" class="btn btn-primary">Profile</a>
                    <a href="#" class="btn">Settings</a>
                    <a href="dashboard.php" class="btn">Dashboard</a>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer bg-black">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="index.html">
                        <img src="images/logo-white.png" alt="logo" />
                    </a>
                    <div class="card">
                        <h4>Subscribe to Newsletter</h4>
                        <p class="text-sm">Subscribe now to receive tips on how to take your business to the next level.</p>
                        <form>
                            <input type="email" id="email" placeholder="Enter your email" />
                            <button type="submit" class="btn btn-primary btn-block">Subscribe</button>
                        </form>
                    </div>
                    <i class="fab fa-linkedin"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                </div>
                <div>
                    <h4>Company</h4>
                    <ul>
                        <li><a href="about_us.html">About Us</a></li>
                        <li><a href="our_process">Our Process</a></li>
                        <li><a href="meet_team.html">Join Our Team</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Resources</h4>
                    <ul>
                        <li><a href="#">News</a></li>
                        <li><a href="#">Research</a></li>
                        <li><a href="#">Recent Projects</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Contact</h4>
                    <ul>
                        <li><a href="#">hello@growthapp.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <script src="js/main.js"></script>
</body>
</html>
