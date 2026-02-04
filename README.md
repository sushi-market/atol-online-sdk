# ATOL Online SDK for PHP

[![PHP Version](https://img.shields.io/badge/PHP-8.4%2B-blue.svg)](https://php.net)
[![Latest Version](https://img.shields.io/github/release/sushi-market/atol-online-sdk.svg?style=flat-square)](https://github.com/sushi-market/atol-online-sdk/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/sushi-market/atol-online-sdk.svg?style=flat-square)](https://packagist.org/packages/sushi-market/atol-online-sdk)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

SDK на основе версии документа **3.12**

Тестовые данные:
* URL (ФФД 1.2): `https://testonline.atol.ru/possystem/v5/`
* Компания: `АТОЛ`
* ИНН: `5544332219`
* Адрес расчетов: `https://v5.online.atol.ru`
* Код группы: `v5-online-atol-ru_5179`
* Логин: `v5-online-atol-ru`
* Пароль: `zUr0OxfI`

```php
use DF\AtolOnline\V5\AtolOnlineApi;
use DF\AtolOnline\V5\ValueObjects\Credentials;

$atol = new AtolOnlineApi(
    credentials: new Credentials(
        login: 'v5-online-atol-ru',
        password: 'zUr0OxfI',
        groupCode: 'v5-online-atol-ru_5179',
    ),
);
```

## 💰 Работа с НДС (VatType)

В SDK доступен enum `VatType`, который инкапсулирует тип ставки НДС для чеков Atol и содержит хелперы для расчёта суммы с НДС, выделения НДС и получения суммы без НДС.

Поддерживаются:
- обычные ставки (0%, 5%, 7%, 10%, 20%, 22%)
- расчетные ставки (5/105, 7/107, 10/110, 20/120, 22/122)
- режим без НДС

---

### Начисление НДС (из цены без НДС в цену с НДС)

```php
use DF\AtolOnline\V5\Enums\VatType;

$vat = VatType::VAT_20;

$net = 1000.00;
$gross = $vat->applyVat($net);

// 1200.00
```

### Выделение НДС из суммы с НДС

```php
use DF\AtolOnline\V5\Enums\VatType;

$vat = VatType::VAT_20;

$gross = 1200.00;
$vatAmount = $vat->extractVat($gross);

// 200.00
```

### Получение суммы без НДС

```php
use DF\AtolOnline\V5\Enums\VatType;

$vat = VatType::VAT_20;

$gross = 1200.00;
$net = $vat->removeVat($gross);

// 1000.00
```
