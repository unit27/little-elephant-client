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

Następnie udaj się do swojego [panelu](https://little-elephant.me/user/panel/apiKeys) i wygeneruj klucz do api.

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

## Przykłady zwrotek

Wizytówka

```php
print_r($client->scan('sciezka_do_pliku.jpg', 'BUSINESS_CARD'));
// LittleElephantClient\Model\BusinessCard Object
// (
//     [fullName:LittleElephantClient\Model\BusinessCard:private] => Jan Testowy
//     [telephones:LittleElephantClient\Model\BusinessCard:private] => Array
//         (
//             [0] => (+48) 666 000 000
//         )
// 
//     [email:LittleElephantClient\Model\BusinessCard:private] => jan@testowy.pl
//     [website:LittleElephantClient\Model\BusinessCard:private] => testowy.pl
// )
```

Paragon

```php
print_r($client->scan('sciezka_do_pliku.jpg', 'RECEIPT'));
// LittleElephantClient\Model\Receipt Object
// (
//     [deviceNumber:LittleElephantClient\Model\Receipt:private] => CAC 1231231231
//     [nip:LittleElephantClient\Model\Receipt:private] => 1231231231
//     [value:LittleElephantClient\Model\Receipt:private] =>
//     [createdDate:LittleElephantClient\Model\Receipt:private] => DateTimeImmutable Object
//     (
//         [date] => 2019-03-18 18:02:00.000000
//         [timezone_type] => 3
//         [timezone] => UTC
//         )
//    
//     [companyName:LittleElephantClient\Model\Receipt:private] => Sklep testowy
//     [postalCode:LittleElephantClient\Model\Receipt:private] =>
//     [address:LittleElephantClient\Model\Receipt:private] => ul. Testowa 11 99-120 Testowo
//     [items:LittleElephantClient\Model\Receipt:private] => Array
//     (
//         [0] => LittleElephantClient\Model\Partial\ReceiptItem Object
//         (
//             [name:LittleElephantClient\Model\Partial\BaseItem:private] => Item
//             [value:LittleElephantClient\Model\Partial\BaseItem:private] => 9.49
//             )
//        
//         [1] => LittleElephantClient\Model\Partial\ReceiptItem Object
//         (
//             [name:LittleElephantClient\Model\Partial\BaseItem:private] => Item 2
//             [value:LittleElephantClient\Model\Partial\BaseItem:private] => 6.99
//             )
    
//     [additionalInformation:LittleElephantClient\Model\Receipt:private] => Array
//     (
//         [posNumber] => 666
//         [employeeNumber] => 1234
//         [receiptNumber] => 1F21545u75623
//         )
//    
//     )
```

Faktura

```php
print_r($client->scan('sciezka_do_pliku.jpg', 'INVOICE'));
// LittleElephantClient\Model\Invoice Object
// (
//     [buyerNip:LittleElephantClient\Model\Invoice:private] => 1231231231
//     [sellerNip:LittleElephantClient\Model\Invoice:private] => 3213123123
//     [totalPurchaseValue:LittleElephantClient\Model\Invoice:private] => 1111.39
//     [number:LittleElephantClient\Model\Invoice:private] => FD/D/2018/4085
//     [items:LittleElephantClient\Model\Invoice:private] => Array
//     (
//         [0] => LittleElephantClient\Model\Partial\InvoiceItem Object
//         (
//             [name:LittleElephantClient\Model\Partial\BaseItem:private] => Item
//             [value:LittleElephantClient\Model\Partial\BaseItem:private] => 1000.00
//             )
//        
//         [1] => LittleElephantClient\Model\Partial\InvoiceItem Object
//         (
//             [name:LittleElephantClient\Model\Partial\BaseItem:private] => Item 2
//             [value:LittleElephantClient\Model\Partial\BaseItem:private] => 111.39
//             )
//    
//     [addresses:LittleElephantClient\Model\Invoice:private] => Array
//     (
//         [0] => Array
//         (
//             [latitude] => 50.0052779
//             [longitude] => 20.0151831
//             [address] => Array
//             (
//                 [country] => Polska
//                 [region] => podkarpackie
//                 [city] => Testowo Małe
//                 [street] => Array
//                 (
//                     [name] => Testowa
//                     [number] => 7
//                     )
//                
//                 [postalCode] => 99-020
//                 )
//            
//             [formattedAddress] => Kosocicka 7, 32-020 Kraków, Polska
//             )
//    
//     [createdDate:LittleElephantClient\Model\Invoice:private] => DateTimeImmutable Object
//     (
//         [date] => 2018-02-17 12:00:00.000000
//         [timezone_type] => 3
//         [timezone] => UTC
//         )
//    
//     )
```