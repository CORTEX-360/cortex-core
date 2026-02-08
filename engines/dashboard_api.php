<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

// Filtro de Tempo (Padrão: 24h)
$range = $_GET['range'] ?? '24h';
$intervalSQL = "INTERVAL 24 HOUR";

switch($range) {
    case '1h': $intervalSQL = "INTERVAL 1 HOUR"; break;
    case '7d': $intervalSQL = "INTERVAL 7 DAY"; break;
    default:   $intervalSQL = "INTERVAL 24 HOUR"; break;
}

try {
    $response = [];

    // --- 1. KPIs GERAIS ---
    $stmt = $pdo->query("
        SELECT 
            COUNT(*) as total_hits,
            COUNT(DISTINCT ip_address) as unique_visitors,
            SUM(CASE WHEN status_code >= 400 THEN 1 ELSE 0 END) as errors
        FROM access_logs 
        WHERE log_time >= NOW() - $intervalSQL
    ");
    $kpis = $stmt->fetch();
    
    // Cálculo de Tendência (Fake por enquanto, ou comparativo real se quiser complexidade)
    $response['kpis'] = [
        'total_hits' => $kpis['total_hits'],
        'unique_visitors' => $kpis['unique_visitors'],
        'errors' => $kpis['errors'],
        // Taxa de Erro %
        'error_rate' => $kpis['total_hits'] > 0 ? round(($kpis['errors'] / $kpis['total_hits']) * 100, 2) : 0
    ];

    // --- 2. TIMELINE (Gráfico de Linha) ---
    // Agrupa por Hora (se 24h) ou Dia (se 7d)
    $dateFormat = ($range === '7d') ? '%Y-%m-%d' : '%H:00';
    
    $stmt = $pdo->query("
        SELECT 
            DATE_FORMAT(log_time, '$dateFormat') as time_label,
            COUNT(*) as count
        FROM access_logs
        WHERE log_time >= NOW() - $intervalSQL
        GROUP BY time_label
        ORDER BY time_label ASC
    ");
    $response['timeline'] = $stmt->fetchAll();

    // --- 3. TECH STACK (Browsers via User Agent) ---
    // Classificação simples via SQL
    $stmt = $pdo->query("
        SELECT 
            CASE 
                WHEN user_agent LIKE '%Chrome%' THEN 'Chrome'
                WHEN user_agent LIKE '%Firefox%' THEN 'Firefox'
                WHEN user_agent LIKE '%Safari%' AND user_agent NOT LIKE '%Chrome%' THEN 'Safari'
                WHEN user_agent LIKE '%Edg%' THEN 'Edge'
                WHEN user_agent LIKE '%bot%' OR user_agent LIKE '%crawl%' OR user_agent LIKE '%slurp%' THEN 'Bots/Crawlers'
                WHEN user_agent LIKE '%Python%' OR user_agent LIKE '%curl%' THEN 'Scripts/API'
                ELSE 'Outros'
            END as browser,
            COUNT(*) as value
        FROM access_logs
        WHERE log_time >= NOW() - $intervalSQL
        GROUP BY browser
        ORDER BY value DESC
        LIMIT 5
    ");
    $response['tech_stack'] = $stmt->fetchAll();

    // --- 4. LIVE LOGS (Tabela Terminal) ---
    $stmt = $pdo->query("
        SELECT log_time, method, ip_address, url_path, user_agent, status_code
        FROM access_logs
        ORDER BY log_time DESC
        LIMIT 50
    ");
    $response['recent_logs'] = $stmt->fetchAll();

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>