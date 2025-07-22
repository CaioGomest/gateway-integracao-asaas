<?php
session_start();
include '../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

// Verifique a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

function generateRandomId($length = 24) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto_name = $_POST['produto_name'];
    $valor_checkout = $_POST['valor_checkout'];
    $obrigado_page = $_POST['obrigado_page'];
    $status = $_POST['status'];
    $email = $_SESSION['email']; // Pega o email da sessão
    $cliente_id = $_POST['cliente_id']; // Pega o cliente_id da sessão

    // Manipulação do upload da imagem do produto
    $logo_produto = '';
$target_dir = "../uploads/"; // Diretório para armazenar os uploads
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif']; // Extensões permitidas
$max_file_size = 5 * 1024 * 1024; // Tamanho máximo permitido para o arquivo (5MB)

// Verifica se o arquivo foi enviado sem erro
if (isset($_FILES['formFile']) && $_FILES['formFile']['error'] == UPLOAD_ERR_OK) {
    // Verifica se o diretório de destino existe, se não, cria
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = $_FILES["formFile"]["name"];
    $file_tmp = $_FILES["formFile"]["tmp_name"];
    $file_size = $_FILES["formFile"]["size"];
    
    // Obtém a extensão do arquivo
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Verifica se a extensão do arquivo é permitida
    if (!in_array($file_extension, $allowed_extensions)) {
        echo "Erro: Apenas arquivos de imagem (JPG, JPEG, PNG, GIF) são permitidos.";
        exit;
    }

    // Verifica o tamanho do arquivo
    if ($file_size > $max_file_size) {
        echo "Erro: O arquivo é muito grande. O tamanho máximo permitido é 5MB.";
        exit;
    }

    // Verifica o tipo MIME do arquivo
    $mime_type = mime_content_type($file_tmp);
    if (!in_array($mime_type, ['image/jpeg', 'image/png', 'image/gif'])) {
        echo "Erro: O arquivo não é uma imagem válida.";
        exit;
    }

    // Define o caminho completo do arquivo no diretório de destino
    $target_file = $target_dir . basename($file_name);

    // Move o arquivo para o diretório de destino
    if (move_uploaded_file($file_tmp, $target_file)) {
        $logo_produto = $target_file;
        echo "Upload da imagem do produto foi bem-sucedido.";
    } else {
        echo "Erro ao fazer upload da imagem do produto.";
        exit;
    }
} else {
    echo "Erro ao fazer upload da imagem do produto.";
    exit;
}


    // Manipulação do upload do banner
   $target_dir = "../uploads/";  // Diretório de destino para o upload
$banner_produto = '';
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif']; // Extensões permitidas
$max_file_size = 5 * 1024 * 1024; // Tamanho máximo do arquivo (5MB)

// Verifica se o arquivo foi enviado sem erro
if (isset($_FILES['bannerFile']) && $_FILES['bannerFile']['error'] == UPLOAD_ERR_OK) {
    $file_name = $_FILES["bannerFile"]["name"];
    $file_tmp = $_FILES["bannerFile"]["tmp_name"];
    $file_size = $_FILES["bannerFile"]["size"];
    
    // Obtém a extensão do arquivo
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Verifica se a extensão do arquivo é permitida
    if (!in_array($file_extension, $allowed_extensions)) {
        echo "Erro: Apenas arquivos de imagem (JPG, JPEG, PNG, GIF) são permitidos.";
        exit;
    }

    // Verifica o tamanho do arquivo
    if ($file_size > $max_file_size) {
        echo "Erro: O arquivo é muito grande. O tamanho máximo permitido é 5MB.";
        exit;
    }

    // Verifica o tipo MIME do arquivo
    $mime_type = mime_content_type($file_tmp);
    if (!in_array($mime_type, ['image/jpeg', 'image/png', 'image/gif'])) {
        echo "Erro: O arquivo não é uma imagem válida.";
        exit;
    }

    // Define o caminho completo do arquivo no diretório de destino
    $target_file_banner = $target_dir . basename($file_name);
    
    // Move o arquivo para o diretório de destino
    if (move_uploaded_file($file_tmp, $target_file_banner)) {
        $banner_produto = $target_file_banner;
        echo "Upload do banner foi bem-sucedido.";
    } else {
        echo "Erro ao fazer upload do banner.";
        exit;
    }
} else {
    echo "Erro ao fazer upload do banner.";
    exit;
}


    // Gera um ID aleatório
    $checkout_id = generateRandomId(24); // Gera um ID aleatório com 24 caracteres

    // Insere o registro inicial com a coluna key_gateway
    $sql = "INSERT INTO checkout_build (name_produto, valor, obrigado_page, logo_produto, banner_produto, ativo, email, url_checkout, key_gateway) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $url_checkout = "https://$_SERVER[HTTP_HOST]/checkout/v1/?id=$checkout_id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsssssss", $produto_name, $valor_checkout, $obrigado_page, $logo_produto, $banner_produto, $status, $email, $url_checkout, $cliente_id);

    if ($stmt->execute()) {
        echo "Novo checkout criado com sucesso!";
        header("Location: index.php"); // Redireciona para a página principal
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
