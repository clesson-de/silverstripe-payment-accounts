<?php

namespace Clesson\BankAccount\Models;

use Clesson\Contacts\Models\Contact;
use Clesson\EmergencyCenter\Models\Activity;
use SilverStripe\ORM\DataObject;

class BankAccount extends DataObject
{

    /**
     * @inheritdoc
     */
    private static $table_name = 'BankAccount_BankAccount';

    /**
     * @inheritdoc
     */
    private static $default_sort = 'Name ASC';

    /**
     * @inheritdoc
     */
    private static $db = [
        'Name' => 'Varchar',
        'BIC' => 'Varchar',
        'IBAN' => 'Varchar',
    ];

    /**
     * @inheritdoc
     */
    private static $has_one = [
        'Contact' => Contact::class
    ];

    /**
     * @inheritdoc
     */
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Name'] = _t(__CLASS__ . '.Name', 'Name');
        $labels['BIC'] = _t(__CLASS__ . '.BIC', 'BIC');
        $labels['IBAN'] = _t(__CLASS__ . '.IBAN', 'IBAN');
        $labels['Contact'] = _t(__CLASS__ . '.Contact', 'Contact');
        return $labels;
    }

}
