<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VendorTemps Model
 *
 * @property \App\Model\Table\CompanyCodesTable&\Cake\ORM\Association\BelongsTo $CompanyCodes
 * @property \App\Model\Table\PurchasingOrganizationsTable&\Cake\ORM\Association\BelongsTo $PurchasingOrganizations
 * @property \App\Model\Table\AccountGroupsTable&\Cake\ORM\Association\BelongsTo $AccountGroups
 * @property \App\Model\Table\SchemaGroupsTable&\Cake\ORM\Association\BelongsTo $SchemaGroups
 * @property \App\Model\Table\ReconciliationAccountsTable&\Cake\ORM\Association\BelongsTo $ReconciliationAccounts
 * @property \App\Model\Table\PaymentTermsTable&\Cake\ORM\Association\BelongsTo $PaymentTerms
 * @property \App\Model\Table\StatesTable&\Cake\ORM\Association\BelongsTo $States
 * @property \App\Model\Table\CountriesTable&\Cake\ORM\Association\BelongsTo $Countries
 * @property \App\Model\Table\RfqCommunicationsTable&\Cake\ORM\Association\HasMany $RfqCommunications
 * @property \App\Model\Table\RfqsTable&\Cake\ORM\Association\HasMany $Rfqs
 * @property \App\Model\Table\VendorBranchOfficesTable&\Cake\ORM\Association\HasMany $VendorBranchOffices
 * @property \App\Model\Table\VendorCommencementsTable&\Cake\ORM\Association\HasMany $VendorCommencements
 * @property \App\Model\Table\VendorFacilitiesTable&\Cake\ORM\Association\HasMany $VendorFacilities
 * @property \App\Model\Table\VendorFactoriesTable&\Cake\ORM\Association\HasMany $VendorFactories
 * @property \App\Model\Table\VendorIncometaxesTable&\Cake\ORM\Association\HasMany $VendorIncometaxes
 * @property \App\Model\Table\VendorOtherdetailsTable&\Cake\ORM\Association\HasMany $VendorOtherdetails
 * @property \App\Model\Table\VendorPartnerAddressTable&\Cake\ORM\Association\HasMany $VendorPartnerAddress
 * @property \App\Model\Table\VendorQuestionnairesTable&\Cake\ORM\Association\HasMany $VendorQuestionnaires
 * @property \App\Model\Table\VendorRegisteredOfficesTable&\Cake\ORM\Association\HasMany $VendorRegisteredOffices
 * @property \App\Model\Table\VendorReputedCustomersTable&\Cake\ORM\Association\HasMany $VendorReputedCustomers
 * @property \App\Model\Table\VendorSmallScalesTable&\Cake\ORM\Association\HasMany $VendorSmallScales
 * @property \App\Model\Table\VendorTempOtpsTable&\Cake\ORM\Association\HasMany $VendorTempOtps
 * @property \App\Model\Table\VendorTurnoversTable&\Cake\ORM\Association\HasMany $VendorTurnovers
 *
 * @method \App\Model\Entity\VendorTemp newEmptyEntity()
 * @method \App\Model\Entity\VendorTemp newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\VendorTemp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VendorTemp get($primaryKey, $options = [])
 * @method \App\Model\Entity\VendorTemp findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\VendorTemp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VendorTemp[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\VendorTemp|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VendorTemp saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VendorTemp[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\VendorTemp[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\VendorTemp[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\VendorTemp[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class VendorTempsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('vendor_temps');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('VendorStatus', [
            'foreignKey' => 'status',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('CompanyCodes', [
            'foreignKey' => 'company_code_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('PaymentTerms', [
            'foreignKey' => 'payment_terms',
            'joinType' => 'INNER',
        ]);

        
        $this->belongsTo('PurchasingOrganizations', [
            'foreignKey' => 'purchasing_organization_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('AccountGroups', [
            'foreignKey' => 'account_group_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('SchemaGroups', [
            'foreignKey' => 'schema_group_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ReconciliationAccounts', [
            'foreignKey' => 'reconciliation_account_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PaymentTerms', [
            'foreignKey' => 'payment_term_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('RfqCommunications', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('Rfqs', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('VendorBranchOffices', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('VendorCommencements', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('VendorFacilities', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('VendorFactories', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('VendorIncometaxes', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('VendorOtherdetails', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('VendorPartnerAddress', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('VendorQuestionnaires', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('VendorRegisteredOffices', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('VendorReputedCustomers', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('VendorSmallScales', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('VendorTempOtps', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('VendorTurnovers', [
            'foreignKey' => 'vendor_temp_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('company_code_id')
            ->notEmptyString('company_code_id');

        $validator
            ->integer('purchasing_organization_id')
            ->notEmptyString('purchasing_organization_id');

        $validator
            ->integer('account_group_id')
            ->notEmptyString('account_group_id');

        $validator
            ->integer('schema_group_id')
            ->notEmptyString('schema_group_id');

        $validator
            ->integer('reconciliation_account_id')
            ->notEmptyString('reconciliation_account_id');

        $validator
            ->integer('payment_term_id')
            ->notEmptyString('payment_term_id');

        $validator
            ->scalar('title')
            ->maxLength('title', 15)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('name')
            ->maxLength('name', 200)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('mobile')
            ->maxLength('mobile', 12)
            ->requirePresence('mobile', 'create')
            ->notEmptyString('mobile');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('sap_vendor_code')
            ->maxLength('sap_vendor_code', 10)
            ->allowEmptyString('sap_vendor_code');

        $validator
            ->scalar('order_currency')
            ->maxLength('order_currency', 10)
            ->notEmptyString('order_currency');

        $validator
            ->scalar('gst_no')
            ->maxLength('gst_no', 20)
            ->allowEmptyString('gst_no');

        $validator
            ->scalar('gst_file')
            ->maxLength('gst_file', 255)
            ->allowEmptyFile('gst_file');

        $validator
            ->scalar('pan_no')
            ->maxLength('pan_no', 20)
            ->allowEmptyString('pan_no');

        $validator
            ->scalar('pan_file')
            ->maxLength('pan_file', 255)
            ->allowEmptyFile('pan_file');

        $validator
            ->scalar('bank_file')
            ->maxLength('bank_file', 255)
            ->allowEmptyFile('bank_file');

        $validator
            ->scalar('cin_no')
            ->maxLength('cin_no', 25)
            ->allowEmptyString('cin_no');

        $validator
            ->scalar('tan_no')
            ->maxLength('tan_no', 25)
            ->allowEmptyString('tan_no');

        $validator
            ->dateTime('valid_date')
            ->requirePresence('valid_date', 'create')
            ->notEmptyDateTime('valid_date');

        $validator
            ->notEmptyString('status');

        $validator
            ->integer('buyer_id')
            ->requirePresence('buyer_id', 'create')
            ->notEmptyString('buyer_id');

        $validator
            ->scalar('remark')
            ->allowEmptyString('remark');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('address_2')
            ->maxLength('address_2', 100)
            ->allowEmptyString('address_2');

        $validator
            ->scalar('city')
            ->maxLength('city', 50)
            ->allowEmptyString('city');

        $validator
            ->integer('state_id')
            ->notEmptyString('state_id');

        $validator
            ->scalar('pincode')
            ->maxLength('pincode', 6)
            ->allowEmptyString('pincode');

        $validator
            ->integer('country_id')
            ->notEmptyString('country_id');

        $validator
            ->scalar('contact_person')
            ->maxLength('contact_person', 50)
            ->allowEmptyString('contact_person');

        $validator
            ->scalar('contact_email')
            ->maxLength('contact_email', 50)
            ->allowEmptyString('contact_email');

        $validator
            ->scalar('contact_mobile')
            ->maxLength('contact_mobile', 12)
            ->allowEmptyString('contact_mobile');

        $validator
            ->scalar('contact_department')
            ->maxLength('contact_department', 50)
            ->allowEmptyString('contact_department');

        $validator
            ->scalar('contact_designation')
            ->maxLength('contact_designation', 50)
            ->allowEmptyString('contact_designation');

        $validator
            ->scalar('bank_name')
            ->maxLength('bank_name', 250)
            ->allowEmptyString('bank_name');

        $validator
            ->scalar('bank_branch')
            ->maxLength('bank_branch', 250)
            ->allowEmptyString('bank_branch');

        $validator
            ->scalar('bank_number')
            ->maxLength('bank_number', 250)
            ->allowEmptyString('bank_number');

        $validator
            ->scalar('bank_ifsc')
            ->maxLength('bank_ifsc', 250)
            ->allowEmptyString('bank_ifsc');

        $validator
            ->scalar('bank_key')
            ->maxLength('bank_key', 250)
            ->allowEmptyString('bank_key');

        $validator
            ->scalar('bank_country')
            ->maxLength('bank_country', 250)
            ->allowEmptyString('bank_country');

        $validator
            ->scalar('bank_city')
            ->maxLength('bank_city', 250)
            ->allowEmptyString('bank_city');

        $validator
            ->scalar('bank_swift')
            ->maxLength('bank_swift', 250)
            ->allowEmptyString('bank_swift');

        $validator
            ->integer('update_flag')
            ->allowEmptyString('update_flag');

        $validator
            ->dateTime('added_date')
            ->notEmptyDateTime('added_date');

        $validator
            ->dateTime('updated_date')
            ->notEmptyDateTime('updated_date');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->existsIn('company_code_id', 'CompanyCodes'), ['errorField' => 'company_code_id']);
        $rules->add($rules->existsIn('purchasing_organization_id', 'PurchasingOrganizations'), ['errorField' => 'purchasing_organization_id']);
        $rules->add($rules->existsIn('account_group_id', 'AccountGroups'), ['errorField' => 'account_group_id']);
        $rules->add($rules->existsIn('schema_group_id', 'SchemaGroups'), ['errorField' => 'schema_group_id']);
        $rules->add($rules->existsIn('reconciliation_account_id', 'ReconciliationAccounts'), ['errorField' => 'reconciliation_account_id']);
        $rules->add($rules->existsIn('payment_term_id', 'PaymentTerms'), ['errorField' => 'payment_term_id']);
        $rules->add($rules->existsIn('state_id', 'States'), ['errorField' => 'state_id']);
        $rules->add($rules->existsIn('country_id', 'Countries'), ['errorField' => 'country_id']);

        return $rules;
    }
}
