<?php
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'] ?? 0;
    $to     = $_POST['to'] ?? '';
    // ❌ RANJIVOST: Nema CSRF tokena, nema validacije
    $message = "Preneseno €{$amount} na {$to}. (Demo — ni resnično)";
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>MyBank – Prenos</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, sans-serif; background: #f5f5f5; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .card { background: white; border-radius: 12px; padding: 2rem; width: 380px; border: 1px solid #e0e0e0; }
        h2 { font-size: 18px; font-weight: 500; margin-bottom: 1.5rem; }
        label { display: block; font-size: 13px; color: #444; margin-bottom: 5px; }
        input { width: 100%; padding: 10px 12px; border: 1px solid #d0d0d0; border-radius: 8px; font-size: 14px; margin-bottom: 1rem; }
        button { width: 100%; padding: 11px; background: #1a56db; color: white; border: none; border-radius: 8px; font-size: 14px; cursor: pointer; }
        .msg { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; border-radius: 8px; padding: 10px 12px; margin-bottom: 1rem; font-size: 13px; }
        a { display: block; text-align: center; margin-top: 1rem; font-size: 13px; color: #1a56db; text-decoration: none; }
    </style>
</head>
<body>
<div class="card">
    <h2>Nova transakcija</h2>
    <?php if ($message): ?><div class="msg"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <form method="POST">
        <label>Prejemnik (IBAN ali ime)</label>
        <input type="text" name="to" placeholder="SI56 3456 7890 1234 567">
        <label>Znesek (€)</label>
        <input type="number" name="amount" step="0.01" min="0" placeholder="0.00">
        <button type="submit">Pošlji</button>
    </form>
    <a href="dashboard.php">← Nazaj</a>
</div>
</body>
</html>