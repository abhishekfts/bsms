<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VendorRegisteredOffices Model
 *
 * @property \App\Model\Table\VendorTempsTable&\Cake\ORM\Association\BelongsTo $VendorTemps
 *
 * @method \App\Model\Entity\VendorRegisteredOffice newEmptyEntity()
 * @method \App\Model\Entity\VendorRegisteredOffice newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\VendorRegisteredOffice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VendorRegisteredOffice get($primaryKey, $options = [])
 * @method \App\Model\Entity\VendorRegisteredOffice findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\VendorRegisteredOffice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VendorRegisteredOffice[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\VendorRegisteredOffice|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VendorRegisteredOffice saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VendorRegisteredOffice[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\VendorRegisteredOffice[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\VendorRegisteredOffice[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\VendorRegisteredOffice[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class VendorRegisteredOfficesTable extends Table
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

        $this->setTable('vendor_registered_offices');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('VendorTemps', [
            'foreignKey' => 'vendor_temp_id',
            'joinType' => 'INNER',
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
            ->integer('vendor_temp_id')
            ->notEmptyString('vendor_temp_id');

        $validator
            ->scalar('address')
            ->maxLength('address', 250)
            ->allowEmptyString('address');

        $validator
            ->scalar('address_2')
            ->maxLength('address_2', 250)
            ->allowEmptyString('address_2');

        $validator
            ->scalar('pincode')
            ->maxLength('pincode', 6)
            ->allowEmptyString('pincode');

        $validator
            ->scalar('city')
            ->maxLength('city', 200)
            ->allowEmptyString('city');

        $validator
            ->scalar('country')
            ->maxLength('country', 200)
            ->allowEmptyString('country');

        $validator
            ->scalar('state')
            ->maxLength('state', 200)
            ->allowEmptyString('state');

        $validator
            ->scalar('telephone')
            ->maxLength('telephone', 15)
            ->allowEmptyString('telephone');

        $validator
            ->dateTime('added_date')
            ->allowEmptyDateTime('added_date');

        $validator
            ->dateTime('updated_date')
            ->allowEmptyDateTime('updated_date');

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
        $rules->add($rules->existsIn('vendor_temp_id', 'VendorTemps'), ['errorField' => 'vendor_temp_id']);

        return $rules;
    }
}
