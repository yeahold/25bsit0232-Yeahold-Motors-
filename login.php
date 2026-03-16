<?php
include 'config.php';
if (isset($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; }

$error = '';
if ($_POST) {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php"); exit;
    } else {
        $error = "Invalid email or password. Please try again.";
    }
}
$success = $_SESSION['success'] ?? '';
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — YEAHOLD MOTORS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="ym-auth">
    <div class="ym-auth__box">
        <div class="ym-auth__logo">
            <div class="hex">⬡</div>
            <h1>YEAHOLD<span>MOTORS</span></h1>
        </div>
        <h2 class="ym-auth__title">Welcome back</h2>
        <p class="ym-auth__sub">Sign in to your account to continue</p>

        <?php if($error): ?>
        <div class="ym-alert ym-alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if($success): ?>
        <div class="ym-alert ym-alert-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="ym-form-group">
                <label>Email Address</label>
                <div class="ym-input-wrap">
                    <i class="fas fa-envelope ym-input-icon"></i>
                    <input type="email" name="email" class="ym-form-control" placeholder="you@example.com" required autocomplete="email">
                </div>
            </div>
            <div class="ym-form-group">
                <label>Password</label>
                <div class="ym-input-wrap">
                    <i class="fas fa-lock ym-input-icon"></i>
                    <input type="password" name="password" class="ym-form-control" placeholder="••••••••" required autocomplete="current-password">
                </div>
            </div>
            <button type="submit" class="ym-btn ym-btn-gold ym-btn-full ym-btn-lg" style="margin-top:0.5rem;">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>
        <div class="ym-divider">or</div>
        <p class="ym-auth__link">Don't have an account? <a href="signup.php">Create one free</a></p>
        <p class="ym-auth__link" style="margin-top:0.5rem;"><a href="index.php"><i class="fas fa-arrow-left"></i> Back to Home</a></p>
    </div>
</div>
</body>
</html>
