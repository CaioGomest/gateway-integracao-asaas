<?php
include '../../../conectarbanco.php';

$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT secret_key, url_cash_out FROM ad_pagpix LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $secretKey = $row['secret_key'];
    $urlCashIn = $row['url_cash_out'];
} else {
    die("Erro: Não foi possível obter a chave secret_key.");
}

**
 * FUNÇÃO PARA VALIDAR O IP DO SAQUE
 */
$ip = '';
if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}else{
    $ip = $_SERVER['REMOTE_ADDR'];
}

if(empty($ip)){
    echo json_encode(['K' => 'IP é obrigatório.']);
    exit;
}

$safe = $conn->prepare('SELECT users.id FROM users INNER JOIN ip_autorizado ON ip_autorizado.user_id = users.id WHERE ip_autorizado.ip = ?');
$safe->bind_param('s', $ip);
$safe->execute();
$ip_ok = $safe->get_result();
if($ip_ok->num_rows == 0) {
    echo json_encode(['K' => 'IP não autorizado: '.$ip]);
    exit;
}
/**
 * FIM -- FUNÇÃO PARA VALIDAR O IP DO SAQUE
 */


$conn->close();

$headers = [
    'Authorization: Basic ' . base64_encode($secretKey),
    'Content-Type: application/json'
];

$response = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ip = $_SERVER['REMOTE_ADDR'];
    date_default_timezone_set('America/Sao_Paulo');
    $dataHora = date('Y-m-d H:i:s');

    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sqlLog = "INSERT INTO logs_ip_cash_out (ip, data) VALUES (?, ?)";
    $stmtLog = $conn->prepare($sqlLog);
    $stmtLog->bind_param("ss", $ip, $dataHora);
    $stmtLog->execute();

    $stmtLog->close();
    $conn->close();

    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['keyseguranca']) || empty($input['keyseguranca'])) {
        echo json_encode(['K' => 'Acesso negado K-404 - IP Salvo']);
        exit;
    }

    if (!isset($input['cpf']) || empty($input['cpf'])) {
        echo json_encode(['K' => 'O CPF do beneficiário é obrigatório.']);
        exit;
    }

    if (!isset($input['amount']) || !is_numeric($input['amount']) || empty($input['amount'])) {
        echo json_encode(['K' => 'O valor deve ser um número e não pode ser vazio.']);
        exit;
    }

    $keySeguranca = $input['keyseguranca'];
    $cpf = $input['cpf'];
    $amount = $input['amount'] * 100;
    $beneficiaryName = isset($input['beneficiaryName']) ? $input['beneficiaryName'] : 'usuario padrao';
    $postbackUrl = "https://api.abacash.pro/c1/adquirente/pagpix/webhook/";

    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    $sql = "SELECT COUNT(*) as count FROM seguranca WHERE keyseguranca = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $keySeguranca);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] === 0) {
        echo json_encode(['K' => 'Acesso negado K-404 - IP Salvo']);
        exit;
    }

    $pixKey = $cpf;

    $cashoutData = [
        'amount' => (int)$amount,
        'pixKey' => (string)$pixKey,
        'pixType' => 'CPF',
        'beneficiaryName' => (string)$beneficiaryName,
        'beneficiaryDocument' => (string)$cpf,
        'description' => "Saque",
        'postbackUrl' => (string)$postbackUrl
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $urlCashIn,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($cashoutData)
    ]);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        $response = json_encode(['K' => 'Erro: ' . curl_error($curl)]);
    } else {
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpCode != 200) {
            $response = json_encode(['K' => "Error: $httpCode - " . $response]);
        }
    }

    curl_close($curl);

    echo $response;
} else {
    echo json_encode(['error' => 'HELLO']);
}
