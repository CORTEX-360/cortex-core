<?php
// ARQUIVO: api/process_n8n_proxy.php
// OBJETIVO: Proxy reverso para o n8n (Evita CORS e expor portas internas)
// AUTOR: CORTEX 360 (Vinicius/Heraldo)

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// URL interna do Docker (n8n rodando na porta padrao 5678)
// Se falhar, tente o IP do host: http://72.60.244.132:5678/webhook/split-pdf
$n8n_url = "http://localhost:5678/webhook/split-pdf";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
    exit;
}

// Verifica se arquivo e ranges foram enviados
if (!isset($_FILES['file']) || !isset($_POST['ranges'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Faltam dados (arquivo ou ranges).']);
    exit;
}

// Prepara o envio para o n8n via CURL
$cFile = new CURLFile($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
$postData = [
    'file' => $cFile,
    'ranges' => $_POST['ranges']
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $n8n_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Timeout de seguranca para PDFs grandes
curl_setopt($ch, CURLOPT_TIMEOUT, 120); 

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

if (curl_errno($ch)) {
    echo json_encode(['status' => 'error', 'message' => 'Erro CURL: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}
curl_close($ch);

// Se o n8n retornar 200, assume-se que e o binario (ZIP)
if ($httpCode == 200) {
    // Repassa os headers corretos para o navegador baixar
    header("Content-Type: $contentType");
    header("Content-Disposition: attachment; filename=cortex_result.zip");
    echo $response;
} else {
    // Se der erro no n8n, repassa o erro
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Erro no Motor n8n', 'debug' => $response]);
}
?>
