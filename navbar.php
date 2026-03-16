<?php
// navbar.php - shared navigation include
// Requires $user to be set before including
$current = basename($_SERVER['PHP_SELF']);
?>
<nav class="ym-nav" id="ymNav">
    <div class="ym-nav__inner">
        <a href="dashboard.php" class="ym-nav__brand">
            <span class="ym-nav__logo-icon">⬡</span>
            <span class="ym-nav__logo-text">YEAHOLD<em>MOTORS</em></span>
        </a>
        <button class="ym-nav__burger" id="navBurger" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
        <ul class="ym-nav__links" id="navLinks">
            <li><a href="dashboard.php" class="<?= $current==='dashboard.php'?'active':'' ?>">
                <i class="fas fa-user-circle"></i> Profile
            </a></li>
            <li><a href="gallery.php" class="<?= $current==='gallery.php'?'active':'' ?>">
                <i class="fas fa-car"></i> Inventory
            </a></li>
            <li><a href="brands.php" class="<?= $current==='brands.php'?'active':'' ?>">
                <i class="fas fa-star"></i> Brands
            </a></li>
            <li><a href="services.php" class="<?= $current==='services.php'?'active':'' ?>">
                <i class="fas fa-wrench"></i> Services
            </a></li>
            <li class="ym-nav__user">
                <span class="ym-nav__greeting">
                    <i class="fas fa-circle ym-nav__online-dot"></i>
                    <?= htmlspecialchars($user['full_name']) ?>
                </span>
            </li>
            <li>
                <a href="edit-profile.php" class="ym-nav__edit-btn">
                    <i class="fas fa-pen"></i> Edit
                </a>
            </li>
            <li>
                <a href="logout.php" class="ym-nav__logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</nav>
<script>
document.getElementById('navBurger').addEventListener('click', function() {
    document.getElementById('navLinks').classList.toggle('open');
    this.classList.toggle('active');
});
window.addEventListener('scroll', function() {
    document.getElementById('ymNav').classList.toggle('scrolled', window.scrollY > 40);
});
</script>
