<?php
include 'asaas_functions.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['name'], $data['cpf'], $data['amount'], $data['creditCard'])) {
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
// Criar cobrança CARTÃO
$payment = asaasRequest('payments', 'POST', [
    'customer' => $customer['id'],
    'billingType' => 'CREDIT_CARD',
    'value' => floatval($data['amount']),
    'creditCard' => $data['creditCard'],
    'creditCardHolderInfo' => $data['creditCardHolderInfo'] ?? [],
]);
if (empty($payment['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao criar cobrança cartão', 'asaas' => $payment]);
    exit;
}
$response = [
    'status' => 'success',
    'idTransaction' => $payment['id'],
    'asaas' => $payment
];
echo json_encode($response); 