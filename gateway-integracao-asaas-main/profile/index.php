



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
if ($status == 5) {
    // Redirecionar para ../home se o status for 5
    echo '<script>
            window.onload = function() {
              window.location.href = "../home";
            }
          </script>';
  
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

$sql = "SELECT user_id, nome, status, permission, saldo, transacoes_aproved FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($user_id, $nome, $status, $permission, $saldo, $transacoes_aproved);
$stmt->fetch();

// Armazenar o user_id na sessão
$_SESSION['user_id'] = $user_id;

$stmt->close();
$conn->close();
?>




<?php

// Verifica se o parâmetro de logout foi passado na URL
if (isset($_GET['logout'])) {
    // Destroi a sessão
    session_destroy();
    // Redireciona para a página inicial
    header("Location: ../");
    exit;
}
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


<script>
    // Recuperar o user_id do PHP e imprimir no console
    const userId = <?php echo json_encode($_SESSION['user_id']); ?>;
    console.log("User ID:", userId);
  </script>




            <div class="main-content app-content">
                <div class="container-fluid">

                    <!-- Start::page-header -->
                    <div class="d-flex align-items-center justify-content-between my-4 page-header-breadcrumb flex-wrap gap-2">
                     
</div>
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

// Consultar os dados do usuário pelo email
$sql = "SELECT cpf_cnpj, cep, rua, numero_residencia, complemento, bairro, cidade, estado, media_faturamento, foto_rg_frente, foto_rg_verso, selfie_rg FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($cpf_cnpj, $cep, $rua, $numero_residencia, $complemento, $bairro, $cidade, $estado, $media_faturamento, $foto_rg_frente, $foto_rg_verso, $selfie_rg);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!-- HTML do formulário -->
<form method="POST" enctype="multipart/form-data" onsubmit="return false;">
    <div class="row">
        <div class="col-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        DADOS CADASTRAIS
                    </div>
                </div>
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-12 col-md-6">
                            <label for="cpf-cnpj" class="form-label">CPF/CNPJ</label>
                            <input type="text" class="form-control" id="cpf-cnpj" name="cpf_cnpj" value="<?php echo $cpf_cnpj; ?>" readonly>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="CEP" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="CEP" name="cep" value="<?php echo $cep; ?>" readonly>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="rua" class="form-label">Rua</label>
                            <input type="text" class="form-control" id="rua" name="rua" value="<?php echo $rua; ?>" readonly>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="numero_residencia" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero_residencia" name="numero_residencia" value="<?php echo $numero_residencia; ?>" readonly>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="complemento" class="form-label">Complemento:</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" value="<?php echo $complemento; ?>" readonly>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="bairro" class="form-label">Bairro:</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" value="<?php echo $bairro; ?>" readonly>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="cidade" class="form-label">Cidade:</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo $cidade; ?>" readonly>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="estado" class="form-label">Estado:</label>
                            <input type="text" class="form-control" id="estado" name="estado" value="<?php echo $estado; ?>" readonly>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Média de Faturamento mensal:</label>
                            <select class="form-control" name="media_faturamento" disabled>
                                <option value="10000-30000" <?php if ($media_faturamento == "10000-30000") echo "selected"; ?>>Entre R$ 10.000 - 30.000</option>
                                <option value="30000-100000" <?php if ($media_faturamento == "30000-100000") echo "selected"; ?>>Entre R$ 30.000 - 100.000</option>
                                <option value="100000-400000" <?php if ($media_faturamento == "100000-400000") echo "selected"; ?>>Entre R$ 100.000 - 400.000</option>
                                <option value="500000+" <?php if ($media_faturamento == "500000+") echo "selected"; ?>>Acima de R$ 500.000</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="foto_rg_frente" class="form-label">Foto de frente RG ou Habilitação:</label>
                            <a href="../uploads/<?php echo $foto_rg_frente; ?>" target="_blank" class="form-control">Ver Documento</a>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="foto_rg_verso" class="form-label">Foto do verso RG ou Habilitação:</label>
                            <a href="../uploads/<?php echo $foto_rg_verso; ?>" target="_blank" class="form-control">Ver Documento</a>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="selfie_rg" class="form-label">Selfie segurando o RG:</label>
                            <a href="../uploads/<?php echo $selfie_rg; ?>" target="_blank" class="form-control">Ver Documento</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function validateForm() {
    // Obtém todos os campos de input
    var inputs = document.querySelectorAll('input[required], select[required]');
    for (var i = 0; i < inputs.length; i++) {
        // Verifica se o campo está vazio
        if (!inputs[i].value) {
            alert("Por favor, preencha todos os campos obrigatórios.");
            inputs[i].focus(); // Foca no primeiro campo vazio
            return false; // Impede o envio do formulário
        }
    }
    return true; // Permite o envio do formulário
}
</script>


<!-- Modal de sucesso -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Dados Enviados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Seus dados foram enviados com sucesso e estão em análise. Você receberá um retorno em até 24 horas.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="window.location.href='../home';">Continuar</button>
            </div>
        </div>
    </div>
</div>


<!-- Inclua o Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Exibir o modal de sucesso se a mensagem for "success"
    <?php if ($message == "success"): ?>
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    <?php endif; ?>
</script>



                </div>
            </div>

<?php $content = ob_get_clean(); ?>
<!-- This code is useful for content -->

<!-- This code is useful for internal scripts  -->
<?php ob_start(); ?>

        <!-- Apex Charts JS -->
        <script src="<?php echo $baseUrl; ?>/assets/libs/apexcharts/apexcharts.min.js"></script>
        
 

<?php $scripts = ob_get_clean(); ?>
<!-- This code is useful for internal scripts  -->

<!-- This code use for render base file -->
<?php include '../layouts/base.php'; ?>
<!-- This code use for render base file -->

 

<!-- Internal Apex Area Charts JS -->
<script src="../assets/js/apexcharts-area.js"></script>













<!-- Internal Apex Area Charts JS -->
<script src="../assets/js/apexcharts-area.js"></script>



