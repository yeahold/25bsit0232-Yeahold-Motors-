<?php
include 'config.php';
if (isset($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; }

$error = $success = '';
if ($_POST) {
    $full_name = trim($_POST['full_name']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $phone     = trim($_POST['phone'] ?? '');
    if (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, phone) VALUES (?,?,?,?)");
        try {
            $stmt->execute([$full_name, $email, $hashed, $phone]);
            $_SESSION['success'] = "Account created! Welcome to Yeahold Motors.";
            header("Location: login.php"); exit;
        } catch (PDOException $e) {
            $error = "This email is already registered.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up — YEAHOLD MOTORS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="ym-auth">
    <div class="ym-auth__box" style="max-width:500px;">
        <div class="ym-auth__logo">
            <div class="hex">⬡</div>
            <h1>YEAHOLD<span>MOTORS</span></h1>
        </div>
        <h2 class="ym-auth__title">Create your account</h2>
        <p class="ym-auth__sub">Join thousands of satisfied customers</p>

        <?php if($error): ?>
        <div class="ym-alert ym-alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="ym-form-group">
                <label>Full Name</label>
                <div class="ym-input-wrap">
                    <i class="fas fa-user ym-input-icon"></i>
                    <input type="text" name="full_name" class="ym-form-control" placeholder="Ndagire Trisha" required autocomplete="name">
                </div>
            </div>
            <div class="ym-form-group">
                <label>Email Address</label>
                <div class="ym-input-wrap">
                    <i class="fas fa-envelope ym-input-icon"></i>
                    <input type="email" name="email" class="ym-form-control" placeholder="you@example.com" required autocomplete="email">
                </div>
            </div>
            <div class="ym-form-group">
                <label>Phone <span style="color:var(--text3);font-weight:400;">(optional)</span></label>
                <div class="ym-input-wrap">
                    <i class="fas fa-phone ym-input-icon"></i>
                    <input type="tel" name="phone" class="ym-form-control" placeholder="+256 7XX XXX XXX">
                </div>
            </div>
            <div class="ym-form-group">
                <label>Password</label>
                <div class="ym-input-wrap">
                    <i class="fas fa-lock ym-input-icon"></i>
                    <input type="password" name="password" class="ym-form-control" placeholder="Min. 6 characters" required autocomplete="new-password">
                </div>
            </div>
            <button type="submit" class="ym-btn ym-btn-gold ym-btn-full ym-btn-lg" style="margin-top:0.5rem;">
                <i class="fas fa-user-plus"></i> Create Account
            </button>
        </form>
        <div class="ym-divider">or</div>
        <p class="ym-auth__link">Already have an account? <a href="login.php">Sign In</a></p>
        <p class="ym-auth__link" style="margin-top:0.5rem;"><a href="index.php"><i class="fas fa-arrow-left"></i> Back to Home</a></p>
    </div>
</div>
</body>
</html>
