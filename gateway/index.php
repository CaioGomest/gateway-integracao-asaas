<?php
session_start();
require '../vendor/autoload.php';
use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

function is_2fa_validado()
{
  return isset($_COOKIE['2fa_verified_ip']) && $_COOKIE['2fa_verified_ip'] === 'true';
}

// Verificar se o e-mail está presente na sessão
if (!isset($_SESSION['email'])) {
  // Se o e-mail não estiver presente na sessão, redirecione para outra página
  header("Location: ../");
  exit; // Certifique-se de sair do script após o redirecionamento
}

include '../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

// Verifica se houve algum erro na conexão
if ($conn->connect_error) {
  die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

function update_ip($ip, $validado)
{
  global $conn;

  if (isset($ip) && !empty($ip) && $validado == true) {
    $exist = $conn->prepare('SELECT users.id,(SELECT COUNT(*) FROM ip_autorizado WHERE user_id = users.id AND ip = ?) as qtd_autorizado FROM users WHERE email = ?');
    $exist->bind_param('ss', $ip, $_SESSION['email']);
    $exist->execute();
    $result = $exist->get_result();
    $user = $result->fetch_assoc();

    //die(var_dump($user));
    if ($user['qtd_autorizado'] == 0) {
      $user_id = $user['id'];
      $data = date('Y-m-d H:m:s');

      $criar_ip = $conn->prepare('INSERT INTO ip_autorizado SET user_id = ?, ip = ?, data = ?');
      $criar_ip->bind_param('sss', $user_id, $ip, $data);
      $criar_ip->execute();

      if (isset($_COOKIE['ip_tmp']) && !empty($_COOKIE['ip_tmp'])) {
        unset($_COOKIE['ip_tmp']);
      }

      unset($_COOKIE['2fa_verified_ip']);
      setcookie("2fa_verified_ip", 'false');
    }
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ip']) && !empty($_POST['ip']) && is_2fa_validado() == true) {
  update_ip($_POST['ip'], true);
  header("refresh:0;url=/gateway");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["2FA"])) {

  $secret = $_SESSION["2fa_secret"];
  $email = $_SESSION["email2"];

  $g = new GoogleAuthenticator();
  if ($g->checkCode($secret, $_POST["2FA"])) {
    $_SESSION["email"] = $email;

    $successMessage = "Validação efetuada com sucesso!";
    setcookie("2fa_verified_ip", 'true');

    if (isset($_COOKIE['ip_tmp']) && !empty($_COOKIE['ip_tmp'])) {
      update_ip($_COOKIE['ip_tmp'], true);
      header("refresh:0;url=/gateway");
    }else{
      header("refresh:0;url=/gateway");
    }
    
  } else {
    $errorMessage = "Código 2FA incorreto.";
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_ip']) && !empty($_POST['delete_ip'])) {
  $exist = $conn->prepare('SELECT users.id,(SELECT COUNT(*) FROM ip_autorizado WHERE user_id = users.id AND ip_autorizado.id = ?) as qtd_autorizado FROM users WHERE email = ?');
  $exist->bind_param('ss', $_POST['delete_ip'], $_SESSION['email']);
  $exist->execute();
  $result = $exist->get_result();
  $user = $result->fetch_assoc();

  if ($user['qtd_autorizado'] > 0) {
    $user_id = $user['id'];
    $data = date('Y-m-d H:m:s');

    $delete = $conn->prepare('DELETE FROM ip_autorizado WHERE id = ? AND user_id = ?');
    $delete->bind_param('ss', $_POST['delete_ip'], $user_id);
    $delete->execute();
  }
}

// Recuperar o e-mail da sessão
$email = $_SESSION['email'];

// Consultar o status do usuário pelo email
$sql = "SELECT status FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($status);
$stmt->fetch();

$stmt->close();
$conn->close();

// Verificar o status do usuário
if ($status == 0) {
  // Redirecionar imediatamente para a página ../home se o status for 0
  header("Location: ../home");
  exit;
}

// Verificar o status do usuário
if ($status == 5) {
  // Redirecionar imediatamente para a página ../home se o status for 0
  header("Location: ../home");
  exit;
}
?>





<?php
session_start();

// Verificar se o e-mail está presente na sessão
if (!isset($_SESSION['email'])) {
  // Se o e-mail não estiver presente na sessão, redirecione para outra página
  header("Location: ../");
  exit; // Certifique-se de sair do script após o redirecionamento
}

include '../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

// Verifica se houve algum erro na conexão
if ($conn->connect_error) {
  die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Recuperar o e-mail da sessão
$email = $_SESSION['email'];

$sql = "SELECT nome, status, permission, cliente_id, user_id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
  die("Erro na preparação da consulta: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($nome, $status, $permission, $cliente_id, $user_id);
$stmt->fetch();
$stmt->close();

// Conectar ao banco de dados API
include '../conectar_api_banco.php';

$conn_api = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

// Verifica se houve algum erro na conexão
if ($conn_api->connect_error) {
  die("Erro na conexão com o banco de dados API: " . $conn_api->connect_error);
}

// Verificar se já existe um user_id na tabela users_key
$sql_check = "SELECT COUNT(*) FROM users_key WHERE user_id = ?";
$stmt_check = $conn_api->prepare($sql_check);
if (!$stmt_check) {
  die("Erro na preparação da consulta de verificação: " . $conn_api->error);
}
$stmt_check->bind_param("s", $user_id);
$stmt_check->execute();
$stmt_check->bind_result($count);
$stmt_check->fetch();
$stmt_check->close();

if ($count > 0) {
  echo "OK";
} else {
  // Inserir dados na tabela users_key
  $api_key = $cliente_id;
  $status = 'ativo';

  $sql_api = "INSERT INTO users_key (user_id, api_key, status) VALUES (?, ?, ?)";
  $stmt_api = $conn_api->prepare($sql_api);
  if (!$stmt_api) {
    die("Erro na preparação da consulta API: " . $conn_api->error);
  }
  $stmt_api->bind_param("sss", $user_id, $api_key, $status);
  $stmt_api->execute();

  if ($stmt_api->affected_rows > 0) {
    echo "Dados inseridos com sucesso.";
  } else {
    echo "Erro ao inserir os dados.";
  }

  $stmt_api->close();
}

$conn_api->close();
//$conn->close();
?>



<?php
session_start();

// Verifica se o parâmetro de logout foi passado na URL
if (isset($_GET['logout'])) {
  // Destroi a sessão
  session_destroy();
  // Redireciona para a página inicial
  header("Location: ../");
  exit;
}

// O restante do seu código PHP continua abaixo...
?>



<!-- Este código gera o URL base do site combinando o protocolo, o nome de domínio e o caminho do diretório -->
<?php
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/../';
?>
<!-- This code generates the base URL for the website by combining the protocol, domain name, and directory path -->

<!-- This code generates the base URL for the website by combining the protocol, domain name, and directory path -->

<!-- This code is useful for internal styles  -->
<?php ob_start(); ?>



<?php $styles = ob_get_clean(); ?>
<!-- This code is useful for internal styles  -->

<!-- This code is useful for content -->
<?php ob_start(); ?>
<script src="../login/assets-login/js/core/bootstrap.min.js"></script>
<link rel="stylesheet"
  href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=delete" />

<div class="main-content app-content">
  <div class="container-fluid">


    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">


            <h4 class="d-block mb-2">Recursos do Gateway Digipag:</h4>
            <ul style="list-style-type: none;padding-left: 0;color: aliceblue;">
              <li>
                <i class="mb-4 fs-4" style="color: #007bff;"></i> Tecnologia avançada que processa transações com
                eficiência e segurança.
              </li>
              <li>
                <i class="mb-4 fs-4" style="color: #28a745;"></i> Painel de controle personalizado para análise de
                vendas e gerenciamento financeiro.
              </li>
              <li>
                <i class="mb-4 fs-4" style="color: #dc3545;"></i> Segurança robusta contra fraudes e proteção dos dados
                dos clientes.
              </li>
              <li>
                <i class="mb-4 fs-4"" style=" color: #ffc107;"></i> Integração perfeita com as principais plataformas de
                e-commerce.
              </li>
              <li>
                <i class="mb-4 fs-4" style="color: #17a2b8;"></i> Conexão direta com a adquirente, simplificando o
                processo de pagamento.
              </li>
            </ul>

          </div>
        </div>
      </div>



      <script>
        function mostrarCodigo() {
          var codigoOculto1 = document.getElementById("codigoOculto1");

          if (codigoOculto1.innerText === "*********") {
            codigoOculto1.innerText = "<?php echo $cliente_id; ?>";
          } else {
            codigoOculto1.innerText = "*********";
          }
        }
      </script>

      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <form action="" id="form-2fa" method="post">
              <h4 class="d-block mb-3">Cadastro de IPs:</h4>

              <div class="col-12 col-sm-6 col-md-4">
                <div class="d-flex gap-2">
                  <input type="text" class="form-control" id="ip" name="ip" placeholder="192.168.1.1" required>
                  <button class="btn btn-outline-success btn-fw" style="max-width: 150px;" type="button"
                    onclick="mostrarModal(event, this)">Cadastrar</button>
                </div>
              </div>
            </form>

            <div class="tabela-ips mt-3"
              style="color: aliceblue;display:flex;flex-direction: column;flex-wrap: nowrap;">
              <?php
              $buscar_ip = $conn->prepare('SELECT ip_autorizado.id,ip FROM ip_autorizado INNER JOIN users u ON u.id = ip_autorizado.user_id WHERE u.email = ?');
              $buscar_ip->bind_param('s', $_SESSION['email2']);
              $buscar_ip->execute();


              $result = $buscar_ip->get_result();
              while ($row = $result->fetch_assoc()):
                ?>
                <div style="display:flex; align-items: center;" class="gap-2">
                  <span>IP Cadastrado: <?= $row['ip'] ?></span>
                  <span class="material-symbols-outlined" style="font-size: 18px;cursor: pointer;"
                    onclick="deleteIp(<?= $row['id'] ?>)">delete</span>
                </div>

              <?php endwhile;
              $conn->close(); ?>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body" style="
    color: aliceblue;
">
            <h8 class="d-block mb-2">integração com o Gateway</h8>
            <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
              <div class="text-md-center text-xl-left">

              </div>
              <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                <div id="codigoOculto1">
                  <h6 class="font-weight-bold mb-0">*********</h6>
                </div>
              </div>
            </div>


          </div>
          <div class="text-center mt-3"> <!-- Adicione uma classe para centralizar o botão -->
            <button class="btn btn-outline-success btn-fw" style="max-width: 150px;" onclick="mostrarCodigo()">Mostrar
              Chaves</button>
          </div>
          <br>
        </div>
      </div>

      <?php if (!is_2fa_validado()): ?>
        <div class="modal fade" id="modal-2fa" tabindex="1000" aria-labelledby="modal-2fa" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-white" style="background-color:rgb(46, 47, 48)">
              <div class="modal-header border-0" style="color: white;">
                Validação 2FA
              </div>
              <div class="modal-body">
                <form method="post" id="form-modal" accept-charset="utf-8"
                  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                  <?php
                  if (!empty($errorMessage)) {
                    echo '<span class="login-error" style="color:red">' . $errorMessage . '</span>';
                  }
                  if (!empty($successMessage)) {
                    echo '<p class="login-success" style="color:green">' . $successMessage . '</p>';
                  }
                  ?>
                  <div style="display: flex; justify-content: center; gap: 10px; margin-bottom: 20px;">
                    <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&amp;pcampaignid=web_share"
                      target="_blank">
                      <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                        alt="Play Store" style="width: 120px; height: auto;">
                    </a>
                    <a href="https://apps.apple.com/br/app/google-authenticator/id388497605" target="_blank"
                      style="position: relative; top: -1px;">
                      <img src="https://www.gov.br/pt-br/imagens-de-servicos/apple.png" alt="Apple Store"
                        style="width: 129px; height: auto;">
                    </a>
                  </div>

                  <?php
                  $hasFaRegistered = $_SESSION["isfaregistered"];
                  $nomeApp = 'Digipag';
                  $nomeUsuario = $_SESSION["email2"];
                  $secret = $_SESSION["2fa_secret"];
                  //$qrCodeUrl = GoogleQrUrl::generate($nomeUsuario, $secret, $nomeApp);
                
                  // Verifica se o 2FA já está registrado
                  if ($hasFaRegistered == 1) {
                    echo "<h2>Insira o código</h2>";
                  }
                  ?>

                  <div class="input-group input-group-outline my-3">
                    <input type="2FA" id="2FA" name="2FA" class="form-control" required>
                  </div>

                  <div class="text-center">
                    <button class="btn btn-outline-success btn-fw" style="width: 100%;" type="submit">Autorizar</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <script>
      var twoFa = <?= is_2fa_validado() ? 1 : 0; ?>;

      function mostrarModal(e, btn) {
        e.preventDefault();

        if (twoFa == 0 || twoFa == '') {
          document.cookie = 'ip_tmp=' + document.getElementById('ip').value;
          console.log('Setado ip temporario '+document.cookie)
          var modal = new bootstrap.Modal(document.getElementById('modal-2fa'));
          modal.show();
          return;
        }

        if (twoFa == 1) {
          var form = document.getElementById('form-2fa');
          form.submit()
        }
      }

      function deleteIp(id) {
        const formData = new FormData();
        formData.append('delete_ip', id);

        fetch(window.location.href, {
          method: 'POST', body: formData
        }).then(data => {
          window.location.href = '/gateway';
        });
      }

    </script>

  </div>
</div>
</div>

<?php $content = ob_get_clean(); ?>
<!-- This code is useful for content -->

<!-- This code is useful for internal scripts  -->
<?php ob_start(); ?>



<?php $scripts = ob_get_clean(); ?>
<!-- This code is useful for internal scripts  -->

<!-- This code use for render base file -->
<?php include '../layouts/base.php'; ?>
<!-- This code use for render base file -->