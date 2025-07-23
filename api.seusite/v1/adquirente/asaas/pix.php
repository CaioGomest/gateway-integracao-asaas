<?php
include 'asaas_functions.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['name'], $data['cpf'], $data['amount'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Dados obrigatórios ausentes']);
    exit;
}

// Criar cliente (se necessário)
$customer = asaasRequest('customers', 'POST', [
    'name' => $data['name'],
    'cpfCnpj' => $data['cpf'],
    'email' => $data['email'] ?? 'cliente@email.com',
]);
if (empty($customer['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao criar cliente', 'asaas' => $customer]);
    exit;
}
// Criar cobrança PIX
$payment = asaasRequest('payments', 'POST', [
    'customer' => $customer['id'],
    'billingType' => 'PIX',
    'value' => floatval($data['amount']),
]);
if (empty($payment['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao criar cobrança PIX', 'asaas' => $payment]);
    exit;
}
// Retornar dados essenciais
$response = [
    'status' => 'success',
    'idTransaction' => $payment['id'],
    'paymentCode' => $payment['pix']['payload'] ?? null,
    'qrCodeImage' => $payment['pix']['encodedImage'] ?? null,
    'asaas' => $payment
];
echo json_encode($response); 