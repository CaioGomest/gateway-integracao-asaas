<?php

require '../vendor/autoload.php';

use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

session_start();

function is_2fa_verified()
{
    return isset($_COOKIE['2fa_verified']) && $_COOKIE['2fa_verified'] === 'true';
}

if (isset($_SESSION['email'])) {
    header("Location: ../home");
    exit();
}
?>


<?php

// Inicializa as variáveis
$email = $senha = "";
$emailErr = $senhaErr = "";
$errorMessage = $successMessage = "";

// Função para validar os dados do formulário
function validateForm($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["2FA"])) {

    $secret = $_SESSION["2fa_secret"];
    $email = $_SESSION["email2"];
    include '../conectarbanco.php';

    $conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }


    $updateQuery = "UPDATE users SET 2fa_registered = 1 WHERE email = ?";

    $stmt = $conn->prepare($updateQuery);
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    if (!$stmt->execute()) {
        die("Erro na execução da consulta: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();


    $_SESSION["isfaregistered"] = 1;

    $g = new GoogleAuthenticator();
    if ($g->checkCode($secret, $_POST["2FA"])) {
        $_SESSION["email"] = $email;

        $successMessage = "Login efetuado com sucesso!";
        header("refresh:3;url=/home");
    } else {
        $errorMessage = "Código 2FA incorreto.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
    // Validar e obter os dados do formulário
    $email = validateForm($_POST["email"]);
    $senha = validateForm($_POST["password"]);

    include '../conectarbanco.php';

    $conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

    // Verifica se houve algum erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Consulta SQL para verificar as credenciais e status
    $sql = "SELECT senha, status, secret, 2fa_registered FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hash, $status, $secret2fa, $isfaregistered);
    $stmt->fetch();

    if ($status == 3) { // Verifica se o status é "banido"
        $errorMessage = "Sua conta foi banida. Entre em contato com o suporte.";
    } elseif ($status === 'pendente') {
        $errorMessage = "Conta em análise, aguarde.";
    } elseif ($status === 'rejeitado') {
        $errorMessage = "Conta rejeitada, entre em contato com o suporte.";
    } elseif ($hash && password_verify($senha, $hash)) {
        $_SESSION["email2"] = $email;
        $_SESSION["2fa_secret"] = $secret2fa;
        $_SESSION["isfaregistered"] = $isfaregistered;

        header("refresh:3");
    } else {
        // Credenciais incorretas, exiba uma mensagem de erro
        $errorMessage = "Credenciais incorretas.";
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();
    
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../img/logo-pwaa.png">
    <link rel="icon" type="image/png" href="../img/favicon.png">
    <title>JustPay - Login</title>
    <!-- Manifesto PWA -->
    <link rel="manifest" href="manifest.json">
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="assets-login/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets-login/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="assets-login/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
    <!-- Bootstrap CSS for modal -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
</body>

</html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baixe nosso App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .mobile-banner {
            background-color: black;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: none;
            /* Oculta por padrão */
            z-index: 9999;
            /* Garante que fique acima de outros elementos */
        }

        .mobile-banner .download-button {
            background-color: #0e14cb;
            color: white;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .popup {
            display: none;
            /* Oculta por padrão */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 2px solid #0e14cb;
            z-index: 10000;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            /* Define a largura do popup */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Adiciona sombra */
        }

        .popup img {
            width: 100%;
            /* Ajusta a largura da imagem ao tamanho do popup */
            border-radius: 10px;
            display: none;
            /* Oculta as imagens inicialmente */
        }

        .popup .close-btn {
            background-color: #0e14cb;
            /* Cor de fundo para o botão X */
            border: none;
            font-size: 20px;
            /* Diminui o tamanho do texto do botão */
            color: white;
            /* Cor do texto */
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            padding: 5px;
            /* Diminui o espaçamento interno */
            border-radius: 5px;
            /* Ajusta o arredondamento */
            transition: background-color 0.5s;
            /* Aumenta o tempo de transição para 0.5s */
        }

        .popup .close-btn:hover {
            background-color: #0056b3;
            /* Cor ao passar o mouse */
            transition: background-color 1.5s;
            /* Tempo de transição no hover */
        }

        .arrow {
            display: none;
            /* Oculta as setas */
        }

        @media (max-width: 768px) {

            /* Ajuste este valor se necessário */
            .mobile-banner {
                display: block;
                /* Exibe somente em mobile */
            }
        }
    </style>
</head>

<body>

    <div class="mobile-banner">
        <span>Baixe nosso App</span>
        <button class="download-button" id="open-popup">Baixar</button>
    </div>
</body>

</html>


<div class="popup" id="image-popup">
    <button class="close-btn" id="close-popup">&times;</button>
    <div id="image-container">
        <img src="https://i.imgur.com/N3JN0S2.png" alt="Imagem 1" class="popup-image">
        <img src="https://i.imgur.com/mW1rRP9.png" alt="Imagem 2" class="popup-image">
        <img src="https://i.imgur.com/FiMzGCU.png" alt="Imagem 3" class="popup-image">
        <img src="https://i.imgur.com/BmKxOql.png" alt="Imagem 4" class="popup-image">
        <img src="https://i.imgur.com/WR6J8CG.png" alt="Imagem 5" class="popup-image">
    </div>
    <span class="arrow left" id="prev-image">&#10094;</span>
    <span class="arrow right" id="next-image">&#10095;</span>
</div>


<script>
    const openPopupButton = document.getElementById('open-popup');
    const closePopupButton = document.getElementById('close-popup');
    const popup = document.getElementById('image-popup');
    const images = document.querySelectorAll('.popup-image');

    let currentImageIndex = 0;

    function showImage(index) {
        images.forEach((img, i) => {
            img.style.display = (i === index) ? 'block' : 'none';
        });
    }

    function nextImage() {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        showImage(currentImageIndex);
    }

    function prevImage() {
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        showImage(currentImageIndex);
    }

    openPopupButton.addEventListener('click', () => {
        popup.style.display = 'block';
        showImage(currentImageIndex);
        setInterval(nextImage, 3000); // Muda a imagem a cada 3 segundos
    });

    closePopupButton.addEventListener('click', () => {
        popup.style.display = 'none';
    });

    document.getElementById('next-image').addEventListener('click', nextImage);
    document.getElementById('prev-image').addEventListener('click', prevImage);

    // Função para permitir rolagem de toque nas imagens
    let touchStartX = 0;

    const imageContainer = document.getElementById('image-container');

    imageContainer.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
    });

    imageContainer.addEventListener('touchmove', (e) => {
        const touchEndX = e.touches[0].clientX;
        if (touchStartX - touchEndX > 50) {
            nextImage(); // Desliza para a esquerda
        } else if (touchEndX - touchStartX > 50) {
            prevImage(); // Desliza para a direita
        }
    });
</script>

</body>

</html>


</body>

</html>

<body class="bg-gray-200">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">

            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
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
                                <?php if (!isset($_SESSION['email2'])): ?>

                                    <form method="post" accept-charset="utf-8" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="return validateForm()">
                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" id="email" name="email" class="form-control" required>
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" name="password" id="senha" class="form-control" required>
                                        </div>
                                        <div class="form-check form-switch d-flex align-items-center mb-3">
                                            <input class="form-check-input" type="checkbox" id="togglePassword">
                                            <label class="form-check-label mb-0 ms-2" for="togglePassword">Mostrar Senha</label>
                                        </div>
                                        <div class="form-check form-switch d-flex align-items-center mb-3">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label mb-0 ms-2" for="rememberMe">Lembre-se</label>
                                        </div>

                                        <?php
                                        if (!empty($errorMessage)) {
                                            echo '<span class="login-error" style="color:red">' . $errorMessage . '</span>';
                                        }
                                        if (!empty($successMessage)) {
                                            echo '<p class="login-success" style="color:green">' . $successMessage . '</p>';
                                        }
                                        ?>

                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Login</button>
                                        </div>
                                        <p class="mt-4 text-sm text-center">
                                            Não tem uma conta?
                                            <a href="../registrar/" class="text-primary text-gradient font-weight-bold">Inscrever-se</a>
                                        </p>
                                    </form>
                                <?php elseif (!is_2fa_verified()): ?>
                                    <form method="post" accept-charset="utf-8" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                                        <?php
                                        if (!empty($errorMessage)) {
                                            echo '<span class="login-error" style="color:red">' . $errorMessage . '</span>';
                                        }
                                        if (!empty($successMessage)) {
                                            echo '<p class="login-success" style="color:green">' . $successMessage . '</p>';
                                        }
                                        ?>
                                        <div style="display: flex; justify-content: center; gap: 10px; margin-bottom: 20px;">
                                            <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&amp;pcampaignid=web_share" target="_blank">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Play Store" style="width: 120px; height: auto;">
                                            </a>
                                            <a href="https://apps.apple.com/br/app/google-authenticator/id388497605" target="_blank" style="position: relative; top: -1px;">
                                                <img src="https://www.gov.br/pt-br/imagens-de-servicos/apple.png" alt="Apple Store" style="width: 129px; height: auto;">
                                            </a>
                                        </div>

                                        <?php
                                        $hasFaRegistered = $_SESSION["isfaregistered"];
                                        $nomeApp = 'JustPay';
                                        $nomeUsuario = $_SESSION["email2"];
                                        $secret = $_SESSION["2fa_secret"];
                                        $qrCodeUrl = GoogleQrUrl::generate($nomeUsuario, $secret, $nomeApp);

                                        // Verifica se o 2FA já está registrado
                                        if ($hasFaRegistered != 1) {
                                            echo "<h2>Escaneie o código 2FA</h2>";
                                            echo "<img src='" . $qrCodeUrl . "' alt='QR Code' style='display: block; margin: 0 auto;'>";
                                                                                    // Código secreto com ícone de copiar
    echo "
    <div style='text-align: center; margin-top: 10px; display: flex; justify-content: center; align-items: center; gap: 10px;'>
        <p style='font-weight: bold; margin: 0;'>
            Código secreto: <span id='secret-code' style='background-color: #f5f5f5; padding: 5px; border-radius: 5px;'>" . htmlspecialchars($secret) . "</span>
        </p>
        <img src='https://cdn.icon-icons.com/icons2/931/PNG/512/copy_paste_icon-icons.com_72426.png' alt='Copiar' onclick='copySecretCode()' style='width: 24px; height: 24px; cursor: pointer;'>
    </div>

    <script>
        function copySecretCode() {
            const secretCode = document.getElementById('secret-code').innerText;
            navigator.clipboard.writeText(secretCode).then(() => {
                alert('Código secreto copiado!');
            }).catch(err => {
                alert('Erro ao copiar o código: ' + err);
            });
        }
    </script>";
                                        } elseif ($hasFaRegistered == 1) {
                                            echo "<h2>Insira o código</h2>";
                                        }
                                        ?>

                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">2FA</label>
                                            <input type="2FA" id="2FA" name="2FA" class="form-control" required>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Prosseguir</button>
                                            
                                                                                                                                      <!-- Adicionando o texto de logout -->
        <div class="text-center mt-3">
            <a href="../logout.php" class="text-decoration-none" style="color: #ff0000; font-size: 14px;">
                Sair
            </a>
            
                                        </div>
                                    </form>
                                <?php endif; ?>

                                <script>
                                    function validateForm() {
                                        const email = document.getElementById("email").value;
                                        const senha = document.getElementById("senha").value;

                                        if (email === "" || senha === "") {
                                            const modal = new bootstrap.Modal(document.getElementById('errorModal'));
                                            modal.show();
                                            return false;
                                        }
                                        return true;
                                    }

                                    document.addEventListener('DOMContentLoaded', function() {
                                        const inputs = document.querySelectorAll('.form-control');

                                        inputs.forEach(input => {
                                            if (input.value) {
                                                input.parentElement.classList.add('is-filled');
                                            }

                                            input.addEventListener('focus', () => {
                                                input.parentElement.classList.add('is-filled');
                                            });

                                            input.addEventListener('blur', () => {
                                                if (!input.value) {
                                                    input.parentElement.classList.remove('is-filled');
                                                }
                                            });
                                        });
                                    });
                                </script>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Modal com fundo preto -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header border-0">

                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Por favor, preencha todos os campos antes de continuar.
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>




        <!-- Script to trigger modal and set message -->
        <script>
            function showModal(message) {
                document.getElementById('modalMessage').innerText = message;
                var modal = new bootstrap.Modal(document.getElementById('errorModal'));
                modal.show();
            }
        </script>



        <!--   Core JS Files   -->
        <script src="assets-login/js/core/popper.min.js"></script>
        <script src="assets-login/js/core/bootstrap.min.js"></script>
        <script src="assets-login/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="assets-login/js/plugins/smooth-scrollbar.min.js"></script>

        <!-- Bootstrap JS for modal -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

<!-- Mostrar Senha -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#senha');

        togglePassword.addEventListener('change', function() {
            // Verifica se o checkbox está marcado
            const type = togglePassword.checked ? 'text' : 'password';
            passwordField.setAttribute('type', type);
        });
    });
</script>
<!-- End Mostrar Senha -->



<!-- Registro do service worker -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/service-worker.js')
                .then(function(registration) {
                    console.log('Service Worker registrado com sucesso:', registration);
                }, function(error) {
                    console.log('Falha ao registrar o Service Worker:', error);
                });
        });
    }
</script>

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

</html>