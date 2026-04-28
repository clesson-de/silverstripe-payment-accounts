<?php

declare(strict_types=1);

namespace Clesson\Silverstripe\PaymentAccount\Models;

use Clesson\Silverstripe\PaymentAccount\Constants\OnlineAccountProvider;
use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;

/**
 * Represents an online payment account (e.g. PayPal, Stripe, Klarna) belonging to a contact.
 *
 * @property string $Provider
 * @property string $AccountEmail
 * @property-read string $Summary
 *
 * @package Clesson\Silverstripe\PaymentAccount
 * @subpackage Models
 */
class OnlineAccount extends PaymentAccount
{

    /**
     * @inheritdoc
     */
    private static string $table_name = 'BankAccount_OnlineAccount';

    /**
     * @inheritdoc
     */
    private static string $default_sort = 'Created DESC';

    /**
     * @inheritdoc
     */
    private static string $general_search_field = 'AccountEmail';

    /**
     * @inheritdoc
     */
    private static array $db = [
        'Provider'     => 'Varchar(100)',
        'AccountEmail' => 'Varchar(255)',
    ];

    /**
     * @inheritdoc
     */
    public function fieldLabels($includerelations = true): array
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Holder']       = _t(__CLASS__ . '.HOLDER', 'Account owner');
        $labels['Provider']     = _t(__CLASS__ . '.PROVIDER', 'Provider');
        $labels['AccountEmail'] = _t(__CLASS__ . '.ACCOUNT_EMAIL', 'Account e-mail');
        return $labels;
    }

    /**
     * Validates the record before writing.
     * Provider is required in addition to the base class validation.
     *
     * @return ValidationResult
     */
    public function validate(): ValidationResult
    {
        $result = parent::validate();
        if (!$this->Provider) {
            $result->addError(_t(Form::class . '.FIELDISREQUIRED', '{name} is required', ['name' => $this->fieldLabel('Provider')]));
        }
        return $result;
    }

    /**
     * Returns the CMS edit form fields for this record.
     *
     * @return FieldList
     */
    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(['Provider', 'AccountEmail']);

        /** @var DropdownField $providerField */
        $providerField = DropdownField::create('Provider', $this->fieldLabel('Provider'), OnlineAccountProvider::options());
        $providerField->setEmptyString('');

        /** @var EmailField $accountEmailField */
        $accountEmailField = EmailField::create('AccountEmail', $this->fieldLabel('AccountEmail'));

        $fields->addFieldsToTab('Root.Main', [$providerField, $accountEmailField]);

        return $fields;
    }

    /**
     * Returns a short summary of the online account (provider and account e-mail).
     *
     * @return string
     */
    public function getSummary(): string
    {
        $parts = [];

        if ($this->Provider) {
            $parts[] = OnlineAccountProvider::label($this->Provider);
        }

        if ($this->AccountEmail) {
            $parts[] = $this->AccountEmail;
        }

        return implode(' — ', $parts);
    }

}

