<?php
// api/get_metrics.php
header('Content-Type: application/json');

// 1. Configuração de Conexão (aaPanel / MySQL)
$host = '72.60.244.132';
$db   = 'cortex360';
$user = 'cortex360'; // Altere para seu usuário do banco
$pass = 'Cortex360Vini';   // Altere para sua senha do banco

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Cálculo dos KPIs Principais
    // Total de requisições
    $totalReq = $pdo->query("SELECT COUNT(*) FROM access_logs")->fetchColumn();
    
    // Taxa de Erro (Status >= 500)
    $errorCount = $pdo->query("SELECT COUNT(*) FROM access_logs WHERE status_code >= 500")->fetchColumn();
    $errorRate = ($totalReq > 0) ? round(($errorCount / $totalReq) * 100, 2) : 0;
    
    // Payload Médio (Bytes para KB)
    $avgPayload = $pdo->query("SELECT AVG(bytes_sent) FROM access_logs")->fetchColumn();
    $avgPayloadKb = ($avgPayload) ? round($avgPayload / 1024, 2) : 0;

    // 3. Dados para os Gráficos (Agrupamentos)
    // Distribuição de Status HTTP
    $stmtStatus = $pdo->query("SELECT status_code as label, COUNT(*) as value FROM access_logs GROUP BY status_code ORDER BY value DESC");
    $statusDist = $stmtStatus->fetchAll(PDO::FETCH_ASSOC);

    // Top Endpoints (Top 5 mais acessados)
    $stmtEndpoints = $pdo->query("SELECT url_path as label, COUNT(*) as value FROM access_logs GROUP BY url_path ORDER BY value DESC LIMIT 5");
    $topEndpoints = $stmtEndpoints->fetchAll(PDO::FETCH_ASSOC);

    // 4. Resposta JSON Final
    echo json_encode([
        'status' => 'success',
        'kpis' => [
            'total_requests' => (int)$totalReq,
            'error_rate' => (string)$errorRate,
            'avg_payload_kb' => (string)$avgPayloadKb
        ],
        'charts' => [
            'status_distribution' => $statusDist,
            'top_endpoints' => $topEndpoints
        ],
        'server_info' => [
            'timestamp' => date('d/m/Y H:i:s'),
            'ip' => '72.60.244.132'
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'DB Fail: ' . $e->getMessage()
    ]);
}