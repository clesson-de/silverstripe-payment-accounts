<?php

declare(strict_types=1);

namespace Clesson\Silverstripe\PaymentAccount\Models;

use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;

/**
 * Base class for all payment accounts belonging to a contact.
 * Concrete subclasses: BankAccount, CreditCard, OnlineAccount.
 * The has_one relation to Contact is provided by
 * Clesson\Silverstripe\Contacts\Extensions\PaymentAccountContactExtension.
 *
 * @property string $Holder
 * @property string $Note
 * @property-read string $TypeLabel
 * @property-read string $Summary
 *
 * @package Clesson\Silverstripe\PaymentAccount
 * @subpackage Models
 */
class PaymentAccount extends DataObject
{

    /**
     * @inheritdoc
     */
    private static string $table_name = 'BankAccount_PaymentAccount';

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
        'Holder' => 'Varchar(150)',
        'Note'   => 'Text',
    ];

    /**
     * @inheritdoc
     */
    public function fieldLabels($includerelations = true): array
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Holder']     = _t(__CLASS__ . '.HOLDER', 'Account holder');
        $labels['Note']       = _t(__CLASS__ . '.NOTE', 'Note');
        $labels['Created']    = _t('Clesson\Silverstripe\PaymentAccount\Common.CREATED', 'Created');
        $labels['LastEdited'] = _t('Clesson\Silverstripe\PaymentAccount\Common.LAST_EDITED', 'Last edited');
        $labels['ID']         = _t('Clesson\Silverstripe\PaymentAccount\Common.ID', 'ID');
        return $labels;
    }

    /**
     * Validates the record before writing.
     * Holder is required.
     *
     * @return ValidationResult
     */
    public function validate(): ValidationResult
    {
        $result = parent::validate();
        if (!$this->Holder) {
            $result->addError(_t(Form::class . '.FIELDISREQUIRED', '{name} is required', ['name' => $this->fieldLabel('Holder')]));
        }
        return $result;
    }

    /**
     * Sets default values before the record is first saved.
     */
    public function populateDefaults(): void
    {
        parent::populateDefaults();
    }

    /**
     * Returns the CMS edit form fields for this record.
     *
     * @return FieldList
     */
    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(['Holder', 'Note', 'ContactID']);

        /** @var TextField $holderField */
        $holderField = TextField::create('Holder', $this->fieldLabel('Holder'));

        /** @var TextareaField $noteField */
        $noteField = TextareaField::create('Note', $this->fieldLabel('Note'));

        $fields->addFieldsToTab('Root.Main', [
            $holderField,
            $noteField,
        ]);

        return $fields;
    }

    /**
     * Returns a translated type label for the account type (based on the singular class name).
     *
     * @return string
     */
    public function getTypeLabel(): string
    {
        return $this->i18n_singular_name();
    }

    /**
     * Returns a short plain-text summary of the account details.
     * Subclasses should override this to provide type-specific information.
     *
     * @return string
     */
    public function getSummary(): string
    {
        return $this->Holder;
    }

    /**
     * Only CMS users may view payment accounts.
     *
     * @param Member|null $member
     * @return bool
     */
    public function canView($member = null): bool
    {
        return Permission::check('CMS_ACCESS', 'any', $member);
    }

    /**
     * Only CMS users may create payment accounts.
     *
     * @param Member|null $member
     * @return bool
     */
    public function canCreate($member = null, $context = []): bool
    {
        return Permission::check('CMS_ACCESS', 'any', $member);
    }

    /**
     * Only CMS users may edit payment accounts.
     *
     * @param Member|null $member
     * @return bool
     */
    public function canEdit($member = null): bool
    {
        return Permission::check('CMS_ACCESS', 'any', $member);
    }

    /**
     * Only administrators may delete payment accounts.
     *
     * @param Member|null $member
     * @return bool
     */
    public function canDelete($member = null): bool
    {
        return Permission::check('ADMIN', 'any', $member);
    }

}

