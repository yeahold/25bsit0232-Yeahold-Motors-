<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
if (!$user) { session_destroy(); header('Location: login.php'); exit; }

$cars = [
    ['model'=>'Toyota Noah','year'=>'2018–2022','desc'=>'Spacious 7–8 seater family van. Very popular for taxi/business use in Kampala. Reliable, fuel-efficient.','price'=>'UGX 45M – 75M','img'=>'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?w=700&q=80','badge'=>'Best Seller'],
    ['model'=>'Toyota Hilux','year'=>'2016–2023','desc'=>'Tough double-cab pickup. King of Uganda roads – great for business, farming & rough terrain.','price'=>'UGX 55M – 120M','img'=>'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=700&q=80','badge'=>'Hot'],
    ['model'=>'Land Cruiser Prado','year'=>'2014–2021','desc'=>'Premium SUV – durable, off-road capable, high resale value. Favorite for families & executives.','price'=>'UGX 90M – 180M','img'=>'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=700&q=80','badge'=>'Premium'],
    ['model'=>'Toyota Harrier','year'=>'2014–2020','desc'=>'Luxury crossover SUV. Stylish, comfortable, smooth drive – very sought after in Uganda.','price'=>'UGX 50M – 95M','img'=>'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=700&q=80','badge'=>''],
    ['model'=>'Toyota Corolla','year'=>'2016–2023','desc'=>'Reliable sedan – low maintenance, fuel saver. Perfect daily driver for city use.','price'=>'UGX 35M – 65M','img'=>'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?w=700&q=80','badge'=>''],
    ['model'=>'Nissan Navara','year'=>'2015–2022','desc'=>'Strong pickup alternative to Hilux. Good payload & off-road ability for work.','price'=>'UGX 50M – 90M','img'=>'https://images.unsplash.com/photo-1486496146582-9ffcd0b2b2b7?w=700&q=80','badge'=>''],
    ['model'=>'Mitsubishi Delica','year'=>'2013–2020','desc'=>'Rugged 7–8 seater MPV. Excellent for families & group transport on rough roads.','price'=>'UGX 40M – 70M','img'=>'https://images.unsplash.com/photo-1546614042-7df3c24c9e5d?w=700&q=80','badge'=>''],
    ['model'=>'Subaru Forester','year'=>'2016–2022','desc'=>'AWD safety & performance. Great handling in rain & on bad roads. Safety rated.','price'=>'UGX 45M – 85M','img'=>'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?w=700&q=80','badge'=>'New Arrival'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Car Inventory — YEAHOLD MOTORS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="ym-page">
    <div class="ym-section-header">
        <div class="tag"><i class="fas fa-car"></i> Car Inventory</div>
        <h1>Our <span>Featured Cars</span></h1>
        <p>Popular Japanese imports &amp; reliable vehicles we sell in Kampala — quality you can trust.</p>
    </div>

    <div class="ym-grid">
        <?php foreach ($cars as $i => $car): ?>
        <div class="ym-card anim-fade-up" style="transition-delay:<?= ($i % 3) * 0.08 ?>s;">
            <div class="ym-card__img-wrap">
                <img src="<?= htmlspecialchars($car['img']) ?>" alt="<?= htmlspecialchars($car['model']) ?>" loading="lazy">
                <?php if($car['badge']): ?>
                <span class="ym-card__badge"><?= htmlspecialchars($car['badge']) ?></span>
                <?php endif; ?>
            </div>
            <div class="ym-card__body">
                <h3 class="ym-card__title"><?= htmlspecialchars($car['model']) ?></h3>
                <span class="ym-card__year"><i class="fas fa-calendar-alt"></i> <?= htmlspecialchars($car['year']) ?></span>
                <p class="ym-card__desc"><?= htmlspecialchars($car['desc']) ?></p>
                <span class="ym-card__price"><?= htmlspecialchars($car['price']) ?></span>
            </div>
            <div class="ym-card__footer">
                <a href="tel:+256791463105" class="ym-btn ym-btn-gold" style="flex:1;justify-content:center;"><i class="fas fa-phone"></i> Enquire</a>
                <a href="https://wa.me/256791463105?text=Hi, I'm interested in the <?= urlencode($car['model']) ?>" target="_blank" class="ym-btn ym-btn-outline"><i class="fab fa-whatsapp"></i></a>
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
