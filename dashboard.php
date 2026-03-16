<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
if (!$user) { session_destroy(); header('Location: login.php'); exit; }

$avatar = !empty($user['profile_picture']) && file_exists('uploads/avatars/'.$user['profile_picture'])
    ? 'uploads/avatars/' . htmlspecialchars($user['profile_picture'])
    : 'https://ui-avatars.com/api/?name=' . urlencode($user['full_name']) . '&background=c9a84c&color=0a0b0d&size=200&bold=true';
$bio = !empty($user['bio']) ? nl2br(htmlspecialchars($user['bio'])) : '<em style="color:var(--text3)">No bio added yet. <a href="edit-profile.php" style="color:var(--gold)">Add one →</a></em>';
$memberSince = date('F Y', strtotime($user['created_at']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile — YEAHOLD MOTORS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="ym-page">
    <div class="ym-dashboard">

        <!-- PROFILE HERO -->
        <div class="ym-profile-hero anim-fade-up">
            <div class="ym-avatar-wrap">
                <img src="<?= $avatar ?>" alt="Profile picture of <?= htmlspecialchars($user['full_name']) ?>" class="ym-avatar">
                <a href="edit-profile.php" class="ym-avatar-edit" title="Edit profile"><i class="fas fa-pen"></i></a>
            </div>
            <div class="ym-profile-info">
                <h1 class="ym-profile-name"><?= htmlspecialchars($user['full_name']) ?></h1>
                <p class="ym-profile-handle">@user<?= $user['id'] ?> &nbsp;·&nbsp; Member since <?= $memberSince ?></p>
                <div class="ym-profile-meta">
                    <div class="ym-meta-pill"><i class="fas fa-envelope"></i><?= htmlspecialchars($user['email']) ?></div>
                    <?php if(!empty($user['phone'])): ?>
                    <div class="ym-meta-pill"><i class="fas fa-phone"></i><?= htmlspecialchars($user['phone']) ?></div>
                    <?php endif; ?>
                    <div class="ym-meta-pill"><i class="fas fa-calendar-check"></i><?= $memberSince ?></div>
                </div>
            </div>
        </div>

        <!-- BIO -->
        <div class="ym-profile-bio-card anim-fade-up" style="transition-delay:0.1s;">
            <h3><i class="fas fa-user"></i> About Me</h3>
            <div class="ym-bio-text"><?= $bio ?></div>
        </div>

        <!-- QUICK LINKS -->
        <div class="ym-quick-links">
            <a href="gallery.php" class="ym-quick-link anim-fade-up" style="transition-delay:0.15s;">
                <div class="ym-quick-link__icon"><i class="fas fa-car"></i></div>
                <div class="ym-quick-link__text">
                    <span>Browse</span>
                    <strong>Car Inventory</strong>
                </div>
            </a>
            <a href="brands.php" class="ym-quick-link anim-fade-up" style="transition-delay:0.2s;">
                <div class="ym-quick-link__icon"><i class="fas fa-star"></i></div>
                <div class="ym-quick-link__text">
                    <span>Explore</span>
                    <strong>Our Brands</strong>
                </div>
            </a>
            <a href="services.php" class="ym-quick-link anim-fade-up" style="transition-delay:0.25s;">
                <div class="ym-quick-link__icon"><i class="fas fa-wrench"></i></div>
                <div class="ym-quick-link__text">
                    <span>Book</span>
                    <strong>Auto Services</strong>
                </div>
            </a>
            <a href="edit-profile.php" class="ym-quick-link anim-fade-up" style="transition-delay:0.3s;">
                <div class="ym-quick-link__icon"><i class="fas fa-pen"></i></div>
                <div class="ym-quick-link__text">
                    <span>Update</span>
                    <strong>Edit Profile</strong>
                </div>
            </a>
        </div>

    </div>
</div>

<!-- FOOTER -->
<footer class="ym-footer">
    <div class="ym-footer__bottom" style="max-width:1100px;margin:0 auto;">
        <span>&copy; <?= date('Y') ?> Yeahold Motors • Kampala, Uganda</span>
        <span>+256 791 463 105 &nbsp;·&nbsp; Mon–Sat 8AM–6PM</span>
    </div>
</footer>

<script>
const obs = new IntersectionObserver((entries)=>{entries.forEach(e=>{if(e.isIntersecting)e.target.classList.add('visible');});},{threshold:0.1});
document.querySelectorAll('.anim-fade-up').forEach(el=>obs.observe(el));
</script>
</body>
</html>
