# TroPay Laravel Package Integration

## Installation

`composer require trodevit/tropay:dev-main`

### Usage
1. At First create an account on our website TroPay.
2. Store your mobile banking credentials in our database.
3. Call it to your controller

```php
use TrodevIT\TroPay\Helpers;

$bkash = new Client();
$payment = $bkash->createPayment($amount);
```

4. In your callback controller

```php
$paymentID = $request->query('paymentID');
$bkash = new Client();
$result = $bkash->executePayment($paymentID);
```
