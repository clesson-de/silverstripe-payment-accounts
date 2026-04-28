<?php

declare(strict_types=1);

namespace Clesson\Silverstripe\PaymentAccount\Models;

use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\TextField;

/**
 * Represents a bank account belonging to a contact.
 *
 * @property string $Name
 * @property string $BIC
 * @property string $IBAN
 * @property-read string $Summary
 *
 * @package Clesson\Silverstripe\PaymentAccount
 * @subpackage Models
 */
class BankAccount extends PaymentAccount
{

    /**
     * @inheritdoc
     */
    private static string $table_name = 'BankAccount_BankAccount';

    /**
     * @inheritdoc
     */
    private static string $default_sort = 'Name ASC';

    /**
     * @inheritdoc
     */
    private static string $general_search_field = 'Name';

    /**
     * @inheritdoc
     */
    private static array $db = [
        'Name' => 'Varchar(100)',
        'BIC'  => 'Varchar(11)',
        'IBAN' => 'Varchar(34)',
    ];


    /**
     * @inheritdoc
     */
    public function fieldLabels($includerelations = true): array
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Holder'] = _t(__CLASS__ . '.HOLDER', 'Bank account holder');
        $labels['Name']   = _t(__CLASS__ . '.NAME', 'Bank');
        $labels['BIC']    = _t(__CLASS__ . '.BIC', 'BIC');
        $labels['IBAN']   = _t(__CLASS__ . '.IBAN', 'IBAN');
        return $labels;
    }

    /**
     * Validates the record before writing.
     * Name (bank name) is required in addition to the base class validation.
     *
     * @return ValidationResult
     */
    public function validate(): ValidationResult
    {
        $result = parent::validate();
        if (!$this->Name) {
            $result->addError(_t(Form::class . '.FIELDISREQUIRED', '{name} is required', ['name' => $this->fieldLabel('Name')]));
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

        $fields->removeByName(['Name', 'BIC', 'IBAN']);

        /** @var TextField $nameField */
        $nameField = TextField::create('Name', $this->fieldLabel('Name'));

        /** @var TextField $bicField */
        $bicField = TextField::create('BIC', $this->fieldLabel('BIC'));

        /** @var TextField $ibanField */
        $ibanField = TextField::create('IBAN', $this->fieldLabel('IBAN'));

        $fields->addFieldsToTab('Root.Main', [$nameField, $bicField, $ibanField]);

        return $fields;
    }

    /**
     * Returns a short summary of the bank account (bank name and IBAN).
     *
     * @return string
     */
    public function getSummary(): string
    {
        $parts = array_filter([$this->Name, $this->IBAN]);
        return implode(' — ', $parts);
    }

}
