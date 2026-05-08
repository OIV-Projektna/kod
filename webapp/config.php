<?php
// nezaštićena konfiguracija
define('DB_PATH', getenv('DB_PATH') ?: __DIR__ . '/data/bankapp.sqlite');

function db() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $dbDir = dirname(DB_PATH);
    if (!is_dir($dbDir)) {
        mkdir($dbDir, 0775, true);
    }

    $isNew = !file_exists(DB_PATH);

    $pdo = new PDO('sqlite:' . DB_PATH);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($isNew || !sqlite_has_users_table($pdo)) {
        sqlite_init_from_seed($pdo);
    }

    return $pdo;
}

function sqlite_has_users_table(PDO $pdo): bool {
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");
    return (bool) $stmt->fetchColumn();
}

function sqlite_init_from_seed(PDO $pdo): void {
    $seedPath = __DIR__ . '/init.sql';
    if (!file_exists($seedPath)) {
        $seedPath = __DIR__ . '/../db/init.sql';
    }

    $sql = file_get_contents($seedPath);
    if ($sql === false) {
        throw new RuntimeException('Seed SQL file not found.');
    }

    $sql = preg_replace('/INT\s+AUTO_INCREMENT\s+PRIMARY\s+KEY/i', 'INTEGER PRIMARY KEY AUTOINCREMENT', $sql);

    $statements = array_filter(array_map('trim', explode(';', $sql)));
    foreach ($statements as $statement) {
        $pdo->exec($statement);
    }
}
?>