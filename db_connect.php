<?php
/**
 * db_connect.php
 * ─────────────────────────────────────────────────
 * YEAHOLD MOTORS — Database Connection File
 * Milestone Requirement: Separate configuration file
 * that establishes the connection between the
 * server-side script and the database.
 * ─────────────────────────────────────────────────
 */

define('DB_HOST',   'localhost');
define('DB_NAME',   'trisha');
define('DB_USER',   'root');
define('DB_PASS',   '');       // ← Change if you set a MySQL password
define('DB_CHARSET','utf8mb4');

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $db  = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    // Show a friendly error — never expose raw exceptions in production
    die('
        <div style="font-family:sans-serif;background:#0a0b0d;color:#f1948a;
                    padding:2rem;border:1px solid rgba(231,76,60,0.3);
                    border-radius:12px;max-width:600px;margin:4rem auto;text-align:center;">
            <h2>&#10060; Database Connection Failed</h2>
            <p style="color:#8a9099;margin-top:0.5rem;">
                Could not connect to the database.<br>
                Check your credentials in <code>db_connect.php</code>.
            </p>
            <code style="display:block;margin-top:1rem;font-size:0.8rem;color:#f1948a;">
                ' . htmlspecialchars($e->getMessage()) . '
            </code>
        </div>
    ');
}
?>
