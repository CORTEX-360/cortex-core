<?php
// api/process.php

// 1. BLINDAGEM: Impede que erros do PHP (Warnings/Notices) sujem o JSON
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Define que a resposta será SEMPRE JSON
header('Content-Type: application/json');

try {
    // Diretórios
    $baseDir = '/www/wwwroot/cortex360.com.br'; 
    $uploadDir = $baseDir . '/uploads/';
    $engineDir = $baseDir . '/engines/';

    // Verifica se diretórios existem e são graváveis
    if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
        throw new Exception("Erro de Permissão: O PHP não consegue escrever em '$uploadDir'. Rode 'chmod 777' nesta pasta.");
    }

    $response = ['status' => 'error', 'message' => 'Erro desconhecido.'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Validação de Upload
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $phpFileUploadErrors = [
                0 => 'There is no error, the file uploaded with success',
                1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
                2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
                3 => 'The uploaded file was only partially uploaded',
                4 => 'No file was uploaded',
                6 => 'Missing a temporary folder',
                7 => 'Failed to write file to disk.',
                8 => 'A PHP extension stopped the file upload.',
            ];
            $errorCode = $_FILES['file']['error'] ?? 4;
            throw new Exception("Erro no Upload (Código $errorCode): " . ($phpFileUploadErrors[$errorCode] ?? 'Erro desconhecido'));
        }

        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['file']['name']);
        $uniqueName = uniqid() . '_' . $fileName;
        $destPath = $uploadDir . $uniqueName;

        // Move o arquivo
        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            throw new Exception("Falha ao mover arquivo. Verifique permissões da pasta uploads.");
        }
            
        $toolType = $_POST['tool_type'] ?? '';
        $cmdOutput = '';
        $cmdReturnVar = 0;

        // --- MOTOR PDF ---
        if ($toolType === 'pdf_splitter') {
            $pages = escapeshellarg($_POST['pages'] ?? '1');
            $outputFile = $uploadDir . 'split_' . $uniqueName;
            
            // Verifica se o Python existe
            $pythonCmd = shell_exec('which python3');
            if(empty($pythonCmd)) throw new Exception("Python3 não encontrado no path do servidor.");

            $cmd = "python3 " . $engineDir . "pdf_splitter.py " . escapeshellarg($destPath) . " " . escapeshellarg($outputFile) . " " . $pages;
            
            // Executa e captura STDERR também
            exec($cmd . " 2>&1", $cmdOutput, $cmdReturnVar);
            
        // --- MOTOR CONVERSOR ---
        } elseif ($toolType === 'converter') {
            $targetFormat = escapeshellarg($_POST['target_format'] ?? 'txt');
            
            $cmd = "python3 " . $engineDir . "universal_converter.py " . escapeshellarg($destPath) . " " . escapeshellarg($uploadDir) . " " . $targetFormat;
            
            exec($cmd . " 2>&1", $cmdOutput, $cmdReturnVar);
            
        } else {
            throw new Exception("Ferramenta não identificada: " . $toolType);
        }

        // Processa a saída do Python
        $fullOutput = implode("\n", $cmdOutput);
        $jsonOutput = json_decode($fullOutput, true);

        if (json_last_error() === JSON_ERROR_NONE && isset($jsonOutput['status'])) {
            // Sucesso: Python retornou JSON válido
            $response = $jsonOutput;
        } else {
            // Falha: Python retornou erro ou texto puro (Debug)
            // Se o arquivo de destino existir apesar do erro de JSON, tenta recuperar (caso o print tenha falhado)
            $response = [
                'status' => 'error',
                'message' => 'Erro no Motor Python (Raw Output): ' . $fullOutput,
                'debug_cmd' => $cmd
            ];
        }

    }

} catch (Exception $e) {
    // Captura qualquer exceção PHP e devolve como JSON limpo
    $response = [
        'status' => 'error',
        'message' => 'System Error: ' . $e->getMessage()
    ];
}

echo json_encode($response);
exit;
?>