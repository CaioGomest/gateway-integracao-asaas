<?php
require 'asaas_functions.php'; // contém asaasRequest()

header('Content-Type: application/json');

// Lê JSON
$input = file_get_contents('php://input');
$data  = json_decode($input, true);

// Segurança básica contra JSON inválido
if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'JSON inválido.']);
    exit;
}

// Define ação
$action = $data['action'] ?? 'create';

/**
 * --------------------------------------------------------
 * 1) CONSULTAR QR CODE PIX (sem recriar cobrança)
 * --------------------------------------------------------
 */
if ($action === 'pix_qrcode') 
{
    if (empty($data['idTransaction'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'idTransaction obrigatório para pix_qrcode.']);
        exit;
    }

    $paymentId = $data['idTransaction'];

    // Conforme docs Asaas: GET /payments/{id}/pixQrCode
    $pixResp = asaasRequest("payments/{$paymentId}/pixQrCode", 'GET');

    // Monta resposta padronizada
    echo json_encode([
        'status'       => isset($pixResp['encodedImage']) ? 'success' : 'error',
        'idTransaction'=> $paymentId,
        'tipo'         => 'PIX',
        'paymentCode'  => $pixResp['payload'] ?? null,
        'qrCodeImage'  => $pixResp['encodedImage'] ?? null,
        'asaas'        => $pixResp
    ]);
    exit;
}

/**
 * --------------------------------------------------------
 * 2) CRIAR COBRANÇA (fluxo padrão)
 * --------------------------------------------------------
 */

// Valida campos mínimos
$required = ['name','cpf','amount','tipoPagamento'];
foreach ($required as $r) {
    if (!isset($data[$r]) || $data[$r] === '') {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => "Campo obrigatório ausente: {$r}"]);
        exit;
    }
}

// Sanitiza CPF/CNPJ (remove máscara)
$cpfCnpj = preg_replace('/\D+/', '', $data['cpf']);

// Valor numérico (troca vírgula por ponto caso venha em formato brasileiro)
$valor = str_replace(['.', ','], ['', '.'], $data['amount']); // primeiro remove milhar, depois vírgula vira ponto
$valor = (float)$valor;

// Cria cliente
$customer = asaasRequest('customers', 'POST', [
    'name'    => $data['name'],
    'cpfCnpj' => $cpfCnpj,
    'email'   => $data['email'] ?? 'cliente@email.com',
]);

if (empty($customer['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao criar cliente', 'asaas' => $customer]);
    exit;
}

// Billing type
$tipo = strtoupper($data['tipoPagamento']); // PIX, BOLETO, CREDIT_CARD

$payload = [
    'customer'   => $customer['id'],
    'billingType'=> $tipo,
    'value'      => $valor,
    'dueDate'    => date('Y-m-d'), // pode ajustar
];

// Se cartão, anexar dados
if ($tipo === 'CREDIT_CARD') {
    if (empty($data['creditCard']) || empty($data['creditCardHolderInfo'])) {
        echo json_encode(['status' => 'error', 'message' => 'Dados do cartão ausentes']);
        exit;
    }

    // Garante que holderName está presente
    if (empty($data['creditCard']['holderName'])) {
        $data['creditCard']['holderName'] = $data['creditCardHolderInfo']['name'] ?? $data['name'];
    }

    $payload['creditCard']           = $data['creditCard'];
    $payload['creditCardHolderInfo'] = $data['creditCardHolderInfo'];
}


// Cria cobrança
$payment = asaasRequest('payments', 'POST', $payload);

if (empty($payment['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao criar cobrança', 'asaas' => $payment]);
    exit;
}

$response = [
    'status'        => 'success',
    'idTransaction' => $payment['id'],
    'tipo'          => $tipo,
    'asaas'         => $payment
];

// Dados extras conforme tipo
if ($tipo === 'PIX') {
    // Alguns retornos já vêm embutidos no objeto $payment
    $response['paymentCode'] = $payment['pix']['payload']       ?? null;
    $response['qrCodeImage'] = $payment['pix']['encodedImage']  ?? null;

    // (Opcional) Se não vier, podemos chamar o endpoint pixQrCode agora:
    if (empty($response['qrCodeImage'])) {
        $pixResp = asaasRequest("payments/{$payment['id']}/pixQrCode", 'GET');
        $response['paymentCode'] = $response['paymentCode'] ?: ($pixResp['payload'] ?? null);
        $response['qrCodeImage'] = $response['qrCodeImage'] ?: ($pixResp['encodedImage'] ?? null);
        $response['asaas_pix']   = $pixResp;
    }
}

if ($tipo === 'BOLETO') {
    $response['boletoUrl'] = $payment['bankSlipUrl'] ?? null;
}

echo json_encode($response);
