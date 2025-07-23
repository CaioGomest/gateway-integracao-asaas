<?php
function safe_number_format2($num, $decimals = 2) {
    // Se $num for null ou não for um número válido, substitui por 0
    return number_format(is_numeric($num) ? $num : 0, $decimals);
}
function formatarNumero($numero)
{
    if ($numero >= 1000000) {
        return safe_number_format2($numero / 1000000, 1, ',', '.') . 'M'; // Milhões
    } elseif ($numero >= 1000) {
        return safe_number_format2($numero / 1000, 1, ',', '.') . 'K'; // Milhares
    } else {
        return safe_number_format2($numero, 2, ',', '.'); // Formato normal
    }
}

// Criar a conexão usando as credenciais fornecidas no arquivo incluído
$cunnect = new mysqli('localhost', 'u214219698_gateway', '^2vjA:9nFMS', 'u214219698_gateway');

// Verificar a conexão
if ($cunnect->connect_error) {
    die("Conexão falhou: " . $cunnect->connect_error);
} 

if (!isset($_SESSION['user_id'])) {
    die("User ID não encontrado na sessão.");
}
$sexy_id = $_SESSION['user_id'];

$sumAmountSexy = 0;
// Consultar a soma dos valores na coluna amount para as linhas com status = 'PAID_OUT' e user_id correspondente
$sqlSumAmountSexy = "SELECT SUM(amount) AS sumAmountPaidOut FROM solicitacoes WHERE user_id = ? AND status = 'PAID_OUT'";
$stmtSumAmountSexy = $cunnect->prepare($sqlSumAmountSexy);
$stmtSumAmountSexy->bind_param("s", $sexy_id);
$stmtSumAmountSexy->execute();
$stmtSumAmountSexy->bind_result($sumAmountSexy);
$stmtSumAmountSexy->fetch();
$stmtSumAmountSexy->close();


$cunnect->close();

// Definindo as metas
$metas = [10000, 100000, 500000, 1000000];

$nextMeta = null;
foreach ($metas as $meta) {
    if ($sumAmountSexy < $meta) {
        $nextMeta = $meta;
        break;
    }
}

if ($nextMeta !== null) {
    $percentageAchieved = ($sumAmountSexy / $nextMeta) * 100;
} else {
    $percentageAchieved = 100;
}

?>

<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="../home" class="header-logo">
            <img src="../img/logo.png" alt="logo" class="desktop-logo" style="width: 250px; height: auto;">
            <img src="../img/logo.png" alt="logo" class="toggle-dark" style="width: 180px; height: auto;">
            <img src="../img/logo.png" alt="logo" class="desktop-dark" style="width: 250px; height: auto;">
            <img src="../img/logo.png" alt="logo" class="toggle-logo" style="width: 180px; height: auto;">
        </a>
    </div>

    <!-- End::main-sidebar-header -->




    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>

            <div style="padding: 16px;"> <!-- p-4 substituído por padding inline -->
                <p>R$ <?php echo safe_number_format2($sumAmountSexy, 2, ',', '.'); ?> / R$ <?php echo formatarNumero($nextMeta); ?></p>

                <div style="display: flex; flex-direction: row; gap: 4px; width: 100%; align-items: center;"> <!-- flex e gap substituídos por estilos inline -->
                    <div style="width: 70%; background-color: #e0e0e0; height: 8px; border-radius: 20px; overflow: hidden;">
                        <span style="display: block; width: <?php echo round($percentageAchieved, 2); ?>%; height: 8px; background-color: #39A1FF; border-radius: 20px; transition: width 0.3s ease;"></span>
                    </div>
                    <p style="margin: 0;"><?php echo round($percentageAchieved, 2); ?>%</p> <!-- Remover margens do parágrafo -->
                </div>
            </div>


            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Menu</span></li>
                <!-- End::slide__category -->





                <!-- Start::slide -->
                <li class="slide">
                    <a href="../home" class="side-menu__item">

                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32" viewBox="0 0 256 256">
                            <path d="M216,115.54V208a8,8,0,0,1-8,8H160a8,8,0,0,1-8-8V160a8,8,0,0,0-8-8H112a8,8,0,0,0-8,8v48a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V115.54a8,8,0,0,1,2.62-5.92l80-75.54a8,8,0,0,1,10.77,0l80,75.54A8,8,0,0,1,216,115.54Z" opacity="0.2"></path>
                            <path d="M218.83,103.77l-80-75.48a1.14,1.14,0,0,1-.11-.11,16,16,0,0,0-21.53,0l-.11.11L37.17,103.77A16,16,0,0,0,32,115.55V208a16,16,0,0,0,16,16H96a16,16,0,0,0,16-16V160h32v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V115.55A16,16,0,0,0,218.83,103.77ZM208,208H160V160a16,16,0,0,0-16-16H112a16,16,0,0,0-16,16v48H48V115.55l.11-.1L128,40l79.9,75.43.11.1Z"></path>
                        </svg>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <!-- End::slide -->



                <?php if ($status == 1): ?>






                    <!-- Start::slide -->
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32" viewBox="0 0 256 256">
                                <path d="M208,40V208H152V40Z" opacity="0.2"></path>
                                <path d="M224,200h-8V40a8,8,0,0,0-8-8H152a8,8,0,0,0-8,8V80H96a8,8,0,0,0-8,8v40H48a8,8,0,0,0-8,8v64H32a8,8,0,0,0,0,16H224a8,8,0,0,0,0-16ZM160,48h40V200H160ZM104,96h40V200H104ZM56,144H88v56H56Z"></path>
                            </svg>
                            <span class="side-menu__label">Relatorio</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)"></a>
                            </li>
                            <li class="slide">
                                <a href="../relatorio/pix-entrada.php" class="side-menu__item">Pix Entrada</a>
                            </li>

                            <li class="slide">
                                <a href="../relatorio/pix-saida.php" class="side-menu__item">Pix Saida</a>
                            </li>
                        </ul>
                    </li>
                    <!-- End::slide -->





                    <li class="slide">
                        <a href="../financeiro" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32" viewBox="0 0 256 256">
                                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm40-68a28,28,0,0,1-28,28h-4v8a8,8,0,0,1-16,0v-8H104a8,8,0,0,1,0-16h36a12,12,0,0,0,0-24H116a28,28,0,0,1,0-56h4V72a8,8,0,0,1,16,0v8h16a8,8,0,0,1,0,16H116a12,12,0,0,0,0,24h24A28,28,0,0,1,168,148Z"> </path>
                            </svg>
                            <span class="side-menu__label">Financeiro</span>

                        </a>
                    </li>




                    <li class="slide">
                        <a href="../checkout-build" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32" viewBox="0 0 256 256">
                                <path d="M216,48H40a8,8,0,0,0-8,8V216l32-16,32,16,32-16,32,16,32-16,32,16V56A8,8,0,0,0,216,48ZM112,160H64V96h48Z" opacity="0.2"></path>
                                <path d="M216,40H40A16,16,0,0,0,24,56V216a8,8,0,0,0,11.58,7.15L64,208.94l28.42,14.21a8,8,0,0,0,7.16,0L128,208.94l28.42,14.21a8,8,0,0,0,7.16,0L192,208.94l28.42,14.21A8,8,0,0,0,232,216V56A16,16,0,0,0,216,40Zm0,163.06-20.42-10.22a8,8,0,0,0-7.16,0L160,207.06l-28.42-14.22a8,8,0,0,0-7.16,0L96,207.06,67.58,192.84a8,8,0,0,0-7.16,0L40,203.06V56H216ZM136,112a8,8,0,0,1,8-8h48a8,8,0,0,1,0,16H144A8,8,0,0,1,136,112Zm0,32a8,8,0,0,1,8-8h48a8,8,0,0,1,0,16H144A8,8,0,0,1,136,144ZM64,168h48a8,8,0,0,0,8-8V96a8,8,0,0,0-8-8H64a8,8,0,0,0-8,8v64A8,8,0,0,0,64,168Zm8-64h32v48H72Z"></path>
                            </svg>
                            <span class="side-menu__label">Produtos</span>

                        </a>
                    </li>
                    
<li class="slide">
    <a href="../profile" class="side-menu__item">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24" style="margin-right: 12px;">
            <path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm10 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-8-5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm1.942 4a3 3 0 0 0-2.847 2.051l-.044.133-.004.012c-.042.126-.055.167-.042.195.006.013.02.023.038.039.032.025.08.064.146.155A1 1 0 0 0 6 17h6a1 1 0 0 0 .811-.415.713.713 0 0 1 .146-.155c.019-.016.031-.026.038-.04.014-.027 0-.068-.042-.194l-.004-.012-.044-.133A3 3 0 0 0 10.059 14H7.942Z" clip-rule="evenodd"></path>
        </svg>
        <span class="side-menu__label">Perfil</span>
    </a>
</li>

<li class="slide">
    <a href="#" class="side-menu__item">
<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24" style="margin-right: 12px;">
  <path d="M11 9a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z"/>
  <path fill-rule="evenodd" d="M9.896 3.051a2.681 2.681 0 0 1 4.208 0c.147.186.38.282.615.255a2.681 2.681 0 0 1 2.976 2.975.681.681 0 0 0 .254.615 2.681 2.681 0 0 1 0 4.208.682.682 0 0 0-.254.615 2.681 2.681 0 0 1-2.976 2.976.681.681 0 0 0-.615.254 2.682 2.682 0 0 1-4.208 0 .681.681 0 0 0-.614-.255 2.681 2.681 0 0 1-2.976-2.975.681.681 0 0 0-.255-.615 2.681 2.681 0 0 1 0-4.208.681.681 0 0 0 .255-.615 2.681 2.681 0 0 1 2.976-2.975.681.681 0 0 0 .614-.255ZM12 6a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z" clip-rule="evenodd"/>
  <path d="M5.395 15.055 4.07 19a1 1 0 0 0 1.264 1.267l1.95-.65 1.144 1.707A1 1 0 0 0 10.2 21.1l1.12-3.18a4.641 4.641 0 0 1-2.515-1.208 4.667 4.667 0 0 1-3.411-1.656Zm7.269 2.867 1.12 3.177a1 1 0 0 0 1.773.224l1.144-1.707 1.95.65A1 1 0 0 0 19.915 19l-1.32-3.93a4.667 4.667 0 0 1-3.4 1.642 4.643 4.643 0 0 1-2.53 1.21Z"/>
</svg>

        <span class="side-menu__label">Prêmios</span>
    </a>
</li>










                    <!-- Start::slide__category -->
                    <li class="slide__category"><span class="category-name">DESENVOLVEDOR</span></li>
                    <!-- End::slide__category -->



                    <li class="slide">
                        <a href="../documentacao" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32" viewBox="0 0 256 256">
                                <path d="M224,56V200a8,8,0,0,1-8,8H40a8,8,0,0,1-8-8V56a8,8,0,0,1,8-8H216A8,8,0,0,1,224,56Z" opacity="0.2"></path>
                                <path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,160H40V56H216V200ZM184,96a8,8,0,0,1-8,8H80a8,8,0,0,1,0-16h96A8,8,0,0,1,184,96Zm0,32a8,8,0,0,1-8,8H80a8,8,0,0,1,0-16h96A8,8,0,0,1,184,128Zm0,32a8,8,0,0,1-8,8H80a8,8,0,0,1,0-16h96A8,8,0,0,1,184,160Z"></path>
                            </svg>
                            <span class="side-menu__label">Documentação</span>

                        </a>
                    </li>


                    <li class="slide">
                        <a href="../gateway" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32" viewBox="0 0 256 256">
                                <path d="M216,96V208a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V96a8,8,0,0,1,8-8H208A8,8,0,0,1,216,96Z" opacity="0.2"></path>
                                <path d="M208,80H176V56a48,48,0,0,0-96,0V80H48A16,16,0,0,0,32,96V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V96A16,16,0,0,0,208,80ZM96,56a32,32,0,0,1,64,0V80H96ZM208,208H48V96H208V208Zm-68-56a12,12,0,1,1-12-12A12,12,0,0,1,140,152Z"></path>
                            </svg>
                            <span class="side-menu__label">Chaves API <span class="badge bg-primary ms-2 shadow-primary">1</span></span>

                        </a>
                    </li>



                <?php endif; ?>
                
           <?php if ($permission == 2): ?>
    <li class="slide">
        <a href="../home/gerar_link.php" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32" viewBox="0 0 256 256">
                <path d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z"> </path>
            </svg>
            <span class="side-menu__label">Meu Link</span>
        </a>
    </li>
<?php endif; ?>




                <?php if ($permission == 4): ?>
                    <!-- Start::slide__category -->
                    <li class="slide__category"><span class="category-name">COMPLIANCE</span></li>
                    <!-- End::slide__category -->

                <li class="slide">
                        <a href="../adm/usuarios.php" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32" viewBox="0 0 256 256">
                                <path d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z"> </path>
                            </svg>
                            <span class="side-menu__label">Usuarios</span>

                        </a>
                    </li>
                <?php endif; ?>
                    
        <!-- end compliance -->


                <?php if ($permission == 3): ?>
                    <!-- Start::slide__category -->
                    <li class="slide__category"><span class="category-name">ADMINISTRADOR</span></li>
                    <!-- End::slide__category -->


                    <li class="slide">
                        <a href="../adm/" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32" viewBox="0 0 256 256">
                                <path d="M112,56v48a8,8,0,0,1-8,8H56a8,8,0,0,1-8-8V56a8,8,0,0,1,8-8h48A8,8,0,0,1,112,56Zm88-8H152a8,8,0,0,0-8,8v48a8,8,0,0,0,8,8h48a8,8,0,0,0,8-8V56A8,8,0,0,0,200,48Zm-96,96H56a8,8,0,0,0-8,8v48a8,8,0,0,0,8,8h48a8,8,0,0,0,8-8V152A8,8,0,0,0,104,144Zm96,0H152a8,8,0,0,0-8,8v48a8,8,0,0,0,8,8h48a8,8,0,0,0,8-8V152A8,8,0,0,0,200,144Z" opacity="0.2"></path>
                                <path d="M200,136H152a16,16,0,0,0-16,16v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V152A16,16,0,0,0,200,136Zm0,64H152V152h48v48ZM104,40H56A16,16,0,0,0,40,56v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V56A16,16,0,0,0,104,40Zm0,64H56V56h48v48Zm96-64H152a16,16,0,0,0-16,16v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V56A16,16,0,0,0,200,40Zm0,64H152V56h48v48Zm-96,32H56a16,16,0,0,0-16,16v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V152A16,16,0,0,0,104,136Zm0,64H56V152h48v48Z"></path>
                            </svg>
                            <span class="side-menu__label">Dash</span>

                        </a>
                    </li>



                    <li class="slide">
                        <a href="../adm/usuarios.php" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32" viewBox="0 0 256 256">
                                <path d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z"> </path>
                            </svg>
                            <span class="side-menu__label">Usuarios</span>

                        </a>
                    </li>



                    <!-- Start::slide -->
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32" viewBox="0 0 256 256">
                                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm40-68a28,28,0,0,1-28,28h-4v8a8,8,0,0,1-16,0v-8H104a8,8,0,0,1,0-16h36a12,12,0,0,0,0-24H116a28,28,0,0,1,0-56h4V72a8,8,0,0,1,16,0v8h16a8,8,0,0,1,0,16H116a12,12,0,0,0,0,24h24A28,28,0,0,1,168,148Z"> </path>
                            </svg>
                            <span class="side-menu__label">Financeiro</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)"></a>
                            </li>
                            <li class="slide">
                                <a href="../adm-financeiro/transacoes.php" class="side-menu__item">Transações</a>
                            </li>
                            <li class="slide">
                                <a href="../adm-financeiro/carteiras.php" class="side-menu__item">Carteiras</a>
                            </li>

                            <li class="slide">
                                <a href="../adm-financeiro/entradas.php" class="side-menu__item">Entradas</a>
                            </li>

                            <li class="slide">
                                <a href="../adm-financeiro/saidas.php" class="side-menu__item">Saidas</a>
                            </li>
                            <li class="slide">
                                <a href="#" class="side-menu__item">Procurar transação</a>
                            </li>
                        </ul>
                    </li>
                    <!-- End::slide -->


                    <!-- Start::slide -->
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32" viewBox="0 0 256 256">
                                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm40-68a28,28,0,0,1-28,28h-4v8a8,8,0,0,1-16,0v-8H104a8,8,0,0,1,0-16h36a12,12,0,0,0,0-24H116a28,28,0,0,1,0-56h4V72a8,8,0,0,1,16,0v8h16a8,8,0,0,1,0,16H116a12,12,0,0,0,0,24h24A28,28,0,0,1,168,148Z"> </path>
                            </svg>
                            <span class="side-menu__label">Criar Transação</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)"></a>
                            </li>


                            <li class="slide">
                                <a href="../adm-criar/entrada.php" class="side-menu__item">Entrada</a>
                            </li>

                            <li class="slide">
                                <a href="../adm-criar/saida.php" class="side-menu__item">Saida</a>
                            </li>

                        </ul>
                    </li>
                    <!-- End::slide -->




                    <li class="slide">
                        <a href="../adm/saques_usuarios.php" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32" viewBox="0 0 256 256">
                                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm40-68a28,28,0,0,1-28,28h-4v8a8,8,0,0,1-16,0v-8H104a8,8,0,0,1,0-16h36a12,12,0,0,0,0-24H116a28,28,0,0,1,0-56h4V72a8,8,0,0,1,16,0v8h16a8,8,0,0,1,0,16H116a12,12,0,0,0,0,24h24A28,28,0,0,1,168,148Z"> </path>
                            </svg>
                            <span class="side-menu__label">Saques usuarios</span>

                        </a>
                    </li>



                    <!-- Start::slide -->
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32" viewBox="0 0 256 256">
                                <path d="M216,56H176V48a24,24,0,0,0-24-24H104A24,24,0,0,0,80,48v8H40A16,16,0,0,0,24,72V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V72A16,16,0,0,0,216,56ZM96,48a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96ZM216,72v41.61A184,184,0,0,1,128,136a184.07,184.07,0,0,1-88-22.38V72Zm0,128H40V131.64A200.19,200.19,0,0,0,128,152a200.25,200.25,0,0,0,88-20.37V200ZM104,112a8,8,0,0,1,8-8h32a8,8,0,0,1,0,16H112A8,8,0,0,1,104,112Z"> </path>
                            </svg>
                            <span class="side-menu__label">Ajustes Plataforma</span>
                            <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)"></a>
                            </li>
                            <li class="slide">
                                <a href="../adm-config/" class="side-menu__item">Adquirentes & taxas</a>
                            </li>
                            <li class="slide">
                                <a href="#" class="side-menu__item">SMTP E-MAIL</a>
                            </li>
                            <li class="slide">
                                <a href="#" class="side-menu__item">Segurança</a>
                            </li>

                        </ul>
                    </li>
                    <!-- End::slide -->





                <?php endif; ?>








            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>