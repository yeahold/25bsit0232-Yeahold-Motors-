<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT full_name, email, phone, profile_picture, bio FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
if (!$user) { session_destroy(); header('Location: login.php'); exit; }

$success = $error = '';
$upload_dir = 'uploads/avatars/';
$max_size = 2 * 1024 * 1024;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = trim($_POST['bio'] ?? '');
    $stmt_bio = $pdo->prepare("UPDATE users SET bio = ? WHERE id = ?");
    $stmt_bio->execute([$bio, $user_id]);
    if (!empty($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['profile_picture'];
        $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','webp'];
        if (!in_array($ext, $allowed)) {
            $error = "Allowed: JPG, JPEG, PNG, WEBP";
        } elseif ($file['size'] > $max_size) {
            $error = "File too large (max 2 MB)";
        } else {
            $new_name = 'avatar_' . $user_id . '_' . time() . '.' . $ext;
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            if (move_uploaded_file($file['tmp_name'], $upload_dir . $new_name)) {
                $pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?")->execute([$new_name, $user_id]);
                $success = "Profile updated successfully!";
            } else { $error = "Failed to save image. Check folder permissions."; }
        }
    } elseif (empty($error)) { $success = "Bio updated successfully!"; }
    $stmt->execute([$user_id]); $user = $stmt->fetch();
}

$avatar_path = !empty($user['profile_picture']) && file_exists($upload_dir . $user['profile_picture'])
    ? $upload_dir . htmlspecialchars($user['profile_picture'])
    : 'https://ui-avatars.com/api/?name=' . urlencode($user['full_name']) . '&background=c9a84c&color=0a0b0d&size=200&bold=true';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile — YEAHOLD MOTORS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="ym-page">
    <div class="ym-edit-page">
        <div class="ym-edit-card">
            <div class="ym-edit-card__header">
                <h2><i class="fas fa-pen" style="color:var(--gold);margin-right:0.5rem;"></i> Edit Profile</h2>
                <p style="color:var(--text2);font-size:0.88rem;margin-top:0.3rem;">Update your photo and bio</p>
            </div>
            <div class="ym-edit-card__body">

                <?php if ($success): ?>
                <div class="ym-alert ym-alert-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                <div class="ym-alert ym-alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">

                    <!-- AVATAR PREVIEW -->
                    <div class="ym-avatar-preview-wrap">
                        <img src="<?= $avatar_path ?>" class="ym-avatar-preview" alt="Current profile picture" id="avatarPreview">
                        <p style="font-size:0.83rem;color:var(--text3);"><?= htmlspecialchars($user['full_name']) ?></p>
                    </div>

                    <!-- FILE UPLOAD -->
                    <div class="ym-form-group">
                        <label>Profile Picture</label>
                        <div class="ym-file-drop" id="fileDrop">
                            <input type="file" name="profile_picture" id="fileInput" accept="image/jpeg,image/png,image/webp">
                            <label for="fileInput">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span id="fileLabel">Click to upload or drag & drop &nbsp;·&nbsp; JPG, PNG, WEBP &nbsp;·&nbsp; max 2MB</span>
                            </label>
                        </div>
                    </div>

                    <!-- BIO -->
                    <div class="ym-form-group">
                        <label>About Me</label>
                        <textarea name="bio" class="ym-form-control" rows="6" placeholder="Tell others about yourself..."><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="ym-btn ym-btn-gold ym-btn-full ym-btn-lg">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </form>

                <div style="text-align:center;margin-top:1.5rem;">
                    <a href="dashboard.php" class="ym-btn ym-btn-outline"><i class="fas fa-arrow-left"></i> Back to Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Live image preview
document.getElementById('fileInput').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    document.getElementById('fileLabel').textContent = file.name;
    const reader = new FileReader();
    reader.onload = e => document.getElementById('avatarPreview').src = e.target.result;
    reader.readAsDataURL(file);
});
// Drag & drop highlight
const drop = document.getElementById('fileDrop');
drop.addEventListener('dragover', e => { e.preventDefault(); drop.style.borderColor='var(--gold)'; });
drop.addEventListener('dragleave', () => drop.style.borderColor='');
drop.addEventListener('drop', e => {
    e.preventDefault(); drop.style.borderColor='';
    const file = e.dataTransfer.files[0];
    if (!file) return;
    document.getElementById('fileInput').files = e.dataTransfer.files;
    document.getElementById('fileLabel').textContent = file.name;
    const reader = new FileReader();
    reader.onload = ev => document.getElementById('avatarPreview').src = ev.target.result;
    reader.readAsDataURL(file);
});
</script>
</body>
</html>
