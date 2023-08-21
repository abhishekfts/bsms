<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LineMasters Model
 *
 * @property \App\Model\Table\VendorFactoriesTable&\Cake\ORM\Association\BelongsTo $VendorFactories
 * @property \App\Model\Table\ProductionLinesTable&\Cake\ORM\Association\HasMany $ProductionLines
 *
 * @method \App\Model\Entity\LineMaster newEmptyEntity()
 * @method \App\Model\Entity\LineMaster newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\LineMaster[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LineMaster get($primaryKey, $options = [])
 * @method \App\Model\Entity\LineMaster findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\LineMaster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LineMaster[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LineMaster|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LineMaster saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LineMaster[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LineMaster[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\LineMaster[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LineMaster[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class LineMastersTable extends Table
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

        $this->setTable('line_masters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('VendorFactories', [
            'foreignKey' => 'vendor_factory_id',
        ]);
        $this->hasMany('ProductionLines', [
            'foreignKey' => 'line_master_id',
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
            ->scalar('sap_vendor_code')
            ->maxLength('sap_vendor_code', 10)
            ->requirePresence('sap_vendor_code', 'create')
            ->notEmptyString('sap_vendor_code');

        $validator
            ->integer('vendor_factory_id')
            ->allowEmptyString('vendor_factory_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 20)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->decimal('capacity')
            ->requirePresence('capacity', 'create')
            ->notEmptyString('capacity');

        $validator
            ->scalar('uom')
            ->maxLength('uom', 3)
            ->requirePresence('uom', 'create')
            ->notEmptyString('uom');

        $validator
            ->boolean('status')
            ->notEmptyString('status');

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
        $rules->add($rules->isUnique(['sap_vendor_code', 'vendor_factory_id', 'name'], ['allowMultipleNulls' => true]), ['errorField' => 'sap_vendor_code']);
        $rules->add($rules->existsIn('vendor_factory_id', 'VendorFactories'), ['errorField' => 'vendor_factory_id']);

        return $rules;
    }
}
