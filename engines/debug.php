<?php
// api/debug.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>🔍 Diagnóstico do Servidor (CORTEX 360)</h1>";

// 1. Quem é o usuário?
$user = get_current_user();
$exec_user = exec('whoami');
echo "<p><b>Usuário PHP:</b> $user</p>";
echo "<p><b>Usuário Exec:</b> $exec_user</p>";

// 2. Teste de Funções Bloqueadas
echo "<h3>1. Teste de Funções do Sistema</h3>";
if (function_exists('shell_exec')) {
    echo "<p style='color:green'>✅ shell_exec está HABILITADO.</p>";
} else {
    echo "<p style='color:red'>❌ shell_exec está DESABILITADO (Bloqueio do aaPanel).</p>";
}

// 3. Teste do Python
echo "<h3>2. Versão do Python</h3>";
$pythonVersion = shell_exec('python3 --version 2>&1');
if ($pythonVersion) {
    echo "<p style='color:green'>✅ Python encontrado: $pythonVersion</p>";
} else {
    // Tenta caminho absoluto
    $pythonPathAbs = shell_exec('/usr/bin/python3 --version 2>&1');
    if ($pythonPathAbs) {
        echo "<p style='color:orange'>⚠️ 'python3' direto falhou, mas '/usr/bin/python3' funcionou: $pythonPathAbs</p>";
    } else {
        echo "<p style='color:red'>❌ O PHP não consegue chamar o Python. Verifique permissões.</p>";
    }
}

// 4. Teste de Permissão de Escrita
echo "<h3>3. Permissões de Pasta</h3>";
$uploadDir = '../uploads/';
if (is_writable($uploadDir)) {
    echo "<p style='color:green'>✅ Pasta /uploads é gravável.</p>";
} else {
    echo "<p style='color:red'>❌ Pasta /uploads NÃO é gravável. Execute chown www:www.</p>";
}

// 5. Teste da Engine
echo "<h3>4. Checagem do Script Python</h3>";
$enginePath = '../engines/pdf_splitter.py';
if (file_exists($enginePath)) {
    echo "<p>Arquivo encontrado.</p>";
    $perms = substr(sprintf('%o', fileperms($enginePath)), -4);
    echo "<p>Permissões: $perms (Precisa ser 0755 ou +x)</p>";
    
    // Tenta rodar a engine sem argumentos para ver se ela responde (deve dar erro de args, mas responde)
    $testOutput = shell_exec("python3 $enginePath 2>&1");
    echo "<pre style='background:#eee; padding:10px'>Output do Teste:\n$testOutput</pre>";
} else {
    echo "<p style='color:red'>❌ Arquivo engines/pdf_splitter.py NÃO encontrado.</p>";
}
?>