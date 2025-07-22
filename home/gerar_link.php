session_start();

// Verifique se o e-mail está presente na sessão
if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit;
}

// Conexão com o banco
include '../conectarbanco.php';

// Consulta para obter a permissão do usuário
$email = $_SESSION['email'];
$sql = "SELECT permission FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($permission);
$stmt->fetch();
$stmt->close();

// Verifique se o usuário tem a permissão de afiliado (2)
if ($permission != 2) {
    // Redirecionar para a home se a permissão não for 2
    header("Location: ../home");
    exit;
}
