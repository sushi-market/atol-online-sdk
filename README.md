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
