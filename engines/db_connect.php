<?php
// Configurações de Banco (Produção)
$host = '127.0.0.1';
$db   = 'cortex360';
$user = 'cortex360';
$pass = 'Cortex360Vini';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Retorna erro JSON se falhar (para o dashboard saber)
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Falha na conexão com BD: ' . $e->getMessage()]);
    exit;
}
?>