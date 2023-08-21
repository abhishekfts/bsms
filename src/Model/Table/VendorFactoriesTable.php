<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VendorFactories Model
 *
 * @property \App\Model\Table\VendorTempsTable&\Cake\ORM\Association\BelongsTo $VendorTemps
 * @property \App\Model\Table\VendorCommencementsTable&\Cake\ORM\Association\HasMany $VendorCommencements
 *
 * @method \App\Model\Entity\VendorFactory newEmptyEntity()
 * @method \App\Model\Entity\VendorFactory newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\VendorFactory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VendorFactory get($primaryKey, $options = [])
 * @method \App\Model\Entity\VendorFactory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\VendorFactory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VendorFactory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\VendorFactory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VendorFactory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VendorFactory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\VendorFactory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\VendorFactory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\VendorFactory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class VendorFactoriesTable extends Table
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

        $this->setTable('vendor_factories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('VendorTemps', [
            'foreignKey' => 'vendor_temp_id',
        ]);
        $this->hasMany('StockUploads', [
            'foreignKey' => 'vendor_factory_id',
        ]);
        $this->hasMany('VendorCommencements', [
            'foreignKey' => 'vendor_factory_id',
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
            ->allowEmptyString('vendor_temp_id');

        $validator
            ->scalar('factory_code')
            ->maxLength('factory_code', 45)
            ->requirePresence('factory_code', 'create')
            ->notEmptyString('factory_code');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('address_2')
            ->maxLength('address_2', 100)
            ->allowEmptyString('address_2');

        $validator
            ->scalar('pincode')
            ->maxLength('pincode', 6)
            ->allowEmptyString('pincode');

        $validator
            ->scalar('city')
            ->maxLength('city', 50)
            ->allowEmptyString('city');

        $validator
            ->integer('state')
            ->requirePresence('state', 'create')
            ->notEmptyString('state');

        $validator
            ->integer('country')
            ->requirePresence('country', 'create')
            ->notEmptyString('country');

        $validator
            ->scalar('installed_capacity')
            ->maxLength('installed_capacity', 45)
            ->allowEmptyString('installed_capacity');

        $validator
            ->scalar('installed_capacity_file')
            ->maxLength('installed_capacity_file', 250)
            ->allowEmptyFile('installed_capacity_file');

        $validator
            ->scalar('machinery_available')
            ->maxLength('machinery_available', 45)
            ->allowEmptyString('machinery_available');

        $validator
            ->scalar('machinery_available_file')
            ->maxLength('machinery_available_file', 250)
            ->allowEmptyFile('machinery_available_file');

        $validator
            ->scalar('power_available')
            ->maxLength('power_available', 45)
            ->allowEmptyString('power_available');

        $validator
            ->scalar('power_available_file')
            ->maxLength('power_available_file', 250)
            ->allowEmptyFile('power_available_file');

        $validator
            ->scalar('raw_material')
            ->maxLength('raw_material', 45)
            ->allowEmptyString('raw_material');

        $validator
            ->scalar('raw_material_file')
            ->maxLength('raw_material_file', 250)
            ->allowEmptyFile('raw_material_file');

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
