# Frenet Rates Conversion by MagedIn

This module can be used to convert Frenet quotations from a given currency, like US Dollar, to the current store currency.

## Premissas

Para que este módulo seja útil para você é preciso que:

- Você tenha um Magento 2 configurado com, pelo menos, duas moedas diferentes;
- Você tenha uma moeda base que não seja USD, por exemplo.

## O Problema

Quando você faz cotações para o exterior utilizando a Frenet, a DHL retorna os valores dos fretes em dólar e a Frenet não identifica a moeda que está sendo retornada.
Quando o Magento apresenta esse valor, ele converte o valor para o valor da moeda atual do frontend.
O problema é que, quando a sua moeda base não é dólar, o Magento faz uma conversão errada para o serviço da DHL em questão.

Vamos exemplificar melhor:

Consideraremos um Magento com a seguinte configuração de moeda:

- Moeda Base: BRL
- Moeda da Loja: USD

Consideramos que:

- 1,00 BRL = 0.18 USD

Fizemos uma cotação de um carrinho para o CEP: 1000-005, Portugal.
A DHL retornou um frete no valor de USD 100.00 para a Frenet, que apenas repassou esse valor como resposta na requisição, não identificando que a moeda é dólar.
O Magento recebe USD 100.00 e, ele entende que esse é o valor na moeda base, ou seja, BRL.
Automaticamente ele faz a conversão de BRL para USD, que resultaria USD 18.00.
Este é o valor apresentado na front store da loja, o que está incorreto.

## O que este módulo faz

Este módulo faz a conversão correta do valor que vem da Frenet para que o Magento aplique a conversão corretamente no resultado.
Seguindo o exemplo acima, este módulo dividiria USD 100.00 por USD 0.18, resultando em R$ 555,56.
O Magento, por sua vez, faz a conversão de R$ 555,56 x USD 0.18, o que resulta em USD 100.00 novamente, o valor correto da cotação.
