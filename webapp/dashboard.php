<?php
session_start();

// ❌ RANJIVOST: Provjera samo po cookie-u, nije stroga
if (!isset($_SESSION['user_id']) && !isset($_COOKIE['session_user'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'] ?? $_COOKIE['session_user'] ?? 'Nepoznat';
$balance  = $_SESSION['balance']  ?? $_COOKIE['user_balance'] ?? '0.00';
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>MyBank – Dashboard</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, sans-serif; background: #f5f5f5; }
        .nav { background: white; border-bottom: 1px solid #e0e0e0; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .nav .logo { font-size: 18px; font-weight: 600; }
        .nav .logo span { color: #1a56db; }
        .nav a { font-size: 13px; color: #666; text-decoration: none; }
        .main { max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        .welcome { font-size: 22px; font-weight: 500; margin-bottom: 1.5rem; }
        .cards { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem; }
        .card { background: white; border-radius: 10px; padding: 1.5rem; border: 1px solid #e0e0e0; }
        .card-label { font-size: 12px; color: #888; margin-bottom: 6px; }
        .card-value { font-size: 28px; font-weight: 500; }
        .card-value.money { color: #16a34a; }
        .actions { display: flex; gap: 10px; }
        .btn { padding: 10px 20px; border-radius: 8px; font-size: 14px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #1a56db; color: white; border: none; }
        .btn-outline { background: white; color: #333; border: 1px solid #d0d0d0; }
        .session-info { background: #fef9c3; border: 1px solid #fde68a; border-radius: 8px; padding: 1rem; margin-top: 2rem; font-size: 12px; color: #713f12; }
        .session-info code { background: #fef3c7; padding: 2px 4px; border-radius: 3px; font-family: monospace; }
    </style>
</head>
<body>
<nav class="nav">
    <div class="logo">My<span>Bank</span></div>
    <a href="logout.php">Odjava</a>
</nav>
<div class="main">
    <div class="welcome">Dobro došli, <?= htmlspecialchars($username) ?></div>

    <div class="cards">
        <div class="card">
            <div class="card-label">Stanje računa</div>
            <div class="card-value money">€<?= number_format((float)$balance, 2) ?></div>
        </div>
        <div class="card">
            <div class="card-label">Session ID</div>
            <div class="card-value" style="font-size:14px;font-family:monospace;word-break:break-all"><?= session_id() ?></div>
        </div>
    </div>

    <div class="actions">
        <a href="transfer.php" class="btn btn-primary">Uplata / Isplata</a>
        <a href="logout.php" class="btn btn-outline">Odjava</a>
    </div>

    <!-- ❌ RANJIVOST: Session detalji vidljivi u HTML-u (za demo) -->
    <div class="session-info">
        <strong>Debug info (namjerno izloženo):</strong><br>
        Session ID: <code><?= session_id() ?></code><br>
        Cookie: <code>session_user=<?= $_COOKIE['session_user'] ?? 'nije postavljen' ?></code><br>
        Balance cookie: <code>user_balance=<?= $_COOKIE['user_balance'] ?? 'nije postavljen' ?></code>
    </div>
</div>
</body>
</html>