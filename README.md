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
