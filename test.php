<?php
// 1. Inicia a sessão se ela ainda não existir, mas sem torná-la obrigatória
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Coleta de dados básicos (IP e Domínio)
// Tratamos o IP considerando possíveis proxies/load balancers do Nginx
$ip_acesso = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$dominio_acessado = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'];
$uri_acessada = $_SERVER['REQUEST_URI'] ?? '';

// 3. Coleta de dados de sessão (de forma condicional)
$dados_sessao = !empty($_SESSION) ? $_SESSION : null;

// 4. Montagem do Payload JSON
$payload_data = [
    'metrica' => [
        'ip' => $ip_acesso,
        'dominio' => $dominio_acessado,
        'path' => $uri_acessada,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Desconhecido',
        'metodo' => $_SERVER['REQUEST_METHOD'],
        'timestamp' => date('Y-m-d H:i:s')
    ],
    // Se for null, o n8n receberá como null ou campo ausente conforme o json_encode
    'sessao' => $dados_sessao 
];

// 5. Envio para o Webhook do n8n
$webhook_url = 'https://n8n.gerenciamentocohidro.com.br/webhook-test/c149e3aa-ded6-4cf1-9e1d-7d423568ded1';

$ch = curl_init($webhook_url);
$json_payload = json_encode($payload_data);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($json_payload)
]);

// Timeout curto para não travar o carregamento do seu site principal
curl_setopt($ch, CURLOPT_TIMEOUT, 5); 

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

// Opcional: Log de depuração local se você estiver no Debian (ajuste o caminho se necessário)
// error_log("Métrica enviada: $http_code para o domínio $dominio_acessado");