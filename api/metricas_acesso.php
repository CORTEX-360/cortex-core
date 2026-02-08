<?php
// api/test_logs_n8n.php

// Configurações
$webhook_url = "https://n8n.gerenciamentocohidro.com.br/webhook/c149e3aa-ded6-4cf1-9e1d-7d423568ded1";

// Mock Data para Simulação
$methods = ['GET', 'POST', 'PUT', 'DELETE'];
$paths = ['/', '/api/data', '/dashboard', '/api/login', '/assets/style.css'];
$statuses = [200, 200, 200, 301, 404, 500];
$agents = [
    'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
    'Googlebot/2.1 (+http://www.google.com/bot.html)',
    'Python-urllib/3.9'
];

// Gerar um payload aleatório
$payload = [
    'ip_address' => '172.16.' . rand(1, 254) . '.' . rand(1, 254),
    'method'     => $methods[array_rand($methods)],
    'url_path'   => $paths[array_rand($paths)],
    'status_code'=> $statuses[array_rand($statuses)],
    'bytes_sent' => rand(500, 5000),
    'referer'    => '-',
    'user_agent' => $agents[array_rand($agents)],
    'timestamp'  => date('Y-m-d H:i:s')
];

// Enviar via CURL
$ch = curl_init($webhook_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
