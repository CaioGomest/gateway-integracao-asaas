<?php
require_once __DIR__ . '/../adquirente/asaas/asaas_functions.php';
include_once __DIR__ . '/../../../conectarbanco.php';

header('Content-Type: application/json');

// Recebe o ID do pedido
$id = $_GET['id'] ?? ($_POST['id'] ?? null);
if (!$id) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'ID do pedido não informado']);
    exit;
}

// Conexão com o banco
$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Erro ao conectar no banco']);
    exit;
}

// Busca o pedido pelo ID e adquirente
$stmt = $conn->prepare("SELECT id, idtransaction, status FROM solicitacoes WHERE idtransaction = ? AND adquirente_ref = 'asaas' LIMIT 1");
$stmt->bind_param("s", $id);
$stmt->execute();
$res = $stmt->get_result();

// echo "SELECT id, idtransaction, status FROM solicitacoes WHERE idtransaction = {$id} AND adquirente_ref = 'asaas' LIMIT 1";

if ($res && $res->num_rows > 0) {
    $pedido = $res->fetch_assoc();
    $idtransaction = $pedido['idtransaction'];
    $status_banco = $pedido['status'];
    $id_pedido = $pedido['id'];

    // Verifica se existe ID da transação para consultar na Asaas
    if (!$idtransaction) {
        echo json_encode(['status' => 'error', 'message' => 'ID da transação não encontrado para este pedido.']);
        exit;
    }

    // Consulta a transação no Asaas
$asaas = asaasRequest("payments/{$id}", 'GET');


 

    if (!isset($asaas['status'])) {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao consultar status no Asaas', 'asaas_response' => $asaas]);
        exit;
    }

    $status_asaas = $asaas['status'];

    switch($status_asaas) {
        case 'PENDING':
            $status_asaas = "WAITING_FOR_APPROVAL";
            break;
      case 'CONFIRMED':
        case 'RECEIVED':
            $status_asaas = "PAID_OUT";
            break;
        default:
            echo "Status Desconhecido";
    }

    // exit;
    // Atualiza se o status estiver diferente

    if ($status_asaas != $status_banco) {
        $stmtUpdate = $conn->prepare("UPDATE solicitacoes SET status = ? WHERE id = ?");
        $stmtUpdate->bind_param("si", $status_asaas, $id_pedido);
        $stmtUpdate->execute();
        $stmtUpdate->close();



 print_r($status_asaas !== $status_banco);
 
 
        echo json_encode([
            'status' => 'updated',
            'id' => $id,
            'idtransaction' => $idtransaction,
            'old_status' => $status_banco,
            'new_status' => $status_asaas
        ]);
    } else {
        echo json_encode([
            'status' => 'no_change',
            'id' => $id,
            'idtransaction' => $idtransaction,
            'current_status' => $status_banco
        ]);
    }

} else {
    echo json_encode(['status' => 'empty', 'message' => 'Pedido não encontrado']);
}

$stmt->close();
$conn->close();
