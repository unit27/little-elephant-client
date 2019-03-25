# LittleElephantClient

## Instalacja

Instalacja z użyciem [composera](http://getcomposer.org).

Dodaj LittleElephantClient'a do swojego `composer.json`:

```json
{
    "require-dev": {
        "unit27/little-elephant-client": "^1.0"
    }
}
```

I zainstaluj:

```bash
$> composer install
```

Następnie udaj się do swojego panelu i wygeneruj klucz do api.

Na koniec zainicjuj gdziekolwiek w swojej aplikacji klienta używając w/w klucza.

```php
<?php
$client = new LittleElephantClient('twoj_klucz_api');
```

## Przykład użycia

```php
<?php
// inicjacja klienta
$client = new LittleElephantClient('twoj_klucz_api');

// skanowanie paragonu
$client->scan('sciezka_do_pliku.jpg', 'RECEIPT');

// to samo z uzyciem preprocesora graficznego
$token = $client->scanUsingPreprocessor('sciezka_do_pliku.jpg', 'RECEIPT');

// pobranie w/w rezultatu
$client->getResult($token);

// można również przekazać klucz api bezpośrednio do metody, jeśli np. chcesz rozdzielić klucze per aplikacja
$client->scan('sciezka_do_pliku.jpg', 'INVOICE', 'twoj_klucz_api_2');

// dokumenty są przypisywane zarówno do konta użytkownika, jak i do klucza api
// poniższy kod zwróci błąd braku dokumentu, ponieważ został dodany za pomocą innego klucza
$token = $client->scanUsingPreprocessor('sciezka_do_pliku.jpg', 'INVOICE', 'twoj_klucz_do_api');
$client->getResult($token, 'twoj_klucz_do_api_2');
```

## Dostępne typy dokumentów

```php
'RECEIPT' // paragon
'INVOICE' // faktura
'BUSINESS_CARD' // wizytówka
'AUTOMATIC' // typ dokumentu zostanie wykryty automatycznie; miej na uwadze, że może to zająć dużo więcej czasu
```