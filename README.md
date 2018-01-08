# Conjunto de Classes utilitários


PHP CURRENCY
====================

Implementação que lhe permitirá formatar e realizar a conversão de valores entre moedas
Esta Classe lhe permite:
* Formar um valor para qualquer moeda definida
* Converter valores entre as moedas definidas

Requisitos
---

* PHP >= 5.6.0

Instalação com Composer (recomendado)
---

Adicione as seguintes linha ao seu arquivo `composer.json`:
	"crisnao2/currency": "dev-master"    
    

E então execute `composer update` via linha de comando.

ou

execute `composer require crisnao2/currency` no diretório de seu projeto



Instalação manual
---

* Faça o download da última versão.
* Para utilizar a classe do currency, você só precisa carregar o arquivo "src/Currency.php".

Usando
---

**exemplo 1**
Formatando
```php
<?php
    use \Crisnao2\Utils\Currency;

    // criando a configuração para REAL, passando todos os atributos
    $settings['BRL'] = array(
        'symbol_left'   => 'R$ ',
        'decimal_place' => 2,
        'decimal_point' => ',',
        'thousand_point' => '.',
    );

    $currency = new Currency($settings);

    echo $currency->format(1.00); // R$ 1,00
```

**exemplo 2**
Formatando
```php
<?php
	// criando a configuração para REAL, passando todos os atributos
    use \Crisnao2\Utils\Currency;

    // criando a configuração para REAL, passando todos os atributos
    $settings['BRL'] = array(
        'symbol_left'   => 'R$ ',
        'symbol_right'   => '',
        'decimal_place' => 2,
        'decimal_point' => ',',
        'thousand_point' => '.',
        'value' => 1.00
    );

    $currency = new Currency($settings);

    echo $currency->format(1.00); // R$ 1,00
```

**exemplo 3**
Convertendo de uma moeda para outro
```php
<?php
    use \Crisnao2\Utils\Currency;

    // criando a configuração para REAL, passando todos os atributos
    $settings['BRL'] = array(
        'symbol_left'   => 'R$ ',
        'decimal_place' => 2,
        'decimal_point' => ',',
        'thousand_point' => '.',
        'value' => 1.00
    );

    // criando a configuração para DOLLAR
    $settings['USD'] = array(
        'symbol_left'   => 'R$ ',
        'decimal_place' => 2,
        'decimal_point' => ',',
        'thousand_point' => '.',
        'value' => 0.3125
    );

    // como tem mais de uma moeda, indico qual será a default
    $currency = new Currency($settings, 'BRL');

    // de Real para Dollar
    echo $currency->convert(5, 'BRL', 'USD'); // 1.5625

    // de Dollar para Real
    echo $currency->convert(5, 'USD', 'BRL'); // 16
```

Contribua
---

1. Faça um fork
2. Crie sua branch para a funcionalidade (`git checkout -b nova-funcionalidade`)
3. Faça o commit suas modificações (`git commit -am 'Adiciona nova funcionalidade'`)
4. Faça o push para a branch (`git push origin nova-funcionalidade`)
5. Crie um novo Pull Request
