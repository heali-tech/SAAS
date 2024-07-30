<?php
session_start();

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

$login_error = $register_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // Handle login
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare('SELECT * FROM mygrowth WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: welcome.php');
            exit;
        } else {
            $login_error = 'Invalid email or password';
        }
    } elseif (isset($_POST['register'])) {
        // Handle registration
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Check if passwords match
        if ($password !== $confirm_password) {
            $register_error = 'Passwords do not match';
        } else {
            // Check if email already exists
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM mygrowth WHERE email = ?');
            $stmt->execute([$email]);
            $emailExists = $stmt->fetchColumn();

            if ($emailExists > 0) {
                $register_error = 'Email address already exists.';
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Insert new user
                $stmt = $pdo->prepare('INSERT INTO mygrowth (name, email, password) VALUES (?, ?, ?)');
                if ($stmt->execute([$name, $email, $hashed_password])) {
                    header('Location: welcome.php');
                    exit;
                } else {
                    $register_error = 'Registration failed. Please try again.';
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Login & Registration Form</title>
</head>
<body>
    <div class="container">
        <div class="forms">
            <div class="form login">
                <span class="title">Login</span>

                <?php if (!empty($login_error)): ?>
                    <p style="color: red;"><?php echo $login_error; ?></p>
                <?php endif; ?>

                <form action="index.php" method="post">
                    <div class="input-field">
                        <input type="email" name="email" placeholder="Enter your email" aria-label="Email" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" name="password" placeholder="Enter your password" aria-label="Password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>

                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" id="logCheck" aria-label="Remember me">
                            <label for="logCheck" class="text">Remember me</label>
                        </div>
                        <a href="#" class="text">Forgot password?</a>
                    </div>

                    <div class="input-field button">
                        <input type="submit" name="login" value="Login">
                    </div>
                </form>

                <div class="login-signup">
                    <span class="text">Not a member?
                        <a href="#" class="text signup-link" onclick="showSignupForm()">Signup Now</a>
                    </span>
                </div>
            </div>

            <div class="form signup" style="display: none;">
                <span class="title">Registration</span>

                <?php if (!empty($register_error)): ?>
                    <p style="color: red;"><?php echo $register_error; ?></p>
                <?php endif; ?>

                <form action="index.php" method="post">
                    <div class="input-field">
                        <input type="text" name="name" placeholder="Enter your name" aria-label="Name" required>
                        <i class="uil uil-user"></i>
                    </div>
                    <div class="input-field">
                        <input type="email" name="email" placeholder="Enter your email" aria-label="Email" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" name="password" placeholder="Create a password" aria-label="Password" required>
                        <i class="uil uil-lock icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" name="confirm_password" placeholder="Confirm your password" aria-label="Confirm Password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>

                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" id="termCon" aria-label="Terms and Conditions">
                            <label for="termCon" class="text">I accept all terms and conditions</label>
                        </div>
                    </div>

                    <div class="input-field button">
                        <input type="submit" name="register" value="Signup">
                    </div>
                </form>

                <div class="login-signup">
                    <span class="text">Already a member?
                        <a href="#" class="text login-link" onclick="showLoginForm()">Login Now</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showSignupForm() {
            document.querySelector('.form.login').style.display = 'none';
            document.querySelector('.form.signup').style.display = 'block';
        }

        function showLoginForm() {
            document.querySelector('.form.signup').style.display = 'none';
            document.querySelector('.form.login').style.display = 'block';
        }
    </script>
    <script src="js/login.js"></script>
</body>
</html>
