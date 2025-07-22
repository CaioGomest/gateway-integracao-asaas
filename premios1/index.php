<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="apple-touch-icon" sizes="76x76" href="../img/logo-favicon.png">
    <link rel="icon" type="image/png" href="../img/logo-favicon.png">
    <title>Prêmios JustPay</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #1e90ff;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 2.5em;
            text-align: center;
            margin-bottom: 50px;
        }

        .awards-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .award {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 20px;
            text-align: center;
            width: 300px;
        }

        .award img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .award h2 {
            font-size: 1.5em;
            margin: 20px 0;
        }

        .award p {
            font-size: 1em;
            color: #333;
        }

        footer {
            background-color: #1e90ff;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

    <header>
        <h1>Prêmios JustPay</h1>
    </header>

    <div class="container">
        <section class="awards-section">
            <div class="award">
                <img src="https://i.imgur.com/gkgdDM1.png" alt="Prêmio 1">
                <h2>Pulseiras de Faturamento</h2>
                <p>Pulseira Standard Faturamento 10K</p>
                <p>Pulseira Black Faturamento 1 Milhão</p>
            </div>

            <div class="award">
                <img src="https://i.imgur.com/MNxASUa.png" alt="Prêmio 2">
                <h2>Pacote Office</h2>
                <p>Pacote Office para Faturamento</p>
                <p>10K e 1 Milhão.</p>
            </div>

            <div class="award">
                <img src="https://i.imgur.com/jaqYUqy.png" alt="Prêmio 3">
                <h2>Camiseta JustPay</h2>
                <p>Camiseta personalizada para faturamentos acima de 500K.</p>
            </div>
            
            <div class="award">
                <img src="https://i.imgur.com/fJOkrKX.png" alt="Prêmio 3">
                <h2>Certificado 10K</h2>
                <p>Certificado de Faturamento 10K</p>
            </div>
            
            <div class="award">
                <img src="https://i.imgur.com/IRWhu3J.png" alt="Prêmio 3">
                <h2>Placa 100K</h2>
                <p>Placa de Faturamento 100K.</p>
            </div>
            
            <div class="award">
                <img src="https://i.imgur.com/GIV4xtG.png" alt="Prêmio 3">
                <h2>Placa 500K</h2>
                <p>Placa de Faturamento 500K.</p>
            </div>
            
            <div class="award">
                <img src="https://i.imgur.com/eLlxDp6.png" alt="Prêmio 3">
                <h2>Placa 1 Milhão</h2>
                <p>Placa de Faturamento 1 Milhão.</p>
            </div>
        </section>
    </div>

    <footer>
        <p>&copy; 2024 JustPay. Todos os direitos reservados.</p>
    </footer>
    
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

</body>
</html>
