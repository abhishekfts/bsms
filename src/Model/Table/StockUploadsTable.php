<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StockUploads Model
 *
 * @property \App\Model\Table\MaterialsTable&\Cake\ORM\Association\BelongsTo $Materials
 *
 * @method \App\Model\Entity\StockUpload newEmptyEntity()
 * @method \App\Model\Entity\StockUpload newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\StockUpload[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StockUpload get($primaryKey, $options = [])
 * @method \App\Model\Entity\StockUpload findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\StockUpload patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StockUpload[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\StockUpload|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StockUpload saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StockUpload[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StockUpload[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\StockUpload[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StockUpload[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class StockUploadsTable extends Table
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

        $this->setTable('stock_uploads');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('VendorFactories', [
            'foreignKey' => 'vendor_factory_id',
        ]);
        $this->belongsTo('Materials', [
            'foreignKey' => 'material_id',
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
            ->scalar('sap_vendor_code')
            ->maxLength('sap_vendor_code', 10)
            ->requirePresence('sap_vendor_code', 'create')
            ->notEmptyString('sap_vendor_code');

        $validator
            ->integer('vendor_factory_id')
            ->allowEmptyString('vendor_factory_id');

        $validator
            ->integer('material_id')
            ->notEmptyString('material_id');

        $validator
            ->decimal('opening_stock')
            ->requirePresence('opening_stock', 'create')
            ->notEmptyString('opening_stock');

        $validator
            ->decimal('current_stock')
            ->requirePresence('current_stock', 'create')
            ->notEmptyString('current_stock');

        $validator
            ->decimal('asn_stock')
            ->requirePresence('asn_stock', 'create')
            ->notEmptyString('asn_stock');

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
        $rules->add($rules->existsIn('material_id', 'Materials'), ['errorField' => 'material_id']);
        $rules->add($rules->existsIn('vendor_factory_id', 'VendorFactories'), ['errorField' => 'vendor_factory_id']);

        return $rules;
    }
}
