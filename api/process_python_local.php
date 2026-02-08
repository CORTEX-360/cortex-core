<?php
// api/process_python_local.php
// BLINDAGEM DE ERRO: Desativa output de HTML de erros do PHP
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    // 1. Configurações de Pastas
    $baseDir = dirname(__DIR__); // /www/wwwroot/cortex360.com.br
    $uploadDir = $baseDir . '/uploads/';
    $enginePath = $baseDir . '/engines/pdf_splitter.py';

    // Validações Iniciais
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            throw new Exception("Não foi possível criar a pasta uploads.");
        }
    }

    if (!file_exists($enginePath)) {
        throw new Exception("Engine Python não encontrada em: $enginePath");
    }

    // Verifica se shell_exec está habilitado no PHP
    if (!function_exists('shell_exec')) {
        throw new Exception("A função shell_exec está desativada no PHP. Verifique o php.ini");
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método inválido. Use POST.");
    }

    // 2. Upload
    if (!isset($_FILES['file']) || !isset($_POST['ranges'])) {
        throw new Exception("Arquivo ou Ranges não enviados.");
    }

    $file = $_FILES['file'];
    $ranges = $_POST['ranges'];
    
    $uniqueId = uniqid('cortex_', true);
    $inputPdf = $uploadDir . $uniqueId . '.pdf';
    $outputZip = $uploadDir . $uniqueId . '.zip';

    if (!move_uploaded_file($file['tmp_name'], $inputPdf)) {
        throw new Exception("Falha ao mover arquivo enviado.");
    }

    // 3. Execução do Python
    // Atenção: Usamos 'python3' direto. Se falhar, tente '/usr/bin/python3'
    $command = "python3 " . escapeshellarg($enginePath) . " " . escapeshellarg($inputPdf) . " " . escapeshellarg($outputZip) . " " . escapeshellarg($ranges);
    
    // Redireciona stderr para stdout para capturarmos erros do Python também
    $output = shell_exec($command . " 2>&1");

    // 4. Parse do Resultado
    if (!$output) {
        throw new Exception("O script Python não retornou nada. Verifique permissões (chmod +x).");
    }

    $result = json_decode($output, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        // Se o Python devolveu erro bruto (não JSON), mostramos aqui
        throw new Exception("Erro Python (Raw): " . $output);
    }

    if (isset($result['status']) && $result['status'] === 'success') {
        echo json_encode([
            'status' => 'success',
            'download_url' => 'uploads/' . basename($outputZip),
            'debug_info' => 'Processado via Python Local'
        ]);
        // Limpeza (Opcional)
        @unlink($inputPdf);
    } else {
        throw new Exception($result['message'] ?? "Erro desconhecido na engine.");
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>