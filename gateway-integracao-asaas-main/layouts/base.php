<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="dark" data-header-styles="transparent" data-width="default" data-menu-styles="dark" data-toggled="close">

    <head>

        <!-- Meta Data -->
		<meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="JustPay">
        <meta name="Author" content="JustPay">
        <meta name="keywords" content="JustPay">
        
        <!-- TITLE -->
		<title>Abacash</title>

        <!-- FAVICON -->
        <link rel="icon" href="../img/favicon.png" type="image/x-icon">

        <!-- BOOTSTRAP CSS -->
	    <link  id="style" href="<?php echo $baseUrl; ?>assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- STYLES CSS -->
        <link href="<?php echo $baseUrl; ?>assets/css/styles.css" rel="stylesheet">
        
        <!-- ICONS CSS -->
        <link href="<?php echo $baseUrl; ?>assets/icon-fonts/icons.css" rel="stylesheet">

        <?php include '../layouts/components/styles.php'; ?>
        
        <!-- MAIN JS -->
        <script src="<?php echo $baseUrl; ?>assets/js/main.js"></script>

        <?php echo $styles; ?>

	</head>

    <body>

        <!-- SWITCHER -->
        <?php include '../layouts/components/switcher.php'; ?>

        <!-- END SWITCHER -->

        <!-- LOADER -->
        <div id="loader">
            <img src="<?php echo $baseUrl; ?>/assets/images/media/loader.svg" alt="">
        </div>
        <!-- END LOADER -->

        <!-- PAGE -->
        <div class="page">

            <!-- HEADER -->
            <?php include '../layouts/components/header.php'; ?>

            <!-- END HEADER -->

            <!-- SIDEBAR -->
            <?php include '../layouts/components/sidebar.php'; ?>

            <!-- END SIDEBAR -->

            <!-- MAIN-CONTENT -->
            <?php echo $content; ?>
            <!-- END MAIN-CONTENT -->

            <!-- FOOTER -->
            <?php include '../layouts/components/footer.php'; ?>

            <!-- END FOOTER -->

        </div>
        <!-- END PAGE-->

        <!-- SCRIPTS -->
        <?php include '../layouts/components/scripts.php'; ?>

        <?php echo $scripts; ?>

        <!-- STICKY JS -->
        <script src="<?php echo $baseUrl; ?>/assets/js/sticky.js"></script>

        <!-- DEFAULTMENU JS -->
        <script src="<?php echo $baseUrl; ?>/assets/js/defaultmenu.js"></script>

        <!-- CUSTOM JS -->
        <script src="<?php echo $baseUrl; ?>/assets/js/custom.js"></script>
        
        <!-- CUSTOM-SWITCHER JS -->
        <script src="<?php echo $baseUrl; ?>/assets/js/custom-switcher.js"></script>

        <!-- END SCRIPTS -->

    </body>
            <script>
    // Bloquear o console do desenvolvedor
    Object.defineProperty(window, 'console', {
        value: console,
        writable: false,
        configurable: false
    });

    // Bloquear o botão direito do mouse
    window.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    });
</script>
        
</html>