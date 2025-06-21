![Laravel Pay Pocket](https://github.com/user-attachments/assets/8e8ebcf6-f8d4-4811-b97c-fb6362e3f019)

# Laravel Pay Pocket

[![Latest Version on Packagist](https://img.shields.io/packagist/v/toneflix-code/laravel-pay-pocket.svg?style=flat-square)](https://packagist.org/packages/toneflix-code/laravel-pay-pocket)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/toneflix/laravel-pay-pocket/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/toneflix/laravel-pay-pocket/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/toneflix/laravel-pay-pocket/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/toneflix/laravel-pay-pocket/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Imports](https://github.com/toneflix/laravel-pay-pocket/actions/workflows/check_imports.yml/badge.svg?branch=main)](https://github.com/toneflix/laravel-pay-pocket/actions/workflows/check_imports.yml)
[![codecov](https://codecov.io/gh/toneflix/laravel-pay-pocket/graph/badge.svg?token=4A0pTNRHsG)](https://codecov.io/gh/toneflix/laravel-pay-pocket)
[![Downloads](https://img.shields.io/packagist/dt/hpwebdeveloper/laravel-pay-pocket.svg?style=flat-square&label=<3.x+Downloads)](https://packagist.org/packages/hpwebdeveloper/laravel-pay-pocket)
[![Total Downloads](https://img.shields.io/packagist/dt/toneflix-code/laravel-pay-pocket.svg?style=flat-square&label=3.x+Downloads)](https://packagist.org/packages/toneflix-code/laravel-pay-pocket)

**Laravel Pay Pocket** is a package designed for Laravel applications, offering the flexibility to manage multiple wallet types within two dedicated database tables, `wallets` and `wallets_logs`.

**Videos:**

-   [Laravel Pay Pocket Package: Virtual Wallets in Your Project](https://www.youtube.com/watch?v=KoQyURiwsA4)

-   [Laravel Exceptions: Why and How to Use? Practical Example.](https://www.youtube.com/watch?v=-Sr18w91v8Q)

-   [PHP Enums in Laravel: Practical Example from Package](https://www.youtube.com/watch?v=iUOb-3HQtK8)

**Note:** This package does not handle payments from payment platforms, but instead offers the concept of virtual money, deposit, and withdrawal.

-   **Author**: Hamed Panjeh | Hamza's Legacy
-   **Vendor**: toneflix-code
-   **Package**: laravel-pay-pocket
-   **Alias name**: Laravel PPP (Laravel Pay Pocket Package)
-   **Version**: `3.x`
-   **PHP Version**: 8.2+
-   **Laravel Version**: `11.x`, `12.x`
-   **[Composer](https://getcomposer.org/):** `composer require toneflix-code/laravel-pay-pocket`

### About This Fork

This package is a maintained and community-inclusive fork of `hpwebdeveloper/laravel-pay-pocket`.

> **Why Toneflix?** The original repo has seen little to no maintenance in a while, and pull requests with useful features and bug fixes have been neglected. This fork merges all major pending contributions and begins a new, more active journey under `toneflix-code/laravel-pay-pocket`.

### What’s new in 3.x?

-   All important open PRs from the base package are reviewed and merged
-   Bugs and rough edges smoothed out
-   Cleaner structure for Laravel apps
-   Full backward compatibility with the original package (in most cases)
-   More responsive to issues and contributions
-   Actively maintained — contributions welcome
-   Support for Laravel 12.x with up-to-date dependencies
-   Continued support and versioning going forward

### Migrating?

If you're coming from `hpwebdeveloper/laravel-pay-pocket`, just update your composer.json:

```json
"require": {
  "toneflix-code/laravel-pay-pocket": "^3.0"
}
```

Run:

```bash
composer update
```

Then update your imports:

`- HPWebdeveloper\LaravelPayPocket`  
`+ ToneflixCode\LaravelPayPocket`

Everything should work as expected. Open a PR if anything breaks.

### Support Policy

| Version                                        | Laravel      | PHP           | Release date  | End of improvements | End of support |
| ---------------------------------------------- | ------------ | ------------- | ------------- | ------------------- | -------------- |
| 1.x                                            | ^10.0        | 8.1, 8.2, 8.3 | Nov 30, 2023  | Mar 1, 2024         | June 21 2025   |
| 2.x                                            | ^10.0, ^11.0 | 8.2, 8.3      | June 27, 2024 | January 30, 2025    | June 21 2025   |
| 3.x (atomic operations and restricted wallets) | ^11.0, ^12.0 | 8.2, 8.3, 8.4 | June 21 2025  | January 29, 2026    |                |

## Installation:

-   **Step 1:** You can install the package via composer:

```bash
composer require toneflix-code/laravel-pay-pocket
```

-   **Step 2:** Publish and run the migrations with:

```bash
php artisan vendor:publish --tag="pay-pocket-migrations"
php artisan migrate
```

You have successfully added two dedicated database tables, `wallets` and `wallets_logs`, without making any modifications to the `users` table.

-   **Step 3:** Publish the wallet types using

```bash
php artisan vendor:publish --tag="pay-pocket-wallets"
php artisan vendor:publish --tag="config"
```

This command will automatically publish the `pay-pocket.php` config file and also `WalletEnums.php` file into your application's `config` and `app/Enums` directories respectively.

## Updating

If coming from version prior to `^2.0`, new migration and config files have been added to support the new [Transaction Notes Feature](#transaction-notes-8)

Follow the [Installation](#installation) Steps 2 and 3 to update your migrations.

## Preparation

### Prepare User Model

To use this package you need to implement the `WalletOperations` into `User` model and utilize the `ManagesWallet` trait.

```php

use ToneflixCode\LaravelPayPocket\Interfaces\WalletOperations;
use ToneflixCode\LaravelPayPocket\Traits\ManagesWallet;

class User extends Authenticatable implements WalletOperations
{
    use ManagesWallet;
}
```

### Prepare Wallets

In Laravel Pay Pocket, you have the flexibility to define the order in which wallets are prioritized for payments through the use of Enums. The order of wallets in the Enum file determines their priority level. The first wallet listed has the highest priority and will be used first for deducting order values.

For example, consider the following wallet types defined in the Enum class (published in step 3 of installation):

```php
namespace App\Enums;

enum WalletEnums: string
{
    case WALLET_MAIN = 'wallet_main';
    case WALLET_ESCROW = 'wallet_escrow';
}

```

**You have complete freedom to name your wallets as per your requirements and even add more wallet types to the Enum list.**

In this particular setup, `wallet_main` (`WALLET_MAIN`) is given the **highest priority**. When an order payment is processed, the system will first attempt to use `wallet_main` to cover the cost. If `wallet_main` does not have sufficient funds, `wallet_escrow` (`WALLET_ESCROW`) will be used next.

### Example:

If the balance in `wallet_main` is 10 and the balance in `wallet_escrow` is 20, and you need to pay an order value of 15, the payment process will first utilize the entire balance of `wallet_main`. Since `wallet_main`'s balance is insufficient to cover the full amount, the remaining 5 will be deducted from `wallet_escrow`. After the payment, `wallet_escrow` will have a remaining balance of 15."

## Usage, APIs and Operations:

### Deposit

```php
deposit(type: string, amount: float|int, notes: string null)
```

Deposit funds into `wallet_main`

```php
$user = auth()->user();
$user->deposit('wallet_main', 123.45);
```

Deposit funds into `wallet_escrow`

```php
$user = auth()->user();
$user->deposit('wallet_escrow', 67.89);
```

Or using provided facade

```php
use ToneflixCode\LaravelPayPocket\Facades\LaravelPayPocket;

$user = auth()->user();
LaravelPayPocket::deposit($user, 'wallet_main', 123.45);

```

Note: `wallet_main` and `wallet_escrow` must already be defined in the `WalletEnums`.

#### Transaction Info ([#8][i8])

When you need to add descriptions for a specific transaction, the `$notes` parameter enables you to provide details explaining the reason behind the transaction.

```php
$user = auth()->user();
$user->deposit('wallet_main', 67.89, 'You sold pizza.');
```

### Pay

```php
pay(amount: int, allowedWallets: array [], notes: string null)
```

Pay the value using the total combined balance available across all allowed wallets

```php
$user = auth()->user();
$user->pay(12.34);
```

Or using provided facade

```php
use ToneflixCode\LaravelPayPocket\Facades\LaravelPayPocket;

$user = auth()->user();
LaravelPayPocket::pay($user, 12.34);
```

By default the sytem will attempt to pay using all available wallets unless the `allowedWallets` param is provided.

#### Allowed Wallets ([#8][i8])

Sometimes you want to mark certain wallets as allowed so that when the `pay()` method is called, the system does not attempt to charge other wallets, a possible use case is an escrow system, the `$allowedWallets` param of the pay method allows you to do just that.

```php
$user = auth()->user();
$user->pay(12.34, ['wallet_main']);
```

When the `$allowedWallets` param is provided and is not an empty array, the system would attempt to charge only the wallets specified in the array.

#### Transaction Notes ([#8][i8])

In a case where you want to enter descriptions for a particular transaction, the `$note` param allows you to provide information about why a transaction happened.

```php
$user = auth()->user();
$user->pay(12.34, [], 'You ordered pizza.');
```

### Balance

-   **Wallets**

```php
$user->walletBalance // Total combined balance available across all wallets

// Or using provided facade

LaravelPayPocket::checkBalance($user);
```

-   **Particular Wallet**

```php
$user->getWalletBalanceByType('wallet_main') // Balance available in wallet_main
$user->getWalletBalanceByType('wallet_escrow') // Balance available in wallet_escrow

// Or using provided facade

LaravelPayPocket::walletBalanceByType($user, 'wallet_main');
```

### Exceptions

Upon examining the `src/Exceptions` directory within the source code,
you will discover a variety of exceptions tailored to address each scenario of invalid entry. Review the [demo](https://github.com/toneflix/demo-pay-pocket) that accounts for some of the exceptions.

### Log

A typical `wallets_logs` table.
![Laravel Pay Pocket Log](https://github.com/user-attachments/assets/0d7f2237-88e1-4ac0-a4f2-ac200bad9273)

## Testing

```bash
composer install

composer test


// Or

./vender/bin/pest
```

## TODO:

-   [ ] Encrypt wallet balances before storage and decrypt during retrieval.

-   [ ] Encrypt wallet amount in logs before storage and decrypt during retrieval.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Hamed Panjeh](https://github.com/toneflix)
-   [All Contributors](../../contributors)
-   Icon in the above image: pocket by Creative Mahira from [Noun Project](https://thenounproject.com/browse/icons/term/pocket/) (CC BY 3.0)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[i8]: https://github.com/toneflix/laravel-pay-pocket/releases/tag/2.0.0
