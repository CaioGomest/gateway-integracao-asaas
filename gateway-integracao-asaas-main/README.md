# Gateway Integração Asaas

Este projeto é uma integração do **Banco Asaas** em um gateway de pagamentos, utilizando o **ambiente de testes (sandbox)** fornecido pelo Asaas.

## Acesso ao Painel
Para visualizar o painel ativo, acesse:  
[https://gateway.stackcode.com.br/](https://gateway.stackcode.com.br/)

## Teste de Pagamentos
Para testar o checkout de pagamento, utilize o link:  
[https://gateway.stackcode.com.br/checkout/v1/?id=RxfaCswsD8o5GZXSsno0RD7k](https://gateway.stackcode.com.br/checkout/v1/?id=RxfaCswsD8o5GZXSsno0RD7k)

### Dados de Cartão de Crédito (Sandbox)
No ambiente de teste, utilize os cartões disponibilizados pelo Asaas.  
Exemplo de cartão de crédito para testes:

- **Número do Cartão:** `4444 4444 4444 4444`  
- **Vencimento:** Qualquer mês posterior à data atual  
- **CVV:** `123` (ou qualquer outro conjunto de 3 números aleatórios)

Mais exemplos podem ser encontrados na documentação oficial do Asaas:  
[http://docs.asaas.com/docs/como-testar-funcionalidades](http://docs.asaas.com/docs/como-testar-funcionalidades)

---

## Sobre o Projeto
- Integração desenvolvida em PHP.
- Utiliza as funções de API do Asaas para geração de pagamentos.
- Ambiente de testes para simulação de transações.

---
