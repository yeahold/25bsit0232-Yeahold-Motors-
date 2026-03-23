<?php
/**
 * index.php — YEAHOLD MOTORS Landing Page
 * Featured vehicles section is now data-driven from tbl_content.
 */
include 'db_connect.php';
include 'config.php';

// Fetch up to 3 featured cars (those with a badge, newest first)
try {
    $feat_query = $db->prepare(
        "SELECT * FROM tbl_content
         WHERE is_active = 1 AND badge IS NOT NULL
         ORDER BY id DESC LIMIT 3"
    );
    $feat_query->execute();
    $featured = $feat_query->fetchAll();
    // Fallback: if no badged cars, just grab the first 3
    if (empty($featured)) {
        $feat_query2 = $db->prepare("SELECT * FROM tbl_content WHERE is_active = 1 ORDER BY id ASC LIMIT 3");
        $feat_query2->execute();
        $featured = $feat_query2->fetchAll();
    }
} catch (PDOException $e) {
    $featured = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YEAHOLD MOTORS | Premium Cars — Kampala, Uganda</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="ym-nav" id="ymNav">
    <div class="ym-nav__inner">
        <a href="index.php" class="ym-nav__brand">
            <span class="ym-nav__logo-icon">&#x2B21;</span>
            <span class="ym-nav__logo-text">YEAHOLD<em>MOTORS</em></span>
        </a>
        <button class="ym-nav__burger" id="navBurger" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
        <ul class="ym-nav__links" id="navLinks">
            <li><a href="#inventory"><i class="fas fa-car"></i> Inventory</a></li>
            <li><a href="#services"><i class="fas fa-wrench"></i> Services</a></li>
            <li><a href="#about"><i class="fas fa-info-circle"></i> About</a></li>
            <li><a href="login.php" class="ym-nav__edit-btn"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            <li>
                <a href="signup.php" class="ym-btn ym-btn-gold" style="padding:0.45rem 1.1rem;border-radius:8px;">
                    <i class="fas fa-user-plus"></i> Get Started
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- HERO -->
<section class="ym-hero">
    <div class="ym-hero__content">
        <p class="ym-hero__eyebrow">Kampala, Uganda &bull; Est. 2024</p>
        <h1 class="ym-hero__title">
            YEAHOLD
            <span>MOTORS</span>
        </h1>
        <p class="ym-hero__sub">Drive your dream. Premium imports, trusted service, unbeatable prices.</p>
        <div>
            <a href="signup.php" class="ym-hero__cta">
                <i class="fas fa-arrow-right"></i> Get Started
            </a>
            <a href="#inventory" class="ym-hero__cta-ghost">
                <i class="fas fa-car"></i> View Inventory
            </a>
        </div>
        <div class="ym-hero__stats">
            <div class="ym-hero__stat">
                <span class="ym-hero__stat-num">200+</span>
                <span class="ym-hero__stat-label">Cars Sold</span>
            </div>
            <div class="ym-hero__stat">
                <span class="ym-hero__stat-num">6+</span>
                <span class="ym-hero__stat-label">Top Brands</span>
            </div>
            <div class="ym-hero__stat">
                <span class="ym-hero__stat-num">500+</span>
                <span class="ym-hero__stat-label">Happy Clients</span>
            </div>
            <div class="ym-hero__stat">
                <span class="ym-hero__stat-num">24/7</span>
                <span class="ym-hero__stat-label">Support</span>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES STRIP -->
<section class="ym-features">
    <div class="ym-features__grid">
        <div class="ym-feature anim-fade-up">
            <span class="ym-feature__icon"><i class="fas fa-shipping-fast"></i></span>
            <h3>Direct Imports</h3>
            <p>Sourced from Japan, UK &amp; UAE for quality &amp; value</p>
        </div>
        <div class="ym-feature anim-fade-up">
            <span class="ym-feature__icon"><i class="fas fa-shield-alt"></i></span>
            <h3>Inspection Certified</h3>
            <p>Every vehicle passes our 50-point check</p>
        </div>
        <div class="ym-feature anim-fade-up">
            <span class="ym-feature__icon"><i class="fas fa-hand-holding-usd"></i></span>
            <h3>Flexible Financing</h3>
            <p>Installment plans tailored to your budget</p>
        </div>
        <div class="ym-feature anim-fade-up">
            <span class="ym-feature__icon"><i class="fas fa-tools"></i></span>
            <h3>In-House Service</h3>
            <p>Professional repair &amp; maintenance center</p>
        </div>
    </div>
</section>

<!-- FEATURED INVENTORY — pulled dynamically from tbl_content -->
<section id="inventory">
    <div class="ym-section-header">
        <div class="tag"><i class="fas fa-database"></i> From Database</div>
        <h1>Featured <span>Vehicles</span></h1>
        <p>Hand-picked cars dominating the Ugandan market — updated live from our database.</p>
    </div>

    <div class="ym-grid" style="max-width:1100px;">
        <?php if (empty($featured)): ?>
        <!-- Empty state -->
        <div style="grid-column:1/-1;text-align:center;padding:4rem 2rem;color:var(--text3);">
            <i class="fas fa-car-crash" style="font-size:3rem;display:block;margin-bottom:1rem;"></i>
            <p>No featured vehicles found in the database yet.</p>
            <a href="signup.php" class="ym-btn ym-btn-outline" style="margin-top:1rem;">Create an account to browse</a>
        </div>
        <?php else: ?>
        <?php foreach ($featured as $i => $car): ?>
        <div class="ym-card anim-fade-up" style="transition-delay:<?= $i * 0.1 ?>s;">
            <div class="ym-card__img-wrap">
                <img
                    src="<?= htmlspecialchars($car['image_url']) ?>"
                    alt="<?= htmlspecialchars($car['title']) ?>"
                    loading="lazy"
                    onerror="this.src='https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=700&q=80'">
                <?php if (!empty($car['badge'])): ?>
                <span class="ym-card__badge"><?= htmlspecialchars($car['badge']) ?></span>
                <?php endif; ?>
            </div>
            <div class="ym-card__body">
                <h3 class="ym-card__title"><?= htmlspecialchars($car['title']) ?></h3>
                <?php if (!empty($car['year_range'])): ?>
                <span class="ym-card__year">
                    <i class="fas fa-calendar-alt"></i> <?= htmlspecialchars($car['year_range']) ?>
                </span>
                <?php endif; ?>
                <p class="ym-card__desc"><?= htmlspecialchars($car['description']) ?></p>
                <?php if (!empty($car['price'])): ?>
                <span class="ym-card__price"><?= htmlspecialchars($car['price']) ?></span>
                <?php endif; ?>
            </div>
            <div class="ym-card__footer">
                <a href="signup.php" class="ym-btn ym-btn-gold ym-btn-full">
                    <i class="fas fa-info-circle"></i> Enquire Now
                </a>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div style="text-align:center;padding-bottom:4rem;">
        <a href="signup.php" class="ym-btn ym-btn-outline ym-btn-lg">
            <i class="fas fa-th-large"></i> View Full Inventory
        </a>
    </div>
</section>

<!-- ABOUT -->
<section id="about" style="background:var(--bg2);border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:5rem 2rem;">
    <div style="max-width:900px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;">
        <div>
            <div class="ym-section-header" style="text-align:left;padding:0;">
                <div class="tag"><i class="fas fa-info-circle"></i> About Us</div>
                <h1 style="margin-top:1rem;">Trusted by <span>Ugandans</span></h1>
            </div>
            <p style="color:var(--text2);margin-top:1.5rem;line-height:1.9;">
                Yeahold Motors is a premier vehicle dealership and service center based in Kampala.
                We specialize in the importation and sale of quality vehicles from Japan, UK, and UAE —
                offering the most sought-after models at competitive prices.
            </p>
            <div style="margin-top:2rem;display:flex;gap:1rem;flex-wrap:wrap;">
                <a href="signup.php" class="ym-btn ym-btn-gold ym-btn-lg"><i class="fas fa-user-plus"></i> Join Us</a>
                <a href="tel:+256791463105" class="ym-btn ym-btn-outline ym-btn-lg"><i class="fas fa-phone"></i> Call Now</a>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:1.5rem;text-align:center;">
                <i class="fas fa-map-marker-alt" style="font-size:1.8rem;color:var(--gold);margin-bottom:.75rem;display:block;"></i>
                <strong>Location</strong>
                <p style="font-size:.85rem;color:var(--text2);margin-top:.3rem;">Kampala, Uganda</p>
            </div>
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:1.5rem;text-align:center;">
                <i class="fas fa-clock" style="font-size:1.8rem;color:var(--gold);margin-bottom:.75rem;display:block;"></i>
                <strong>Hours</strong>
                <p style="font-size:.85rem;color:var(--text2);margin-top:.3rem;">Mon&ndash;Sat 8AM&ndash;6PM</p>
            </div>
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:1.5rem;text-align:center;">
                <i class="fab fa-whatsapp" style="font-size:1.8rem;color:var(--gold);margin-bottom:.75rem;display:block;"></i>
                <strong>WhatsApp</strong>
                <p style="font-size:.85rem;color:var(--text2);margin-top:.3rem;">+256 791 463 105</p>
            </div>
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:1.5rem;text-align:center;">
                <i class="fas fa-envelope" style="font-size:1.8rem;color:var(--gold);margin-bottom:.75rem;display:block;"></i>
                <strong>Email</strong>
                <p style="font-size:.85rem;color:var(--text2);margin-top:.3rem;">info@yeahold.ug</p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="ym-footer">
    <div class="ym-footer__inner">
        <div class="ym-footer__brand">
            <span class="ym-nav__logo-text">YEAHOLD<em>MOTORS</em></span>
            <p>Premium vehicles and trusted auto services in Kampala, Uganda. Your dream car is one call away.</p>
        </div>
        <div class="ym-footer__col">
            <h4>Navigate</h4>
            <ul>
                <li><a href="#inventory">Inventory</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign Up</a></li>
            </ul>
        </div>
        <div class="ym-footer__col">
            <h4>Contact</h4>
            <ul>
                <li><a href="tel:+256791463105">+256 791 463 105</a></li>
                <li><a href="mailto:info@yeahold.ug">info@yeahold.ug</a></li>
                <li><a href="#">Kampala, Uganda</a></li>
            </ul>
        </div>
    </div>
    <div class="ym-footer__bottom">
        <span>&copy; <?= date('Y') ?> Yeahold Motors. All rights reserved.</span>
        <span>Made with <i class="fas fa-heart" style="color:var(--gold)"></i> in Kampala</span>
    </div>
</footer>

<script>
document.getElementById('navBurger').addEventListener('click', function() {
    document.getElementById('navLinks').classList.toggle('open');
    this.classList.toggle('active');
});
window.addEventListener('scroll', function() {
    document.getElementById('ymNav').classList.toggle('scrolled', window.scrollY > 40);
});
const obs = new IntersectionObserver(
    entries => entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); }),
    { threshold: 0.12 }
);
document.querySelectorAll('.anim-fade-up').forEach(el => obs.observe(el));
</script>
</body>
</html>
