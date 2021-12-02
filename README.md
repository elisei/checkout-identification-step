# Checkout Identification Step

Implemente uma etapa para identificação do cliente no checkout, essa etapa pode ser definida para permitir a criação de conta e se permite a continuidade no checkout como um cliente não logado.

# Badges

Status Atual

[![Build Status](https://app.travis-ci.com/elisei/checkout-identification-step.svg?branch=Magento%402.3)](https://app.travis-ci.com/elisei/checkout-identification-step)
[![StyleCI](https://github.styleci.io/repos/432328264/shield?branch=Magento@2.3)](https://github.styleci.io/repos/432328264?branch=Magento@2.3)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/939d6dc3ac134fb384b67075bda95022)](https://www.codacy.com/gh/elisei/checkout-identification-step/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=elisei/checkout-identification-step&amp;utm_campaign=Badge_Grade)

Estatísticas

[![Total Downloads](https://poser.pugx.org/o2ti/checkout-identification-step/downloads)](https://packagist.org/packages/o2ti/checkout-identification-step)
[![Monthly Downloads](https://poser.pugx.org/o2ti/checkout-identification-step/d/monthly)](https://packagist.org/packages/o2ti/checkout-identification-step)

Versões

[![Latest Stable Version](https://poser.pugx.org/o2ti/checkout-identification-step/v/stable)](https://packagist.org/packages/o2ti/checkout-identification-step)

## Recursos

Um maior controle para o comportamento dos clientes no checkout, onde pode definir:

### Comportamento para clientes anonimos - Checkout como Convidado

Configure se deseja permitir a compra como um cliente convidado, nesse recurso a lógica de permissão não irá redirecionar o cliente ao formulário de cliente (customer page login) e sim atuar para que o cliente possa ou não prosseguir no checkout.

### Comportamento para clientes

Configure o comportamento para quando o usuário for identificado como um cliente que já pertencente a base de clientes da loja, para esse comportamento você pode definir:
- Associar pedidos feitos como anônimos/convidados na conta do cliente
- Permitir deslogar

### Comportamento para novos clientes

Configure o comportamento para quando  o usuário for identificado um novo cliente, para esse comportamento você pode definir:
- Criar conta na etapa
- Capturar o endereço na criação de conta

## Instalação e Configuração

Visite nossa [Wiki][wiki] e veja como configurar e instalar nosso módulo.

## License

[Open Source License](LICENSE.txt)
