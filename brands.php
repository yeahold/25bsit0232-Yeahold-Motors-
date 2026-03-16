<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
if (!$user) { session_destroy(); header('Location: login.php'); exit; }

$brands = [
    ['name'=>'Toyota','desc'=>'The most trusted brand in Uganda – Hilux, Noah, Prado, Corolla, Land Cruiser & more. Legendary reliability and high resale value.','logo'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/Toyota_carlogo.svg/120px-Toyota_carlogo.svg.png','img'=>'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=700&q=80','models'=>'Hilux · Noah · Land Cruiser · Corolla · RAV4','icon'=>'fas fa-crown'],
    ['name'=>'Nissan','desc'=>'Strong pickups & reliable family cars. NP300, Navara, X-Trail, Patrol – built for business & tough roads alike.','logo'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8e/Nissan_logo.svg/120px-Nissan_logo.svg.png','img'=>'https://images.unsplash.com/photo-1486496146582-9ffcd0b2b2b7?w=700&q=80','models'=>'NP300 · Navara · X-Trail · Patrol','icon'=>'fas fa-bolt'],
    ['name'=>'Mitsubishi','desc'=>'Rugged & spacious – Delica, Pajero, L200 Triton. Very popular for families and off-road use in Uganda.','logo'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Mitsubishi_logo.svg/120px-Mitsubishi_logo.svg.png','img'=>'https://images.unsplash.com/photo-1546614042-7df3c24c9e5d?w=700&q=80','models'=>'Delica · Pajero · L200 Triton','icon'=>'fas fa-mountain'],
    ['name'=>'Subaru','desc'=>'All-wheel drive excellence. Forester, Outback, Impreza – loved for safety & performance on wet & rough roads.','logo'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6a/Subaru_logo.svg/120px-Subaru_logo.svg.png','img'=>'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?w=700&q=80','models'=>'Forester · Outback · XV · Impreza','icon'=>'fas fa-shield-alt'],
    ['name'=>'Isuzu','desc'=>'Tough commercial & pickup vehicles. D-Max, MU-X – excellent for heavy-duty work, known for incredible durability.','logo'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Isuzu_logo.svg/120px-Isuzu_logo.svg.png','img'=>'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?w=700&q=80','models'=>'D-Max · MU-X','icon'=>'fas fa-truck'],
    ['name'=>'Honda','desc'=>'Smooth, fuel-efficient & reliable. CR-V, Fit, Civic, Accord – great everyday & family options in the city.','logo'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/3/38/Honda.svg/120px-Honda.svg.png','img'=>'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=700&q=80','models'=>'CR-V · Fit · Civic · Accord','icon'=>'fas fa-leaf'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Car Brands — YEAHOLD MOTORS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="ym-page">
    <div class="ym-section-header">
        <div class="tag"><i class="fas fa-star"></i> Our Brands</div>
        <h1>Brands We <span>Specialize In</span></h1>
        <p>Expert service, repairs &amp; sales for Uganda's most popular imported vehicles.</p>
    </div>

    <div class="ym-grid">
        <?php foreach ($brands as $i => $brand): ?>
        <div class="ym-card ym-brand-card anim-fade-up" style="transition-delay:<?= ($i % 3) * 0.08 ?>s;">
            <div class="ym-card__img-wrap">
                <img src="<?= htmlspecialchars($brand['img']) ?>" alt="<?= htmlspecialchars($brand['name']) ?>" loading="lazy">
                <span class="ym-card__badge"><i class="<?= $brand['icon'] ?>"></i></span>
            </div>
            <img src="<?= htmlspecialchars($brand['logo']) ?>" alt="<?= htmlspecialchars($brand['name']) ?> logo" class="ym-card__logo">
            <div class="ym-card__body" style="text-align:center;">
                <h3 class="ym-card__title"><?= htmlspecialchars($brand['name']) ?></h3>
                <p class="ym-card__desc"><?= htmlspecialchars($brand['desc']) ?></p>
                <div class="ym-card__models"><?= htmlspecialchars($brand['models']) ?></div>
            </div>
            <div class="ym-card__footer">
                <a href="tel:+256791463105" class="ym-btn ym-btn-gold ym-btn-full"><i class="fas fa-phone"></i> Contact for <?= htmlspecialchars($brand['name']) ?></a>
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
