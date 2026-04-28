<?php

declare(strict_types=1);

namespace Clesson\Silverstripe\PaymentAccount\Models;

use Clesson\Silverstripe\PaymentAccount\Constants\CreditCardType;
use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\TextField;

/**
 * Represents a credit card belonging to a contact.
 *
 * @property string $CardType
 * @property string $Last4Digits
 * @property string $ExpiryDate
 * @property-read string $Summary
 *
 * @package Clesson\Silverstripe\PaymentAccount
 * @subpackage Models
 */
class CreditCard extends PaymentAccount
{

    /**
     * @inheritdoc
     */
    private static string $table_name = 'BankAccount_CreditCard';

    /**
     * @inheritdoc
     */
    private static string $default_sort = 'Created DESC';

    /**
     * @inheritdoc
     */
    private static string $general_search_field = 'Holder';

    /**
     * @inheritdoc
     */
    private static array $db = [
        'CardType'    => 'Varchar(50)',
        'Last4Digits' => 'Varchar(4)',
        'ExpiryDate'  => 'Date',
    ];

    /**
     * @inheritdoc
     */
    public function fieldLabels($includerelations = true): array
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Holder']      = _t(__CLASS__ . '.HOLDER', 'Cardholder');
        $labels['CardType']    = _t(__CLASS__ . '.CARD_TYPE', 'Card type');
        $labels['Last4Digits'] = _t(__CLASS__ . '.LAST_4_DIGITS', 'Last 4 digits');
        $labels['ExpiryDate']  = _t(__CLASS__ . '.EXPIRY_DATE', 'Expiry date');
        return $labels;
    }

    /**
     * Validates the record before writing.
     * CardType is required in addition to the base class validation.
     *
     * @return ValidationResult
     */
    public function validate(): ValidationResult
    {
        $result = parent::validate();
        if (!$this->CardType) {
            $result->addError(_t(Form::class . '.FIELDISREQUIRED', '{name} is required', ['name' => $this->fieldLabel('CardType')]));
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

        $fields->removeByName(['CardType', 'Last4Digits', 'ExpiryDate']);

        /** @var DropdownField $cardTypeField */
        $cardTypeField = DropdownField::create('CardType', $this->fieldLabel('CardType'), CreditCardType::options());
        $cardTypeField->setEmptyString('');

        /** @var TextField $last4DigitsField */
        $last4DigitsField = TextField::create('Last4Digits', $this->fieldLabel('Last4Digits'));

        /** @var DateField $expiryDateField */
        $expiryDateField = DateField::create('ExpiryDate', $this->fieldLabel('ExpiryDate'));

        $fields->addFieldsToTab('Root.Main', [$cardTypeField, $last4DigitsField, $expiryDateField]);

        return $fields;
    }

    /**
     * Returns a short summary of the credit card (type, last 4 digits, expiry date).
     *
     * @return string
     */
    public function getSummary(): string
    {
        $parts = [];

        if ($this->CardType) {
            $parts[] = CreditCardType::label($this->CardType);
        }

        if ($this->Last4Digits) {
            $parts[] = '**** ' . $this->Last4Digits;
        }

        if ($this->ExpiryDate) {
            $parts[] = date('m/Y', strtotime($this->ExpiryDate));
        }

        return implode(' — ', $parts);
    }

}

