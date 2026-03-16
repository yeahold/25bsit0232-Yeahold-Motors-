<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
if (!$user) { session_destroy(); header('Location: login.php'); exit; }

$services = [
    ['title'=>'Oil Change & Filter Replacement','desc'=>'Regular oil changes keep your engine running smoothly and extend its life. We use high-quality oils and genuine filters for all brands.','img'=>'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=700&q=80','price'=>'From UGX 80,000','icon'=>'fas fa-oil-can'],
    ['title'=>'Brake Inspection & Repair','desc'=>'Safety first! We inspect pads, discs, calipers, fluid, and lines. Full brake repair & replacement available for all vehicle makes.','img'=>'https://images.unsplash.com/photo-1625047509168-a7026f36de04?w=700&q=80','price'=>'From UGX 150,000','icon'=>'fas fa-stop-circle'],
    ['title'=>'Tire Rotation & Balancing','desc'=>'Even tire wear improves handling, fuel efficiency, and extends tire life. Includes wheel balancing & alignment check.','img'=>'https://images.unsplash.com/photo-1612825173281-9a193378527e?w=700&q=80','price'=>'UGX 50,000 – 90,000','icon'=>'fas fa-circle-notch'],
    ['title'=>'Engine Diagnostics & Tune-up','desc'=>'Fast computer diagnostics using modern scan tools plus full tune-up: spark plugs, air filters, belts, and timing check.','img'=>'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?w=700&q=80','price'=>'From UGX 120,000','icon'=>'fas fa-search-plus'],
    ['title'=>'AC Repair & Gas Refill','desc'=>'Stay cool in any weather! We diagnose leaks, repair compressors, replace evaporators, and recharge your AC system.','img'=>'https://images.unsplash.com/photo-1601362840469-51e4d8d58785?w=700&q=80','price'=>'From UGX 100,000','icon'=>'fas fa-snowflake'],
    ['title'=>'Suspension & Steering','desc'=>'Shocks, struts, ball joints, bushings, wheel alignment — for a smoother, safer ride and better vehicle control.','img'=>'https://images.unsplash.com/photo-1507136566006-cfc505b114fc?w=700&q=80','price'=>'From UGX 200,000','icon'=>'fas fa-car-crash'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Services — YEAHOLD MOTORS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="ym-page">
    <div class="ym-section-header">
        <div class="tag"><i class="fas fa-wrench"></i> Auto Services</div>
        <h1>Professional <span>Services</span></h1>
        <p>Trusted vehicle repair &amp; maintenance right here in Kampala — quality you can rely on every time.</p>
    </div>

    <div class="ym-grid">
        <?php foreach ($services as $i => $svc): ?>
        <div class="ym-card ym-service-card anim-fade-up" style="transition-delay:<?= ($i % 3) * 0.08 ?>s;">
            <div class="ym-card__img-wrap">
                <img src="<?= htmlspecialchars($svc['img']) ?>" alt="<?= htmlspecialchars($svc['title']) ?>" loading="lazy">
            </div>
            <div class="ym-card__body">
                <div class="ym-card__icon"><i class="<?= $svc['icon'] ?>"></i></div>
                <h3 class="ym-card__title" style="font-size:1.35rem;"><?= htmlspecialchars($svc['title']) ?></h3>
                <p class="ym-card__desc"><?= htmlspecialchars($svc['desc']) ?></p>
                <span class="ym-card__price-tag"><i class="fas fa-tag"></i> <?= htmlspecialchars($svc['price']) ?></span>
            </div>
            <div class="ym-card__footer">
                <a href="tel:+256791463105" class="ym-btn ym-btn-gold" style="flex:1;justify-content:center;"><i class="fas fa-calendar-check"></i> Book Now</a>
                <a href="https://wa.me/256791463105?text=Hi, I'd like to book: <?= urlencode($svc['title']) ?>" target="_blank" class="ym-btn ym-btn-outline"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

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
