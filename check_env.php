<?php
// check_env.php
header('Content-Type: text/plain');

echo "=== DIAGNÓSTICO DE AMBIENTE CORTEX 360 ===\n\n";

// 1. Verifica Usuário e Permissões
$user = get_current_user();
$processUser = exec('whoami');
echo "1. Usuário do Processo: " . $processUser . "\n";

$dirs = ['uploads', 'engines'];
foreach ($dirs as $dir) {
    if (is_dir($dir)) {
        $perms = substr(sprintf('%o', fileperms($dir)), -4);
        $writable = is_writable($dir) ? "OK (Gravável)" : "ERRO (Não gravável)";
        echo "   - Pasta '$dir': $writable [Perm: $perms]\n";
    } else {
        echo "   - Pasta '$dir': NÃO ENCONTRADA (Crie esta pasta)\n";
    }
}

echo "\n2. Verifica Funções de Sistema (aaPanel Security)\n";
$functions = ['exec', 'shell_exec', 'system'];
foreach ($functions as $func) {
    if (function_exists($func)) {
        echo "   - Função '$func': HABILITADA\n";
    } else {
        echo "   - Função '$func': BLOQUEADA (Remova em 'Disabled Functions')\n";
    }
}

echo "\n3. Verifica Python\n";
// Tenta rodar Python simples
$pythonVersion = shell_exec('python3 --version 2>&1');
if ($pythonVersion) {
    echo "   - Python Detectado: " . trim($pythonVersion) . "\n";
    
    // Verifica bibliotecas
    echo "   - Bibliotecas instaladas:\n";
    $libs = shell_exec('pip3 list 2>&1');
    echo $libs;
} else {
    echo "   - Python: NÃO DETECTADO ou shell_exec falhou.\n";
}

echo "\n=== FIM DO RELATÓRIO ===";
?>