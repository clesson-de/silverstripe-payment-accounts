<?php

namespace Clesson\BankAccount\Forms;

use Clesson\BankAccount\Models\BankAccount;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\TextField;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;

class GridFieldConfig_BankAccountsInContact extends GridFieldConfig
{

    public function __construct($itemsPerPage = null, $showPagination = null, $showAdd = null)
    {
        parent::__construct();

        $this->addComponent(GridFieldButtonRow::create('after'));
        $this->addComponent($sort = GridFieldSortableHeader::create());

        $this->addComponent($editableColumns = GridFieldEditableColumns::create());
        $this->addComponent(GridFieldAddNewInlineButton::create('buttons-after-right'));
        $this->addComponent(GridFieldDeleteAction::create());

        $editableColumns->setDisplayFields([
            'Name' => [
                'title' => _t(BankAccount::class . '.Name', 'Name'),
                'callback' => function($record, $column, $grid) {
                    $field = TextField::create($column, $record->$column);
                    $field->setAttribute('placeholder', _t(BankAccount::class . '.Name', 'Name'));
                    return $field;
                }
            ],
            'BIC' => [
                'title' => _t(BankAccount::class . '.BIC', 'BIC'),
                'callback' => function($record, $column, $grid) {
                    $field = TextField::create($column, $record->$column);
                    $field->setAttribute('placeholder', _t(BankAccount::class . '.BIC', 'BIC'));
                    return $field;
                }
            ],
            'IBAN' => [
                'title' => _t(BankAccount::class . '.IBAN', 'IBAN'),
                'callback' => function($record, $column, $grid) {
                    $field = TextField::create($column, $record->$column);
                    $field->setAttribute('placeholder', _t(BankAccount::class . '.IBAN', 'IBAN'));
                    return $field;
                }
            ]
        ]);

        $this->addComponent(GridFieldDetailForm::create(null, $showPagination, $showAdd));

        $sort->setThrowExceptionOnBadDataType(false);
        // $filter->setThrowExceptionOnBadDataType(false);

        $this->extend('updateConfig');
    }

}
