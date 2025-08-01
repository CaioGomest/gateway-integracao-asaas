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
$valor = str_replace(',', '.', $data['amount']); // só troca vírgula por ponto
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
$protocolo = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
$url_base = $protocolo . "://" . $_SERVER['HTTP_HOST'] . "/api.seusite/v1/webhook/asaas.php";

$payload = [
    'customer'   => $customer['id'],
    'billingType'=> $tipo,
    'value'      => $valor,
    'dueDate'    => date('Y-m-d'), // pode ajustar
    "callback"   => [
        "cancelUrl"   => $url_base,
        "expiredUrl"  => $url_base,
        "successUrl"  => $url_base
    ]
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

    // Adiciona cidade e estado se existirem
    if (!empty($data['creditCardHolderInfo']['city'])) {
        $data['creditCardHolderInfo']['city'] = $data['creditCardHolderInfo']['city'];
    }
    if (!empty($data['creditCardHolderInfo']['state'])) {
        $data['creditCardHolderInfo']['state'] = $data['creditCardHolderInfo']['state'];
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

// REGISTRA NO BANCO DE DADOS (tabela solicitacoes)
include_once '../../../../conectarbanco.php';

// Função de debug
function debug_log($msg) {
    file_put_contents(__DIR__ . '/debug_asaas.txt', date('Y-m-d H:i:s') . ' - ' . $msg . "\n", FILE_APPEND);
}

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);
if ($conn->connect_error) {
    debug_log('Erro ao conectar banco para registrar solicitacao: ' . $conn->connect_error);
} else {
    $user_id = $data['user_id'] ?? null;
    $externalreference = bin2hex(random_bytes(16));
    $amount = $valor;
    $client_name = $data['name'];
    $client_document = $cpfCnpj;
    $client_email = $data['email'] ?? '';
    $real_data = date('Y-m-d');
    $status = 'WAITING_FOR_APPROVAL';
    $qrcode_pix = $tipo === 'PIX' ? ($payment['pix']['payload'] ?? '') : '';
    $paymentcode = $tipo === 'PIX' ? ($payment['pix']['payload'] ?? '') : '';
    $idtransaction = $payment['id'];
    $paymentCodeBase64 = $tipo === 'PIX' && isset($payment['pix']['payload']) ? base64_encode($payment['pix']['payload']) : null;
    $adquirente_ref = 'asaas';
    $taxa_cash_in = 0.00; // Ajuste se necessário
    $tipo_transacao = $tipo;
    $desc_transacao = $tipo === 'PIX' ? 'Pagamento via Pix' : ($tipo === 'CREDIT_CARD' ? 'Pagamento via Cartão' : '');
    $deposito_liquido = $amount; // Ajuste se houver taxa
    $taxa_pix_cash_in_adquirente = 0.00;
    $taxa_pix_cash_in_valor_fixo = 0.00;
    $client_telefone = $data['telefone'] ?? null;
    $executor_ordem = null;
    $descricao_transacao = $desc_transacao;
    $postback = null;

    // só pra registrar um log
    debug_log('Dados recebidos: ' . json_encode($data));
    debug_log('Parâmetros do insert: ' . json_encode([
        $user_id,
        $externalreference,
        $amount,
        $client_name,
        $client_document,
        $client_email,
        $real_data,
        $status,
        $qrcode_pix,
        $paymentcode,
        $idtransaction,
        $paymentCodeBase64,
        $adquirente_ref,
        $taxa_cash_in,
        $tipo_transacao,
        $desc_transacao,
        $deposito_liquido,
        $taxa_pix_cash_in_adquirente,
        $taxa_pix_cash_in_valor_fixo,
        $client_telefone,
        $executor_ordem,
        $descricao_transacao,
        $postback
    ]));

    $stmt = $conn->prepare("INSERT INTO solicitacoes (user_id, externalreference, amount, client_name, client_document, client_email, real_data, status, qrcode_pix, paymentcode, idtransaction, paymentCodeBase64, adquirente_ref, taxa_cash_in, tipo_transacao, desc_transacao, deposito_liquido, taxa_pix_cash_in_adquirente, taxa_pix_cash_in_valor_fixo, client_telefone, executor_ordem, descricao_transacao, postback) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        debug_log('Erro no prepare: ' . $conn->error);
    } else {
        $ok = $stmt->bind_param(
            "ssdssssssssssdsssssssss", // 23 caracteres
            $user_id,
            $externalreference,
            $amount,
            $client_name,
            $client_document,
            $client_email,
            $real_data,
            $status,
            $qrcode_pix,
            $paymentcode,
            $idtransaction,
            $paymentCodeBase64,
            $adquirente_ref,
            $taxa_cash_in,
            $tipo_transacao,
            $desc_transacao,
            $deposito_liquido,
            $taxa_pix_cash_in_adquirente,
            $taxa_pix_cash_in_valor_fixo,
            $client_telefone,
            $executor_ordem,
            $descricao_transacao,
            $postback
        );
        if (!$ok) {
            debug_log('Erro no bind_param: ' . $stmt->error);
        }
        $exec = $stmt->execute();
        if (!$exec) {
            debug_log('Erro no execute: ' . $stmt->error);
        }
        $stmt->close();
    }
    $conn->close();
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
