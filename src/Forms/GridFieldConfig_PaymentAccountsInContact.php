<?php

declare(strict_types=1);

namespace Clesson\Silverstripe\PaymentAccount\Forms;

use Clesson\Silverstripe\PaymentAccount\Models\BankAccount;
use Clesson\Silverstripe\PaymentAccount\Models\CreditCard;
use Clesson\Silverstripe\PaymentAccount\Models\OnlineAccount;
use Clesson\Silverstripe\PaymentAccount\Models\PaymentAccount;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;

/**
 * GridField configuration for displaying PaymentAccount records (all subtypes) in a Contact.
 *
 * @package Clesson\Silverstripe\PaymentAccount
 * @subpackage Forms
 */
class GridFieldConfig_PaymentAccountsInContact extends GridFieldConfig
{

    /**
     * @param int|null  $itemsPerPage
     * @param bool|null $showPagination
     * @param bool|null $showAdd
     */
    public function __construct($itemsPerPage = null, $showPagination = null, $showAdd = null)
    {
        parent::__construct();

        $this->addComponent(GridFieldButtonRow::create('after'));
        $this->addComponent(GridFieldSortableHeader::create());

        /** @var GridFieldDataColumns $dataColumns */
        $dataColumns = GridFieldDataColumns::create();
        $dataColumns->setDisplayFields([
            'TypeLabel' => [
                'title'    => _t(__CLASS__ . '.TYPE', 'Type'),
                'callback' => function (PaymentAccount $record, string $column, $grid): DBField {
                    return DBField::create_field('Varchar', $record->TypeLabel);
                },
            ],
            'Holder' => [
                'title'    => _t(PaymentAccount::class . '.HOLDER', 'Account holder'),
                'callback' => function (PaymentAccount $record, string $column, $grid): DBField {
                    return DBField::create_field('Varchar', $record->Holder);
                },
            ],
            'Summary' => [
                'title'    => _t(__CLASS__ . '.SUMMARY', 'Details'),
                'callback' => function (PaymentAccount $record, string $column, $grid): DBField {
                    return DBField::create_field('Varchar', $record->Summary);
                },
            ],
        ]);
        $this->addComponent($dataColumns);

        /** @var GridFieldAddNewMultiClass $addButton */
        $addButton = GridFieldAddNewMultiClass::create('buttons-after-right');
        $addButton->setClasses([
            BankAccount::class,
            CreditCard::class,
            OnlineAccount::class,
        ]);
        $this->addComponent($addButton);

        $this->addComponent(GridFieldEditButton::create());
        $this->addComponent(GridFieldDeleteAction::create());
        $this->addComponent(GridFieldDetailForm::create(null, $showPagination, $showAdd));

        $this->extend('updateConfig');
    }

}

