<h1 align="center" style="font-size: xxx-large"><b style="color: red">Я</b>ндекс метрика</h1>

<h3 align="center">Библиотека для удобного взаимодействия с Yandex Metrika API</h3>

<p align="center">
    <a href="https://php.net"><img alt="PHP 7.4" src="https://img.shields.io/badge/PHP-5.6-777BB4?style=for-the-badge&logo=php"></a>
</p>

### Получение токена
1. Переходим на страницу [oauth.yandex.ru](https://oauth.yandex.ru/)
2. Нажимаем "Зарегистрировать новое приложение"
3. Вписываем название и выбираем "Получение статистики, чтение параметров своих и доверенных счетчиков"
4. Выбираем "Подставить URL для разработки"
5. Копируем ID
6. Переходим по ссылке: `https://oauth.yandex.ru/authorize?response_type=token&client_id=ВАШ ID`
7. Подтверждаем запрос


### Client Code
```php
$token = '';
$counterId = '';

$YaMetrika = new YaMetrika($token, $counterId);

$search = $YaMetrika->getUsersSearchEngine();
```

### Пользователи из поисковых систем
#### За последние N дней
```php
public function getUsersSearchEngine($days = 30, $limit = 10) : array
```
Название | Тип | Описание
---------|-----|----------------------
$days | integer | Кол-во дней. По умолчанию 30
$limit | integer | Лимит записей. По умолчанию 10

#### За указанный период
```php
public function getUsersSearchEngineForPeriod(DateTime $startDate, DateTime $endDate, $limit = 10) : array 
```
Название | Тип | Описание
---------|-----|----------------------
$startDate | DateTime | Начальная дата
$endDate | DateTime | Конечная дата
$limit | integer | Лимит записей. По умолчанию 10

## Автор
[Alexey Marchenko](https://github.com/mavrin88), e-mail: [mavrin_88@mail.ru](mailto:mavrin_88@mail.ru)

## Лицензия
Основой Yandex Metrika API являет открытый исходный код, в соответствии [MIT license](https://opensource.org/licenses/MIT)
