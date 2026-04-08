## Transliterate

Невеликий пакет для транслітерації кирилиці з можливістю створення власних карт транслітерації.

- [Попередньо встановлені карти](#Попередньо-встановлені-карти)
- [Системні вимоги](#Системні-вимоги)
- [Встановлення](#Встановлення)
- [Конфігурація](#Конфігурація)
- [Використання](#Використання)
- [Створення карт транслітерації](#Створення-карт-транслітерації)
- [Створення трансформерів](#Створення-трансформерів)

## Попередньо встановлені карти

- Українська
    - Національна
- Російська
    - Дефолтна
    - ГОСТ 7.79 2000

## Системні вимоги
- laravel >= 9.0
- ext-intl

## Встановлення
```
> composer require digit-soft/transliterate
```

Якщо ви хочете використовувати аліас, додайте його в масив `facades` в `app.php`.

Рекомендую як аліас використовувати `Transliterate`, щоб уникнути конфліктів з класом `Transliterator` з розширення `Intl`.

```php
'Transliterate' => DigitSoft\Transliterate\Facade::class,
```

## Конфігурація

Для копіювання конфігу `transliterate.php` в директорію `configs` виконайте:

```
> php artisan vendor:publish --provider="DigitSoft\Transliterate\ServiceProvider"
```

## Використання

Ви можете використовувати фасад для транслітерації рядків.

```php
use Transliterate;

Transliterate::make('Двадцять тисяч льє під водою');
// "Dvadtsyat tysyach lie pid vodoiu"
```

Альтернативна карта транслітерації може бути передана другим параметром.

```php
use DigitSoft\Transliterate\Transliterator;

$transliterator = new Transliterator(Map::LANG_UK, Map::DEFAULT);
$transliterator->make('Двадцять тисяч льє під водою');
// "Dvadtsyat tysyach lie pid vodoiu"
```

## Генерація URL

Метод `slugify` генерує URL, видаляючи з рядка всі розділові знаки та замінюючи пробіли на "-".

```php
Transliterate::slugify('Жебракують філософи при ґанку церкви в Гадячі, ще й шатро розклали!');
// zhebrakuiut-filosofy-pry-ganku-tserkvy-v-hadyachi-shche-i-shatro-rozklaly
```

## Створення карт транслітерації

Кожна карта являє собою асоціативний масив із символами, що підлягають заміні, у якості ключів, та значеннями, на які вони будуть замінені.

Карта створюється у вигляді окремого файлу з масивом, що повертається:

```php
// /resources/maps/uk/ukrainian-v2.php

return [
    'ї' => 'i',
    'і' => 'i',
    'є' => 'ie',
];
```

Додайте шлях до створеної карти в масив `maps` конфігу `transliterate.php`:

```php
'ua' => [
    'ukraine' => dirname(__DIR__) . '/resources/maps/uk/ukrainian-v2.php',
]
```

Після цього карту можна використовувати.

```php
$transliterator = new Transliterator('ua', 'ukrainian-v2');
$transliterator->make('Ваша транслітерація');
```

## Створення трансформерів

Трансформери - функції, які будуть автоматично застосовані до результату транслітерації. Корисно, якщо вам необхідно щоразу виконувати одні й ті самі дії з рядком, що транслітерується. Реєструється трансформер у масиві `transformers`.

Наприклад, можна автоматично прибирати кінцеві пробіли.

```php
DigitSoft\Transliterate\Transformer::register(\Closure::fromCallable('trim')),
```

Або додатково приводити рядки до нижнього регістру.

```php
DigitSoft\Transliterate\Transformer::register(\Closure::fromCallable('trim')),
DigitSoft\Transliterate\Transformer::register(\Closure::fromCallable('strtolower')),
```

> Будьте уважні, оскільки трансформери застосовуються при кожному виклику `Transliterator::make`.

### Розробка

Для прогону PHPUnit тестів можна скористатися Dockerfile, що лежить у корені:

```bash
docker-compose up --build

...
php_1  | Runtime:       PHP 8.0.22
php_1  | Configuration: /srv/app/phpunit.xml
php_1  |
php_1  | .....                                                               5 / 5 (100%)
php_1  |
php_1  | Time: 00:00.959, Memory: 14.00 MB
php_1  |
php_1  | OK (5 tests, 6 assertions)
```
