# Payment Accounts — Silverstripe Module

A Silverstripe module for managing payment accounts. It supports multiple account types:

- **Bank accounts** — IBAN, BIC, bank name
- **Credit cards** — card type, last 4 digits, expiry date
- **Online accounts** — provider (PayPal, Stripe, Klarna, Apple Pay, Google Pay), account e-mail

## Installation

```bash
composer require clesson-de/silverstripe-payment-accounts
```

Then run:

```
/dev/build?flush=all
```


## Developer Documentation

### Data Model

```
PaymentAccount          (Holder, Note)
 ├── BankAccount         (+ BIC, IBAN, Name)
 ├── CreditCard          (+ CardType, Last4Digits, ExpiryDate)
 └── OnlineAccount       (+ Provider, AccountEmail)
```

All subclasses share the base `PaymentAccount` table. Silverstripe's ORM handles the JOIN automatically.

### Constants

| Class | Purpose |
|---|---|
| `Clesson\Silverstripe\PaymentAccount\Constants\CreditCardType` | Card type options (visa, mastercard, amex, diners, other) |
| `Clesson\Silverstripe\PaymentAccount\Constants\OnlineAccountProvider` | Provider options (paypal, stripe, klarna, apple_pay, google_pay, other) |

Use `CreditCardType::options()` or `OnlineAccountProvider::options()` to get a translated dropdown array. Use `::label($value)` to get the translated label for a stored value.

### Extension Points

The GridField config can be extended via the `updateConfig` hook:

```php
// In your extension
public function updateConfig(GridFieldConfig $config): void
{
    // add or remove components
}
```

Apply the extension to `Clesson\Silverstripe\PaymentAccount\Forms\GridFieldConfig_PaymentAccountsInContact` in your `_config/extensions.yml`.

### Database Tables

| Table | Contents |
|---|---|
| `BankAccount_PaymentAccount` | Base fields (Holder, Note, ClassName) + ContactID (via contacts extension) |
| `BankAccount_BankAccount` | Bank-specific fields (Name, BIC, IBAN) |
| `BankAccount_CreditCard` | Card-specific fields (CardType, Last4Digits, ExpiryDate) |
| `BankAccount_OnlineAccount` | Online account fields (Provider, AccountEmail) |

> Table names are prefixed with `BankAccount_` for historical reasons and will not change to avoid data migration.
