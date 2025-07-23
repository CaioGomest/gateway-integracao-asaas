<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Testar Integração Asaas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        form {
            width: 300px;
            margin: auto;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
        }
        #resultado {
            margin-top: 20px;
            font-size: 14px;
            white-space: pre-wrap;
            word-break: break-word;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <h2>Testar Integração Asaas</h2>
    <form id="asaasForm">
        <label>Nome:</label>
        <input type="text" name="name" required>
        
        <label>CPF:</label>
        <input type="text" name="cpf" required>
        
        <label>Email:</label>
        <input type="email" name="email">
        
        <label>Valor:</label>
        <input type="number" step="0.01" name="amount" required>
        
        <label>Tipo de Pagamento:</label>
        <select name="tipoPagamento" required>
            <option value="PIX">PIX</option>
            <option value="CREDIT_CARD">Cartão</option>
            <option value="BOLETO">Boleto</option>
        </select>
        
        <button type="submit">Enviar</button>
    </form>
    
    <div id="resultado"></div>
    
    <script>
document.getElementById('asaasForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = {};
    formData.forEach((value, key) => data[key] = value);

    // Adiciona ação explícita
    data.action = 'create';

    const url = 'https://gateway.stackcode.com.br/api.seusite/v1/adquirente/asaas/processa_pagamento.php';
    const resultadoEl = document.getElementById('resultado');
    resultadoEl.innerText = 'Processando...';

    try {
        const resp = await fetch(url, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        });
        const result = await resp.json();
        resultadoEl.innerText = JSON.stringify(result, null, 2);

        // Se PIX, mostrar QR e opcionalmente reconsultar
        if (result.tipo === 'PIX') {
            if (result.qrCodeImage) {
                resultadoEl.innerHTML += `<br><img src="data:image/png;base64,${result.qrCodeImage}" style="width:200px;margin-top:10px;">`;
            }

            // (Opcional) Reconsulta para garantir que o QR está válido/atualizado
            if (result.idTransaction) {
                const consulta = await fetch(url, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        action: 'pix_qrcode',
                        idTransaction: result.idTransaction
                    })
                });
                const pixData = await consulta.json();
                resultadoEl.innerHTML += `<pre>${JSON.stringify(pixData, null, 2)}</pre>`;
                if (pixData.qrCodeImage) {
                    resultadoEl.innerHTML += `<br><img src="data:image/png;base64,${pixData.qrCodeImage}" style="width:200px;margin-top:10px;">`;
                }
            }
        }
    } catch (err) {
        resultadoEl.innerText = 'Erro: ' + err;
    }
});
</script>

</body>
</html>
