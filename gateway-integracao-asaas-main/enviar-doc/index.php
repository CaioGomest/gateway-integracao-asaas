



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
    header("Location: ../");
    exit;
}

include '../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

// Verifica se houve algum erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Recuperar o e-mail da sessão
$email = $_SESSION['email'];
$message = ""; // Para armazenar mensagens

// Processar os dados do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf_cnpj = $_POST['cpf_cnpj'];
    $cep = $_POST['cep'];
    $rua = $_POST['rua'];
    $numero_residencia = $_POST['numero_residencia'];
    $complemento = $_POST['complemento'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $media_faturamento = $_POST['media_faturamento']; 

    // Processar os arquivos de upload e gerar nomes únicos
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";

$allowed_extensions = ['jpg', 'jpeg', 'png']; // Extensões permitidas
$max_file_size = 5 * 1024 * 1024; // 5MB

// Função para validar e mover arquivos
function upload_file($file, $prefix) {
    global $target_dir, $allowed_extensions, $max_file_size;

    if (!isset($_FILES[$file]) || $_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
        die("Erro ao enviar o arquivo $file.");
    }

    // Verifica se é uma imagem real
    $check = getimagesize($_FILES[$file]['tmp_name']);
    if ($check === false) {
        die("O arquivo enviado não é uma imagem válida ($file) ,volte e envie uma imagem!.");
    }

    // Obtém a extensão real do arquivo
    $ext = strtolower(pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_extensions)) {
        die("Extensão inválida para $file.");
    }

    // Verifica o tamanho do arquivo
    if ($_FILES[$file]['size'] > $max_file_size) {
        die("O arquivo $file é muito grande (máx. 5MB).");
    }

    // Gera um nome único
    $new_filename = uniqid($prefix) . '.' . $ext;
    
    // Move o arquivo para a pasta segura
    if (!move_uploaded_file($_FILES[$file]['tmp_name'], $target_dir . $new_filename)) {
        die("Erro ao salvar o arquivo $file.");
    }

    return $new_filename;
}

// Processa os arquivos com segurança
$foto_rg_frente = upload_file('foto_rg_frente', 'rg_frente_');
$foto_rg_verso = upload_file('foto_rg_verso', 'rg_verso_');
$selfie_rg = upload_file('selfie_rg', 'selfie_');

echo "Arquivos enviados com sucesso!";
    // Atualizar os dados do usuário na tabela users
    $sql = "UPDATE users SET 
                cpf_cnpj = ?, 
                cep = ?, 
                rua = ?, 
                numero_residencia = ?, 
                complemento = ?, 
                bairro = ?, 
                cidade = ?, 
                estado = ?, 
                media_faturamento = ?, 
                foto_rg_frente = ?, 
                foto_rg_verso = ?, 
                selfie_rg = ?, 
                status = 5 
            WHERE email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssss", $cpf_cnpj, $cep, $rua, $numero_residencia, $complemento, $bairro, $cidade, $estado, $media_faturamento, $foto_rg_frente, $foto_rg_verso, $selfie_rg, $email);

    if ($stmt->execute()) {
        $message = "success"; // Mensagem de sucesso
    } else {
        $message = "error: " . $stmt->error; // Mensagem de erro
    }

    $stmt->close();
}

$conn->close();
?>

<!-- HTML do formulário -->
<form method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
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
                            <input type="text" class="form-control" id="cpf-cnpj" name="cpf_cnpj" required placeholder="xxx.xxx.xxx-xx" maxlength="14">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="CEP" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="CEP" name="cep" required placeholder="xxxxx-xxx" maxlength="9">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="rua" class="form-label">Rua</label>
                            <input type="text" class="form-control" id="rua" name="rua" required placeholder="">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="numero_residencia" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero_residencia" name="numero_residencia" required placeholder="">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="complemento" class="form-label">Complemento:</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" required placeholder="">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="bairro" class="form-label">Bairro:</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" required placeholder="">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="cidade" class="form-label">Cidade:</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" required placeholder="">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="estado" class="form-label">Estado:</label>
                            <input type="text" class="form-control" id="estado" name="estado" required placeholder="">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Média de Faturamento mensal:</label>
                            <select class="form-control" name="media_faturamento" required>
                                <option value="">Selecione uma opção</option>
                                <option value="10000-30000">Entre R$ 10.000 - 30.000</option>
                                <option value="30000-100000">Entre R$ 30.000 - 100.000</option>
                                <option value="100000-400000">Entre R$ 100.000 - 400.000</option>
                                <option value="500000+">Acima de R$ 500.000</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="foto_rg_frente" class="form-label">Foto de frente RG ou Habilitação:</label>
                            <input class="form-control" type="file" id="foto_rg_frente" name="foto_rg_frente" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="foto_rg_verso" class="form-label">Foto do verso RG ou Habilitação:</label>
                            <input class="form-control" type="file" id="foto_rg_verso" name="foto_rg_verso" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="selfie_rg" class="form-label">Selfie segurando o RG:</label>
                            <input class="form-control" type="file" id="selfie_rg" name="selfie_rg" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary btn-wave waves-effect waves-light">
                        <i class="bi bi-plus-circle"></i> enviar
                    </button>
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

<!-- Pontuação CPF e CEP -->
<script>
function formatCPF(cpf) {
    cpf = cpf.replace(/\D/g, ""); // Remove qualquer coisa que não seja número
    cpf = cpf.substring(0, 11); // Limita a quantidade de caracteres a 11 (apenas números)
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // Adiciona ponto após os três primeiros dígitos
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // Adiciona outro ponto após os três dígitos
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // Adiciona hífen antes dos dois últimos dígitos
    return cpf;
}

function formatCEP(cep) {
    cep = cep.replace(/\D/g, ""); // Remove qualquer coisa que não seja número
    cep = cep.substring(0, 8); // Limita a quantidade de caracteres a 8 (apenas números)
    cep = cep.replace(/(\d{5})(\d)/, "$1-$2"); // Adiciona hífen após os cinco primeiros dígitos
    return cep;
}

document.getElementById('cpf-cnpj').addEventListener('input', function (e) {
    e.target.value = formatCPF(e.target.value);
});

document.getElementById('CEP').addEventListener('input', function (e) {
    e.target.value = formatCEP(e.target.value);
});
</script>
<!-- End Pontuação CPF e CEP -->

<script>
function buscarCEP(cep) {
    // Remove qualquer coisa que não seja número
    cep = cep.replace(/\D/g, '');

    // Verifica se o CEP tem o tamanho correto (8 dígitos)
    if (cep.length !== 8) {
        return;
    }

    // Faz a requisição para a API do ViaCEP
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (!("erro" in data)) {
                // Preenche os campos com os dados retornados pela API
                document.getElementById('rua').value = data.logradouro;
                document.getElementById('bairro').value = data.bairro;
                document.getElementById('cidade').value = data.localidade;
                document.getElementById('estado').value = data.uf;
            } else {
                // CEP não encontrado
                alert("CEP não encontrado.");
            }
        })
        .catch(error => {
            console.error("Erro ao buscar o CEP:", error);
            alert("Erro ao buscar o CEP. Tente novamente mais tarde.");
        });
}

// Adiciona o evento no campo de CEP para buscar os dados após digitar o CEP completo
document.getElementById('CEP').addEventListener('input', function (e) {
    let cep = e.target.value;
    // Quando o CEP tiver 8 dígitos, chamamos a função de busca
    if (cep.length === 9) { // Considerando o formato "xxxxx-xxx"
        buscarCEP(cep);
    }
});
</script>













<!-- Internal Apex Area Charts JS -->
<script src="../assets/js/apexcharts-area.js"></script>



