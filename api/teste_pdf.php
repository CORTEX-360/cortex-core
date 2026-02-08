<?php
// api/teste_pdf.php
// Objetivo: Simular o envio de um PDF para o n8n processar

// CONFIGURAÇÃO DO WEBHOOK (Ajuste com a URL do seu n8n Production/Test)
$webhook_url = "https://n8n.gerenciamentocohidro.com.br/webhook-test/split-pdf"; 

// ARQUIVO DE TESTE (Crie um pdf dummy chamado 'dummy.pdf' na mesma pasta para testar)
$filePath = __DIR__ . '/dummy.pdf';

if (!file_exists($filePath)) {
    die("❌ Erro: Crie um arquivo 'dummy.pdf' nesta pasta para testar.");
}

// DADOS DO FORMULÁRIO
$postFields = [
    'ranges' => '1-2,3-4', // Exemplo: Quero dois arquivos resultantes
    'file' => new CURLFile($filePath, 'application/pdf', 'documento_teste.pdf')
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $webhook_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executa
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "<h1>Teste de Integração n8n</h1>";
if ($httpCode >= 200 && $httpCode < 300) {
    echo "✅ <b>Sucesso!</b> n8n respondeu (Código $httpCode).<br>";
    echo "Resposta: <pre>" . htmlspecialchars($response) . "</pre>";
} else {
    echo "❌ <b>Erro!</b> (Código $httpCode)<br>";
    echo "Curl Error: $error<br>";
    echo "Response: <pre>$response</pre>";
}
?>