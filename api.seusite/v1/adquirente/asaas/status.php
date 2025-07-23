<?php
include 'asaas_functions.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? ($_POST['id'] ?? null);
if (!$id) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'ID da transação não informado']);
    exit;
}
$payment = asaasRequest("payments/$id", 'GET');
if (empty($payment['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Cobrança não encontrada', 'asaas' => $payment]);
    exit;
}
$response = [
    'status' => 'success',
    'idTransaction' => $payment['id'],
    'paymentStatus' => $payment['status'],
    'asaas' => $payment
];
echo json_encode($response); 