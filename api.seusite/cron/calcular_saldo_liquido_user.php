<?php
// Incluir o arquivo de conexão
include '../conectarbanco.php';

// Criar a conexão usando as credenciais fornecidas no arquivo incluído
$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Array para armazenar os logs de saldos atualizados
$logsAtualizacao = [];

// Consulta para pegar todos os user_ids da tabela users
$sqlUsers = "SELECT user_id FROM users"; // Alterado para pegar a coluna user_id
$resultUsers = $conn->query($sqlUsers);

// Verificar se encontrou usuários
if ($resultUsers->num_rows > 0) {
    while ($rowUser = $resultUsers->fetch_assoc()) {
        $user_id2 = $rowUser['user_id']; // Pegar o user_id corretamente

        // Inicializar variáveis
        $sumDepositoLiquido = 0;
        $sumSaquesAprovados = 0;

        // Consultar a soma dos depósitos líquidos para o user_id
        $sqlSumDepositoLiquido = "SELECT COALESCE(SUM(deposito_liquido), 0) AS sumDepositoLiquido FROM solicitacoes WHERE user_id = ? AND status = 'PAID_OUT'";
        $stmtSumDepositoLiquido = $conn->prepare($sqlSumDepositoLiquido);
        $stmtSumDepositoLiquido->bind_param("s", $user_id2);
        $stmtSumDepositoLiquido->execute();
        $stmtSumDepositoLiquido->bind_result($sumDepositoLiquido);
        $stmtSumDepositoLiquido->fetch();
        $stmtSumDepositoLiquido->close();

        // Consultar a soma dos saques aprovados
        $sqlSumSaquesAprovados = "SELECT COALESCE(SUM(amount), 0) AS sumSaquesAprovados FROM solicitacoes_cash_out WHERE user_id = ? AND status = 'COMPLETED'";
        $stmtSumSaquesAprovados = $conn->prepare($sqlSumSaquesAprovados);
        $stmtSumSaquesAprovados->bind_param("s", $user_id2);
        $stmtSumSaquesAprovados->execute();
        $stmtSumSaquesAprovados->bind_result($sumSaquesAprovados);
        $stmtSumSaquesAprovados->fetch();
        $stmtSumSaquesAprovados->close();

        // Calcular o saldo líquido
        $saldoLiquido = $sumDepositoLiquido - $sumSaquesAprovados;

        // Atualizar o saldo na tabela users
        $sqlUpdateSaldo = "UPDATE users SET saldo = ? WHERE user_id = ?"; // Usando user_id corretamente
        $stmtUpdateSaldo = $conn->prepare($sqlUpdateSaldo);
        $stmtUpdateSaldo->bind_param("ds", $saldoLiquido, $user_id2);
        $stmtUpdateSaldo->execute();
        $stmtUpdateSaldo->close();

        // Adicionar o log da atualização
        $logsAtualizacao[] = "User ID: $user_id2, Saldo Atualizado: $saldoLiquido";
    }
} else {
    echo "Nenhum usuário encontrado.";
}

// Fechar a conexão
$conn->close();

// Exibir os logs de atualização
if (!empty($logsAtualizacao)) {
    echo "Logs de Atualizações de Saldos:<br>";
    foreach ($logsAtualizacao as $log) {
        echo $log . "<br>";
    }
} else {
    echo "Nenhuma atualização de saldo foi realizada.";
}

echo "Cálculo de saldo concluído.";
?>
