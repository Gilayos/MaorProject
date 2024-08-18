<?php
session_start();

// Hardcoded username and password
$valid_username = "idfcommander";
$valid_password = "sisma123";

// Initialize the login attempts if not already set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

// Check if the maximum attempts have been reached
if ($_SESSION['login_attempts'] >= 5) {
    // Redirect to an error page or lockout page
    $error = "הקש קוד סודי לאיפוס ,נגמרו לך הנסיונות";
    header('Location: index.html?error=' . urlencode($error));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the submitted username and password match the hardcoded values
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['username'] = $username;
        $_SESSION['login_attempts'] = 0; // Reset attempts on successful login
        // Redirect to a protected page or dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        // Increment login attempts
        $_SESSION['login_attempts']++;
        $remaining_attempts = 5 - $_SESSION['login_attempts'];
        // Redirect back to the login page with an error message
        $error = "שם משתמש או סיסמה לא נכונים, נשאר לך $remaining_attempts נסיונות.";
        header('Location: index.html?error=' . urlencode($error));
        exit();
    }
} else {
    // If the request method is not POST, redirect back to the login page
    header('Location: login.html');
    exit();
}
?>
