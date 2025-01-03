<?php

namespace Clesson\BankAccount\Extensions;

use Clesson\BankAccount\Forms\GridFieldConfig_BankAccountsInContact;
use Clesson\BankAccount\Models\BankAccount;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\Tab;
use SilverStripe\ORM\DataExtension;

class Contact extends DataExtension
{

    /**
     * @inheritdoc
     */
    private static $has_many = [
        'BankAccounts' => BankAccount::class
    ];

    /**
     * @inheritdoc
     */
    public function updateFieldLabels(&$labels)
    {
        $labels['BankAccounts'] = _t(__CLASS__ . '.BankAccounts', 'Bank accounts');
    }

    /**
     * @inheritdoc
     */
    public function updateMainTabSet(&$tabSet)
    {
        $bankAccountsField = GridField::create('BankAccounts', '', $this->owner->BankAccounts());
        $bankAccountsField->setConfig(new GridFieldConfig_BankAccountsInContact());
        $bankAccountsTab = new Tab(
            $this->owner->fieldLabel('BankAccounts'),
            $bankAccountsField
        );
        $tabSet->FieldList()->add($bankAccountsTab);
    }
}
