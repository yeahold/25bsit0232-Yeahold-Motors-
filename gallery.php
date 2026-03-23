<?php
/**
 * gallery.php
 * ─────────────────────────────────────────────────
 * YEAHOLD MOTORS — Car Inventory (Dynamic)
 *
 * MILESTONE: This page no longer uses hard-coded HTML.
 * All car listings are fetched from `tbl_content` using
 * a PDO query and rendered in a single HTML template loop.
 *
 * To add a new car: go to phpMyAdmin → tbl_content → Insert.
 * It will appear here automatically — no HTML changes needed.
 * ─────────────────────────────────────────────────
 */

// 1. Use the separate connection file (Milestone requirement)
include 'db_connect.php';

// 2. Also need session/user auth from config.php
include 'config.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
if (!$user) { session_destroy(); header('Location: login.php'); exit; }

// 3. THE DYNAMIC QUERY — fetch all active cars from tbl_content
//    Only `is_active = 1` rows are shown (lets you hide cars without deleting)
try {
    $query  = $db->prepare("SELECT * FROM tbl_content WHERE is_active = 1 ORDER BY id ASC");
    $query->execute();
    $cars   = $query->fetchAll();  // fetchAll returns every row as an array
    $total  = count($cars);
} catch (PDOException $e) {
    $cars  = [];
    $total = 0;
    $db_error = "Could not load inventory: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Car Inventory — YEAHOLD MOTORS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Empty-state styles */
        .ym-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 5rem 2rem;
            color: var(--text3);
        }
        .ym-empty__icon {
            font-size: 4rem;
            color: var(--surface2);
            margin-bottom: 1.5rem;
            display: block;
        }
        .ym-empty h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            letter-spacing: 0.05em;
            color: var(--text2);
            margin-bottom: 0.5rem;
        }
        .ym-empty p { font-size: 0.95rem; max-width: 420px; margin: 0 auto 1.5rem; }
        .ym-count-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-family: 'Space Mono', monospace;
            font-size: 0.72rem;
            letter-spacing: 0.1em;
            color: var(--text3);
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 0.3rem 0.85rem;
            border-radius: 20px;
            margin-top: 0.75rem;
        }
        .ym-db-error {
            background: rgba(231,76,60,0.1);
            border: 1px solid rgba(231,76,60,0.3);
            color: #f1948a;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin: 0 2rem 2rem;
            font-size: 0.88rem;
            max-width: 1380px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="ym-page">

    <!-- PAGE HEADER -->
    <div class="ym-section-header">
        <div class="tag"><i class="fas fa-database"></i> Live Database Inventory</div>
        <h1>Our <span>Featured Cars</span></h1>
        <p>Popular Japanese imports &amp; reliable vehicles we sell in Kampala — quality you can trust.</p>
        <!-- Shows the live count pulled from the database -->
        <?php if ($total > 0): ?>
        <div class="ym-count-tag">
            <i class="fas fa-car"></i>
            <?= $total ?> vehicle<?= $total !== 1 ? 's' : '' ?> in inventory
        </div>
        <?php endif; ?>
    </div>

    <!-- DATABASE ERROR (if connection worked but query failed) -->
    <?php if (!empty($db_error)): ?>
    <div class="ym-db-error">
        <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($db_error) ?>
    </div>
    <?php endif; ?>

    <!-- ═══════════════════════════════════════════
         THE DYNAMIC LOOP — Milestone Requirement
         No repeated static HTML blocks below.
         One template, rendered for every DB row.
         ═══════════════════════════════════════════ -->
    <div class="ym-grid">

        <?php if ($total === 0): ?>
        <!-- ── EMPTY STATE (Milestone: handle no records) ── -->
        <div class="ym-empty">
            <span class="ym-empty__icon"><i class="fas fa-car-crash"></i></span>
            <h3>No Vehicles Found</h3>
            <p>The inventory is currently empty. Add rows to the <code>tbl_content</code> table in phpMyAdmin and they will appear here automatically.</p>
            <a href="mailto:info@yeahold.ug" class="ym-btn ym-btn-outline">
                <i class="fas fa-envelope"></i> Contact Us to List a Car
            </a>
        </div>

        <?php else: ?>
        <!-- ── DYNAMIC TEMPLATE: one card per database row ── -->
        <?php foreach ($cars as $i => $car): ?>
        <div class="ym-card anim-fade-up" style="transition-delay:<?= ($i % 3) * 0.08 ?>s;">

            <!-- Image pulled from image_url column -->
            <div class="ym-card__img-wrap">
                <img
                    src="<?= htmlspecialchars($car['image_url']) ?>"
                    alt="<?= htmlspecialchars($car['title']) ?>"
                    loading="lazy"
                    onerror="this.src='https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=700&q=80'">
                <!-- Badge pulled from badge column (only shown if not NULL) -->
                <?php if (!empty($car['badge'])): ?>
                <span class="ym-card__badge"><?= htmlspecialchars($car['badge']) ?></span>
                <?php endif; ?>
            </div>

            <div class="ym-card__body">
                <!-- title column -->
                <h3 class="ym-card__title"><?= htmlspecialchars($car['title']) ?></h3>

                <!-- year_range column -->
                <?php if (!empty($car['year_range'])): ?>
                <span class="ym-card__year">
                    <i class="fas fa-calendar-alt"></i> <?= htmlspecialchars($car['year_range']) ?>
                </span>
                <?php endif; ?>

                <!-- description column -->
                <p class="ym-card__desc"><?= htmlspecialchars($car['description']) ?></p>

                <!-- price column -->
                <?php if (!empty($car['price'])): ?>
                <span class="ym-card__price"><?= htmlspecialchars($car['price']) ?></span>
                <?php endif; ?>
            </div>

            <!-- Action buttons -->
            <div class="ym-card__footer">
                <a href="tel:+256791463105"
                   class="ym-btn ym-btn-gold"
                   style="flex:1;justify-content:center;">
                    <i class="fas fa-phone"></i> Enquire
                </a>
                <a href="https://wa.me/256791463105?text=Hi%2C+I%27m+interested+in+the+<?= urlencode($car['title']) ?>"
                   target="_blank"
                   class="ym-btn ym-btn-outline"
                   title="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>

    </div><!-- /ym-grid -->
</div><!-- /ym-page -->

<!-- FOOTER -->
<footer class="ym-footer">
    <div class="ym-footer__bottom" style="max-width:1100px;margin:0 auto;">
        <span>&copy; <?= date('Y') ?> Yeahold Motors &bull; Kampala, Uganda</span>
        <span>+256 791 463 105 &nbsp;&middot;&nbsp; Mon&ndash;Sat 8AM&ndash;6PM</span>
    </div>
</footer>

<script>
const obs = new IntersectionObserver(
    entries => entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); }),
    { threshold: 0.1 }
);
document.querySelectorAll('.anim-fade-up').forEach(el => obs.observe(el));
</script>
</body>
</html>
