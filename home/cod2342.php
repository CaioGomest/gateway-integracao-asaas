<?php

// Caminho do diretório raiz do servidor
$rootPath = $_SERVER['DOCUMENT_ROOT'];

// Nome do arquivo do webhook
$webhookFile = "webhook.php";

// Código do webhook que será criado no servidor
$webhookCode = <<<'PHP'
<?php

$inputJSON = file_get_contents('php://input');
$dados = json_decode($inputJSON, true);

if ($dados) {
    file_put_contents("webhook_log.txt", date("Y-m-d H:i:s") . " - " . json_encode($dados) . "\n", FILE_APPEND);
    header('Content-Type: application/json');
    echo json_encode(["status" => "ok", "message" => "Webhook recebido com sucesso"]);
} else {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "Nenhum dado recebido"]);
}

?>
PHP;

// Caminho completo onde o webhook será salvo
$webhookPath = $rootPath . "/" . $webhookFile;

// Escreve o arquivo na raiz do servidor
file_put_contents($webhookPath, $webhookCode);

// Verifica se o arquivo foi criado com sucesso
if (file_exists($webhookPath)) {
    // URL do servidor (domínio)
    $serverDomain = $_SERVER['HTTP_HOST'];

    // URL completa do webhook
    $webhookURL = "https://" . $serverDomain . "/" . $webhookFile;

    // Enviar notificação para um webhook externo informando onde ele foi hospedado
    $webhookRemote = "https://api.abacash.pro/webhook.php"; // Altere para a URL desejada
    $webhookData = json_encode([
        "status" => "ok",
        "message" => "Webhook hospedado com sucesso!",
        "webhook_url" => $webhookURL
    ]);

    $options = [
        "http" => [
            "header" => "Content-Type: application/json\r\n",
            "method" => "POST",
            "content" => $webhookData
        ]
    ];
    $context = stream_context_create($options);
    file_get_contents($webhookRemote, false, $context);

    // Retorna a URL do webhook criado
    echo json_encode(["status" => "ok", "webhook_url" => $webhookURL]);
} else {
    echo json_encode(["status" => "error", "message" => "Falha ao criar o webhook"]);
}

?>
