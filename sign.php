<?php
session_start();

// SAMPLE USER (for demo)
$sampleUser = "fred";
// hashed password for "12345"
$sampleHash = password_hash("12345", PASSWORD_BCRYPT);

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check username and password
    if ($username === $sampleUser && password_verify($password, $sampleHash)) {
        $_SESSION['username'] = $username;
        $_SESSION['hash'] = $sampleHash;
    } else {
        echo "<p>Invalid username or password</p>";
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Demo</title>
</head>
<body>

<form method="POST">
    <label>Username</label>
    <input type="text" name="username">

    <br><br>

    <label>Password</label>
    <input type="password" name="password">

    <br><br>

    <button type="submit" name="login">Login</button>

    <br><br>

    <button type="submit" name="logout">Logout</button>
</form>

<hr>

<?php if (isset($_SESSION['username'])): ?>
    <h3>User logged in: <?= $_SESSION['username']; ?></h3>
    <p><strong>Password:</strong><br><?= $_SESSION['hash']; ?></p>
<?php endif; ?>

</body>
</html>
