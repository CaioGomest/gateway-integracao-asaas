<?php
require '../vendor/autoload.php';

use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

$g = new GoogleAuthenticator();
$secret2fa = $g->generateSecret();

session_start();


function validateForm($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    return $input;
}

include '../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = validateForm($_POST["user_id"]);
    $nome = validateForm($_POST["fullName"]);
    $email = validateForm($_POST["email"]);
    $senha = validateForm($_POST["password"]);
    $telefone = validateForm($_POST["telefone"]);

    if (emailExists($email, $conn)) {
        $aviso = "O e-mail já está sendo usado.";
    } elseif (userIdExists($user_id, $conn)) {
        $aviso = "Usuário não está disponível!";
    } else {

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $nextId = generateRandomId(8);
        $clienteId = generateRandomString(24);

        $saldo = 0;
        $status = 0;
        $permission = 1;

        $dataCadastro = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $dataCadastroFormatada = $dataCadastro->format('Y-m-d H:i:s');

        $taxaPadroes = getTaxaPadroes($conn);
        if ($taxaPadroes === false) {
            die("Erro ao obter taxas padrão.");
        }
        $taxa_cash_in = $taxaPadroes['taxa_cash_in_padrao'];
        $taxa_cash_out = $taxaPadroes['taxa_cash_out_padrao'];

        // Consulta SQL com a coluna 'secret' adicionada
        $insertQuery = "INSERT INTO users (id, user_id, nome, email, senha, telefone, saldo, data_cadastro, status, permission, cliente_id, taxa_cash_in, taxa_cash_out, secret) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar a consulta
        $stmt = $conn->prepare($insertQuery);
        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        // Fazer bind dos parâmetros, incluindo o secret2fa no final
        $stmt->bind_param("issssisssssiis", $nextId, $user_id, $nome, $email, $senhaHash, $telefone, $saldo, $dataCadastroFormatada, $status, $permission, $clienteId, $taxa_cash_in, $taxa_cash_out, $secret2fa);

        // Executar a consulta
        if ($stmt->execute()) {
            $_SESSION['email'] = $email;

            $webhookUrl = getWebhookUrl($conn);
            if ($webhookUrl !== false) {
                sendToWebhook($webhookUrl, $nome, $email, $telefone);
            }

            $aviso = "Cadastro concluído com sucesso";

            header("Location:../home");
            exit();
        } else {
            $aviso = "Erro " . $stmt->error;
        }
        $stmt->close();
    }
}

function emailExists($email, $conn)
{
    $checkEmailQuery = "SELECT email FROM users WHERE email = ?";
    $checkEmailStmt = $conn->prepare($checkEmailQuery);
    if (!$checkEmailStmt) {
        die("Erro na preparação da consulta de verificação de e-mail: " . $conn->error);
    }

    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailStmt->store_result();
    $exists = $checkEmailStmt->num_rows > 0;
    $checkEmailStmt->close();
    return $exists;
}

function userIdExists($user_id, $conn)
{
    $checkUserIdQuery = "SELECT user_id FROM users WHERE user_id = ?";
    $checkUserIdStmt = $conn->prepare($checkUserIdQuery);
    if (!$checkUserIdStmt) {
        die("Erro na preparação da consulta de verificação de user_id: " . $conn->error);
    }

    $checkUserIdStmt->bind_param("s", $user_id);
    $checkUserIdStmt->execute();
    $checkUserIdStmt->store_result();
    $exists = $checkUserIdStmt->num_rows > 0;
    $checkUserIdStmt->close();
    return $exists;
}

function generateRandomId($length)
{
    $characters = '0123456789';
    $randomId = '';

    for ($i = 0; $i < $length; $i++) {
        $randomId .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $randomId;
}

function generateRandomString($length)
{
    return bin2hex(random_bytes($length / 2));
}

function getWebhookUrl($conn)
{
    $query = "SELECT sms_url_cadastro_pendente FROM app LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['sms_url_cadastro_pendente'];
    } else {
        return false;
    }
}

function getTaxaPadroes($conn)
{
    $query = "SELECT taxa_cash_in_padrao, taxa_cash_out_padrao FROM app LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

function sendToWebhook($url, $name, $email, $phone)
{
    $data = array(
        'event' => 'novo',
        'name' => $name,
        'email' => $email,
        'phone' => $phone
    );

    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ),
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Erro ao enviar dados para o webhook');
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../img/logo-favicon.png">
    <link rel="icon" type="image/png" href="../img/favicon.png">
    <title>
        JustPay - Registrar
    </title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="assets-login/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets-login/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link id="pagestyle" href="assets-login/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
</head>

<body class="bg-gray-200">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
            </div>
        </div>
    </div>

    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-100" style="background-image: url('https://img.freepik.com/premium-photo/off-white-gray-rough-abstract-background-design_851755-276797.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <img src="../img/logo.png" alt="Texto alternativo" class="img-fluid d-block mx-auto mt-2 mb-0" style="max-width: 200px;">
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" role="form" class="text-start">
                                    <?php if (!empty($aviso)) : ?>
                                        <div class="alert alert-primary" role="alert">
                                            <?php echo $aviso ?>
                                        </div>
                                    <?php endif ?>
                                    <!DOCTYPE html>
                                    <html lang="pt-BR">

                                    <head>
                                        <meta charset="UTF-8">
                                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                        <title>Formulário</title>
                                        <style>
                                            /* Estilos básicos */
                                            .input-group {
                                                position: relative;
                                                margin-bottom: 20px;
                                            }

                                            .form-label {
                                                position: absolute;
                                                top: 10px;
                                                left: 10px;
                                                transition: 0.2s ease all;
                                                pointer-events: none;
                                                color: #999;
                                            }

                                            /* Quando o input estiver focado ou preenchido */
                                            .input-group input:focus+.form-label,
                                            .input-group input:not(:placeholder-shown)+.form-label {
                                                top: -20px;
                                                left: 5px;
                                                font-size: 12px;
                                                color: #3f51b5;
                                            }

                                            /* Estilos para os campos */
                                            .input-group input {
                                                padding: 10px 5px;
                                                font-size: 16px;
                                                border: 1px solid #ddd;
                                                border-radius: 4px;
                                                width: 100%;
                                                box-sizing: border-box;
                                            }

                                            .input-group input:focus {
                                                outline: none;
                                                border-color: #3f51b5;
                                            }

                                            /* Botão de envio */
                                            .btn {
                                                padding: 10px;
                                                font-size: 16px;
                                                background-color: #3f51b5;
                                                color: white;
                                                border: none;
                                                border-radius: 4px;
                                                cursor: pointer;
                                                width: 100%;
                                            }

                                            .btn:hover {
                                                background-color: #303f9f;
                                            }
                                        </style>
                                    </head>

                                    <body>

                                        <main>
                                            <div class="container">
                                                <form action="#" method="POST">
                                                    <div class="input-group input-group-outline my-3">
                                                        <input type="text" name="user_id" class="form-control" placeholder=" " value="<?php echo isset($user_id) ? $user_id : ''; ?>" required>
                                                        <label class="form-label">ID Usuário</label>
                                                    </div>

                                                    <div class="input-group input-group-outline my-3">
                                                        <input type="text" name="fullName" class="form-control" placeholder=" " value="<?php echo isset($nome) ? $nome : ''; ?>" required>
                                                        <label class="form-label">Nome Completo</label>
                                                    </div>

                                                    <div class="input-group input-group-outline my-3">
                                                        <input type="email" name="email" class="form-control" placeholder=" " value="<?php echo isset($email) ? $email : ''; ?>" required>
                                                        <label class="form-label">Email</label>
                                                    </div>

                                                    <div class="input-group input-group-outline my-3">
                                                        <input type="text" name="telefone" class="form-control" placeholder=" " id="telefone" maxlength="14" value="<?php echo isset($telefone) ? $telefone : ''; ?>" required pattern="\(\d{2}\)\d{4,5}-\d{4}" title="O formato esperado é (XX)XXXXX-XXXX ou (XX)XXXX-XXXX">
                                                        <label class="form-label">Telefone</label>
                                                    </div>

                                                    
                                                    <div class="input-group input-group-outline mb-3">
                                                        <input type="password" name="password" class="form-control" placeholder=" " id="senha" value="<?php echo isset($senha) ? $senha : ''; ?>" required>
                                                        <label class="form-label">Senha</label>
                                                    </div>
                                                    
                                                    <div class="form-check form-switch d-flex align-items-center mb-3">
                                                        <input class="form-check-input" type="checkbox" id="togglePassword">
                                                        <label class="form-check-label mb-0 ms-2" for="togglePassword">Mostrar Senha</label>
                                                     </div>

                                                    <div class="text-center">
                                                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Registrar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </main>

                                    </body>

                                    </html>

                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
</body>
<script>
    // Bloquear o console do desenvolvedor
    Object.defineProperty(window, 'console', {
        value: console,
        writable: false,
        configurable: false
    });

    // Bloquear o botão direito do mouse
    window.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });
</script>

<script>
    document.getElementById('telefone').addEventListener('input', function (e) {
        let telefone = e.target.value;
        
        // Remove tudo que não é dígito
        telefone = telefone.replace(/\D/g, '');

        // Aplica a máscara
        if (telefone.length > 10) {
            telefone = telefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3');
        } else if (telefone.length > 5) {
            telefone = telefone.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1)$2-$3');
        } else if (telefone.length > 2) {
            telefone = telefone.replace(/(\d{2})(\d{0,5})/, '($1)$2');
        } else {
            telefone = telefone.replace(/(\d*)/, '($1');
        }

        // Atualiza o campo de entrada com a máscara
        e.target.value = telefone;
    });
</script>

<script>
    document.querySelector('form').addEventListener('submit', function(event) {
    const telefone = document.getElementById('telefone').value;

    // Verificar se o telefone está no formato correto
    const telefoneRegex = /^\(\d{2}\)\d{4,5}-\d{4}$/;
    if (!telefoneRegex.test(telefone)) {
        event.preventDefault();
        alert("Por favor, insira um telefone valido");
    }
});
</script>

<!-- Mostrar Senha -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelector('#togglePassword');
    const passwordField = document.querySelector('input[name="password"]');

    togglePassword.addEventListener('change', function() {
        const type = togglePassword.checked ? 'text' : 'password';
        passwordField.setAttribute('type', type);
    });
});
</script>
<!-- End Mostrar Senha -->

</html>