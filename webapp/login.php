<?php
// ❌ RANJIVOST 1: Nema session_regenerate_id()
// ❌ RANJIVOST 2: Cookie bez Secure i HttpOnly
session_start();

require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    $db = db();
    // ❌ RANJIVOST: SQL injection moguć (namjerno)
    $result = $db->query("SELECT * FROM users WHERE username='$user' AND password='$pass'");

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // ❌ RANJIVOST: Session ID se ne regenerira
        $_SESSION['user_id']  = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['balance']  = $row['balance'];

        setcookie('session_user', $row['username'], [
            'expires'  => time() + 86400,
            'path'     => '/',
            'secure'   => false,   // ❌ radi na HTTP
            'httponly' => false,   // ❌ JS može čitati
            'samesite' => 'None',  // ❌ nema zaštite
        ]);

        setcookie('user_balance', $row['balance'], time() + 86400, '/');

        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Napačni podatki.';
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>MyBank – Prijava</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, sans-serif; background: #f5f5f5; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .card { background: white; border-radius: 12px; padding: 2.5rem; width: 360px; border: 1px solid #e0e0e0; }
        .logo { font-size: 20px; font-weight: 600; margin-bottom: 6px; }
        .logo span { color: #1a56db; }
        .subtitle { font-size: 13px; color: #666; margin-bottom: 2rem; }
        label { display: block; font-size: 13px; color: #333; margin-bottom: 5px; }
        input { width: 100%; padding: 10px 12px; border: 1px solid #d0d0d0; border-radius: 8px; font-size: 14px; margin-bottom: 1rem; outline: none; }
        input:focus { border-color: #1a56db; }
        button { width: 100%; padding: 11px; background: #1a56db; color: white; border: none; border-radius: 8px; font-size: 14px; cursor: pointer; }
        button:hover { background: #1448b8; }
        .error { background: #fef2f2; color: #b91c1c; font-size: 13px; padding: 10px 12px; border-radius: 8px; margin-bottom: 1rem; }
        .warning { background: #fffbeb; border: 1px solid #fcd34d; color: #92400e; font-size: 11px; padding: 8px 12px; border-radius: 8px; margin-top: 1.5rem; text-align: center; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">My<span>Bank</span></div>
    <div class="subtitle">Prijavite se v vaš račun</div>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label>Uporabniško ime</label>
        <input type="text" name="username" placeholder="npr. alice" autocomplete="off">

        <label>Geslo</label>
        <input type="password" name="password">

        <button type="submit">Prijava</button>
    </form>

    <div class="warning">
        ⚠ HTTP povezava — podatki se prenašajo nešifrirani
    </div>
</div>
</body>
</html>